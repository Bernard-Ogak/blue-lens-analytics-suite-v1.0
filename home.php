<?php
/**
 * The Home (Blog Index) template
 *
 * @package B.O-Safari-theme
 */

get_header();
?>

<div class="blog-hero py-16 bg-sand-light text-center border-b border-sand">
	<div class="site-container">
		<span class="badge-gold uppercase tracking-widest text-xs font-semibold mb-2 inline-block">
			<?php esc_html_e( 'Travel Guide & Journal', 'bo-safari-theme' ); ?>
		</span>
		<h1 class="text-4xl lg:text-5xl font-serif text-safari-green font-bold mb-4">
			<?php single_post_title(); ?>
		</h1>
		<p class="text-charcoal/80 max-w-2xl mx-auto text-lg">
			<?php esc_html_e( 'Discover African travel advice, safari planning guides, wildlife photography tips, and lodge spotlights.', 'bo-safari-theme' ); ?>
		</p>
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

		<div class="pagination-container mt-12 flex justify-center">
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
