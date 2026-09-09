<?php
/**
 * Site Header Template Part
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone    = get_option( 'bo_safari_phone', '+254 (0) 700 123 456' );
$whatsapp = get_option( 'bo_safari_whatsapp', '+254700000000' );
?>

<header class="site-header" id="masthead">
	<div class="site-container header-container">

		<!-- Branding / Logo -->
		<div class="site-branding flex items-center">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-text" rel="home">
					B.O SAFARI<span class="text-champagne">.</span>
				</a>
			<?php endif; ?>
		</div>

		<!-- Primary Desktop Navigation -->
		<nav class="primary-navigation hidden lg:block" aria-label="<?php esc_attr_e( 'Primary Menu', 'bo-safari-theme' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_class'     => 'primary-menu-list flex gap-8 items-center list-none',
						'container'      => false,
						'walker'         => new BO_Safari_Nav_Walker(),
					)
				);
			} else {
				bo_safari_primary_nav_fallback();
			}
			?>
		</nav>

		<!-- Action CTA & Mobile Toggle -->
		<div class="header-actions">
			<a href="#" class="btn-primary text-xs tracking-widest hidden sm:inline-flex" data-open-enquiry-modal="true">
				<?php esc_html_e( 'Plan Your Safari', 'bo-safari-theme' ); ?>
			</a>

			<button class="mobile-menu-toggle lg:hidden p-2 text-safari-green hover:text-champagne focus:outline-none" aria-label="<?php esc_attr_e( 'Open Navigation Menu', 'bo-safari-theme' ); ?>">
				<svg class="w-7 h-7 fill-current" viewBox="0 0 24 24">
					<path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
				</svg>
			</button>
		</div>

	</div>
</header>

<!-- Mobile Navigation Drawer -->
<div class="drawer-overlay"></div>
<div class="mobile-drawer">
	<div class="flex items-center justify-between pb-6 border-b border-sand mb-6">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-text text-xl">
			B.O SAFARI<span class="text-champagne">.</span>
		</a>
		<button class="mobile-drawer-close text-charcoal p-2 focus:outline-none" aria-label="<?php esc_attr_e( 'Close Menu', 'bo-safari-theme' ); ?>">
			&times;
		</button>
	</div>

	<nav class="mobile-navigation mb-8" aria-label="<?php esc_attr_e( 'Mobile Menu', 'bo-safari-theme' ); ?>">
		<?php
		if ( has_nav_menu( 'mobile' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'mobile',
					'menu_class'     => 'flex flex-col gap-4 text-lg font-serif font-semibold text-safari-green',
					'container'      => false,
				)
			);
		} else {
			bo_safari_primary_nav_fallback();
		}
		?>
	</nav>

	<div class="mobile-drawer-actions pt-6 border-t border-sand flex flex-col gap-4">
		<a href="#" class="btn-primary text-center w-full" data-open-enquiry-modal="true">
			<?php esc_html_e( 'Plan Your Safari', 'bo-safari-theme' ); ?>
		</a>
		<?php bo_safari_render_whatsapp_button( __( 'WhatsApp Concierge', 'bo-safari-theme' ), 'mobile_drawer' ); ?>
	</div>
</div>
