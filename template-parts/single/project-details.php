<?php
/**
 * Optional operational detail fields for a project.
 *
 * Expected $args: post_id.
 *
 * @package Leadsun
 */

$post_id = absint( $args['post_id'] ?? 0 );
$fields  = array(
	'project_location'      => __( 'Ubicación', 'leadsun' ),
	'project_application'   => __( 'Aplicación', 'leadsun' ),
	'project_quantity'      => __( 'Cantidad', 'leadsun' ),
	'project_configuration' => __( 'Configuración', 'leadsun' ),
	'project_condition'     => __( 'Condición', 'leadsun' ),
);
$items = array();

foreach ( $fields as $field => $label ) {
	$value = trim( (string) leadsun_field( $field, $post_id ) );
	if ( $value ) {
		$items[ $label ] = $value;
	}
}

if ( ! $items ) {
	return;
}
?>
<section class="entity-project-details" aria-labelledby="entity-project-details-title" data-aos="fade-up">
	<h2 id="entity-project-details-title"><?php esc_html_e( 'Datos del proyecto', 'leadsun' ); ?></h2>
	<dl>
		<?php foreach ( $items as $label => $value ) : ?>
			<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div>
		<?php endforeach; ?>
	</dl>
</section>
