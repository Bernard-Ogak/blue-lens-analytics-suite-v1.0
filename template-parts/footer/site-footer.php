<?php
/**
 * Site Footer Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone = get_option( 'bo_safari_phone', '+254 (0) 700 123 456' );
$email = get_option( 'bo_safari_email', 'concierge@bo-safari.com' );
?>

<footer class="site-footer bg-safari-green text-white pt-16 pb-12 border-t-4 border-champagne">
	<div class="site-container">

		<!-- Footer Grid -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

			<!-- Column 1: Brand -->
			<div class="footer-col-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-2xl font-serif font-bold text-white tracking-wide block mb-4">
					B.O SAFARI<span class="text-champagne">.</span>
				</a>
				<p class="text-sand/80 text-sm leading-relaxed mb-6">
					<?php esc_html_e( 'Handcrafted bespoke African luxury safaris, fly-in wilderness expeditions, and conservation-led journeys in Kenya, Tanzania, Rwanda, and Uganda.', 'bo-safari-theme' ); ?>
				</p>
				<div class="contact-info flex flex-col gap-2 text-sm text-sand">
					<p><strong><?php esc_html_e( 'Concierge:', 'bo-safari-theme' ); ?></strong> <?php echo esc_html( $phone ); ?></p>
					<p><strong><?php esc_html_e( 'Email:', 'bo-safari-theme' ); ?></strong> <?php echo esc_html( $email ); ?></p>
				</div>
			</div>

			<!-- Column 2: Quick Links -->
			<div class="footer-col-nav">
				<h4 class="text-champagne text-sm font-sans font-semibold uppercase tracking-widest mb-4">
					<?php esc_html_e( 'Destinations', 'bo-safari-theme' ); ?>
				</h4>
				<ul class="flex flex-col gap-2 text-sm text-sand/80 list-none">
					<li><a href="#" class="hover:text-champagne transition-colors"><?php esc_html_e( 'Serengeti National Park', 'bo-safari-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-champagne transition-colors"><?php esc_html_e( 'Masai Mara National Reserve', 'bo-safari-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-champagne transition-colors"><?php esc_html_e( 'Volcanoes National Park', 'bo-safari-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-champagne transition-colors"><?php esc_html_e( 'Ngorongoro Conservation Area', 'bo-safari-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-champagne transition-colors"><?php esc_html_e( 'Amboseli & Kilimanjaro', 'bo-safari-theme' ); ?></a></li>
				</ul>
			</div>

			<!-- Column 3: Safaris -->
			<div class="footer-col-nav">
				<h4 class="text-champagne text-sm font-sans font-semibold uppercase tracking-widest mb-4">
					<?php esc_html_e( 'Travel Styles', 'bo-safari-theme' ); ?>
				</h4>
				<ul class="flex flex-col gap-2 text-sm text-sand/80 list-none">
					<li><a href="#" class="hover:text-champagne transition-colors"><?php esc_html_e( 'Luxury Fly-In Safaris', 'bo-safari-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-champagne transition-colors"><?php esc_html_e( 'Private Family Safaris', 'bo-safari-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-champagne transition-colors"><?php esc_html_e( 'Honeymoon & Romantic Escapes', 'bo-safari-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-champagne transition-colors"><?php esc_html_e( 'Gorilla Trekking Expeditions', 'bo-safari-theme' ); ?></a></li>
					<li><a href="#" class="hover:text-champagne transition-colors"><?php esc_html_e( 'Photographic Safaris', 'bo-safari-theme' ); ?></a></li>
				</ul>
			</div>

			<!-- Column 4: Newsletter -->
			<div class="footer-col-newsletter">
				<h4 class="text-champagne text-sm font-sans font-semibold uppercase tracking-widest mb-4">
					<?php esc_html_e( 'Safari Inspiration', 'bo-safari-theme' ); ?>
				</h4>
				<p class="text-sand/80 text-sm mb-4">
					<?php esc_html_e( 'Subscribe to receive our seasonal migration updates and exclusive luxury lodge offers.', 'bo-safari-theme' ); ?>
				</p>
				<form class="newsletter-footer-form flex flex-col gap-2">
					<input type="email" placeholder="<?php esc_attr_e( 'Your Email Address', 'bo-safari-theme' ); ?>" class="p-3 bg-white/10 text-white placeholder-sand/50 rounded border border-sand/20 focus:outline-none focus:border-champagne text-sm" required>
					<button type="submit" class="btn-primary w-full text-xs py-3">
						<?php esc_html_e( 'Subscribe', 'bo-safari-theme' ); ?>
					</button>
				</form>
			</div>

		</div>

		<!-- Footer Bottom Credit -->
		<div class="footer-bottom border-t border-sand/20 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-sand/60">
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All Rights Reserved. Handcrafted by Bernard Ogak.', 'bo-safari-theme' ); ?></p>
			<div class="flex gap-6">
				<a href="#" class="hover:text-champagne"><?php esc_html_e( 'Privacy Policy', 'bo-safari-theme' ); ?></a>
				<a href="#" class="hover:text-champagne"><?php esc_html_e( 'Terms of Service', 'bo-safari-theme' ); ?></a>
				<a href="#" class="hover:text-champagne"><?php esc_html_e( 'Safety & Sustainability', 'bo-safari-theme' ); ?></a>
			</div>
		</div>

	</div>
</footer>
