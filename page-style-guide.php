<?php
/**
 * Template Name: LEADSUN Style Guide
 *
 * Local visual foundation preview. Assign manually only when a design review is needed.
 *
 * @package Leadsun
 */

get_header();
?>
<main id="primary" class="site-main">
	<section class="leadsun-section">
		<div class="leadsun-container">
			<header class="leadsun-section__header">
				<p class="leadsun-eyebrow"><?php esc_html_e( 'Foundation preview', 'leadsun' ); ?></p>
				<h1><?php esc_html_e( 'Sistema visual LEADSUN', 'leadsun' ); ?></h1>
				<p><?php esc_html_e( 'Superficie local para revisar jerarquía, interacción y componentes reutilizables.', 'leadsun' ); ?></p>
				<div class="d-flex flex-wrap gap-3">
					<a class="btn-leadsun" href="#form"><?php esc_html_e( 'Acción principal', 'leadsun' ); ?></a>
					<a class="btn-leadsun-outline" href="#card"><?php esc_html_e( 'Acción secundaria', 'leadsun' ); ?></a>
				</div>
			</header>

			<div class="leadsun-grid" id="card">
				<article class="leadsun-card">
					<div class="leadsun-card__media leadsun-media" aria-hidden="true"></div>
					<div class="leadsun-card__body">
						<p class="leadsun-card__meta"><?php esc_html_e( 'Componente reusable', 'leadsun' ); ?></p>
						<h2 class="leadsun-card__title"><?php esc_html_e( 'Card foundation', 'leadsun' ); ?></h2>
						<p><?php esc_html_e( 'Superficie oscura, media adaptable y estados sobrios.', 'leadsun' ); ?></p>
						<span class="leadsun-card__action"><?php esc_html_e( 'Ver detalle', 'leadsun' ); ?></span>
					</div>
				</article>
			</div>
		</div>
	</section>

	<section class="leadsun-section leadsun-section--surface" id="form">
		<div class="leadsun-container">
			<div class="leadsun-section__header">
				<p class="leadsun-eyebrow"><?php esc_html_e( 'Form controls', 'leadsun' ); ?></p>
				<h2><?php esc_html_e( 'Base de formulario', 'leadsun' ); ?></h2>
			</div>
			<form class="leadsun-form" action="#" method="post" novalidate>
				<div class="leadsun-field">
					<label for="style-guide-name"><?php esc_html_e( 'Nombre', 'leadsun' ); ?></label>
					<input id="style-guide-name" type="text" placeholder="<?php esc_attr_e( 'Ejemplo', 'leadsun' ); ?>">
					<p class="leadsun-form__help"><?php esc_html_e( 'Texto de ayuda de ejemplo.', 'leadsun' ); ?></p>
				</div>
				<div class="leadsun-field">
					<label for="style-guide-message"><?php esc_html_e( 'Mensaje', 'leadsun' ); ?></label>
					<textarea id="style-guide-message" placeholder="<?php esc_attr_e( 'Escribe una prueba visual', 'leadsun' ); ?>"></textarea>
				</div>
				<button class="btn-leadsun" type="button"><?php esc_html_e( 'Botón de prueba', 'leadsun' ); ?></button>
			</form>
		</div>
	</section>
</main>
<?php get_footer(); ?>
