<?php
/**
 * 404 template.
 *
 * @package Leadsun
 */

get_header();
?>
<main id="primary" class="site-main container">
	<section class="error-404 not-found">
		<h1><?php esc_html_e( 'Página no encontrada', 'leadsun' ); ?></h1>
		<p><?php esc_html_e( 'La dirección solicitada no está disponible.', 'leadsun' ); ?></p>
		<?php get_search_form(); ?>
	</section>
</main>
<?php
get_footer();
