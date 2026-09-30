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
?>
<footer class="entity-single__cta">
	<div class="leadsun-container">
		<h2><?php esc_html_e( '¿Tienes un proyecto en mente?', 'leadsun' ); ?></h2>
		<a class="btn-leadsun" href="<?php echo esc_url( add_query_arg( $context, $post_id, home_url( '/cotizar-proyecto/' ) ) ); ?>"><?php esc_html_e( 'Cotiza tu proyecto', 'leadsun' ); ?></a>
	</div>
</footer>
