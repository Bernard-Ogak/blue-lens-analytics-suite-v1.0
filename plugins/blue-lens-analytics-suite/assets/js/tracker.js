/**
 * Blue-Lens Analytics — first-party event tracker.
 *
 * No cookies, no third-party requests. The session id lives in
 * sessionStorage (cleared when the browser tab closes) purely to
 * de-duplicate a single visit across multiple pageviews/events — it is
 * never combined with anything that identifies a person, and the
 * server additionally only ever stores a one-way, daily-rotating hash
 * of IP+user-agent (see BlueLens_Analytics_DB::visitor_hash()), not the
 * IP itself.
 */
( function () {
	'use strict';

	if ( typeof blueLensAnalytics === 'undefined' ) {
		return;
	}

	function getSessionId() {
		try {
			var id = sessionStorage.getItem( 'blueLensAnalyticsSession' );
			if ( ! id ) {
				id = 'pa_' + Date.now().toString( 36 ) + '_' + Math.random().toString( 36 ).slice( 2 );
				sessionStorage.setItem( 'blueLensAnalyticsSession', id );
			}
			return id;
		} catch ( e ) {
			return '';
		}
	}

	function utmParam( name ) {
		try {
			return new URLSearchParams( window.location.search ).get( name ) || '';
		} catch ( e ) {
			return '';
		}
	}

	/**
	 * New vs. returning is the one signal that has to survive across
	 * sessions, so it lives in localStorage rather than the
	 * sessionStorage used for the session id above. It stores nothing
	 * beyond "have we seen this browser before" — no identifier that
	 * could be linked back to a person.
	 */
	function isReturningVisitor() {
		if ( ! blueLensAnalytics.settings || ! blueLensAnalytics.settings.returning_visitor_detection ) {
			return false;
		}
		try {
			var seen = localStorage.getItem( 'blueLensAnalyticsFirstSeen' );
			if ( seen ) {
				return true;
			}
			localStorage.setItem( 'blueLensAnalyticsFirstSeen', Date.now().toString() );
			return false;
		} catch ( e ) {
			return false;
		}
	}

	function send( eventType, eventLabel, extra ) {
		if ( blueLensAnalytics.settings && false === blueLensAnalytics.settings[ eventType ] ) {
			return;
		}

		var payload = {
			event_type:   eventType,
			event_label:  eventLabel || '',
			url:          window.location.href,
			post_id:      blueLensAnalytics.postId || 0,
			session_id:   getSessionId(),
			referrer:     document.referrer || '',
			utm_source:   utmParam( 'utm_source' ),
			utm_medium:   utmParam( 'utm_medium' ),
			utm_campaign: utmParam( 'utm_campaign' ),
		};
		if ( extra ) {
			for ( var key in extra ) {
				if ( Object.prototype.hasOwnProperty.call( extra, key ) ) {
					payload[ key ] = extra[ key ];
				}
			}
		}

		var body = JSON.stringify( payload );

		// sendBeacon survives the page unloading (important for outbound
		// link clicks — WhatsApp/tel/mailto navigate away immediately).
		if ( navigator.sendBeacon ) {
			var blob = new Blob( [ body ], { type: 'application/json' } );
			navigator.sendBeacon( blueLensAnalytics.restUrl, blob );
			return;
		}

		fetch( blueLensAnalytics.restUrl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': blueLensAnalytics.nonce },
			body: body,
			keepalive: true,
		} ).catch( function () {} );
	}

	// Pageview — fired once per load. is_returning is resolved here (its
	// localStorage side effect should only run once per load) and
	// carried on the pageview row, which is what the New vs. Returning
	// widget groups by.
	send( 'pageview', '', { is_returning: isReturningVisitor() ? 1 : 0 } );

	// Image views — content images scrolled into view, once per image
	// per page load. Powers the "Most Viewed Images" widget.
	if ( blueLensAnalytics.settings && blueLensAnalytics.settings.image_view && 'IntersectionObserver' in window ) {
		var seenImages = new Set();
		var imageObserver = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( ! entry.isIntersecting || seenImages.has( entry.target ) ) {
					return;
				}
				seenImages.add( entry.target );
				imageObserver.unobserve( entry.target );
				var img = entry.target;
				var label = ( img.getAttribute( 'alt' ) || '' ).trim();
				if ( ! label ) {
					label = ( img.getAttribute( 'src' ) || '' ).split( '/' ).pop().split( '?' )[ 0 ];
				}
				send( 'image_view', label.slice( 0, 100 ) );
			} );
		}, { threshold: 0.5 } );

		document.querySelectorAll( 'article img, .entry-content img, .wp-block-image img' ).forEach( function ( img ) {
			imageObserver.observe( img );
		} );
	}

	// Time on page — active time only (paused while the tab is hidden),
	// flushed once when the page is actually being left. pagehide fires
	// reliably on both desktop navigation and mobile tab-switch/close,
	// unlike beforeunload/unload.
	if ( blueLensAnalytics.settings && blueLensAnalytics.settings.time_on_page ) {
		var activeMs = 0;
		var segmentStart = document.visibilityState === 'visible' ? Date.now() : null;

		document.addEventListener( 'visibilitychange', function () {
			if ( document.visibilityState === 'visible' ) {
				segmentStart = Date.now();
			} else if ( segmentStart ) {
				activeMs += Date.now() - segmentStart;
				segmentStart = null;
			}
		} );

		window.addEventListener( 'pagehide', function () {
			if ( segmentStart ) {
				activeMs += Date.now() - segmentStart;
				segmentStart = null;
			}
			var seconds = Math.round( activeMs / 1000 );
			if ( seconds > 0 ) {
				send( 'time_on_page', '', { value: seconds } );
			}
		} );
	}

	// Scroll depth — 25/50/75/100% milestones, each fired at most once
	// per page load. rAF-throttled so this costs nothing on the far more
	// frequent scroll events than it would firing on every one.
	if ( blueLensAnalytics.settings && blueLensAnalytics.settings.scroll_depth ) {
		var milestones = [ 25, 50, 75, 100 ];
		var firedMilestones = {};
		var scrollTicking = false;

		function checkScrollDepth() {
			scrollTicking = false;
			var doc = document.documentElement;
			var scrollable = ( doc.scrollHeight - doc.clientHeight ) || 1;
			var pct = Math.min( 100, Math.round( ( ( window.pageYOffset || doc.scrollTop ) / scrollable ) * 100 ) );
			milestones.forEach( function ( m ) {
				if ( pct >= m && ! firedMilestones[ m ] ) {
					firedMilestones[ m ] = true;
					send( 'scroll_depth', m + '%', { value: m } );
				}
			} );
		}

		window.addEventListener( 'scroll', function () {
			if ( ! scrollTicking ) {
				scrollTicking = true;
				window.requestAnimationFrame( checkScrollDepth );
			}
		}, { passive: true } );
	}

	// Outbound intent + CTA clicks, delegated from the document so
	// dynamically-inserted content (AJAX-loaded gallery cards, etc.)
	// is covered without extra wiring.
	document.addEventListener( 'click', function ( e ) {
		var link = e.target.closest( 'a[href]' );
		if ( link ) {
			var href = link.getAttribute( 'href' ) || '';
			if ( href.indexOf( 'wa.me' ) !== -1 || href.indexOf( 'api.whatsapp.com' ) !== -1 ) {
				send( 'whatsapp_click', link.textContent.trim().slice( 0, 100 ) );
			} else if ( href.indexOf( 'tel:' ) === 0 ) {
				send( 'phone_click', href.replace( 'tel:', '' ) );
			} else if ( href.indexOf( 'mailto:' ) === 0 ) {
				send( 'email_click', href.replace( 'mailto:', '' ) );
			}
		}

		var cta = e.target.closest( '[data-bluelens-track]' );
		if ( cta ) {
			send( 'cta_click', cta.getAttribute( 'data-bluelens-track' ) );
		}
	}, { passive: true } );
} )();
