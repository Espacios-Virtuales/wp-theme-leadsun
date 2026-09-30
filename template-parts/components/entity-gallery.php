<?php
/**
 * Static responsive gallery for LEADSUN entities; images do not open overlays.
 *
 * Expected $args: image_ids.
 *
 * @package Leadsun
 */

$image_ids = isset( $args['image_ids'] ) && is_array( $args['image_ids'] ) ? array_slice( array_values( array_unique( array_filter( array_map( 'absint', $args['image_ids'] ) ) ) ), 0, 3 ) : array();

if ( ! $image_ids ) {
	return;
}
?>
<div class="entity-gallery">
	<?php foreach ( $image_ids as $image_id ) : ?>
		<figure><?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?></figure>
	<?php endforeach; ?>
</div>
