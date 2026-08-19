<?php
/**
 * Front-end assets.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a cache-busting version based on file modification time when available.
 */
function leadsun_asset_version( string $relative_path ): string {
	$absolute_path = get_template_directory() . $relative_path;

	if ( file_exists( $absolute_path ) ) {
		return (string) filemtime( $absolute_path );
	}

	return LEADSUN_THEME_VERSION;
}

function leadsun_enqueue_assets(): void {
	wp_enqueue_style(
		'leadsun-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		leadsun_asset_version( '/assets/css/main.css' )
	);

	wp_enqueue_script(
		'leadsun-app',
		get_template_directory_uri() . '/assets/js/app.js',
		array(),
		leadsun_asset_version( '/assets/js/app.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'leadsun_enqueue_assets' );
