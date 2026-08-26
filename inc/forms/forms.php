<?php
/**
 * Reusable form presentation helpers.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the editorial form selection assigned to a LEADSUN Landing.
 */
function leadsun_landing_form_type( int $page_id ): string {
	$form_type = leadsun_field( 'landing_form_type', $page_id, 'none' );
	$form_type = is_string( $form_type ) ? $form_type : 'none';

	return in_array( $form_type, array( 'none', 'contact', 'quote' ), true ) ? $form_type : 'none';
}

/**
 * Validate only a post directed to the specified form, without delivering it.
 *
 * @return array{valid: bool|null, data: array<string, mixed>, errors: array<string, string>, success: string}
 */
function leadsun_form_submission_state( string $form_type ): array {
	$empty_state = array(
		'valid'   => null,
		'data'    => array(),
		'errors'  => array(),
		'success' => '',
	);
	$query         = wp_unslash( $_GET );
	$success_nonce = sanitize_text_field( leadsun_form_request_value( $query, 'leadsun_form_success' ) );
	$success_state = sanitize_key( leadsun_form_request_value( $query, 'leadsun_form_status' ) );
	$success_type  = sanitize_key( leadsun_form_request_value( $query, 'leadsun_form_type' ) );
	if (
		'success' === $success_state
		&& $form_type === $success_type
		&& wp_verify_nonce( $success_nonce, 'leadsun_form_success_' . $form_type . '_' . get_queried_object_id() )
	) {
		$empty_state['valid']   = true;
		$empty_state['success'] = 'quote' === $form_type
			? __( 'Gracias por contactarnos. Hemos recibido los antecedentes de su proyecto. Nuestro equipo técnico revisará la información y se pondrá en contacto a la brevedad para evaluar la solución LEADSUN más adecuada.', 'leadsun' )
			: __( 'Gracias por contactarnos. Hemos recibido tu mensaje y nuestro equipo lo revisará a la brevedad.', 'leadsun' );
		return $empty_state;
	}

	$submitted_request = wp_unslash( $_POST );
	$submitted_type    = sanitize_key( leadsun_form_request_value( $submitted_request, 'leadsun_form_type' ) );
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || $form_type !== $submitted_type ) {
		return $empty_state;
	}

	if ( ! empty( $GLOBALS['leadsun_form_delivery_states'][ $form_type ] ) ) {
		$state                  = $GLOBALS['leadsun_form_delivery_states'][ $form_type ];
		$state['valid']         = false;
		$state['errors']['form'] = $GLOBALS['leadsun_form_delivery_errors'][ $form_type ] ?? '';
		return $state + array( 'success' => '' );
	}

	$state = 'quote' === $form_type ? leadsun_validate_quote_submission() : leadsun_validate_contact_submission();
	if ( ! empty( $GLOBALS['leadsun_form_delivery_errors'][ $form_type ] ) ) {
		$state['valid']          = false;
		$state['errors']['form'] = $GLOBALS['leadsun_form_delivery_errors'][ $form_type ];
	}

	return $state + array( 'success' => '' );
}

/**
 * Return dynamic product-interest choices from published solutions.
 *
 * @return array<string, string>
 */
function leadsun_quote_product_options(): array {
	$query = new WP_Query(
		array(
			'post_type'      => 'leadsun_solution',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);
	$options = array();

	foreach ( $query->posts as $post_id ) {
		$options[ (string) absint( $post_id ) ] = get_the_title( $post_id );
	}

	return $options;
}

/**
 * Return an escaped retained value from a form state.
 */
function leadsun_form_value( array $state, string $key ): string {
	return esc_attr( (string) ( $state['data'][ $key ] ?? '' ) );
}

/**
 * Output common accessible form feedback containers.
 */
function leadsun_form_feedback( array $state ): void {
	if ( ! empty( $state['errors']['form'] ) ) {
		echo '<div class="leadsun-form__notice leadsun-form__notice--error" role="alert">' . esc_html( $state['errors']['form'] ) . '</div>';
		$whatsapp_url = leadsun_whatsapp_url();
		if ( $whatsapp_url ) {
			echo '<p class="leadsun-form__whatsapp leadsun-form__whatsapp--error"><a href="' . esc_url( $whatsapp_url ) . '" target="_blank" rel="noopener">' . esc_html__( '¿Prefieres WhatsApp? Hablar por WhatsApp', 'leadsun' ) . '</a></p>';
		}
	}

	if ( ! empty( $state['success'] ) ) {
		echo '<div class="leadsun-form__notice leadsun-form__notice--success" role="status" aria-live="polite">' . esc_html( $state['success'] ) . '</div>';
		return;
	}

	echo '<div class="leadsun-form__notice leadsun-form__notice--success" aria-live="polite" hidden></div>';
}

/**
 * Output the hidden field-level error for a field when present.
 */
function leadsun_form_field_error( array $state, string $field_name ): void {
	$error = $state['errors'][ $field_name ] ?? '';
	echo '<p id="' . esc_attr( $field_name ) . '-error" class="leadsun-field__error"' . ( $error ? '' : ' hidden' ) . '>' . esc_html( $error ) . '</p>';
}
