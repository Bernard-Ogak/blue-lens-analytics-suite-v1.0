<?php
/**
 * Blog Content Card Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white border border-sand rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="aspect-[16/10] overflow-hidden block">
			<?php the_post_thumbnail( 'safari-card', array( 'class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-500' ) ); ?>
		</a>
	<?php endif; ?>

	<div class="p-6 flex flex-col flex-1">
		<div class="text-xs uppercase font-semibold text-champagne mb-2">
			<?php the_category( ', ' ); ?>
		</div>

		<h3 class="text-xl font-serif font-bold text-safari-green mb-3 leading-snug hover:text-champagne transition-colors">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<p class="text-xs text-charcoal/70 mb-4 line-clamp-3 flex-1">
			<?php echo esc_html( get_the_excerpt() ); ?>
		</p>

		<div class="flex items-center justify-between pt-4 border-t border-sand-light text-xs text-charcoal/60">
			<span><?php echo esc_html( get_the_date() ); ?></span>
			<a href="<?php the_permalink(); ?>" class="font-semibold text-safari-green hover:text-champagne">
				<?php esc_html_e( 'Read Journal', 'bo-safari-theme' ); ?> &rarr;
			</a>
		</div>
	</div>
</article>
