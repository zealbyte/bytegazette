<?php
/**
 * Template part for displaying post's related posts.
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_related_posts          = bytegazette_related_posts();
$bytegazette_related_excerpt_length = get_theme_mod( 'featured_excerpt_length', ByteGazette::DEFAULT_FEATURED_EXCERPT_LENGTH );
$bytegazette_home_display           = get_theme_mod( 'home_display', ByteGazette::DEFAULT_HOME_DISPLAY );
?>

<?php if ( $bytegazette_related_posts->have_posts() ) : ?>

	<section class="uk-section-xsmall">
		<h4 class="uk-heading-line uk-text-bold"><span><?php esc_html_e( 'Related Posts', 'bytegazette' ); ?></span></h4>

		<div class="post-<?php echo esc_attr( $bytegazette_home_display ); ?> uk-child-width-1-2@m">
			<?php

			while ( $bytegazette_related_posts->have_posts() ) :
				$bytegazette_related_posts->the_post();
				?>
				<div>
					<div class="uk-card uk-card-default">
						<div class="uk-card-media-top">
							<?php get_template_part( 'template-parts/post/grid', 'featured' ); ?>
						</div>
						<div class="uk-card-body">
							<h3 class="uk-card-title uk-margin-small-top uk-margin-remove-bottom">
								<?php the_title( '<a class="uk-link-reset" title="" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' ); ?>
							</h3>
							<p class="uk-margin-small"><?php echo wp_kses_post( bytegazette_truncate_string( get_the_excerpt(), $bytegazette_related_excerpt_length, 'words' ) ); ?></p>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>

	</section>

<?php endif; ?>
