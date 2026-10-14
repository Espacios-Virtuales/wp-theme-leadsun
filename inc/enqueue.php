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
		'leadsun-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'leadsun-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		leadsun_asset_version( '/assets/css/main.css' )
	);

	wp_enqueue_script(
		'leadsun-aos',
		get_template_directory_uri() . '/assets/js/vendor/aos.js',
		array(),
		leadsun_asset_version( '/assets/js/vendor/aos.js' ),
		true
	);

	wp_enqueue_script(
		'leadsun-app',
		get_template_directory_uri() . '/assets/js/app.js',
		array( 'leadsun-aos' ),
		leadsun_asset_version( '/assets/js/app.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'leadsun_enqueue_assets' );
