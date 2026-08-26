<?php
/**
 * Lazy inline YouTube video shell for Home compositions.
 *
 * @package Leadsun
 */

if ( empty( $args['video']['embed_url'] ) ) {
	return;
}

$poster_url = ! empty( $args['poster_url'] ) ? $args['poster_url'] : leadsun_media_fallback_url();
$title      = ! empty( $args['title'] ) ? $args['title'] : __( 'Video LEADSUN', 'leadsun' );
$class_name = ! empty( $args['class_name'] ) ? ' ' . $args['class_name'] : '';
?>
<div class="video-inline<?php echo esc_attr( $class_name ); ?>" data-video-inline data-video-embed-url="<?php echo esc_url( $args['video']['embed_url'] ); ?>" data-video-title="<?php echo esc_attr( $title ); ?>">
	<img class="video-inline__poster" src="<?php echo esc_url( $poster_url ); ?>" alt="" aria-hidden="true">
	<div class="video-inline__frame" data-video-inline-frame></div>
	<button class="video-inline__fallback" type="button" data-video-inline-trigger><span class="screen-reader-text"><?php echo esc_html( $title ); ?></span><span aria-hidden="true">▶</span></button>
</div>
