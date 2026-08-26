<?php
/**
 * Reusable video modal shell. Its iframe is inserted only after interaction.
 *
 * Expected $args: modal_id, title.
 *
 * @package Leadsun
 */

if ( empty( $args['modal_id'] ) ) {
	return;
}

$title     = ! empty( $args['title'] ) ? $args['title'] : __( 'Video', 'leadsun' );
$auto_open = ! empty( $args['auto_open'] );
?>
<div id="<?php echo esc_attr( $args['modal_id'] ); ?>" class="video-modal" data-video-modal<?php echo $auto_open ? ' data-video-modal-auto-open' : ''; ?> hidden>
	<div class="video-modal__backdrop" aria-hidden="true"></div>
	<div class="video-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="<?php echo esc_attr( $args['modal_id'] ); ?>-title">
		<h2 id="<?php echo esc_attr( $args['modal_id'] ); ?>-title" class="screen-reader-text"><?php echo esc_html( $title ); ?></h2>
		<button type="button" class="video-modal__close" data-video-modal-close aria-label="<?php esc_attr_e( 'Cerrar video', 'leadsun' ); ?>">×</button>
		<div class="video-modal__frame" data-video-modal-frame></div>
	</div>
</div>
