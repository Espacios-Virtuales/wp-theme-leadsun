<?php
/**
 * Site footer.
 *
 * @package Leadsun
 */
?>
	<footer id="colophon" class="site-footer">
		<div class="container leadsun-footer__inner">
			<div class="leadsun-footer__brand">
				<?php the_custom_logo(); ?>
				<p><?php esc_html_e( 'Iluminación profesional para infraestructura.', 'leadsun' ); ?></p>
			</div>
			<nav class="leadsun-footer__nav" aria-label="<?php esc_attr_e( 'Navegación de pie', 'leadsun' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'fallback_cb'    => 'leadsun_primary_navigation_fallback',
					)
				);
				?>
			</nav>
			<div class="leadsun-footer__links">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'leadsun_project' ) ); ?>"><?php esc_html_e( 'Proyectos', 'leadsun' ); ?></a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'leadsun_technology' ) ); ?>"><?php esc_html_e( 'Tecnología', 'leadsun' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/#certificaciones' ) ); ?>"><?php esc_html_e( 'Certificaciones', 'leadsun' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/#contacto' ) ); ?>"><?php esc_html_e( 'Contacto', 'leadsun' ); ?></a>
			</div>
			<p class="site-footer__copyright">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
			</p>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
