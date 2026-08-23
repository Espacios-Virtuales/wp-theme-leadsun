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
 * @return array{valid: bool|null, data: array<string, mixed>, errors: array<string, string>}
 */
function leadsun_form_submission_state( string $form_type ): array {
	$empty_state = array(
		'valid'  => null,
		'data'   => array(),
		'errors' => array(),
	);

	$submitted_request = wp_unslash( $_POST );
	$submitted_type    = sanitize_key( leadsun_form_request_value( $submitted_request, 'leadsun_form_type' ) );
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || $form_type !== $submitted_type ) {
		return $empty_state;
	}

	return 'quote' === $form_type ? leadsun_validate_quote_submission() : leadsun_validate_contact_submission();
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
	}

	// C02 will reveal this confirmation only after successful delivery.
	echo '<div class="leadsun-form__notice leadsun-form__notice--success" aria-live="polite" hidden></div>';
}

/**
 * Output the hidden field-level error for a field when present.
 */
function leadsun_form_field_error( array $state, string $field_name ): void {
	$error = $state['errors'][ $field_name ] ?? '';
	echo '<p id="' . esc_attr( $field_name ) . '-error" class="leadsun-field__error"' . ( $error ? '' : ' hidden' ) . '>' . esc_html( $error ) . '</p>';
}
