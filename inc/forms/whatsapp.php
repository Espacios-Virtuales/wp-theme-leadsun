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
 * Format the configured WhatsApp number for the visible phone contact channel.
 */
function leadsun_contact_phone_display(): string {
	$number = leadsun_whatsapp_number();

	if ( preg_match( '/^569(\d{4})(\d{4})$/', $number, $matches ) ) {
		return sprintf( '+56 9 %s %s', $matches[1], $matches[2] );
	}

	return '' === $number ? '' : '+' . $number;
}

/**
 * Build the telephone URL from the configured WhatsApp number.
 */
function leadsun_contact_phone_url(): string {
	$number = leadsun_whatsapp_number();

	return '' === $number ? '' : 'tel:+' . $number;
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
