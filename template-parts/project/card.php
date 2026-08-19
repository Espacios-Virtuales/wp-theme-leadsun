<?php
/**
 * Project card structural shell.
 *
 * @package Leadsun
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'leadsun-card leadsun-card--project' ); ?>>
	<a class="leadsun-card__link" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="leadsun-card__media"><?php the_post_thumbnail( 'medium_large' ); ?></div>
		<?php endif; ?>
		<div class="leadsun-card__body">
			<?php the_title( '<h2 class="leadsun-card__title">', '</h2>' ); ?>
			<?php if ( has_excerpt() ) : ?><div class="leadsun-card__excerpt"><?php the_excerpt(); ?></div><?php endif; ?>
		</div>
	</a>
</article>
