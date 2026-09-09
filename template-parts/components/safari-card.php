<?php
/**
 * Safari Card Component
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $safari_data;
$safari = $safari_data ?: array(
	'title'        => get_the_title(),
	'permalink'    => get_permalink(),
	'thumbnail'    => get_the_post_thumbnail_url( get_the_ID(), 'safari-card' ),
	'destination'  => get_post_meta( get_the_ID(), '_safari_destination', true ) ?: 'Serengeti & Masai Mara',
	'duration'     => get_post_meta( get_the_ID(), '_safari_duration', true ) ?: '7 Days / 6 Nights',
	'price'        => get_post_meta( get_the_ID(), '_safari_price', true ) ?: '3,850',
	'currency'     => 'USD',
	'rating'       => '4.95',
	'review_count' => '128',
	'style'        => 'Luxury Private',
	'badge'        => 'Featured',
	'excerpt'      => get_the_excerpt(),
);
?>

<div class="card-safari group">
	<div class="card-safari-image">
		<?php if ( ! empty( $safari['badge'] ) ) : ?>
			<span class="card-safari-badge badge-gold">
				<?php echo esc_html( $safari['badge'] ); ?>
			</span>
		<?php endif; ?>
		<img src="<?php echo esc_url( $safari['thumbnail'] ?: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=800&q=80' ); ?>" alt="<?php echo esc_attr( $safari['title'] ); ?>" loading="lazy" width="800" height="600">
	</div>

	<div class="card-safari-content">
		<div class="card-safari-meta">
			<span class="flex items-center gap-1 font-semibold text-safari-green">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
				<?php echo esc_html( $safari['duration'] ); ?>
			</span>
			<span>&bull;</span>
			<span><?php echo esc_html( $safari['destination'] ); ?></span>
		</div>

		<h3 class="card-safari-title text-xl font-serif font-bold text-safari-green group-hover:text-champagne transition-colors">
			<a href="<?php echo esc_url( $safari['permalink'] ); ?>">
				<?php echo esc_html( $safari['title'] ); ?>
			</a>
		</h3>

		<p class="text-xs text-charcoal/70 line-clamp-2 mb-4">
			<?php echo esc_html( $safari['excerpt'] ); ?>
		</p>

		<div class="flex items-center gap-2 mb-4">
			<?php bo_safari_render_star_rating( $safari['rating'] ); ?>
			<span class="text-xs text-charcoal/60 font-semibold">(<?php echo esc_html( $safari['review_count'] ); ?> <?php esc_html_e( 'reviews', 'bo-safari-theme' ); ?>)</span>
		</div>

		<div class="card-safari-footer">
			<?php bo_safari_render_price_display( $safari['price'], $safari['currency'] ); ?>
			<a href="<?php echo esc_url( $safari['permalink'] ); ?>" class="btn-outline text-xs py-2 px-4">
				<?php esc_html_e( 'Explore', 'bo-safari-theme' ); ?>
			</a>
		</div>
	</div>
</div>
