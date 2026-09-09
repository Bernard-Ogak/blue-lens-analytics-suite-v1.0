<?php
/**
 * The template for displaying all single blog posts
 *
 * @package B.O-Safari-theme
 */

get_header();
?>

<div class="single-post-container py-12">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'site-container max-w-4xl mx-auto' ); ?>>
			<header class="entry-header text-center mb-8">
				<div class="entry-meta mb-3 text-sm text-gold-accent uppercase font-medium">
					<?php echo esc_html( get_the_category_list( ', ' ) ); ?>
				</div>
				<h1 class="entry-title text-3xl md:text-5xl font-serif text-safari-green font-bold mb-4">
					<?php the_title(); ?>
				</h1>
				<div class="post-byline flex items-center justify-center gap-4 text-sm text-charcoal/70">
					<span><?php esc_html_e( 'By', 'bo-safari-theme' ); ?> <?php the_author(); ?></span>
					<span>&bull;</span>
					<span><?php echo esc_html( get_the_date() ); ?></span>
					<span>&bull;</span>
					<span><?php echo esc_html( bo_safari_get_reading_time() ); ?> <?php esc_html_e( 'min read', 'bo-safari-theme' ); ?></span>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-featured-image mb-10 rounded-xl overflow-hidden shadow-lg">
					<?php the_post_thumbnail( 'safari-hero', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content prose prose-lg max-w-none text-charcoal leading-relaxed">
				<?php the_content(); ?>
			</div>

			<footer class="entry-footer mt-12 pt-6 border-t border-sand flex flex-wrap justify-between items-center gap-4">
				<div class="post-tags text-sm">
					<?php the_tags( '<span class="font-semibold text-safari-green mr-2">' . esc_html__( 'Tags:', 'bo-safari-theme' ) . '</span>', ' ', '' ); ?>
				</div>
				<div class="social-share flex gap-2">
					<?php bo_safari_render_social_share(); ?>
				</div>
			</footer>
		</article>

		<div class="related-posts-section bg-ivory py-12 mt-16 border-t border-sand">
			<div class="site-container max-w-5xl mx-auto">
				<h3 class="text-2xl font-serif text-safari-green font-bold text-center mb-8">
					<?php esc_html_e( 'More African Travel Stories', 'bo-safari-theme' ); ?>
				</h3>
				<?php bo_safari_render_related_posts(); ?>
			</div>
		</div>

	<?php endwhile; ?>
</div>

<?php
get_footer();
