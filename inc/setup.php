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
	$items     = array(
		__( 'Inicio', 'leadsun' )       => home_url( '/' ),
		__( 'Solar', 'leadsun' )        => leadsun_solution_landing_url( 'solar' ),
		__( 'Eléctrica', 'leadsun' )    => leadsun_solution_landing_url( 'electrica' ),
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

/**
 * Keep the Solar and Eléctrica menu entries routed to their editable pages.
 *
 * Menu structure and labels remain managed in WordPress; only these two
 * destinations are resolved from the pages created for their solution lines.
 *
 * @param WP_Post[] $items Menu items.
 * @param stdClass  $args  Menu arguments.
 * @return WP_Post[]
 */
function leadsun_primary_navigation_solution_landings( array $items, $args ): array {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}

	$landing_slugs = array(
		'solar'     => 'solar',
		'electrica' => 'electrica',
	);

	foreach ( $items as $item ) {
		$label = sanitize_title( wp_strip_all_tags( $item->title ) );
		if ( isset( $landing_slugs[ $label ] ) ) {
			$item->url = leadsun_solution_landing_url( $landing_slugs[ $label ] );
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'leadsun_primary_navigation_solution_landings', 10, 2 );

function leadsun_content_width(): void {
	$GLOBALS['content_width'] = (int) apply_filters( 'leadsun_content_width', 1320 );
}
add_action( 'after_setup_theme', 'leadsun_content_width', 0 );
