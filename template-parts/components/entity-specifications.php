<?php
/**
 * Render editable solution specifications from a simple textarea.
 *
 * Expected $args: post_id.
 *
 * @package Leadsun
 */

$post_id = absint( $args['post_id'] ?? 0 );
$value   = $post_id ? leadsun_field( 'solution_specifications', $post_id ) : '';
$rows    = array();

if ( is_string( $value ) ) {
	foreach ( preg_split( '/\R/u', $value ) as $line ) {
		$parts = explode( '|', $line, 2 );

		if ( 2 !== count( $parts ) ) {
			continue;
		}

		$label = trim( $parts[0] );
		$value = trim( $parts[1] );

		if ( '' !== $label && '' !== $value ) {
			$rows[] = array( $label, $value );
		}
	}
}

if ( ! $rows ) {
	return;
}
?>
<section class="entity-specifications" aria-labelledby="entity-specifications-title" data-aos="fade-up">
	<h2 id="entity-specifications-title"><?php esc_html_e( 'Ficha técnica', 'leadsun' ); ?></h2>
	<div class="entity-specifications__table-wrap">
		<table>
			<tbody>
				<?php foreach ( $rows as $row ) : ?>
					<tr>
						<th scope="row"><?php echo esc_html( $row[0] ); ?></th>
						<td><?php echo esc_html( $row[1] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>
