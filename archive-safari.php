<?php
/**
 * Archive Safari Template
 *
 * @package B.O-Safari-theme
 */

get_header();

$safaris = bo_safari_get_safaris( array( 'posts_per_page' => 12 ) );
?>

<div class="archive-safari-hero py-16 bg-ivory border-b border-sand text-center">
	<div class="site-container max-w-3xl">
		<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Bespoke Collection', 'bo-safari-theme' ); ?></span>
		<h1 class="text-4xl lg:text-5xl font-serif text-safari-green font-bold mb-3">
			<?php esc_html_e( 'Luxury African Safaris', 'bo-safari-theme' ); ?>
		</h1>
		<p class="text-charcoal/80 text-sm">
			<?php esc_html_e( 'Explore our handpicked collection of luxury wilderness expeditions across Kenya, Tanzania, Rwanda, and Uganda.', 'bo-safari-theme' ); ?>
		</p>
	</div>
</div>

<div class="site-container py-12">
	<!-- Filter Bar -->
	<div class="bg-white p-6 rounded-xl border border-sand mb-12 shadow-sm">
		<form method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-center">
			<div>
				<label class="block text-xs uppercase font-semibold text-charcoal/60 mb-1"><?php esc_html_e( 'Destination', 'bo-safari-theme' ); ?></label>
				<select name="destination" class="w-full p-2.5 bg-sand-light border border-sand rounded text-xs">
					<option value=""><?php esc_html_e( 'All Destinations', 'bo-safari-theme' ); ?></option>
					<option value="kenya">Kenya</option>
					<option value="tanzania">Tanzania</option>
					<option value="rwanda">Rwanda</option>
					<option value="uganda">Uganda</option>
				</select>
			</div>
			<div>
				<label class="block text-xs uppercase font-semibold text-charcoal/60 mb-1"><?php esc_html_e( 'Duration', 'bo-safari-theme' ); ?></label>
				<select name="duration" class="w-full p-2.5 bg-sand-light border border-sand rounded text-xs">
					<option value=""><?php esc_html_e( 'Any Duration', 'bo-safari-theme' ); ?></option>
					<option value="1-6">1 - 6 Days</option>
					<option value="7-10">7 - 10 Days</option>
					<option value="11+">11+ Days</option>
				</select>
			</div>
			<div>
				<label class="block text-xs uppercase font-semibold text-charcoal/60 mb-1"><?php esc_html_e( 'Style', 'bo-safari-theme' ); ?></label>
				<select name="style" class="w-full p-2.5 bg-sand-light border border-sand rounded text-xs">
					<option value=""><?php esc_html_e( 'All Styles', 'bo-safari-theme' ); ?></option>
					<option value="luxury">Luxury Fly-In</option>
					<option value="family">Private Family</option>
					<option value="honeymoon">Honeymoon</option>
				</select>
			</div>
			<div>
				<button type="submit" class="btn-primary w-full py-3 text-xs font-bold uppercase tracking-wider mt-4 sm:mt-0">
					<?php esc_html_e( 'Filter Safaris', 'bo-safari-theme' ); ?>
				</button>
			</div>
		</form>
	</div>

	<!-- Safaris Grid -->
	<?php if ( ! empty( $safaris ) ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			foreach ( $safaris as $safari ) {
				$GLOBALS['safari_data'] = $safari;
				get_template_part( 'template-parts/components/safari-card' );
			}
			unset( $GLOBALS['safari_data'] );
			?>
		</div>
	<?php else : ?>
		<div class="text-center py-12 bg-white rounded-xl border border-sand p-8">
			<h3 class="text-xl font-serif font-bold text-safari-green mb-2"><?php esc_html_e( 'No safaris matched your query.', 'bo-safari-theme' ); ?></h3>
			<p class="text-xs text-charcoal/70 mb-4"><?php esc_html_e( 'Try clearing your filters or contact our concierge for a custom route.', 'bo-safari-theme' ); ?></p>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'safari' ) ); ?>" class="btn-primary text-xs"><?php esc_html_e( 'Reset Filters', 'bo-safari-theme' ); ?></a>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
