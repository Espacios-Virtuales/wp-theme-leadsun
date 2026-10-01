<?php
/**
 * Render direct video or featured image beside a static entity gallery.
 *
 * @package Leadsun
 */

$config       = $args['config'] ?? array();
$post_id      = absint( $args['post_id'] ?? 0 );
$video_field  = $config['video_field'] ?? '';
$video        = $video_field ? leadsun_youtube_video( leadsun_field( $video_field, $post_id ) ) : null;
$featured_id  = absint( get_post_thumbnail_id( $post_id ) );
$logo_id      = absint( get_theme_mod( 'custom_logo' ) );
$gallery_ids  = array();
$gallery_fields = $config['gallery_fields'] ?? array( $config['secondary_field'] ?? '' );

foreach ( $gallery_fields as $field_name ) {
	if ( ! $field_name ) {
		continue;
	}

	$image = leadsun_field( $field_name, $post_id );
	$image = is_array( $image ) ? absint( $image['ID'] ?? $image['id'] ?? 0 ) : absint( $image );
	if ( $image ) {
		$gallery_ids[] = $image;
	}
}

$gallery_ids = array_slice( array_values( array_unique( array_diff( $gallery_ids, array( $featured_id ) ) ) ), 0, 3 );
$has_primary = $video || $featured_id || $logo_id;
$layout_class = $has_primary ? ( $gallery_ids ? ' entity-media-layout--has-primary' : ' entity-media-layout--primary-only' ) : ' entity-media-layout--gallery-only';

if ( ! $has_primary && ! $gallery_ids ) {
	$layout_class = ' entity-media-layout--primary-only';
}
?>
<section class="entity-media-layout<?php echo esc_attr( $layout_class ); ?>" aria-label="<?php esc_attr_e( 'Contenido multimedia', 'leadsun' ); ?>">
	<?php if ( $has_primary ) : ?>
		<div class="entity-media-layout__primary">
			<?php if ( $video ) : ?>
				<?php get_template_part( 'template-parts/components/video-responsive', null, array( 'video' => $video, 'title' => sprintf( __( 'Video de %s', 'leadsun' ), get_the_title( $post_id ) ) ) ); ?>
			<?php elseif ( $featured_id ) : ?>
				<figure class="entity-media"><?php echo wp_get_attachment_image( $featured_id, 'large', false, array( 'decoding' => 'async' ) ); ?></figure>
			<?php elseif ( $logo_id ) : ?>
				<figure class="entity-media entity-media--logo"><?php echo wp_get_attachment_image( $logo_id, 'full', false, array( 'decoding' => 'async', 'alt' => get_bloginfo( 'name' ) ) ); ?></figure>
			<?php else : ?>
				<figure class="entity-media entity-media--logo"><img src="<?php echo esc_url( leadsun_media_fallback_url() ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></figure>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if ( $gallery_ids ) : ?>
		<?php get_template_part( 'template-parts/components/entity-gallery', null, array( 'image_ids' => $gallery_ids ) ); ?>
	<?php endif; ?>
</section>
