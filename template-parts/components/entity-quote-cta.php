<?php
/**
 * Contextual quote CTA for solutions and technologies.
 *
 * Expected $args: context (solucion|tecnologia), post_id.
 *
 * @package Leadsun
 */

$context = $args['context'] ?? '';
$post_id = absint( $args['post_id'] ?? 0 );

if ( ! $post_id || ! in_array( $context, array( 'solucion', 'tecnologia' ), true ) ) {
	return;
}

$heading = 'tecnologia' === $context ? __( 'Consulta la aplicación de esta tecnología', 'leadsun' ) : __( '¿Tienes un proyecto en mente?', 'leadsun' );
$label   = 'tecnologia' === $context ? __( 'Consultar aplicación', 'leadsun' ) : __( 'Cotiza tu proyecto', 'leadsun' );
?>
<footer class="entity-single__cta">
	<div class="leadsun-container" data-aos="fade-up">
		<h2><?php echo esc_html( $heading ); ?></h2>
		<a class="btn-leadsun" href="<?php echo esc_url( add_query_arg( $context, $post_id, home_url( '/cotizar-proyecto/' ) ) ); ?>"><?php echo esc_html( $label ); ?></a>
	</div>
</footer>
