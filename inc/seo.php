<?php
/**
 * SEO & Structured Data (Schema.org) Output
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output JSON-LD Schema for Organization & TravelAgency
 */
function bo_safari_output_agency_schema() {
	if ( ! is_front_page() ) {
		return;
	}

	$phone    = get_option( 'bo_safari_phone', '+254700123456' );
	$email    = get_option( 'bo_safari_email', 'concierge@bo-safari.com' );
	$logo_id  = get_theme_mod( 'custom_logo' );
	$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : get_template_directory_uri() . '/assets/images/logo.png';

	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'TravelAgency',
		'name'            => get_bloginfo( 'name' ),
		'description'     => get_bloginfo( 'description' ),
		'url'             => home_url( '/' ),
		'logo'            => $logo_url,
		'telephone'       => $phone,
		'email'           => $email,
		'priceRange'      => '$$$$',
		'currenciesAccepted' => 'USD, EUR, GBP',
		'areaServed'      => array( 'Kenya', 'Tanzania', 'Rwanda', 'Uganda', 'Botswana', 'South Africa' ),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}
add_action( 'wp_head', 'bo_safari_output_agency_schema' );

/**
 * Output JSON-LD Schema for TouristTrip on single safari page
 */
function bo_safari_output_safari_schema() {
	if ( ! is_singular( 'safari' ) ) {
		return;
	}

	global $post;

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'TouristTrip',
		'name'        => get_the_title(),
		'description' => get_the_excerpt(),
		'url'         => get_permalink(),
		'image'       => get_the_post_thumbnail_url( $post->ID, 'safari-hero' ),
		'offers'      => array(
			'@type'         => 'Offer',
			'price'         => get_post_meta( $post->ID, '_safari_price', true ) ?: '3850',
			'priceCurrency' => 'USD',
			'availability'  => 'https://schema.org/InStock',
		),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}
add_action( 'wp_head', 'bo_safari_output_safari_schema' );
