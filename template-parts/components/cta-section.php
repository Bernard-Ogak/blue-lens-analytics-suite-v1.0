<?php
/**
 * CTA Section Component
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="final-cta-section py-20 bg-ivory text-center border-t border-sand">
	<div class="site-container max-w-3xl">
		<span class="badge-gold mb-3"><?php esc_html_e( 'Your African Story Starts Here', 'bo-safari-theme' ); ?></span>
		<h2 class="text-3xl lg:text-5xl font-serif text-safari-green font-bold mb-6">
			<?php esc_html_e( 'Ready to Experience the Magic of Africa?', 'bo-safari-theme' ); ?>
		</h2>
		<p class="text-charcoal/80 text-lg mb-8 leading-relaxed">
			<?php esc_html_e( 'Speak directly with our senior luxury safari specialists today. We are ready to make your dream African journey a reality.', 'bo-safari-theme' ); ?>
		</p>

		<div class="flex flex-wrap items-center justify-center gap-4">
			<a href="#" class="btn-primary py-4 px-8 text-sm" data-open-enquiry-modal="true">
				<?php esc_html_e( 'Request Tailor-Made Itinerary', 'bo-safari-theme' ); ?>
			</a>
			<?php bo_safari_render_whatsapp_button( __( 'Chat on WhatsApp', 'bo-safari-theme' ), 'cta_section' ); ?>
		</div>
	</div>
</section>
