<?php
/**
 * Luxury Accommodation Section Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$accommodations = bo_safari_get_accommodations();
?>

<section class="luxury-accommodation-section py-20 bg-sand-light border-y border-sand">
	<div class="site-container">
		<div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-12 gap-4">
			<div>
				<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Wilderness Sanctuaries', 'bo-safari-theme' ); ?></span>
				<h2 class="text-3xl lg:text-4xl font-serif text-safari-green font-bold">
					<?php esc_html_e( 'Luxury Safari Lodges & Camps', 'bo-safari-theme' ); ?>
				</h2>
			</div>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'accommodation' ) ? get_post_type_archive_link( 'accommodation' ) : home_url( '/accommodation' ) ); ?>" class="text-xs font-semibold uppercase tracking-wider text-safari-green hover:text-champagne flex items-center gap-1">
				<?php esc_html_e( 'View All Lodges', 'bo-safari-theme' ); ?> &rarr;
			</a>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
			<?php
			foreach ( $accommodations as $acc ) {
				$GLOBALS['accommodation_data'] = $acc;
				get_template_part( 'template-parts/components/accommodation-card' );
			}
			unset( $GLOBALS['accommodation_data'] );
			?>
		</div>
	</div>
</section>
