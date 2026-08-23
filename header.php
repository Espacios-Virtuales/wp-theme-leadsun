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
		<div class="container leadsun-header__inner navbar navbar-expand-lg">
			<div class="site-branding">
				<?php the_custom_logo(); ?>
			</div>

			<button class="navbar-toggler menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Alternar navegación principal', 'leadsun' ); ?>">
				<span class="navbar-toggler-icon" aria-hidden="true"></span>
			</button>

			<nav id="site-navigation" class="main-navigation collapse navbar-collapse" aria-label="<?php esc_attr_e( 'Navegación principal', 'leadsun' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'navbar-nav ms-auto',
						'container'      => false,
						'fallback_cb'    => 'leadsun_primary_navigation_fallback',
					)
				);
				?>
			</nav>
			<a class="btn-leadsun leadsun-header__cta" href="<?php echo esc_url( leadsun_quote_page_url() ); ?>"><?php esc_html_e( 'Cotizar proyecto', 'leadsun' ); ?></a>
		</div>
	</header>
