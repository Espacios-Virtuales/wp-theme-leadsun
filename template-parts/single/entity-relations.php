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
	foreach ( leadsun_entity_project_relations( $post_id, $post_type ) as $project_id ) {
		$items[] = array( __( 'Proyecto relacionado', 'leadsun' ), $project_id );
	}
}

if ( ! $items ) {
	return;
}
?>
<section class="entity-relations" aria-labelledby="entity-relations-title">
	<h2 id="entity-relations-title"><?php esc_html_e( 'Relaciones', 'leadsun' ); ?></h2>
	<ul>
		<?php foreach ( $items as $item ) : ?>
			<li><span><?php echo esc_html( $item[0] ); ?></span> <a href="<?php echo esc_url( get_permalink( $item[1] ) ); ?>"><?php echo esc_html( get_the_title( $item[1] ) ); ?></a></li>
		<?php endforeach; ?>
	</ul>
</section>
