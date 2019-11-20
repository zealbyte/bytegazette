<?php
/**
 * The template for displaying the lower footer section.
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_footer_logo = get_theme_mod( 'footer_logo', ByteGazette::DEFAULT_FOOTER_LOGO );
?>

<nav class="navbar">
	<div id="footer-branding">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="nofollow">
			<?php if ( ! empty( $bytegazette_footer_logo ) ) : ?>
				<img src="<?php echo esc_url( $bytegazette_footer_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			<?php else : ?>
				<h2 class="footer-title"><?php bloginfo( 'name' ); ?></h2>
			<?php endif; ?>
		</a>
	</div>

	<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'depth'          => 1,
				'menu_id'        => 'footer-menu',
				'menu_class'     => 'navbar-nav',
			) );
		?>
	<?php endif; ?>

	<div class="footer-about-text">
		<?php echo wp_kses_post( get_theme_mod( 'footer_lower', ByteGazette::get_theme_author_text() ) ); ?>
	</div>
</nav>
