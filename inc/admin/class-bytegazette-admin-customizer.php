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
		add_action( 'bytegazette_customizer_section_colors', array( __CLASS__, 'customizer_section_colors' ) );
		add_action( 'bytegazette_customizer_section_front_page', array( __CLASS__, 'customizer_section_front' ) );
		add_action( 'bytegazette_customizer_section_site', array( __CLASS__, 'customizer_section_site' ) );
		add_action( 'bytegazette_customizer_section_navigation', array( __CLASS__, 'customizer_section_navigation' ) );
		add_action( 'bytegazette_customizer_section_footer', array( __CLASS__, 'customizer_section_footer' ), 10 );
		add_action( 'bytegazette_customizer_section_posts', array( __CLASS__, 'customizer_section_posts' ) );
		add_action( 'bytegazette_customizer_section_comments', array( __CLASS__, 'customizer_section_comments' ) );
		add_action( 'bytegazette_customizer_section_archives', array( __CLASS__, 'customizer_section_archives' ) );
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

		if ( isset( $show_sections['colors'] ) && $show_sections['colors'] ) {
			do_action( 'bytegazette_customizer_section_colors' );
		}

		if ( isset( $show_sections['front'] ) && $show_sections['front'] ) {
			do_action( 'bytegazette_customizer_section_front_page' );
		}

		if ( isset( $show_sections['site'] ) && $show_sections['site'] ) {
			do_action( 'bytegazette_customizer_section_site' );
		}

		if ( isset( $show_sections['navigation'] ) && $show_sections['navigation'] ) {
			do_action( 'bytegazette_customizer_section_navigation' );
		}

		if ( isset( $show_sections['footer'] ) && $show_sections['footer'] ) {
			do_action( 'bytegazette_customizer_section_footer' );
		}

		if ( isset( $show_sections['posts'] ) && $show_sections['posts'] ) {
			do_action( 'bytegazette_customizer_section_posts' );
		}

		if ( isset( $show_sections['comments'] ) && $show_sections['comments'] ) {
			do_action( 'bytegazette_customizer_section_comments' );
		}

		if ( isset( $show_sections['archives'] ) && $show_sections['archives'] ) {
			do_action( 'bytegazette_customizer_section_archives' );
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
	 * Append the colors setcion of the theme customizer to customize custom colors.
	 *
	 * @return void
	 */
	public static function customizer_section_colors() {
		ByteGazette_Customizer_Controls::add_color( 'heading_fg_color', 'colors', array(
			'label'   => esc_html__( 'Heading Text', 'bytegazette' ),
			'default' => ByteGazette::HEADING_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'emphasis_fg_color', 'colors', array(
			'label'   => esc_html__( 'Emphasis Text', 'bytegazette' ),
			'default' => ByteGazette::EMPHASIS_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'mute_fg_color', 'colors', array(
			'label'   => esc_html__( 'Muted Text', 'bytegazette' ),
			'default' => ByteGazette::MUTE_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'border_color', 'colors', array(
			'label'   => esc_html__( 'Borders', 'bytegazette' ),
			'default' => ByteGazette::BORDER_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'even_bg_color', 'colors', array(
			'label'   => esc_html__( 'Even Row Background', 'bytegazette' ),
			'default' => ByteGazette::EVEN_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'odd_bg_color', 'colors', array(
			'label'   => esc_html__( 'Odd Row Background', 'bytegazette' ),
			'default' => ByteGazette::ODD_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_bg_color', 'colors', array(
			'label'   => esc_html__( 'Header Background', 'bytegazette' ),
			'default' => ByteGazette::HEADER_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_link_fg_color', 'colors', array(
			'label'   => esc_html__( 'Header Links', 'bytegazette' ),
			'default' => ByteGazette::HEADER_LINK_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_title_fg_color', 'colors', array(
			'label'   => esc_html__( 'Header Title', 'bytegazette' ),
			'default' => ByteGazette::HEADER_TITLE_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_nav_fg_color', 'colors', array(
			'label'   => esc_html__( 'Navigation Text', 'bytegazette' ),
			'default' => ByteGazette::HEADER_NAV_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_nav_bg_color', 'colors', array(
			'label'   => esc_html__( 'Navigation Background', 'bytegazette' ),
			'default' => ByteGazette::HEADER_NAV_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_nav_link_fg_color', 'colors', array(
			'label'   => esc_html__( 'Navigation Links', 'bytegazette' ),
			'default' => ByteGazette::HEADER_NAV_LINK_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_nav_item_bg_color', 'colors', array(
			'label'   => esc_html__( 'Navigation Item Background', 'bytegazette' ),
			'default' => ByteGazette::HEADER_NAV_ITEM_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_nav_item_fg_color', 'colors', array(
			'label'   => esc_html__( 'Navigation Item Text', 'bytegazette' ),
			'default' => ByteGazette::HEADER_NAV_ITEM_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_nav_item_current_bg_color', 'colors', array(
			'label'   => esc_html__( 'Navigation Current Item Background', 'bytegazette' ),
			'default' => ByteGazette::HEADER_NAV_ITEM_CURRENT_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_nav_item_current_fg_color', 'colors', array(
			'label'   => esc_html__( 'Navigation Current Item Text', 'bytegazette' ),
			'default' => ByteGazette::HEADER_NAV_ITEM_CURRENT_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_subnav_bg_color', 'colors', array(
			'label'   => esc_html__( 'Dropdown Background', 'bytegazette' ),
			'default' => ByteGazette::HEADER_SUBNAV_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_subnav_item_bg_color', 'colors', array(
			'label'   => esc_html__( 'Dropdown Item Background', 'bytegazette' ),
			'default' => ByteGazette::HEADER_SUBNAV_ITEM_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_subnav_item_fg_color', 'colors', array(
			'label'   => esc_html__( 'Dropdown Item Text', 'bytegazette' ),
			'default' => ByteGazette::HEADER_SUBNAV_ITEM_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_subnav_item_current_bg_color', 'colors', array(
			'label'   => esc_html__( 'Dropdown Item Current Background', 'bytegazette' ),
			'default' => ByteGazette::HEADER_SUBNAV_ITEM_CURRENT_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'header_subnav_item_current_fg_color', 'colors', array(
			'label'   => esc_html__( 'Dropdown Item Current Text', 'bytegazette' ),
			'default' => ByteGazette::HEADER_SUBNAV_ITEM_CURRENT_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'footer_fg_color', 'colors', array(
			'label'   => esc_html__( 'Footer Text', 'bytegazette' ),
			'default' => ByteGazette::FOOTER_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'footer_bg_color', 'colors', array(
			'label'   => esc_html__( 'Footer Background', 'bytegazette' ),
			'default' => ByteGazette::FOOTER_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'footer_link_fg_color', 'colors', array(
			'label'   => esc_html__( 'Footer Links', 'bytegazette' ),
			'default' => ByteGazette::FOOTER_LINK_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'footer_heading_fg_color', 'colors', array(
			'label'   => esc_html__( 'Footer Heading Text', 'bytegazette' ),
			'default' => ByteGazette::FOOTER_HEADING_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'footer_nav_fg_color', 'colors', array(
			'label'   => esc_html__( 'Footer Navigation Text', 'bytegazette' ),
			'default' => ByteGazette::FOOTER_NAV_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'footer_nav_bg_color', 'colors', array(
			'label'   => esc_html__( 'Footer Navigation Background', 'bytegazette' ),
			'default' => ByteGazette::FOOTER_NAV_BG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'footer_nav_link_fg_color', 'colors', array(
			'label'   => esc_html__( 'Footer Navigation Link', 'bytegazette' ),
			'default' => ByteGazette::FOOTER_NAV_LINK_FG_COLOR,
		) );

		ByteGazette_Customizer_Controls::add_color( 'footer_nav_heading_fg_color', 'colors', array(
			'label'   => esc_html__( 'Footer Navigation Title Text', 'bytegazette' ),
			'default' => ByteGazette::FOOTER_NAV_HEADING_FG_COLOR,
		) );
	}

	/**
	 * Add a setcion to the theme customizer to customize general site options.
	 *
	 * @return void
	 */
	public static function customizer_section_site() {
		ByteGazette_Customizer_Controls::add_section( 'bytegazette_site', array(
			'title' => esc_html__( 'Theme Settings', 'bytegazette' ),
		), 20 );

		// Site sidebar layout options.
		ByteGazette_Customizer_Controls::add_image_radio( 'sidebar_layout', 'bytegazette_site', array(
			'label'   => esc_html__( 'Sidebar Settings', 'bytegazette' ),
			'default' => ByteGazette::SIDEBAR_LAYOUT,
			'choices' => array(
				'right' => get_template_directory_uri() . '/assets/img/sidebar-right.png',
				'left'  => get_template_directory_uri() . '/assets/img/sidebar-left.png',
				'none'  => get_template_directory_uri() . '/assets/img/sidebar-none.png',
			),
		) );

		// Content layout setting.
		ByteGazette_Customizer_Controls::add_image_radio( 'content_layout', 'bytegazette_site', array(
			'label'   => esc_html__( 'Content Layout', 'bytegazette' ),
			'default' => ByteGazette::CONTENT_LAYOUT,
			'choices' => array(
				'list'    => get_template_directory_uri() . '/assets/img/feed-list.png',
				'grid'    => get_template_directory_uri() . '/assets/img/feed-cards.png',
			),
		) );

		// @todo Generate an actual date and run through the formatters for preview.
		ByteGazette_Customizer_Controls::add_radio( 'date_format', 'bytegazette_site', array(
			'label'   => esc_html__( 'Date Format', 'bytegazette' ),
			'default' => ByteGazette::DATE_FORMAT,
			'choices' => array(
				'default'  => esc_html__( 'Default', 'bytegazette' ) . ' (' . get_option( 'date_format' ) . ')',
				'relative' => esc_html__( 'Relative', 'bytegazette' ) . ' (Days Ago)',
			),
		) );
	}

	/**
	 * Add to front page section to customize layout.
	 *
	 * @return void
	 */
	public static function customizer_section_front() {
		// Site sidebar layout options.
		ByteGazette_Customizer_Controls::add_image_radio( 'front_sidebar', 'static_front_page', array(
			'label'   => esc_html__( 'Sidebar Settings', 'bytegazette' ),
			'default' => get_theme_mod( 'sidebar_layout', ByteGazette::SIDEBAR_LAYOUT ),
			'choices' => array(
				'right' => get_template_directory_uri() . '/assets/img/sidebar-right.png',
				'left'  => get_template_directory_uri() . '/assets/img/sidebar-left.png',
				'none'  => get_template_directory_uri() . '/assets/img/sidebar-none.png',
			),
		) );

		// Front content layout setting.
		ByteGazette_Customizer_Controls::add_image_radio( 'front_layout', 'static_front_page', array(
			'label'   => esc_html__( 'Content Layout', 'bytegazette' ),
			'default' => get_theme_mod( 'content_layout', ByteGazette::CONTENT_LAYOUT ),
			'choices' => array(
				'list'    => get_template_directory_uri() . '/assets/img/feed-list.png',
				'grid'    => get_template_directory_uri() . '/assets/img/feed-cards.png',
			),
		) );
	}

	/**
	 * Add a section to the theme customizer to customize the site navigation.
	 *
	 * @return void
	 */
	public static function customizer_section_navigation() {
		ByteGazette_Customizer_Controls::add_section( 'navigation', array(
			'title' => esc_html__( 'Navigation Bar', 'bytegazette' ),
		) );

		// Show search box in navbar.
		ByteGazette_Customizer_Controls::add_checkbox( 'nav_show_search', 'navigation', array(
			'label'   => esc_html__( 'Show Search', 'bytegazette' ),
			'default' => ByteGazette::NAV_SHOW_SEARCH,
		) );

		// The fixed position on scroll.
		ByteGazette_Customizer_Controls::add_radio( 'nav_sticky_setting', 'navigation', array(
			'label'   => esc_html__( 'Sticky Setting', 'bytegazette' ),
			'default' => ByteGazette::NAV_STICKY_SETTING,
			'choices' => array(
				'scroll'     => 'Scroll with page',
				'sticktop'   => 'Stick to top on scroll',
				'stickfixed' => 'Fixed header',
			),
		) );

		// Custom logo in navbar.
		ByteGazette_Customizer_Controls::add_cropped_image( 'navigation_icon_logo', 'navigation', array(
			'label'       => __( 'Icon Logo', 'bytegazette' ),
			'default'     => ByteGazette::NAVIGATION_ICON_LOGO,
			'width'       => 80,
			'height'      => 80,
			'flex_width'  => true,
			'flex_height' => false,
		) );
	}

	/**
	 * Add a section to the theme customizer to customize the footer.
	 *
	 * @return void
	 */
	public static function customizer_section_footer() {
		ByteGazette_Customizer_Controls::add_section( 'bytegazette_footer', array(
			'title' => esc_html__( 'Footer Logo', 'bytegazette' ),
		) );

		ByteGazette_Customizer_Controls::add_custom_image( 'footer_logo', 'bytegazette_footer', array(
			'label'   => esc_html__( 'Logo', 'bytegazette' ),
			'default' => ByteGazette::FOOTER_LOGO,
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
			'title' => esc_html__( 'Post Settings', 'bytegazette' ),
		) );

		// Show featured image on post pages.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_featured_image', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Show Featured Image', 'bytegazette' ),
			'default' => ByteGazette::POST_FEATURED_IMAGE,
		) );

		// Show post date on post pages.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_date', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Show Posted Date', 'bytegazette' ),
			'default' => ByteGazette::POST_DATE,
		) );

		// Show post author on post pages.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_author', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Show Post Author', 'bytegazette' ),
			'default' => ByteGazette::POST_AUTHOR,
		) );

		// Show the next/previous links on posts.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_next_prev', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Show Previous / Next Links', 'bytegazette' ),
			'default' => ByteGazette::POST_NEXT_PREV,
		) );

		// Show post tags on post pages.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_tags', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Show Tags', 'bytegazette' ),
			'default' => ByteGazette::POST_TAGS,
		) );

		// Show post categories on post pages.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_categories', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Show Categories', 'bytegazette' ),
			'default' => ByteGazette::POST_CATEGORIES,
		) );

		// Display the author information on posts.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_author_box', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Show Author Box', 'bytegazette' ),
			'default' => ByteGazette::POST_AUTHOR_BOX,
		) );

		// Show the related posts section on post pages.
		ByteGazette_Customizer_Controls::add_checkbox( 'post_related', 'bytegazette_posts', array(
			'label'   => esc_html__( 'Show Related Posts', 'bytegazette' ),
			'default' => ByteGazette::POST_RELATED,
		) );
	}

	/**
	 * Add a section to the theme customizer to customize the post comments style.
	 *
	 * @return void
	 */
	public static function customizer_section_comments() {
		// Archives section.
		ByteGazette_Customizer_Controls::add_section( 'comments', array(
			'title' => __( 'Comment Settings', 'bytegazette' ),
		) );

		// Comment avatar size.
		ByteGazette_Customizer_Controls::add_number( 'comment_avatar_size', 'comments', array(
			'label'       => __( 'Avatar Size', 'bytegazette' ),
			'description' => __( 'Size in pixels.', 'bytegazette' ),
			'default'     => ByteGazette::COMMENT_AVATAR_SIZE,
			'min'         => 16,
			'max'         => 128,
		) );

		// Comment pagination.
		ByteGazette_Customizer_Controls::add_select( 'comment_pagination', 'comments', array(
			'label'   => __( 'Comment Pagination', 'bytegazette' ),
			'default' => ByteGazette::COMMENT_PAGINATION,
			'choices' => array(
				'above' => __( 'Above Comments', 'bytegazette' ),
				'below' => __( 'Below Comments', 'bytegazette' ),
				'both'  => __( 'Above and Below Comments', 'bytegazette' ),
			),
		) );

		// Comment list type.
		ByteGazette_Customizer_Controls::add_select( 'comment_list_tag', 'comments', array(
			'label'   => __( 'List Type', 'bytegazette' ),
			'default' => ByteGazette::COMMENT_LIST_TAG,
			'choices' => array(
				'ol' => __( 'Ordered', 'bytegazette' ),
				'ul' => __( 'Unordered', 'bytegazette' ),
			),
		) );

		// Show short pingbacks.
		ByteGazette_Customizer_Controls::add_checkbox( 'comment_short_ping', 'comments', array(
			'label'   => __( 'Show Short Pingbacks', 'bytegazette' ),
			'default' => ByteGazette::COMMENT_SHORT_PING,
		) );
	}

	/**
	 * Add a section to the theme customizer to customize the site archives display.
	 *
	 * @return void
	 */
	public static function customizer_section_archives() {
		// Archives section.
		ByteGazette_Customizer_Controls::add_section( 'archives', array(
			'title' => esc_html__( 'Archive Settings', 'bytegazette' ),
		) );

		// Max length of the excerpt text on archives.
		ByteGazette_Customizer_Controls::add_number( 'archives_excerpt_length', 'archives', array(
			'label'       => esc_html__( 'Excerpt Length', 'bytegazette' ),
			'description' => esc_html__( 'Excerpt length (in Words) for Homepage & archive pages. Min is 0, max is 500. Set to 0 to disable.', 'bytegazette' ),
			'default'     => ByteGazette::ARCHIVES_EXCERPT_LENGTH,
			'min'         => 0,
			'max'         => 500,
		) );

		// Show featured image on archives.
		ByteGazette_Customizer_Controls::add_checkbox( 'archives_featured_image', 'archives', array(
			'label'   => esc_html__( 'Show Featured Image', 'bytegazette' ),
			'default' => ByteGazette::ARCHIVES_FEATURED_IMAGE,
		) );

		// Show post date on archives.
		ByteGazette_Customizer_Controls::add_checkbox( 'archives_date', 'archives', array(
			'label'   => esc_html__( 'Show Post Date', 'bytegazette' ),
			'default' => ByteGazette::ARCHIVES_DATE,
		) );

		// Show post author on archives.
		ByteGazette_Customizer_Controls::add_checkbox( 'archives_author', 'archives', array(
			'label'   => esc_html__( 'Show Post Author', 'bytegazette' ),
			'default' => ByteGazette::ARCHIVES_AUTHOR,
		) );

		// Show read more link on archives.
		ByteGazette_Customizer_Controls::add_checkbox( 'archives_more_link', 'archives', array(
			'label'   => esc_html__( 'Show Read More Link', 'bytegazette' ),
			'default' => ByteGazette::ARCHIVES_MORE_LINK,
		) );

		// Show category link on archives.
		ByteGazette_Customizer_Controls::add_checkbox( 'archives_category_link', 'archives', array(
			'label'   => esc_html__( 'Show Post Category Link', 'bytegazette' ),
			'default' => ByteGazette::ARCHIVES_CATEGORY_LINK,
		) );

		// Show comment count on archives.
		ByteGazette_Customizer_Controls::add_checkbox( 'archives_comment_count', 'archives', array(
			'label'   => esc_html__( 'Show Post Comment Count', 'bytegazette' ),
			'default' => ByteGazette::ARCHIVES_COMMENT_COUNT,
		) );
	}
}
