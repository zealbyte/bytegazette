<?php
/**
 * Template part for displaying posts (default style)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bytegazette
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$bytegazette_excerpt_length     = get_theme_mod( 'archives_excerpt_length', ByteGazette::ARCHIVES_EXCERPT_LENGTH );
$bytegazette_post_style         = is_singular() ? 'single' : 'uk-card';
$bytegazette_post_body_style    = is_singular() ? 'single-body' : 'uk-card-body';
$bytegazette_post_show_featured = true;
?>

	<div class="post <?php echo esc_attr( $bytegazette_post_style ); ?>">

		<?php if ( $bytegazette_post_show_featured && ! is_singular() ) : ?>

			<div class="post-thumbnail">

				<?php get_template_part( 'template-parts/post/featured', 'wide' ); ?>

			</div>

		<?php endif; ?>

		<div class="post-body <?php echo esc_attr( $bytegazette_post_body_style ); ?>">

			<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'hentry', 'entry' ) ); ?>>

				<header class="entry-header">

					<!-- Entry Title -->
					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
						edit_post_link( esc_html__( 'Edit', 'bytegazette' ), '<span class="post-edit">', '</span>' );
					else :
						the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
					endif;
					?>

					<!-- Entry Meta -->
					<?php if ( 'post' === get_post_type() ) : ?>

						<p class="post-info">

							<?php
							bytegazette_posted_on();
							bytegazette_posted_by();
							?>

						</p>

					<?php endif; ?>

				</header><!-- .entry-header -->

				<!-- Entry Content -->
				<?php if ( is_singular() ) : ?>

					<div class="entry-content">

						<?php
						if ( $bytegazette_post_show_featured && ! get_post_format() ) :
							get_template_part( 'template-parts/post/featured', 'single' );
						endif;
						?>

						<?php the_content(); ?>

					</div>

				<?php else : ?>

					<div class="entry-summary">

						<?php echo wp_kses_post( bytegazette_truncate_string( get_the_excerpt(), $bytegazette_excerpt_length, 'words' ) ); ?>

					</div>

					<br>

					<a class="mute" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'bytegazette' ); ?></a>

				<?php endif; ?>

			</article>

		</div><!-- .post-body -->

		<?php
		if ( is_singular() ) :

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bytegazette' ),
				'after'  => '</div>',
			) );

		else :
			?>

			<div class="post-footer uk-card-footer">

				<div class="post-meta">

					<span class="post-category"><?php bytegazette_entry_category(); ?></span>

				</div><!-- .post-meta-footer -->

				<div class="post-actions">

					<?php if ( comments_open() ) : ?>

						<span uk-icon="comments"></span> <?php bytegazette_entry_comments(); ?>

					<?php endif; ?>

					<?php edit_post_link( esc_html__( 'Edit', 'bytegazette' ), '<span>', '</span>' ); ?>

				</div><!-- .post-actions -->

			</div><!-- .post-footer-->

			<?php
		endif;
		?>

	</div><!-- .post -->

