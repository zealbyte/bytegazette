<?php
/**
 * Byte Gazette functions and definitions
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
 * Customizer controls generator.
 */
class ByteGazette_Customizer_Controls {
	/**
	 * Default priority for added sections.
	 */
	const DEFAULT_SECTION_PRIORITY = 30;

	/**
	 * Default priority for added controls.
	 */
	const DEFAULT_CONTROL_PRIORITY = 10;

	/**
	 * Add a panel section to a customizer panel.
	 *
	 * @param string $section_name The unique name of the section to add.
	 * @param array  $attributes The arguments to pass to the new section.
	 * @param int    $priority The section priority in the panel.
	 */
	public static function add_section( $section_name, $attributes = array(), $priority = self::DEFAULT_SECTION_PRIORITY ) {
		global $wp_customize;

		$title           = (string) isset( $attributes['title'] ) ? $attributes['title'] : '';
		$description     = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';
		$active_callback = isset( $attributes['active_callback'] ) ? $attributes['active_callback'] : null;

		$wp_customize->add_section( $section_name, array(
			'title'           => $title,
			'active_callback' => $active_callback,
			'priority'        => $priority,
		) );
	}

	/**
	 * Add switch to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_switch( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$sanitize    = 'realistic_sanitize_checkbox';
		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (bool) isset( $attributes['default'] ) ? $attributes['default'] : false;
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';

		$wp_customize->add_setting($control_name, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
		) );

		$wp_customize->add_control( new Realistic_Customizer_Switcher_Control(
			$wp_customize,
			$control_name,
			array(
				'type'        => 'checkbox',
				'label'       => $label,
				'description' => $description,
				'section'     => $section_name,
				'priority'    => $priority,
			)
		) );
	}

	/**
	 * Add checkbox to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_checkbox( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$sanitize    = 'realistic_sanitize_checkbox';
		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (bool) isset( $attributes['default'] ) ? $attributes['default'] : false;
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
		) );

		$wp_customize->add_control( $control_name, array(
			'type'         => 'checkbox',
			'label'        => $label,
			'description'  => $description,
			'section'      => $section_name,
			'priority'     => $priority,
		) );
	}

	/**
	 * Add number field control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_number( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$sanitize    = 'realistic_sanitize_posint';
		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (int) isset( $attributes['default'] ) ? $attributes['default'] : 0;
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';
		$min         = (int) isset( $attributes['min'] ) ? $attributes['min'] : 0;
		$max         = (int) isset( $attributes['max'] ) ? $attributes['max'] : 100;
		$step        = (int) isset( $attributes['step'] ) ? $attributes['step'] : 1;

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
		) );

		$wp_customize->add_control( $control_name, array(
			'type'        => 'number',
			'label'       => $label,
			'description' => $description,
			'section'     => $section_name,
			'priority'    => $priority,
			'input_attrs' => array(
				'min'       => $min,
				'max'       => $max,
				'step'      => $step,
			),
		) );
	}

	/**
	 * Add range selector control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_range( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$sanitize    = 'realistic_sanitize_posint';
		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (int) isset( $attributes['default'] ) ? $attributes['default'] : 0;
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';
		$min         = (int) isset( $attributes['min'] ) ? $attributes['min'] : 0;
		$max         = (int) isset( $attributes['max'] ) ? $attributes['max'] : 100;
		$step        = (int) isset( $attributes['step'] ) ? $attributes['step'] : 1;

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
		) );

		$wp_customize->add_control( $control_name, array(
			'type'        => 'range',
			'label'       => $label,
			'description' => $description,
			'section'     => $section_name,
			'priority'    => $priority,
			'input_attrs' => array(
				'min'       => $min,
				'max'       => $max,
				'step'      => $step,
			),
		) );
	}

	/**
	 * Add general text field control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_textfield( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (string) isset( $attributes['default'] ) ? $attributes['default'] : '';
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';

		$sanitize_callback = 'realistic_sanitize_text';

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize_callback,
		) );

		$wp_customize->add_control( $control_name, array(
			'type'        => 'textfield',
			'label'       => $label,
			'description' => $description,
			'section'     => $section_name,
			'priority'    => $priority,
		) );
	}

	/**
	 * Add general text area control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_textarea( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (string) isset( $attributes['default'] ) ? $attributes['default'] : '';
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';

		$sanitize_callback = 'realistic_sanitize_text';

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize_callback,
		) );

		$wp_customize->add_control( $control_name, array(
			'type'        => 'textarea',
			'label'       => $label,
			'description' => $description,
			'section'     => $section_name,
			'priority'    => $priority,
		) );
	}

	/**
	 * Add cropped image control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_cropped_image( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (string) isset( $attributes['default'] ) ? $attributes['default'] : '';
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';
		$width       = (int) isset( $attributes['width'] ) ? $attributes['width'] : 0;
		$height      = (int) isset( $attributes['height'] ) ? $attributes['height'] : 0;
		$flex_width  = (bool) isset( $attributes['flex_width'] ) ? $attributes['flex_width'] : false;
		$flex_height = (bool) isset( $attributes['flex_height'] ) ? $attributes['flex_height'] : false;

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			$control_name,
			array(
				'width'       => $width,
				'height'      => $height,
				'flex_width'  => $flex_width,
				'flex_height' => $flex_height,
				'label'       => $label,
				'description' => $description,
				'section'     => $section_name,
				'priority'    => $priority,
			)
		) );
	}

	/**
	 * Add uploader control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_custom_image( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (string) isset( $attributes['default'] ) ? $attributes['default'] : '';
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			$control_name,
			array(
				'label'       => $label,
				'description' => $description,
				'section'     => $section_name,
				'priority'    => $priority,
			)
		) );
	}

	/**
	 * Add color picker control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_color( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (string) isset( $attributes['default'] ) ? $attributes['default'] : '';
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			$control_name,
			array(
				'label'       => $label,
				'description' => $description,
				'section'     => $section_name,
				'priority'    => $priority,
			)
		) );
	}

	/**
	 * Add radio control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_radio( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (string) isset( $attributes['default'] ) ? $attributes['default'] : '';
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';
		$choices     = (array) isset( $attributes['choices'] ) ? $attributes['choices'] : array();

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => 'realistic_sanitize_choices',
		) );

		$wp_customize->add_control( $control_name, array(
			'type'        => 'radio',
			'label'       => $label,
			'description' => $description,
			'section'     => $section_name,
			'priority'    => $priority,
			'choices'     => $choices,
		) );
	}

	/**
	 * Add image radio control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_image_radio( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (string) isset( $attributes['default'] ) ? $attributes['default'] : '';
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';
		$choices     = (array) isset( $attributes['choices'] ) ? $attributes['choices'] : array();

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => 'realistic_sanitize_choices',
		) );

		$wp_customize->add_control( new ByteGazette_Customizer_Control_Radio_Image(
			$wp_customize,
			$control_name,
			array(
				'label'       => $label,
				'description' => $description,
				'section'     => $section_name,
				'priority'    => $priority,
				'choices'     => $choices,
			)
		) );
	}

	/**
	 * Add button radio control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_radio_buttons( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (string) isset( $attributes['default'] ) ? $attributes['default'] : '';
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';
		$choices     = (array) isset( $attributes['choices'] ) ? $attributes['choices'] : array();

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => 'realistic_sanitize_choices',
		) );

		$wp_customize->add_control( new Realistic_Customizer_Radio_Button_Control(
			$wp_customize,
			$control_name,
			array(
				'label'       => $label,
				'description' => $description,
				'section'     => $section_name,
				'priority'    => $priority,
				'choices'     => $choices,
			)
		) );
	}

	/**
	 * Add dropdown select control to a customizer section.
	 *
	 * @param string $control_name The unique name of the control to add.
	 * @param string $section_name The name of the section to add the control to.
	 * @param array  $attributes The specific attributes for this control.
	 * @param int    $priority The control priority in the section.
	 */
	public static function add_select( $control_name, $section_name, $attributes = array(), $priority = self::DEFAULT_CONTROL_PRIORITY ) {
		global $wp_customize;

		$label       = (string) isset( $attributes['label'] ) ? $attributes['label'] : '';
		$default     = (string) isset( $attributes['default'] ) ? $attributes['default'] : '';
		$description = (string) isset( $attributes['description'] ) ? $attributes['description'] : '';
		$choices     = (array) isset( $attributes['choices'] ) ? $attributes['choices'] : array();

		$wp_customize->add_setting( $control_name, array(
			'default'           => $default,
			'sanitize_callback' => 'realistic_sanitize_choices',
		) );

		$wp_customize->add_control( $control_name, array(
			'type'        => 'select',
			'label'       => $label,
			'description' => $description,
			'section'     => $section_name,
			'priority'    => $priority,
			'choices'     => $choices,
		) );
	}
}
