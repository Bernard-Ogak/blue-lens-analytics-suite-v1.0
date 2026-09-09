<?php
/**
 * Archive Experience Template
 *
 * @package B.O-Safari-theme
 */

get_header();

$experiences = bo_safari_get_experiences();
?>

<div class="archive-exp-hero py-16 bg-ivory border-b border-sand text-center">
	<div class="site-container max-w-3xl">
		<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Bespoke Activities', 'bo-safari-theme' ); ?></span>
		<h1 class="text-4xl lg:text-5xl font-serif text-safari-green font-bold mb-3">
			<?php esc_html_e( 'Signature African Experiences', 'bo-safari-theme' ); ?>
		</h1>
	</div>
</div>

<div class="site-container py-12">
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
		<?php
		foreach ( $experiences as $exp ) {
			$GLOBALS['experience_data'] = $exp;
			get_template_part( 'template-parts/components/experience-card' );
		}
		unset( $GLOBALS['experience_data'] );
		?>
	</div>
</div>

<?php
get_footer();
