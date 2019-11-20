<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Byte_Gazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_description = get_bloginfo( 'description', 'display' );
?>

<div class="uk-inline-clip">

	<div class="site-branding uk-position-center-left">
		<a class="uk-logo uk-float-left" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php endif; ?>

			<?php bloginfo( 'name' ); ?>
		</a>
	</div>

	<?php if ( $bytegazette_description || is_customize_preview() ) : ?>
		<div class="site-tagline uk-position-center-right">
			<?php echo esc_html( $bytegazette_description ); ?>
		</div>
	<?php endif; ?>

</div>
