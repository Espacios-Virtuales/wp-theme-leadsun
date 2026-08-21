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
			'primary'          => __( 'Navegación principal', 'leadsun' ),
			'footer_segment_1' => __( 'Footer · Soluciones', 'leadsun' ),
			'footer_segment_2' => __( 'Footer · Navegación', 'leadsun' ),
			'footer_segment_3' => __( 'Footer · Contacto', 'leadsun' ),
			'social'           => __( 'Redes sociales', 'leadsun' ),
		)
	);
}
add_action( 'after_setup_theme', 'leadsun_theme_setup' );

/**
 * Keep the local demo navigable when no WordPress menu has been assigned yet.
 */
function leadsun_primary_navigation_fallback(): void {
	$solar     = get_term_by( 'name', 'Solar', 'leadsun_solution_line' );
	$electric  = get_term_by( 'name', 'Eléctrica', 'leadsun_solution_line' );
	$items     = array(
		__( 'Inicio', 'leadsun' )       => home_url( '/' ),
		__( 'Solar', 'leadsun' )        => $solar ? get_term_link( $solar ) : get_post_type_archive_link( 'leadsun_solution' ),
		__( 'Eléctrica', 'leadsun' )    => $electric ? get_term_link( $electric ) : get_post_type_archive_link( 'leadsun_solution' ),
		__( 'Proyectos', 'leadsun' )    => get_post_type_archive_link( 'leadsun_project' ),
		__( 'Tecnología', 'leadsun' )   => get_post_type_archive_link( 'leadsun_technology' ),
		__( 'Contacto', 'leadsun' )     => home_url( '/#contacto' ),
	);

	echo '<ul id="primary-menu" class="navbar-nav ms-auto">';
	foreach ( $items as $label => $url ) {
		if ( $url ) {
			echo '<li class="menu-item"><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
		}
	}
	echo '</ul>';
}

function leadsun_content_width(): void {
	$GLOBALS['content_width'] = (int) apply_filters( 'leadsun_content_width', 1320 );
}
add_action( 'after_setup_theme', 'leadsun_content_width', 0 );
