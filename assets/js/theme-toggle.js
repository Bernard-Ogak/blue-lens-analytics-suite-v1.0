/**
 * Dark/light toggle for this plugin's own admin screens. The initial
 * theme (localStorage, falling back to prefers-color-scheme) is
 * applied synchronously by an inline script printed right before the
 * .bla-brand-header markup (see class-admin-menu.php::brand_header())
 * so there's no flash of the wrong theme — this file only has to
 * handle the click.
 */
( function () {
	'use strict';

	document.addEventListener( 'click', function ( e ) {
		var btn = e.target.closest( '.bla-theme-toggle' );
		if ( ! btn ) {
			return;
		}
		var wrap = btn.closest( '.wrap' );
		if ( ! wrap ) {
			return;
		}
		var isDark = wrap.classList.toggle( 'bla-theme-dark' );
		btn.setAttribute( 'aria-checked', isDark ? 'true' : 'false' );
		try {
			localStorage.setItem( 'blueLensAnalyticsTheme', isDark ? 'dark' : 'light' );
		} catch ( err ) {}
	} );

	document.addEventListener( 'DOMContentLoaded', function () {
		document.querySelectorAll( '.bla-theme-toggle' ).forEach( function ( btn ) {
			var wrap = btn.closest( '.wrap' );
			btn.setAttribute( 'aria-checked', wrap && wrap.classList.contains( 'bla-theme-dark' ) ? 'true' : 'false' );
		} );
	} );
} )();
