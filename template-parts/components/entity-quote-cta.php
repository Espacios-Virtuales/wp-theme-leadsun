<?php
/**
 * Contextual quote CTA for solutions and technologies.
 *
 * Expected $args: context (solucion|tecnologia|proyecto), post_id.
 *
 * @package Leadsun
 */

$context = $args['context'] ?? '';
$post_id = absint( $args['post_id'] ?? 0 );

if ( ! $post_id || ! in_array( $context, array( 'solucion', 'tecnologia', 'proyecto' ), true ) ) {
	return;
}

$heading     = 'tecnologia' === $context ? __( 'Consulta la aplicación de esta tecnología', 'leadsun' ) : __( '¿Tienes un proyecto en mente?', 'leadsun' );
$description = '';
$label       = 'tecnologia' === $context ? __( 'Consultar aplicación', 'leadsun' ) : __( 'Cotiza tu proyecto', 'leadsun' );
$quote_url   = add_query_arg( $context, $post_id, home_url( '/cotizar-proyecto/' ) );

if ( 'proyecto' === $context ) {
	$heading     = __( '¿Necesitas una solución similar?', 'leadsun' );
	$description = __( 'Conversemos sobre los requerimientos de tu proyecto y las alternativas que LEADSUN puede desarrollar.', 'leadsun' );
	$label       = __( 'Cotizar un proyecto similar', 'leadsun' );
	$quote_url   = 'leadsun_project' === get_post_type( $post_id ) && 'publish' === get_post_status( $post_id )
		? $quote_url
		: leadsun_quote_page_url();
}
?>
<footer class="entity-single__cta">
	<div class="leadsun-container" data-aos="fade-up">
		<div class="entity-single__cta-copy">
			<h2><?php echo esc_html( $heading ); ?></h2>
			<?php if ( $description ) : ?><p><?php echo esc_html( $description ); ?></p><?php endif; ?>
		</div>
		<a class="btn-leadsun" href="<?php echo esc_url( $quote_url ); ?>"><?php echo esc_html( $label ); ?></a>
	</div>
</footer>
