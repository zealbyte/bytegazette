<?php
namespace ByteGazette\Customizer\Control
{
	use WP_Customize_Control;

	class RadioButtonControl extends WP_Customize_Control
	{
		public $type = 'radio-button';

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

			<div id="input_<?php echo $this->id; ?>" class="radio-button">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<input class="button-select" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
										<label for="<?php echo $this->id . $value; ?>"><?php echo esc_html( $label ); ?></label>
				<?php endforeach; ?>
			</div>
<?php }
	}
}
