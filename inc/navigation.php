<?php
/**
 * Navigation and Walker Functions
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Walker for Primary Navigation with Mega Menu support
 */
class BO_Safari_Nav_Walker extends Walker_Nav_Menu {
	/**
	 * Starts the element output.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			$classes[] = 'has-dropdown';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= '<li' . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$item_output  = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $title . ( isset( $args->link_after ) ? $args->link_after : '' );
		$item_output .= '</a>';
		$item_output .= isset( $args->after ) ? $args->after : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**
 * Render Fallback Primary Navigation when no menu is assigned
 */
function bo_safari_primary_nav_fallback() {
	echo '<ul class="primary-menu-list flex gap-8 items-center list-none">';
	echo '<li><a href="' . esc_url( get_post_type_archive_link( 'destination' ) ? get_post_type_archive_link( 'destination' ) : home_url( '/destinations' ) ) . '">' . esc_html__( 'Destinations', 'bo-safari-theme' ) . '</a></li>';
	echo '<li><a href="' . esc_url( get_post_type_archive_link( 'safari' ) ? get_post_type_archive_link( 'safari' ) : home_url( '/safaris' ) ) . '">' . esc_html__( 'Safaris', 'bo-safari-theme' ) . '</a></li>';
	echo '<li><a href="' . esc_url( get_post_type_archive_link( 'experience' ) ? get_post_type_archive_link( 'experience' ) : home_url( '/experiences' ) ) . '">' . esc_html__( 'Experiences', 'bo-safari-theme' ) . '</a></li>';
	echo '<li><a href="' . esc_url( get_post_type_archive_link( 'accommodation' ) ? get_post_type_archive_link( 'accommodation' ) : home_url( '/accommodation' ) ) . '">' . esc_html__( 'Accommodation', 'bo-safari-theme' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/reviews' ) ) . '">' . esc_html__( 'Reviews', 'bo-safari-theme' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/about' ) ) . '">' . esc_html__( 'About Us', 'bo-safari-theme' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '">' . esc_html__( 'Contact', 'bo-safari-theme' ) . '</a></li>';
	echo '</ul>';
}
