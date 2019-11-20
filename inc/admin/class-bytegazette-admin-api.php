<?php
/**
 * Byte Gazette Admin API Controller
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
 * Class ByteGazette_Admin_Api
 *
 * Example rest server that allows for CRUD operations on the wp_options table
 */
class ByteGazette_Admin_Api extends WP_Rest_Controller {
	const API_NAMESPACE = 'bytegazette/';
	const API_VERSION   = 'v1';

	/**
	 * The instance of self.
	 *
	 * @var ByteGazette_Admin_Api
	 **/
	protected static $instance;

	/**
	 *
	 *
	 * @return void
	 */
	public static function init_admin_api() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		add_action( 'rest_api_init', array( self::$instance, 'register_routes' ) );
	}

	/**
	 *
	 *
	 * @return void
	 */
	public function register_routes() {
		$namespace = self::API_NAMESPACE . self::API_VERSION;

		register_rest_route( $namespace, '/records', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_options' ),
				'permission_callback' => array( $this, 'get_options_permission' ),
			),
		) );

		register_rest_route( $namespace, '/record/(?P<slug>(.*)+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_option' ),
				'permission_callback' => array( $this, 'get_options_permission' ),
			),
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'edit_option' ),
				'permission_callback' => array( $this, 'get_options_permission' ),
			),
		) );
	}

	/**
	 *
	 *
	 * @return array The RESTful API Options.
	 */
	public function get_options( WP_REST_Request $request ) {
		return wp_load_alloptions();
	}

	/**
	 *
	 */
	public function get_options_permission()
	{
		//if ( ! current_user_can( 'administrator' ) ) {
			//return new WP_Error( 'rest_forbidden', esc_html__( 'You do not have permissions to manage options.', 'wp-react-boilerplate' ), array( 'status' => 401 ) );
		//}

		return true;
	}

	/**
	 *
	 */
	public function get_option( WP_REST_Request $request ) {
		$params = $request->get_params();

		if ( ! isset( $params['slug'] ) || empty( $params['slug'] ) ) {
			return new WP_Error( 'no-param', __( 'No slug param', 'bytegazette' ) );
		}

		$converted_slug = $this->_convert_slug( $params['slug'] );

		$opt_value = get_site_option( $converted_slug );

		if ( ! $opt_value ) {
			return new WP_Error( 'option-not-found', __( 'Option not found', 'bytegazette' ) );
		}

		return $opt_value;
	}

	/**
	 *
	 */
	public function edit_option( WP_REST_Request $request ) {
		$params = $request->get_params();

		if ( ! isset( $params['slug'] ) || empty( $params['slug'] ) ) {
			return new WP_Error( 'no-param', __( 'No slug param', 'bytegazette' ) );
		}

		$body = $request->get_body();

		if ( empty( $body ) ) {
			return new WP_Error( 'no-body', __( 'Request body empty', 'bytegazette' ) );
		}

		$decoded_body = json_decode( $body );

		if ( $decoded_body ) {
			if ( isset( $decoded_body->key, $decoded_body->value ) ) {

				if ( ! get_site_option( $decoded_body->key ) ) {
					return false;
				}

				if ( update_option( $decoded_body->key, $decoded_body->value ) ) {
					return true;
				}
			}
		}

		return false;
	}
}
