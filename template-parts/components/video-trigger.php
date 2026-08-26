<?php
/**
 * Video modal trigger.
 *
 * Expected $args: video (validated contract), modal_id, poster_url, title.
 *
 * @package Leadsun
 */

if ( empty( $args['video']['embed_url'] ) || empty( $args['modal_id'] ) ) {
	return;
}

$poster_url = ! empty( $args['poster_url'] ) ? $args['poster_url'] : leadsun_media_fallback_url();
$title      = ! empty( $args['title'] ) ? $args['title'] : __( 'Reproducir video', 'leadsun' );
?>
<button
	type="button"
	class="video-trigger"
	data-video-modal-trigger
	data-video-modal-target="<?php echo esc_attr( $args['modal_id'] ); ?>"
	data-video-embed-url="<?php echo esc_url( $args['video']['embed_url'] ); ?>"
	data-video-title="<?php echo esc_attr( $title ); ?>"
>
	<img src="<?php echo esc_url( $poster_url ); ?>" alt="" loading="lazy">
	<span class="video-trigger__play" aria-hidden="true">▶</span>
	<span class="screen-reader-text"><?php echo esc_html( $title ); ?></span>
</button>
