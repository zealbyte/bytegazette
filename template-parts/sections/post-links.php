<?php
/**
 * Template part for displaying post's next & previous posts links.
 *
 * @package realistic
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !get_theme_mod( 'next_prev_post', '1' ) ) {
	return '';
} ?>

