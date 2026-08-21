<?php
/**
 * LEADSUN approved mockup composition.
 *
 * @package Leadsun
 */

get_header();

$home_id         = leadsun_home_page_id();
$hero_title      = leadsun_field( 'home_hero_title', $home_id, "ILUMINACIÓN\nPROFESIONAL\nPARA INFRAESTRUCTURA" );
$hero_text       = leadsun_field( 'home_hero_text', $home_id, __( 'Soluciones de iluminación para proyectos que exigen continuidad, eficiencia y resistencia.', 'leadsun' ) );
$hero_image      = leadsun_field( 'home_hero_image', $home_id );
$hero_image_url  = is_numeric( $hero_image ) ? wp_get_attachment_image_url( absint( $hero_image ), 'full' ) : '';
$hero_image_url  = $hero_image_url ?: leadsun_media_fallback_url();
$hero_video      = leadsun_youtube_video( leadsun_field( 'home_hero_youtube_url', $home_id ) );
$featured_ids    = leadsun_home_featured_solution_ids();
$extreme_id      = leadsun_home_entity_id( leadsun_field( 'home_extreme_solution', $home_id ), 'leadsun_solution' );
$extreme_id      = $extreme_id ?: leadsun_home_solution_from_line( 'Solar' );
$extreme_id      = $extreme_id ?: ( $featured_ids[0] ?? 0 );
$responsible_id  = leadsun_home_responsible_technology_id();
$contact_page    = get_page_by_path( 'contacto' );
$contact_url     = $contact_page ? get_permalink( $contact_page ) : get_post_type_archive_link( 'leadsun_project' );
?>
<main id="primary" class="site-main">
	<section class="home-hero">
		<img class="home-hero__media" src="<?php echo esc_url( $hero_image_url ); ?>" alt="" aria-hidden="true">
		<div class="home-hero__overlay"></div>
		<div class="leadsun-container home-hero__content">
			<h1><?php echo wp_kses_post( nl2br( esc_html( $hero_title ) ) ); ?></h1>
			<p><?php echo esc_html( $hero_text ); ?></p>
			<a class="btn-leadsun" href="#soluciones"><?php esc_html_e( 'Conoce nuestras soluciones', 'leadsun' ); ?></a>
			<?php if ( $hero_video ) : $modal_id = leadsun_video_modal_id(); ?>
				<?php get_template_part( 'template-parts/components/video-trigger', null, array( 'video' => $hero_video, 'modal_id' => $modal_id, 'poster_url' => $hero_image_url, 'title' => __( 'Reproducir video LEADSUN', 'leadsun' ) ) ); ?>
				<?php get_template_part( 'template-parts/components/video-modal', null, array( 'modal_id' => $modal_id, 'title' => __( 'Video LEADSUN', 'leadsun' ) ) ); ?>
			<?php endif; ?>
		</div>
	</section>

	<section id="soluciones" class="home-section home-solutions">
		<div class="leadsun-container"><h2>NUESTRAS SOLUCIONES PROFESIONALES</h2>
			<div class="home-solutions__grid">
				<?php foreach ( $featured_ids as $id ) : leadsun_home_render_card( $id ); endforeach; ?>
			</div>
		</div>
	</section>

	<section class="home-section home-extreme">
		<div class="leadsun-container home-feature">
			<div class="home-feature__content"><h2>BLACK DUALFACE<br>DISEÑADA PARA<br>CONDICIONES EXTREMAS</h2>
			<?php if ( $extreme_id ) : $config = leadsun_entity_config( 'leadsun_solution' ); $poster = leadsun_entity_poster_url( $extreme_id, $config['secondary_field'] ); ?>
				<p><?php echo esc_html( get_the_excerpt( $extreme_id ) ); ?></p><a class="btn-leadsun-outline" href="<?php echo esc_url( get_permalink( $extreme_id ) ); ?>"><?php esc_html_e( 'Ver solución', 'leadsun' ); ?></a>
				<?php $video = leadsun_youtube_video( leadsun_field( 'solution_youtube_url', $extreme_id ) ); if ( $video ) : $modal_id = leadsun_video_modal_id(); get_template_part( 'template-parts/components/video-trigger', null, array( 'video' => $video, 'modal_id' => $modal_id, 'poster_url' => $poster, 'title' => __( 'Reproducir video de solución', 'leadsun' ) ) ); get_template_part( 'template-parts/components/video-modal', null, array( 'modal_id' => $modal_id, 'title' => get_the_title( $extreme_id ) ) ); endif; ?>
			<?php endif; ?></div>
			<?php if ( $extreme_id ) : ?>
				<div class="home-feature__media"><img src="<?php echo esc_url( $poster ); ?>" alt=""></div>
			<?php endif; ?>
		</div>
	</section>

	<?php $technologies = new WP_Query( array( 'post_type' => 'leadsun_technology', 'post_status' => 'publish', 'posts_per_page' => 3, 'no_found_rows' => true ) ); ?>
	<section class="home-section home-entities">
		<div class="leadsun-container"><div class="home-section__heading"><h2>TECNOLOGÍA LEADSUN</h2><a href="<?php echo esc_url( get_post_type_archive_link( 'leadsun_technology' ) ); ?>"><?php esc_html_e( 'Ver tecnología', 'leadsun' ); ?></a></div>
			<?php if ( $technologies->have_posts() ) : ?><div class="entity-grid"><?php while ( $technologies->have_posts() ) : $technologies->the_post(); get_template_part( 'template-parts/components/entity-card' ); endwhile; ?></div><?php endif; wp_reset_postdata(); ?>
		</div>
	</section>

	<?php $projects = new WP_Query( array( 'post_type' => 'leadsun_project', 'post_status' => 'publish', 'posts_per_page' => 3, 'no_found_rows' => true ) ); ?>
	<section class="home-section home-projects">
		<div class="leadsun-container"><div class="home-section__heading"><h2>PROYECTOS REALES</h2><a class="btn-leadsun-outline" href="<?php echo esc_url( get_post_type_archive_link( 'leadsun_project' ) ); ?>"><?php esc_html_e( 'Ver proyectos', 'leadsun' ); ?></a></div>
			<?php if ( $projects->have_posts() ) : ?><div class="entity-grid"><?php while ( $projects->have_posts() ) : $projects->the_post(); get_template_part( 'template-parts/components/entity-card' ); endwhile; ?></div><?php endif; wp_reset_postdata(); ?>
		</div>
	</section>

	<section class="home-section home-responsible">
		<div class="leadsun-container home-feature home-feature--reverse"><div class="home-feature__content"><h2>ILUMINACIÓN RESPONSABLE</h2>
			<?php if ( $responsible_id ) : $config = leadsun_entity_config( 'leadsun_technology' ); $poster = leadsun_entity_poster_url( $responsible_id, $config['secondary_field'] ); ?>
				<p><?php echo esc_html( get_the_excerpt( $responsible_id ) ); ?></p><a class="btn-leadsun-outline" href="<?php echo esc_url( get_permalink( $responsible_id ) ); ?>"><?php esc_html_e( 'Ver tecnología', 'leadsun' ); ?></a>
				<?php $video = leadsun_youtube_video( leadsun_field( 'technology_youtube_url', $responsible_id ) ); if ( $video ) : $modal_id = leadsun_video_modal_id(); get_template_part( 'template-parts/components/video-trigger', null, array( 'video' => $video, 'modal_id' => $modal_id, 'poster_url' => $poster, 'title' => __( 'Reproducir video de tecnología', 'leadsun' ) ) ); get_template_part( 'template-parts/components/video-modal', null, array( 'modal_id' => $modal_id, 'title' => get_the_title( $responsible_id ) ) ); endif; ?>
			<?php endif; ?></div>
			<?php if ( $responsible_id ) : ?><div class="home-feature__media"><img src="<?php echo esc_url( $poster ); ?>" alt=""></div><?php endif; ?></div>
	</section>

	<section id="certificaciones" class="home-section home-certifications"><div class="leadsun-container"><h2>CERTIFICACIONES</h2><p class="home-certifications__note"><?php esc_html_e( 'Referencias temporales de maqueta; pendientes de validación y material del cliente.', 'leadsun' ); ?></p><ul><?php foreach ( array( 'SEC', 'Resistencia al impacto', 'ISO 9001', 'ISO 14001', 'Certificación Europea' ) as $certification ) : ?><li><?php echo esc_html( $certification ); ?></li><?php endforeach; ?></ul></div></section>

	<section id="contacto" class="home-section home-contact"><div class="leadsun-container"><h2>¿TIENES UN PROYECTO DE ILUMINACIÓN?</h2><p><?php esc_html_e( 'Conversemos sobre la solución adecuada para tu infraestructura.', 'leadsun' ); ?></p><?php if ( $contact_url ) : ?><a class="btn-leadsun" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Cotizar proyecto', 'leadsun' ); ?></a><?php endif; ?></div></section>
</main>
<?php
get_footer();
