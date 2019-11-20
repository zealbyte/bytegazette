<?php
/**
 * Byte Gazette functions and definitions
 *
 * @package Byte_Gazette
 */

/*
This file is part of the Byte Gazette theme for WordPress.

Byte Gazette is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

Byte Gazette is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Byte Gazette.  If not, see <http://www.gnu.org/licenses/>.

Copyright 2018 ZealByte.
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}
?>

<div class="wrap">

	<h2><?php echo esc_html( wp_get_theme()->Name . ' ' ); ?><?php esc_html_e( 'Options', 'bytegazette' ); ?></h2>

	<?php settings_errors(); ?>

	<?php do_action( 'bytegazette_admin_options_header' ); ?>

	<h2 class="nav-tab-wrapper">
		<?php foreach ( ByteGazette_Admin_Options::get_pages() as $bytegazette_admin_option_page => $bytegazette_admin_option_page_title ) : ?>
			<a href="<?php echo esc_url( ByteGazette_Admin_Options::generate_url( $bytegazette_admin_option_page ) ); ?>" class="nav-tab <?php echo $current_page === $bytegazette_admin_option_page ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $bytegazette_admin_option_page_title ); ?></a>
		<?php endforeach; ?>
	</h2>

	<div class="manage-menus">
		<div class="alignleft">
			<a class="button">Action</a>
		</div>
		<div class="alignright">
			<a class="button">Menu</a>
		</div>
	</div>

	<div class="fx-settings-meta-box-wrap">
		<form action="options.php" method="post">
			<input type="hidden" name="action" value="some-action">
			<?php wp_nonce_field( ByteGazette::NONCE ); ?>
			<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>

			<!-- <input name="bytegazette_display_options[submit-<?php echo esc_attr( $current_page ); ?>]" type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Settings', 'bytegazette' ); ?>" /> -->

			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-<?php echo 1 === get_current_screen()->get_columns() ? '1' : '2'; ?>">

					<div id="postbox-container-1" class="postbox-container">

							<?php do_meta_boxes( $hook_suffix, 'side', null ); ?>
							<!-- #side-sortables -->

					</div><!-- #postbox-container-1 -->

					<div id="postbox-container-2" class="postbox-container">

							<?php do_meta_boxes( $hook_suffix, 'normal', null ); ?>
							<!-- #normal-sortables -->

							<?php do_meta_boxes( $hook_suffix, 'advanced', null ); ?>
							<!-- #advanced-sortables -->

					</div><!-- #postbox-container-2 -->

				</div> <!-- #post-body -->
				<br class="clear">
			</div> <!-- #poststuff -->
		</form>
	</div>

	<div>
		<hr>
		<p class="alignleft">
			<a target="_blank" href="<?php echo esc_url( ByteGazette::URL_FEEDBACK ); ?>"><?php esc_html_e( 'Feedback', 'bytegazette' ); ?></a> |
			<a target="_blank" href="<?php echo esc_url( ByteGazette::URL_ABOUT ); ?>"><?php esc_html_e( 'About', 'bytegazette' ); ?></a> |
			<a target="_blank" href="<?php echo esc_url( ByteGazette::URL_SUPPORT ); ?>"><?php esc_html_e( 'Community', 'bytegazette' ); ?></a>
		</p>
		<p class="alignright">
			<?php echo wp_kses_post( ByteGazette::get_theme_author_text() ); ?>
		</p>
		<br class="clear">
	</div>

</div><!-- /.wrap -->
