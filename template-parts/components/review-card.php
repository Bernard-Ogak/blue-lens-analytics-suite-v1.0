<?php
/**
 * Review Card Component
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $review_data;
$review = $review_data ?: array(
	'author'   => 'Eleanor Harrington',
	'country'  => 'United Kingdom',
	'tour'     => 'Grand East Africa Odyssey',
	'rating'   => 5,
	'platform' => 'TripAdvisor',
	'date'     => 'February 2026',
	'text'     => 'An extraordinary experience from start to finish. The attention to detail, private transfers, and lodge selections were unmatched.',
	'avatar'   => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
);
?>

<div class="review-card bg-ivory border border-sand p-6 rounded-xl shadow-sm flex flex-col justify-between h-full">
	<div>
		<div class="flex items-center justify-between mb-4">
			<?php bo_safari_render_star_rating( $review['rating'] ); ?>
			<span class="text-xs uppercase font-bold text-champagne bg-champagne/10 px-2.5 py-1 rounded">
				<?php echo esc_html( $review['platform'] ); ?>
			</span>
		</div>
		<p class="text-sm text-charcoal/80 italic mb-6 leading-relaxed">
			"<?php echo esc_html( $review['text'] ); ?>"
		</p>
	</div>
	<div class="flex items-center gap-3 pt-4 border-t border-sand/60">
		<img src="<?php echo esc_url( $review['avatar'] ); ?>" alt="<?php echo esc_attr( $review['author'] ); ?>" class="w-10 h-10 rounded-full object-cover">
		<div>
			<h4 class="text-sm font-bold text-safari-green leading-tight"><?php echo esc_html( $review['author'] ); ?></h4>
			<span class="text-xs text-charcoal/60"><?php echo esc_html( $review['country'] ); ?> &bull; <?php echo esc_html( $review['tour'] ); ?></span>
		</div>
	</div>
</div>
