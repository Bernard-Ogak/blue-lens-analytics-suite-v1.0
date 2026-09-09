<?php
/**
 * The Front Page template
 *
 * @package B.O-Safari-theme
 */

get_header();
?>

<div class="homepage-wrapper">
	<?php get_template_part( 'template-parts/hero/hero-home' ); ?>
	<?php get_template_part( 'template-parts/components/trust-bar' ); ?>
	<?php get_template_part( 'template-parts/safari/featured-safaris' ); ?>
	<?php get_template_part( 'template-parts/components/why-travel-with-us' ); ?>
	<?php get_template_part( 'template-parts/destination/popular-destinations' ); ?>
	<?php get_template_part( 'template-parts/experience/signature-experiences' ); ?>
	<?php get_template_part( 'template-parts/accommodation/luxury-accommodation' ); ?>
	<?php get_template_part( 'template-parts/components/custom-builder-banner' ); ?>
	<?php get_template_part( 'template-parts/reviews/traveller-reviews-home' ); ?>
	<?php get_template_part( 'template-parts/reviews/external-platforms' ); ?>
	<?php get_template_part( 'template-parts/blog/travel-inspiration' ); ?>
	<?php get_template_part( 'template-parts/components/newsletter-section' ); ?>
	<?php get_template_part( 'template-parts/components/cta-section' ); ?>
</div>

<?php
get_footer();
