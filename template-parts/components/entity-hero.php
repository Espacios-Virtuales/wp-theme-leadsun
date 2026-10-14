<?php
/**
 * Shared archive and single entity hero.
 *
 * @package Leadsun
 */

$title      = $args['title'] ?? '';
$eyebrow    = $args['eyebrow'] ?? '';
$excerpt    = $args['excerpt'] ?? '';
$meta       = is_array( $args['meta'] ?? null ) ? array_filter( array_map( 'sanitize_text_field', $args['meta'] ) ) : array();
$poster_url = $args['poster_url'] ?? '';
$compact    = ! empty( $args['compact'] );
?>
<header class="entity-hero<?php echo $poster_url ? ' entity-hero--has-media' : ''; ?><?php echo $compact ? ' entity-hero--compact' : ''; ?>">
	<?php if ( $poster_url ) : ?><img class="entity-hero__media" src="<?php echo esc_url( $poster_url ); ?>" alt="" aria-hidden="true"><?php endif; ?>
	<div class="entity-hero__overlay"></div>
	<div class="leadsun-container entity-hero__content">
		<?php if ( $eyebrow ) : ?><p class="leadsun-eyebrow" data-aos="fade-up"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
		<h1 data-aos="fade-up"><?php echo esc_html( $title ); ?></h1>
		<?php if ( $meta ) : ?><p class="entity-hero__meta" data-aos="fade-up"><?php echo esc_html( implode( ' · ', $meta ) ); ?></p><?php endif; ?>
		<?php if ( $excerpt ) : ?><p class="entity-hero__excerpt" data-aos="fade-up"><?php echo esc_html( $excerpt ); ?></p><?php endif; ?>
	</div>
</header>
