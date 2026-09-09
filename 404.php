<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package B.O-Safari-theme
 */

get_header();
?>

<div class="error-404-wrapper py-20 bg-ivory min-h-[60vh] flex items-center justify-center text-center">
	<div class="site-container max-w-2xl mx-auto px-4">
		<span class="text-7xl md:text-9xl font-serif font-bold text-champagne/40 block mb-2">404</span>
		<h1 class="text-3xl md:text-5xl font-serif text-safari-green font-bold mb-4">
			<?php esc_html_e( "You've wandered off the safari trail.", 'bo-safari-theme' ); ?>
		</h1>
		<p class="text-charcoal/80 text-lg mb-8 leading-relaxed">
			<?php esc_html_e( 'The page or journey you are looking for does not exist or may have moved. Let us guide you back to civilization or your next adventure.', 'bo-safari-theme' ); ?>
		</p>

		<div class="flex flex-wrap items-center justify-center gap-4">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'safari' ) ? get_post_type_archive_link( 'safari' ) : home_url( '/safaris' ) ); ?>" class="btn-primary py-3 px-8 text-base">
				<?php esc_html_e( 'Explore Safaris', 'bo-safari-theme' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-outline py-3 px-8 text-base">
				<?php esc_html_e( 'Return Home', 'bo-safari-theme' ); ?>
			</a>
		</div>
	</div>
</div>

<?php
get_footer();
