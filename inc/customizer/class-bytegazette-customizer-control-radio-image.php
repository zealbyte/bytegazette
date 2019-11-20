<?php
/**
 * Image radio buttons control.
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
 * Custom control to use images as radio buttons in theme customizer.
 */
class ByteGazette_Customizer_Control_Radio_Image extends WP_Customize_Control {
	/**
	 * The base control type.
	 *
	 * @var string
	 */
	public $type = 'radio-image';

	/**
	 * The required javascripts for this control to operate.
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );
	}

	/**
	 * The rendered output of the control.
	 */
	public function render_content()
	{
		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-' . $this->id; ?>

						<?php if ( !empty( $this->label ) ) { ?>
								<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php } ?>
						<?php if ( !empty( $this->description ) ) { ?>
								<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
						<?php } ?>

			<div id="input_<?php echo $this->id; ?>" class="image">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<label for="<?php echo $this->id . $value; ?>">
							<img src="<?php echo esc_html( $label ); ?>">
						</label>
					</input>
				<?php endforeach; ?>
			</div>
			<script>jQuery(document).ready(function($) { $( '[id="input_<?php echo esc_attr( $this->id ); ?>"]' ).buttonset(); });</script>
		<?php
	}
}

