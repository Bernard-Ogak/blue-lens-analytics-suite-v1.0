<?php
/**
 * Archive Accommodation Template
 *
 * @package B.O-Safari-theme
 */

get_header();

$accommodations = bo_safari_get_accommodations();
?>

<div class="archive-acc-hero py-16 bg-ivory border-b border-sand text-center">
	<div class="site-container max-w-3xl">
		<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Luxury Lodging', 'bo-safari-theme' ); ?></span>
		<h1 class="text-4xl lg:text-5xl font-serif text-safari-green font-bold mb-3">
			<?php esc_html_e( 'African Safari Camps & Lodges', 'bo-safari-theme' ); ?>
		</h1>
	</div>
</div>

<div class="site-container py-12">
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

<?php
get_footer();
