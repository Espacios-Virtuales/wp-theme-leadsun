<?php
/**
 * Site footer.
 *
 * @package Leadsun
 */
?>
	<footer id="colophon" class="site-footer">
		<div class="container leadsun-footer__inner">
			<nav aria-label="<?php esc_attr_e( 'Navegación de pie', 'leadsun' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
			<p class="site-footer__copyright">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
			</p>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
