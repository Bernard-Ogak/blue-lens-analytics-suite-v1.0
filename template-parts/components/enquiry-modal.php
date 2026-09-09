<?php
/**
 * Enquiry Modal Component
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="enquiry-modal" class="modal-wrapper">
	<div class="modal-backdrop"></div>
	<div class="modal-content-card">
		<button class="modal-close-btn" aria-label="<?php esc_attr_e( 'Close Modal', 'bo-safari-theme' ); ?>">&times;</button>

		<div class="text-center mb-6">
			<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Bespoke Enquiry', 'bo-safari-theme' ); ?></span>
			<h3 class="text-2xl font-serif font-bold text-safari-green">
				<?php esc_html_e( 'Plan Your African Safari', 'bo-safari-theme' ); ?>
			</h3>
			<p class="text-xs text-charcoal/70 enquiry-safari-title-display mt-1">
				<?php esc_html_e( 'Speak with our senior luxury travel concierge', 'bo-safari-theme' ); ?>
			</p>
		</div>

		<form class="bo-safari-enquiry-form flex flex-col gap-4">
			<input type="hidden" name="safari_title" value="">

			<div>
				<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-1"><?php esc_html_e( 'Full Name *', 'bo-safari-theme' ); ?></label>
				<input type="text" name="full_name" required class="w-full p-3 bg-sand-light border border-sand rounded text-sm focus:outline-none focus:border-champagne">
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-1"><?php esc_html_e( 'Email Address *', 'bo-safari-theme' ); ?></label>
					<input type="email" name="email" required class="w-full p-3 bg-sand-light border border-sand rounded text-sm focus:outline-none focus:border-champagne">
				</div>
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-1"><?php esc_html_e( 'Phone Number', 'bo-safari-theme' ); ?></label>
					<input type="tel" name="phone" class="w-full p-3 bg-sand-light border border-sand rounded text-sm focus:outline-none focus:border-champagne">
				</div>
			</div>

			<div>
				<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-1"><?php esc_html_e( 'Your Travel Plans & Preferences', 'bo-safari-theme' ); ?></label>
				<textarea name="message" rows="4" placeholder="<?php esc_attr_e( 'Tell us about your estimated dates, group size, and interests...', 'bo-safari-theme' ); ?>" class="w-full p-3 bg-sand-light border border-sand rounded text-sm focus:outline-none focus:border-champagne"></textarea>
			</div>

			<div class="form-feedback"></div>

			<button type="submit" class="btn-primary w-full py-3.5 text-xs font-bold uppercase tracking-wider">
				<?php esc_html_e( 'Submit Safari Request', 'bo-safari-theme' ); ?>
			</button>
		</form>
	</div>
</div>
