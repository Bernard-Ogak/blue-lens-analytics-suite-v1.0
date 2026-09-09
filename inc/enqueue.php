<?php
/**
 * Enqueue Styles and Scripts
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue scripts and styles.
 */
function bo_safari_theme_scripts() {
	// Google Fonts (Poppins & Playfair Display)
	wp_enqueue_style(
		'bo-safari-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..800;1,400..800&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap',
		array(),
		null
	);

	// Theme Main Stylesheet
	wp_enqueue_style(
		'bo-safari-style',
		BO_SAFARI_THEME_URI . '/assets/css/main.css',
		array(),
		BO_SAFARI_THEME_VERSION
	);

	// Core Theme JavaScript
	wp_enqueue_script(
		'bo-safari-script',
		BO_SAFARI_THEME_URI . '/assets/js/main.js',
		array(),
		BO_SAFARI_THEME_VERSION,
		true
	);

	// Localize script for AJAX dynamic interactions
	wp_localize_script(
		'bo-safari-script',
		'boSafariData',
		array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'restUrl'     => esc_url_raw( rest_url( 'bo-safari/v1/' ) ),
			'nonce'       => wp_create_nonce( 'bo_safari_nonce' ),
			'whatsapp'    => array(
				'number'  => get_option( 'bo_safari_whatsapp_number', '+254700000000' ),
				'message' => get_option( 'bo_safari_whatsapp_default_message', 'Hello, I am interested in planning a luxury African safari with you.' ),
			),
			'currency'    => array(
				'code'   => get_option( 'bo_safari_currency_code', 'USD' ),
				'symbol' => get_option( 'bo_safari_currency_symbol', '$' ),
			),
			'strings'     => array(
				'loading'     => esc_html__( 'Processing request...', 'bo-safari-theme' ),
				'success'     => esc_html__( 'Thank you! Your enquiry has been sent successfully.', 'bo-safari-theme' ),
				'error'       => esc_html__( 'An error occurred. Please try again or contact us directly via WhatsApp.', 'bo-safari-theme' ),
				'selectDay'   => esc_html__( 'Day', 'bo-safari-theme' ),
				'copied'      => esc_html__( 'Link copied to clipboard!', 'bo-safari-theme' ),
			),
		)
	);

	// Custom Safari Builder Script (Loaded on custom builder template or page)
	if ( is_page_template( 'page-build-your-safari.php' ) || is_page( 'build-your-safari' ) ) {
		wp_enqueue_script(
			'bo-safari-builder',
			BO_SAFARI_THEME_URI . '/assets/js/safari-builder.js',
			array( 'bo-safari-script' ),
			BO_SAFARI_THEME_VERSION,
			true
		);
	}

	// Comment reply script if needed
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bo_safari_theme_scripts' );
