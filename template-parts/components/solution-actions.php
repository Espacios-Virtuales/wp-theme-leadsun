<?php
/**
 * Conditional solution actions.
 *
 * Expected $args: post_id, config.
 *
 * @package Leadsun
 */

$post_id      = absint( $args['post_id'] ?? 0 );
$config       = isset( $args['config'] ) && is_array( $args['config'] ) ? $args['config'] : array();
$document_url = leadsun_entity_document_url( (string) ( $config['document_field'] ?? '' ), $post_id );
$certificates = trim( (string) leadsun_field( 'solution_certifications', $post_id ) );

if ( ! $post_id || ( ! $document_url && ! $certificates ) ) {
	return;
}
?>
<section class="solution-actions" aria-label="<?php esc_attr_e( 'Acciones de la solución', 'leadsun' ); ?>" data-aos="fade-up">
	<?php if ( $document_url ) : ?><a class="btn-leadsun-outline" href="<?php echo esc_url( $document_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $config['document_label'] ?? __( 'Descargar ficha técnica', 'leadsun' ) ); ?></a><?php endif; ?>
	<?php if ( $certificates ) : ?><a class="btn-leadsun-outline" href="#certificaciones"><?php esc_html_e( 'Ver certificaciones', 'leadsun' ); ?></a><?php endif; ?>
</section>
