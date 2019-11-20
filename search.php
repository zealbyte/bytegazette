<?php
/**
 * The template for displaying search results pages.
 *
 * @package realistic
 */

get_header();

$bytegazette_single_class = 'no_sidebar' === get_theme_mod( 'sidebar_layout', ByteGazette::DEFAULT_SIDEBAR_LAYOUT ) ? 'mdl-cell mdl-cell--12-col-desktop' : 'mdl-cell mdl-cell--9-col-desktop';
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main uk-section-xsmall">

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'bytegazette' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->


			<?php
add_filter( 'bbp_get_search_terms', function ( $search_terms, $passed_terms ) {
	return get_search_query();
}, 1, 2 );

//if ( bbp_search_query() ) {
while ( bbp_search_results() ) {
	echo 'hi';
}
//}
?>


			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Type-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );

				endwhile;

				bytegazette_the_posts_pagination();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
