<?php
/**
 * The template for displaying all pages
 *
 * @package B.O-Safari-theme
 */

get_header();
?>

<div class="site-page-container py-12">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article site-container max-w-4xl mx-auto' ); ?>>
			<header class="entry-header text-center mb-8">
				<h1 class="entry-title text-3xl lg:text-4xl font-serif text-safari-green font-bold">
					<?php the_title(); ?>
				</h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="page-featured-media mb-8 rounded-lg overflow-hidden shadow-md">
					<?php the_post_thumbnail( 'safari-hero', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content prose max-w-none text-charcoal leading-relaxed">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bo-safari-theme' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
		</article>
	<?php endwhile; ?>
</div>

<?php
get_footer();
