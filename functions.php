<?php
/**
 * B.O-Safari-theme functions and definitions
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'BO_SAFARI_THEME_VERSION', '1.0.0' );
define( 'BO_SAFARI_THEME_DIR', get_template_directory() );
define( 'BO_SAFARI_THEME_URI', get_template_directory_uri() );

/**
 * Include theme modules
 */
require_once BO_SAFARI_THEME_DIR . '/inc/setup.php';
require_once BO_SAFARI_THEME_DIR . '/inc/enqueue.php';
require_once BO_SAFARI_THEME_DIR . '/inc/plugin-integration.php';
require_once BO_SAFARI_THEME_DIR . '/inc/navigation.php';
require_once BO_SAFARI_THEME_DIR . '/inc/template-functions.php';
require_once BO_SAFARI_THEME_DIR . '/inc/theme-options.php';
require_once BO_SAFARI_THEME_DIR . '/inc/accessibility.php';
require_once BO_SAFARI_THEME_DIR . '/inc/performance.php';
require_once BO_SAFARI_THEME_DIR . '/inc/seo.php';
require_once BO_SAFARI_THEME_DIR . '/inc/helpers.php';
