<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Byte_Gazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}
?>

<div class="page">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bytegazette' ),
				'after'  => '</div>',
			) );
			?>
		</footer>

	</article><!-- #post-## -->
</div>
