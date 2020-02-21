<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_front_layout      = get_theme_mod( 'front_layout', ByteGazette::CONTENT_LAYOUT );
$bytegazette_post_column_style = 'list' === $bytegazette_front_layout || is_singular() ? 's12' : 's12 m6 l6';

get_header();

if ( ! is_paged() ) {
	get_template_part( 'template-parts/sections/featured', 'slideshow' );
	get_template_part( 'template-parts/sections/featured', 'slider' );
}
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) :

			?>
			<div class="<?php echo esc_attr( $bytegazette_front_layout ); ?>">
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
