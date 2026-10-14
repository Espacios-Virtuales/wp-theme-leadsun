<?php
/**
 * Direct responsive, muted autoplay YouTube embed without poster or modal.
 *
 * Expected $args: video (validated contract), title.
 *
 * @package Leadsun
 */

if ( empty( $args['video']['embed_url'] ) ) {
	return;
}

$title = ! empty( $args['title'] ) ? $args['title'] : __( 'Video LEADSUN', 'leadsun' );
$embed_url = add_query_arg(
	array(
		'autoplay'    => '1',
		'mute'        => '1',
		'playsinline' => '1',
		'controls'     => '1',
		'rel'          => '0',
	),
	$args['video']['embed_url']
);
?>
<div class="video-responsive">
	<iframe
		src="<?php echo esc_url( $embed_url ); ?>"
		title="<?php echo esc_attr( $title ); ?>"
		allow="autoplay; accelerometer; encrypted-media; gyroscope; picture-in-picture; web-share"
		referrerpolicy="strict-origin-when-cross-origin"
		allowfullscreen
	></iframe>
</div>
