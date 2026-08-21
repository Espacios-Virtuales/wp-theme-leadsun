<?php
/**
 * Shared entity archive markup.
 *
 * @package Leadsun
 */

$post_type = get_query_var( 'post_type' );
$post_type = is_array( $post_type ) ? reset( $post_type ) : $post_type;
$post_type = is_string( $post_type ) ? $post_type : '';
$config = leadsun_entity_config( $post_type );
?>
<main id="primary" class="site-main entity-archive">
	<?php
	get_template_part(
		'template-parts/components/entity-hero',
		null,
		array(
			'eyebrow' => $config['label'] ?? '',
			'title'    => $config['plural'] ?? post_type_archive_title( '', false ),
			'excerpt'  => $config['introduction'] ?? '',
		)
	);
	?>
	<section class="entity-archive__listing leadsun-section" aria-label="<?php echo esc_attr( $config['plural'] ?? '' ); ?>">
		<div class="leadsun-container">
			<?php if ( have_posts() ) : ?>
				<div class="entity-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/components/entity-card' ); ?>
					<?php endwhile; ?>
				</div>
				<?php the_posts_navigation(); ?>
			<?php else : ?>
				<p class="entity-empty"><?php esc_html_e( 'Aún no hay registros disponibles. Esta vista está preparada para el contenido administrable.', 'leadsun' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
