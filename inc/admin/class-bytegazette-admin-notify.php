<?php
/**
 * Byte Gazette Admin Common
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


/**
 *
 */
class ByteGazette_Admin_Notify {
	/**
	 * Collection of warning admin notices.
	 *
	 * @var array
	 */
	protected static $warnings = array();

	/**
	 * Collection of error admin notices.
	 *
	 * @var array
	 */
	protected static $errors = array();

	/**
	 * Collection of information admin notices.
	 *
	 * @var array
	 */
	protected static $infos = array();

	/**
	 * Collection of success admin notices.
	 *
	 * @var array
	 */
	protected static $successes = array();


	/**
	 * Initialize methods with necessary events to utilize the features of this
	 * class.
	 *
	 * @return void
	 */
	public static function init_admin_notify() {
		add_action( 'admin_notices', array( __CLASS__, 'do_notices' ) );
	}

	/**
	 * Add an info notice to the WordPress Admin.
	 *
	 * @param string $title The tile of the notice.
	 * @param string $message The notice message.
	 * @return void
	 */
	public static function add_info( $title, $message = '' ) {
		array_push( self::$infos, array(
			'title'   => $title,
			'message' => $message,
		) );
	}

	/**
	 * Add a success notice to the WordPress Admin.
	 *
	 * @param string $title The tile of the notice.
	 * @param string $message The notice message.
	 * @return void
	 */
	public static function add_success( $title, $message = '' ) {
		array_push( self::$successes, array(
			'title'   => $title,
			'message' => $message,
		) );
	}

	/**
	 * Add an error notice to the WordPress Admin.
	 *
	 * @param string $title The tile of the notice.
	 * @param string $message The notice message.
	 * @return void
	 */
	public static function add_error( $title, $message = '' ) {
		array_push( self::$errors, array(
			'title'   => $title,
			'message' => $message,
		) );
	}

	/**
	 * Add a warning notice to the WordPress Admin.
	 *
	 * @param string $title The tile of the notice.
	 * @param string $message The notice message.
	 * @return void
	 */
	public static function add_warn( $title, $message = '' ) {
		array_push( self::$warnings, array(
			'title'   => $title,
			'message' => $message,
		) );
	}

	/**
	 *
	 */
	public static function do_notices() {
		if ( array() !== self::$errors ) {
			$notices = self::merge_notices( self::$errors );
			self::echo_merged_notices( $notices, 'error' );
		}

		if ( array() !== self::$warnings ) {
			$notices = self::merge_notices( self::$warnings );
			self::echo_merged_notices( $notices, 'warning' );
		}

		if ( array() !== self::$successes ) {
			$notices = self::merge_notices( self::$successes );
			self::echo_merged_notices( $notices, 'success' );
		}

		if ( array() !== self::$infos ) {
			$notices = self::merge_notices( self::$infos );
			self::echo_merged_notices( $notices, 'info' );
		}
	}

	/**
	 * notice-error, notice-warning, notice-success, notice-info
	 * is-dismissible
	 */
	protected static function merge_notices( array $notices ) {
		$messages = array();

		foreach ( $notices as $notice ) {
			$title   = ( array_key_exists( 'title', $notice ) ? $notice['title'] : '' );
			$message = ( array_key_exists( 'message', $notice ) ? $notice['message'] : '' );

			$hash = self::generate_title_hash( $title );

			$dismiss_url = add_query_arg( array(
				'bytegazette_theme_dismiss' => $hash,
			), admin_url() );

			if ( ! array_key_exists( $hash, $messages ) ) {
				$messages[ $hash ] = array(
					'title'    => $title,
					'messages' => array(),
				);
			}

			array_push( $messages[ $hash ]['messages'], $message );
		}

		return $messages;
	}

	/**
	 * Print notices.
	 *
	 * @param array  $notices A list of notices to echo.
	 * @param string $type The type of notices to echo.
	 * @return void;
	 */
	protected static function echo_merged_notices( $notices, $type ) { ?>
		<?php $class = "notice notice-$type is-dismissible"; ?>

		<?php foreach ( $notices as $notice ) : ?>
			<?php $title = ( array_key_exists( 'title', $notice ) ? $notice['title'] : '' ); ?>
			<?php $messages = ( array_key_exists( 'messages', $notice ) ? $notice['messages'] : '' ); ?>

			<div class="<? echo esc_attr( $class ); ?>">
				<p><strong><?php echo esc_html( $title ); ?></strong><br>

				<?php if ( ! is_array( $messages ) || 1 === count( $messages ) ) : ?>

					<?php echo esc_html( is_array( $messages ) ? array_pop( $messages ) : $messages ); ?>

				<?php else : ?>

					<ul>

						<?php foreach ( $messages as $message ) : ?>

							<li><?php echo esc_html( $message ); ?></li>

						<?php endforeach; ?>

					</ul>

				<?php endif; ?>

				</p>
			</div>

		<?php endforeach; ?>
		<?php
	}

	/**
	 * Create a common canonicalization and hash for a title.
	 *
	 * @param string $title The tile to hash.
	 * @return string;
	 */
	protected static function generate_title_hash( $title ) {
		return md5( strtolower( trim( $title ) ) );
	}

}
