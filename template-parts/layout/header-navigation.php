<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_navigation_logo = get_theme_mod( 'navigation_logo', ByteGazette::DEFAULT_FOOTER_LOGO );
?>

<nav class="navbar">
	<?php if ( ! empty( $bytegazette_navigation_logo ) ) : ?>
		<div id="navigation-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="nofollow">
				<img src="<?php echo esc_url( $bytegazette_navigation_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>
		</div>
	<?php endif; ?>

	<?php
	if ( has_nav_menu( 'header' ) ) :
		do_action( 'bytegazette_before_header_nav_menu' );

		wp_nav_menu( array(
			'theme_location' => 'header',
			'menu_id'        => 'header-menu',
			'menu_class'     => 'navbar-nav',
		) );

		do_action( 'bytegazette_after_header_nav_menu' );
	endif;
	?>

	<div class="search-box">
		<a class="uk-navbar-toggle" uk-search-icon href="#"></a>

		<div class="uk-drop" uk-drop="mode: click; pos: left-center; offset: 0">
			<form role="search" method="get" class="search-form uk-search-navbar uk-width-1-1@m uk-width-1-2@s" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input class="search-field uk-search-input" type="search" id="search-field" name="s" placeholder="Search..." value="" autofocus>
			</form>
		</div>
	</div>
</nav>
