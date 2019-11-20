<?php
/**
 * Template Name: Full Width
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

if ( is_home() && ! is_paged() ) {
	get_template_part( 'template-parts/sections/featured', 'slideshow' );
	get_template_part( 'template-parts/sections/featured', 'slider' );
}

?>

	<div id="primary" class="content-area full-width">
		<main id="main" class="site-main uk-section-xsmall">

		<?php
		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

			/*
			 * Include the Post-Type-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_type() );

		endwhile;

		if ( is_single() ) :
			previous_post_link( '<div class="left-button">%link</div>', esc_html__( 'Previous Post', 'bytegazette' ) );
			next_post_link( '<div class="right-button">%link</div>', esc_html__( 'Next Post', 'bytegazette' ) );

			if ( $bytegazette_post_author_show ) {
				get_template_part( 'template-parts/sections/post', 'author' );
			}

			if ( $bytegazette_post_related_show ) {
				get_template_part( 'template-parts/sections/post', 'related' );
			}
		endif;

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
