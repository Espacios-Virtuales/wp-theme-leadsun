<?php
/**
 * Small reusable template tags.
 *
 * @package Leadsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function leadsun_posted_on(): void {
	printf(
		'<time class="entry-date published" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);
}
