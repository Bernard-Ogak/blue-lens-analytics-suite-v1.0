<?php
/**
 * Custom Safari Builder Banner Component
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="builder-banner my-16 py-16 bg-safari-green text-white relative overflow-hidden">
	<div class="site-container relative z-10">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
			<div>
				<span class="badge-gold mb-4 inline-block"><?php esc_html_e( 'Interactive Planner', 'bo-safari-theme' ); ?></span>
				<h2 class="text-3xl lg:text-5xl font-serif font-bold text-white mb-6 leading-tight">
					<?php esc_html_e( 'Build Your Dream African Safari in Minutes', 'bo-safari-theme' ); ?>
				</h2>
				<p class="text-sand/80 text-base mb-8 leading-relaxed">
					<?php esc_html_e( 'Select your preferred destinations, travel dates, accommodation style, and signature experiences. Our trip architects will curate a bespoke proposal tailored to your specifications.', 'bo-safari-theme' ); ?>
				</p>
				<a href="<?php echo esc_url( home_url( '/build-your-safari' ) ); ?>" class="btn-primary py-4 px-8 text-sm">
					<?php esc_html_e( 'Start Planning My Journey', 'bo-safari-theme' ); ?> &rarr;
				</a>
			</div>

			<div class="bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 text-center">
				<h3 class="text-2xl font-serif font-bold text-champagne mb-4"><?php esc_html_e( 'How It Works', 'bo-safari-theme' ); ?></h3>
				<div class="grid grid-cols-1 gap-4 text-left text-sm text-sand">
					<div class="flex items-center gap-3">
						<span class="w-8 h-8 rounded-full bg-champagne text-white font-bold flex items-center justify-center shrink-0">1</span>
						<span><?php esc_html_e( 'Choose destinations & travel style preferences', 'bo-safari-theme' ); ?></span>
					</div>
					<div class="flex items-center gap-3">
						<span class="w-8 h-8 rounded-full bg-champagne text-white font-bold flex items-center justify-center shrink-0">2</span>
						<span><?php esc_html_e( 'Specify group size, dates, and budget range', 'bo-safari-theme' ); ?></span>
					</div>
					<div class="flex items-center gap-3">
						<span class="w-8 h-8 rounded-full bg-champagne text-white font-bold flex items-center justify-center shrink-0">3</span>
						<span><?php esc_html_e( 'Receive a custom itinerary proposal within 24h', 'bo-safari-theme' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
