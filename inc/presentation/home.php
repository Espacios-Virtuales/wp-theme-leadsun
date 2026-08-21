<?php
/**
 * Home composition queries and editorial fallbacks.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Read a Home post object safely and ensure it belongs to the expected type.
 */
function leadsun_home_entity_id( $value, string $post_type ): int {
	$id = leadsun_related_post_id( $value );
	return $id > 0 && $post_type === get_post_type( $id ) ? $id : 0;
}

/**
 * Return the home page ID, regardless of the current query context.
 */
function leadsun_home_page_id(): int {
	return absint( get_option( 'page_on_front' ) );
}

/**
 * Query one solution from a preferred line, excluding already selected IDs.
 */
function leadsun_home_solution_from_line( string $line, array $exclude = array() ): int {
	$query = new WP_Query(
		array(
			'post_type'      => 'leadsun_solution',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'post__not_in'   => $exclude,
			'tax_query'      => array(
				array(
					'taxonomy' => 'leadsun_solution_line',
					'field'    => 'name',
					'terms'    => $line,
				),
			),
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);

	return ! empty( $query->posts[0] ) ? absint( $query->posts[0] ) : 0;
}

/**
 * Resolve exactly the two editorial featured-solution slots when records exist.
 *
 * @return int[] Up to two unique solution IDs.
 */
function leadsun_home_featured_solution_ids(): array {
	$page_id  = leadsun_home_page_id();
	$selected = array();

	foreach ( array( 'home_featured_solution_1', 'home_featured_solution_2' ) as $field ) {
		$id = leadsun_home_entity_id( leadsun_field( $field, $page_id ), 'leadsun_solution' );
		if ( $id && ! in_array( $id, $selected, true ) ) {
			$selected[] = $id;
		}
	}

	foreach ( array( 'Solar', 'Eléctrica' ) as $line ) {
		if ( count( $selected ) >= 2 ) {
			break;
		}

		$id = leadsun_home_solution_from_line( $line, $selected );
		if ( $id ) {
			$selected[] = $id;
		}
	}

	if ( count( $selected ) < 2 ) {
		$fallback = new WP_Query(
			array(
				'post_type'      => 'leadsun_solution',
				'post_status'    => 'publish',
				'posts_per_page' => 2 - count( $selected ),
				'post__not_in'   => $selected,
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);
		$selected = array_merge( $selected, array_map( 'absint', $fallback->posts ) );
	}

	return array_slice( $selected, 0, 2 );
}

/**
 * Resolve up to three editorial entity slots, falling back to latest posts.
 *
 * @return int[]
 */
function leadsun_home_featured_entity_ids( string $post_type, string $field_prefix ): array {
	$page_id  = leadsun_home_page_id();
	$selected = array();

	foreach ( array( 1, 2, 3 ) as $position ) {
		$id = leadsun_home_entity_id( leadsun_field( $field_prefix . $position, $page_id ), $post_type );
		if ( $id && ! in_array( $id, $selected, true ) ) {
			$selected[] = $id;
		}
	}

	if ( count( $selected ) < 3 ) {
		$fallback = new WP_Query(
			array(
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => 3 - count( $selected ),
				'post__not_in'   => $selected,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);
		$selected = array_merge( $selected, array_map( 'absint', $fallback->posts ) );
	}

	return array_slice( $selected, 0, 3 );
}

/**
 * Provide structured contact slots without hardcoding business details.
 *
 * Integrations can supply WhatsApp and phone via the filter; email defaults to
 * WordPress' configured administrative email until a global contact source exists.
 *
 * @return array<string, string>
 */
function leadsun_contact_channels(): array {
	$channels = array(
		'whatsapp' => '',
		'email'    => sanitize_email( get_option( 'admin_email' ) ),
		'phone'    => '',
	);

	return apply_filters( 'leadsun_contact_channels', $channels );
}

/**
 * Find the technology intended for the responsible-lighting section.
 */
function leadsun_home_responsible_technology_id(): int {
	$page_id = leadsun_home_page_id();
	$id      = leadsun_home_entity_id( leadsun_field( 'home_responsible_technology', $page_id ), 'leadsun_technology' );

	if ( $id ) {
		return $id;
	}

	$query = new WP_Query(
		array(
			'post_type'      => 'leadsun_technology',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			's'              => 'Ámbar',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);

	return ! empty( $query->posts[0] ) ? absint( $query->posts[0] ) : 0;
}

/**
 * Render the existing generic card in a manually selected Home slot.
 */
function leadsun_home_render_card( int $post_id ): void {
	$post_id = absint( $post_id );

	if ( ! $post_id || 'publish' !== get_post_status( $post_id ) ) {
		return;
	}

	get_template_part(
		'template-parts/components/entity-card',
		null,
		array(
			'post_id' => $post_id,
		)
	);
}
