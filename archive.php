<?php
/**
 * Archive fallback template.
 *
 * @package Leadsun
 */

get_header();
?>
<main id="primary" class="site-main container">
	<header class="archive-header">
		<?php the_archive_title( '<h1 class="archive-title">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content/content', get_post_type() ); ?>
		<?php endwhile; ?>
		<?php the_posts_navigation(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
	<?php endif; ?>
</main>
<?php
get_footer();
