<?php
/**
 * Shared card for solution, technology, and project records.
 *
 * @package Leadsun
 */

$post_type = get_post_type();
$config    = leadsun_entity_config( $post_type );
$poster    = leadsun_entity_poster_url( get_the_ID(), $config['secondary_field'] ?? '' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entity-card' ); ?>>
	<a class="entity-card__link" href="<?php the_permalink(); ?>">
		<img class="entity-card__media" src="<?php echo esc_url( $poster ); ?>" alt="" loading="lazy">
		<div class="entity-card__body">
			<p class="entity-card__eyebrow"><?php echo esc_html( $config['label'] ?? '' ); ?></p>
			<?php the_title( '<h2 class="entity-card__title">', '</h2>' ); ?>
			<?php if ( has_excerpt() ) : ?><div class="entity-card__excerpt"><?php the_excerpt(); ?></div><?php endif; ?>
			<span class="entity-card__action"><?php esc_html_e( 'Ver detalle', 'leadsun' ); ?></span>
		</div>
	</a>
</article>
