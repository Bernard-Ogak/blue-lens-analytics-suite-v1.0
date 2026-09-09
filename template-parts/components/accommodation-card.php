<?php
/**
 * Accommodation Card Component
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $accommodation_data;
$acc = $accommodation_data ?: array(
	'title'       => 'Singita Mara River Tented Camp',
	'destination' => 'Lamai Triangle, Serengeti',
	'type'        => 'Luxury Tented Camp',
	'rating'      => '5.0',
	'image'       => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
	'permalink'   => '#',
);
?>

<div class="accommodation-card bg-white border border-sand rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
	<div class="aspect-[16/10] overflow-hidden relative">
		<img src="<?php echo esc_url( $acc['image'] ); ?>" alt="<?php echo esc_attr( $acc['title'] ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
		<span class="absolute top-3 right-3 bg-safari-green/90 text-white text-xs px-3 py-1 rounded-full font-semibold">
			<?php echo esc_html( $acc['type'] ); ?>
		</span>
	</div>
	<div class="p-6">
		<span class="text-xs uppercase font-semibold text-champagne block mb-1">
			<?php echo esc_html( $acc['destination'] ); ?>
		</span>
		<h3 class="text-xl font-serif font-bold text-safari-green mb-2 group-hover:text-champagne transition-colors">
			<a href="<?php echo esc_url( $acc['permalink'] ); ?>"><?php echo esc_html( $acc['title'] ); ?></a>
		</h3>
		<div class="flex items-center justify-between pt-3 border-t border-sand-light">
			<?php bo_safari_render_star_rating( $acc['rating'] ); ?>
			<a href="<?php echo esc_url( $acc['permalink'] ); ?>" class="text-xs font-semibold text-safari-green hover:text-champagne">
				<?php esc_html_e( 'View Sanctuary', 'bo-safari-theme' ); ?> &rarr;
			</a>
		</div>
	</div>
</div>
