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
		add_action( 'bytegazette_load_options_page_social', array( __CLASS__, 'options_panels_social' ) );
		add_action( 'bytegazette_load_options_page_design', array( __CLASS__, 'options_panels_design' ) );
		add_action( 'bytegazette_load_options_page_features', array( __CLASS__, 'options_panels_features' ) );
		add_action( 'bytegazette_load_options_page_customizer', array( __CLASS__, 'options_panels_customizer' ) );
	}

	/**
	 * Add options pages tabs.
	 *
	 * @param array $pages The existing array of options pages tabs.
	 * @return array The new array of options pages.
	 */
	public static function add_options_pages( $pages ) {
		$pages = array_merge( $pages, array(
			'homepage'   => __( 'Home Page', 'bytegazette' ),
			'social'     => __( 'Social', 'bytegazette' ),
			'design'     => __( 'Design', 'bytegazette' ),
			'features'   => __( 'Features', 'bytegazette' ),
			'customizer' => __( 'Customizer Options', 'bytegazette' ),
		) );

		return $pages;
	}

	/**
	 * The social icons to use panel.
	 */
	public function options_panels_social() {
		ByteGazette_Options_Controls::add_panel( 'social_accounts_header', array(
			'title'       => __( 'Social Account icon in Header', 'bytegazette' ),
			'description' => __( 'Add the social icon links to your social network account home pages.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_panel( 'social_accounts_footer', array(
			'title'       => __( 'Social Account Icons in Footer', 'bytegazette' ),
			'description' => __( 'Add the social icon links to your social network account home pages.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_panel( 'social_accounts_widget', array(
			'title'       => __( 'Social Account Icons in Widget', 'bytegazette' ),
			'description' => __( 'Add the social icon links to your social network account home pages.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_panel( 'social_share', array(
			'title'       => 'Share Icons',
			'description' => 'Add icons for readers to share content on their social network of choice.',
		) );

		ByteGazette_Options_Controls::add_checkboxes( 'noa', 'social_accounts_footer', array(
			'label'       => 'Noa',
			'description' => 'not on agatha!',
			'default'     => array(
				'abc' => false,
				'def' => true,
				'ghi' => true,
			),
			'choices'     => array(
				'abc' => 'ABC',
				'def' => 'DEF',
				'ghi' => 'GHI',
			),
		) );
	}

	/**
	 * The graphics options panels.
	 */
	public static function options_panels_design() {
		ByteGazette_Options_Controls::add_panel( 'post_format_icons', array(
			'title'       => __( 'Post Format Icons', 'bytegazette' ),
			'description' => __( 'Customize the icons for specific post formats.', 'bytegazette' ),
		), 'normal' );

		ByteGazette_Options_Controls::add_panel( 'default_featured_images', array(
			'title'       => __( 'Default Featured Images', 'bytegazette' ),
			'description' => __( 'Customize the default featured images per post format.', 'bytegazette' ),
		), 'normal' );
	}

	/**
	 * The features options panels.
	 */
	public static function options_panels_features() {
		ByteGazette_Options_Controls::add_panel( 'featured_posts', array(
			'title'       => __( 'Featured Posts', 'bytegazette' ),
			'description' => __( 'Settings for featured posts.', 'bytegazette' ),
		), 'normal' );

		ByteGazette_Options_Controls::add_panel( 'tracking_code', array(
			'title'       => __( 'Analytics Tracking Code', 'bytegazette' ),
			'description' => __( 'Paste all of your analytics or traching code here.', 'bytegazette' ),
		), 'normal' );

		ByteGazette_Options_Controls::add_panel( 'cdn', array(
			'title'       => __( 'CDN Paths', 'bytegazette' ),
			'description' => __( 'Remote locations you wish to use for scripts and styles.', 'bytegazette' ),
		), 'low' );
	}

	/**
	 * The customizer sections panel.
	 */
	public static function options_panels_customizer() {
		ByteGazette_Options_Controls::add_panel( 'customizer_sections', array(
			'title'       => 'Customizer Sections',
			'description' => __( 'Select which customizer sections to show.', 'bytegazette' ),
		) );

		ByteGazette_Options_Controls::add_checkboxes( 'show_sections', 'customizer_sections', array(
			'label'       => 'Show Sections',
			'description' => 'The customizer sections to display.',
			'default'     => ByteGazette::get_theme_customizer_options(),
			'choices'     => array(
				'site'       => __( 'Site', 'bytegazette' ),
				'homepage'   => __( 'Homepage', 'bytegazette' ),
				'header'     => __( 'Header', 'bytegazette' ),
				'footer'     => __( 'Footer', 'bytegazette' ),
				'posts'      => __( 'Posts', 'bytegazette' ),
				'archives'   => __( 'Archives', 'bytegazette' ),
				'background' => __( 'Background', 'bytegazette' ),
			),
		) );

		ByteGazette_Options_Controls::add_panel( 'customizer_reset', array(
			'title'       => 'Reset Customizer Settings',
			'description' => __( 'Delete customizations made with the theme customizer.', 'bytegazette' ),
			'context'     => 'side',
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
		self::include_options_page_help_overview( $current_screen );
		self::include_options_page_help_features( $current_screen );
		self::include_options_page_help_configuration( $current_screen );
	}

	/**
	 * Add the overview help tab and content to the options pages.
	 *
	 * @param WP_Screen $screen The WordPress Screen to apply the help tab to.
	 * @return void
	 */
	protected static function include_options_page_help_overview( WP_Screen $screen ) {
		$content  = '<p><strong>' . esc_html__( 'Overview', 'bytegazette' ) . '</strong></p>';
		$content .= '<p>' . esc_html__( 'PressDown provides the ability to create and edit posts and pages with markdown syntax. When enabled, the default post editor is replaced with the PressDown Editor.', 'bytegazette' ) . '</p>';
		$content .= '<p>' . esc_html__( 'You also have the option to use your favorite text editor for writing markdown. Depending on the text editor, your operating system, and hosting provider there are several methods to accomplish this.', 'bytegazette' ) . '</p>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_BYTEGAZETTE_HOW_TO ) . '" target="_blank">' . esc_html__( 'External Editor How to Guide', 'bytegazette' ) . '</a></p>';
		$content .= '<p><strong>' . esc_html__( 'Existing Posts', 'bytegazette' ) . '</strong></p>';
		$content .= '<p>' . esc_html__( 'Any post which was not created with markdown will not have the appropriate data associated to be effectively edited with PressDown. Please read the "Integration Guide" for more information on how you choose to work with existing posts.', 'bytegazette' ) . '</p>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_BYTEGAZETTE_INTEGRATION ) . '" target="_blank">' . esc_html__( 'PressDown Integration Guide', 'bytegazette' ) . '</a></p>';

		$screen->add_help_tab( array(
			'id'      => 'bytegazette-overview',
			'title'   => __( 'Overview', 'bytegazette' ),
			'content' => $content,
		) );
	}

	/**
	 * Add the features help tab and content to the options pages.
	 *
	 * @param WP_Screen $screen The WordPress Screen to apply the help tab to.
	 * @return void
	 */
	protected static function include_options_page_help_features( WP_Screen $screen ) {
		$content  = '<p><strong>' . esc_html__( 'Features', 'bytegazette' ) . '</strong></p>';
		$content .= '<p><strong>' . esc_html__( 'Custom Styles', 'bytegazette' ) . '</strong> - ' . esc_html__( 'Define the css classes and styles to be applied to the rendered output of the markdown.', 'bytegazette' ) . '</p>';
		$content .= '<p><strong>' . esc_html__( 'Meta Data', 'bytegazette' ) . '</strong> - ' . esc_html__( 'The mapping between the YAML metadata in the markdown and the post data fields.', 'bytegazette' ) . '</p>';

		$screen->add_help_tab( array(
			'id'      => 'bytegazette-features',
			'title'   => __( 'Features', 'bytegazette' ),
			'content' => $content,
		) );
	}

	/**
	 * Add the configuration help tab and content to the options pages.
	 *
	 * @param WP_Screen $screen The WordPress Screen to apply the help tab to.
	 * @return void
	 */
	protected static function include_options_page_help_configuration( WP_Screen $screen ) {
		$content  = '<p><strong>' . esc_html__( 'Configuration', 'bytegazette' ) . '</strong></p>';
		$content .= '<p><strong>' . esc_html__( 'Post Types', 'bytegazette' ) . '</strong> - ' . esc_html__( 'You can enable/disable the PressDown editor for specific post types. This may or may not have an effect on post types created by other plugins.', 'bytegazette' ) . '</p>';
		$content .= '<p><strong>' . esc_html__( 'Existing Posts', 'bytegazette' ) . '</strong> - ' . esc_html__( 'How do you want to handle the PressDown editor for existing posts which do not have markdown data.', 'bytegazette' ) . '</p>';

		$screen->add_help_tab( array(
			'id'      => 'bytegazette-configuration',
			'title'   => __( 'Configuration', 'bytegazette' ),
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
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_BYTEGAZETTE_GUIDE ) . '" target="_blank">' . esc_html__( 'Markdown Reference', 'bytegazette' ) . '</a></p>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_BYTEGAZETTE_GUIDE ) . '" target="_blank">' . esc_html__( 'Byte Gazette Guide', 'bytegazette' ) . '</a></p>';
		$content .= '<p><a href="' . esc_url( ByteGazette::URL_BYTEGAZETTE_FAQ ) . '" target="_blank">' . esc_html__( 'Byte Gazette FAQ', 'bytegazette' ) . '</a></p>';

		$screen->set_help_sidebar( $content );
	}

}
