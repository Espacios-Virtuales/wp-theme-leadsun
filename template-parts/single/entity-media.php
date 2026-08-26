<?php
/**
 * Render one media surface for an entity: a validated video or a static image.
 *
 * @package Leadsun
 */

$config    = $args['config'] ?? array();
$post_id   = $args['post_id'] ?? 0;
$poster_url = leadsun_entity_poster_url( $post_id, $config['secondary_field'] ?? '' );
$video      = leadsun_youtube_video( leadsun_field( $config['video_field'] ?? '', $post_id ) );

if ( $video ) :
	$modal_id = leadsun_video_modal_id();
	get_template_part(
		'template-parts/components/video-trigger',
		null,
		array(
			'video'      => $video,
			'modal_id'   => $modal_id,
			'poster_url' => $poster_url,
			'title'      => sprintf( __( 'Reproducir video: %s', 'leadsun' ), get_the_title( $post_id ) ),
		)
	);
	get_template_part( 'template-parts/components/video-modal', null, array( 'modal_id' => $modal_id, 'title' => get_the_title( $post_id ), 'auto_open' => true ) );
else :
	?>
	<figure class="entity-media"><img src="<?php echo esc_url( $poster_url ); ?>" alt=""></figure>
<?php endif; ?>
