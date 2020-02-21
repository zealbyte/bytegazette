<?php
/**
 * The featured posts slider feature.
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_title_featured_posts    = bytegazette_get_option( 'title_featured_posts', BYTEGAZETTE_STRING_FEATURED_POSTS );
$bytegazette_featured_posts          = bytegazette_featured_posts();
$bytegazette_featured_excerpt_length = get_theme_mod( 'featured_excerpt_length', ByteGazette::FEATURED_EXCERPT_LENGTH );
?>

<?php if ( $bytegazette_featured_posts->have_posts() ) : ?>

	<section class="bytegazette-featured-slider">
		<h4 class="section-title uk-heading-line"><span><?php echo esc_html( $bytegazette_title_featured_posts ); ?></span></h4>

		<div class="slider-container">
			<div id="featured-slider-slider" class="slider">
					<?php
					while ( $bytegazette_featured_posts->have_posts() ) :

						$bytegazette_featured_posts->the_post();

						get_template_part( 'template-parts/content', 'snippet' );

					endwhile;
					?>
			</div>

			<a class="prev">&#10094;</a>
			<a class="next">&#10095;</a>

		</div>
	</section>

<?php endif; ?>
