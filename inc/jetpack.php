<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package NewsAnchor
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function newsanchor_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'newsanchor_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function newsanchor_jetpack_setup
add_action( 'after_setup_theme', 'newsanchor_jetpack_setup' );

function newsanchor_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function newsanchor_infinite_scroll_render