<?php
/**
 * Template Helper Functions
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render Star Rating HTML
 *
 * @param float $rating Rating number e.g. 4.9.
 * @return void
 */
function bo_safari_render_star_rating( $rating = 5.0 ) {
	$rating = floatval( $rating );
	$full_stars = floor( $rating );
	$half_star = ( $rating - $full_stars ) >= 0.5;

	echo '<div class="star-rating flex items-center gap-1 text-champagne" aria-label="' . esc_attr( sprintf( __( 'Rating: %s out of 5 stars', 'bo-safari-theme' ), $rating ) ) . '">';
	for ( $i = 1; $i <= 5; $i++ ) {
		if ( $i <= $full_stars ) {
			echo '<svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
		} elseif ( $half_star && $i === $full_stars + 1 ) {
			echo '<svg class="w-4 h-4 fill-current opacity-70" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
		} else {
			echo '<svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
		}
	}
	echo '</div>';
}

/**
 * Render WhatsApp Button HTML
 *
 * @param string $label Button label.
 * @param string $source Source placement location.
 * @return void
 */
function bo_safari_render_whatsapp_button( $label = '', $source = 'page' ) {
	$label   = $label ?: __( 'WhatsApp Concierge', 'bo-safari-theme' );
	$number  = preg_replace( '/[^0-9+]/', '', get_option( 'bo_safari_whatsapp_number', '+254700000000' ) );
	$message = rawurlencode( get_option( 'bo_safari_whatsapp_default_message', 'Hello! I am planning an African safari and would like expert advice.' ) );
	$url     = "https://wa.me/{$number}?text={$message}";

	echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer" class="btn-whatsapp" data-source="' . esc_attr( $source ) . '">';
	echo '<svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>';
	echo '<span>' . esc_html( $label ) . '</span>';
	echo '</a>';
}

/**
 * Render Price Display
 *
 * @param string|float $price Price amount.
 * @param string       $currency Currency code.
 * @return void
 */
function bo_safari_render_price_display( $price, $currency = 'USD' ) {
	$symbol = '$';
	if ( 'EUR' === $currency ) {
		$symbol = '€';
	} elseif ( 'GBP' === $currency ) {
		$symbol = '£';
	}

	echo '<div class="price-display-wrapper">';
	echo '<span class="price-tag-label block text-xs uppercase text-charcoal/60">' . esc_html__( 'From', 'bo-safari-theme' ) . '</span>';
	echo '<span class="price-tag-amount font-serif text-xl font-bold text-safari-green">' . esc_html( $symbol ) . esc_html( $price ) . ' <span class="text-xs font-sans font-normal text-charcoal/70">/ ' . esc_html__( 'person', 'bo-safari-theme' ) . '</span></span>';
	echo '</div>';
}
