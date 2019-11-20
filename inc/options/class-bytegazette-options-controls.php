<?php
/**
 * Byte Gazette Admin Settings
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
class ByteGazette_Options_Controls {

	const DEFAULT_PANEL_PRIORITY = 'default';
	const DEFAULT_PANEL_CONTEXT  = 'normal';

	/**
	 * Add a metabox and settings section for the metabox to the the current screen.
	 *
	 * @param string $panel_name The unique metabox name.
	 * @param array  $attributes The metabox attributes.
	 * @param int    $priority The metabox priority on the screen.
	 */
	public static function add_panel( $panel_name, $attributes = array(), $priority = self::DEFAULT_PANEL_PRIORITY ) {
		$screen_id        = get_current_screen()->id;
		$metabox_callback = array( __CLASS__, 'do_panel_content_callback' );
		$section_callback = array( __CLASS__, 'do_setting_section_callback' );

		$context = isset( $attributes['context'] ) ? $attributes['context'] : self::DEFAULT_PANEL_CONTEXT;
		$context = in_array( $context, array( 'side', 'normal', 'advanced' ), true ) ? $context : self::DEFAULT_PANEL_CONTEXT;

		$name        = "bytegazette_$panel_name";
		$title       = (string) isset( $attributes['title'] ) ? $attributes['title'] : '';
		$priority    = in_array( $priority, array( 'default', 'low', 'high' ), true ) ? $priority : self::DEFAULT_PANEL_PRIORITY;
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';

		$args = array(
			'description' => $description,
		);

		add_settings_section( $name, $title, $section_callback, $screen_id );
		add_meta_box( $name, $title, $metabox_callback, $screen_id, $context, $priority, $args );
	}

	/**
	 * Add checkbox to a customizer section.
	 *
	 * @param string $setting_name The unique name of the setting to add.
	 * @param string $panel_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this form control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_checkboxes( $setting_name, $panel_name, $attributes = array(), $priority = 10 ) {
		$screen_id = get_current_screen()->id;
		$callback  = array( __CLASS__, 'do_settings_field_callback' );

		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';

		$default = isset( $attributes['default'] ) && is_array( $attributes['default'] ) ? $attributes['default'] : array();
		$choices = isset( $attributes['choices'] ) && is_array( $attributes['choices'] ) ? $attributes['choices'] : array();

		$section = "bytegazette_$panel_name";
		$id      = "bytegazette_options_$setting_name";
		$label   = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';

		$args = array(
			'id'      => $id,
			'setting' => $setting_name,
			'label'   => $label,
			'default' => $default,
			'choices' => $choices,
		);

		add_settings_field( $id, $label, $callback, $screen_id, $section, $args );
	}

	/**
	 * Provide content to the metabox.
	 *
	 * @param mixed $cbb I have no clue what this is.
	 * @param array $args The arguments passed to the content generator.
	 */
	public static function do_panel_content_callback( $cbb, $args ) {
		$screen_id   = get_current_screen()->id;
		$id          = isset( $args['id'] ) ? $args['id'] : null;
		$description = isset( $args['args'] ) && isset( $args['args']['description'] ) ? $args['args']['description'] : null;

		if ( ! empty( $description ) ) {
			print( esc_html( $description ) );
		}

		settings_fields( $screen_id );

		print( '<table class="form-table">' );
		do_settings_fields( $screen_id, $id );
		print( '</table>' );
	}

	/**
	 * Settings section callback function .
	 *
	 * This function is needed if we added a new section. This function
	 * will be run at the start of our section
	 *
	 * @param array $args The section arguments.
	 */
	public static function do_setting_section_callback( $args ) {
		$description = isset( $args['description'] ) ? $args['description'] : null;

		if ( $description ) {
			printf( '<p>%s</p>', esc_html( $args['description'] ) );
		}
	}

	/**
	 * Callback function for our example setting.
	 *
	 * Creates a checkbox true/false option. Other types are surely possible.
	 */
	public static function do_settings_field_callback( $args ) {
		$option = ByteGazette::OPTIONS_SETTINGS;

		$id      = isset( $args['id'] ) ? $args['id'] : null;
		$setting = isset( $args['setting'] ) ? $args['setting'] : null;

		if ( ! ( $id && $setting ) ) {
			return;
		}

		$name    = sprintf( '%s[%s]', $option, $setting );
		$label   = (string) isset( $args['label'] ) ? $args['label'] : '';
		$choices = isset( $args['choices'] ) && is_array( $args['choices'] ) ? $args['choices'] : array();
		$default = isset( $args['default'] ) && is_array( $args['default'] ) ? $args['default'] : array();
		$values  = bytegazette_get_option( $setting, $default );
		$values  = is_array( $values ) ? $values : $default;

		printf( '<fieldset><legend class="screen-reader-text"><span>%s</span></legend>', esc_html( $label ) );

		foreach ( $choices as $choice => $choice_label ) {
			$choice_id    = sprintf( '%s_%s', $id, $choice );
			$choice_name  = sprintf( '%s[%s][%s]', $option, $setting, $choice );
			$choice_value = isset( $values[ $choice ] ) ? $values[ $choice ] : 0;

			printf( '<label for="%1$s"><input id="%1$s" name="%2$s" type="checkbox" value="1" class="code" %3$s /> %4$s</label><br>',
				esc_attr( $choice_id ),
				esc_attr( $choice_name ),
				checked( 1, $choice_value, false ),
				esc_html( $choice_label )
			);
		}

		printf( '<input type="hidden" id="%1$s" name="%2$s[_saved]" value="saved"></fieldset>', esc_attr( $id ), esc_attr( $name ) );
	}

}
