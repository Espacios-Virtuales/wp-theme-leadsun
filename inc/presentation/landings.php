<?php
/**
 * Presentation helpers for reusable landing pages.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve the optional solution-line selection made on a landing page.
 */
function leadsun_landing_solution_line_id( int $page_id ): int {
	$term_id = absint( leadsun_field( 'landing_solution_line', $page_id ) );

	return $term_id && term_exists( $term_id, 'leadsun_solution_line' ) ? $term_id : 0;
}

/**
 * Return the published solutions assigned to a selected solution line.
 *
 * @return int[]
 */
function leadsun_landing_solution_ids( int $term_id ): array {
	if ( ! $term_id ) {
		return array();
	}

	$query = new WP_Query(
		array(
			'post_type'      => 'leadsun_solution',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'tax_query'      => array(
				array(
					'taxonomy' => 'leadsun_solution_line',
					'field'    => 'term_id',
					'terms'    => $term_id,
				),
			),
		)
	);

	return array_map( 'absint', $query->posts );
}

/**
 * Resolve the commercial quote route, with Contacto as the safe fallback.
 */
function leadsun_quote_page_url(): string {
	$quote_page = get_page_by_path( 'cotizar-proyecto' );
	if ( $quote_page instanceof WP_Post ) {
		return (string) get_permalink( $quote_page );
	}

	$contact_page = get_page_by_path( 'contacto' );
	if ( $contact_page instanceof WP_Post ) {
		return (string) get_permalink( $contact_page );
	}

	return home_url( '/#contacto' );
}

/**
 * Resolve a solution landing page by its page slug for navigation fallbacks.
 */
function leadsun_solution_landing_url( string $slug ): string {
	$page = get_page_by_path( sanitize_title( $slug ) );
	if ( $page instanceof WP_Post ) {
		return (string) get_permalink( $page );
	}

	return (string) get_post_type_archive_link( 'leadsun_solution' );
}
