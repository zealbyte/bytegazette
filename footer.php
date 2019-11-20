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
?>
			</div><!-- #content -->

			<footer id="colophon">

				<div class="site-info">
					<div class="container">
						<?php get_template_part( 'template-parts/layout/footer', 'widget-area' ); ?>
					</div>
				</div>

				<?php if ( is_active_sidebar( 'footer-columns' ) && ! ( 'no_sidebar' === get_theme_mod( 'bytegazette_sidebar_layout', ByteGazette::DEFAULT_SIDEBAR_LAYOUT ) ) ) : ?>
					<div class="site-info-widgets">
						<div class="container">
							<?php dynamic_sidebar( 'footer-columns' ); ?>
						</div>
					</div>
				<?php endif; ?>

				<div id="footer-navigation" class="site-footer">
					<div class="container uk-section">
						<?php get_template_part( 'template-parts/layout/footer', 'lower-navigation' ); ?>
					</div>
				</div><!-- #colophon -->

			</footer>
		</div><!-- #page -->

		<?php wp_footer(); ?>
	</body>
</html>
