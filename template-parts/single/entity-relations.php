<?php
/**
 * One-way project relationships.
 *
 * @package Leadsun
 */

$relations = leadsun_project_relations( $args['post_id'] ?? null );
$items     = array_filter(
	array(
		'solution'   => array( __( 'Solución relacionada', 'leadsun' ), $relations['solution'] ),
		'technology' => array( __( 'Tecnología relacionada', 'leadsun' ), $relations['technology'] ),
	),
	static function ( array $item ): bool {
		return $item[1] > 0;
	}
);

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
