<?php
/**
 * Travel Inspiration Section Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$query = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
	)
);
?>

<section class="travel-inspiration-section py-20 bg-ivory">
	<div class="site-container">
		<div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-12 gap-4">
			<div>
				<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Journal & Guides', 'bo-safari-theme' ); ?></span>
				<h2 class="text-3xl lg:text-4xl font-serif text-safari-green font-bold">
					<?php esc_html_e( 'African Travel Inspiration', 'bo-safari-theme' ); ?>
				</h2>
			</div>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/journal' ) ); ?>" class="text-xs font-semibold uppercase tracking-wider text-safari-green hover:text-champagne flex items-center gap-1">
				<?php esc_html_e( 'Read All Stories', 'bo-safari-theme' ); ?> &rarr;
			</a>
		</div>

		<?php if ( $query->have_posts() ) : ?>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					get_template_part( 'template-parts/blog/content-card' );
				}
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<?php get_template_part( 'template-parts/blog/content-none' ); ?>
		<?php endif; ?>
	</div>
</section>
