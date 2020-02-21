<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_content_layout    = get_theme_mod( 'content_layout', ByteGazette::CONTENT_LAYOUT );
$bytegazette_post_column_style = 'list' === $bytegazette_content_layout || is_singular() ? 's12' : 's12 m6 l6';

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div class="<?php echo esc_attr( $bytegazette_content_layout ); ?>">

				<?php
				/* Start the Loop */
				while ( have_posts() ) :

					?>
					<div class="grid-item col <?php echo esc_attr( $bytegazette_post_column_style ); ?>">
					<?php

					the_post();

					/*
					 * Include the Post-Type-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_type() );

					?>
					</div>
					<?php

				endwhile;

				?>
				<div class="empty-item col <?php echo esc_attr( $bytegazette_post_column_style ); ?>"></div>
			</div>
				<?php

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->

		<?php bytegazette_the_posts_pagination(); ?>

	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
