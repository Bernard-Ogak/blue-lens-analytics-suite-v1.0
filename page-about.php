<?php
/**
 * Template Name: About Us Page
 *
 * @package B.O-Safari-theme
 */

get_header();
?>

<div class="about-hero py-20 bg-safari-green text-white relative overflow-hidden">
	<div class="site-container relative z-10 text-center max-w-3xl">
		<span class="badge-gold mb-4 inline-block"><?php esc_html_e( 'Our Legacy', 'bo-safari-theme' ); ?></span>
		<h1 class="text-4xl lg:text-6xl font-serif font-bold text-white mb-6">
			<?php esc_html_e( 'The Pioneers of Luxury African Safaris', 'bo-safari-theme' ); ?>
		</h1>
		<p class="text-sand/90 text-lg leading-relaxed">
			<?php esc_html_e( 'Founded on a deep reverence for wild Africa, we create extraordinary bespoke wildlife expeditions that honor local communities and protect endangered ecosystems.', 'bo-safari-theme' ); ?>
		</p>
	</div>
</div>

<div class="site-container py-16">

	<!-- Story Grid -->
	<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
		<div>
			<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Our Philosophy', 'bo-safari-theme' ); ?></span>
			<h2 class="text-3xl font-serif font-bold text-safari-green mb-6">
				<?php esc_html_e( 'Authentic Luxury, Uncompromising Conservation', 'bo-safari-theme' ); ?>
			</h2>
			<div class="prose text-charcoal/80 text-sm leading-relaxed flex flex-col gap-4">
				<p>
					<?php esc_html_e( 'We believe true luxury is not defined merely by fine linen and gourmet dining, but by access to untamed wilderness, rare animal sightings with zero crowd disturbance, and meaningful engagement with indigenous cultures.', 'bo-safari-theme' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'Every itinerary we craft contributes directly to wildlife habitat preservation, ranger anti-poaching patrols, and clean water projects in rural African villages.', 'bo-safari-theme' ); ?>
				</p>
			</div>
		</div>
		<div class="rounded-2xl overflow-hidden shadow-xl border border-sand">
			<img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=1000&q=80" alt="African Safari Guide" class="w-full h-auto object-cover">
		</div>
	</div>

	<!-- Values Grid -->
	<?php get_template_part( 'template-parts/components/why-travel-with-us' ); ?>

</div>

<?php
get_template_part( 'template-parts/components/cta-section' );
get_footer();
