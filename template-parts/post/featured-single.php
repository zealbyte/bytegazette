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

$bytegazette_featured_image_size = 'featured-image';
?>

<?php if ( 'audio' === get_post_format() ) : ?>

	<div class="post-featured audio">
		<div class="audio-wrapper">
			<?php bytegazette_the_featured_audio( get_the_ID() ); ?>
		</div>
	</div>

<?php elseif ( 'video' === get_post_format() ) : ?>

	<div class="post-featured video">
		<div class="video-wrapper">
			<?php bytegazette_the_featured_video( get_the_ID() ); ?>
		</div>
	</div>

<?php elseif ( has_post_thumbnail() ) : ?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

<?php endif; ?>
