<?php
/**
 * Template Name: Contact Us Page
 *
 * @package B.O-Safari-theme
 */

get_header();

$phone    = get_option( 'bo_safari_phone', '+254 (0) 700 123 456' );
$email    = get_option( 'bo_safari_email', 'concierge@bo-safari.com' );
$whatsapp = get_option( 'bo_safari_whatsapp', '+254700000000' );
?>

<div class="contact-hero py-16 bg-ivory border-b border-sand text-center">
	<div class="site-container max-w-2xl">
		<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Direct Concierge Access', 'bo-safari-theme' ); ?></span>
		<h1 class="text-4xl lg:text-5xl font-serif text-safari-green font-bold mb-4">
			<?php esc_html_e( 'Get in Touch With Our Trip Architects', 'bo-safari-theme' ); ?>
		</h1>
		<p class="text-charcoal/80 text-base">
			<?php esc_html_e( 'Whether you have a quick question about seasonal migration timings or wish to design a grand multi-country expedition, we are at your service.', 'bo-safari-theme' ); ?>
		</p>
	</div>
</div>

<div class="site-container py-16">
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

		<!-- Contact Details Box -->
		<div class="space-y-8 bg-sand-light p-8 rounded-2xl border border-sand">
			<div>
				<h3 class="text-xl font-serif font-bold text-safari-green mb-4"><?php esc_html_e( 'Headquarters', 'bo-safari-theme' ); ?></h3>
				<p class="text-sm text-charcoal/80 leading-relaxed">
					B.O Safari Concierge Tower,<br>
					Karen Road, Nairobi, Kenya
				</p>
			</div>

			<div>
				<h3 class="text-xl font-serif font-bold text-safari-green mb-4"><?php esc_html_e( 'Direct Communication', 'bo-safari-theme' ); ?></h3>
				<ul class="space-y-3 text-sm text-charcoal/80 list-none">
					<li><strong><?php esc_html_e( 'Phone:', 'bo-safari-theme' ); ?></strong> <?php echo esc_html( $phone ); ?></li>
					<li><strong><?php esc_html_e( 'Email:', 'bo-safari-theme' ); ?></strong> <?php echo esc_html( $email ); ?></li>
					<li><strong><?php esc_html_e( 'Hours:', 'bo-safari-theme' ); ?></strong> 24/7 VIP Concierge Support</li>
				</ul>
			</div>

			<div>
				<h3 class="text-xl font-serif font-bold text-safari-green mb-4"><?php esc_html_e( 'Instant WhatsApp', 'bo-safari-theme' ); ?></h3>
				<?php bo_safari_render_whatsapp_button( __( 'Chat Directly via WhatsApp', 'bo-safari-theme' ), 'contact_page' ); ?>
			</div>
		</div>

		<!-- Interactive Contact Form -->
		<div class="lg:col-span-2 bg-white p-8 lg:p-10 rounded-2xl border border-sand shadow-sm">
			<h2 class="text-2xl font-serif font-bold text-safari-green mb-6"><?php esc_html_e( 'Send Us an Online Message', 'bo-safari-theme' ); ?></h2>

			<form class="bo-safari-enquiry-form flex flex-col gap-6">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Full Name *', 'bo-safari-theme' ); ?></label>
						<input type="text" name="full_name" required class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm focus:outline-none focus:border-champagne">
					</div>
					<div>
						<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Email Address *', 'bo-safari-theme' ); ?></label>
						<input type="email" name="email" required class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm focus:outline-none focus:border-champagne">
					</div>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Phone / WhatsApp Number', 'bo-safari-theme' ); ?></label>
						<input type="tel" name="phone" class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm focus:outline-none focus:border-champagne">
					</div>
					<div>
						<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Estimated Travel Dates', 'bo-safari-theme' ); ?></label>
						<input type="text" name="travel_dates" placeholder="e.g. July 2026" class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm focus:outline-none focus:border-champagne">
					</div>
				</div>

				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Your Message / Inquiry Details', 'bo-safari-theme' ); ?></label>
					<textarea name="message" rows="5" class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm focus:outline-none focus:border-champagne" required></textarea>
				</div>

				<div class="form-feedback"></div>

				<button type="submit" class="btn-primary py-4 px-8 text-xs font-bold uppercase tracking-wider">
					<?php esc_html_e( 'Send Message', 'bo-safari-theme' ); ?>
				</button>
			</form>
		</div>

	</div>
</div>

<?php
get_footer();
