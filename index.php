<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_post_column_style = is_singular() ? 'col s12' : 'col s12 m6 l6';

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

			?>
			<div class="grid">
			<?php

			/* Start the Loop */
			while ( have_posts() ) :

				?>
				<div class="grid-item <?php echo esc_attr( $bytegazette_post_column_style ); ?>">
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
				<div class="empty-item <?php echo esc_attr( $bytegazette_post_column_style ); ?>"></div>
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
