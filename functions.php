<?php
/**
 * LEADSUN Chile theme bootstrap.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'LEADSUN_THEME_VERSION' ) ) {
	define( 'LEADSUN_THEME_VERSION', '0.1.0' );
}

require_once get_template_directory() . '/inc/init.php';

/**
 * Adapta enlaces personalizados del menú entre localhost y túneles.
 *
 * Los enlaces guardados como:
 * http://localhost/leadsun/proyectos/
 *
 * pasan dinámicamente a:
 * https://xxxxx.ngrok-free.app/leadsun/proyectos/
 *
 * cuando WP_HOME está siendo sobrescrito por ngrok.
 */
add_filter('wp_nav_menu_objects', function ($items) {

    $local_base   = 'http://localhost/leadsun';
    $current_base = untrailingslashit(home_url());

    foreach ($items as $item) {
        if (
            isset($item->url) &&
            str_starts_with($item->url, $local_base)
        ) {
            $relative  = substr($item->url, strlen($local_base));
            $item->url = $current_base . $relative;
        }
    }

    return $items;
});