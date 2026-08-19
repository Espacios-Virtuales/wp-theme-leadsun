<?php
/**
 * Project content shell.
 *
 * @package Leadsun
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'leadsun-project' ); ?>>
	<header class="leadsun-project__header">
		<?php the_title( '<h1 class="leadsun-project__title">', '</h1>' ); ?>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="leadsun-project__media"><?php the_post_thumbnail( 'large' ); ?></div>
	<?php endif; ?>
	<div class="leadsun-project__content"><?php the_content(); ?></div>
</article>
