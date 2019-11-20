<?php
/**
 * Template part for displaying post actions menu.
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

if ( !current_user_can( 'editor' ) && !current_user_can( 'administrator' ) ) {
	return '';
} ?>

<button id="post-actions-<?php the_ID(); ?>" class="post-actions uk-icon-button uk-margin-small-left" uk-icon="cog"></button>
<div uk-dropdown>
	<ul class="post-actions-menu uk-nav uk-dropdown-nav" for="post-actions-<?php the_ID(); ?>">

		<?php edit_post_link( esc_html__( 'Edit', 'bytegazette' ), '<li>', '</li>' ); ?>

		<?php if ( current_user_can( 'administrator' ) ) {

			$delLink = wp_nonce_url( admin_url() . "post.php?post=" . get_the_ID() . "&action=delete", 'delete-' . get_post_type() . '_' . get_the_ID() ); ?>

			<li>
				<a href="<?php echo $delLink; ?>"><?php esc_html_e( 'Delete', 'bytegazette' ); ?></a>
			</li>

		<?php } ?>

	</ul>
</div>


