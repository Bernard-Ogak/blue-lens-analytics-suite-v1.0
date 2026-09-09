<?php
/**
 * Single Accommodation Template
 *
 * @package B.O-Safari-theme
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<div class="single-acc-hero py-20 bg-safari-green text-white relative">
		<div class="site-container max-w-4xl text-center relative z-10">
			<span class="badge-gold mb-3 inline-block"><?php esc_html_e( 'Luxury Wilderness Sanctuary', 'bo-safari-theme' ); ?></span>
			<h1 class="text-4xl lg:text-6xl font-serif font-bold text-white mb-4"><?php the_title(); ?></h1>
		</div>
	</div>

	<div class="site-container py-16 max-w-4xl">
		<div class="prose max-w-none text-charcoal/80 leading-relaxed mb-12">
			<?php the_content(); ?>
		</div>
	</div>

<?php endwhile; ?>

<?php
get_footer();
