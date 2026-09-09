<?php
/**
 * Archive Destination Template
 *
 * @package B.O-Safari-theme
 */

get_header();

$destinations = bo_safari_get_destinations( 12 );
?>

<div class="archive-dest-hero py-16 bg-ivory border-b border-sand text-center">
	<div class="site-container max-w-3xl">
		<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Iconic Destinations', 'bo-safari-theme' ); ?></span>
		<h1 class="text-4xl lg:text-5xl font-serif text-safari-green font-bold mb-3">
			<?php esc_html_e( 'African Wildlife Destinations', 'bo-safari-theme' ); ?>
		</h1>
		<p class="text-charcoal/80 text-sm">
			<?php esc_html_e( 'Discover premier national parks, private conservancies, and wilderness reserves.', 'bo-safari-theme' ); ?>
		</p>
	</div>
</div>

<div class="site-container py-12">
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

<?php
get_footer();
