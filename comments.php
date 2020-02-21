<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$bytegazette_comment_count      = get_comments_number();
$bytegazette_comment_pagination = get_theme_mod( 'comment_pagination', ByteGazette::COMMENT_PAGINATION );
?>

<section>
	<h4 class="section-title uk-heading-line"><span><?php echo esc_html( bytegazette_get_option( 'title_comments', BYTEGAZETTE_STRING_COMMENTS ) ); ?></span></h4>

	<div id="comments" class="comments-area">

		<?php
		// You can start editing here -- including this comment!
		if ( have_comments() ) :

			if ( in_array( $bytegazette_comment_pagination, array( 'both', 'above' ), true ) ) :

				bytegazette_the_comments_pagination();

			endif;

			bytegazette_list_comments();

			if ( in_array( $bytegazette_comment_pagination, array( 'both', 'below' ), true ) ) :

				bytegazette_the_comments_pagination();

			endif;

			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() ) :
				?>

				<p class="no-comments"><?php echo esc_html( bytegazette_get_option( 'title_comments_closed', BYTEGAZETTE_STRING_COMMENTS_CLOSED ) ); ?></p>

				<?php
			endif;

		endif; // Check for have_comments().

		?>

		<hr>

		<?php

		comment_form( array(
			'title_reply'         => esc_html( bytegazette_get_option( 'title_reply', BYTEGAZETTE_STRING_REPLY ) ),
			'comment_notes_after' => '',
			'label_submit'        => esc_html( bytegazette_get_option( 'action_add_reply', BYTEGAZETTE_STRING_ADD_REPLY ) ),
			'class_submit'        => 'uk-button uk-button-primary',
			'comment_field'       => '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>',
		) );

		?>

	</div><!-- #comments -->
</section>
