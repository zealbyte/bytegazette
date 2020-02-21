<?php
/**
 * The template for displaying all single posts.
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_prev_next_show    = get_theme_mod( 'post_next_prev', ByteGazette::POST_NEXT_PREV ) ? true : false;
$bytegazette_post_author_show  = get_theme_mod( 'post_author_box', ByteGazette::POST_AUTHOR_BOX ) ? true : false;
$bytegazette_post_related_show = get_theme_mod( 'post_related', ByteGazette::POST_RELATED ) ? true : false;

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

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

		if ( $bytegazette_prev_next_show ) {
			get_template_part( 'template-parts/sections/post', 'links' );
		}

		if ( $bytegazette_post_author_show ) {
			get_template_part( 'template-parts/sections/post', 'author' );
		}

		if ( $bytegazette_post_related_show ) {
			get_template_part( 'template-parts/sections/post', 'related' );
		}

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
