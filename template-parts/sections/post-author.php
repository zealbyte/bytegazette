<?php
/**
 * Template part for displaying post's author.
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

if ( ! get_theme_mod( 'author_box', '1' ) ) {
	return '';
}

$bytegazette_title_about_author = bytegazette_get_option( 'title_about_author', BYTEGAZETTE_STRING_ABOUT_AUTHOR );
?>

<section>
	<h4 class="section-title uk-heading-line"><span><?php echo esc_html( $bytegazette_title_about_author ); ?></span></h4>

	<div class="author-box">
		<div class="author-box-wrap">

			<div class="author-avatar col s4 m3 l2">
				<?php echo get_avatar( get_the_author_meta( 'email' ), '120' ); ?>
			</div>

			<div class="author-vcard col s8 m9 l10">

				<h5>
					<?php if ( get_the_author_link() ) : ?>

						<a class="fn" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>"><?php the_author(); ?></a>

					<?php else : ?>

						<strong><?php the_author_meta( 'display_name' ); ?></strong>

					<?php endif; ?>
				</h5>

				<address>
					<a href="mailto:<?php the_author_meta( 'email' ); ?>"><?php the_author_meta( 'email' ); ?></a>
				</address>

			</div>

			<div class="author-description col s12 m9 l10">

				<?php
				if ( get_the_author_meta( 'description' ) ) :

					the_author_meta( 'description' );

				endif;
				?>

			</div>

		</div>
	</div>
</section>
