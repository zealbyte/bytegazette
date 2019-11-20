<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Byte_Gazette
 */

/*
This file is part of the Byte Gazette theme for WordPress.

Byte Gazette is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

Byte Gazette is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Byte Gazette.  If not, see <http://www.gnu.org/licenses/>.

Copyright 2018 ZealByte.
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

if ( ! function_exists( 'bytegazette_slideshow_posts' ) ) :
	/**
	 * Generate list of featured slideshow posts using tag.
	 *
	 * @param string $tag The tag to use to query for featured posts.
	 * @param int    $count The number of posts to get.
	 * @return WP_Query The featured posts to show.
	 */
	function bytegazette_slideshow_posts( $tag = null, $count = null ) {
		$tag = (bool) $tag ? $tag : get_theme_mod( 'slideshow_posts_tag', ByteGazette::DEFAULT_SLIDESHOW_POSTS_TAG );
		$num = (bool) $count ? $count : get_theme_mod( 'slideshow_posts_count', ByteGazette::DEFAULT_SLIDESHOW_POSTS_COUNT );

		return bytegazette_featured_posts( $tag, $num );
	}
endif;

if ( ! function_exists( 'bytegazette_featured_posts' ) ) :
	/**
	 * Generate list of featured posts using featured tag and category.
	 *
	 * @param string $tag The tag to use to query for featured posts.
	 * @param int    $count The number of posts to get.
	 * @return WP_Query The featured posts to show.
	 */
	function bytegazette_featured_posts( $tag = null, $count = null ) {
		$tag = (bool) $tag ? $tag : get_theme_mod( 'featured_posts_tag', ByteGazette::DEFAULT_FEATURED_POSTS_TAG );
		$num = (bool) $count ? $count : get_theme_mod( 'featured_posts_count', ByteGazette::DEFAULT_FEATURED_POSTS_COUNT );

		$args = array(
			'tag'            => (string) $tag,
			'posts_per_page' => (int) $num,
		);

		if ( is_archive() ) {
			switch ( true ) {
				case is_author():
					$author         = get_the_author_meta( 'ID' );
					$args['author'] = $author;
					break;
				case is_category():
					$cat         = get_category( get_query_var( 'cat' ) );
					$args['cat'] = $cat->cat_ID;
					break;
				case is_tag():
					$tag_id         = get_queried_object()->term_id;
					$args['tag_id'] = $tag_id;
					break;
				case is_date():
					$year     = get_query_var( 'year' );
					$monthnum = get_query_var( 'monthnum' );
					$day      = get_query_var( 'day' );

					if ( $year ) {
						$args['year'] = $year;
					}

					if ( $month ) {
						$args['monthnum'] = $monthnum;
					}

					if ( $day ) {
						$args['day'] = $day;
					}
					break;
			}
		}

		return new WP_Query( $args );
	}
endif;

if ( ! function_exists( 'bytegazette_related_posts' ) ) :
	/**
	 * Get related posts for current post.
	 *
	 * @return WP_Query The related posts to show.
	 */
	function bytegazette_related_posts() {
		$post_id = get_the_ID();
		$method  = get_theme_mod( 'post_related_method', ByteGazette::DEFAULT_POST_RELATED_METHOD );
		$count   = (int) get_theme_mod( 'post_related_count', ByteGazette::DEFAULT_POST_RELATED_COUNT );

		if ( ByteGazette::DEFAULT_POST_RELATED_MAX < $bytegazette_post_related_count ) {
			$bytegazette_post_related_count = ByteGazette::DEFAULT_POST_RELATED_MAX;
		}

		$ids  = array();
		$args = array(
			'posts_per_page'      => $count,
			'ignore_sticky_posts' => 1,
			'orderby'             => 'modified',
		);

		if ( $post_id ) {
			$args['post__not_in'] = array( $post_id );
		}

		if ( 'categories' === $method ) {
			$arg   = 'category__in';
			$terms = get_the_category( $post_id );
		} else {
			$arg   = 'tag__in';
			$terms = wp_get_post_tags( $post_id );
		}

		foreach ( $terms as $term ) {
			array_push( $ids, $term->term_id );
		}

		$args[ $arg ] = $ids;

		return new WP_Query( $args );
	}
endif;

if ( ! function_exists( 'bytegazette_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function bytegazette_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'bytegazette' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'bytegazette_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function bytegazette_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'bytegazette' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'bytegazette_images_loading' ) ) :
	/**
	 * Return the loading image url.
	 */
	function bytegazette_images_loading() {
		return get_template_directory_uri() . '/assets/img/images-loading.png';
	}
endif;

if ( ! function_exists( 'bytegazette_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function bytegazette_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			//$categories_list = get_the_category_list( esc_html__( ', ', 'bytegazette' ) );
			//if ( $categories_list ) {
				/* translators: 1: list of categories. */
				//printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'bytegazette' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			//}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'bytegazette' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'bytegazette' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'bytegazette' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'bytegazette' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'bytegazette_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function bytegazette_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

/**
 * Time ago formatter function
 *
 * @param DateTime $date The date to be compared to current date.
 */
function bytegazette_time_ago( DateTime $date ) {

	// Array of time period chunks
	$chunks = array(
		array( 60 * 60 * 24 * 365, esc_html__( 'year', 'bytegazette' ), esc_html__( 'years', 'bytegazette' ) ),
		array( 60 * 60 * 24 * 30, esc_html__( 'month', 'bytegazette' ), esc_html__( 'months', 'bytegazette' ) ),
		array( 60 * 60 * 24 * 7, esc_html__( 'week', 'bytegazette' ), esc_html__( 'weeks', 'bytegazette' ) ),
		array( 60 * 60 * 24, esc_html__( 'day', 'bytegazette' ), esc_html__( 'days', 'bytegazette' ) ),
		array( 60 * 60, esc_html__( 'hour', 'bytegazette' ), esc_html__( 'hours', 'bytegazette' ) ),
		array( 60, esc_html__( 'minute', 'bytegazette' ), esc_html__( 'minutes', 'bytegazette' ) ),
		array( 1, esc_html__( 'second', 'bytegazette' ), esc_html__( 'seconds', 'bytegazette' ) ),
	);

	/*
	if ( !is_numeric( $date ) ) {
		$time_chunks = explode( ':', str_replace( ' ', ':', $date ) );
		$date_chunks = explode( '-', str_replace( ' ', '-', $date ) );
		$date = gmmktime( (int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0] );
	}

	$current_time = current_time( 'mysql', $gmt = 0 );
	$newer_date = strtotime( $current_time );

	// Difference in seconds
	$since = $newer_date - $date;

	// Something went wrong with date calculation and we ended up with a negative date.
	if ( 0 > $since )
		return esc_html__( 'sometime', 'bytegazette' );

	//Step one: the first chunk
	for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
		$seconds = $chunks[$i][0];

		// Finding the biggest chunk (if the chunk fits, break)
		if ( ( $count = floor($since / $seconds) ) != 0 )
			break;
	}

	// Set output var
	$output = ( 1 == $count ) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];


	if ( !(int)trim($output) ){
		$output = '0 ' . esc_html__( 'seconds', BYTEGAZETTE_THEME_DOMAIN );
	}

	$output .= esc_html__( ' ago', BYTEGAZETTE_THEME_DOMAIN );
	return $output;
	 */

	return $date->format('c');
}

if ( ! function_exists( 'bytegazette_the_posts_pagination' ) ) :
	/**
	 * Show pagination links for archive pages.
	 */
	function bytegazette_the_posts_pagination() {
		$args = array(
			'show_all'           => false,
			'end_size'           => 1,
			'mid_size'           => 2,
			'prev_next'          => true,
			'prev_text'          => '<span uk-pagination-previous></span>',
			'next_text'          => '<span uk-pagination-next></span>',
			'type'               => 'array',
			'add_fragment'       => '',
			'before_page_number' => '',
			'after_page_number'  => '',
		);

		$pages = paginate_links( $args );

		if ( is_array( $pages ) ) {
			echo '<div class="nav-pagination uk-margin-top"><hr><ul class="uk-pagination uk-flex-center">';

			foreach ( $pages as $page ) {
				printf( '<li>%s</li>', $page );
			}

			echo '</ul></div>';
		}
	}
endif;


/**
 * Display Thumbnail/Featured image.
 *
 * @param int    $post_id The id of the post to retrieve the thumbnail from.
 * @param string $size The name of the size of thumbnail to obtain.
 */
function bytegazette_the_thumbnail_url( $post_id, $size = 'featured-image' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );
		$image = $image[0];
	} else {
		$image = get_template_directory_uri() . "/assets/img/nothumb-$size.jpg";
	}

	echo esc_url( $image );
}

/**
 * Get the featured video for a post.
 *
 * @param string $post_id The post_id to find the video for.
 */
function bytegazette_the_featured_video( $post_id ) {
	static $video_strings = array(
		'video',
		'youtube',
		'vimeo',
		'dailymotion',
		'wordPress.tv',
		'hulu',
	);

	bytegazette_get_first_embed_media( $post_id, $video_strings );
}

/**
 * Get the featured audio for a post.
 *
 * @param string $post_id The post_id to find the audio for.
 */
function bytegazette_the_featured_audio( $post_id ) {
	static $audio_strings = array(
		'audio',
		'mixcloud',
		'rdio',
		'soundcloud',
		'spotify',
	);

	bytegazette_get_first_embed_media( $post_id, $audio_strings );
}

/**
 * Get the featured embedded media from a post.
 *
 * @param string $post_id The post_id to find the embedded media for.
 * @param array  $embed_strings An array of strings to search the embeds for.
 */
function bytegazette_get_first_embed_media( $post_id, array $embed_strings ) {
	$content = do_shortcode( apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) ) );
	$embeds  = get_media_embedded_in_content( $content );

	if ( ! empty( $embeds ) ) {
		foreach ( $embeds as $embed ) {
			foreach ( $embed_strings as $embed_string ) {
				if ( strpos( $embed, $embed_string ) ) {
					echo $embed;
				}
			}
		}
	}
}

// Display post format icon
if ( !function_exists( 'bytegazette_post_format_icon' ) ) {
	function bytegazette_post_format_icon( $format = 'format' ) {
		if ( 'audio' === $format ) {
			$icon = '<span uk-icon="microphone"></span>';
		} elseif ( 'video' === $format ) {
			$icon = '<span uk-icon="video-camera"></span>';
		} else {
			$icon = '<span uk-icon="code"></span>';
		}

		echo $icon;
	}
}

if ( ! function_exists( 'bytegazette_entry_sticky' ) ) {
	function bytegazette_entry_sticky() {
		if ( is_sticky() ) {
			print( '<div class="featured"><i class="material-icons">star_rate</i></div>' );
		}
	}
}

if ( ! function_exists( 'bytegazette_entry_category' ) ) {
	/**
	 * Display HTML with meta information for Category.
	 */
	function bytegazette_entry_category() {
		$categories = get_the_category();

		if ( ! empty( $categories ) ) {
			printf( '<a href="%s">%s</a>', esc_url( get_category_link( $categories[0]->term_id ) ), esc_html( $categories[0]->name ) );
		}
	}
}

// Display HTML with meta information for Tags.
if ( ! function_exists( 'bytegazette_entry_tags' ) ) {
	function bytegazette_entry_tags() {

		if ( 'post' == get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'bytegazette' ) );
			if ( $tags_list ) {
				printf( '<span class="thetags"><i class="material-icons">label</i>'. esc_html__( '%1$s', 'bytegazette' ) .'</span>', $tags_list );
			}
		}
	}
}

// Display HTML with meta information for the current post-date/time.
if ( ! function_exists( 'bytegazette_posted' ) ) {
	function bytegazette_posted() {

		global $post;

		$format = get_theme_mod( 'date_format', 'ago' );

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {

			$pattern = '<time class="entry-date published" datetime="%1$s" style="display:none;">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';

			// Readable dates
			$date = $format == 'ago'? bytegazette_time_ago( new DateTime( get_post_time( 'c', true, $post ) ) ): esc_html( get_the_date() );
			$modified_date = $format == 'ago'? bytegazette_time_ago( new DateTime( get_post_modified_time( 'c', true, $post ) ) ): esc_html( get_the_modified_date() );

			$date_string = sprintf( $pattern,
				esc_attr( get_the_date( 'c' ) ),
				$date,
				esc_attr( get_the_modified_date( 'c' ) ),
				$modified_date
			);

		} else {

			$pattern = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

			// Readable date
			$date = $format == 'ago' ? bytegazette_time_ago( new DateTime( get_post_time( 'c', true, $post ) ) ): esc_html( get_the_date() );

			$date_string = sprintf( $pattern,
				esc_attr( get_the_date( 'c' ) ),
				$date
			);
		}

		$posted = sprintf(
			_x( '%s', 'post date', 'bytegazette' ),
			$date_string
		);

		echo $posted;
	}
}

if ( ! function_exists( 'bytegazette_get_sidebar_layout' ) ) :
	/**
	 * Get the sidebar class as per configured sidebar location.
	 */
	function bytegazette_get_sidebar_layout() {
		$sidebar_layout = get_theme_mod( 'sidebar_layout', ByteGazette::DEFAULT_SIDEBAR_LAYOUT );

		if ( is_home() ) {
			$sidebar_layout = get_theme_mod( 'sidebar_layout_home', $sidebar_layout );
		} elseif ( is_singular() ) {
			$sidebar_layout = get_theme_mod( 'sidebar_layout_singular', $sidebar_layout );
		} elseif ( is_archive() ) {
			$sidebar_layout = get_theme_mod( 'sidebar_layout_archive', $sidebar_layout );
		}

		if ( in_array( $sidebar_layout, array( 'left', 'right', 'none' ), true ) ) {
			return $sidebar_layout;
		}

		return ByteGazette::DEFAULT_SIDEBAR_LAYOUT;
	}
endif;

if ( ! function_exists( 'bytegazette_get_main_width_class' ) ) :
	/**
	 * Get the master width form configured sidebar width.
	 */
	function bytegazette_get_main_width_class() {
		$sidebar_width = bytegazette_get_sidebar_width();

		switch ( $sidebar_width ) {
			case '1_2':
				return 'uk-width-1-2@m';
			case '1_3':
				return 'uk-width-2-3@m';
			case '1_4':
				return 'uk-width-3-4@m';
			case '1_6':
				return 'uk-width-5-6@m';
		}

		return '';
	}
endif;

if ( ! function_exists( 'bytegazette_get_sidebar_width_class' ) ) :
	/**
	 * Get the sidebar width form configured sidebar width.
	 */
	function bytegazette_get_sidebar_width_class() {
		$sidebar_width = bytegazette_get_sidebar_width();

		switch ( $sidebar_width ) {
			case '1_2':
				return 'uk-width-1-2@m';
			case '1_3':
				return 'uk-width-1-3@m';
			case '1_4':
				return 'uk-width-1-4@m';
			case '1_6':
				return 'uk-width-1-6@m';
		}

		return '';
	}
endif;

if ( ! function_exists( 'bytegazette_get_sidebar_width' ) ) :
	/**
	 * Get the sidebar width as configured.
	 */
	function bytegazette_get_sidebar_width() {
		$sidebar_width = get_theme_mod( 'sidebar_layout', ByteGazette::DEFAULT_SIDEBAR_WIDTH );

		if ( in_array( $sidebar_width, array( '1_2', '1_3', '1_4', '1_6' ), true ) ) {
			return $sidebar_width;
		}

		return ByteGazette::DEFAULT_SIDEBAR_WIDTH;
	}
endif;

if ( ! function_exists( 'bytegazette_entry_author' ) ) {
	/**
	 * Display HTML with meta information for Author.
	 */
	function bytegazette_entry_author() {

		if ( 'post' === get_post_type() ) {

			printf(
				// translator: post author.
				_x( '%s', 'post author', 'bytegazette' ),
				'<span class="author vcard"><span class="url fn"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span></span>'
			);
		}
	}
}

if ( ! function_exists( 'bytegazette_entry_comments' ) ) {
	/**
	 * Display HTML with meta information for Comments number.
	 */
	function bytegazette_entry_comments() {
		if ( 'post' === get_post_type() ) {
			printf( '<span>%s</span>', esc_attr( get_comments_number() ) );
		}
	}
}

// Truncate string to x letters/words
if ( ! function_exists( 'bytegazette_truncate_string' ) ) {
	function bytegazette_truncate_string( $str, $length = 40, $units = 'letters', $ellipsis = '&nbsp;&hellip;' ) {

		if ( $units == 'letters' ) {

			if ( mb_strlen( $str ) > $length ) {
				return mb_substr( $str, 0, $length ) . $ellipsis;
			} else {
				return $str;
			}

		} else {

			$words = explode( ' ', $str );

			if ( count( $words ) > $length ) {
				return implode( " ", array_slice( $words, 0, $length ) ) . $ellipsis;
			} else {
				return $str;
			}
		}
	}
}

// Display breadcrumb
if ( !function_exists( 'bytegazette_breadcrumb' ) ) {
	function bytegazette_breadcrumb() {

		// Separator, change this if you want to change breadcrumb items separator
		$sep = esc_html__( '/', 'bytegazette' ); ?>

		<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">

			<div typeof="v:Breadcrumb" class="root">
				<a rel="v:url" property="v:title" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php esc_html_e( 'Home', 'bytegazette' ); ?>
				</a>
			</div>

			<div><?php echo $sep; ?></div>

			<?php if ( is_category() || is_single() ) { ?>

			<?php $categories = get_the_category();
		if ( $categories ) { ?>

					<div typeof="v:Breadcrumb">
						<a href="<?php echo get_category_link( $categories[0]->term_id ); ?>" rel="v:url" property="v:title">
							<?php echo $categories[0]->cat_name; ?>
						</a>
					</div>
					<div><?php echo $sep; ?></div>

				<?php } ?>

				<?php if ( is_single() ) { ?>
					<div typeof='v:Breadcrumb'>
						<span property='v:title'><?php the_title(); ?></span>
					</div>
				<?php } ?>

			<?php } else if ( is_page() ) { ?>

				<div typeof='v:Breadcrumb'><span property='v:title'>
					<?php the_title(); ?>
				</span></div>

			<?php } ?>

		</div>
		<?php }
}

