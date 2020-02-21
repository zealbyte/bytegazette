<?php
/**
 * Template part for displaying post featured image.
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

if ( post_password_required() || is_attachment() ) {
	return;
}

$bytegazette_featured_image_size = 'featured-card';
?>

<?php if ( has_post_thumbnail() ) : ?>

	<div class="featured-image">
		<div class="image-wrapper">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<img class="attachment-featured wp-post-image lazy" src="<?php echo esc_url( bytegazette_images_loading() ); ?>" data-src="<?php bytegazette_the_thumbnail_url( get_the_ID(), $bytegazette_featured_image_size ); ?>" alt="<?php the_title_attribute(); ?>" class="lazy" data-uk-img>
			</a>
		</div>
	</div>

<?php elseif ( 'audio' === get_post_format() ) : ?>

	<div class="featured-audio">
		<div class="audio-wrapper">
			<?php bytegazette_the_featured_audio( get_the_ID() ); ?>
		</div>
	</div>

<?php elseif ( 'video' === get_post_format() ) : ?>

	<div class="featured-video">
		<div class="video-wrapper">
			<?php bytegazette_the_featured_video( get_the_ID() ); ?>
		</div>
	</div>

<?php endif; ?>
