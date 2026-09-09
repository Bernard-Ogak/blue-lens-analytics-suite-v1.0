<?php
/**
 * WP Customizer Theme Options (Presentation Only)
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bo_safari_customize_register( $wp_customize ) {
	// Panel for Luxury Theme Settings
	$wp_customize->add_panel(
		'bo_safari_theme_panel',
		array(
			'title'       => esc_html__( 'B.O-Safari-theme Options', 'bo-safari-theme' ),
			'description' => esc_html__( 'Presentation and branding configuration for your luxury safari website.', 'bo-safari-theme' ),
			'priority'    => 20,
		)
	);

	// Section 1: Contact & WhatsApp Concierge
	$wp_customize->add_section(
		'bo_safari_contact_section',
		array(
			'title'    => esc_html__( 'Contact & WhatsApp Details', 'bo-safari-theme' ),
			'panel'    => 'bo_safari_theme_panel',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting( 'bo_safari_phone', array( 'default' => '+254 (0) 700 123 456', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'bo_safari_phone', array( 'label' => esc_html__( 'Phone Number', 'bo-safari-theme' ), 'section' => 'bo_safari_contact_section', 'type' => 'text' ) );

	$wp_customize->add_setting( 'bo_safari_email', array( 'default' => 'concierge@bo-safari.com', 'sanitize_callback' => 'sanitize_email' ) );
	$wp_customize->add_control( 'bo_safari_email', array( 'label' => esc_html__( 'Contact Email', 'bo-safari-theme' ), 'section' => 'bo_safari_contact_section', 'type' => 'email' ) );

	$wp_customize->add_setting( 'bo_safari_whatsapp', array( 'default' => '+254700000000', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'bo_safari_whatsapp', array( 'label' => esc_html__( 'WhatsApp Number (with country code)', 'bo-safari-theme' ), 'section' => 'bo_safari_contact_section', 'type' => 'text' ) );

	// Section 2: Social Media Handles
	$wp_customize->add_section(
		'bo_safari_social_section',
		array(
			'title'    => esc_html__( 'Social Media Links', 'bo-safari-theme' ),
			'panel'    => 'bo_safari_theme_panel',
			'priority' => 20,
		)
	);

	$socials = array(
		'facebook'  => 'Facebook URL',
		'instagram' => 'Instagram URL',
		'youtube'   => 'YouTube URL',
		'tiktok'    => 'TikTok URL',
		'linkedin'  => 'LinkedIn URL',
	);

	foreach ( $socials as $key => $label ) {
		$wp_customize->add_setting( "bo_safari_social_{$key}", array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( "bo_safari_social_{$key}", array( 'label' => esc_html__( $label, 'bo-safari-theme' ), 'section' => 'bo_safari_social_section', 'type' => 'url' ) );
	}
}
add_action( 'customize_register', 'bo_safari_customize_register' );
