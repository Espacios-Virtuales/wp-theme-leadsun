<?php
/**
 * Technology-specific principle or operation explanation.
 *
 * Expected $args: post_id.
 *
 * @package Leadsun
 */

$post_id = absint( $args['post_id'] ?? 0 );
$title   = $post_id ? sanitize_text_field( (string) leadsun_field( 'technology_principle_title', $post_id ) ) : '';
$text    = $post_id ? trim( (string) leadsun_field( 'technology_principle_text', $post_id ) ) : '';

if ( ! $title && ! $text ) {
	return;
}
?>
<section class="technology-principle" aria-labelledby="technology-principle-heading" data-aos="fade-up">
	<p class="technology-principle__eyebrow"><?php esc_html_e( 'Principio / funcionamiento', 'leadsun' ); ?></p>
	<?php if ( $title ) : ?><h2 id="technology-principle-heading"><?php echo esc_html( $title ); ?></h2><?php else : ?><h2 id="technology-principle-heading"><?php esc_html_e( 'Cómo funciona', 'leadsun' ); ?></h2><?php endif; ?>
	<?php if ( $text ) : ?><div class="technology-principle__text"><?php echo wp_kses_post( wpautop( $text ) ); ?></div><?php endif; ?>
</section>
