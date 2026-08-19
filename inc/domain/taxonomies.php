<?php
/**
 * LEADSUN taxonomies.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function leadsun_register_taxonomies(): void {
	register_taxonomy(
		'leadsun_line',
		array( 'leadsun_product' ),
		array(
			'labels' => array(
				'name'          => __( 'Líneas de producto', 'leadsun' ),
				'singular_name' => __( 'Línea de producto', 'leadsun' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'linea-producto' ),
		)
	);

	register_taxonomy(
		'leadsun_sector',
		array( 'leadsun_project' ),
		array(
			'labels' => array(
				'name'          => __( 'Sectores de proyecto', 'leadsun' ),
				'singular_name' => __( 'Sector de proyecto', 'leadsun' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'sector-proyecto' ),
		)
	);
}
add_action( 'init', 'leadsun_register_taxonomies' );
