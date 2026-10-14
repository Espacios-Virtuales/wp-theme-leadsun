<?php
/**
 * LEADSUN content types.
 *
 * These registrations are isolated in /inc/domain so they can be extracted
 * later to a lightweight companion plugin without changing the public models.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function leadsun_register_content_types(): void {
	register_post_type(
		'leadsun_solution',
		array(
			'labels' => array(
				'name'          => __( 'Soluciones', 'leadsun' ),
				'singular_name' => __( 'Solución', 'leadsun' ),
				'add_new_item'  => __( 'Agregar solución', 'leadsun' ),
				'edit_item'     => __( 'Editar solución', 'leadsun' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-admin-tools',
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'soluciones' ),
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);

	register_post_type(
		'leadsun_technology',
		array(
			'labels' => array(
				'name'          => __( 'Tecnologías', 'leadsun' ),
				'singular_name' => __( 'Tecnología', 'leadsun' ),
				'add_new_item'  => __( 'Agregar tecnología', 'leadsun' ),
				'edit_item'     => __( 'Editar tecnología', 'leadsun' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-cpu',
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'tecnologias' ),
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);

	register_post_type(
		'leadsun_project',
		array(
			'labels' => array(
				'name'          => __( 'Proyectos', 'leadsun' ),
				'singular_name' => __( 'Proyecto', 'leadsun' ),
				'add_new_item'  => __( 'Agregar proyecto', 'leadsun' ),
				'edit_item'     => __( 'Editar proyecto', 'leadsun' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-building',
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'proyectos' ),
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);

	register_post_type(
		'leadsun_lead',
		array(
			'labels' => array(
				'name'          => __( 'Leads', 'leadsun' ),
				'singular_name' => __( 'Lead', 'leadsun' ),
				'edit_item'     => __( 'Ver lead', 'leadsun' ),
			),
			'public'             => false,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'has_archive'        => false,
			'rewrite'             => false,
			'show_in_rest'       => false,
			'show_ui'             => true,
			'menu_icon'          => 'dashicons-id-alt',
			'supports'           => array( 'title' ),
		)
	);
}
add_action( 'init', 'leadsun_register_content_types' );
