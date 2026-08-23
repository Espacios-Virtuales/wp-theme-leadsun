<?php
/**
 * Sanitization and validation contracts for LEADSUN commercial forms.
 *
 * Delivery is intentionally handled by the next implementation capsule.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return array{valid: bool, data: array<string, mixed>, errors: array<string, string>}
 */
function leadsun_validate_contact_submission( ?array $request = null ): array {
	$request = null === $request ? wp_unslash( $_POST ) : $request;
	$data    = array(
		'name'    => sanitize_text_field( leadsun_form_request_value( $request, 'contact_name' ) ),
		'email'   => sanitize_email( leadsun_form_request_value( $request, 'contact_email' ) ),
		'phone'   => sanitize_text_field( leadsun_form_request_value( $request, 'contact_phone' ) ),
		'subject' => sanitize_text_field( leadsun_form_request_value( $request, 'contact_subject' ) ),
		'message' => sanitize_textarea_field( leadsun_form_request_value( $request, 'contact_message' ) ),
	);
	$errors  = leadsun_form_security_errors( $request, 'contact' );

	if ( '' === $data['name'] ) {
		$errors['contact_name'] = __( 'Ingresa tu nombre.', 'leadsun' );
	}
	if ( ! is_email( $data['email'] ) ) {
		$errors['contact_email'] = __( 'Ingresa un correo electrónico válido.', 'leadsun' );
	}
	if ( '' === $data['subject'] ) {
		$errors['contact_subject'] = __( 'Indica el asunto de tu consulta.', 'leadsun' );
	}
	if ( '' === $data['message'] ) {
		$errors['contact_message'] = __( 'Escribe tu mensaje.', 'leadsun' );
	}

	return array(
		'valid'  => empty( $errors ),
		'data'   => $data,
		'errors' => $errors,
	);
}

/**
 * @return array{valid: bool, data: array<string, mixed>, errors: array<string, string>}
 */
function leadsun_validate_quote_submission( ?array $request = null, ?array $files = null ): array {
	$request = null === $request ? wp_unslash( $_POST ) : $request;
	$files   = null === $files ? $_FILES : $files;
	$data    = array(
		'name'             => sanitize_text_field( leadsun_form_request_value( $request, 'quote_name' ) ),
		'company'          => sanitize_text_field( leadsun_form_request_value( $request, 'quote_company' ) ),
		'email'            => sanitize_email( leadsun_form_request_value( $request, 'quote_email' ) ),
		'phone'            => sanitize_text_field( leadsun_form_request_value( $request, 'quote_phone' ) ),
		'location'         => sanitize_text_field( leadsun_form_request_value( $request, 'quote_location' ) ),
		'project_type'     => sanitize_text_field( leadsun_form_request_value( $request, 'quote_project_type' ) ),
		'product_interest' => sanitize_text_field( leadsun_form_request_value( $request, 'quote_product_interest' ) ),
		'budget'           => sanitize_text_field( leadsun_form_request_value( $request, 'quote_budget' ) ),
		'quantity'         => sanitize_text_field( leadsun_form_request_value( $request, 'quote_quantity' ) ),
		'stage'            => sanitize_text_field( leadsun_form_request_value( $request, 'quote_stage' ) ),
		'execution_date'   => sanitize_text_field( leadsun_form_request_value( $request, 'quote_execution_date' ) ),
		'message'          => sanitize_textarea_field( leadsun_form_request_value( $request, 'quote_message' ) ),
	);
	$errors  = leadsun_form_security_errors( $request, 'quote' );

	foreach (
		array(
			'name'         => __( 'Ingresa tu nombre.', 'leadsun' ),
			'phone'        => __( 'Ingresa un teléfono de contacto.', 'leadsun' ),
			'location'     => __( 'Indica la región o ciudad del proyecto.', 'leadsun' ),
			'project_type' => __( 'Selecciona el tipo de proyecto.', 'leadsun' ),
			'message'      => __( 'Describe las necesidades de tu proyecto.', 'leadsun' ),
		) as $field => $message
	) {
		if ( '' === $data[ $field ] ) {
			$errors[ 'quote_' . $field ] = $message;
		}
	}

	if ( ! is_email( $data['email'] ) ) {
		$errors['quote_email'] = __( 'Ingresa un correo electrónico válido.', 'leadsun' );
	}

	$attachment = leadsun_validate_quote_attachment( $files['quote_attachment'] ?? array() );
	if ( ! empty( $attachment['error'] ) ) {
		$errors['quote_attachment'] = $attachment['error'];
	} elseif ( ! empty( $attachment['file'] ) ) {
		$data['attachment'] = $attachment['file'];
	}

	return array(
		'valid'  => empty( $errors ),
		'data'   => $data,
		'errors' => $errors,
	);
}

/**
 * Validate the form nonce and hidden spam trap for a distinct form action.
 *
 * @return array<string, string>
 */
function leadsun_form_security_errors( array $request, string $form_type ): array {
	$errors      = array();
	$nonce_field = 'leadsun_' . $form_type . '_nonce';
	$nonce       = sanitize_text_field( leadsun_form_request_value( $request, $nonce_field ) );

	if ( ! wp_verify_nonce( $nonce, 'leadsun_' . $form_type . '_submit' ) ) {
		$errors['form'] = __( 'No fue posible validar el formulario. Actualiza la página e inténtalo nuevamente.', 'leadsun' );
	}

	if ( '' !== leadsun_form_request_value( $request, 'website' ) ) {
		$errors['form'] = __( 'No fue posible procesar el formulario.', 'leadsun' );
	}

	return $errors;
}

/**
 * Read only a scalar request value, rejecting malformed array input.
 */
function leadsun_form_request_value( array $request, string $key ): string {
	$value = $request[ $key ] ?? '';
	return is_scalar( $value ) ? (string) $value : '';
}

/**
 * Validate the optional quote attachment without moving or persisting it.
 *
 * @return array{file?: array<string, mixed>, error?: string}
 */
function leadsun_validate_quote_attachment( array $file ): array {
	if ( empty( $file ) || UPLOAD_ERR_NO_FILE === (int) ( $file['error'] ?? UPLOAD_ERR_NO_FILE ) ) {
		return array();
	}

	if ( UPLOAD_ERR_OK !== (int) ( $file['error'] ?? UPLOAD_ERR_NO_FILE ) || empty( $file['tmp_name'] ) ) {
		return array( 'error' => __( 'No fue posible cargar el archivo adjunto.', 'leadsun' ) );
	}

	$max_size = 10 * MB_IN_BYTES;
	if ( (int) ( $file['size'] ?? 0 ) > $max_size ) {
		return array( 'error' => __( 'El archivo adjunto no puede superar los 10 MB.', 'leadsun' ) );
	}

	$allowed_mimes = array(
		'pdf'  => 'application/pdf',
		'jpg'  => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'png'  => 'image/png',
		'doc'  => 'application/msword',
		'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'xls'  => 'application/vnd.ms-excel',
		'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	);
	$filename      = sanitize_file_name( (string) ( $file['name'] ?? '' ) );
	$file_info     = wp_check_filetype_and_ext( (string) $file['tmp_name'], $filename, $allowed_mimes );

	if ( empty( $file_info['ext'] ) || empty( $file_info['type'] ) || ! isset( $allowed_mimes[ $file_info['ext'] ] ) ) {
		return array( 'error' => __( 'El archivo debe ser PDF, imagen JPG/PNG, Word o Excel.', 'leadsun' ) );
	}

	return array(
		'file' => array(
			'name'     => $filename,
			'type'     => $file_info['type'],
			'tmp_name' => (string) $file['tmp_name'],
			'size'     => (int) $file['size'],
		),
	);
}
