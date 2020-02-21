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
						<?php get_template_part( 'template-parts/layout/footer', 'info' ); ?>
					</div>
				</div>

				<?php if ( is_active_sidebar( 'footer-columns' ) ) : ?>
					<div class="site-info-widgets">
						<div class="container">
							<?php dynamic_sidebar( 'footer-columns' ); ?>
						</div>
					</div>
				<?php endif; ?>

				<div id="footer-navigation" class="site-footer">
					<div class="section section-xlarge container">
						<?php get_template_part( 'template-parts/layout/footer', 'navigation' ); ?>
					</div>
				</div><!-- #colophon -->

			</footer>
		</div><!-- #page -->

		<?php wp_footer(); ?>

	</body>
</html>
