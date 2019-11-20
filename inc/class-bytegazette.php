<?php
/**
 * The Byte Gazette theme defaults
 *
 * @package The_Byte_Gazette
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
 * Defaults for The Byte Gazette.
 */
class ByteGazette {
	// Config keys.
	const OPTIONS_SETTINGS = 'bytegazette_options';
	const NONCE            = 'bytegazette-entropy-nonce';

	// Theme resources.
	const URL_AUTHOR                  = 'https://zealbyte.org/';
	const URL_ABOUT                   = 'https://zealbyte.org/projects/bytegazette/about';
	const URL_BYTEGAZETTE_GUIDE       = 'https://zealbyte.org/projects/bytegazette/guide';
	const URL_BYTEGAZETTE_FAQ         = 'https://zealbyte.org/projects/bytegazette/faq';
	const URL_BYTEGAZETTE_HOW_TO      = 'https://zealbyte.org/projects/bytegazette/external-editor';
	const URL_FEEDBACK                = 'https://zealbyte.org/projects/bytegazette/external-editor';
	const URL_SUPPORT                 = 'https://zealbyte.org/projects/bytegazette/external-editor';
	const URL_BYTEGAZETTE_INTEGRATION = 'https://zealbyte.org/projects/bytegazette/integration';
	const URL_DEFAULT_UIKIT_JS        = 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.20/js/uikit.min.js';
	const URL_DEFAULT_UIKIT_ICONS     = 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.20/js/uikit-icons.min.js';
	const URL_DEFAULT_UIKIT_STYLE     = 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.20/css/uikit.min.css';

	// The default theme options.
	const DEFAULT_DATE_FORMAT              = 'default';
	const DEFAULT_SIDEBAR_LAYOUT           = 'right';
	const DEFAULT_SIDEBAR_WIDTH            = '1_3';
	const DEFAULT_CONTENT_LAYOUT           = 'default';
	const DEFAULT_ARCHIVE_DISPLAY          = 'list';
	const DEFAULT_HOME_DISPLAY             = 'grid';
	const DEFAULT_FEATURED_POSTS_TAG       = 'featured';
	const DEFAULT_FEATURED_POSTS_COUNT     = 10;
	const DEFAULT_FEATURED_EXCERPT_LENGTH  = 12;
	const DEFAULT_SLIDESHOW_POSTS_TAG      = 'showit';
	const DEFAULT_SLIDESHOW_POSTS_COUNT    = 4;
	const DEFAULT_SLIDESHOW_EXCERPT_LENGTH = 21;

	// The default home page options.
	const DEFAULT_HOME_PAGE_BANNER = '';

	// The default header options.
	const DEFAULT_HEADER_BG_COLOR     = '#ffffff';
	const DEFAULT_HEADER_FG_CLASS     = 'uk-dark';
	const DEFAULT_HEADER_NAV_BG_COLOR = '#512DA8';
	const DEFAULT_HEADER_NAV_FG_CLASS = 'uk-light';

	// The default footer options.
	const DEFAULT_FOOTER_UPPER_BG_COLOR = '#455A64';
	const DEFAULT_FOOTER_LOWER_BG_COLOR = '#263238';
	const DEFAULT_FOOTER_FG_CLASS       = 'uk-light';
	const DEFAULT_FOOTER_LOGO           = '';

	// The default post options.
	const DEFAULT_POST_BREADCRUMBS    = 1;
	const DEFAULT_POST_META           = 1;
	const DEFAULT_POST_RELATED        = 1;
	const DEFAULT_POST_RELATED_COUNT  = 4;
	const DEFAULT_POST_RELATED_MAX    = 20;
	const DEFAULT_POST_RELATED_METHOD = 'tags';
	const DEFAULT_POST_NEXT_PREV      = 1;
	const DEFAULT_POST_AUTHOR_BOX     = 1;

	// The default archive options.
	const DEFAULT_ARCHIVES_META           = 1;
	const DEFAULT_ARCHIVES_EXCERPT_LENGTH = 30;

	// The default theme background options.
	const DEFAULT_BG_COLOR           = '#f7f7f7';
	const DEFAULT_BACKGROUND_OPTION  = 'none';
	const DEFAULT_BACKGROUND_PATTERN = '';
	const DEFAULT_BG_REPEAT          = 'no-repeat';
	const DEFAULT_BG_SIZE            = 'cover';
	const DEFAULT_BG_ATTACHMENT      = 'scroll';
	const DEFAULT_BG_POSITION        = 'center center';

	/**
	 * Determine if the theme is considered "configured" or not.
	 *
	 * @return bool
	 */
	public static function is_configured() {
		return true;
	}

	/**
	 * Check the theme directory to determine if we are using a production release
	 * of the theme.
	 */
	public static function admin_theme_check() {
		$manifest_path = get_template_directory() . '/manifest.json';
		$filelist_path = get_template_directory() . '/filelist.json';

		if ( file_exists( $manifest_path ) && file_exists( $filelist_path ) ) {
			// Show notice if we notice we are running the theme from the git source.
			ByteGazette_Admin_Notify::add_warn(
				__( 'The Byte Gazette theme is not production ready', 'bytegazette' ),
				__( 'The Byte Gazette theme is currencly running from the source.', 'bytegazette' )
			);
		} elseif ( file_exists( $manifest_path ) ) {
			// Show notice if we notice we are running the theme from a source build.
			ByteGazette_Admin_Notify::add_warn(
				__( 'The Byte Gazette theme is not production ready', 'bytegazette' ),
				__( 'Theme running from the build.', 'bytegazette' )
			);
		} elseif ( file_exists( $filelist_path ) ) {
			// Show notice if we need to build the sources.
			ByteGazette_Admin_Notify::add_error(
				__( 'The Byte Gazette theme is not production ready', 'bytegazette' ),
				__( 'The source build process needs to run.', 'bytegazette' )
			);
		}
	}

	/**
	 * Return the powered by text.
	 */
	public static function get_powered_by_text() {
		return __( 'Proudly powered by', 'bytegazette' ) . ' <a href="http://wordpress.org/">WordPress</a>.';
	}

	/**
	 * Return the theme author text.
	 */
	public static function get_theme_author_text() {
		return __( 'Byte Gazette theme by', 'bytegazette' ) . ' <a href="' . ByteGazette::URL_AUTHOR . '">ZealByte</a>.';
	}

	/**
	 * Get the list of default customizer options
	 */
	public static function get_theme_customizer_options() {
		return array(
			'site'       => true,
			'homepage'   => true,
			'header'     => true,
			'footer'     => true,
			'posts'      => true,
			'archives'   => true,
			'background' => true,
		);
	}

	/**
	 * Get the list of default social icons.
	 */
	public static function get_social_icons_list() {
		$contact = array(
			'rss' => array(
				'label' => esc_html__( 'RSS', 'bytegazette' ),
				'icon'  => 'rss',
			),
			'email' => array(
				'label' => esc_html__( 'Email', 'bytegazette' ),
				'icon'  => 'mail',
			),
		);

		$social = array(
			'500px' => array(
				'label' => esc_html__( '500px', 'bytegazette' ),
				'icon'  => '500px',
				'url'   => 'https://500px.com',
			),
			'behance' => array(
				'label' => esc_html__( 'Behance', 'bytegazette' ),
				'icon'  => 'behance',
				'url'   => 'https://',
			),
			'dribbble' => array(
				'label' => esc_html__( 'Dribbble', 'bytegazette' ),
				'icon'  => 'dribbble',
				'url'   => 'https://',
			),
			'facebook' => array(
				'label' => esc_html__( 'Facebook', 'bytegazette' ),
				'icon'  => 'facebook',
				'url'   => 'https://',
			),
			'flickr' => array(
				'label' => esc_html__( 'Flickr', 'bytegazette' ),
				'icon'  => 'flickr',
				'url'   => 'https://',
			),
			'foursquare' => array(
				'label' => esc_html__( 'Foursquare', 'bytegazette' ),
				'icon'  => 'foursquare',
				'url'   => 'https://',
			),
			'github' => array(
				'label' => esc_html__( 'GitHub', 'bytegazette' ),
				'icon'  => 'github-alt',
				'url'   => 'https://',
			),
			'gitter' => array(
				'label' => esc_html__( 'Gitter', 'bytegazette' ),
				'icon'  => 'gitter',
				'url'   => 'https://',
			),
			'google_plus' => array(
				'label' => esc_html__( 'Google+', 'bytegazette' ),
				'icon'  => 'google-plus',
				'url'   => 'https://',
			),
			'instagram' => array(
				'label' => esc_html__( 'Instagram', 'bytegazette' ),
				'icon'  => 'instagram',
				'url'   => 'https://',
			),
			'linkedin' => array(
				'label' => esc_html__( 'LinkedIn', 'bytegazette' ),
				'icon'  => 'linkedin',
				'url'   => 'https://',
			),
			'pinterest' => array(
				'label' => esc_html__( 'Pinterest', 'bytegazette' ),
				'icon'  => 'pinterest',
				'url'   => 'https://',
			),
			'soundcloud' => array(
				'label' => esc_html__( 'Soundcloud', 'bytegazette' ),
				'icon'  => 'soundcloud',
				'url'   => 'https://',
			),
			'tripadvisor' => array(
				'label' => esc_html__( 'TripAdvisor', 'bytegazette' ),
				'icon'  => 'tripadvisor',
				'url'   => 'https://',
			),
			'tumblr' => array(
				'label' => esc_html__( 'Tumblr', 'bytegazette' ),
				'icon'  => 'tumblr',
				'url'   => 'https://',
			),
			'twitter' => array(
				'label' => esc_html__( 'Twitter', 'bytegazette' ),
				'icon'  => 'twitter',
				'url'   => 'https://',
				'share' => true,
				'attrs' => array(
					'href'          => 'https://twitter.com/intent/tweet',
					'data-size'     => 'large',
					'data-text'     => 'custom share text',
					'data-url'      => '{{url}}',
					'data-hashtags' => 'example,demo',
					'data-via'      => 'twitterdev',
					'data-related'  => 'twitterapi,twitter',
				),
			),
			'vimeo' => array(
				'label' => esc_html__( 'Vimeo', 'bytegazette' ),
				'icon'  => 'vimeo',
				'url'   => 'https://',
			),
			'yelp' => array(
				'label' => esc_html__( 'Yelp', 'bytegazette' ),
				'icon'  => 'yelp',
				'url'   => 'https://',
			),
			'youtube' => array(
				'label' => esc_html__( 'YouTube', 'bytegazette' ),
				'icon'  => 'youtube',
				'url'   => 'https://',
			),
		);

		return apply_filters( 'bytegazette_get_social_icons_list', array_merge( $contact, $social ) );
	}
}
