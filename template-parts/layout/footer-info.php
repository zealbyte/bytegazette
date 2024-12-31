<?php
/**
 * The template for displaying the upper footer section.
 *
 * @package Byte_Gazette
 */

do_action( 'bytegazette_theme_before_footer' );
?>

<div class="site-info-text">
	<?php echo wp_kses_post( bytegazette_get_option( 'footer_upper_text', ByteGazette::get_powered_by_text() ) ); ?>
</div>

<?php do_action( 'bytegazette_theme_after_footer' ); ?>
