<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_sidebar_body_class = bytegazette_get_sidebar_body_class();

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width,initial-scale=1">

		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<link rel="prefetch" href="<?php echo esc_url( bytegazette_images_loading() ); ?>">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class( array( $bytegazette_sidebar_body_class ) ); ?>>

		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bytegazette' ); ?></a>

			<header id="masthead" class="site-header">

				<div id="site-branding" class="main-banner" role="banner">
					<div class="container">
						<?php get_template_part( 'template-parts/layout/header', 'banner' ); ?>
					</div>
				</div>

				<div id="site-navigation" class="main-navigation sticktotop" role="navigation">
					<div class="container">
						<?php get_template_part( 'template-parts/layout/header', 'navigation' ); ?>
					</div>
				</div>

			</header>

			<div id="content" class="site-content container">

