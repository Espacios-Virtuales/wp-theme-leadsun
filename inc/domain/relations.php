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
