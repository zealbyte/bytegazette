<?php
/**
 * Byte Gazette functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
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

// Define default strings.
define( 'BYTEGAZETTE_THEME_VERSION', '1.0.0' );
define( 'BYTEGAZETTE_STRING_FEATURED_POSTS', __( 'Featured', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_ABOUT_AUTHOR', __( 'About the author', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_RELATED_POSTS', __( 'Related Posts', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_COMMENTS', __( 'Comments', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_REPLY', __( 'Add a Comment', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_ADD_REPLY', __( 'Add Comment', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_ARCHIVES_PREVIOUS', __( 'Previous', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_ARCHIVES_NEXT', __( 'Next', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_POST_PREVIOUS', __( 'Previous Post', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_POST_NEXT', __( 'Next Post', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_COMMENTS_PREVIOUS', __( 'Older Comments', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_COMMENTS_NEXT', __( 'Newer Comments', 'bytegazette' ) );
define( 'BYTEGAZETTE_STRING_COMMENTS_CLOSED', __( 'Comments are closed', 'bytegazette' ) );


// Default options and global methods.
require_once get_template_directory() . '/inc/class-bytegazette.php';

if ( ! function_exists( 'bytegazette_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bytegazette_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'bytegazette', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', apply_filters( 'bytegazette_custom_post_formats', array(
			'aside',
			'gallery',
			'image',
			'video',
			'audio',
		) ) );

		// Add support to change header image.
		add_theme_support( 'custom-header', apply_filters( 'bytegazette_custom_header_args', array(
			'wp-head-callback'   => 'bytegazette_header_style',
			//'default-image'      => get_template_directory_uri() . 'images/default-header.jpg',
			'default-image'      => '',
			'uploads'            => true,
			'default-text-color' => ByteGazette::HEADING_FG_COLOR,
			'width'              => 4000,
			'height'             => 100,
			'flex-width'         => true,
			'flex-height'        => true,
		) ) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'bytegazette_custom_background_args', array(
			'default-image' => '',
			'default-color' => ByteGazette::BODY_BG_COLOR,
		) ) );

		// Add support for core custom logo.
		add_theme_support( 'custom-logo', apply_filters( 'bytegazette_custom_logo_args', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) ) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( apply_filters( 'bytegazette_custom_nav_menus', array(
			'drawer' => esc_html__( 'Drawer Menu', 'bytegazette' ),
			'header' => esc_html__( 'Header Menu', 'bytegazette' ),
			'mobile' => esc_html__( 'Mobile Menu', 'bytegazette' ),
			'footer' => esc_html__( 'Footer Menu', 'bytegazette' ),
		) ) );

		// The avaliable Post Thumbnails sizes.
		foreach ( apply_filters( 'bytegazette_custom_image_sizes', array() ) as $size => $args ) {
			$size   = (string) $size;
			$width  = (int) ( isset( $args['width'] ) ? $args['width'] : 0 );
			$height = (int) ( isset( $args['height'] ) ? $args['height'] : 0 );
			$crop   = ( isset( $args['crop'] ) && $args['crop'] ) ? true : false;

			if ( $width && $height ) {
				add_image_size( $size, $width, $height, $crop );
			}
		}
	}
endif;
add_action( 'after_setup_theme', 'bytegazette_setup' );

/**
 * Supply array of custom image sizes for the theme.
 *
 * @param array $sizes The current sizes avaliable.
 * @return array The sizes to apply to the theme.
 */
function bytegazette_custom_image_sizes( array $sizes ) {

	if ( ! isset( $sizes['featured-image'] ) ) {
		$sizes['featured-image'] = array(
			'width'  => 800,
			'height' => 480,
			'crop'   => true,
		);
	}

	if ( ! isset( $sizes['featured-card'] ) ) {
		$sizes['featured-card'] = array(
			'width'  => 420,
			'height' => 240,
			'crop'   => true,
		);
	}

	if ( ! isset( $sizes['featured-list'] ) ) {
		$sizes['featured-list'] = array(
			'width'  => 240,
			'height' => 240,
			'crop'   => true,
		);
	}

	if ( ! isset( $sizes['slide'] ) ) {
		$sizes['slide'] = array(
			'width'  => 1280,
			'height' => 400,
			'crop'   => true,
		);
	}

	if ( ! isset( $sizes['jumbo'] ) ) {
		$sizes['large'] = array(
			'width'  => 1280,
			'height' => 1280,
			'crop'   => true,
		);
	}

	return $sizes;
}
add_filter( 'bytegazette_custom_image_sizes', 'bytegazette_custom_image_sizes' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bytegazette_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'bytegazette_content_width', 1024 );
}
add_action( 'after_setup_theme', 'bytegazette_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bytegazette_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bytegazette' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'The primary always visible sidebar.', 'bytegazette' ),
		'class'         => '',
		'before_widget' => '<section id="%1$s" class="widget sidebar-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="section-title widget-title uk-heading-line uk-text-bold"><span>',
		'after_title'   => '</span></h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Drawer', 'bytegazette' ),
		'id'            => 'drawer',
		'description'   => esc_html__( 'The widget area for the drawer menu.', 'bytegazette' ),
		'class'         => '',
		'before_widget' => '<div id="%1$s" class="widget drawer-widget %2$s">',
		'after_widget'  => '</div><hr>',
		'before_title'  => '<h4 class="section-title widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'bytegazette' ),
		'id'            => 'footer-columns',
		'description'   => esc_html__( 'Widget in the site info footer.', 'bytegazette' ),
		'class'         => '',
		'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="section-title widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'bytegazette_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bytegazette_scripts() {
	wp_enqueue_style( 'bytegazette-style', get_stylesheet_uri() );

	wp_enqueue_style(
		'bytegazette-style-bundle',
		bytegazette_get_option( 'url_uikit_style', get_template_directory_uri() . '/assets/css/bytegazette-site.bundle.css' )
	);

	wp_enqueue_script(
		'bytegazette-script-bundle',
		bytegazette_get_option( 'url_uikit_js', get_template_directory_uri() . '/assets/js/bytegazette-site.bundle.js' ),
		array(),
		'3.0.0-rc.20',
		true
	);

	//wp_enqueue_script( 'bytegazette-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	//wp_enqueue_script( 'bytegazette-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bytegazette_scripts' );

/**
 * Load the feature libraries for this theme.
 */
function bytegazette_load_theme_features() {
	$basepath = get_template_directory() . '/inc/';
	$features = array(
		// Implement customized options.
		'custom-header',

		// Functions which enhance the theme by hooking into WordPress.
		'template-functions',

		// Custom template tags for this theme.
		'template-tags',
	);

	$load_theme_features = apply_filters( 'bytegazette_load_theme_features', $features );

	foreach ( $load_theme_features as $feature ) {
		require_once $basepath . $feature . '.php';
	}
}
add_action( 'init', 'bytegazette_load_theme_features' );

/**
 * Load the necessary libraries for admin options.
 */
function bytegazette_load_theme_admin() {
	$basepath       = get_template_directory() . '/inc/admin/';
	$admin_features = array(
		// Customizer additions.
		'customizer',

		// Navigation menu options.
		'navmod',

		// Admin notifications.
		'notify',

		// Admin theme option pages.
		'options',

		// Admin theme option pages settings.
		'settings',
	);

	$load_admin_features = apply_filters( 'bytegazette_load_theme_admin', $admin_features );

	foreach ( $load_admin_features as $admin_feature ) {
		$admin_feature_class = 'ByteGazette_Admin_' . ucwords( $admin_feature );
		$admin_feature_init  = 'init_admin_' . $admin_feature;

		require_once $basepath . 'class-bytegazette-admin-' . $admin_feature . '.php';

		call_user_func( array( $admin_feature_class, $admin_feature_init ) );
	}
}

/**
 * Execute admin loader if we are admin.
 */
if ( is_admin() || is_customize_preview() ) {
	bytegazette_load_theme_admin();
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require_once get_template_directory() . '/inc/jetpack.php';
}

