<?php
/**
 * The Header for B.O-Safari-theme
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary-content">
	<?php esc_html_e( 'Skip to content', 'bo-safari-theme' ); ?>
</a>

<div id="page" class="site-wrapper">

	<?php get_template_part( 'template-parts/header/site-header' ); ?>

	<main id="primary-content" class="site-main" role="main">
