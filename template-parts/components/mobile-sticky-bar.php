<?php
/**
 * Mobile Sticky Bar Component
 *
 * Sticky bottom action bar for mobile devices: WhatsApp | Call | Enquire
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone    = get_option( 'bo_safari_phone', '+254700123456' );
$whatsapp = get_option( 'bo_safari_whatsapp', '+254700000000' );
$message  = rawurlencode( __( 'Hello! I am viewing your safari website and would like to speak to an agent.', 'bo-safari-theme' ) );
$wa_url   = "https://wa.me/{$whatsapp}?text={$message}";
?>

<div class="mobile-sticky-bar md:hidden">
	<a href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener" class="flex-1 btn-whatsapp text-xs py-2 px-3 justify-center" data-source="mobile_sticky_bar">
		<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
		<span>WhatsApp</span>
	</a>

	<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="btn-outline flex-1 text-xs py-2 px-3 text-center justify-center">
		<?php esc_html_e( 'Call Us', 'bo-safari-theme' ); ?>
	</a>

	<a href="#" class="btn-primary flex-1 text-xs py-2 px-3 text-center justify-center" data-open-enquiry-modal="true">
		<?php esc_html_e( 'Enquire', 'bo-safari-theme' ); ?>
	</a>
</div>
