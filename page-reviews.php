<?php
/**
 * Template Name: Reviews & Testimonials Page
 *
 * @package B.O-Safari-theme
 */

get_header();

$reviews   = bo_safari_get_reviews();
$platforms = bo_safari_get_external_platforms();
?>

<div class="reviews-hero py-16 bg-ivory border-b border-sand text-center">
	<div class="site-container max-w-3xl">
		<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Verified Guest Feedback', 'bo-safari-theme' ); ?></span>
		<h1 class="text-4xl lg:text-5xl font-serif text-safari-green font-bold mb-4">
			<?php esc_html_e( 'Traveller Reviews & Accolades', 'bo-safari-theme' ); ?>
		</h1>
		<p class="text-charcoal/80 text-base">
			<?php esc_html_e( 'Read unedited reviews from guests across TripAdvisor, SafariBookings, and Google.', 'bo-safari-theme' ); ?>
		</p>
	</div>
</div>

<div class="site-container py-16">
	<!-- Platform Ratings Summary -->
	<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
		<?php foreach ( $platforms as $p ) : ?>
			<div class="p-6 bg-white border border-sand rounded-xl text-center shadow-sm">
				<h3 class="font-serif font-bold text-safari-green text-xl mb-1"><?php echo esc_html( $p['name'] ); ?></h3>
				<span class="text-champagne font-bold text-2xl block mb-1"><?php echo esc_html( $p['rating'] ); ?></span>
				<span class="text-xs text-charcoal/70 block"><?php echo esc_html( $p['reviews'] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>

	<!-- Reviews Grid -->
	<h2 class="text-2xl font-serif font-bold text-safari-green mb-8 text-center"><?php esc_html_e( 'Featured Guest Stories', 'bo-safari-theme' ); ?></h2>

	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
		<?php
		foreach ( $reviews as $rev ) {
			$GLOBALS['review_data'] = $rev;
			get_template_part( 'template-parts/components/review-card' );
		}
		unset( $GLOBALS['review_data'] );
		?>
	</div>
</div>

<?php
get_template_part( 'template-parts/components/cta-section' );
get_footer();
