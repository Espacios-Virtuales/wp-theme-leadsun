<?php
/**
 * Shared card for solution, technology, and project records.
 *
 * @package Leadsun
 */

$post_id = absint( $args['post_id'] ?? get_the_ID() );

if ( ! $post_id ) {
	return;
}

$entity = get_post( $post_id );
if ( ! $entity instanceof WP_Post ) {
	return;
}

$post_type = get_post_type( $post_id );
$config    = leadsun_entity_config( $post_type );
$title     = get_the_title( $post_id );
$permalink = get_permalink( $post_id );
$excerpt   = get_the_excerpt( $post_id );
$poster    = leadsun_entity_poster_url( $post_id, $config['secondary_field'] ?? '' );
$classes   = get_post_class( 'entity-card', $post_id );
?>
<article id="post-<?php echo esc_attr( $post_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<a class="entity-card__link" href="<?php echo esc_url( $permalink ); ?>">
		<img class="entity-card__media" src="<?php echo esc_url( $poster ); ?>" alt="" loading="lazy">
		<div class="entity-card__body">
			<p class="entity-card__eyebrow"><?php echo esc_html( $config['label'] ?? '' ); ?></p>
			<h2 class="entity-card__title"><?php echo esc_html( $title ); ?></h2>
			<?php if ( $excerpt ) : ?><div class="entity-card__excerpt"><?php echo wp_kses_post( $excerpt ); ?></div><?php endif; ?>
			<span class="entity-card__action"><?php esc_html_e( 'Ver detalle', 'leadsun' ); ?></span>
		</div>
	</a>
</article>
