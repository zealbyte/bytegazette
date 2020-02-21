<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_sidebar_layout = bytegazette_get_sidebar_layout();
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php
	if ( is_active_sidebar( 'sidebar' ) && 'none' !== $bytegazette_sidebar_layout ) {
		dynamic_sidebar( 'sidebar' );
	}
	?>
</div><!-- #secondary -->

