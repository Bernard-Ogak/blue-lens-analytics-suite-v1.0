<?php
/**
 * The main template file
 *
 * @package B.O-Safari-theme
 */

get_header();
?>

<div class="site-container py-12">
	<div class="content-header text-center mb-10">
		<h1 class="page-title text-4xl font-serif text-safari-green dark:text-sand-gold">
			<?php
			if ( is_home() && ! is_front_page() ) {
				single_post_title();
			} else {
				esc_html_e( 'Latest Travel Insights & Safari Stories', 'bo-safari-theme' );
			}
			?>
		</h1>
		<p class="section-subtitle max-w-2xl mx-auto text-charcoal/80 mt-2">
			<?php esc_html_e( 'Expert wildlife guides, destination overviews, and African travel inspiration.', 'bo-safari-theme' ); ?>
		</p>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/blog/content-card' );
			endwhile;
			?>
		</div>

		<div class="pagination-wrapper mt-12 flex justify-center">
			<?php
			the_posts_pagination(
				array(
					'prev_text' => '&larr; ' . esc_html__( 'Previous', 'bo-safari-theme' ),
					'next_text' => esc_html__( 'Next', 'bo-safari-theme' ) . ' &rarr;',
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
