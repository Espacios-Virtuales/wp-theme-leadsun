<?php
/**
 * Reusable, validated YouTube and poster helpers.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Convert a supported YouTube URL into a safe embed contract.
 *
 * @param mixed $url Candidate URL.
 * @return array{id: string, embed_url: string}|null
 */
function leadsun_youtube_video( $url ): ?array {
	if ( ! is_string( $url ) || '' === trim( $url ) ) {
		return null;
	}

	$parts = wp_parse_url( trim( $url ) );
	if ( ! is_array( $parts ) || ! isset( $parts['scheme'], $parts['host'] ) || 'https' !== strtolower( $parts['scheme'] ) ) {
		return null;
	}

	$host = strtolower( $parts['host'] );
	$path = trim( $parts['path'] ?? '', '/' );
	$id   = '';

	if ( in_array( $host, array( 'youtu.be', 'www.youtu.be' ), true ) ) {
		$id = strtok( $path, '/' );
	} elseif ( in_array( $host, array( 'youtube.com', 'www.youtube.com', 'm.youtube.com' ), true ) ) {
		if ( 'watch' === $path && ! empty( $parts['query'] ) ) {
			parse_str( $parts['query'], $query );
			$id = isset( $query['v'] ) && is_string( $query['v'] ) ? $query['v'] : '';
		} elseif ( 0 === strpos( $path, 'embed/' ) ) {
			$id = substr( $path, strlen( 'embed/' ) );
			$id = strtok( $id, '/' );
		}
	}

	if ( ! is_string( $id ) || 1 !== preg_match( '/^[A-Za-z0-9_-]{11}$/', $id ) ) {
		return null;
	}

	return array(
		'id'        => $id,
		'embed_url' => 'https://www.youtube-nocookie.com/embed/' . $id,
	);
}

/**
 * Return a local neutral fallback when an entity has no available image.
 */
function leadsun_media_fallback_url(): string {
	return get_template_directory_uri() . '/assets/img/media-fallback.svg';
}

/**
 * Resolve the poster for an entity: featured image, optional ACF image, fallback.
 *
 * @param int|null $post_id         Entity ID. Defaults to the current post.
 * @param string   $secondary_field Optional ACF image field name.
 */
function leadsun_entity_poster_url( ?int $post_id = null, string $secondary_field = '' ): string {
	$id        = $post_id ?: get_the_ID();
	$featured  = $id ? get_the_post_thumbnail_url( $id, 'large' ) : false;

	if ( is_string( $featured ) && '' !== $featured ) {
		return $featured;
	}

	if ( $id && '' !== $secondary_field ) {
		$secondary = leadsun_field( $secondary_field, $id );

		if ( is_array( $secondary ) && isset( $secondary['url'] ) && is_string( $secondary['url'] ) ) {
			return $secondary['url'];
		}

		if ( is_numeric( $secondary ) ) {
			$url = wp_get_attachment_image_url( absint( $secondary ), 'large' );
			if ( is_string( $url ) && '' !== $url ) {
				return $url;
			}
		}
	}

	return leadsun_media_fallback_url();
}

/**
 * Generate an ID shared by a video trigger and its modal instance.
 */
function leadsun_video_modal_id(): string {
	return wp_unique_id( 'leadsun-video-modal-' );
}
