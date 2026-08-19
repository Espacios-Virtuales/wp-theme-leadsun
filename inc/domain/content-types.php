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
		'leadsun_product',
		array(
			'labels' => array(
				'name'          => __( 'Productos', 'leadsun' ),
				'singular_name' => __( 'Producto', 'leadsun' ),
				'add_new_item'  => __( 'Agregar producto', 'leadsun' ),
				'edit_item'     => __( 'Editar producto', 'leadsun' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-lightbulb',
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'productos' ),
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
}
add_action( 'init', 'leadsun_register_content_types' );
