<?php
/**
 * Configurable commercial video launcher.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Render the launcher and the shared video modal only when configured. */
function leadsun_render_commercial_avatar(): void {
	if ( ! get_option( 'leadsun_avatar_enabled', true ) ) {
		return;
	}

	$video_url = (string) get_option( 'leadsun_avatar_video_url', '' );
	$video     = leadsun_youtube_video( $video_url );
	if ( ! $video ) {
		return;
	}

	$label    = sanitize_text_field( (string) get_option( 'leadsun_avatar_label', __( 'Conoce LEADSUN', 'leadsun' ) ) );
	$label    = '' !== $label ? $label : __( 'Conoce LEADSUN', 'leadsun' );
	$modal_id = leadsun_video_modal_id();
	$poster   = 'https://img.youtube.com/vi/' . rawurlencode( $video['id'] ) . '/hqdefault.jpg';
	?>
	<div class="leadsun-avatar" data-leadsun-avatar>
		<button
			type="button"
			class="leadsun-avatar__launcher"
			data-video-modal-trigger
			data-video-modal-target="<?php echo esc_attr( $modal_id ); ?>"
			data-video-embed-url="<?php echo esc_url( $video['embed_url'] ); ?>"
			data-video-title="<?php echo esc_attr( $label ); ?>"
			aria-label="<?php echo esc_attr( $label ); ?>"
		>
			<span class="leadsun-avatar__poster" aria-hidden="true">
				<img src="<?php echo esc_url( $poster ); ?>" alt="" loading="lazy">
				<span class="leadsun-avatar__play">▶</span>
			</span>
			<span class="leadsun-avatar__label"><?php echo esc_html( $label ); ?></span>
		</button>
	</div>
	<?php
	get_template_part(
		'template-parts/components/video-modal',
		null,
		array(
			'modal_id' => $modal_id,
			'title'    => $label,
			'cta_url'  => home_url( '/cotizar-proyecto/' ),
			'cta_label' => __( 'Cotiza tu proyecto', 'leadsun' ),
		)
	);
}
add_action( 'wp_footer', 'leadsun_render_commercial_avatar', 5 );
