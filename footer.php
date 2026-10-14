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
				<p><strong><?php esc_html_e( 'LEADSUN CHILE', 'leadsun' ); ?></strong><br><?php esc_html_e( 'Ingeniería e iluminación para infraestructura.', 'leadsun' ); ?></p>
			</div>
			<nav class="leadsun-footer__segment" aria-label="<?php esc_attr_e( 'Footer soluciones', 'leadsun' ); ?>">
				<p class="leadsun-footer__heading"><?php esc_html_e( 'Soluciones', 'leadsun' ); ?></p>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer_segment_1',
						'container'      => false,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
			<nav class="leadsun-footer__segment" aria-label="<?php esc_attr_e( 'Footer navegación', 'leadsun' ); ?>">
				<p class="leadsun-footer__heading"><?php esc_html_e( 'Navegación', 'leadsun' ); ?></p>
				<?php wp_nav_menu( array( 'theme_location' => 'footer_segment_2', 'container' => false, 'fallback_cb' => false ) ); ?>
			</nav>
			<div class="leadsun-footer__segment leadsun-footer__contact">
				<p class="leadsun-footer__heading"><?php esc_html_e( 'Contacto', 'leadsun' ); ?></p>
				<?php wp_nav_menu( array( 'theme_location' => 'footer_segment_3', 'container' => false, 'fallback_cb' => false ) ); ?>
				<?php $footer_channels = leadsun_contact_channels(); ?>
				<?php if ( ! empty( $footer_channels['whatsapp'] ) || ! empty( $footer_channels['email'] ) ) : ?>
					<ul class="leadsun-footer__channels">
						<?php if ( ! empty( $footer_channels['whatsapp'] ) && leadsun_whatsapp_url() ) : ?><li><a href="<?php echo esc_url( leadsun_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp', 'leadsun' ); ?></a></li><?php endif; ?>
						<?php if ( ! empty( $footer_channels['email'] ) ) : ?><li><a href="mailto:<?php echo esc_attr( antispambot( $footer_channels['email'] ) ); ?>"><?php esc_html_e( 'Correo', 'leadsun' ); ?></a></li><?php endif; ?>
					</ul>
				<?php endif; ?>
				<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Redes sociales', 'leadsun' ); ?>">
					<?php wp_nav_menu( array( 'theme_location' => 'social', 'container' => false, 'menu_class' => 'social-navigation__list', 'fallback_cb' => false ) ); ?>
				</nav>
			</div>
			<p class="site-footer__copyright">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
			</p>
		</div>
	</footer>
</div>
<?php $leadsun_whatsapp_url = leadsun_whatsapp_url(); ?>
<?php if ( $leadsun_whatsapp_url ) : ?>
	<a class="leadsun-whatsapp-float" href="<?php echo esc_url( $leadsun_whatsapp_url ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Hablar por WhatsApp', 'leadsun' ); ?>"><span aria-hidden="true">WA</span></a>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
