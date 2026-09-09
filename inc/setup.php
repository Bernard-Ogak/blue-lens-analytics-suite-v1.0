<?php
/**
 * Theme Setup
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bo_safari_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function bo_safari_theme_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'bo-safari-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Define custom image sizes tailored for luxury tourism presentation
		add_image_size( 'safari-hero', 1920, 1080, true );
		add_image_size( 'safari-card', 800, 600, true );
		add_image_size( 'safari-gallery', 1200, 800, true );
		add_image_size( 'safari-thumb', 400, 300, true );
		add_image_size( 'safari-square', 600, 600, true );

		// Register Navigation Menus
		register_nav_menus(
			array(
				'primary'           => esc_html__( 'Primary Menu', 'bo-safari-theme' ),
				'mobile'            => esc_html__( 'Mobile Navigation', 'bo-safari-theme' ),
				'footer_quick'      => esc_html__( 'Footer Quick Links', 'bo-safari-theme' ),
				'footer_dest'       => esc_html__( 'Footer Destinations', 'bo-safari-theme' ),
				'footer_safaris'    => esc_html__( 'Footer Safaris', 'bo-safari-theme' ),
			)
		);

		// Switch default core markup to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Custom Logo support
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 90,
				'width'       => 280,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Add theme support for Gutenberg blocks
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/main.css' );

		// Gutenberg Color Palette alignment with theme identity
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Deep Safari Green', 'bo-safari-theme' ),
					'slug'  => 'deep-safari-green',
					'color' => '#1b3b2b',
				),
				array(
					'name'  => esc_html__( 'Forest Green', 'bo-safari-theme' ),
					'slug'  => 'forest-green',
					'color' => '#2d5a40',
				),
				array(
					'name'  => esc_html__( 'Sand Gold', 'bo-safari-theme' ),
					'slug'  => 'sand-gold',
					'color' => '#c5a059',
				),
				array(
					'name'  => esc_html__( 'Warm Ivory', 'bo-safari-theme' ),
					'slug'  => 'warm-ivory',
					'color' => '#fdfbf7',
				),
				array(
					'name'  => esc_html__( 'Sand', 'bo-safari-theme' ),
					'slug'  => 'sand',
					'color' => '#e6dfd3',
				),
				array(
					'name'  => esc_html__( 'Charcoal Dark', 'bo-safari-theme' ),
					'slug'  => 'charcoal-dark',
					'color' => '#222222',
				),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'bo_safari_theme_setup' );

/**
 * Set content width in pixels based on theme design
 */
function bo_safari_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bo_safari_theme_content_width', 1280 );
}
add_action( 'after_setup_theme', 'bo_safari_theme_content_width', 0 );
