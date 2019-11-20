<?php
/**
 * The posts slideshow feature.
 *
 * @package Byte_Gazette
 */

$bytegazette_slideshow_posts          = bytegazette_slideshow_posts();
$bytegazette_slideshow_excerpt_length = get_theme_mod( 'slideshow_excerpt_length', ByteGazette::DEFAULT_SLIDESHOW_EXCERPT_LENGTH );
?>

<?php if ( $bytegazette_slideshow_posts->have_posts() ) : ?>

	<section class="uk-section-xsmall">
		<div class="slideshow-container">

				<?php

				while ( $bytegazette_slideshow_posts->have_posts() ) :
					$bytegazette_slideshow_posts->the_post();

					?>

					<div class="mySlides fade">
						<div class="numbertext">1 / 3</div>
						<img class="attachment-featured wp-post-image" src="<?php echo esc_url( bytegazette_images_loading() ); ?>" data-src="<?php bytegazette_the_thumbnail_url( get_the_ID(), 'jumbo' ); ?>" alt="<?php the_title_attribute(); ?>">
						<div class="text">
							<h2><?php the_title(); ?></h2>
							<p><?php echo wp_kses_post( bytegazette_truncate_string( get_the_excerpt(), $bytegazette_slideshow_excerpt_length, 'words' ) ); ?></p>
							<a href="<?php esc_url( get_permalink() ); ?>" class="uk-button uk-button-default uk-margin-top"><?php esc_html_e( 'Read Article', 'bytegazette' ); ?></a>
						</div>
					</div>

				<?php endwhile; ?>

			<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
			<a class="next" onclick="plusSlides(1)">&#10095;</a>
		</div>

		<br>

		<div style="text-align:center">
			<span class="dot" onclick="currentSlide(1)"></span>
			<span class="dot" onclick="currentSlide(2)"></span>
			<span class="dot" onclick="currentSlide(3)"></span>
		</div>

	</section>

<?php endif; ?>
