<?php
/**
 * The template for displaying search results
 *
 * @package B.O-Safari-theme
 */

get_header();
?>

<div class="search-header-section py-12 bg-ivory text-center border-b border-sand">
	<div class="site-container max-w-3xl">
		<h1 class="page-title text-3xl md:text-4xl font-serif text-safari-green font-bold mb-4">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'bo-safari-theme' ), '<span class="text-champagne font-italic">"' . get_search_query() . '"</span>' );
			?>
		</h1>
		<div class="search-bar-wrapper max-w-xl mx-auto">
			<?php get_search_form(); ?>
		</div>
	</div>
</div>

<div class="site-container py-12">
	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while ( have_posts() ) :
				the_post();
				if ( 'safari' === get_post_type() ) {
					get_template_part( 'template-parts/components/safari-card' );
				} elseif ( 'destination' === get_post_type() ) {
					get_template_part( 'template-parts/components/destination-card' );
				} elseif ( 'accommodation' === get_post_type() ) {
					get_template_part( 'template-parts/components/accommodation-card' );
				} else {
					get_template_part( 'template-parts/blog/content-card' );
				}
			endwhile;
			?>
		</div>

		<div class="pagination-wrapper mt-12 flex justify-center">
			<?php the_posts_pagination(); ?>
		</div>
	<?php else : ?>
		<div class="no-results-box text-center py-16 bg-white rounded-xl shadow-sm border border-sand max-w-2xl mx-auto p-8">
			<svg class="w-16 h-16 text-champagne mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
			</svg>
			<h2 class="text-2xl font-serif text-safari-green font-bold mb-2">
				<?php esc_html_e( 'No safaris or stories matched your search.', 'bo-safari-theme' ); ?>
			</h2>
			<p class="text-charcoal/80 mb-6">
				<?php esc_html_e( 'Try checking for spelling errors, using different keywords, or explore our handpicked safari collection.', 'bo-safari-theme' ); ?>
			</p>
			<div class="flex flex-wrap gap-4 justify-center">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'safari' ) ? get_post_type_archive_link( 'safari' ) : home_url( '/safaris' ) ); ?>" class="btn-primary">
					<?php esc_html_e( 'Explore All Safaris', 'bo-safari-theme' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-secondary">
					<?php esc_html_e( 'Return Home', 'bo-safari-theme' ); ?>
				</a>
			</div>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
