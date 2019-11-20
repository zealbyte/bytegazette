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

$bytegazette_excerpt_length     = get_theme_mod( 'excerpt_length', ByteGazette::DEFAULT_ARCHIVES_EXCERPT_LENGTH );
$bytegazette_post_card_style    = is_singular() ? 'post-single' : 'uk-card';
$bytegazette_post_body_style    = is_singular() ? '' : 'uk-card-body';
$bytegazette_post_show_featured = true;
?>

<div class="ccc w3-col s12 m6 l6">
	<div class="post <?php echo esc_attr( $bytegazette_post_card_style ); ?>">

		<?php if ( $bytegazette_post_show_featured && ! is_singular() ) : ?>

			<div class="uk-card-media-top">
				<?php get_template_part( 'template-parts/post/grid', 'featured' ); ?>
			</div>

		<?php endif; ?>

		<div class="post-body <?php echo esc_attr( $bytegazette_post_body_style ); ?>">

			<article class="hentry entry" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<!-- Entry Title -->
				<?php
				if ( is_singular() ) :
					the_title( '<h2 class="entry-title">', '</h2>' );
				else :
					the_title( '<h3 class="entry-title"><a class="uk-link-reset" title="" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
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

				<!-- Entry Content -->
				<?php if ( is_singular() ) : ?>
					<div class="entry-content">
						<?php print_r( get_post_format() ); ?>
						<?php if ( $bytegazette_post_show_featured && ! get_post_format() ) : ?>
							<?php get_template_part( 'template-parts/post/single', 'featured' ); ?>
						<?php endif; ?>
						<?php the_content(); ?>
					</div>
				<?php else : ?>
					<div class="entry-summary">
						<?php echo wp_kses_post( bytegazette_truncate_string( get_the_excerpt(), $bytegazette_excerpt_length, 'words' ) ); ?>
					</div>
					<br>
					<span class="post-format-icon"><?php bytegazette_post_format_icon( get_post_format() ); ?></span>
					<a class="uk-button uk-button-text" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'bytegazette' ); ?></a>
				<?php endif; ?>
			</article>

		</div><!-- .post-body -->

		<?php if ( ! is_singular() ) : ?>
			<footer class="post-footer uk-card-footer">

				<div class="post-meta">
					<span class="post-category"><?php bytegazette_entry_category(); ?></span>
				</div><!-- .post-meta-footer -->

				<div class="post-actions-footer uk-float-right">
					<?php if ( is_singular() ) : ?>
						<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bytegazette' ),
							'after'  => '</div>',
						) );
						?>
					<?php else : ?>
						<?php if ( comments_open() ) : ?>
							<span uk-icon="comments"></span> <?php bytegazette_entry_comments(); ?>
						<?php endif; ?>
					<?php endif; ?>

					<?php get_template_part( 'template-parts/post/single', 'actions' ); ?>
				</div><!-- .post-actions-footer -->

			</footer><!-- .post-footer-->
		<?php endif; ?>

	</div><!-- .post -->
</div>
