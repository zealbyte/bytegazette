<?php
namespace ByteGazette\Customizer\Control
{
	use WP_Customize_Control;

	class Realistic_Customizer_Switcher_Control extends WP_Customize_Control
	{
		public $type = 'switcher';

		public function render_content ()
		{
?>

			<label>

								<?php if ( !empty( $this->label ) ) { ?>
										<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
								<?php } ?>
								<?php if ( !empty( $this->description ) ) { ?>
										<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
								<?php } ?>

								<input type="checkbox" id="input_<?php echo $this->id; ?>" class="switcher-toggle" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
								<label class="switcher-viewport" for="input_<?php echo $this->id; ?>">
										<div class="switcher">
												<div class="switcher-button">&nbsp;</div>
												<div class="switcher-content left"><span><?php esc_html_e( 'On', 'realistic' ); ?></span></div>
												<div class="switcher-content right"><span><?php esc_html_e( 'Off', 'realistic' ); ?></span></div>
										</div>
								</label>

			</label>
<?php }
	}
}
