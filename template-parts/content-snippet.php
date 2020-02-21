<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_excerpt_length     = get_theme_mod( 'excerpt_length', ByteGazette::ARCHIVES_EXCERPT_LENGTH );
$bytegazette_post_show_featured = true;
?>

	<div class="post uk-card card-post-thumbnail-left">

		<?php if ( $bytegazette_post_show_featured && ! is_singular() ) : ?>

			<div class="post-thumbnail">

				<?php get_template_part( 'template-parts/post/featured', 'snippet' ); ?>

			</div>

		<?php endif; ?>

		<div class="post-body uk-card-body">

			<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'hentry', 'entry' ) ); ?>>

				<header class="entry-header">

					<!-- Entry Title -->
					<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>

				</header><!-- .entry-header -->

				<!-- Entry Content -->

				<div class="entry-summary">

					<?php echo wp_kses_post( bytegazette_truncate_string( get_the_excerpt(), $bytegazette_excerpt_length, 'words' ) ); ?>

				</div>

			</article>

		</div><!-- .post-body -->

	</div><!-- .post -->

