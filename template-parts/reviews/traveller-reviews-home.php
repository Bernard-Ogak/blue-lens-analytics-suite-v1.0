<?php
/**
 * Traveller Reviews Home Section Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$reviews = bo_safari_get_reviews();
?>

<section class="reviews-home-section py-20 bg-ivory">
	<div class="site-container">
		<div class="text-center max-w-2xl mx-auto mb-12">
			<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Verified Feedback', 'bo-safari-theme' ); ?></span>
			<h2 class="text-3xl lg:text-4xl font-serif text-safari-green font-bold mb-3">
				<?php esc_html_e( 'Stories From Our Travellers', 'bo-safari-theme' ); ?>
			</h2>
			<p class="text-charcoal/80 text-sm">
				<?php esc_html_e( 'Read real experiences from luxury travelers who entrusted us with their African dream holidays.', 'bo-safari-theme' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
			<?php
			foreach ( $reviews as $rev ) {
				$GLOBALS['review_data'] = $rev;
				get_template_part( 'template-parts/components/review-card' );
			}
			unset( $GLOBALS['review_data'] );
			?>
		</div>
	</div>
</section>
