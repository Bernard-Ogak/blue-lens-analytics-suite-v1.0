<?php
/**
 * The Footer for B.O-Safari-theme
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	</main><!-- #primary-content -->

	<?php get_template_part( 'template-parts/footer/site-footer' ); ?>

	<?php get_template_part( 'template-parts/components/mobile-sticky-bar' ); ?>

	<?php get_template_part( 'template-parts/components/enquiry-modal' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
