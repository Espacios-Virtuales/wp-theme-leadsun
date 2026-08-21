<?php
/**
 * Shared single entity composition.
 *
 * @package Leadsun
 */

$post_type = get_post_type();
$config    = leadsun_entity_config( $post_type );
$post_id   = get_the_ID();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entity-single' ); ?>>
	<?php
	get_template_part(
		'template-parts/components/entity-hero',
		null,
		array(
			'eyebrow'    => $config['label'] ?? '',
			'title'       => get_the_title(),
			'excerpt'     => get_the_excerpt(),
			'poster_url'  => leadsun_entity_poster_url( $post_id, $config['secondary_field'] ?? '' ),
		)
	);
	?>
	<div class="leadsun-container entity-single__layout">
		<div class="entity-single__main">
			<?php get_template_part( 'template-parts/single/entity-meta', null, array( 'post_type' => $post_type, 'post_id' => $post_id ) ); ?>
			<div class="entity-single__content"><?php the_content(); ?></div>
			<?php
			$document_url = leadsun_entity_document_url( $config['document_field'] ?? '', $post_id );
			if ( $document_url && ! empty( $config['document_label'] ) ) :
				?>
				<a class="btn-leadsun-outline" href="<?php echo esc_url( $document_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $config['document_label'] ); ?></a>
			<?php endif; ?>
		</div>
		<aside class="entity-single__aside">
			<?php get_template_part( 'template-parts/single/entity-media', null, array( 'config' => $config, 'post_id' => $post_id ) ); ?>
			<?php if ( 'leadsun_project' === $post_type ) : ?>
				<?php get_template_part( 'template-parts/single/entity-relations', null, array( 'post_id' => $post_id ) ); ?>
			<?php endif; ?>
		</aside>
	</div>
</article>
