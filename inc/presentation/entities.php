<?php
/**
 * Shared presentation configuration for LEADSUN content entities.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the display and field contract for a supported entity type.
 *
 * @return array<string, string>
 */
function leadsun_entity_config( string $post_type ): array {
	$config = array(
		'leadsun_solution' => array(
			'label'           => __( 'Solución', 'leadsun' ),
			'plural'          => __( 'Soluciones', 'leadsun' ),
			'introduction'    => __( 'Una selección navegable de soluciones LEADSUN. El contenido final será incorporado cuando esté disponible.', 'leadsun' ),
			'secondary_field' => 'solution_secondary_image',
			'gallery_fields'  => array( 'solution_secondary_image', 'solution_secondary_image_2', 'solution_secondary_image_3' ),
			'video_field'     => 'solution_youtube_url',
			'document_field'  => 'solution_datasheet',
			'document_label'  => __( 'Descargar ficha técnica', 'leadsun' ),
		),
		'leadsun_technology' => array(
			'label'           => __( 'Tecnología', 'leadsun' ),
			'plural'          => __( 'Tecnologías', 'leadsun' ),
			'introduction'    => __( 'Tecnologías administrables que pueden complementar cada solución o proyecto.', 'leadsun' ),
			'secondary_field' => 'technology_secondary_image',
			'gallery_fields'  => array( 'technology_secondary_image', 'technology_secondary_image_2', 'technology_secondary_image_3' ),
			'video_field'     => 'technology_youtube_url',
			'document_field'  => 'technology_document',
			'document_label'  => __( 'Descargar documento técnico', 'leadsun' ),
		),
		'leadsun_project' => array(
			'label'           => __( 'Proyecto', 'leadsun' ),
			'plural'          => __( 'Proyectos', 'leadsun' ),
			'introduction'    => __( 'Proyectos conectados con sus soluciones y tecnologías relacionadas.', 'leadsun' ),
			'secondary_field' => 'project_secondary_image',
			'gallery_fields'  => array( 'project_secondary_image', 'project_secondary_image_2', 'project_secondary_image_3' ),
			'video_field'     => 'project_youtube_url',
			'document_field'  => '',
			'document_label'  => '',
		),
	);

	return $config[ $post_type ] ?? array();
}

/**
 * Resolve an ACF file field without assuming its return format.
 */
function leadsun_entity_document_url( string $field_name, int $post_id ): string {
	if ( '' === $field_name || $post_id <= 0 ) {
		return '';
	}

	$value = leadsun_field( $field_name, $post_id );

	if ( is_array( $value ) && isset( $value['url'] ) && is_string( $value['url'] ) ) {
		return $value['url'];
	}

	if ( is_numeric( $value ) ) {
		$url = wp_get_attachment_url( absint( $value ) );
		return is_string( $url ) ? $url : '';
	}

	return is_string( $value ) ? $value : '';
}
