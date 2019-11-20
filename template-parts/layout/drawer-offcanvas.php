<?php
/**
 * The template for displaying the offcanvas drawer
 *
 * @package Byte_Gazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

?>

<!-- <div id="offcanvas-nav" data-uk-offcanvas="flip: true; overlay: true"> -->
<div id="drawer" uk-offcanvas="mode: slide; overlay: true">
	<div class="uk-offcanvas-bar uk-offcanvas-bar-animation uk-offcanvas-slide">

		<button class="uk-offcanvas-close" type="button" uk-close></button>

		<!-- The widget area for the drawer -->
		<?php dynamic_sidebar( 'drawer' ); ?>

		<nav class="offcanvas-navigation" role="navigation">
			<?php
			if ( has_nav_menu( 'drawer' ) ) :

				wp_nav_menu( array(
					'theme_location' => 'drawer',
					'menu_id'        => 'drawer-menu',
					'menu_class'     => 'site-navigation uk-nav uk-nav-default uk-nav-parent-icon',
					'walker'         => new ZealByte\Walker\NavWalker(),
				) );

			endif;
			?>
		</nav>

	</div>
</div> <!-- /#drawer -->
