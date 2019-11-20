<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package The_Byte_Gazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

if ( ! function_exists( 'bytegazette_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see bytegazette_custom_header_setup().
	 */
	function bytegazette_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}
		 */

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

// Dynamic CSS
if ( !function_exists( 'bytegazette_dynamic_css' ) ) :
	function bytegazette_dynamic_css() {

		// Sidebar layout settings.
		$theme_css = '';
		$theme_css .= 'left_sidebar' == esc_attr( get_theme_mod( 'sidebar_layout', ByteGazette::DEFAULT_SIDEBAR_LAYOUT ) )? '.content-area{float:right;}': '';

		// Background patter and image settings.
		$bg_settings = get_theme_mod( 'background_option', ByteGazette::DEFAULT_BACKGROUND_OPTION );

		if ( 'pattern' === $bg_settings ) {

			$bytegazette_background_pattern = get_theme_mod( 'background_pattern', ByteGazette::DEFAULT_BACKGROUND_PATTERN );

			if ( $pattern != '' ) {
				$theme_css .= 'body{background:url(' . esc_url( $bytegazette_background_pattern ) . ') repeat top left;}';
			}

		} elseif ( 'custom_image' === $bg_settings ) {

			// BG repeat
			$bg_repeat = get_theme_mod( 'background_repeat', ByteGazette::DEFAULT_BACKGROUND_REPEAT );
			if ( $bg_repeat != '' ) {
				$theme_css .= 'body{background-repeat:'. esc_attr( $bg_repeat ) .';}';
			}

			// BG size
			$bg_size = get_theme_mod( 'background_size', ByteGazette::DEFAULT_BACKGROUND_SIZE );
			if ( $bg_size != '' ) {
				$theme_css .= 'body{background-size:'. esc_attr( $bg_size ) .';}';
			}

			// BG attachment
			$bg_attach = get_theme_mod( 'background_attach', ByteGazette::DEFAULT_BACKGROUND_ATTACHMENT );
			if ( $bg_attach != '' ) {
				$theme_css .= 'body{background-attachment:'. esc_attr( $bg_attach ) .';}';
			}

			// BG position
			$bg_pos = get_theme_mod( 'background_position', ByteGazette::DEFAULT_BACKGROUND_POSITION );
			if ( $bg_pos != '' ) {
				$theme_css .= 'body{background-position:'. esc_attr( $bg_pos ) .';}';
			}
		}

		// Header
		$header_bg_color = get_theme_mod( 'header_bg_color', ByteGazette::DEFAULT_HEADER_BG_COLOR );
		$theme_css .= $header_bg_color != '' ? "#masthead .site-branding{background-color:{$header_bg_color};}" : '';

		// site navigation
		$header_nav_bg_color = get_theme_mod( 'header_nav_bg_color', ByteGazette::DEFAULT_HEADER_NAV_BG_COLOR );
		$theme_css .= $header_nav_bg_color != '' ? "#masthead .main-navigation{background-color:{$header_nav_bg_color};}" : '';

		// Footer
		$bytegazette_footer_upper_bg_color = get_theme_mod( 'footer_upper_bg_color', ByteGazette::DEFAULT_FOOTER_UPPER_BG_COLOR );
		$theme_css .= "footer .site-info, footer .site-info-widgets {background-color:{$bytegazette_footer_upper_bg_color};}";

		$bytegazette_footer_lower_bg_color = get_theme_mod( 'footer_lower_bg_color', ByteGazette::DEFAULT_FOOTER_LOWER_BG_COLOR );
		$theme_css .= "footer .site-footer{background-color:{$bytegazette_footer_lower_bg_color};}";

		$output = '';
		$output .= $theme_css; ?>

	<style type="text/css">
				<?php echo $output ?>
		</style>
<?php }
endif;
add_action( 'wp_head', 'bytegazette_dynamic_css' );
