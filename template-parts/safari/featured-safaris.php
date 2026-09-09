<?php
/**
 * Featured Safaris Section Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$safaris = bo_safari_get_safaris( array( 'posts_per_page' => 3 ) );
?>

<section class="featured-safaris-section py-20 bg-ivory">
	<div class="site-container">
		<div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-12 gap-4">
			<div>
				<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Handcrafted Journeys', 'bo-safari-theme' ); ?></span>
				<h2 class="text-3xl lg:text-4xl font-serif text-safari-green font-bold">
					<?php esc_html_e( 'Featured Luxury Safaris', 'bo-safari-theme' ); ?>
				</h2>
			</div>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'safari' ) ? get_post_type_archive_link( 'safari' ) : home_url( '/safaris' ) ); ?>" class="text-xs font-semibold uppercase tracking-wider text-safari-green hover:text-champagne flex items-center gap-1">
				<?php esc_html_e( 'View All Safaris', 'bo-safari-theme' ); ?> &rarr;
			</a>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			foreach ( $safaris as $safari ) {
				$GLOBALS['safari_data'] = $safari;
				get_template_part( 'template-parts/components/safari-card' );
			}
			unset( $GLOBALS['safari_data'] );
			?>
		</div>
	</div>
</section>
