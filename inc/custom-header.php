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
 * @package bytegazette
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
		$bytegazette_header_text_color       = get_header_textcolor();
		$bytegazette_header_background_image = header_image();

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Are we showing the header text? If so, apply the header text color.
		if ( display_header_text() ) :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $bytegazette_header_text_color ); ?>;
			}
			<?php
		else :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php endif; ?>

		<?php if ( $header_background_image ) : ?>
			.main-banner {
				background-image: url('<?php esc_url( $bytegazette_header_background_image ); ?>');
				height: <?php echo esc_attr( get_custom_header()->height ); ?>px;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

if ( ! function_exists( 'bytegazette_custom_colors' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 */
	function bytegazette_custom_colors() {
		?>
		<style>
			body {
				color: <?php echo esc_attr( get_theme_mod( 'body_fg_color', ByteGazette::BODY_FG_COLOR ) ); ?>;
				background-color: <?php echo esc_attr( ByteGazette::BODY_BG_COLOR ); ?>;
			}

			a {
				color: <?php echo esc_attr( get_theme_mod( 'link_fg_color', ByteGazette::LINK_FG_COLOR ) ); ?>;
			}

			h1, h2, h3, h4, h5, h6,
			h1 > a, h2 > a, h3 > a, h4 > a, h5 > a, h6 > a,
			h1 > a:hover, h2 > a:hover, h3 > a:hover, h4 > a:hover, h5 > a:hover, h6 > a:hover {
				color: <?php echo esc_attr( get_theme_mod( 'heading_fg_color', ByteGazette::HEADING_FG_COLOR ) ); ?>;
			}

			em, code, kbd, samp, .required, .required > * {
				color: <?php echo esc_attr( get_theme_mod( 'emphasis_fg_color', ByteGazette::EMPHASIS_FG_COLOR ) ); ?>;
			}

			*, *::before, *::after, hr {
				border-color: <?php echo esc_attr( get_theme_mod( 'border_color', ByteGazette::BORDER_COLOR ) ); ?>;
			}

			.pagination li .current {
				color: <?php echo esc_attr( get_theme_mod( 'link_fg_color', ByteGazette::LINK_FG_COLOR ) ); ?>;
				border-color: <?php echo esc_attr( get_theme_mod( 'link_fg_color', ByteGazette::LINK_FG_COLOR ) ); ?>;
			}

			.pagination li a,
			.pagination li a span,
			.pagination li .dots {
				color: <?php echo esc_attr( get_theme_mod( 'heading_fg_color', ByteGazette::HEADING_FG_COLOR ) ); ?>;
			}

			.pagination svg {
				fill: <?php echo esc_attr( get_theme_mod( 'heading_fg_color', ByteGazette::HEADING_FG_COLOR ) ); ?>;
			}

			.mute, .mute a, .post-info, .post-info a, .comment-meta-item, .comment-meta-item a {
				color: <?php echo esc_attr( get_theme_mod( 'mute_fg_color', ByteGazette::MUTE_FG_COLOR ) ); ?>;
			}

			.even > * {
				background-color: <?php echo esc_attr( get_theme_mod( 'even_bg_color', ByteGazette::EVEN_BG_COLOR ) ); ?>;
			}

			.odd > * {
				background-color: <?php echo esc_attr( get_theme_mod( 'odd_bg_color', ByteGazette::ODD_BG_COLOR ) ); ?>;
			}

			#site-branding {
				background-color: <?php echo esc_attr( get_theme_mod( 'header_bg_color', ByteGazette::HEADER_BG_COLOR ) ); ?>;
			}

			#site-branding a {
				color: <?php echo esc_attr( get_theme_mod( 'header_link_fg_color', ByteGazette::HEADER_LINK_FG_COLOR ) ); ?>;
				text-decoration: none;
			}

			#site-branding .site-title a {
				color: <?php echo esc_attr( get_theme_mod( 'header_title_fg_color', ByteGazette::HEADER_TITLE_FG_COLOR ) ); ?>;
			}

			#site-navigation {
				color: <?php echo esc_attr( get_theme_mod( 'header_nav_fg_color', ByteGazette::HEADER_NAV_FG_COLOR ) ); ?>;
				background-color: <?php echo esc_attr( get_theme_mod( 'header_nav_bg_color', ByteGazette::HEADER_NAV_BG_COLOR ) ); ?>;
			}

			#site-navigation a {
				color: <?php echo esc_attr( get_theme_mod( 'header_nav_link_fg_color', ByteGazette::HEADER_NAV_LINK_FG_COLOR ) ); ?>;
			}

			#site-navigation .menu-item, {
				background-color: <?php echo esc_attr( get_theme_mod( 'header_nav_item_bg_color', ByteGazette::HEADER_NAV_ITEM_BG_COLOR ) ); ?>;
			}

			#site-navigation .menu-item a {
				color: <?php echo esc_attr( get_theme_mod( 'header_nav_item_fg_color', ByteGazette::HEADER_NAV_ITEM_FG_COLOR ) ); ?>;
			}

			#site-navigation li.menu-item.current-menu-item, #site-navigation li.menu-item.current-menu-ancestor {
				background-color: <?php echo esc_attr( get_theme_mod( 'header_nav_item_current_bg_color', ByteGazette::HEADER_NAV_ITEM_CURRENT_BG_COLOR ) ); ?>;
			}

			#site-navigation li.menu-item.current-menu-item > a, #site-navigation li.menu-item.current-menu-ancestor > a {
				color: <?php echo esc_attr( get_theme_mod( 'header_nav_item_current_fg_color', ByteGazette::HEADER_NAV_ITEM_CURRENT_FG_COLOR ) ); ?>;
			}

			#site-navigation .sub-menu {
				background-color: <?php echo esc_attr( get_theme_mod( 'header_subnav_bg_color', ByteGazette::HEADER_SUBNAV_BG_COLOR ) ); ?>;
			}

			#site-navigation .sub-menu .menu-item {
				background-color: <?php echo esc_attr( get_theme_mod( 'header_subnav_item_bg_color', ByteGazette::HEADER_SUBNAV_ITEM_BG_COLOR ) ); ?>;
			}

			#site-navigation .sub-menu .menu-item a {
				color: <?php echo esc_attr( get_theme_mod( 'header_subnav_item_fg_color', ByteGazette::HEADER_SUBNAV_ITEM_FG_COLOR ) ); ?>;
			}

			#site-navigation .sub-menu li.menu-item.current-menu-item, #site-navigation .sub-menu li.menu-item.current-menu-ancestor {
				background-color: <?php echo esc_attr( get_theme_mod( 'header_subnav_item_current_bg_color', ByteGazette::HEADER_SUBNAV_ITEM_CURRENT_BG_COLOR ) ); ?>;
			}

			#site-navigation .sub-menu li.menu-item.current-menu-item > a, #site-navigation .sub-menu li.menu-item.current-menu-ancestor > a {
				color: <?php echo esc_attr( get_theme_mod( 'header_subnav_item_current_fg_color', ByteGazette::HEADER_SUBNAV_ITEM_CURRENT_FG_COLOR ) ); ?>;
			}

			#colophon {
				color: <?php echo esc_attr( get_theme_mod( 'footer_fg_color', ByteGazette::FOOTER_FG_COLOR ) ); ?>;
				background-color: <?php echo esc_attr( get_theme_mod( 'footer_bg_color', ByteGazette::FOOTER_BG_COLOR ) ); ?>;
			}

			#colophon a {
				color: <?php echo esc_attr( get_theme_mod( 'footer_link_fg_color', ByteGazette::FOOTER_LINK_FG_COLOR ) ); ?>;
			}

			#colophon h1, #colophon h2, #colophon h3, #colophon h4, #colophon h5, #colophon h6 {
				color: <?php echo esc_attr( get_theme_mod( 'footer_heading_fg_color', ByteGazette::FOOTER_HEADING_FG_COLOR ) ); ?>;
			}

			#colophon .site-footer {
				color: <?php echo esc_attr( get_theme_mod( 'footer_nav_fg_color', ByteGazette::FOOTER_NAV_FG_COLOR ) ); ?>;
				background-color: <?php echo esc_attr( get_theme_mod( 'footer_nav_bg_color', ByteGazette::FOOTER_NAV_BG_COLOR ) ); ?>;
			}

			#colophon .site-footer a {
				color: <?php echo esc_attr( get_theme_mod( 'footer_nav_link_fg_color', ByteGazette::FOOTER_NAV_LINK_FG_COLOR ) ); ?>;
			}

			#colophon .site-footer h1, #colophon .site-footer h2, #colophon .site-footer h3, #colophon .site-footer h4, #colophon .site-footer h5, #colophon .site-footer h6 {
				color: <?php echo esc_attr( get_theme_mod( 'footer_nav_heading_fg_color', ByteGazette::FOOTER_NAV_HEADING_FG_COLOR ) ); ?>;
			}

			.comment-list li.comment > article.comment-body {
				margin-left: <?php echo ( (int) esc_attr( get_theme_mod( 'comment_avatar_size', ByteGazette::COMMENT_AVATAR_SIZE ) ) + 20 ); ?>px;
			}
		</style>
		<?php
	}
endif;
add_action( 'wp_head', 'bytegazette_custom_colors' );

