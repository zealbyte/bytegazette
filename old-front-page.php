<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Byte_Gazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_sidebar_layout      = bytegazette_get_sidebar_layout();
$bytegazette_sidebar_width_class = bytegazette_get_sidebar_width_class();
$bytegazette_main_width_class    = bytegazette_get_main_width_class();
$bytegazette_home_display        = get_theme_mod( 'home_display', ByteGazette::DEFAULT_HOME_DISPLAY );

get_header();

if ( is_home() && ! is_paged() ) {
	get_template_part( 'template-parts/sections/featured', 'slideshow' );
	get_template_part( 'template-parts/sections/featured', 'slider' );
}
?>

<?php if ( is_home() && ! is_front_page() ) : ?>
	<header class="page-header">
		<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
	</header>
<?php endif; ?>

<div id="content-area">

	<?php if ( 'left' === $bytegazette_sidebar_layout ) : ?>
		<aside class=" <?php echo esc_attr( $bytegazette_sidebar_width_class ); ?>">
			<?php get_sidebar(); ?>
		</aside>
	<?php endif; ?>

	<main id="main" class="site-main <?php echo esc_attr( $bytegazette_main_width_class ); ?>">

		<section id="posts" class="uk-section uk-section-small uk-preserve-color">
			<div id="primary" class="uk-container-expand">
				<div class="post-<?php echo esc_attr( $bytegazette_home_display ); ?> uk-child-width-1-2@m">
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
							get_template_part( 'template-parts/content', get_post_type() );

						endwhile;

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>
				</div><!-- #primary -->

				<?php bytegazette_the_posts_pagination(); ?>

			</div>
		</section><!-- #posts -->

	</main><!-- #main -->

	<?php if ( 'right' === $bytegazette_sidebar_layout ) : ?>
		<aside class=" <?php echo esc_attr( $bytegazette_sidebar_width_class ); ?>">
			<?php get_sidebar(); ?>
		</aside>
	<?php endif; ?>

</div><!-- #content-area -->

<?php
get_footer();
