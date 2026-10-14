<?php
/**
 * Reusable technical highlight for solution pages.
 *
 * Expected $args: post_id.
 *
 * @package Leadsun
 */

$post_id        = absint( $args['post_id'] ?? 0 );
$title          = $post_id ? sanitize_text_field( (string) leadsun_field( 'solution_highlight_title', $post_id ) ) : '';
$text           = $post_id ? (string) leadsun_field( 'solution_highlight_text', $post_id ) : '';
$badge_title    = $post_id ? sanitize_text_field( (string) leadsun_field( 'solution_highlight_badge_title', $post_id ) ) : '';
$badge_subtitle = $post_id ? sanitize_text_field( (string) leadsun_field( 'solution_highlight_badge_subtitle', $post_id ) ) : '';
$note           = $post_id ? (string) leadsun_field( 'solution_note', $post_id ) : '';

if ( ! $title && ! $text && ! $badge_title && ! $note ) {
	return;
}
?>
<section class="solution-highlight" aria-labelledby="solution-highlight-title" data-aos="fade-up">
	<div>
		<?php if ( $title ) : ?><h2 id="solution-highlight-title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
		<?php if ( $text ) : ?><div class="solution-highlight__text"><?php echo wp_kses_post( wpautop( $text ) ); ?></div><?php endif; ?>
		<?php if ( $note ) : ?><div class="solution-highlight__note"><?php echo wp_kses_post( wpautop( $note ) ); ?></div><?php endif; ?>
	</div>
	<?php if ( $badge_title || $badge_subtitle ) : ?>
		<p class="solution-highlight__badge"><strong><?php echo esc_html( $badge_title ); ?></strong><?php if ( $badge_subtitle ) : ?><span><?php echo esc_html( $badge_subtitle ); ?></span><?php endif; ?></p>
	<?php endif; ?>
</section>
