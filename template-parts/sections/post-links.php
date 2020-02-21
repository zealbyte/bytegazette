<?php
/**
 * Template part for displaying post's next & previous posts links.
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

previous_post_link( '<div class="left-button">%link</div>', esc_html__( 'Previous Post', 'bytegazette' ) );
next_post_link( '<div class="right-button">%link</div>', esc_html__( 'Next Post', 'bytegazette' ) );
