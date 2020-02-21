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

$bytegazette_title_related_posts  = bytegazette_get_option( 'title_related_posts', BYTEGAZETTE_STRING_RELATED_POSTS );
$bytegazette_snippet_column_style = 'col s12 m6 l4';
$bytegazette_related_posts        = bytegazette_related_posts();
?>

<?php if ( $bytegazette_related_posts->have_posts() ) : ?>

	<section>
		<h4 class="section-title uk-heading-line"><span><?php echo esc_html( $bytegazette_title_related_posts ); ?></span></h4>

			<div class="grid">

				<div class="empty-item <?php echo esc_attr( $bytegazette_snippet_column_style ); ?>"></div>

				<?php
				while ( $bytegazette_related_posts->have_posts() ) :

					?>
					<div class="grid-item <?php echo esc_attr( $bytegazette_snippet_column_style ); ?>">
					<?php

					$bytegazette_related_posts->the_post();

					get_template_part( 'template-parts/content', 'snippet' );

					?>
					</div>
					<?php

				endwhile;
				?>
		</div>

	</section>

<?php endif; ?>
