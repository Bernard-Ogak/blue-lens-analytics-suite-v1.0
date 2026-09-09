<?php
/**
 * Signature Experiences Section Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$experiences = bo_safari_get_experiences();
?>

<section class="signature-experiences-section py-20 bg-ivory">
	<div class="site-container">
		<div class="text-center max-w-2xl mx-auto mb-12">
			<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Unforgettable Moments', 'bo-safari-theme' ); ?></span>
			<h2 class="text-3xl lg:text-4xl font-serif text-safari-green font-bold mb-3">
				<?php esc_html_e( 'Signature African Experiences', 'bo-safari-theme' ); ?>
			</h2>
			<p class="text-charcoal/80 text-sm">
				<?php esc_html_e( 'Elevate your journey with rare wildlife encounters, hot air balloon flights, and private bush dining.', 'bo-safari-theme' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
			<?php
			foreach ( $experiences as $exp ) {
				$GLOBALS['experience_data'] = $exp;
				get_template_part( 'template-parts/components/experience-card' );
			}
			unset( $GLOBALS['experience_data'] );
			?>
		</div>
	</div>
</section>
