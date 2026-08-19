<?php
/**
 * Project single shell.
 *
 * ACF field composition is intentionally deferred.
 *
 * @package Leadsun
 */

get_header();
?>
<main id="primary" class="site-main container">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content/content', 'leadsun_project' ); ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
