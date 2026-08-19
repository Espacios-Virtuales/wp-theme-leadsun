<?php
/**
 * Page content.
 *
 * @package Leadsun
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry--page' ); ?>>
	<header class="entry-header container">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
