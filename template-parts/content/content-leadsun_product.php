<?php
/**
 * Product content shell.
 *
 * @package Leadsun
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'leadsun-product' ); ?>>
	<header class="leadsun-product__header">
		<?php the_title( '<h1 class="leadsun-product__title">', '</h1>' ); ?>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="leadsun-product__media"><?php the_post_thumbnail( 'large' ); ?></div>
	<?php endif; ?>
	<div class="leadsun-product__content"><?php the_content(); ?></div>
</article>
