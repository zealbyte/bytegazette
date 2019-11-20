
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			bytegazette_posted_on();
			bytegazette_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php bytegazette_post_thumbnail(); ?>

	<div class="entry-summary">
		<?php echo wp_kses_post( bytegazette_truncate_string( get_the_excerpt(), $bytegazette_excerpt_length, 'words' ) ); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php bytegazette_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
