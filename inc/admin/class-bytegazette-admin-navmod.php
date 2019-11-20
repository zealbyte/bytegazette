<?php
/**
 * The Byte Gazette navigation modifications
 *
 * @package The_Byte_Gazette
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

/**
 */
class ByteGazette_Admin_Navmod {

	/**
	 *
	 *
	 * @return void
	 */
	public static function init_admin_navmod() {
		add_action(
			'admin_head-nav-menus.php',
			array( __CLASS__, 'register_menu_metabox' )
		);
	}

	/**
	 */
	public static function register_menu_metabox() {
		$custom_param = array( 0 => 'This param will be passed to bytegazette_render_menu_metabox' );

		add_meta_box(
			'my-menu-test-metabox',
			'Headings &amp; Dividers',
			array( __CLASS__, 'render_menu_metabox' ),
			'nav-menus',
			'side',
			'default',
			$custom_param
		);
	}

	/**
	 * Displays a menu metabox
	 *
	 * If you passed custom params to add_meta_box(), they will be in $args['args'].
	 *
	 * @param string $object Not used.
	 * @param array  $args Parameters and arguments.
	 */
	public static function render_menu_metabox( $object, $args ) {
		global $_nav_menu_placeholder, $nav_menu_selected_id;

		$_nav_menu_placeholder = 0 > $_nav_menu_placeholder - 1 ? $_nav_menu_placeholder : -1;

		$nav_heading_items = [
			(object) [
				'ID' => 1,
				'db_id' => 0,
				'menu_item_parent' => 0,
				'object_id' => 1,
				'post_parent' => 0,
				'type' => 'zealbyte-nav-mod',
				'object' => 'zealbyte-nav-mod-heading',
				'type_label' => '(ZealByte) Nav Heading',
				'title' => 'Categories',
				'url' => '#',
				'target' => '',
				'attr_title' => '',
				'description' => 'Nav menu heading',
				'classes' => ['uk-nav-header'],
				'xfn' => '',
			],
			(object) [
				'ID' => 2,
				'db_id' => 0,
				'menu_item_parent' => 0,
				'object_id' => 2,
				'post_parent' => 0,
				'type' => 'zealbyte-nav-mod',
				'object' => 'zealbyte-nav-mod-heading',
				'type_label' => '(ZealByte) Nav Heading',
				'title' => 'More',
				'url' => '#',
				'target' => '',
				'attr_title' => '',
				'description' => 'Nav menu heading',
				'classes' => ['uk-nav-header'],
				'xfn' => '',
			],
		];

		$nav_sectionalize_items = [
			(object) [
				'ID' => 2,
				'db_id' => 0,
				'menu_item_parent' => 0,
				'object_id' => 2,
				'post_parent' => 0,
				'type' => 'zealbyte-nav-mod',
				'object' => 'zealbyte-nav-mod-divider',
				'type_label' => '(ZealByte) Nav Divider',
				'title' => 'Menu Divider',
				'url' => '#',
				'target' => '',
				'attr_title' => '',
				'description' => 'Nav menu divider',
				'classes' => ['uk-nav-divider'],
				'xfn' => '',
			],
		];

		$s_walker = new Walker_Nav_Menu_Checklist( false );

		$current_tab = 'heading';

		if ( isset( $_REQUEST['zealbyte-nav-mod-tab'] ) && in_array( $_REQUEST['zealbyte-nav-mod-tab'], [ 'heading', 'sectionalize' ] ) ) {
			$current_tab = $_REQUEST['zealbyte-nav-mod-tab'];
		}

		$removed_args = [
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		];
		?>

		<div id="zealbyte-nav-mod-div" class="posttypediv">

			<ul id="zealbyte-nav-mod-tabs" class="posttype-tabs add-menu-item-tabs">
				<li <?php echo ( 'heading' == $current_tab ? ' class="tabs"' : '' ); ?>>
					<a class="nav-tab-link" data-type="tabs-panel-zealbyte-nav-mod-heading" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg('zealbyte-nav-mod-tab', 'heading', remove_query_arg($removed_args))); ?>#tabs-panel-zealbyte-nav-mod-heading">
						<?php _e( 'Heading', 'zealbyte' ); ?>
					</a>
				</li>
				<li <?php echo ( 'sectionalize' == $current_tab ? ' class="tabs"' : '' ); ?>>
					<a class="nav-tab-link" data-type="tabs-panel-zealbyte-nav-mod-sectionalize" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg('zealbyte-nav-mod-tab', 'sectionalize', remove_query_arg($removed_args))); ?>#tabs-panel-zealbyte-nav-mod-sectionalize">
						<?php _e( 'Sectionalize', 'zealbyte' ); ?>
					</a>
				</li>
			</ul>

			<div class="tabs-panel <?php echo ( 'heading' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>" id="tabs-panel-zealbyte-nav-mod-heading">
				<ul id="zealbyte-nav-mod-heading" class="categorychecklist form-no-clear">
					<li>
						<input type="hidden" class="menu-item-object" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object]" value="zealbyte-nav-mod-heading" />
						<input type="hidden" class="menu-item-type" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" value="zealbyte-nav-mod" />
						<input type="hidden" class="menu-item-classes" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-classes]" value="uk-nav-header" />
						<p id="zealbyte-nav-mod-heading-menu-item-name-wrap" class="wp-clearfix">
							<label class="menu-item-title" for="zealbyte-nav-mod-heading-menu-item-name">
								<input type="checkbox" class="menu-item-checkbox" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object-id]" value="1" />
							</label>
							<input type="text" class="regular-text menu-item-textbox" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" id="zealbyte-nav-mod-heading-menu-item-name" placeholder="<?php _e( 'New Heading', 'zealbyte' ); ?>" value="" />
						</p>
					</li>
					<?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $nav_heading_items ), 0, (object) array( 'walker' => $s_walker ) ); ?>
				</ul>
			</div>

			<div class="tabs-panel <?php echo ( 'sectionalize' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>" id="tabs-panel-zealbyte-nav-mod-sectionalize">
				<ul id="zealbyte-nav-mod-sectionalize" class="categorychecklist form-no-clear">
					<?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $nav_sectionalize_items ), 0, (object) array( 'walker' => $s_walker ) ); ?>
				</ul>
			</div>

			<p class="button-controls wp-clearfix">
				<span class="list-controls">
				</span>

				<span class="add-to-menu">
					<input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-zealbyte-nav-mod-menu-item" id="submit-zealbyte-nav-mod-div" />
					<span class="spinner"></span>
				</span>
			</p>

		</div>
		<?php
	}
}
