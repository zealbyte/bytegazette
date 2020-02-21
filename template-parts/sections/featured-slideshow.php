<?php
/**
 * The posts slideshow feature.
 *
 * @package Byte_Gazette
 */

$bytegazette_slideshow_posts          = bytegazette_slideshow_posts();
$bytegazette_slideshow_excerpt_length = get_theme_mod( 'slideshow_excerpt_length', ByteGazette::SLIDESHOW_EXCERPT_LENGTH );
?>

<?php if ( $bytegazette_slideshow_posts->have_posts() ) : ?>

	<section>
		<div class="slideshow-container">

				<?php
				$bytegazette_slide_count = 0;

				while ( $bytegazette_slideshow_posts->have_posts() ) :

					$bytegazette_slide_count++;

					$bytegazette_slideshow_posts->the_post();
					?>

					<div class="mySlides fade darken">
						<div class="slide-img attachment-featured wp-post-image loadingimg lazy" data-background-image="<?php bytegazette_the_thumbnail_url( get_the_ID(), 'slide' ); ?>"></div>
						<div class="overlay"></div>
						<div class="text">
							<h2 class="slide-title"><?php the_title(); ?></h2>
							<p><?php echo wp_kses_post( bytegazette_truncate_string( get_the_excerpt(), $bytegazette_slideshow_excerpt_length, 'words' ) ); ?></p>
							<a href="<?php esc_url( get_permalink() ); ?>" class=""><?php esc_html_e( 'Read Article', 'bytegazette' ); ?></a>
						</div>
					</div>

				<?php endwhile; ?>

			<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
			<a class="next" onclick="plusSlides(1)">&#10095;</a>

		</div>

		<br>

		<div style="text-align:center">

			<?php for ( $bytegazette_slide = 1; $bytegazette_slide <= $bytegazette_slide_count; $bytegazette_slide++ ) : ?>

				<span class="dot" data-rel="<?php echo esc_attr( $bytegazette_slide ); ?>"></span>

			<?php endfor; ?>

		</div>

	</section>

<?php endif; ?>
