<?php
/**
 * Render editable solution specifications from a simple textarea.
 *
 * Expected $args: post_id. Optional: field, title, id.
 *
 * @package Leadsun
 */

$post_id = absint( $args['post_id'] ?? 0 );
$field   = sanitize_key( (string) ( $args['field'] ?? 'solution_specifications' ) );
$title   = sanitize_text_field( (string) ( $args['title'] ?? __( 'Ficha técnica', 'leadsun' ) ) );
$id      = sanitize_html_class( (string) ( $args['id'] ?? 'entity-specifications' ) );
$value   = $post_id && $field ? leadsun_field( $field, $post_id ) : '';
$rows    = leadsun_parse_specification_rows( $value );

if ( ! $title || ! $rows ) {
	return;
}
?>
<section id="<?php echo esc_attr( $id ); ?>" class="entity-specifications" aria-labelledby="<?php echo esc_attr( $id . '-title' ); ?>" data-aos="fade-up">
	<h2 id="<?php echo esc_attr( $id . '-title' ); ?>"><?php echo esc_html( $title ); ?></h2>
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
