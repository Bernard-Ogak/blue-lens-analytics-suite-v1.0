/**
 * Blue-Lens Analytics — customizable widget dashboard.
 *
 * Server (class-dashboard.php) renders an empty shell per saved widget
 * (id/metric/chart-type only). Everything else — header, chart,
 * table/list, add/remove/reorder, layout persistence — happens here,
 * so there is exactly one code path for building a widget card whether
 * it was on the page at load or just added from the modal.
 */
( function () {
	'use strict';

	if ( typeof blueLensAnalyticsDashboard === 'undefined' ) {
		return;
	}

	var cfg = blueLensAnalyticsDashboard;
	var catalog = cfg.catalog || {};
	var grid = document.getElementById( 'pa-widget-grid' );
	if ( ! grid ) {
		return;
	}
	var wrapEl = grid.closest( '.wrap' );

	// Chart.js draws to canvas, so it won't pick up the CSS dark-mode
	// class on its own — every place that colors a chart reads the
	// palette through here so a theme toggle (see boot section below)
	// can force a redraw with the other theme's chrome colors.
	function currentPalette() {
		return ( wrapEl && wrapEl.classList.contains( 'bla-theme-dark' ) ) ? cfg.paletteDark : cfg.palette;
	}

	var chartInstances = {}; // widget id -> Chart.js instance
	var dataCache = {}; // widget id -> last-fetched payload
	var saveTimer = null;

	/* -----------------------------------------------------------
	 * Layout persistence
	 * --------------------------------------------------------- */

	function currentLayout() {
		return Array.prototype.map.call( grid.querySelectorAll( '.pa-widget-card' ), function ( card ) {
			var select = card.querySelector( '.pa-widget-card__type-select' );
			return {
				id: card.getAttribute( 'data-id' ),
				metric: card.getAttribute( 'data-metric' ),
				chart_type: select ? select.value : card.getAttribute( 'data-chart-type' ),
			};
		} );
	}

	function scheduleSaveLayout() {
		clearTimeout( saveTimer );
		saveTimer = setTimeout( function () {
			var body = new URLSearchParams();
			body.set( 'action', 'bluelens_analytics_save_layout' );
			body.set( 'nonce', cfg.nonce );
			body.set( 'layout', JSON.stringify( currentLayout() ) );
			fetch( cfg.ajaxUrl, { method: 'POST', body: body, credentials: 'same-origin' } ).catch( function () {} );
		}, 500 );
	}

	/* -----------------------------------------------------------
	 * Data fetch
	 * --------------------------------------------------------- */

	function fetchWidgetData( metric ) {
		var body = new URLSearchParams();
		body.set( 'action', 'bluelens_analytics_widget_data' );
		body.set( 'nonce', cfg.nonce );
		body.set( 'metric', metric );
		body.set( 'range', cfg.range );
		return fetch( cfg.ajaxUrl, { method: 'POST', body: body, credentials: 'same-origin' } )
			.then( function ( res ) { return res.json(); } )
			.then( function ( json ) { return json && json.success ? json.data : null; } )
			.catch( function () { return null; } );
	}

	/* -----------------------------------------------------------
	 * Color helpers (validated palette — see the dataviz skill)
	 * --------------------------------------------------------- */

	function categoricalColor( i ) {
		var p = currentPalette();
		return p.categorical[ i % p.categorical.length ];
	}

	function ordinalColor( i, total ) {
		var ramp = currentPalette().sequential;
		var idx = Math.round( ( i / Math.max( 1, total - 1 ) ) * ( ramp.length - 1 ) );
		return ramp[ idx ];
	}

	/* -----------------------------------------------------------
	 * Card chrome (header) — identical for server-rendered and
	 * freshly-added cards.
	 * --------------------------------------------------------- */

	function buildHeader( card, metric, chartType ) {
		var def = catalog[ metric ];
		if ( ! def ) {
			return;
		}

		var header = document.createElement( 'div' );
		header.className = 'pa-widget-card__header';

		var icon = document.createElement( 'span' );
		icon.className = 'pa-widget-card__icon dashicons ' + def.icon;
		icon.setAttribute( 'aria-hidden', 'true' );
		header.appendChild( icon );

		var title = document.createElement( 'h3' );
		title.className = 'pa-widget-card__title';
		title.textContent = def.label;
		header.appendChild( title );

		if ( def.supports.length > 1 ) {
			var select = document.createElement( 'select' );
			select.className = 'pa-widget-card__type-select';
			select.setAttribute( 'aria-label', 'Chart type' );
			def.supports.forEach( function ( type ) {
				var opt = document.createElement( 'option' );
				opt.value = type;
				opt.textContent = cfg.chartTypeLabels[ type ] || type;
				if ( type === chartType ) {
					opt.selected = true;
				}
				select.appendChild( opt );
			} );
			select.addEventListener( 'change', function () {
				card.setAttribute( 'data-chart-type', select.value );
				renderBody( card, metric, select.value, dataCache[ card.getAttribute( 'data-id' ) ] );
				scheduleSaveLayout();
			} );
			header.appendChild( select );
		}

		var remove = document.createElement( 'button' );
		remove.type = 'button';
		remove.className = 'pa-widget-card__remove';
		remove.setAttribute( 'aria-label', 'Remove widget' );
		remove.innerHTML = '&times;';
		remove.addEventListener( 'click', function () {
			delete chartInstances[ card.getAttribute( 'data-id' ) ];
			delete dataCache[ card.getAttribute( 'data-id' ) ];
			card.remove();
			scheduleSaveLayout();
		} );
		header.appendChild( remove );

		card.appendChild( header );
	}

	/* -----------------------------------------------------------
	 * Body rendering — chart, KPI, or table/list, from one payload
	 * --------------------------------------------------------- */

	function renderBody( card, metric, chartType, data ) {
		var id = card.getAttribute( 'data-id' );
		var body = card.querySelector( '.pa-widget-card__body' );
		if ( ! body ) {
			body = document.createElement( 'div' );
			body.className = 'pa-widget-card__body';
			card.appendChild( body );
		}

		if ( chartInstances[ id ] ) {
			chartInstances[ id ].destroy();
			delete chartInstances[ id ];
		}
		body.innerHTML = '';

		if ( ! data ) {
			body.innerHTML = '<p class="pa-empty">Couldn’t load this widget.</p>';
			return;
		}

		if ( 'kpi' === chartType ) {
			renderKpi( body, data );
			return;
		}
		if ( 'table' === chartType || 'list' === chartType ) {
			renderTable( body, data, 'list' === chartType );
			return;
		}
		if ( ! data.labels || ! data.labels.length || ! data.series || ! data.series.some( function ( n ) { return n > 0; } ) ) {
			body.innerHTML = '<p class="pa-empty">No data recorded yet for this range.</p>';
			return;
		}
		renderChart( body, id, chartType, data );
	}

	function renderKpi( body, data ) {
		var wrap = document.createElement( 'div' );
		wrap.className = 'pa-widget-kpi';
		wrap.innerHTML =
			'<p class="pa-widget-kpi__value">' + escapeHtml( data.value || '—' ) + '</p>' +
			'<p class="pa-widget-kpi__label">' + escapeHtml( data.value_label || '' ) + '</p>' +
			( data.value_sub ? '<p class="pa-widget-kpi__sub">' + escapeHtml( data.value_sub ) + '</p>' : '' );
		body.appendChild( wrap );
	}

	function renderTable( body, data, asList ) {
		if ( ! data.rows || ! data.rows.length ) {
			body.innerHTML = '<p class="pa-empty">No data recorded yet for this range.</p>';
			return;
		}
		if ( data.note ) {
			var note = document.createElement( 'p' );
			note.className = 'pa-widget-note';
			note.textContent = data.note;
			body.appendChild( note );
		}

		if ( asList ) {
			var ol = document.createElement( 'ol' );
			ol.className = 'pa-widget-list';
			data.rows.forEach( function ( row ) {
				var li = document.createElement( 'li' );
				var nameHtml = row.url
					? '<a href="' + escapeAttr( row.url ) + '" target="_blank" rel="noopener noreferrer">' + escapeHtml( row.name ) + '</a>'
					: escapeHtml( row.name );
				li.innerHTML = '<span class="pa-widget-list__name">' + nameHtml + '</span><span class="pa-widget-list__count">' + escapeHtml( row.count ) + '</span>';
				ol.appendChild( li );
			} );
			body.appendChild( ol );
			return;
		}

		var table = document.createElement( 'table' );
		table.className = 'widefat striped pa-widget-table';
		var thead = document.createElement( 'thead' );
		var headRow = document.createElement( 'tr' );
		( data.columns || [] ).forEach( function ( col ) {
			var th = document.createElement( 'th' );
			th.textContent = col.label;
			headRow.appendChild( th );
		} );
		thead.appendChild( headRow );
		table.appendChild( thead );

		var tbody = document.createElement( 'tbody' );
		data.rows.forEach( function ( row ) {
			var tr = document.createElement( 'tr' );
			( data.columns || [] ).forEach( function ( col ) {
				var td = document.createElement( 'td' );
				if ( 'name' === col.key && row.url ) {
					var a = document.createElement( 'a' );
					a.href = row.url;
					a.target = '_blank';
					a.rel = 'noopener noreferrer';
					a.textContent = row[ col.key ];
					td.appendChild( a );
				} else {
					td.textContent = row[ col.key ];
				}
				tr.appendChild( td );
			} );
			tbody.appendChild( tr );
		} );
		table.appendChild( tbody );
		body.appendChild( table );
	}

	function renderChart( body, id, chartType, data ) {
		var palette = currentPalette();
		var canvasWrap = document.createElement( 'div' );
		canvasWrap.className = 'pa-widget-canvas';
		var canvas = document.createElement( 'canvas' );
		canvasWrap.appendChild( canvas );
		body.appendChild( canvasWrap );

		var kind = data.series_kind;
		var isPie = 'pie' === chartType || 'doughnut' === chartType;

		var backgroundColor;
		if ( isPie || ( 'bar' === chartType && 'breakdown' === kind ) ) {
			backgroundColor = data.labels.map( function ( _, i ) { return categoricalColor( i ); } );
		} else if ( 'bar' === chartType && 'ordinal' === kind ) {
			backgroundColor = data.labels.map( function ( _, i ) { return ordinalColor( i, data.labels.length ); } );
		} else {
			backgroundColor = 'rgba(42, 120, 214, 0.18)';
		}

		var chartData = {
			labels: data.labels,
			datasets: [ {
				label: data.value_label || '',
				data: data.series,
				backgroundColor: backgroundColor,
				borderColor: isPie ? palette.surface : '#2a78d6',
				borderWidth: isPie ? 2 : ( 'line' === chartType ? 2 : 0 ),
				borderRadius: 'bar' === chartType ? 4 : 0,
				fill: 'line' === chartType,
				tension: 0.35,
				pointRadius: 'line' === chartType ? 2 : 0,
				pointHoverRadius: 'line' === chartType ? 5 : 0,
				pointBackgroundColor: '#2a78d6',
				hoverOffset: isPie ? 8 : 0,
			} ],
		};

		var showLegend = isPie;

		var options = {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					display: showLegend,
					position: 'bottom',
					labels: { color: palette.textSecondary, boxWidth: 12, padding: 12, font: { family: 'system-ui, -apple-system, "Segoe UI", sans-serif', size: 11 } },
				},
				tooltip: {
					backgroundColor: palette.surface,
					titleColor: palette.textPrimary,
					bodyColor: palette.textSecondary,
					borderColor: palette.gridline,
					borderWidth: 1,
					padding: 10,
					cornerRadius: 6,
					displayColors: ! isPie,
				},
			},
			scales: isPie ? {} : {
				x: { grid: { display: false }, ticks: { color: palette.textMuted, font: { size: 10 } } },
				y: { beginAtZero: true, grid: { color: palette.gridline }, ticks: { color: palette.textMuted, font: { size: 10 }, precision: 0 } },
			},
		};

		chartInstances[ id ] = new Chart( canvas.getContext( '2d' ), { type: chartType, data: chartData, options: options } );
	}

	function escapeHtml( str ) {
		var div = document.createElement( 'div' );
		div.textContent = null === str || undefined === str ? '' : String( str );
		return div.innerHTML;
	}
	function escapeAttr( str ) {
		return escapeHtml( str ).replace( /"/g, '&quot;' );
	}

	/* -----------------------------------------------------------
	 * Card lifecycle
	 * --------------------------------------------------------- */

	function initCard( card ) {
		var metric = card.getAttribute( 'data-metric' );
		var chartType = card.getAttribute( 'data-chart-type' );
		var def = catalog[ metric ];
		if ( ! def ) {
			card.remove();
			return;
		}
		if ( -1 === def.supports.indexOf( chartType ) ) {
			chartType = def.default;
			card.setAttribute( 'data-chart-type', chartType );
		}

		card.innerHTML = '';
		buildHeader( card, metric, chartType );
		var body = document.createElement( 'div' );
		body.className = 'pa-widget-card__body';
		body.innerHTML = '<div class="pa-widget-loading" aria-hidden="true"></div>';
		card.appendChild( body );

		makeDraggable( card );

		fetchWidgetData( metric ).then( function ( data ) {
			dataCache[ card.getAttribute( 'data-id' ) ] = data;
			renderBody( card, metric, card.getAttribute( 'data-chart-type' ), data );
		} );
	}

	function addWidget( metric ) {
		var def = catalog[ metric ];
		if ( ! def ) {
			return;
		}
		var card = document.createElement( 'div' );
		card.className = 'pa-widget-card';
		card.setAttribute( 'data-id', 'w' + Date.now().toString( 36 ) + Math.random().toString( 36 ).slice( 2, 6 ) );
		card.setAttribute( 'data-metric', metric );
		card.setAttribute( 'data-chart-type', def.default );
		grid.appendChild( card );
		initCard( card );
		scheduleSaveLayout();
	}

	/* -----------------------------------------------------------
	 * Drag-to-reorder (native HTML5 DnD — no extra library)
	 * --------------------------------------------------------- */

	function makeDraggable( card ) {
		card.setAttribute( 'draggable', 'true' );
		card.addEventListener( 'dragstart', function ( e ) {
			card.classList.add( 'is-dragging' );
			e.dataTransfer.effectAllowed = 'move';
			e.dataTransfer.setData( 'text/plain', card.getAttribute( 'data-id' ) );
		} );
		card.addEventListener( 'dragend', function () {
			card.classList.remove( 'is-dragging' );
			scheduleSaveLayout();
		} );
	}

	grid.addEventListener( 'dragover', function ( e ) {
		e.preventDefault();
		var dragging = grid.querySelector( '.is-dragging' );
		if ( ! dragging ) {
			return;
		}
		var after = getDragAfterElement( grid, e.clientY );
		if ( null === after ) {
			grid.appendChild( dragging );
		} else if ( after !== dragging ) {
			grid.insertBefore( dragging, after );
		}
	} );

	function getDragAfterElement( container, y ) {
		var cards = Array.prototype.slice.call( container.querySelectorAll( '.pa-widget-card:not(.is-dragging)' ) );
		var closest = { offset: -Infinity, element: null };
		cards.forEach( function ( child ) {
			var box = child.getBoundingClientRect();
			var offset = y - box.top - box.height / 2;
			if ( offset < 0 && offset > closest.offset ) {
				closest = { offset: offset, element: child };
			}
		} );
		return closest.element;
	}

	/* -----------------------------------------------------------
	 * Add Widget modal
	 * --------------------------------------------------------- */

	function buildModal() {
		var modal = document.getElementById( 'pa-widget-modal' );
		if ( ! modal ) {
			return;
		}
		var list = modal.querySelector( '.pa-modal__list' );
		var byCategory = {};
		Object.keys( catalog ).forEach( function ( key ) {
			var def = catalog[ key ];
			byCategory[ def.category ] = byCategory[ def.category ] || [];
			byCategory[ def.category ].push( { key: key, def: def } );
		} );

		Object.keys( byCategory ).forEach( function ( category ) {
			var group = document.createElement( 'div' );
			group.className = 'pa-modal__group';
			var heading = document.createElement( 'h4' );
			heading.textContent = category;
			group.appendChild( heading );

			byCategory[ category ].forEach( function ( item ) {
				var btn = document.createElement( 'button' );
				btn.type = 'button';
				btn.className = 'pa-modal__item';
				btn.innerHTML = '<span class="dashicons ' + item.def.icon + '" aria-hidden="true"></span>' + escapeHtml( item.def.label );
				btn.addEventListener( 'click', function () {
					addWidget( item.key );
					closeModal();
				} );
				group.appendChild( btn );
			} );
			list.appendChild( group );
		} );

		var openBtn = document.getElementById( 'pa-add-widget-btn' );
		var closeBtn = modal.querySelector( '.pa-modal__close' );
		var backdrop = modal.querySelector( '.pa-modal__backdrop' );
		if ( openBtn ) {
			openBtn.addEventListener( 'click', function () { modal.classList.add( 'is-open' ); } );
		}
		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', closeModal );
		}
		if ( backdrop ) {
			backdrop.addEventListener( 'click', closeModal );
		}

		function closeModal() {
			modal.classList.remove( 'is-open' );
		}
	}

	var resetBtn = document.getElementById( 'pa-reset-layout-btn' );
	if ( resetBtn ) {
		resetBtn.addEventListener( 'click', function () {
			var body = new URLSearchParams();
			body.set( 'action', 'bluelens_analytics_reset_layout' );
			body.set( 'nonce', cfg.nonce );
			fetch( cfg.ajaxUrl, { method: 'POST', body: body, credentials: 'same-origin' } )
				.then( function ( res ) { return res.json(); } )
				.then( function () { window.location.reload(); } );
		} );
	}

	/* -----------------------------------------------------------
	 * Re-render every chart when the dark/light toggle fires — Chart.js
	 * paints to canvas, so the CSS class swap alone won't recolor axis
	 * labels/gridlines/tooltips already drawn under the other theme.
	 * --------------------------------------------------------- */

	if ( wrapEl ) {
		// Deliberately attached to `document`, same as theme-toggle.js's
		// own listener, and after it in script order (see the
		// 'blue-lens-analytics-theme-toggle' dependency in
		// class-admin-menu.php) — same-element listeners run in
		// registration order, so the class has already flipped by the
		// time this runs. A listener on wrapEl itself would fire during
		// the bubble phase *before* document's, i.e. too early.
		document.addEventListener( 'click', function ( e ) {
			if ( ! e.target.closest( '.bla-theme-toggle' ) ) {
				return;
			}
			Array.prototype.forEach.call( grid.querySelectorAll( '.pa-widget-card' ), function ( card ) {
				var id = card.getAttribute( 'data-id' );
				var metric = card.getAttribute( 'data-metric' );
				var select = card.querySelector( '.pa-widget-card__type-select' );
				var chartType = select ? select.value : card.getAttribute( 'data-chart-type' );
				if ( dataCache[ id ] ) {
					renderBody( card, metric, chartType, dataCache[ id ] );
				}
			} );
		} );
	}

	/* -----------------------------------------------------------
	 * Boot
	 * --------------------------------------------------------- */

	document.addEventListener( 'DOMContentLoaded', function () {
		Array.prototype.forEach.call( grid.querySelectorAll( '.pa-widget-card' ), initCard );
		buildModal();
	} );
} )();
