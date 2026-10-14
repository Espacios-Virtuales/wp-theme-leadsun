<?php
/**
 * Helpers for one-way relationships stored on LEADSUN projects.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Normalize an ACF post object value to a usable post ID.
 *
 * @param mixed $value A post ID or a WP_Post object.
 */
function leadsun_related_post_id( $value ): int {
	if ( $value instanceof WP_Post ) {
		return max( 0, (int) $value->ID );
	}

	if ( is_numeric( $value ) ) {
		return max( 0, absint( $value ) );
	}

	return 0;
}

/**
 * Return the IDs related from a project without creating inverse metadata.
 *
 * @param int|null $project_id Project ID. Defaults to the current post.
 * @return array{solution: int, technology: int}
 */
function leadsun_project_relations( ?int $project_id = null ): array {
	$post_id = $project_id ?: get_the_ID();

	return array(
		'solution'   => leadsun_related_post_id( leadsun_field( 'project_solution', $post_id ) ),
		'technology' => leadsun_related_post_id( leadsun_field( 'project_technology', $post_id ) ),
	);
}

/**
 * Find published projects that already reference a solution or technology.
 *
 * @return int[]
 */
function leadsun_entity_project_relations( int $entity_id, string $post_type ): array {
	$field_name = 'leadsun_solution' === $post_type ? 'project_solution' : ( 'leadsun_technology' === $post_type ? 'project_technology' : '' );

	if ( $entity_id <= 0 || '' === $field_name ) {
		return array();
	}

	return get_posts(
		array(
			'post_type'      => 'leadsun_project',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'meta_query'     => array(
				array(
					'key'   => $field_name,
					'value' => (string) $entity_id,
				),
			),
		)
	);
}

/**
 * Find published solutions explicitly paired with a technology by published projects.
 *
 * The existing project fields remain the single source of truth. No inverse or
 * parallel relationship metadata is created on technologies or solutions.
 *
 * @return int[]
 */
function leadsun_technology_solution_relations( int $technology_id ): array {
	if ( $technology_id <= 0 || 'leadsun_technology' !== get_post_type( $technology_id ) ) {
		return array();
	}

	$solution_ids = array();

	foreach ( leadsun_entity_project_relations( $technology_id, 'leadsun_technology' ) as $project_id ) {
		$solution_id = leadsun_project_relations( $project_id )['solution'];

		if ( $solution_id > 0 && 'leadsun_solution' === get_post_type( $solution_id ) && 'publish' === get_post_status( $solution_id ) ) {
			$solution_ids[] = $solution_id;
		}
	}

	return array_values( array_unique( $solution_ids ) );
}
