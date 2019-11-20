<?php
/**
 * Template Name: Forum
 *
 * @package bytegazette
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_sidebar_layout      = bytegazette_get_sidebar_layout();
$bytegazette_sidebar_width_class = bytegazette_get_sidebar_width_class();
$bytegazette_main_width_class    = bytegazette_get_main_width_class();
$bytegazette_show_prev_next      = get_theme_mod( 'next_prev_post', '1' ) ? true : false;
$bytegazette_post_author_show    = get_theme_mod( 'post_related_show', ByteGazette::DEFAULT_POST_RELATED ) ? true : false;
$bytegazette_post_related_show   = get_theme_mod( 'post_related_show', ByteGazette::DEFAULT_POST_RELATED ) ? true : false;

get_header();
?>

	<div id="primary" class="content-area full-width">
		<main id="main" class="site-main uk-section-xsmall">

		<?php
		/* Start the Loop */
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'forum' );
		endwhile;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
