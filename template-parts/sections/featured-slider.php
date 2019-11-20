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

$bytegazette_featured_posts          = bytegazette_featured_posts();
$bytegazette_featured_excerpt_length = get_theme_mod( 'featured_excerpt_length', ByteGazette::DEFAULT_FEATURED_EXCERPT_LENGTH );
?>

<?php if ( $bytegazette_featured_posts->have_posts() ) : ?>

	<section class="bytegazette-featured-slider uk-section uk-section-xsmall">
		<h4 class="uk-heading-line uk-text-bold"><span><?php esc_html_e( 'Featured', 'bytegazette' ); ?></span></h4>
		<div class="slider-container">
					<?php

					while ( $bytegazette_featured_posts->have_posts() ) :
						$bytegazette_featured_posts->the_post();

						?>
								<div class="uk-card uk-card-small uk-card-body">
									<div class="minicard">

										<div class="media">
											<img class="attachment-featured wp-post-image" src="<?php echo esc_url( bytegazette_images_loading() ); ?>" data-src="<?php bytegazette_the_thumbnail_url( get_the_ID(), 'featured-list' ); ?>" alt="<?php the_title_attribute(); ?>" class="lazy" data-uk-img>
										</div>

										<div class="text">
											<h3 class="">
												<?php the_title( '<a class="uk-link-reset" title="" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' ); ?>
											</h3>
											<p class="uk-margin-small"><?php echo wp_kses_post( bytegazette_truncate_string( get_the_excerpt(), $bytegazette_featured_excerpt_length, 'words' ) ); ?></p>
										</div>

									</div>
								</div>
					<?php endwhile; ?>

		</div>
	</section>

<?php endif; ?>
