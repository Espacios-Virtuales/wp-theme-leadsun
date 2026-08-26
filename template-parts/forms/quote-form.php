<?php
/**
 * Extended project quote form. Delivery is added in C02.
 *
 * @package Leadsun
 */

$state            = leadsun_form_submission_state( 'quote' );
$product_options  = leadsun_quote_product_options();
$project_types    = array( 'Vial', 'Urbano', 'Industrial', 'Portuario', 'Rural', 'Espacio público', 'Otro' );
$project_stages   = array( 'Evaluación', 'Diseño / especificación', 'Cotización', 'Licitación', 'Ejecución', 'Otro' );
?>
<section id="cotizacion-form" class="leadsun-form-section leadsun-section" aria-labelledby="quote-form-title">
	<div class="leadsun-container leadsun-form-section__inner">
		<h2 id="quote-form-title"><?php esc_html_e( 'Cuéntanos sobre tu proyecto', 'leadsun' ); ?></h2>
		<form class="leadsun-form leadsun-form--quote" method="post" enctype="multipart/form-data" novalidate>
			<?php leadsun_form_feedback( $state ); ?>
			<input type="hidden" name="leadsun_form_type" value="quote">
			<?php wp_nonce_field( 'leadsun_quote_submit', 'leadsun_quote_nonce' ); ?>
			<div class="leadsun-form__honeypot" aria-hidden="true"><label for="quote-website">Website</label><input id="quote-website" type="text" name="website" tabindex="-1" autocomplete="off"></div>
			<div class="leadsun-form__grid">
				<?php
				$fields = array(
					'quote_name'     => array( 'Nombre', 'text', 'name', true, 'name' ),
					'quote_company'  => array( 'Empresa', 'text', 'company', false, 'company' ),
					'quote_email'    => array( 'Correo electrónico', 'email', 'email', true, 'email' ),
					'quote_phone'    => array( 'Teléfono', 'tel', 'phone', true, 'tel' ),
					'quote_location' => array( 'Región / ciudad', 'text', 'location', true, 'address-level2' ),
					'quote_budget'   => array( 'Presupuesto estimado disponible', 'text', 'budget', false, 'off' ),
					'quote_quantity' => array( 'Cantidad aproximada de luminarias', 'number', 'quantity', false, 'off' ),
					'quote_execution_date' => array( 'Fecha estimada de ejecución', 'date', 'execution_date', false, 'off' ),
				);
				foreach ( $fields as $name => $field ) :
					$error = ! empty( $state['errors'][ $name ] );
					?>
					<div class="leadsun-field<?php echo $error ? ' leadsun-field--error' : ''; ?>"><label for="<?php echo esc_attr( str_replace( '_', '-', $name ) ); ?>"><?php echo esc_html( $field[0] ); ?><?php echo $field[3] ? ' *' : ''; ?></label><input id="<?php echo esc_attr( str_replace( '_', '-', $name ) ); ?>" name="<?php echo esc_attr( $name ); ?>" type="<?php echo esc_attr( $field[1] ); ?>" autocomplete="<?php echo esc_attr( $field[4] ); ?>"<?php echo 'quote_quantity' === $name ? ' min="1" step="1"' : ''; ?><?php echo $field[3] ? ' required' : ''; ?> value="<?php echo leadsun_form_value( $state, $field[2] ); ?>" aria-invalid="<?php echo $error ? 'true' : 'false'; ?>" aria-describedby="<?php echo esc_attr( $name ); ?>-error"><?php leadsun_form_field_error( $state, $name ); ?></div>
				<?php endforeach; ?>
				<div class="leadsun-field<?php echo ! empty( $state['errors']['quote_project_type'] ) ? ' leadsun-field--error' : ''; ?>"><label for="quote-project-type"><?php esc_html_e( 'Tipo de proyecto', 'leadsun' ); ?> *</label><select id="quote-project-type" name="quote_project_type" required aria-invalid="<?php echo ! empty( $state['errors']['quote_project_type'] ) ? 'true' : 'false'; ?>" aria-describedby="quote_project_type-error"><option value=""><?php esc_html_e( 'Selecciona una opción', 'leadsun' ); ?></option><?php foreach ( $project_types as $type ) : ?><option value="<?php echo esc_attr( $type ); ?>"<?php selected( $state['data']['project_type'] ?? '', $type ); ?>><?php echo esc_html( $type ); ?></option><?php endforeach; ?></select><?php leadsun_form_field_error( $state, 'quote_project_type' ); ?></div>
				<div class="leadsun-field"><label for="quote-product-interest"><?php esc_html_e( 'Producto de interés', 'leadsun' ); ?></label><select id="quote-product-interest" name="quote_product_interest"><option value=""><?php esc_html_e( 'Por definir', 'leadsun' ); ?></option><?php foreach ( $product_options as $id => $title ) : ?><option value="<?php echo esc_attr( $id ); ?>"<?php selected( $state['data']['product_interest'] ?? '', $id ); ?>><?php echo esc_html( $title ); ?></option><?php endforeach; ?></select></div>
				<div class="leadsun-field"><label for="quote-stage"><?php esc_html_e( 'Etapa actual del proyecto', 'leadsun' ); ?></label><select id="quote-stage" name="quote_stage"><option value=""><?php esc_html_e( 'Selecciona una opción', 'leadsun' ); ?></option><?php foreach ( $project_stages as $stage ) : ?><option value="<?php echo esc_attr( $stage ); ?>"<?php selected( $state['data']['stage'] ?? '', $stage ); ?>><?php echo esc_html( $stage ); ?></option><?php endforeach; ?></select></div>
			</div>
			<div class="leadsun-field leadsun-field--full<?php echo ! empty( $state['errors']['quote_message'] ) ? ' leadsun-field--error' : ''; ?>"><label for="quote-message"><?php esc_html_e( 'Mensaje', 'leadsun' ); ?> *</label><textarea id="quote-message" name="quote_message" required aria-invalid="<?php echo ! empty( $state['errors']['quote_message'] ) ? 'true' : 'false'; ?>" aria-describedby="quote_message-error"><?php echo esc_textarea( $state['data']['message'] ?? '' ); ?></textarea><?php leadsun_form_field_error( $state, 'quote_message' ); ?></div>
			<div class="leadsun-field leadsun-field--full<?php echo ! empty( $state['errors']['quote_attachment'] ) ? ' leadsun-field--error' : ''; ?>"><label for="quote-attachment"><?php esc_html_e( 'Adjuntar antecedentes', 'leadsun' ); ?></label><input id="quote-attachment" name="quote_attachment" type="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,application/pdf,image/jpeg,image/png,application/msword,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" aria-invalid="<?php echo ! empty( $state['errors']['quote_attachment'] ) ? 'true' : 'false'; ?>" aria-describedby="quote_attachment-help quote_attachment-error"><p id="quote_attachment-help" class="leadsun-form__help"><?php esc_html_e( 'PDF, JPG, PNG, Word o Excel. Máximo 10 MB.', 'leadsun' ); ?></p><?php leadsun_form_field_error( $state, 'quote_attachment' ); ?></div>
			<button class="btn-leadsun" type="submit"><?php esc_html_e( 'Enviar solicitud', 'leadsun' ); ?></button>
		</form>
		<?php get_template_part( 'template-parts/forms/whatsapp-link' ); ?>
	</div>
</section>
