<?php
/**
 * Content None Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="no-content-found text-center py-12 px-6 bg-white border border-sand rounded-xl max-w-lg mx-auto">
	<h3 class="text-xl font-serif font-bold text-safari-green mb-2">
		<?php esc_html_e( 'No posts found', 'bo-safari-theme' ); ?>
	</h3>
	<p class="text-xs text-charcoal/70 mb-6">
		<?php esc_html_e( 'It seems we cannot find what you are looking for.', 'bo-safari-theme' ); ?>
	</p>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary text-xs">
		<?php esc_html_e( 'Return to Homepage', 'bo-safari-theme' ); ?>
	</a>
</div>
