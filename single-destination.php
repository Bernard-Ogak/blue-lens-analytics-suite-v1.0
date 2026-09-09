<?php
/**
 * Single Destination Template
 *
 * @package B.O-Safari-theme
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<div class="single-dest-hero py-20 bg-safari-green text-white relative">
		<div class="site-container max-w-4xl text-center relative z-10">
			<span class="badge-gold mb-3 inline-block"><?php esc_html_e( 'Wilderness Destination', 'bo-safari-theme' ); ?></span>
			<h1 class="text-4xl lg:text-6xl font-serif font-bold text-white mb-4"><?php the_title(); ?></h1>
			<p class="text-sand/90 text-lg"><?php echo esc_html( get_the_excerpt() ); ?></p>
		</div>
	</div>

	<div class="site-container py-16 max-w-4xl">
		<div class="prose max-w-none text-charcoal/80 leading-relaxed mb-12">
			<?php the_content(); ?>
		</div>

		<!-- Featured Safaris in Destination -->
		<h2 class="text-2xl font-serif font-bold text-safari-green mb-6"><?php esc_html_e( 'Safaris Visiting This Destination', 'bo-safari-theme' ); ?></h2>
		<?php get_template_part( 'template-parts/safari/featured-safaris' ); ?>
	</div>

<?php endwhile; ?>

<?php
get_footer();
