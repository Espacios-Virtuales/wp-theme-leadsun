<?php
/**
 * Site header.
 *
 * @package Leadsun
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Saltar al contenido', 'leadsun' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container leadsun-header__inner">
			<div class="site-branding">
				<?php the_custom_logo(); ?>
			</div>

			<button class="menu-toggle" type="button" aria-controls="primary-menu" aria-expanded="false">
				<span class="menu-toggle__label"><?php esc_html_e( 'Menú', 'leadsun' ); ?></span>
			</button>

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Navegación principal', 'leadsun' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		</div>
	</header>
