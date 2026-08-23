<?php
/**
 * POST handling and PRG orchestration for LEADSUN commercial forms.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var array<string, string> */
$GLOBALS['leadsun_form_delivery_errors'] = array();

/**
 * Send a validated submission and redirect on success to prevent resubmission.
 */
function leadsun_handle_form_submission(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
		return;
	}

	$request   = wp_unslash( $_POST );
	$form_type = sanitize_key( leadsun_form_request_value( $request, 'leadsun_form_type' ) );
	if ( ! in_array( $form_type, array( 'contact', 'quote' ), true ) ) {
		return;
	}

	$result = 'quote' === $form_type ? leadsun_validate_quote_submission() : leadsun_validate_contact_submission();
	if ( ! $result['valid'] ) {
		return;
	}

	if ( 'quote' === $form_type && ! empty( $result['data']['attachment']['tmp_name'] ) && ! is_uploaded_file( $result['data']['attachment']['tmp_name'] ) ) {
		$GLOBALS['leadsun_form_delivery_errors'][ $form_type ] = __( 'No fue posible enviar la solicitud en este momento. Inténtalo nuevamente o utiliza nuestros canales de contacto.', 'leadsun' );
		return;
	}

	if ( ! leadsun_send_form_mail( $form_type, $result['data'] ) ) {
		$GLOBALS['leadsun_form_delivery_states'][ $form_type ] = $result;
		$GLOBALS['leadsun_form_delivery_errors'][ $form_type ] = __( 'No fue posible enviar la solicitud en este momento. Inténtalo nuevamente o utiliza nuestros canales de contacto.', 'leadsun' );
		return;
	}

	$page_id      = get_queried_object_id();
	$redirect_url = $page_id ? get_permalink( $page_id ) : home_url( '/' );
	$redirect_url = add_query_arg(
		array(
			'leadsun_form_status'  => 'success',
			'leadsun_form_type'    => $form_type,
			'leadsun_form_success' => wp_create_nonce( 'leadsun_form_success_' . $form_type . '_' . $page_id ),
		),
		$redirect_url
	);

	wp_safe_redirect( $redirect_url );
	exit;
}
add_action( 'template_redirect', 'leadsun_handle_form_submission' );
