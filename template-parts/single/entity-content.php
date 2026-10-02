<?php
/**
 * Shared, responsive single composition for the existing LEADSUN entities.
 *
 * @package Leadsun
 */

$post_type = get_post_type();
$config    = leadsun_entity_config( $post_type );
$post_id   = get_the_ID();
$excerpt   = trim( (string) get_post_field( 'post_excerpt', $post_id ) );
$content   = trim( (string) get_post_field( 'post_content', $post_id ) );
$excerpt_text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( $excerpt ) ) );
$content_text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( $content ) ) );
$show_content = '' !== $content_text && $content_text !== $excerpt_text;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entity-single' ); ?>>
	<?php
	get_template_part(
		'template-parts/components/entity-hero',
		null,
		array(
			'eyebrow' => $config['label'] ?? '',
			'title'   => get_the_title(),
			'compact' => true,
		)
	);
	?>
	<?php if ( 'leadsun_solution' === $post_type ) : ?>
		<div class="leadsun-container entity-single__identity-meta" data-aos="fade-up">
			<?php get_template_part( 'template-parts/single/entity-meta', null, array( 'post_type' => $post_type, 'post_id' => $post_id ) ); ?>
		</div>
	<?php endif; ?>
	<div class="leadsun-container entity-single__layout">
		<?php get_template_part( 'template-parts/single/entity-media', null, array( 'config' => $config, 'post_id' => $post_id ) ); ?>

		<?php if ( $excerpt || $show_content ) : ?>
			<section class="entity-single__description" aria-labelledby="entity-description-title" data-aos="fade-up">
				<h2 id="entity-description-title"><?php esc_html_e( 'Descripción', 'leadsun' ); ?></h2>
				<?php if ( $excerpt ) : ?><p class="entity-single__excerpt"><?php echo esc_html( $excerpt ); ?></p><?php endif; ?>
				<?php if ( $show_content ) : ?><div class="entity-single__content entry-content"><?php echo apply_filters( 'the_content', $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><?php endif; ?>
			</section>
		<?php endif; ?>

		<?php if ( 'leadsun_solution' === $post_type ) : ?>
			<?php get_template_part( 'template-parts/components/solution-highlight', null, array( 'post_id' => $post_id ) ); ?>
			<?php get_template_part( 'template-parts/components/entity-text-list', null, array( 'post_id' => $post_id, 'field' => 'solution_benefits', 'title' => __( 'Beneficios', 'leadsun' ), 'id' => 'beneficios' ) ); ?>
			<?php get_template_part( 'template-parts/components/entity-specifications', null, array( 'post_id' => $post_id ) ); ?>
			<?php get_template_part( 'template-parts/components/entity-text-list', null, array( 'post_id' => $post_id, 'field' => 'solution_applications', 'title' => __( 'Aplicaciones', 'leadsun' ), 'id' => 'aplicaciones' ) ); ?>
			<?php get_template_part( 'template-parts/components/entity-text-list', null, array( 'post_id' => $post_id, 'field' => 'solution_certifications', 'title' => __( 'Certificaciones', 'leadsun' ), 'id' => 'certificaciones' ) ); ?>
			<?php get_template_part( 'template-parts/components/solution-actions', null, array( 'post_id' => $post_id, 'config' => $config ) ); ?>
		<?php endif; ?>

		<?php if ( 'leadsun_project' === $post_type ) : ?>
			<?php get_template_part( 'template-parts/single/entity-meta', null, array( 'post_type' => $post_type, 'post_id' => $post_id ) ); ?>
			<?php get_template_part( 'template-parts/single/project-details', null, array( 'post_id' => $post_id ) ); ?>
		<?php endif; ?>

		<?php if ( in_array( $post_type, array( 'leadsun_solution', 'leadsun_technology', 'leadsun_project' ), true ) ) : ?>
			<?php get_template_part( 'template-parts/single/entity-relations', null, array( 'post_id' => $post_id ) ); ?>
		<?php endif; ?>
	</div>

	<?php if ( 'leadsun_solution' === $post_type || 'leadsun_technology' === $post_type ) : ?>
		<?php $quote_context = 'leadsun_solution' === $post_type ? 'solucion' : 'tecnologia'; ?>
		<?php get_template_part( 'template-parts/components/entity-quote-cta', null, array( 'context' => $quote_context, 'post_id' => $post_id ) ); ?>
	<?php endif; ?>
</article>
