<?php
/**
 * Plain-text mail composition and delivery for commercial forms.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Send a validated form payload through wp_mail().
 */
function leadsun_send_form_mail( string $form_type, array $data ): bool {
	$recipients = leadsun_forms_recipients();
	$from_email = sanitize_email( (string) get_option( 'admin_email' ) );
	$from_email = is_email( $from_email ) ? $from_email : 'wordpress@' . wp_parse_url( home_url(), PHP_URL_HOST );
	$site_name  = sanitize_text_field( get_bloginfo( 'name' ) );
	$headers    = array(
		'Content-Type: text/plain; charset=UTF-8',
		'From: ' . $site_name . ' <' . $from_email . '>',
		'Reply-To: ' . sanitize_text_field( (string) $data['name'] ) . ' <' . sanitize_email( (string) $data['email'] ) . '>',
	);

	if ( $recipients['cc'] ) {
		$headers[] = 'Cc: ' . implode( ', ', $recipients['cc'] );
	}

	$attachments = array();
	if ( 'quote' === $form_type && ! empty( $data['attachment']['tmp_name'] ) && is_uploaded_file( $data['attachment']['tmp_name'] ) ) {
		$attachments[] = $data['attachment']['tmp_name'];
	}

	$mail_sent = wp_mail(
		$recipients['primary'],
		leadsun_form_mail_subject( $form_type, $data ),
		leadsun_form_mail_body( $form_type, $data ),
		$headers,
		$attachments
	);

	foreach ( $attachments as $attachment ) {
		wp_delete_file( $attachment );
	}

	return $mail_sent;
}

/**
 * Build a safe, textual subject for a form type.
 */
function leadsun_form_mail_subject( string $form_type, array $data ): string {
	if ( 'contact' === $form_type ) {
		return sprintf( __( 'Nueva consulta desde LEADSUN · %s', 'leadsun' ), sanitize_text_field( (string) $data['subject'] ) );
	}

	return __( 'Nueva solicitud de proyecto · LEADSUN', 'leadsun' );
}

/**
 * Build an operational plain-text email body.
 */
function leadsun_form_mail_body( string $form_type, array $data ): string {
	$empty = __( 'No informado', 'leadsun' );
	if ( 'quote' === $form_type ) {
		$product      = get_post( absint( $data['product_interest'] ?? 0 ) );
		$product_name = $product instanceof WP_Post && 'leadsun_solution' === $product->post_type && 'publish' === $product->post_status ? get_the_title( $product ) : '';
		$data['product_interest'] = $product_name;
	}
	$lead_id = absint( $data['lead_id'] ?? 0 );
	$value = static function ( string $key ) use ( $data, $empty ): string {
		$current = trim( (string) ( $data[ $key ] ?? '' ) );
		return '' === $current ? $empty : $current;
	};

	if ( 'contact' === $form_type ) {
		return implode(
			"\n",
			array(
				__( 'Nueva consulta desde el sitio LEADSUN', 'leadsun' ),
				'',
				'Nombre: ' . $value( 'name' ),
				'Correo: ' . $value( 'email' ),
				'Teléfono: ' . $value( 'phone' ),
				'Asunto: ' . $value( 'subject' ),
				'',
				'Mensaje:',
				$value( 'message' ),
			)
		);
	}

	$lines = array(
			__( 'Nueva solicitud de proyecto desde el sitio LEADSUN', 'leadsun' ),
			'',
		);

	if ( $lead_id ) {
		$lines[] = 'Lead ID: ' . $lead_id;
	}

	$interest_labels = array(
		'solution'   => __( 'Solución', 'leadsun' ),
		'technology' => __( 'Tecnología', 'leadsun' ),
	);
	$interest = leadsun_quote_interest_from_entity(
		sanitize_key( (string) ( $data['interest_type'] ?? '' ) ),
		(string) absint( $data['interest_id'] ?? 0 )
	);
	if ( isset( $interest_labels[ $interest['type'] ] ) && $interest['id'] && '' !== $interest['name'] ) {
		$lines[] = 'Interés: ' . $interest_labels[ $interest['type'] ];
		$lines[] = 'Selección: ' . $interest['name'];
		$lines[] = 'ID interno: ' . $interest['id'];
	}

	$lines = array_merge(
		$lines,
		array(
			'Nombre: ' . $value( 'name' ),
			'Empresa: ' . $value( 'company' ),
			'Correo: ' . $value( 'email' ),
			'Teléfono: ' . $value( 'phone' ),
			'Región / ciudad: ' . $value( 'location' ),
			'Tipo de proyecto: ' . $value( 'project_type' ),
			'Producto de interés: ' . $value( 'product_interest' ),
			'Presupuesto estimado: ' . $value( 'budget' ),
			'Cantidad aproximada: ' . $value( 'quantity' ),
			'Etapa del proyecto: ' . $value( 'stage' ),
			'Fecha estimada de ejecución: ' . $value( 'execution_date' ),
			'',
			'Mensaje:',
			$value( 'message' ),
		)
	);

	return implode( "\n", $lines );
}
