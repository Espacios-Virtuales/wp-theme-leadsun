<?php
/**
 * Direct responsive YouTube embed without poster, modal, or autoplay.
 *
 * Expected $args: video (validated contract), title.
 *
 * @package Leadsun
 */

if ( empty( $args['video']['embed_url'] ) ) {
	return;
}

$title = ! empty( $args['title'] ) ? $args['title'] : __( 'Video LEADSUN', 'leadsun' );
?>
<div class="video-responsive">
	<iframe
		src="<?php echo esc_url( $args['video']['embed_url'] ); ?>"
		title="<?php echo esc_attr( $title ); ?>"
		loading="lazy"
		allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; web-share"
		referrerpolicy="strict-origin-when-cross-origin"
		allowfullscreen
	></iframe>
</div>
