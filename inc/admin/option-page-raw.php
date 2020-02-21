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

global $bytegazette_options_settings;

bytegazette_get_option( 'nada', null );

$bytegazette_mods_option = 'theme_mods_' . get_template();
$bytegazette_theme_mods  = get_option( $bytegazette_mods_option );
?>

<div>

	<h2>Raw Theme Options</h2>

	<h3>Theme Mods</h3>
	<pre>
		<?php print_r( $bytegazette_theme_mods ); ?>
	</pre>

	<h3>Theme Settings</h3>
	<pre>
		<?php print_r( $bytegazette_options_settings ); ?>
	</pre>

</div>

