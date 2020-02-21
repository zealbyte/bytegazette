<?php
/**
 * Byte Gazette theme options settings
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
 * Byte Gazette admin settings.
 */
class ByteGazette_Admin_Settings {

	/**
	 * Initialize this class, register necessary methods to actions.
	 */
	public static function init_admin_settings() {
		add_filter( 'bytegazette_options_pages', array( __CLASS__, 'add_options_pages' ), 10, 1 );
		add_action( 'bytegazette_options_pages_help', array( __CLASS__, 'add_options_pages_help' ), 10, 2 );
		add_action( 'bytegazette_load_options_page_front', array( __CLASS__, 'options_panels_front' ) );
		add_action( 'bytegazette_load_options_page_header', array( __CLASS__, 'options_panels_header' ) );
		add_action( 'bytegazette_load_options_page_footer', array( __CLASS__, 'options_panels_footer' ) );
		add_action( 'bytegazette_load_options_page_options', array( __CLASS__, 'options_panels_options' ) );
		add_action( 'bytegazette_load_options_page_language', array( __CLASS__, 'options_panels_language' ) );
		add_action( 'bytegazette_load_options_page_features', array( __CLASS__, 'options_panels_features' ) );
	}

	/**
	 * Add options pages tabs.
	 *
	 * @param array $pages The existing array of options pages tabs.
	 * @return array The new array of options pages.
	 */
	public static function add_options_pages( $pages ) {
		$pages = array_merge( $pages, array(
			'front'      => __( 'Home Page', 'bytegazette' ),
			'header'     => __( 'Header', 'bytegazette' ),
			'footer'     => __( 'Footer', 'bytegazette' ),
			'options'    => __( 'Options', 'bytegazette' ),
			'language'   => __( 'Language', 'bytegazette' ),
			'features'   => __( 'Features', 'bytegazette' ),
		) );

		return $pages;
	}

	/**
	 * The front page options to use panel.
	 */
	public function options_panels_front() {
		ByteGazette_Options_Controls::add_panel( 'front_page_slideshow', array(
			'title'       => __( 'Slideshow', 'bytegazette' ),
			'description' => __( 'Slideshow options on the home page.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_panel( 'front_page_featured', array(
			'title'       => __( 'Featured Slider', 'bytegazette' ),
			'description' => __( 'Options for the featured posts slider on the home page.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_input( 'slideshow_posts_tag', 'front_page_slideshow', array(
			'label'       => __( 'Slideshow Posts Tag', 'bytegazette' ),
			'description' => __( 'The tag to use to query for posts to include in the slideshow.', 'bytegazette' ),
			'default'     => ByteGazette::SLIDESHOW_POSTS_TAG,
		) );

		ByteGazette_Options_Controls::add_selection( 'slideshow_post_show', 'front_page_slideshow', array(
			'label'       => __( 'Show', 'bytegazette' ),
			'default'     => ByteGazette::SLIDESHOW_POST_SHOW,
			'help'        => __( 'on top of the featured image.', 'bytegazette' ),
			'choices'     => array(
				'title'   => __( 'Title', 'bytegazette' ),
				'excerpt' => __( 'Excerpt', 'bytegazette' ),
				'both'    => __( 'Title and Excerpt', 'bytegazette' ),
			),
		) );

		ByteGazette_Options_Controls::add_input( 'slideshow_posts_count', 'front_page_slideshow', array(
			'type'        => 'number',
			'class'       => 'small-text',
			'label'       => __( 'Max Slide Count', 'bytegazette' ),
			'help'        => __( 'posts', 'bytegazette' ),
			'default'     => ByteGazette::SLIDESHOW_POSTS_COUNT,
		) );

		ByteGazette_Options_Controls::add_input( 'slideshow_excerpt_length', 'front_page_slideshow', array(
			'type'        => 'number',
			'class'       => 'small-text',
			'label'       => __( 'Excerpt Length', 'bytegazette' ),
			'help'        => __( 'words', 'bytegazette' ),
			'default'     => ByteGazette::SLIDESHOW_EXCERPT_LENGTH,
		) );

		ByteGazette_Options_Controls::add_input( 'featured_posts_tag', 'front_page_featured', array(
			'label'       => __( 'Featured Posts Tag', 'bytegazette' ),
			'description' => __( 'The tag to use to query for posts to include in the featured posts slider.', 'bytegazette' ),
			'default'     => ByteGazette::FEATURED_POSTS_TAG,
		) );

		ByteGazette_Options_Controls::add_input( 'featured_posts_count', 'front_page_featured', array(
			'type'        => 'number',
			'class'       => 'small-text',
			'label'       => __( 'Max Post Count', 'bytegazette' ),
			'help'        => __( 'posts', 'bytegazette' ),
			'default'     => ByteGazette::FEATURED_POSTS_COUNT,
		) );

		ByteGazette_Options_Controls::add_input( 'featured_excerpt_length', 'front_page_featured', array(
			'type'        => 'number',
			'class'       => 'small-text',
			'label'       => __( 'Excerpt Length', 'bytegazette' ),
			'help'        => __( 'words', 'bytegazette' ),
			'default'     => ByteGazette::FEATURED_EXCERPT_LENGTH,
		) );
	}


	/**
	 * The header options to use panel.
	 */
	public function options_panels_header() {
		ByteGazette_Options_Controls::add_panel( 'site_header_layout', array(
			'title'       => __( 'Header Layout', 'bytegazette' ),
			'description' => __( 'The layout of elements in the site header.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_panel( 'header_text', array(
			'title'       => __( 'Header Text', 'bytegazette' ),
			'description' => __( 'Custom text to show in the site header.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_selection( 'site_header_layout_logo', 'site_header_layout', array(
			'label'       => 'Logo Position',
			'default'     => 'left',
			'choices'     => array(
				'left'   => __( 'Left', 'bytegazette' ),
				'center' => __( 'Center', 'bytegazette' ),
				'right'  => __( 'Right', 'bytegazette' ),
				'custom' => __( 'Custom', 'bytegazette' ),
			),
		) );

		ByteGazette_Options_Controls::add_selection( 'site_header_layout_title', 'site_header_layout', array(
			'label'       => 'Title Position',
			'default'     => 'left',
			'choices'     => array(
				'left'   => __( 'Left', 'bytegazette' ),
				'center' => __( 'Center', 'bytegazette' ),
				'right'  => __( 'Right', 'bytegazette' ),
				'custom' => __( 'Custom', 'bytegazette' ),
			),
		) );

		ByteGazette_Options_Controls::add_selection( 'site_header_layout_tagline', 'site_header_layout', array(
			'label'       => 'Tagline Position',
			'default'     => 'left',
			'choices'     => array(
				'left'   => __( 'Left', 'bytegazette' ),
				'center' => __( 'Center', 'bytegazette' ),
				'right'  => __( 'Right', 'bytegazette' ),
				'custom' => __( 'Custom', 'bytegazette' ),
			),
		) );

		ByteGazette_Options_Controls::add_selection( 'site_header_layout_text', 'site_header_layout', array(
			'label'       => 'Text Position',
			'default'     => 'left',
			'choices'     => array(
				'left'   => __( 'Left', 'bytegazette' ),
				'center' => __( 'Center', 'bytegazette' ),
				'right'  => __( 'Right', 'bytegazette' ),
				'custom' => __( 'Custom', 'bytegazette' ),
			),
		) );

		ByteGazette_Options_Controls::add_textbox( 'header_text', 'header_text', array(
			'label'       => esc_html__( 'Header Text', 'bytegazette' ),
			'description' => 'The extra text in the header. Allowed tags: <a>, <br>, <em>, <strong>, <i> <img>, and [shortcodes]',
			'default'     => '',
		) );
	}

	/**
	 * The footer options to use panel.
	 */
	public function options_panels_footer() {
		ByteGazette_Options_Controls::add_panel( 'site_footer_layout', array(
			'title'       => __( 'Footer Layout', 'bytegazette' ),
			'description' => __( 'The layout of elements in the site footer.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_panel( 'footer_text', array(
			'title'       => __( 'Footer Text', 'bytegazette' ),
			'description' => __( 'Custom text to show in the site footer.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_textbox( 'footer_upper_text', 'footer_text', array(
			'label'       => esc_html__( 'Upper Footer Text', 'bytegazette' ),
			'description' => 'The text in the upper part of the footer. Allowed tags: <a>, <br>, <em>, <strong>, <i> <img>, and [shortcodes]',
			'default'     => ByteGazette::get_powered_by_text(),
		) );

		ByteGazette_Options_Controls::add_textbox( 'footer_lower_text', 'footer_text', array(
			'label'       => esc_html__( 'Lower Footer Text', 'bytegazette' ),
			'description' => 'The text in the lower part of the footer. Allowed tags: <a>, <br>, <em>, <strong>, <i> <img>, and [shortcodes]',
			'default'     => ByteGazette::get_theme_author_text(),
		) );
	}

	/**
	 * The theme options panels.
	 */
	public static function options_panels_options() {
		ByteGazette_Options_Controls::add_panel( 'related_posts', array(
			'title'       => __( 'Related Posts', 'bytegazette' ),
			'description' => __( 'Settings for related posts.', 'bytegazette' ),
		), 'normal' );

		ByteGazette_Options_Controls::add_panel( 'default_featured_images', array(
			'title'       => __( 'Default Featured Images', 'bytegazette' ),
			'description' => __( 'Customize the default featured images per post format.', 'bytegazette' ),
		), 'normal' );

		ByteGazette_Options_Controls::add_selection( 'post_related_method', 'related_posts', array(
			'type'        => 'radio',
			'label'       => 'Related Post Method',
			'description' => 'How to determine the related posts.',
			'default'     => ByteGazette::POST_RELATED_METHOD,
			'choices'     => array(
				'cats' => __( 'Categories', 'bytegazette' ),
				'tags' => __( 'Tags', 'bytegazette' ),
			),
		) );

		ByteGazette_Options_Controls::add_input( 'post_related_count', 'related_posts', array(
			'type'        => 'number',
			'class'       => 'small-text',
			'label'       => 'Number of Posts',
			'description' => 'The number of related posts to show.',
			'default'     => ByteGazette::POST_RELATED_COUNT,
		) );
	}

	/**
	 * The language options panels.
	 */
	public static function options_panels_language() {
		ByteGazette_Options_Controls::add_panel( 'section_titles', array(
			'title'       => __( 'Section Titles', 'bytegazette' ),
			'description' => __( 'The titles of each section in the theme.', 'bytegazette' ),
		), 'normal' );

		ByteGazette_Options_Controls::add_panel( 'comments_titles', array(
			'title'       => __( 'Comments', 'bytegazette' ),
			'description' => __( 'Comments and reply language titles.', 'bytegazette' ),
		), 'normal' );

		ByteGazette_Options_Controls::add_panel( 'pagination_strings', array(
			'title'       => __( 'Pagination', 'bytegazette' ),
			'description' => __( 'Language to use for previous and next pagination elements.', 'bytegazette' ),
		), 'normal' );

		// Section Titles.
		ByteGazette_Options_Controls::add_input( 'title_featured_posts', 'section_titles', array(
			'label'   => BYTEGAZETTE_STRING_FEATURED_POSTS,
			'default' => BYTEGAZETTE_STRING_FEATURED_POSTS,
		) );

		ByteGazette_Options_Controls::add_input( 'title_about_author', 'section_titles', array(
			'label'   => BYTEGAZETTE_STRING_ABOUT_AUTHOR,
			'default' => BYTEGAZETTE_STRING_ABOUT_AUTHOR,
		) );

		ByteGazette_Options_Controls::add_input( 'title_related_posts', 'section_titles', array(
			'label'   => BYTEGAZETTE_STRING_RELATED_POSTS,
			'default' => BYTEGAZETTE_STRING_RELATED_POSTS,
		) );

		// Comments Titles.
		ByteGazette_Options_Controls::add_input( 'title_comments', 'comments_titles', array(
			'label'   => BYTEGAZETTE_STRING_COMMENTS,
			'default' => BYTEGAZETTE_STRING_COMMENTS,
		) );

		ByteGazette_Options_Controls::add_input( 'title_comments_closed', 'comments_titles', array(
			'label'   => BYTEGAZETTE_STRING_COMMENTS_CLOSED,
			'default' => BYTEGAZETTE_STRING_COMMENTS_CLOSED,
		) );

		ByteGazette_Options_Controls::add_input( 'title_reply', 'comments_titles', array(
			'label'   => BYTEGAZETTE_STRING_REPLY,
			'default' => BYTEGAZETTE_STRING_REPLY,
		) );

		ByteGazette_Options_Controls::add_input( 'action_add_reply', 'comments_titles', array(
			'label'   => BYTEGAZETTE_STRING_ADD_REPLY,
			'default' => BYTEGAZETTE_STRING_ADD_REPLY,
		) );

		// Pagination.
		ByteGazette_Options_Controls::add_input( 'pagination_archives_previous', 'pagination_strings', array(
			'label'   => BYTEGAZETTE_STRING_ARCHIVES_PREVIOUS,
			'default' => BYTEGAZETTE_STRING_ARCHIVES_PREVIOUS,
		) );

		ByteGazette_Options_Controls::add_input( 'pagination_archives_next', 'pagination_strings', array(
			'label'   => BYTEGAZETTE_STRING_ARCHIVES_NEXT,
			'default' => BYTEGAZETTE_STRING_ARCHIVES_NEXT,
		) );

		ByteGazette_Options_Controls::add_input( 'pagination_post_previous', 'pagination_strings', array(
			'label'   => BYTEGAZETTE_STRING_POST_PREVIOUS,
			'default' => BYTEGAZETTE_STRING_POST_PREVIOUS,
		) );

		ByteGazette_Options_Controls::add_input( 'pagination_post_next', 'pagination_strings', array(
			'label'   => BYTEGAZETTE_STRING_POST_NEXT,
			'default' => BYTEGAZETTE_STRING_POST_NEXT,
		) );

		ByteGazette_Options_Controls::add_input( 'pagination_comments_previous', 'pagination_strings', array(
			'label'   => BYTEGAZETTE_STRING_COMMENTS_PREVIOUS,
			'default' => BYTEGAZETTE_STRING_COMMENTS_PREVIOUS,
		) );

		ByteGazette_Options_Controls::add_input( 'pagination_comments_next', 'pagination_strings', array(
			'label'   => BYTEGAZETTE_STRING_COMMENTS_NEXT,
			'default' => BYTEGAZETTE_STRING_COMMENTS_NEXT,
		) );

	}

	/**
	 * The features options panels.
	 */
	public static function options_panels_features() {
		// Panels.
		ByteGazette_Options_Controls::add_panel( 'customizer_sections', array(
			'title'       => 'Customizer Sections',
			'description' => __( 'Select which customizer sections to show.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_panel( 'tracking_code', array(
			'title'       => __( 'Analytics Tracking Code', 'bytegazette' ),
			'description' => __( 'Paste all of your analytics or traching code here.', 'bytegazette' ),
		), 'normal' );

		ByteGazette_Options_Controls::add_panel( 'customizer_reset', array(
			'title'       => 'Reset Customizer Settings',
			'description' => __( 'Delete customizations made with the theme customizer.', 'bytegazette' ),
			'context'     => 'side',
		) );

		// Panel controls.
		ByteGazette_Options_Controls::add_selection( 'show_sections', 'customizer_sections', array(
			'type'        => 'checkbox',
			'label'       => 'Show Sections',
			'description' => 'The customizer sections to display.',
			'default'     => ByteGazette::get_theme_customizer_options(),
			'choices'     => array(
				'site'       => __( 'Theme Settings', 'bytegazette' ),
				'colors'     => __( 'Colors', 'bytegazette' ),
				'front'      => __( 'Homepage Settings', 'bytegazette' ),
				'navigation' => __( 'Navigation Bar', 'bytegazette' ),
				'footer'     => __( 'Footer Logo', 'bytegazette' ),
				'posts'      => __( 'Post Settings', 'bytegazette' ),
				'comments'   => __( 'Comment Settings', 'bytegazette' ),
				'archives'   => __( 'Archive Settings', 'bytegazette' ),
			),
		) );
	}

	/**
	 * Generate the option pages help tabs
	 *
	 * @param WP_Screen $current_screen The WordPress Screen to apply the help to.
	 * @param string    $current_page The current options page to apply help to.
	 * @return void
	 */
	public static function add_options_pages_help( $current_screen, $current_page ) {
		self::include_options_page_help_sidebar( $current_screen );
		self::include_options_page_help_home( $current_screen );
		self::include_options_page_help_header( $current_screen );
		self::include_options_page_help_design( $current_screen );
		self::include_options_page_help_features( $current_screen );
	}

	/**
	 * Add the overview help tab and content to the options pages.
	 *
	 * @param WP_Screen $screen The WordPress Screen to apply the help tab to.
	 * @return void
	 */
	protected static function include_options_page_help_home( WP_Screen $screen ) {
		$content  = '<p><strong>' . esc_html__( 'Overview', 'bytegazette' ) . '</strong></p>';
		$content .= '<p>' . esc_html__( 'PressDown provides the ability to create and edit posts and pages with markdown syntax. When enabled, the default post editor is replaced with the PressDown Editor.', 'bytegazette' ) . '</p>';
		$content .= '<p>' . esc_html__( 'You also have the option to use your favorite text editor for writing markdown. Depending on the text editor, your operating system, and hosting provider there are several methods to accomplish this.', 'bytegazette' ) . '</p>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_HOWTO ) . '" target="_blank">' . esc_html__( 'External Editor How to Guide', 'bytegazette' ) . '</a></p>';
		$content .= '<p><strong>' . esc_html__( 'Existing Posts', 'bytegazette' ) . '</strong></p>';
		$content .= '<p>' . esc_html__( 'Any post which was not created with markdown will not have the appropriate data associated to be effectively edited with PressDown. Please read the "Integration Guide" for more information on how you choose to work with existing posts.', 'bytegazette' ) . '</p>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_INTEGRATION ) . '" target="_blank">' . esc_html__( 'PressDown Integration Guide', 'bytegazette' ) . '</a></p>';

		$screen->add_help_tab( array(
			'id'      => 'bytegazette-help-home',
			'title'   => __( 'Home Page', 'bytegazette' ),
			'content' => $content,
		) );
	}

	/**
	 * Add the features help tab and content to the options pages.
	 *
	 * @param WP_Screen $screen The WordPress Screen to apply the help tab to.
	 * @return void
	 */
	protected static function include_options_page_help_header( WP_Screen $screen ) {
		$content  = '<p><strong>' . esc_html__( 'Features', 'bytegazette' ) . '</strong></p>';
		$content .= '<p><strong>' . esc_html__( 'Custom Styles', 'bytegazette' ) . '</strong> - ' . esc_html__( 'Define the css classes and styles to be applied to the rendered output of the markdown.', 'bytegazette' ) . '</p>';
		$content .= '<p><strong>' . esc_html__( 'Meta Data', 'bytegazette' ) . '</strong> - ' . esc_html__( 'The mapping between the YAML metadata in the markdown and the post data fields.', 'bytegazette' ) . '</p>';

		$screen->add_help_tab( array(
			'id'      => 'bytegazette-help-header',
			'title'   => __( 'Header &amp; Footer', 'bytegazette' ),
			'content' => $content,
		) );
	}

	/**
	 * Add the configuration help tab and content to the options pages.
	 *
	 * @param WP_Screen $screen The WordPress Screen to apply the help tab to.
	 * @return void
	 */
	protected static function include_options_page_help_design( WP_Screen $screen ) {
		$content  = '<p><strong>' . esc_html__( 'Configuration', 'bytegazette' ) . '</strong></p>';
		$content .= '<p><strong>' . esc_html__( 'Post Types', 'bytegazette' ) . '</strong> - ' . esc_html__( 'You can enable/disable the PressDown editor for specific post types. This may or may not have an effect on post types created by other plugins.', 'bytegazette' ) . '</p>';
		$content .= '<p><strong>' . esc_html__( 'Existing Posts', 'bytegazette' ) . '</strong> - ' . esc_html__( 'How do you want to handle the PressDown editor for existing posts which do not have markdown data.', 'bytegazette' ) . '</p>';

		$screen->add_help_tab( array(
			'id'      => 'bytegazette-help-design',
			'title'   => __( 'Design', 'bytegazette' ),
			'content' => $content,
		) );
	}

	/**
	 * Add the configuration help tab and content to the options pages.
	 *
	 * @param WP_Screen $screen The WordPress Screen to apply the help tab to.
	 * @return void
	 */
	protected static function include_options_page_help_features( WP_Screen $screen ) {
		$content  = '<p><strong>' . esc_html__( 'Overview', 'bytegazette' ) . '</strong></p>';
		$content .= '<p>' . esc_html__( 'PressDown provides the ability to create and edit posts and pages with markdown syntax. When enabled, the default post editor is replaced with the PressDown Editor.', 'bytegazette' ) . '</p>';
		$content .= '<p>' . esc_html__( 'You also have the option to use your favorite text editor for writing markdown. Depending on the text editor, your operating system, and hosting provider there are several methods to accomplish this.', 'bytegazette' ) . '</p>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_HOWTO ) . '" target="_blank">' . esc_html__( 'External Editor How to Guide', 'bytegazette' ) . '</a></p>';
		$content .= '<p><strong>' . esc_html__( 'Existing Posts', 'bytegazette' ) . '</strong></p>';
		$content .= '<p>' . esc_html__( 'Any post which was not created with markdown will not have the appropriate data associated to be effectively edited with PressDown. Please read the "Integration Guide" for more information on how you choose to work with existing posts.', 'bytegazette' ) . '</p>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_INTEGRATION ) . '" target="_blank">' . esc_html__( 'PressDown Integration Guide', 'bytegazette' ) . '</a></p>';

		$screen->add_help_tab( array(
			'id'      => 'bytegazette-help-features',
			'title'   => __( 'Features', 'bytegazette' ),
			'content' => $content,
		) );
	}

	/**
	 * Add links to external help resources into the help sidebar.
	 *
	 * @param WP_Screen $screen The WordPress Screen to apply the help tab to.
	 * @return void
	 */
	protected static function include_options_page_help_sidebar( WP_Screen $screen ) {
		$content  = '<p><strong>' . esc_html__( 'For more information:', 'bytegazette' ) . '</strong></p>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_ABOUT ) . '" target="_blank">' . esc_html__( 'About', 'bytegazette' ) . '</a></p>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_COMMUNITY ) . '" target="_blank">' . esc_html__( 'Community Forum', 'bytegazette' ) . '</a></p>';
		$content .= '<hr>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_HOWTO ) . '" target="_blank">' . esc_html__( 'Byte Gazette Customization Guide', 'bytegazette' ) . '</a></p>';

		$screen->set_help_sidebar( $content );
	}

}
