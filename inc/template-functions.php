<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Byte_Gazette
 */

/*
This file is part of the Byte Gazette theme for WordPress.

Byte Gazette is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

Byte Gazette is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Byte Gazette.  If not, see <http://www.gnu.org/licenses/>.

Copyright 2018 ZealByte.
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bytegazette_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar' ) ) {
		$classes[] = 'no-sidebar';
	}

	$option_classes = array();

	return array_merge( $classes, $option_classes );
}
add_filter( 'body_class', 'bytegazette_body_classes' );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function bytegazette_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'bytegazette_pingback_header' );


/**
 * Remove [...] & shortcodes from excerpt.
 *
 * @param string $output The excerpt text to be filtered.
 * @return string The fildered excerpt.
 */
function bytegazette_custom_excerpt( $output ) {
	return preg_replace( '/\[[^\]]*]/', '', $output );
}
add_filter( 'get_the_excerpt', 'bytegazette_custom_excerpt' );
remove_filter( 'the_excerpt', 'wpautop' );


/**
 * Set max excerpt length to 400.
 *
 * @param int $length The configured length of excerpt text.
 * @return int The determined max lenght of excerpt text.
 */
function bytegazette_custom_excerpt_length( $length ) {
	return 400;
}
add_filter( 'excerpt_length', 'bytegazette_custom_excerpt_length', 999 );


/**
 * Custom previous_post_link && next_post_link link class.
 *
 * @param string $output The origional html which makes the prev/next link.
 * @return string The html for the custom prev/next link.
 */
function bytegazette_next_prev_link_attributes( $output ) {
	$code = 'class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"';
	return str_replace( '<a href=', '<a ' . $code . ' href=', $output );
}
add_filter( 'next_post_link', 'bytegazette_next_prev_link_attributes' );
add_filter( 'previous_post_link', 'bytegazette_next_prev_link_attributes' );

