<?php
/**
 * Newsletter Section Component
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="newsletter-section py-16 bg-sand-light border-y border-sand">
	<div class="site-container max-w-4xl text-center">
		<h2 class="text-2xl md:text-3xl font-serif text-safari-green font-bold mb-3">
			<?php esc_html_e( 'Stay Inspired With African Wilderness Stories', 'bo-safari-theme' ); ?>
		</h2>
		<p class="text-charcoal/80 text-sm mb-6 max-w-xl mx-auto">
			<?php esc_html_e( 'Join our private newsletter for seasonal wildebeest migration updates, lodge openings, and insider safari planning guides.', 'bo-safari-theme' ); ?>
		</p>

		<form class="newsletter-form flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
			<input type="email" placeholder="<?php esc_attr_e( 'Enter your email address', 'bo-safari-theme' ); ?>" class="p-3.5 bg-white rounded border border-sand flex-1 text-sm focus:outline-none focus:border-champagne" required>
			<button type="submit" class="btn-primary py-3.5 px-6 text-xs whitespace-nowrap">
				<?php esc_html_e( 'Join Newsletter', 'bo-safari-theme' ); ?>
			</button>
		</form>
	</div>
</section>
