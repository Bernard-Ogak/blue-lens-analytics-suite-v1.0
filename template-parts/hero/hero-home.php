<?php
/**
 * Hero Home Section Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="hero-home relative min-h-[85vh] flex items-center justify-center bg-safari-green text-white overflow-hidden py-24">
	<!-- Background Image Overlay -->
	<div class="absolute inset-0 z-0">
		<img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1920&q=80" alt="African Safari Wilderness" class="w-full h-full object-cover opacity-45">
		<div class="absolute inset-0 bg-gradient-to-t from-safari-green via-transparent to-black/40"></div>
	</div>

	<div class="site-container relative z-10 text-center max-w-4xl mx-auto px-4">
		<span class="badge-gold mb-4 inline-block text-xs uppercase tracking-widest font-semibold">
			<?php esc_html_e( 'Bespoke African Safaris & Wilderness Journeys', 'bo-safari-theme' ); ?>
		</span>

		<h1 class="text-4xl md:text-6xl lg:text-7xl font-serif font-extrabold text-white mb-6 leading-tight">
			<?php esc_html_e( 'Discover Africa, Beautifully', 'bo-safari-theme' ); ?>
		</h1>

		<p class="text-lg md:text-2xl text-sand font-light mb-10 max-w-2xl mx-auto leading-relaxed">
			<?php esc_html_e( 'Private journeys. Extraordinary wildlife encounters. Unforgettable memories.', 'bo-safari-theme' ); ?>
		</p>

		<div class="flex flex-wrap items-center justify-center gap-4 mb-12">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'safari' ) ? get_post_type_archive_link( 'safari' ) : home_url( '/safaris' ) ); ?>" class="btn-primary text-sm py-4 px-8">
				<?php esc_html_e( 'Explore Safaris', 'bo-safari-theme' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/build-your-safari' ) ); ?>" class="btn-outline py-4 px-8 text-sm text-white border-white hover:bg-white hover:text-safari-green">
				<?php esc_html_e( 'Plan Your Journey', 'bo-safari-theme' ); ?>
			</a>
		</div>

		<!-- Quick Safari Filter Bar -->
		<div class="hero-search-bar bg-white/95 backdrop-blur-md p-4 lg:p-6 rounded-2xl shadow-2xl text-charcoal max-w-3xl mx-auto border border-sand">
			<form action="<?php echo esc_url( get_post_type_archive_link( 'safari' ) ? get_post_type_archive_link( 'safari' ) : home_url( '/safaris' ) ); ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/60 text-left mb-1"><?php esc_html_e( 'Destination', 'bo-safari-theme' ); ?></label>
					<select name="destination" class="w-full p-2.5 bg-sand-light border border-sand rounded text-sm text-charcoal">
						<option value=""><?php esc_html_e( 'All Destinations', 'bo-safari-theme' ); ?></option>
						<option value="kenya"><?php esc_html_e( 'Kenya', 'bo-safari-theme' ); ?></option>
						<option value="tanzania"><?php esc_html_e( 'Tanzania', 'bo-safari-theme' ); ?></option>
						<option value="rwanda"><?php esc_html_e( 'Rwanda', 'bo-safari-theme' ); ?></option>
						<option value="uganda"><?php esc_html_e( 'Uganda', 'bo-safari-theme' ); ?></option>
					</select>
				</div>

				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/60 text-left mb-1"><?php esc_html_e( 'Travel Style', 'bo-safari-theme' ); ?></label>
					<select name="travel_style" class="w-full p-2.5 bg-sand-light border border-sand rounded text-sm text-charcoal">
						<option value=""><?php esc_html_e( 'All Travel Styles', 'bo-safari-theme' ); ?></option>
						<option value="luxury"><?php esc_html_e( 'Luxury Fly-In', 'bo-safari-theme' ); ?></option>
						<option value="private"><?php esc_html_e( 'Private Family', 'bo-safari-theme' ); ?></option>
						<option value="honeymoon"><?php esc_html_e( 'Honeymoon & Romantic', 'bo-safari-theme' ); ?></option>
						<option value="gorilla"><?php esc_html_e( 'Gorilla Trekking', 'bo-safari-theme' ); ?></option>
					</select>
				</div>

				<div>
					<button type="submit" class="btn-primary w-full py-3 mt-4 sm:mt-0 text-xs font-bold uppercase tracking-wider">
						<?php esc_html_e( 'Find Safaris', 'bo-safari-theme' ); ?>
					</button>
				</div>
			</form>
		</div>

	</div>
</section>
