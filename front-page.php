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
$technology_ids  = leadsun_home_featured_entity_ids( 'leadsun_technology', 'home_featured_technology_' );
$project_ids     = leadsun_home_featured_entity_ids( 'leadsun_project', 'home_featured_project_' );
$contact_title   = leadsun_field( 'home_contact_title', $home_id, __( '¿TIENES UN PROYECTO DE ILUMINACIÓN?', 'leadsun' ) );
$contact_text    = leadsun_field( 'home_contact_text', $home_id, __( 'Nuestro equipo puede ayudarte a definir la solución adecuada antes de cotizar.', 'leadsun' ) );
$contact_channels = leadsun_contact_channels();
$contact_url     = leadsun_quote_page_url();
$whatsapp_url    = leadsun_whatsapp_url();
$contact_icons   = array(
	'whatsapp' => 'bi-whatsapp',
	'email'    => 'bi-envelope',
	'phone'    => 'bi-telephone',
);
?>
<main id="primary" class="site-main">
	<section class="home-hero">
		<?php if ( $hero_video ) : ?>
			<?php get_template_part( 'template-parts/components/video-inline', null, array( 'video' => $hero_video, 'poster_url' => $hero_image_url, 'title' => __( 'Video LEADSUN', 'leadsun' ), 'class_name' => 'home-hero__media' ) ); ?>
		<?php else : ?>
			<img class="home-hero__media" src="<?php echo esc_url( $hero_image_url ); ?>" alt="" aria-hidden="true">
		<?php endif; ?>
		<div class="home-hero__overlay"></div>
		<div class="leadsun-container home-hero__content">
			<h1><?php echo wp_kses_post( nl2br( esc_html( $hero_title ) ) ); ?></h1>
			<p><?php echo esc_html( wp_strip_all_tags( $hero_text ) ); ?></p>
			<div class="home-hero__actions">
				<a class="btn-leadsun" href="<?php echo esc_url( get_post_type_archive_link( 'leadsun_solution' ) ); ?>"><?php esc_html_e( 'Explorar soluciones', 'leadsun' ); ?></a>
				<a class="btn-leadsun-outline" href="<?php echo esc_url( leadsun_quote_page_url() ); ?>"><?php esc_html_e( 'Cotizar un proyecto', 'leadsun' ); ?></a>
			</div>
		</div>
	</section>

	<section id="soluciones" class="home-section home-solutions">
		<div class="leadsun-container"><h2 data-aos="fade-up">NUESTRAS SOLUCIONES PROFESIONALES</h2>
			<div class="home-solutions__grid">
				<?php foreach ( $featured_ids as $id ) : leadsun_home_render_card( $id ); endforeach; ?>
			</div>
		</div>
	</section>

	<section class="home-section home-extreme">
		<div class="leadsun-container home-feature">
			<div class="home-feature__content" data-aos="fade-up"><h2>BLACK DUALFACE<br>DISEÑADA PARA<br>CONDICIONES EXTREMAS</h2>
			<?php if ( $extreme_id ) : $config = leadsun_entity_config( 'leadsun_solution' ); $poster = leadsun_entity_poster_url( $extreme_id, $config['secondary_field'] ); $video = leadsun_youtube_video( leadsun_field( 'solution_youtube_url', $extreme_id ) ); ?>
				<p><?php echo esc_html( get_the_excerpt( $extreme_id ) ); ?></p><a class="btn-leadsun-outline" href="<?php echo esc_url( get_permalink( $extreme_id ) ); ?>"><?php esc_html_e( 'Ver solución', 'leadsun' ); ?></a>
			<?php endif; ?></div>
			<?php if ( $extreme_id ) : ?>
				<div class="home-feature__media" data-aos="fade-left"><?php if ( $video ) : get_template_part( 'template-parts/components/video-inline', null, array( 'video' => $video, 'poster_url' => $poster, 'title' => __( 'Video de solución', 'leadsun' ) ) ); else : ?><img src="<?php echo esc_url( $poster ); ?>" alt=""><?php endif; ?></div>
			<?php endif; ?>
		</div>
	</section>

	<section class="home-section home-entities">
		<div class="leadsun-container"><div class="home-section__heading"><h2 data-aos="fade-up">TECNOLOGÍA LEADSUN</h2><a href="<?php echo esc_url( get_post_type_archive_link( 'leadsun_technology' ) ); ?>"><?php esc_html_e( 'Ver tecnología', 'leadsun' ); ?></a></div>
			<?php if ( $technology_ids ) : ?><div class="entity-grid"><?php foreach ( $technology_ids as $id ) : leadsun_home_render_card( $id ); endforeach; ?></div><?php endif; ?>
		</div>
	</section>

	<section class="home-section home-projects">
		<div class="leadsun-container"><div class="home-section__heading"><h2 data-aos="fade-up">PROYECTOS REALES</h2><a class="btn-leadsun-outline" href="<?php echo esc_url( get_post_type_archive_link( 'leadsun_project' ) ); ?>"><?php esc_html_e( 'Ver proyectos', 'leadsun' ); ?></a></div>
			<?php if ( $project_ids ) : ?><div class="entity-grid"><?php foreach ( $project_ids as $id ) : leadsun_home_render_card( $id ); endforeach; ?></div><?php endif; ?>
		</div>
	</section>

	<section class="home-section home-responsible">
		<div class="leadsun-container home-feature home-feature--reverse"><div class="home-feature__content" data-aos="fade-up"><h2>ILUMINACIÓN RESPONSABLE</h2>
			<?php if ( $responsible_id ) : $config = leadsun_entity_config( 'leadsun_technology' ); $poster = leadsun_entity_poster_url( $responsible_id, $config['secondary_field'] ); $video = leadsun_youtube_video( leadsun_field( 'technology_youtube_url', $responsible_id ) ); ?>
				<p><?php echo esc_html( get_the_excerpt( $responsible_id ) ); ?></p><a class="btn-leadsun-outline" href="<?php echo esc_url( get_permalink( $responsible_id ) ); ?>"><?php esc_html_e( 'Ver tecnología', 'leadsun' ); ?></a>
			<?php endif; ?></div>
			<?php if ( $responsible_id ) : ?><div class="home-feature__media" data-aos="fade-right"><?php if ( $video ) : get_template_part( 'template-parts/components/video-inline', null, array( 'video' => $video, 'poster_url' => $poster, 'title' => __( 'Video de tecnología', 'leadsun' ) ) ); else : ?><img src="<?php echo esc_url( $poster ); ?>" alt=""><?php endif; ?></div><?php endif; ?></div>
	</section>

	<section id="certificaciones" class="home-section home-certifications" data-aos="fade-up"><div class="leadsun-container"><h2>CERTIFICACIONES</h2><p class="home-certifications__note"><?php esc_html_e( 'Referencias temporales de maqueta; pendientes de validación y material del cliente.', 'leadsun' ); ?></p><ul><?php $certification_defaults = array( 'SEC', 'Resistencia al impacto', 'ISO 9001', 'ISO 14001', 'Certificación Europea' ); for ( $position = 1; $position <= 5; $position++ ) : $label = leadsun_field( 'home_certification_' . $position . '_label', $home_id, $certification_defaults[ $position - 1 ] ); $image = leadsun_field( 'home_certification_' . $position . '_image', $home_id ); $image_url = is_numeric( $image ) ? wp_get_attachment_image_url( absint( $image ), 'medium' ) : ''; ?><li><?php if ( $image_url ) : ?><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $label ); ?>"><?php endif; ?><span><?php echo esc_html( $label ); ?></span></li><?php endfor; ?></ul></div></section>

	<section id="contacto" class="home-section home-contact">
		<div class="leadsun-container" data-aos="fade-up">
			<h2><?php echo esc_html( $contact_title ); ?></h2>
			<p><?php echo esc_html( $contact_text ); ?></p>
			<?php if ( $contact_url ) : ?><a class="btn-leadsun" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Evaluar mi proyecto', 'leadsun' ); ?></a><?php endif; ?>
			<ul class="home-contact__channels">
				<?php foreach ( array( 'whatsapp' => __( 'WhatsApp', 'leadsun' ), 'email' => __( 'Correo', 'leadsun' ), 'phone' => __( 'Teléfono', 'leadsun' ) ) as $key => $label ) : ?>
					<li class="home-contact__channel">
						<span class="home-contact__icon" aria-hidden="true"><i class="bi <?php echo esc_attr( $contact_icons[ $key ] ); ?>"></i></span>
						<span class="home-contact__content">
							<strong><?php echo esc_html( $label ); ?></strong>
							<?php if ( 'whatsapp' === $key && $whatsapp_url ) : ?>
								<small><a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $contact_channels[ $key ] ); ?></a></small>
							<?php elseif ( ! empty( $contact_channels[ $key ] ) ) : ?>
								<small><?php echo esc_html( $contact_channels[ $key ] ); ?></small>
							<?php endif; ?>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
</main>
<?php
get_footer();
