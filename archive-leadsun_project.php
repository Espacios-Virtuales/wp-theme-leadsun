<?php
/**
 * Project archive shell.
 *
 * @package Leadsun
 */

get_header();
?>
<main id="primary" class="site-main container">
	<header class="archive-header">
		<h1><?php post_type_archive_title(); ?></h1>
	</header>
	<div class="leadsun-grid leadsun-grid--projects">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/project/card' ); ?>
		<?php endwhile; ?>
	</div>
	<?php the_posts_navigation(); ?>
</main>
<?php
get_footer();
