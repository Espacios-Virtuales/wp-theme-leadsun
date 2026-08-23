<?php
/**
 * Reusable, configuration-backed WhatsApp channel.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a normalized E.164-style WhatsApp number, or an empty value.
 */
function leadsun_whatsapp_number(): string {
	$number = preg_replace( '/\D+/', '', (string) get_option( 'leadsun_whatsapp_number', '' ) );
	$length = strlen( $number );

	return $length >= 7 && $length <= 15 ? $number : '';
}

/**
 * Build the sole WhatsApp URL used throughout the theme.
 */
function leadsun_whatsapp_url( ?string $message = null ): string {
	$number = leadsun_whatsapp_number();
	if ( '' === $number ) {
		return '';
	}

	$message = null === $message ? (string) get_option( 'leadsun_whatsapp_default_message', __( 'Hola, quisiera consultar por un proyecto de iluminación LEADSUN.', 'leadsun' ) ) : $message;
	$message = sanitize_textarea_field( $message );
	$url     = 'https://wa.me/' . $number;

	return '' === $message ? $url : $url . '?text=' . rawurlencode( $message );
}
