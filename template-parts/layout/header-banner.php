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

	<?php if ( has_custom_logo() ) : ?>
		<div class="site-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home">
				<?php the_custom_logo(); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="site-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home">
			<?php bloginfo( 'name' ); ?>
		</a>
	</div>

	<?php if ( $bytegazette_description || is_customize_preview() ) : ?>
		<div class="site-description">
			<?php echo esc_html( $bytegazette_description ); ?>
		</div>
	<?php endif; ?>
