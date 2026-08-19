<?php
/**
 * Safe ACF helpers.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Read an ACF field without making templates depend directly on ACF.
 *
 * @param string   $key     Field name.
 * @param int|null $post_id Optional post ID.
 * @param mixed    $default Default value.
 * @return mixed
 */
function leadsun_field( string $key, ?int $post_id = null, $default = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = get_field( $key, $post_id ?: false );
	return ( null === $value || '' === $value ) ? $default : $value;
}
