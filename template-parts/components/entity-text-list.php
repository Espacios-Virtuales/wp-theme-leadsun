<?php
/**
 * Reusable line-based editorial section for solution information.
 *
 * Expected $args: post_id, field, title, id.
 *
 * @package Leadsun
 */

$post_id = absint( $args['post_id'] ?? 0 );
$field   = sanitize_key( (string) ( $args['field'] ?? '' ) );
$title   = sanitize_text_field( (string) ( $args['title'] ?? '' ) );
$id      = sanitize_html_class( (string) ( $args['id'] ?? '' ) );
$value   = $post_id && $field ? (string) leadsun_field( $field, $post_id ) : '';
$items   = array_filter( array_map( 'trim', preg_split( '/\R/u', $value ) ?: array() ) );

if ( ! $title || ! $items ) {
	return;
}
?>
<section<?php echo $id ? ' id="' . esc_attr( $id ) . '"' : ''; ?> class="entity-text-list" aria-labelledby="<?php echo esc_attr( $id ? $id . '-title' : sanitize_title( $title ) . '-title' ); ?>" data-aos="fade-up">
	<h2 id="<?php echo esc_attr( $id ? $id . '-title' : sanitize_title( $title ) . '-title' ); ?>"><?php echo esc_html( $title ); ?></h2>
	<ul>
		<?php foreach ( $items as $item ) : ?>
			<li><?php echo esc_html( $item ); ?></li>
		<?php endforeach; ?>
	</ul>
</section>
