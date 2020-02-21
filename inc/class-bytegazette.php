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
	const URL_AUTHOR      = 'https://zealbyte.org/';
	const URL_ABOUT       = 'https://zealbyte.org/projects/bytegazette/about';
	const URL_COMMUNITY   = 'https://zealbyte.org/community/bytegazette';
	const URL_HOWTO       = 'https://zealbyte.org/guides/bytegazette';
	const URL_FEEDBACK    = 'https://wordpress.org/support/theme/bytegazette/reviews/';
	const URL_INTEGRATION = 'https://zealbyte.org/guides/bytegazette/integration';

	// Default colors.
	const BODY_FG_COLOR                       = '#666666';
	const BODY_BG_COLOR                       = '#ffffff';
	const LINK_FG_COLOR                       = '#1e87f0';
	const HEADING_FG_COLOR                    = '#333333';
	const EMPHASIS_FG_COLOR                   = '#f0506e';
	const BORDER_COLOR                        = '#dddddd';
	const MUTE_FG_COLOR                       = '#999999';
	const EVEN_BG_COLOR                       = '#ffffff';
	const ODD_BG_COLOR                        = '#fafafa';
	const HEADER_BG_COLOR                     = 'transparent';
	const HEADER_LINK_FG_COLOR                = '#0022ff';
	const HEADER_TITLE_FG_COLOR               = '#234687';
	const HEADER_NAV_FG_COLOR                 = '#333333';
	const HEADER_NAV_BG_COLOR                 = '#512DA8';
	const HEADER_NAV_LINK_FG_COLOR            = '#ffffff';
	const HEADER_NAV_ITEM_BG_COLOR            = '#512DA8';
	const HEADER_NAV_ITEM_FG_COLOR            = '#ffffff';
	const HEADER_NAV_ITEM_CURRENT_BG_COLOR    = '#512DA8';
	const HEADER_NAV_ITEM_CURRENT_FG_COLOR    = '#090909';
	const HEADER_SUBNAV_BG_COLOR              = '#ffffff';
	const HEADER_SUBNAV_ITEM_BG_COLOR         = '#ffffff';
	const HEADER_SUBNAV_ITEM_FG_COLOR         = '#333333';
	const HEADER_SUBNAV_ITEM_CURRENT_BG_COLOR = '#ffffff';
	const HEADER_SUBNAV_ITEM_CURRENT_FG_COLOR = '#999999';
	const FOOTER_FG_COLOR                     = '#cccccc';
	const FOOTER_BG_COLOR                     = '#455A64';
	const FOOTER_HEADING_FG_COLOR             = '#ffffff';
	const FOOTER_LINK_FG_COLOR                = '#ffffff';
	const FOOTER_NAV_FG_COLOR                 = '#cccccc';
	const FOOTER_NAV_BG_COLOR                 = '#263238';
	const FOOTER_NAV_LINK_FG_COLOR            = '#ffffff';
	const FOOTER_NAV_HEADING_FG_COLOR         = '#ffffff';

	// The default navigation bar options.
	const NAV_SHOW_SEARCH    = 1;
	const NAV_STICKY_SETTING = 'sticktop';

	// The default theme options.
	const DATE_FORMAT    = 'default';
	const SIDEBAR_WIDTH  = '1_3';
	const SIDEBAR_LAYOUT = 'right';
	const CONTENT_LAYOUT = 'grid';

	// Featured slider options.
	const FEATURED_POSTS_TAG      = 'featured';
	const FEATURED_POSTS_COUNT    = 10;
	const FEATURED_EXCERPT_LENGTH = 12;

	// Slideshow options.
	const SLIDESHOW_POSTS_TAG      = 'showit';
	const SLIDESHOW_POST_SHOW      = 'both';
	const SLIDESHOW_POSTS_COUNT    = 4;
	const SLIDESHOW_EXCERPT_LENGTH = 21;

	// The default alternate logos.
	const NAVIGATION_ICON_LOGO = '';
	const FOOTER_LOGO          = '';

	// The default post options.
	const POST_FEATURED_IMAGE = 1;
	const POST_DATE           = 1;
	const POST_AUTHOR         = 1;
	const POST_TAGS           = 0;
	const POST_CATEGORIES     = 0;
	const POST_AUTHOR_BOX     = 1;
	const POST_NEXT_PREV      = 1;
	const POST_RELATED        = 0;
	const POST_RELATED_COUNT  = 6;
	const POST_RELATED_MAX    = 20;
	const POST_RELATED_METHOD = 'tags';

	// The default comment options.
	const COMMENT_PAGINATION  = 'both';
	const COMMENT_LIST_TAG    = 'ol';
	const COMMENT_AVATAR_SIZE = '48';
	const COMMENT_SHORT_PING  = true;

	// The default archive options.
	const ARCHIVES_FEATURED_IMAGE = 1;
	const ARCHIVES_AUTHOR         = 1;
	const ARCHIVES_DATE           = 1;
	const ARCHIVES_MORE_LINK      = 1;
	const ARCHIVES_CATEGORY_LINK  = 1;
	const ARCHIVES_COMMENT_COUNT  = 1;
	const ARCHIVES_EXCERPT_LENGTH = 30;

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
		return __( 'Byte Gazette theme by ', 'bytegazette' ) . ' <a href="' . ByteGazette::URL_AUTHOR . '">ZealByte</a>.';
	}

	/**
	 * Get the list of default customizer options
	 */
	public static function get_theme_customizer_options() {
		return array(
			'site'       => true,
			'colors'     => true,
			'front'      => true,
			'navigation' => true,
			'footer'     => true,
			'posts'      => true,
			'comments'   => true,
			'archives'   => true,
		);
	}

}
