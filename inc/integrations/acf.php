<?php
/**
 * ACF Free integration.
 *
 * The theme only configures Local JSON here. Field groups are intentionally
 * deferred to the content-model task and must remain compatible with ACF Free.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function leadsun_acf_json_save_path( string $path ): string {
	unset( $path );
	return get_template_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'leadsun_acf_json_save_path' );

function leadsun_acf_json_load_paths( array $paths ): array {
	$paths[] = get_template_directory() . '/acf-json';
	return array_values( array_unique( $paths ) );
}
add_filter( 'acf/settings/load_json', 'leadsun_acf_json_load_paths' );

function leadsun_acf_admin_notice(): void {
	if ( ! current_user_can( 'manage_options' ) || function_exists( 'get_field' ) ) {
		return;
	}
	?>
	<div class="notice notice-warning">
		<p><?php esc_html_e( 'LEADSUN: ACF Free no está activo. El tema funcionará, pero los campos dinámicos del proyecto requieren Advanced Custom Fields.', 'leadsun' ); ?></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'leadsun_acf_admin_notice' );
