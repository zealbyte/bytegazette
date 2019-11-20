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

$bytegazette_excerpt_length = get_theme_mod( 'excerpt_length', ByteGazette::DEFAULT_ARCHIVES_EXCERPT_LENGTH );
?>

<div class="uk-card uk-card-body uk-flex uk-flex-middle uk-card-default">
	<div class="uk-grid uk-grid-medium uk-flex uk-flex-middle" data-uk-grid>

		<div class="uk-width-1-3@s uk-width-2-5@m uk-height-1-1">
			<img class="attachment-featured wp-post-image" src="" data-src="<?php bytegazette_the_thumbnail_url( get_the_ID(), 'featured-list' ); ?>" alt="<?php the_title_attribute(); ?>" class="lazy" data-uk-img>
		</div>

		<div class="uk-width-2-3@s uk-width-3-5@m">
			<h3 class="entry-title uk-card-title uk-margin-small-top uk-margin-remove-bottom">
				<?php the_title( '<a class="uk-link-reset" title="" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' ); ?>
			</h3>
			<div class="entry-meta">
				<?php
				bytegazette_posted_on();
				bytegazette_posted_by();
				?>
			</div><!-- .entry-meta -->
			<p class="uk-margin-small"><?php echo wp_kses_post( bytegazette_truncate_string( get_the_excerpt(), $bytegazette_excerpt_length, 'words' ) ); ?></p>
		</div>

	</div>
</div>

