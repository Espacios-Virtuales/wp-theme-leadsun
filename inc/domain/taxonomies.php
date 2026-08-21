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
		'leadsun_solution_line',
		array( 'leadsun_solution' ),
		array(
			'labels' => array(
				'name'          => __( 'Líneas de solución', 'leadsun' ),
				'singular_name' => __( 'Línea de solución', 'leadsun' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'linea-solucion' ),
		)
	);
}
add_action( 'init', 'leadsun_register_taxonomies' );

/**
 * Seed the baseline solution lines once, while allowing editors to add more.
 */
function leadsun_seed_solution_lines(): void {
	$terms = array( 'Solar', 'Eléctrica' );

	foreach ( $terms as $term ) {
		if ( ! term_exists( $term, 'leadsun_solution_line' ) ) {
			wp_insert_term( $term, 'leadsun_solution_line' );
		}
	}
}
add_action( 'init', 'leadsun_seed_solution_lines', 20 );
