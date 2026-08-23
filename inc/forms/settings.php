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
		'leadsun_forms_cc_recipients',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'leadsun_sanitize_cc_recipients',
			'default'           => 'proyectos@leadsun.cl',
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
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
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
