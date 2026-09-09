<?php
/**
 * Popular Destinations Section Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$destinations = bo_safari_get_destinations( 6 );
?>

<section class="popular-destinations-section py-20 bg-sand-light border-y border-sand">
	<div class="site-container">
		<div class="text-center max-w-2xl mx-auto mb-12">
			<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Iconic Wilderness', 'bo-safari-theme' ); ?></span>
			<h2 class="text-3xl lg:text-4xl font-serif text-safari-green font-bold mb-3">
				<?php esc_html_e( 'Explore African Destinations', 'bo-safari-theme' ); ?>
			</h2>
			<p class="text-charcoal/80 text-sm">
				<?php esc_html_e( 'From the infinite plains of Serengeti to the misty peaks of Volcanoes National Park.', 'bo-safari-theme' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			foreach ( $destinations as $dest ) {
				$GLOBALS['destination_data'] = $dest;
				get_template_part( 'template-parts/components/destination-card' );
			}
			unset( $GLOBALS['destination_data'] );
			?>
		</div>
	</div>
</section>
