<?php
/**
 * Accessibility Enhancements (WCAG 2.1 AA Compliance)
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add aria labels and attributes to nav menu items
 *
 * @param array $atts Nav item attributes.
 * @param object $item Nav item object.
 * @param object $args Nav menu args.
 * @return array
 */
function bo_safari_accessibility_nav_atts( $atts, $item, $args ) {
	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
		$atts['aria-expanded'] = 'false';
		$atts['aria-haspopup'] = 'true';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'bo_safari_accessibility_nav_atts', 10, 3 );
