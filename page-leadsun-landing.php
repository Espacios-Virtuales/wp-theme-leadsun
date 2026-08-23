<?php
/**
 * Template Name: LEADSUN Landing
 * Template Post Type: page
 *
 * Reusable editorial landing page with an optional solution-line listing.
 *
 * @package Leadsun
 */

get_header();
?>
<main id="primary" class="site-main leadsun-landing">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$page_id = get_the_ID();
		$term_id = leadsun_landing_solution_line_id( $page_id );
		$term    = $term_id ? get_term( $term_id, 'leadsun_solution_line' ) : null;
		$poster  = get_the_post_thumbnail_url( $page_id, 'full' );
		$form_type = leadsun_landing_form_type( $page_id );

		get_template_part(
			'template-parts/components/entity-hero',
			null,
			array(
				'title'      => get_the_title(),
				'excerpt'    => get_the_excerpt(),
				'poster_url' => $poster ? $poster : '',
			)
		);
		?>

		<section class="leadsun-landing__content leadsun-section">
			<div class="leadsun-container entry-content">
				<?php the_content(); ?>
			</div>
		</section>

		<?php if ( $term instanceof WP_Term && ! is_wp_error( $term ) ) : ?>
			<?php $solution_ids = leadsun_landing_solution_ids( $term->term_id ); ?>
			<section class="leadsun-landing__solutions leadsun-section" aria-labelledby="landing-solutions-title">
				<div class="leadsun-container">
					<h2 id="landing-solutions-title"><?php echo esc_html( sprintf( __( 'Soluciones %s', 'leadsun' ), $term->name ) ); ?></h2>
					<?php if ( $solution_ids ) : ?>
						<div class="entity-grid">
							<?php foreach ( $solution_ids as $solution_id ) : ?>
								<?php get_template_part( 'template-parts/components/entity-card', null, array( 'post_id' => $solution_id ) ); ?>
							<?php endforeach; ?>
						</div>
					<?php else : ?>
						<p class="entity-empty"><?php esc_html_e( 'Aún no hay soluciones disponibles para esta línea.', 'leadsun' ); ?></p>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		if ( 'contact' === $form_type ) {
			get_template_part( 'template-parts/forms/contact-form' );
		} elseif ( 'quote' === $form_type ) {
			get_template_part( 'template-parts/forms/quote-form' );
		}
		?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
