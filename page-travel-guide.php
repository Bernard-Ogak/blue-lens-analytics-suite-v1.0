<?php
/**
 * Template Name: Travel Guide & Journal
 *
 * @package B.O-Safari-theme
 */

get_header();

$query = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 9,
		'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
	)
);
?>

<div class="travel-guide-hero py-16 bg-ivory border-b border-sand text-center">
	<div class="site-container max-w-3xl">
		<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Expert Field Insights', 'bo-safari-theme' ); ?></span>
		<h1 class="text-4xl lg:text-5xl font-serif text-safari-green font-bold mb-4">
			<?php esc_html_e( 'African Travel Guide & Field Journal', 'bo-safari-theme' ); ?>
		</h1>
		<p class="text-charcoal/80 text-base">
			<?php esc_html_e( 'In-depth advice on wildlife migration calendars, lodge packing guides, conservation stories, and photography techniques.', 'bo-safari-theme' ); ?>
		</p>
	</div>
</div>

<div class="site-container py-16">
	<?php if ( $query->have_posts() ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
				get_template_part( 'template-parts/blog/content-card' );
			}
			wp_reset_postdata();
			?>
		</div>

		<div class="pagination-wrapper mt-12 flex justify-center">
			<?php
			echo paginate_links(
				array(
					'total'     => $query->max_num_pages,
					'prev_text' => esc_html__( '&larr; Previous', 'bo-safari-theme' ),
					'next_text' => esc_html__( 'Next &rarr;', 'bo-safari-theme' ),
				)
			);
			?>
		</div>
	<?php else : ?>
		<?php get_template_part( 'template-parts/blog/content-none' ); ?>
	<?php endif; ?>
</div>

<?php
get_footer();
