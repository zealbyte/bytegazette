<?php
/**
 * The template for displaying the upper footer section.
 *
 * @package Byte_Gazette
 */

do_action( 'bytegazette_theme_before_footer' );
?>

<div class="site-info-text">
	<?php echo wp_kses_post( get_theme_mod( 'bytegazette_footer_upper', ByteGazette::get_powered_by_text() ) ); ?>
</div>

<?php do_action( 'bytegazette_theme_after_footer' ); ?>
