<?php
/**
 * Theme setup.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function leadsun_theme_setup(): void {
	load_theme_textdomain( 'leadsun', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );

	add_theme_support(
		'html5',
		array(
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Navegación principal', 'leadsun' ),
			'footer'  => __( 'Navegación de pie', 'leadsun' ),
		)
	);
}
add_action( 'after_setup_theme', 'leadsun_theme_setup' );

function leadsun_content_width(): void {
	$GLOBALS['content_width'] = (int) apply_filters( 'leadsun_content_width', 1320 );
}
add_action( 'after_setup_theme', 'leadsun_content_width', 0 );
