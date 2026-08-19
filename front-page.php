<?php
/**
 * Front page structural shell.
 *
 * Visual composition is intentionally deferred to the design implementation task.
 *
 * @package Leadsun
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content/content', 'page' ); ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
