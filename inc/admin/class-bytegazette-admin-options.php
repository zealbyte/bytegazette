<?php
/**
 * Byte Gazette theme options pages
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
 * Byte Gazette Admin Options Pages
 */
class ByteGazette_Admin_Options {
	/**
	 * Options pages.
	 *
	 * @var array
	 */
	protected static $pages = array();

	/**
	 * The screen id.
	 *
	 * @var string
	 */
	protected static $hook_suffix;

	/**
	 * Initialize this class, register necessary methods to actions.
	 */
	public static function init_admin_options() {
		require_once get_template_directory() . '/inc/options/class-bytegazette-options-controls.php';

		// Add the theme options link in options menu.
		add_action( 'admin_menu', array( __CLASS__, 'menu_theme_options_link' ), 10 );

		// Register action to provide content to the option page.
		add_action( 'bytegazette_theme_options_page', array( __CLASS__, 'do_options_page' ), 10, 1 );
	}

	/**
	 * Add a menu item to the "Apperance" menu for our custom options pages.
	 */
	public static function menu_theme_options_link() {
		$hook_suffix = add_theme_page(
			__( 'Theme Options', 'bytegazette' ),
			__( 'Theme Options', 'bytegazette' ),
			'edit_theme_options',
			'bytegazette_theme_options',
			array( __CLASS__, 'do_options_pages' )
		);

		if ( $hook_suffix ) {
			self::$hook_suffix = $hook_suffix;

			add_action( 'admin_init', array( __CLASS__, 'register_options_scripts' ) );
			add_action( 'admin_init', array( __CLASS__, 'register_options_styles' ) );

			// Register the options setting.
			register_setting( $hook_suffix, ByteGazette::OPTIONS_SETTINGS, array(
				'sanitize_callback' => array( __CLASS__, 'sanitize_save_settings' ),
			) );

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
			add_action( 'bytegazette_options_page_init', array( __CLASS__, 'fx_smb_reset_settings' ) );
			add_action( "load-$hook_suffix", array( 'ByteGazette', 'admin_theme_check' ) );
			add_action( "load-$hook_suffix", array( __CLASS__, 'load_options_page' ) );
		}
	}

	/**
	 * Generate the fill URL path to an options page.
	 *
	 * @param string $page The page name to generate the URL for.
	 * @return string the full URL to the options page.
	 */
	public static function generate_url( $page = null ) {
		$args = array(
			'page' => 'bytegazette_theme_options',
		);

		if ( $page ) {
			$args['view'] = $page;
		}

		$url = add_query_arg( $args, admin_url( 'themes.php' ) );

		return $url;
	}

	/**
	 * Get the current page requested.
	 *
	 * Only will return the page if the page has been registered.

	 * @return string|null The current active page if it exists
	 */
	public static function get_current_page() {
		$request_page = filter_input( INPUT_GET, 'view', FILTER_SANITIZE_STRING );
		$page         = (bool) $request_page ? $request_page : self::get_default_page();

		if ( array_key_exists( $page, self::get_pages() )
			|| in_array( $page, array( 'firstrun', 'raw' ), true ) ) {
			return $page;
		} else {
			return null;
		}
	}

	/**
	 * Return the deault options page.
	 *
	 * @return string The name of the default page.
	 */
	public static function get_default_page() {
		$pages = self::get_pages();

		if ( ! empty( $pages ) && is_array( $pages ) ) {
			$page_names = array_keys( $pages );

			return array_shift( $page_names );
		}

		return '404';
	}

	/**
	 * Get a list of pages avaliable for the option pages.
	 *
	 * Applies filter: bytegazette_options_pages to get the list of pages
	 *  to display.
	 *
	 * @return array The list of pages avaliable
	 */
	public static function get_pages() {
		if ( empty( self::$pages ) ) {
			$pages = array();

			self::$pages = apply_filters( 'bytegazette_options_pages', $pages );
		}

		return (array) self::$pages;
	}

	/**
	 * Sanitize and merge new settings with existing settings.
	 *
	 * @param array $input The new settings to apply.
	 * @return array The settings to apply.
	 */
	public static function sanitize_save_settings( $input ) {
		$current = get_option( ByteGazette::OPTIONS_SETTINGS );

		if ( ! is_array( $current ) ) {
			$current = array();
		}

		if ( ! is_array( $input ) ) {
			return $current;
		}

		return array_merge( $current, $input );
	}

	/**
	 * Register the custom scripts needed for options pages.
	 */
	public static function register_options_scripts() {
		$script_path = '/assets/js/bytegazette-admin.bundle.js';
		$local_path  = ( get_template_directory() . $script_path );

		if ( is_file( $local_path ) ) {
			wp_register_script(
				'bytegazette-admin-bundle',
				get_template_directory_uri() . $script_path,
				array(),
				filemtime( $local_path ),
				'all'
			);

			wp_localize_script('bytegazette-admin-bundle', 'bytegazetteData', array(
				'nonce'       => wp_create_nonce( 'wp_rest' ),
				'hook_suffix' => self::$hook_suffix,
				'basic_auth'  => defined( 'BYTEGAZETTE_ADMIN_AJAX_BASIC_AUTH' ) ? BYTEGAZETTE_ADMIN_AJAX_BASIC_AUTH : null,
			) );
		} else {
			ByteGazette_Admin_Notify::add_warn(
				__( 'ByteGazette theme missing assets!', 'bytegazette' ),
				__( 'The admin.bundle.js script required for the theme to operate was not found.', 'bytegazette' )
			);
		}
	}

	/**
	 * Register the custom styles needed for options pages.
	 */
	public static function register_options_styles() {
		$style_path = '/assets/css/bytegazette-admin.bundle.css';
		$local_path = ( get_template_directory() . $style_path );

		if ( is_file( $local_path ) ) {
			wp_register_style(
				'bytegazette-admin-bundle-styles',
				get_template_directory_uri() . $style_path,
				array(),
				filemtime( $local_path ),
				'all'
			);
		} else {
			ByteGazette_Admin_Notify::add_warn(
				__( 'ByteGazette theme missing assets!', 'bytegazette' ),
				__( 'The admin.bundle.css style sheet required for the theme to operate was not found.', 'bytegazette' )
			);
		}
	}

	/**
	 * Load required scripts for meta box functionality.
	 *
	 * @param string $hook_suffix The hook suffix to compare to load scripts.
	 */
	public static function enqueue_scripts( $hook_suffix ) {
		wp_enqueue_style( 'bytegazette-admin-bundle-styles' );
		wp_add_inline_script( 'bytegazette-admin-bundle', '', 'before' );

		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'postbox' );
		wp_enqueue_script( 'bytegazette-admin-bundle' );
	}

	/**
	 * Load the selected options page.
	 *
	 * @param string $hook_suffix The WordPress page screen id.
	 */
	public static function load_options_page( $hook_suffix ) {
		$current_page = self::get_current_page();

		if ( $current_page ) {
			// Load help tabs.
			self::do_options_page_help( $hook_suffix );

			// Set number of columns available.
			add_filter( 'screen_layout_columns', array( __CLASS__, 'screen_layout_columns' ), 10, 2 );

			// Apply standard meta boxes.
			add_action( 'add_meta_boxes', array( __CLASS__, 'fx_smb_submit_add_meta_box' ) );

			// Apply page specific meta boxes.
			do_action( "bytegazette_load_options_page_{$current_page}" );
		}
	}

	/**
	 * Return the number columns available in Settings Page.
	 * we can only set to 1 or 2 column.
	 *
	 * @param array  $columns The columns array.
	 * @param string $screen The WordPress screen id.
	 */
	public static function screen_layout_columns( $columns, $screen ) {
		$columns[ $screen ] = 2;

		return $columns;
	}

	/**
	 * Delete Options
	 */
	public static function fx_smb_reset_settings() {
		$action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			add_settings_error( ByteGazette::OPTIONS_SETTINGS, 'nopermission', __( 'Failed to reset settings. You do not capability to do this action.', 'bytegazette' ), 'error' );
		}

		if ( $action && 'reset_settings' === $action ) {
			$nonce = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );

			if ( wp_verify_nonce( $nonce, 'fx-smb-reset' ) ) {
				// Delete existing settings.
				delete_option( ByteGazette::OPTIONS_SETTINGS );

				// Deleted settings hook.
				do_action( 'bytegazette_options_settings_reset' );

				add_settings_error( ByteGazette::OPTIONS_SETTINGS, 'success', __( 'Settings reset to defaults.', 'bytegazette' ), 'updated' );
			} else {
				add_settings_error( ByteGazette::OPTIONS_SETTINGS, 'fail-nonce', __( 'Failed to reset settings. Please try again.', 'bytegazette' ), 'error' );
			}
		}
	}

	/**
	 * Add Submit/Save Meta Box
	 */
	public static function fx_smb_submit_add_meta_box() {
		add_meta_box(
			'submitdiv',
			__( 'Save Settings', 'bytegazette' ),
			array( __CLASS__, 'fx_smb_submit_meta_box' ),
			self::$hook_suffix,
			'side',
			'high'
		);
	}

	/**
	 * Submit Meta Box Callback
	 */
	public static function fx_smb_submit_meta_box() {
		$current_page = self::get_current_page();

		$url_params = array(
			'page'     => 'bytegazette_theme_options',
			'view'     => $current_page,
			'action'   => 'reset_settings',
			'_wpnonce' => wp_create_nonce( 'fx-smb-reset', __FILE__ ),
		);

		$reset_url = add_query_arg( $url_params, admin_url( 'themes.php' ) );

		?>
		<div id="submitpost" class="submitbox">
			<div id="major-publishing-actions">

				<div id="delete-action">
					<a href="<?php echo esc_url( $reset_url ); ?>" class="submitdelete deletion"><?php esc_html_e( 'Restore Defaults', 'bytegazette' ); ?></a>
				</div>

				<div id="publishing-action">
					<span class="spinner"></span>
					<?php submit_button( esc_attr( 'Save' ), 'primary', 'submit', false ); ?>
				</div>

				<div class="clear"></div>

			</div>
		</div>
		<?php
	}

	/**
	 * Show the options page supplied in the view get URL parameter.
	 *
	 * @param string $hook_suffix The WordPress options page screen id.
	 */
	public static function do_options_pages( $hook_suffix ) {
		// Init options page hook.
		do_action( 'bytegazette_options_page_init' );

		// Add meta boxes for this page.
		do_action( 'add_meta_boxes', $hook_suffix );

		if ( ! ByteGazette::is_configured() ) {
			self::render_options_page( 'firstrun' );
		} else {
			self::render_options_page();
		}
	}

	/**
	 * Generate the option page, and render the view.
	 *
	 * {@internal Called by action: "bytegazette_theme_options_page" }
	 *
	 * @param string $page The options page to show.
	 * @return void
	 */
	public static function do_options_page( $page ) {
		self::render( $page );
	}

	/**
	 * Render the options pages requested page or 404 page if no valid page was
	 * requested or supplied.
	 *
	 * @param string|null $page The name of the page to display.
	 * @return void
	 */
	protected static function render_options_page( $page = null ) {
		$page = (bool) $page ? $page : self::get_current_page();

		if ( $page ) {
			do_action_ref_array( 'bytegazette_theme_options_page', array( $page ) );
		} else {
			self::render( '404' );
		}
	}

	/**
	 * Render a theme options page.
	 *
	 * @param string $page The name of the page.
	 * @return void
	 */
	protected static function render( $page ) {
		$current_page = $page;

		if ( in_array( $page, array( '404', 'firstrun', 'raw' ), true ) ) {
			include get_template_directory() . "/inc/admin/option-page-$page.php";
		} else {
			include get_template_directory() . '/inc/admin/option-page-layout.php';
		}
	}

	/**
	 * Generate the option pages help tabs
	 */
	public static function do_options_page_help() {
		$current_screen = get_current_screen();
		$current_page   = self::get_current_page();

		do_action_ref_array( 'bytegazette_options_pages_help', array(
			$current_screen,
			$current_page,
		) );
	}
}
