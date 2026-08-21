<?php
/**
 * Front page structural shell.
 *
 * Visual composition is intentionally deferred to the design implementation task.
 *
 * @package Leadsun
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content/content', 'page' ); ?>
	<?php endwhile; ?>

	<?php
	$preview_types = array(
		'leadsun_solution'   => __( 'Soluciones destacadas', 'leadsun' ),
		'leadsun_technology' => __( 'Tecnologías destacadas', 'leadsun' ),
		'leadsun_project'    => __( 'Proyectos recientes', 'leadsun' ),
	);

	foreach ( $preview_types as $post_type => $heading ) :
		$preview = new WP_Query(
			array(
				'post_type'      => $post_type,
				'posts_per_page' => 3,
				'post_status'    => 'publish',
				'no_found_rows'  => true,
			)
		);
		?>
		<section class="leadsun-section entity-preview">
			<div class="leadsun-container">
				<div class="entity-preview__header">
					<h2><?php echo esc_html( $heading ); ?></h2>
					<a href="<?php echo esc_url( get_post_type_archive_link( $post_type ) ); ?>"><?php esc_html_e( 'Ver todos', 'leadsun' ); ?></a>
				</div>
				<?php if ( $preview->have_posts() ) : ?>
					<div class="entity-grid">
						<?php while ( $preview->have_posts() ) : $preview->the_post(); ?>
							<?php get_template_part( 'template-parts/components/entity-card' ); ?>
						<?php endwhile; ?>
					</div>
				<?php else : ?>
					<p class="entity-empty"><?php esc_html_e( 'La vista se poblará desde el contenido administrable.', 'leadsun' ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php wp_reset_postdata(); ?>
	<?php endforeach; ?>
</main>
<?php
get_footer();
