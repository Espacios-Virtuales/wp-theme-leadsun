<?php
/**
 * WordPress settings for LEADSUN commercial-form delivery.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the delivery settings and their admin screen.
 */
function leadsun_register_forms_settings(): void {
	register_setting(
		'leadsun_forms',
		'leadsun_forms_primary_recipient',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'leadsun_sanitize_primary_recipient',
			'default'           => 'ventas@leadsun.cl',
		)
	);
	register_setting(
		'leadsun_forms',
		'leadsun_whatsapp_number',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'leadsun_sanitize_whatsapp_number',
			'default'           => '',
		)
	);
	register_setting(
		'leadsun_forms',
		'leadsun_whatsapp_default_message',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => __( 'Hola, quisiera consultar por un proyecto de iluminación LEADSUN.', 'leadsun' ),
		)
	);
	register_setting(
		'leadsun_forms',
		'leadsun_forms_cc_recipients',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'leadsun_sanitize_cc_recipients',
			'default'           => 'proyectos@leadsun.cl',
		)
	);
	register_setting(
		'leadsun_forms',
		'leadsun_avatar_enabled',
		array(
			'type'              => 'boolean',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => false,
		)
	);
	register_setting(
		'leadsun_forms',
		'leadsun_avatar_video_url',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'leadsun_sanitize_avatar_video_url',
			'default'           => '',
		)
	);
	register_setting(
		'leadsun_forms',
		'leadsun_avatar_label',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'leadsun_sanitize_avatar_label',
			'default'           => __( 'Conoce LEADSUN', 'leadsun' ),
		)
	);
}
add_action( 'admin_init', 'leadsun_register_forms_settings' );

/**
 * Add the native Settings API page.
 */
function leadsun_add_forms_settings_page(): void {
	add_options_page(
		__( 'LEADSUN Formularios', 'leadsun' ),
		__( 'LEADSUN Formularios', 'leadsun' ),
		'manage_options',
		'leadsun-forms',
		'leadsun_render_forms_settings_page'
	);
}
add_action( 'admin_menu', 'leadsun_add_forms_settings_page' );

/**
 * Render settings without putting delivery values in templates or mail bodies.
 */
function leadsun_render_forms_settings_page(): void {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'LEADSUN Formularios', 'leadsun' ); ?></h1>
		<form action="options.php" method="post">
			<?php settings_fields( 'leadsun_forms' ); ?>
			<table class="form-table" role="presentation">
				<tr><th scope="row"><label for="leadsun_forms_primary_recipient"><?php esc_html_e( 'Destinatario principal', 'leadsun' ); ?></label></th><td><input class="regular-text" id="leadsun_forms_primary_recipient" name="leadsun_forms_primary_recipient" type="email" value="<?php echo esc_attr( get_option( 'leadsun_forms_primary_recipient', 'ventas@leadsun.cl' ) ); ?>"><p class="description"><?php esc_html_e( 'Si no es válido, se utilizará el correo administrador del sitio.', 'leadsun' ); ?></p></td></tr>
				<tr><th scope="row"><label for="leadsun_forms_cc_recipients"><?php esc_html_e( 'Copias (Cc)', 'leadsun' ); ?></label></th><td><textarea class="large-text" id="leadsun_forms_cc_recipients" name="leadsun_forms_cc_recipients" rows="3"><?php echo esc_textarea( get_option( 'leadsun_forms_cc_recipients', 'proyectos@leadsun.cl' ) ); ?></textarea><p class="description"><?php esc_html_e( 'Uno o más correos, separados por coma o por línea.', 'leadsun' ); ?></p></td></tr>
				<tr><th scope="row"><label for="leadsun_whatsapp_number"><?php esc_html_e( 'Número WhatsApp', 'leadsun' ); ?></label></th><td><input class="regular-text" id="leadsun_whatsapp_number" name="leadsun_whatsapp_number" type="tel" value="<?php echo esc_attr( get_option( 'leadsun_whatsapp_number', '' ) ); ?>"><p class="description"><?php esc_html_e( 'Incluye código de país. Se conservarán sólo dígitos.', 'leadsun' ); ?></p></td></tr>
				<tr><th scope="row"><label for="leadsun_whatsapp_default_message"><?php esc_html_e( 'Mensaje inicial WhatsApp', 'leadsun' ); ?></label></th><td><textarea class="large-text" id="leadsun_whatsapp_default_message" name="leadsun_whatsapp_default_message" rows="3"><?php echo esc_textarea( get_option( 'leadsun_whatsapp_default_message', __( 'Hola, quisiera consultar por un proyecto de iluminación LEADSUN.', 'leadsun' ) ) ); ?></textarea></td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Video comercial', 'leadsun' ); ?></th><td><input type="hidden" name="leadsun_avatar_enabled" value="0"><label for="leadsun_avatar_enabled"><input id="leadsun_avatar_enabled" name="leadsun_avatar_enabled" type="checkbox" value="1" <?php checked( (bool) get_option( 'leadsun_avatar_enabled', true ) ); ?>> <?php esc_html_e( 'Mostrar el launcher del video comercial', 'leadsun' ); ?></label><p class="description"><?php esc_html_e( 'Se muestra por defecto cuando existe una URL de YouTube válida y puede desactivarse manualmente.', 'leadsun' ); ?></p></td></tr>
				<tr><th scope="row"><label for="leadsun_avatar_video_url"><?php esc_html_e( 'URL del video', 'leadsun' ); ?></label></th><td><input class="regular-text" id="leadsun_avatar_video_url" name="leadsun_avatar_video_url" type="url" value="<?php echo esc_attr( get_option( 'leadsun_avatar_video_url', '' ) ); ?>" placeholder="https://www.youtube.com/watch?v=xxxxxxxxxxx"><p class="description"><?php esc_html_e( 'Usa una URL segura de YouTube. El video se carga sólo al activar el launcher.', 'leadsun' ); ?></p></td></tr>
				<tr><th scope="row"><label for="leadsun_avatar_label"><?php esc_html_e( 'Texto del launcher', 'leadsun' ); ?></label></th><td><input class="regular-text" id="leadsun_avatar_label" name="leadsun_avatar_label" type="text" maxlength="60" value="<?php echo esc_attr( get_option( 'leadsun_avatar_label', __( 'Conoce LEADSUN', 'leadsun' ) ) ); ?>"></td></tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/** Validate that the commercial video uses a supported secure YouTube URL. */
function leadsun_sanitize_avatar_video_url( $value ): string {
	$value = is_scalar( $value ) ? esc_url_raw( trim( (string) $value ), array( 'https' ) ) : '';
	return leadsun_youtube_video( $value ) ? $value : '';
}

/** Sanitize the short visible and accessible launcher label. */
function leadsun_sanitize_avatar_label( $value ): string {
	$value = is_scalar( $value ) ? sanitize_text_field( (string) $value ) : '';
	return '' === $value ? __( 'Conoce LEADSUN', 'leadsun' ) : wp_html_excerpt( $value, 60, '' );
}

/**
 * Sanitize a configured primary recipient, allowing the send-time fallback.
 */
function leadsun_sanitize_primary_recipient( $value ): string {
	return sanitize_email( is_scalar( $value ) ? (string) $value : '' );
}

/**
 * Sanitize and normalize configured Cc recipients.
 */
function leadsun_sanitize_cc_recipients( $value ): string {
	$value      = is_scalar( $value ) ? (string) $value : '';
	$recipients = leadsun_forms_parse_recipients( $value );

	return implode( ', ', $recipients );
}

/**
 * Retain only digits in the configured WhatsApp number.
 */
function leadsun_sanitize_whatsapp_number( $value ): string {
	return is_scalar( $value ) ? (string) preg_replace( '/\D+/', '', (string) $value ) : '';
}

/**
 * @return string[] Valid unique addresses from comma or newline separated text.
 */
function leadsun_forms_parse_recipients( string $value ): array {
	$addresses = preg_split( '/[\r\n,]+/', $value ) ?: array();
	$valid     = array();

	foreach ( $addresses as $address ) {
		$email = sanitize_email( trim( $address ) );
		if ( is_email( $email ) ) {
			$valid[ strtolower( $email ) ] = $email;
		}
	}

	return array_values( $valid );
}

/**
 * @return array{primary: string, cc: string[]}
 */
function leadsun_forms_recipients(): array {
	$primary = sanitize_email( (string) get_option( 'leadsun_forms_primary_recipient', 'ventas@leadsun.cl' ) );
	$primary = is_email( $primary ) ? $primary : sanitize_email( (string) get_option( 'admin_email' ) );
	$cc      = leadsun_forms_parse_recipients( (string) get_option( 'leadsun_forms_cc_recipients', 'proyectos@leadsun.cl' ) );
	$cc      = array_values( array_filter( $cc, static fn( string $email ): bool => strtolower( $email ) !== strtolower( $primary ) ) );

	return array(
		'primary' => $primary,
		'cc'      => $cc,
	);
}
