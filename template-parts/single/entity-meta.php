<?php
/**
 * Metadata only applicable to projects and solution lines.
 *
 * @package Leadsun
 */

$post_type = $args['post_type'] ?? '';
$post_id   = $args['post_id'] ?? 0;

if ( 'leadsun_solution' === $post_type ) {
	$terms = get_the_terms( $post_id, 'leadsun_solution_line' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
		?>
		<p class="entity-meta"><?php echo esc_html( implode( ' · ', wp_list_pluck( $terms, 'name' ) ) ); ?></p>
	<?php endif;
}

if ( 'leadsun_project' === $post_type ) {
	$location = leadsun_field( 'project_location', $post_id );
	$year     = leadsun_field( 'project_year', $post_id );
	if ( $location || $year ) :
		?>
		<p class="entity-meta"><?php echo esc_html( implode( ' · ', array_filter( array( $location, $year ) ) ) ); ?></p>
	<?php endif;
}
