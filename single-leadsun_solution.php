<?php
/**
 * Solution single.
 *
 * @package Leadsun
 */

get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/single/entity-content' );
endwhile;
get_footer();
