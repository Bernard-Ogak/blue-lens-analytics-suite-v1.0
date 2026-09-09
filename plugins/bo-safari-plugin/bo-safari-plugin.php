<?php
/**
 * Plugin Name: B.O-Safari-Plugin
 * Plugin URI: https://example.com/bo-safari-plugin
 * Description: Business data layer for B.O-Safari-theme. Manages custom post types (Safaris, Destinations, Experiences, Accommodation), pricing, enquiries, bookings, and guest reviews.
 * Version: 1.0.0
 * Author: Bernard Ogak
 * Author URI: https://example.com
 * Text Domain: bo-safari-plugin
 * License: GPL-2.0-or-later
 *
 * @package B.O-Safari-Plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BO_SAFARI_PLUGIN_VERSION', '1.0.0' );

/**
 * Register Custom Post Types for Tours & Tourism Layer
 */
function bo_safari_register_cpts() {

	// Safari CPT
	register_post_type(
		'safari',
		array(
			'labels' => array(
				'name'          => __( 'Safaris', 'bo-safari-plugin' ),
				'singular_name' => __( 'Safari', 'bo-safari-plugin' ),
			),
			'public'        => true,
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-compass',
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
			'show_in_rest'  => true,
			'rewrite'       => array( 'slug' => 'safaris' ),
		)
	);

	// Destination CPT
	register_post_type(
		'destination',
		array(
			'labels' => array(
				'name'          => __( 'Destinations', 'bo-safari-plugin' ),
				'singular_name' => __( 'Destination', 'bo-safari-plugin' ),
			),
			'public'        => true,
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-location-alt',
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'  => true,
			'rewrite'       => array( 'slug' => 'destinations' ),
		)
	);

	// Experience CPT
	register_post_type(
		'experience',
		array(
			'labels' => array(
				'name'          => __( 'Experiences', 'bo-safari-plugin' ),
				'singular_name' => __( 'Experience', 'bo-safari-plugin' ),
			),
			'public'        => true,
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-star-filled',
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'  => true,
			'rewrite'       => array( 'slug' => 'experiences' ),
		)
	);

	// Accommodation CPT
	register_post_type(
		'accommodation',
		array(
			'labels' => array(
				'name'          => __( 'Accommodations', 'bo-safari-plugin' ),
				'singular_name' => __( 'Accommodation', 'bo-safari-plugin' ),
			),
			'public'        => true,
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-building',
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'  => true,
			'rewrite'       => array( 'slug' => 'accommodation' ),
		)
	);
}
add_action( 'init', 'bo_safari_register_cpts' );

/**
 * Public Helper APIs for B.O-Safari-theme Integration
 */
function bo_safari_api_get_safaris( $args = array() ) {
	$default_args = array(
		'post_type'      => 'safari',
		'posts_per_page' => 6,
		'post_status'    => 'publish',
	);

	$query = new WP_Query( wp_parse_args( $args, $default_args ) );
	$results = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$results[] = array(
				'id'           => get_the_ID(),
				'title'        => get_the_title(),
				'permalink'    => get_permalink(),
				'thumbnail'    => get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ),
				'destination'  => get_post_meta( get_the_ID(), '_safari_destination', true ) ?: 'Serengeti & Masai Mara',
				'duration'     => get_post_meta( get_the_ID(), '_safari_duration', true ) ?: '7 Days / 6 Nights',
				'price'        => get_post_meta( get_the_ID(), '_safari_price', true ) ?: '3,850',
				'currency'     => 'USD',
				'rating'       => '4.98',
				'review_count' => '115',
				'badge'        => 'Bestseller',
				'excerpt'      => get_the_excerpt(),
			);
		}
		wp_reset_postdata();
	}
	return $results;
}

function bo_safari_save_enquiry( $data ) {
	$enquiries = get_option( 'bo_safari_enquiries_log', array() );
	$enquiries[] = array_merge( $data, array( 'timestamp' => current_time( 'mysql' ) ) );
	update_option( 'bo_safari_enquiries_log', $enquiries );
	return true;
}
