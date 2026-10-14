<?php
/**
 * Optional technical and compatibility notes for a technology.
 *
 * Expected $args: post_id.
 *
 * @package Leadsun
 */

$post_id          = absint( $args['post_id'] ?? 0 );
$compatibility    = $post_id ? trim( (string) leadsun_field( 'technology_compatibility_note', $post_id ) ) : '';
$technical_scope  = $post_id ? trim( (string) leadsun_field( 'technology_note', $post_id ) ) : '';

if ( ! $compatibility && ! $technical_scope ) {
	return;
}
?>
<section class="technology-notes" aria-labelledby="technology-notes-title" data-aos="fade-up">
	<h2 id="technology-notes-title"><?php esc_html_e( 'Notas técnicas y de compatibilidad', 'leadsun' ); ?></h2>
	<?php if ( $compatibility ) : ?>
		<div class="technology-notes__item">
			<h3><?php esc_html_e( 'Integración y compatibilidad', 'leadsun' ); ?></h3>
			<?php echo wp_kses_post( wpautop( $compatibility ) ); ?>
		</div>
	<?php endif; ?>
	<?php if ( $technical_scope ) : ?>
		<div class="technology-notes__item">
			<h3><?php esc_html_e( 'Criterio de alcance', 'leadsun' ); ?></h3>
			<?php echo wp_kses_post( wpautop( $technical_scope ) ); ?>
		</div>
	<?php endif; ?>
</section>
