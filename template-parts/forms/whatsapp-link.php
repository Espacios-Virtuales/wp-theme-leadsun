<?php
/**
 * Visible WhatsApp alternative for commercial forms.
 *
 * @package Leadsun
 */

$whatsapp_url = leadsun_whatsapp_url();
if ( ! $whatsapp_url ) {
	return;
}
?>
<p class="leadsun-form__whatsapp"><span><?php esc_html_e( '¿Prefieres WhatsApp?', 'leadsun' ); ?></span> <a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Hablar por WhatsApp', 'leadsun' ); ?></a></p>
