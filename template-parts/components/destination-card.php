<?php
/**
 * Destination Card Component
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $destination_data;
$dest = $destination_data ?: array(
	'title'        => 'Serengeti National Park',
	'country'      => 'Tanzania',
	'image'        => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=800&q=80',
	'safari_count' => '14 Safaris',
	'highlights'   => 'Great Migration, Big Cat Predators',
	'permalink'    => '#',
);
?>

<div class="destination-card relative rounded-xl overflow-hidden group shadow-md hover:shadow-xl transition-all duration-300 aspect-[4/5]">
	<img src="<?php echo esc_url( $dest['image'] ); ?>" alt="<?php echo esc_attr( $dest['title'] ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">

	<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-6 text-white">
		<span class="text-xs font-semibold uppercase tracking-widest text-champagne mb-1">
			<?php echo esc_html( $dest['country'] ); ?>
		</span>
		<h3 class="text-2xl font-serif font-bold text-white mb-2">
			<?php echo esc_html( $dest['title'] ); ?>
		</h3>
		<p class="text-xs text-sand/80 mb-4 line-clamp-1">
			<?php echo esc_html( $dest['highlights'] ); ?>
		</p>
		<div class="flex items-center justify-between border-t border-white/20 pt-3 text-xs">
			<span class="text-champagne font-semibold"><?php echo esc_html( $dest['safari_count'] ); ?></span>
			<a href="<?php echo esc_url( $dest['permalink'] ); ?>" class="text-white hover:text-champagne flex items-center gap-1 font-semibold">
				<?php esc_html_e( 'View Destination', 'bo-safari-theme' ); ?> &rarr;
			</a>
		</div>
	</div>
</div>
