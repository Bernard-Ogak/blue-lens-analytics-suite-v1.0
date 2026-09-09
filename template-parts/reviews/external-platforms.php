<?php
/**
 * External Review Platforms Section Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$platforms = bo_safari_get_external_platforms();
?>

<section class="external-platforms-section py-12 bg-white border-y border-sand">
	<div class="site-container">
		<div class="text-center mb-8">
			<span class="text-xs font-semibold uppercase tracking-widest text-charcoal/60">
				<?php esc_html_e( 'Rated Excellent Across Premier Travel Platforms', 'bo-safari-theme' ); ?>
			</span>
		</div>

		<div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
			<?php foreach ( $platforms as $p ) : ?>
				<div class="platform-box p-4 rounded-lg bg-ivory border border-sand text-center">
					<h4 class="font-serif font-bold text-safari-green text-lg mb-1"><?php echo esc_html( $p['name'] ); ?></h4>
					<span class="block text-champagne font-bold text-base mb-1"><?php echo esc_html( $p['rating'] ); ?></span>
					<span class="block text-xs font-semibold text-charcoal/70 mb-1"><?php echo esc_html( $p['badge'] ); ?></span>
					<span class="block text-xs text-charcoal/50"><?php echo esc_html( $p['reviews'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
