<?php
/**
 * Simple contact form. Delivery is added in C02.
 *
 * @package Leadsun
 */

$state = leadsun_form_submission_state( 'contact' );
?>
<section id="contacto-form" class="leadsun-form-section leadsun-section" aria-labelledby="contact-form-title">
	<div class="leadsun-container leadsun-form-section__inner">
		<h2 id="contact-form-title" data-aos="fade-up"><?php esc_html_e( 'Envíanos tu consulta', 'leadsun' ); ?></h2>
		<form class="leadsun-form leadsun-form--contact" method="post" novalidate data-aos="fade-up">
			<?php leadsun_form_feedback( $state ); ?>
			<input type="hidden" name="leadsun_form_type" value="contact">
			<?php wp_nonce_field( 'leadsun_contact_submit', 'leadsun_contact_nonce' ); ?>
			<div class="leadsun-form__honeypot" aria-hidden="true"><label for="contact-website">Website</label><input id="contact-website" type="text" name="website" tabindex="-1" autocomplete="off"></div>
			<div class="leadsun-field<?php echo ! empty( $state['errors']['contact_name'] ) ? ' leadsun-field--error' : ''; ?>"><label for="contact-name"><?php esc_html_e( 'Nombre', 'leadsun' ); ?> *</label><input id="contact-name" name="contact_name" type="text" autocomplete="name" required value="<?php echo leadsun_form_value( $state, 'name' ); ?>" aria-invalid="<?php echo ! empty( $state['errors']['contact_name'] ) ? 'true' : 'false'; ?>" aria-describedby="contact_name-error"><?php leadsun_form_field_error( $state, 'contact_name' ); ?></div>
			<div class="leadsun-field<?php echo ! empty( $state['errors']['contact_email'] ) ? ' leadsun-field--error' : ''; ?>"><label for="contact-email"><?php esc_html_e( 'Correo electrónico', 'leadsun' ); ?> *</label><input id="contact-email" name="contact_email" type="email" autocomplete="email" required value="<?php echo leadsun_form_value( $state, 'email' ); ?>" aria-invalid="<?php echo ! empty( $state['errors']['contact_email'] ) ? 'true' : 'false'; ?>" aria-describedby="contact_email-error"><?php leadsun_form_field_error( $state, 'contact_email' ); ?></div>
			<div class="leadsun-field"><label for="contact-phone"><?php esc_html_e( 'Teléfono', 'leadsun' ); ?></label><input id="contact-phone" name="contact_phone" type="tel" autocomplete="tel" value="<?php echo leadsun_form_value( $state, 'phone' ); ?>"></div>
			<div class="leadsun-field<?php echo ! empty( $state['errors']['contact_subject'] ) ? ' leadsun-field--error' : ''; ?>"><label for="contact-subject"><?php esc_html_e( 'Asunto', 'leadsun' ); ?> *</label><input id="contact-subject" name="contact_subject" type="text" required value="<?php echo leadsun_form_value( $state, 'subject' ); ?>" aria-invalid="<?php echo ! empty( $state['errors']['contact_subject'] ) ? 'true' : 'false'; ?>" aria-describedby="contact_subject-error"><?php leadsun_form_field_error( $state, 'contact_subject' ); ?></div>
			<div class="leadsun-field<?php echo ! empty( $state['errors']['contact_message'] ) ? ' leadsun-field--error' : ''; ?>"><label for="contact-message"><?php esc_html_e( 'Mensaje', 'leadsun' ); ?> *</label><textarea id="contact-message" name="contact_message" required aria-invalid="<?php echo ! empty( $state['errors']['contact_message'] ) ? 'true' : 'false'; ?>" aria-describedby="contact_message-error"><?php echo esc_textarea( $state['data']['message'] ?? '' ); ?></textarea><?php leadsun_form_field_error( $state, 'contact_message' ); ?></div>
			<button class="btn-leadsun" type="submit"><?php esc_html_e( 'Enviar consulta', 'leadsun' ); ?></button>
		</form>
		<?php get_template_part( 'template-parts/forms/whatsapp-link' ); ?>
	</div>
</section>
