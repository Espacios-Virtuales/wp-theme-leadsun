<?php
/**
 * Internal lead persistence for validated quote submissions.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Persist a validated quote as an internal, non-public lead.
 *
 * @return int|WP_Error
 */
function leadsun_persist_quote_lead( array $data ) {
	$name    = sanitize_text_field( (string) ( $data['name'] ?? '' ) );
	$company = sanitize_text_field( (string) ( $data['company'] ?? '' ) );
	$interest = leadsun_quote_interest_from_entity(
		sanitize_key( (string) ( $data['interest_type'] ?? '' ) ),
		(string) absint( $data['interest_id'] ?? 0 )
	);
	$date    = current_time( 'Y-m-d' );
	$title   = $date . ' · ' . $name;
	$title  .= '' === $company ? '' : ' · ' . $company;

	$lead_id = wp_insert_post(
		array(
			'post_type'   => 'leadsun_lead',
			'post_status' => 'private',
			'post_title'  => $title,
		),
		true
	);

	if ( is_wp_error( $lead_id ) || ! $lead_id ) {
		return is_wp_error( $lead_id ) ? $lead_id : new WP_Error( 'leadsun_lead_insert_failed' );
	}

	$meta = array(
		'lead_name'             => $name,
		'lead_company'          => $company,
		'lead_email'            => sanitize_email( (string) ( $data['email'] ?? '' ) ),
		'lead_phone'            => sanitize_text_field( (string) ( $data['phone'] ?? '' ) ),
		'lead_location'         => sanitize_text_field( (string) ( $data['location'] ?? '' ) ),
		'lead_project_type'     => sanitize_text_field( (string) ( $data['project_type'] ?? '' ) ),
		'lead_product_interest' => sanitize_text_field( (string) ( $data['product_interest'] ?? '' ) ),
		'lead_budget'           => sanitize_text_field( (string) ( $data['budget'] ?? '' ) ),
		'lead_quantity'         => sanitize_text_field( (string) ( $data['quantity'] ?? '' ) ),
		'lead_stage'            => sanitize_text_field( (string) ( $data['stage'] ?? '' ) ),
		'lead_execution_date'   => sanitize_text_field( (string) ( $data['execution_date'] ?? '' ) ),
		'lead_message'          => sanitize_textarea_field( (string) ( $data['message'] ?? '' ) ),
		'interest_type'         => $interest['type'],
		'interest_id'           => $interest['id'],
		'interest_name'         => $interest['name'],
		'lead_status'           => 'new',
		'mail_status'           => 'pending',
		'created_at'            => current_time( 'mysql' ),
	);

	foreach ( $meta as $key => $value ) {
		update_post_meta( $lead_id, $key, $value );
	}

	return (int) $lead_id;
}

/** Record the result of the mail attempt made after lead persistence. */
function leadsun_update_quote_lead_mail_status( int $lead_id, bool $mail_sent ): void {
	if ( $lead_id <= 0 ) {
		return;
	}

	update_post_meta( $lead_id, 'mail_status', $mail_sent ? 'sent' : 'failed' );
	if ( $mail_sent ) {
		update_post_meta( $lead_id, 'mail_sent_at', current_time( 'mysql' ) );
	}
}

/** Keep the internal lead list identifiable without a separate dashboard. */
function leadsun_lead_admin_columns( array $columns ): array {
	return array(
		'cb'                => $columns['cb'] ?? '<input type="checkbox">',
		'title'             => __( 'Lead', 'leadsun' ),
		'lead_contact'      => __( 'Contacto', 'leadsun' ),
		'lead_company'      => __( 'Empresa', 'leadsun' ),
		'lead_interest'     => __( 'Interés', 'leadsun' ),
		'lead_mail_status'  => __( 'Correo', 'leadsun' ),
		'date'              => $columns['date'] ?? __( 'Fecha', 'leadsun' ),
	);
}
add_filter( 'manage_leadsun_lead_posts_columns', 'leadsun_lead_admin_columns' );

/** Render the minimal operational lead columns. */
function leadsun_render_lead_admin_column( string $column, int $post_id ): void {
	if ( 'lead_contact' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'lead_name', true ) );
	} elseif ( 'lead_company' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'lead_company', true ) );
	} elseif ( 'lead_interest' === $column ) {
		$type = get_post_meta( $post_id, 'interest_type', true );
		$name = get_post_meta( $post_id, 'interest_name', true );
		$label = 'solution' === $type ? __( 'Solución', 'leadsun' ) : ( 'technology' === $type ? __( 'Tecnología', 'leadsun' ) : ( 'project' === $type ? __( 'Proyecto de referencia', 'leadsun' ) : '' ) );
		echo esc_html( $label && $name ? $label . ': ' . $name : '—' );
	} elseif ( 'lead_mail_status' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'mail_status', true ) ?: 'pending' );
	}
}
add_action( 'manage_leadsun_lead_posts_custom_column', 'leadsun_render_lead_admin_column', 10, 2 );
