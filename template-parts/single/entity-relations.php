<?php
/**
 * Existing project relationships for all supported entity singles.
 *
 * @package Leadsun
 */

$post_id   = absint( $args['post_id'] ?? 0 );
$post_type = get_post_type( $post_id );
$items     = array();

if ( 'leadsun_project' === $post_type ) {
	$relations = leadsun_project_relations( $post_id );
	$items     = array_filter(
		array(
			array( __( 'Solución relacionada', 'leadsun' ), $relations['solution'] ),
			array( __( 'Tecnología relacionada', 'leadsun' ), $relations['technology'] ),
		),
		static function ( array $item ): bool {
			return $item[1] > 0;
		}
	);
} elseif ( in_array( $post_type, array( 'leadsun_solution', 'leadsun_technology' ), true ) ) {
	if ( 'leadsun_technology' === $post_type ) {
		foreach ( leadsun_technology_solution_relations( $post_id ) as $solution_id ) {
			$items[] = array( __( 'Solución compatible', 'leadsun' ), $solution_id );
		}
	} else {
		foreach ( leadsun_entity_project_relations( $post_id, $post_type ) as $project_id ) {
			$items[] = array( __( 'Proyecto relacionado', 'leadsun' ), $project_id );
		}
	}
}

if ( ! $items ) {
	return;
}

$heading = 'leadsun_technology' === $post_type ? __( 'Soluciones compatibles confirmadas', 'leadsun' ) : __( 'Relaciones', 'leadsun' );
?>
<section class="entity-relations" aria-labelledby="entity-relations-title" data-aos="fade-up">
	<h2 id="entity-relations-title"><?php echo esc_html( $heading ); ?></h2>
	<ul>
		<?php foreach ( $items as $item ) : ?>
			<li><span><?php echo esc_html( $item[0] ); ?></span> <a href="<?php echo esc_url( get_permalink( $item[1] ) ); ?>"><?php echo esc_html( get_the_title( $item[1] ) ); ?></a></li>
		<?php endforeach; ?>
	</ul>
</section>
