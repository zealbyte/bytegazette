<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package realistic
 */

get_header();

$bytegazette_page_class = 'no_sidebar' === get_theme_mod( 'sidebar_layout', ByteGazette::DEFAULT_SIDEBAR_LAYOUT ) ? 'mdl-cell mdl-cell--12-col-desktop' : 'mdl-cell mdl-cell--9-col-desktop';
?>

<div id="primary" class="content-area <?php echo $bytegazette_page_class; ?> uk-section uk-section-default">
	<main id="main" class="site-main" role="main">

		<?php if ( get_theme_mod( 'post_breadcrumb', '1' ) ) {
			bytegazette_breadcrumb();
		} ?>

		<header class="entry-header">
			<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
		</header><!-- .entry-header -->


		<div id="content-grid" class="uk-grid" data-ukgrid>
			<div id="post" class="uk-width-2-3@m">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile;
				?>
			</div>

			<div class="uk-width-1-3@m">
				<?php get_sidebar(); ?>
			</div>

		</div><!-- /#content-grid -->
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
