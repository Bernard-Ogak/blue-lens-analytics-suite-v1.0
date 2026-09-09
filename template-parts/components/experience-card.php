<?php
/**
 * Experience Card Component
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $experience_data;
$exp = $experience_data ?: array(
	'title'       => 'Hot Air Balloon Safari',
	'category'    => 'Aerial Adventure',
	'image'       => 'https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?auto=format&fit=crop&w=800&q=80',
	'description' => 'Drift gently over the savannah at dawn followed by a champagne bush breakfast.',
	'permalink'   => '#',
);
?>

<div class="experience-card bg-white border border-sand rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group">
	<div class="aspect-[16/10] overflow-hidden relative">
		<img src="<?php echo esc_url( $exp['image'] ); ?>" alt="<?php echo esc_attr( $exp['title'] ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
		<span class="absolute top-3 left-3 badge-gold">
			<?php echo esc_html( $exp['category'] ); ?>
		</span>
	</div>
	<div class="p-6 flex flex-col flex-1">
		<h3 class="text-xl font-serif font-bold text-safari-green mb-2 group-hover:text-champagne transition-colors">
			<a href="<?php echo esc_url( $exp['permalink'] ); ?>"><?php echo esc_html( $exp['title'] ); ?></a>
		</h3>
		<p class="text-xs text-charcoal/70 mb-4 flex-1">
			<?php echo esc_html( $exp['description'] ); ?>
		</p>
		<a href="<?php echo esc_url( $exp['permalink'] ); ?>" class="text-xs font-semibold uppercase tracking-wider text-safari-green hover:text-champagne inline-flex items-center gap-1">
			<?php esc_html_e( 'Discover Experience', 'bo-safari-theme' ); ?> &rarr;
		</a>
	</div>
</div>
