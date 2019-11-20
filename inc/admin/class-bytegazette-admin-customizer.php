<?php
/**
 * The Byte Gazette Theme Customizer
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
 * The theme customizer additions.
 */
class ByteGazette_Admin_Customizer {

	/**
	 * Initialize the admin customizer.
	 *
	 * @return void
	 */
	public static function init_admin_customizer() {

		add_action( 'customize_register', array( __CLASS__, 'customize_register' ) );
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_js' ) );

			add_action( 'bytegazette_customizer_section_site', array( __CLASS__, 'customizer_section_site' ) );
			add_action( 'bytegazette_customizer_section_homepage', array( __CLASS__, 'customizer_section_homepage' ) );
			add_action( 'bytegazette_customizer_section_header', array( __CLASS__, 'customizer_section_header' ) );
			add_action( 'bytegazette_customizer_section_footer', array( __CLASS__, 'customizer_section_footer' ), 10 );
			add_action( 'bytegazette_customizer_section_posts', array( __CLASS__, 'customizer_section_posts' ) );
			add_action( 'bytegazette_customizer_section_archives', array( __CLASS__, 'customizer_section_archives' ) );
			add_action( 'bytegazette_customizer_section_background', array( __CLASS__, 'customizer_section_background' ) );
	}

	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function customize_register( $wp_customize ) {
		require_once get_template_directory() . '/inc/customizer/class-bytegazette-customizer-control-radio-image.php';
		require_once get_template_directory() . '/inc/customizer/class-bytegazette-customizer-controls.php';
		require_once get_template_directory() . '/inc/customizer/customizer-sanitize.php';

		$show_sections = bytegazette_get_option( 'show_sections', ByteGazette::get_theme_customizer_options() );

		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		if ( isset( $show_sections['site'] ) && $show_sections['site'] ) {
			do_action( 'bytegazette_customizer_section_site' );
		}

		if ( isset( $show_sections['homepage'] ) && $show_sections['homepage'] ) {
			do_action( 'bytegazette_customizer_section_homepage' );
		}

		if ( isset( $show_sections['header'] ) && $show_sections['header'] ) {
			do_action( 'bytegazette_customizer_section_header' );
		}

		if ( isset( $show_sections['footer'] ) && $show_sections['footer'] ) {
			do_action( 'bytegazette_customizer_section_footer' );
		}

		if ( isset( $show_sections['posts'] ) && $show_sections['posts'] ) {
			do_action( 'bytegazette_customizer_section_posts' );
		}

		if ( isset( $show_sections['archives'] ) && $show_sections['archives'] ) {
			do_action( 'bytegazette_customizer_section_archives' );
		}

		if ( isset( $show_sections['background'] ) && $show_sections['background'] ) {
			do_action( 'bytegazette_customizer_section_background' );
		}

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'blogname', array(
				'selector'        => '.site-title a',
				'render_callback' => array( __CLASS__, 'customize_partial_blogname' ),
			) );
			$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => array( __CLASS__, 'customize_partial_blogdescription' ),
			) );
		}
	}

	/**
	 * Render the site title for the selective refresh partial.
	 *
	 * @return void
	 */
	public static function customize_partial_blogname() {
		bloginfo( 'name' );
	}

	/**
	 * Render the site tagline for the selective refresh partial.
	 *
	 * @return void
	 */
	public static function customize_partial_blogdescription() {
		bloginfo( 'description' );
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @return void
	 */
	public static function customize_preview_js() {
		wp_enqueue_script( 'bytegazette-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
	}

	/**
	 * Add a setcion to the theme customizer to customize general site options.
	 *
	 * @return void
	 */
	public static function customizer_section_site() {
		ByteGazette_Customizer_Controls::add_section( 'bytegazette_site', array(
			'title' => esc_html__( 'Site Options', 'bytegazette' ),
		), 20 );

		// @todo Generate an actual date and run through the formatters for preview.
		ByteGazette_Customizer_Controls::add_radio( 'date_format', 'bytegazette_site', array(
			'label'   => esc_html__( 'Date Format', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_DATE_FORMAT,
			'choices' => array(
				'default'  => esc_html__( 'Default', 'bytegazette' ) . ' (' . get_option( 'date_format' ) . ')',
				'relative' => esc_html__( 'Relative', 'bytegazette' ) . ' (Days Ago)',
			),
		) );

		// Site sidebar display options.
		ByteGazette_Customizer_Controls::add_image_radio( 'sidebar_layout', 'bytegazette_site', array(
			'label'   => esc_html__( 'Sidebar Settings', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_SIDEBAR_LAYOUT,
			'choices' => array(
				'right_sidebar' => get_template_directory_uri() . '/images/customizer/sidebar_right.png',
				'left_sidebar'  => get_template_directory_uri() . '/images/customizer/sidebar_left.png',
				'no_sidebar'    => get_template_directory_uri() . '/images/customizer/sidebar_no.png',
			),
		) );

		// Site display setting.
		ByteGazette_Customizer_Controls::add_image_radio( 'content_layout', 'bytegazette_site', array(
			'label'   => esc_html__( 'Display', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_CONTENT_LAYOUT,
			'choices' => array(
				'default' => get_template_directory_uri() . '/images/customizer/display_default.png',
				'style1'  => get_template_directory_uri() . '/images/customizer/display_style1.png',
				'media'   => get_template_directory_uri() . '/images/customizer/display_style1.png',
				'grid'    => get_template_directory_uri() . '/images/customizer/display_style1.png',
			),
		) );
	}

	/**
	 * Add a section to the theme customizer to customize the home page.
	 *
	 * @return void
	 */
	public static function customizer_section_homepage() {
		ByteGazette_Customizer_Controls::add_section( 'bytegazette_home_page', array(
			'title'           => esc_html__( 'Home Page', 'bytegazette' ),
			'active_callback' => 'is_front_page',
		), 25 );

		ByteGazette_Customizer_Controls::add_custom_image( 'bytegazette_home_page_banner', 'bytegazette_home_page', array(
			'label'   => esc_html__( 'Home Page Banner', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_HOME_PAGE_BANNER,
		) );
	}

	/**
	 * Add a section to the theme customizer to customize the site header.
	 *
	 * @return void
	 */
	public static function customizer_section_header() {
		ByteGazette_Customizer_Controls::add_section( 'bytegazette_header', array(
			'title' => esc_html__( 'Header', 'bytegazette' ),
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_bg_color', 'bytegazette_header', array(
			'label'   => esc_html__( 'Background Color', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_HEADER_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_radio( 'header_fg_class', 'bytegazette_header', array(
			'label'   => esc_html__( 'Foreground Style', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_HEADER_FG_CLASS,
			'choices' => array(
				'uk-light' => esc_html__( 'Light', 'bytegazette' ),
				'uk-dark'  => esc_html__( 'Dark', 'bytegazette' ),
			),
		) );
	}

	/**
	 * Add a section to the theme customizer to customize the footer.
	 *
	 * @return void
	 */
	public static function customizer_section_footer() {
		ByteGazette_Customizer_Controls::add_section( 'bytegazette_footer', array(
			'title' => esc_html__( 'Footer', 'bytegazette' ),
		) );

		ByteGazette_Customizer_Controls::add_custom_image( 'footer_logo', 'bytegazette_footer', array(
			'label'   => esc_html__( 'Footer Logo Image', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_FOOTER_LOGO,
		) );

		ByteGazette_Customizer_Controls::add_color( 'footer_upper_bg_color', 'bytegazette_footer', array(
			'label'   => esc_html__( 'Upper Footer Background Color', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_FOOTER_UPPER_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'footer_lower_bg_color', 'bytegazette_footer', array(
			'label'   => esc_html__( 'Lower Footer Background Color', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_FOOTER_LOWER_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_radio( 'footer_fg_class', 'bytegazette_footer', array(
			'label'   => esc_html__( 'Foreground Style', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_FOOTER_FG_CLASS,
			'choices' => array(
				'uk-light' => esc_html__( 'Light', 'bytegazette' ),
				'uk-dark'  => esc_html__( 'Dark', 'bytegazette' ),
			),
		) );

		ByteGazette_Customizer_Controls::add_textarea( 'footer_upper_text', 'bytegazette_footer', array(
			'label'       => esc_html__( 'Upper Footer Text', 'bytegazette' ),
			'default'     => ByteGazette::get_powered_by_text(),
			'description' => esc_html__( 'Allowed tags: <a>, <br>, <em>, <strong>, <i> <img>, and [shortcodes]', 'bytegazette' ),
		) );

		ByteGazette_Customizer_Controls::add_textarea( 'footer_lower_text', 'bytegazette_footer', array(
			'label'       => esc_html__( 'Lower Footer Text', 'bytegazette' ),
			'default'     => ByteGazette::get_theme_author_text(),
			'description' => esc_html__( 'Allowed tags: <a>, <br>, <em>, <strong>, <i> <img>, and [shortcodes]', 'bytegazette' ),
		) );
	}

	/**
	 * Add a section to the theme customizer to customize article options.
	 *
	 * @return void
	 */
	public static function customizer_section_posts() {
		// Posts section.
		ByteGazette_Customizer_Controls::add_section( 'bytegazette_posts', array(
			'title' => esc_html__( 'Posts', 'bytegazette' ),
		) );

		// Show breadcrumbs on posts.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_breadcrumbs', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Breadcrumbs', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_POST_BREADCRUMBS,
		) );

		// Show post meta elements on post pages.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_meta', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Post Meta', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_POST_META,
		) );

		// Show the related posts section on post pages.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_related_show', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Related Posts', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_POST_RELATED,
		) );

		// Number of related posts to show.
		ByteGazette_Customizer_Controls::add_number( 'post_related_count', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Related Posts to Show', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_POST_RELATED_COUNT,
			'min'     => 1,
			'max'     => 6,
		) );

		// Method to use to discover related posts.
		ByteGazette_Customizer_Controls::add_radio( 'post_related_method', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Related Posts Method', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_POST_RELATED_METHOD,
			'choices' => array(
				'tags'       => esc_html__( 'Tags', 'bytegazette' ),
				'categories' => esc_html__( 'Categories', 'bytegazette' ),
			),
		) );

		// Show the next/previous links on posts.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_next_prev', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Next/Previous Links', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_POST_NEXT_PREV,
		) );

		// Display the author information on posts.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_author_box', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Author Box', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_POST_AUTHOR_BOX,
		) );
	}

	/**
	 * Add a section to the theme customizer to customize the site archives display.
	 *
	 * @return void
	 */
	public static function customizer_section_archives() {
		// Archives section.
		ByteGazette_Customizer_Controls::add_section( 'bytegazette_archives', array(
			'title' => esc_html__( 'Archives', 'bytegazette' ),
		) );

		// Show post meta elements on archives.
		ByteGazette_Customizer_Controls::add_checkbox( 'archives_meta', 'bytegazette_archives', array(
			'label'   => esc_html__( 'Post Meta', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_ARCHIVES_META,
		) );

		// Max length of the excerpt text on archives.
		ByteGazette_Customizer_Controls::add_number( 'archives_excerpt_length', 'bytegazette_archives', array(
			'label'       => esc_html__( 'Excerpt Length', 'bytegazette' ),
			'description' => esc_html__( 'Excerpt length (in Words) for Homepage & archive pages. Min is 0, max is 500. Set to 0 to disable.', 'bytegazette' ),
			'default'     => ByteGazette::DEFAULT_ARCHIVES_EXCERPT_LENGTH,
			'min'         => 0,
			'max'         => 500,
		) );

	}

	/**
	 * Amend the section for background customization.
	 *
	 * @return void
	 */
	public static function customizer_section_background() {
		ByteGazette_Customizer_Controls::add_radio( 'background_option', 'background_image', array(
			'label'   => esc_html__( 'Background Image', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_BACKGROUND_OPTION,
			'choices' => array(
				'none'         => esc_html__( 'None', 'bytegazette' ),
				'custom_image' => esc_html__( 'Custom Image', 'bytegazette' ),
				'pattern'      => esc_html__( 'Pattern', 'bytegazette' ),
			),
		), 1 );

		// Background Pattern.
		ByteGazette_Customizer_Controls::add_image_radio( 'background_pattern', 'background_image', array(
			'label'   => esc_html__( 'Background Pattern', 'bytegazette' ),
			'default' => ByteGazette::DEFAULT_BACKGROUND_PATTERN,
			'choices' => array(
				get_template_directory_uri() . '/images/patterns/21.gif' => get_template_directory_uri() . '/images/patterns/21.gif',
				get_template_directory_uri() . '/images/patterns/22.gif' => get_template_directory_uri() . '/images/patterns/22.gif',
				get_template_directory_uri() . '/images/patterns/23.gif' => get_template_directory_uri() . '/images/patterns/23.gif',
				get_template_directory_uri() . '/images/patterns/24.gif' => get_template_directory_uri() . '/images/patterns/24.gif',
				get_template_directory_uri() . '/images/patterns/25.gif' => get_template_directory_uri() . '/images/patterns/25.gif',
				get_template_directory_uri() . '/images/patterns/26.gif' => get_template_directory_uri() . '/images/patterns/26.gif',
				get_template_directory_uri() . '/images/patterns/27.gif' => get_template_directory_uri() . '/images/patterns/27.gif',
				get_template_directory_uri() . '/images/patterns/28.gif' => get_template_directory_uri() . '/images/patterns/28.gif',
				get_template_directory_uri() . '/images/patterns/29.gif' => get_template_directory_uri() . '/images/patterns/29.gif',
				get_template_directory_uri() . '/images/patterns/30.gif' => get_template_directory_uri() . '/images/patterns/30.gif',
				get_template_directory_uri() . '/images/patterns/31.gif' => get_template_directory_uri() . '/images/patterns/31.gif',
				get_template_directory_uri() . '/images/patterns/32.gif' => get_template_directory_uri() . '/images/patterns/32.gif',
				get_template_directory_uri() . '/images/patterns/33.gif' => get_template_directory_uri() . '/images/patterns/33.gif',
				get_template_directory_uri() . '/images/patterns/34.gif' => get_template_directory_uri() . '/images/patterns/34.gif',
				get_template_directory_uri() . '/images/patterns/35.gif' => get_template_directory_uri() . '/images/patterns/35.gif',
				get_template_directory_uri() . '/images/patterns/36.gif' => get_template_directory_uri() . '/images/patterns/36.gif',
				get_template_directory_uri() . '/images/patterns/37.gif' => get_template_directory_uri() . '/images/patterns/37.gif',
				get_template_directory_uri() . '/images/patterns/38.gif' => get_template_directory_uri() . '/images/patterns/38.gif',
				get_template_directory_uri() . '/images/patterns/39.gif' => get_template_directory_uri() . '/images/patterns/39.gif',
				get_template_directory_uri() . '/images/patterns/40.gif' => get_template_directory_uri() . '/images/patterns/40.gif',
				get_template_directory_uri() . '/images/patterns/2.jpg'  => get_template_directory_uri() . '/images/patterns/2.jpg',
				get_template_directory_uri() . '/images/patterns/3.jpg'  => get_template_directory_uri() . '/images/patterns/3.jpg',
				get_template_directory_uri() . '/images/patterns/4.jpg'  => get_template_directory_uri() . '/images/patterns/4.jpg',
				get_template_directory_uri() . '/images/patterns/5.jpg'  => get_template_directory_uri() . '/images/patterns/5.jpg',
				get_template_directory_uri() . '/images/patterns/6.jpg'  => get_template_directory_uri() . '/images/patterns/6.jpg',
				get_template_directory_uri() . '/images/patterns/7.jpg'  => get_template_directory_uri() . '/images/patterns/7.jpg',
				get_template_directory_uri() . '/images/patterns/8.jpg'  => get_template_directory_uri() . '/images/patterns/8.jpg',
				get_template_directory_uri() . '/images/patterns/9.jpg'  => get_template_directory_uri() . '/images/patterns/9.jpg',
				get_template_directory_uri() . '/images/patterns/10.jpg' => get_template_directory_uri() . '/images/patterns/10.jpg',
				get_template_directory_uri() . '/images/patterns/11.jpg' => get_template_directory_uri() . '/images/patterns/11.jpg',
				get_template_directory_uri() . '/images/patterns/12.jpg' => get_template_directory_uri() . '/images/patterns/12.jpg',
				get_template_directory_uri() . '/images/patterns/13.jpg' => get_template_directory_uri() . '/images/patterns/13.jpg',
				get_template_directory_uri() . '/images/patterns/14.jpg' => get_template_directory_uri() . '/images/patterns/14.jpg',
				get_template_directory_uri() . '/images/patterns/15.jpg' => get_template_directory_uri() . '/images/patterns/15.jpg',
				get_template_directory_uri() . '/images/patterns/16.jpg' => get_template_directory_uri() . '/images/patterns/16.jpg',
				get_template_directory_uri() . '/images/patterns/17.jpg' => get_template_directory_uri() . '/images/patterns/17.jpg',
				get_template_directory_uri() . '/images/patterns/18.jpg' => get_template_directory_uri() . '/images/patterns/18.jpg',
				get_template_directory_uri() . '/images/patterns/19.jpg' => get_template_directory_uri() . '/images/patterns/19.jpg',
				get_template_directory_uri() . '/images/patterns/20.jpg' => get_template_directory_uri() . '/images/patterns/20.jpg',
			),
		), 30 );
	}

}
