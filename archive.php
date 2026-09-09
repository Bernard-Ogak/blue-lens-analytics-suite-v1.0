<?php
/**
 * The template for displaying archive pages
 *
 * @package B.O-Safari-theme
 */

get_header();
?>

<div class="archive-hero py-12 bg-ivory text-center border-b border-sand">
	<div class="site-container">
		<?php the_archive_title( '<h1 class="page-title text-3xl md:text-4xl font-serif text-safari-green font-bold">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="archive-description text-charcoal/80 max-w-2xl mx-auto mt-2">', '</div>' ); ?>
	</div>
</div>

<div class="site-container py-12">
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
