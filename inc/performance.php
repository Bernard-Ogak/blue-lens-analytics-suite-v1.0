<?php
/**
 * Performance & Optimization Settings
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Defer non-critical theme scripts for improved Core Web Vitals
 *
 * @param string $tag Script HTML tag.
 * @param string $handle Script handle.
 * @return string
 */
function bo_safari_defer_scripts( $tag, $handle ) {
	if ( is_admin() ) {
		return $tag;
	}

	if ( in_array( $handle, array( 'bo-safari-script', 'bo-safari-builder' ), true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'bo_safari_defer_scripts', 10, 2 );

/**
 * Remove superfluous meta tags from wp_head
 */
function bo_safari_clean_head() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'init', 'bo_safari_clean_head' );
