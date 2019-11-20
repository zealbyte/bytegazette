<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Byte_Gazette
 */

$bytegazette_content_style = esc_attr( get_theme_mod( 'content_layout', ByteGazette::DEFAULT_CONTENT_LAYOUT ) );

get_template_part( 'template-parts/content', $bytegazette_content_style );
