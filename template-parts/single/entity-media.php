<?php
/**
 * Optional secondary image and validated video for an entity.
 *
 * @package Leadsun
 */

$config   = $args['config'] ?? array();
$post_id  = $args['post_id'] ?? 0;
$secondary = leadsun_field( $config['secondary_field'] ?? '', $post_id );
$image_url = '';

if ( is_array( $secondary ) && isset( $secondary['url'] ) ) {
	$image_url = $secondary['url'];
} elseif ( is_numeric( $secondary ) ) {
	$image_url = wp_get_attachment_image_url( absint( $secondary ), 'large' );
}

if ( $image_url ) :
	?>
	<figure class="entity-media"><img src="<?php echo esc_url( $image_url ); ?>" alt=""></figure>
<?php endif; ?>

<?php
$video = leadsun_youtube_video( leadsun_field( $config['video_field'] ?? '', $post_id ) );
if ( $video ) :
	$modal_id = leadsun_video_modal_id();
	get_template_part(
		'template-parts/components/video-trigger',
		null,
		array(
			'video'      => $video,
			'modal_id'   => $modal_id,
			'poster_url' => leadsun_entity_poster_url( $post_id, $config['secondary_field'] ?? '' ),
			'title'      => sprintf( __( 'Reproducir video: %s', 'leadsun' ), get_the_title( $post_id ) ),
		)
	);
	get_template_part( 'template-parts/components/video-modal', null, array( 'modal_id' => $modal_id, 'title' => get_the_title( $post_id ) ) );
endif;
?>
