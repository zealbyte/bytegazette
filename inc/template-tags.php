<?php
/**
 * Custom template tags for this theme
 *
 * @package bytegazette
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

/**
 * Get an option setting value or default if the setting was not found.
 *
 * @param string $option_name The name of the option to get.
 * @param mixed  $default_value The default value for the option setting.
 * @global $bytegazette_options_settings;
 * @return mixed The setting value or default.
 */
function bytegazette_get_option( $option_name, $default_value = null ) {
	global $bytegazette_options_settings;

	if ( empty( $bytegazette_options_settings ) ) {
		$bytegazette_options_settings = get_option( ByteGazette::OPTIONS_SETTINGS, array() );
	}

	if ( isset( $bytegazette_options_settings[ $option_name ] ) ) {
		return $bytegazette_options_settings[ $option_name ];
	}

	return $default_value;
}

/**
 * Set on option setting value.
 *
 * @param string $option_name The name of the option to set.
 * @param mixed  $value The setting value to set.
 * @global $bytegazette_options_settings;
 * @return bool Weather the setting was modified or not.
 */
function bytegazette_set_option( $option_name, $value ) {
	global $bytegazette_options_settings;

	$old_val = bytegazette_get_option( $option_name );

	if ( $old_val !== $value ) {
		$bytegazette_options_settings[ $option_name ] = $value;

		set_option( ByteGazette::OPTIONS_SETTINGS, $byte_gazette_options_settings );

		return true;
	}

	return false;
}

if ( ! function_exists( 'bytegazette_comment' ) ) :
	/**
	 * Build HTML output of a comment response.
	 *
	 * @param string $comment The comment object.
	 * @param array  $args The arguments supplied by the comments template.
	 * @param int    $depth The depth level of the comment.
	 */
	function bytegazette_comment( $comment, $args, $depth ) {
		// This variable is intended to be written.
		$GLOBALS['comment'] = $comment; // phpcs:ignore

		?>
		<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>" itemscope itemtype="http://schema.org/Comment">

			<figure class="gravatar"><?php echo get_avatar( $comment, $args['avatar_size'] ); ?></figure>

			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

				<footer class="comment-footer">

					<div class="comment-metadata">

						<time class="comment-meta-item" datetime="<?php comment_date( 'Y-m-d' ); ?>T<?php comment_time( 'H:iP' ); ?>" itemprop="datePublished">

							<a href="#comment-<?php comment_ID(); ?>" itemprop="url"><?php comment_date( get_option( 'date_format' ) ); ?></a>

						</time>

						<div class="reply-link">

							<?php
							comment_reply_link( array_merge( $args, array(
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
							) ) );
							?>

						</div>

						<?php edit_comment_link( __( 'Edit', 'bytegazette' ), '<div class="edit-link">', '</div>' ); ?>

					</div><!-- .comment-metadata -->

					<div class="comment-author vcard">

						<b class="fn"><a class="comment-author-link" href="<?php comment_author_url(); ?>" rel="external nofollow" itemprop="author"><?php comment_author(); ?></a></b>

					</div><!-- .comment-author -->

				</footer><!-- .comment-meta -->

				<div class="comment-content" itemprop="text">

					<?php if ( '0' === (string) $comment->comment_approved ) : ?>

						<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'bytegazette' ); ?></em>

					<?php endif; ?>

					<?php comment_text(); ?>

				</div><!-- .comment-content -->

			</article>

		</li>
		<?php
	}
endif;

if ( ! function_exists( 'bytegazette_list_comments' ) ) :
	/**
	 * Generate list of comments for current post using the Byte Gazette params.
	 *
	 * @param array $attrs The attributes to override to wp_list_comments.
	 */
	function bytegazette_list_comments( $attrs = array() ) {
		$tag = get_theme_mod( 'comment_list_tag', ByteGazette::COMMENT_LIST_TAG );

		printf( '<%s class="comment-list">', esc_attr( $tag ) );

		wp_list_comments( array_merge( array(
			'style'        => $tag,
			'short_ping'   => get_theme_mod( 'comment_short_ping', ByteGazette::COMMENT_SHORT_PING ),
			'avatar_size'  => get_theme_mod( 'comment_avatar_size', ByteGazette::COMMENT_AVATAR_SIZE ),
			'callback'     => 'bytegazette_comment',
		), $attrs ) );

		printf( '</%s>', esc_attr( $tag ) );
	}
endif;

if ( ! function_exists( 'bytegazette_slideshow_posts' ) ) :
	/**
	 * Generate list of featured slideshow posts using tag.
	 *
	 * @param string $tag The tag to use to query for featured posts.
	 * @param int    $count The number of posts to get.
	 * @return WP_Query The featured posts to show.
	 */
	function bytegazette_slideshow_posts( $tag = null, $count = null ) {
		$tag = (bool) $tag ? $tag : get_theme_mod( 'slideshow_posts_tag', ByteGazette::SLIDESHOW_POSTS_TAG );
		$num = (bool) $count ? $count : get_theme_mod( 'slideshow_posts_count', ByteGazette::SLIDESHOW_POSTS_COUNT );

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
		$tag = (bool) $tag ? $tag : get_theme_mod( 'featured_posts_tag', ByteGazette::FEATURED_POSTS_TAG );
		$num = (bool) $count ? $count : get_theme_mod( 'featured_posts_count', ByteGazette::FEATURED_POSTS_COUNT );

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
		$method  = get_theme_mod( 'post_related_method', ByteGazette::POST_RELATED_METHOD );
		$count   = (int) get_theme_mod( 'post_related_count', ByteGazette::POST_RELATED_COUNT );

		if ( ByteGazette::POST_RELATED_MAX < $bytegazette_post_related_count ) {
			$bytegazette_post_related_count = ByteGazette::POST_RELATED_MAX;
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

		print( '<span class="posted-on">' . $posted_on . '</span>' ); // WPCS: XSS OK.

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

		print( '<span class="byline"> ' . $byline . '</span>' ); // WPCS: XSS OK.

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

if ( ! function_exists( 'bytegazette_time_ago' ) ) :
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

		return $date->format( 'c' );
	}
endif;

if ( ! function_exists( 'bytegazette_the_comments_pagination' ) ) :
	/**
	 * Show pagination links for comments.
	 */
	function bytegazette_the_comments_pagination() {
		$bytegazette_pagination_comments_prev = bytegazette_get_option( 'pagination_comments_previous', BYTEGAZETTE_STRING_COMMENTS_PREVIOUS );
		$bytegazette_pagination_comments_next = bytegazette_get_option( 'pagination_comments_next', BYTEGAZETTE_STRING_COMMENTS_NEXT );

		?>
			<nav class="nav-comment-pagination">
				<ul class="pagination">
					<li class="pager-previous"><?php previous_comments_link( '<span class="icon-svg-wrap"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path d="M11.56 5.56L10.5 4.5 6 9l4.5 4.5 1.06-1.06L8.12 9z"/></svg></span><span class="text-wrap">' . $bytegazette_pagination_comments_prev . '</span>' ); ?></li>
					<li class="pager-next"><?php next_comments_link( '<span class="text-wrap">' . $bytegazette_pagination_comments_next . '</span><span class="icon-svg-wrap"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path d="M7.5 4.5L6.44 5.56 9.88 9l-3.44 3.44L7.5 13.5 12 9z"/></svg></span>' ); ?></li>
				</ul>
			</nav>
		<?php
	}
endif;

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
			'prev_text'          => '<span class="icon-svg-wrap"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path d="M11.56 5.56L10.5 4.5 6 9l4.5 4.5 1.06-1.06L8.12 9z"/></svg></span><span class="text-wrap">Previous</span>',
			'next_text'          => '<span class="text-wrap">Next</span><span class="icon-svg-wrap"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path d="M7.5 4.5L6.44 5.56 9.88 9l-3.44 3.44L7.5 13.5 12 9z"/></svg></span>',
			'type'               => 'array',
			'add_fragment'       => '',
			'before_page_number' => '',
			'after_page_number'  => '',
		);

		$pages = paginate_links( $args );

		if ( is_array( $pages ) ) {
			$pager_count = count( $pages );

			print( '<section class="nav-pagination"><hr><ul class="pagination">' );

			for ( $p = 0; $p < $pager_count; $p++ ) {
				$prev  = ( 0 === $p && strpos( $pages[ $p ], 'prev' ) ) ? 'pager-previous' : null;
				$next  = ( ( $pager_count - 1 ) === $p && strpos( $pages[ $p ], 'next' ) ) ? 'pager-next' : null;
				$class = ( $prev || $next ) ? sprintf( '%s%s', $prev, $next ) : 'pager';

				printf( '<li class="%s">%s</li>', esc_attr( $class ), $pages[ $p ] ); // WPCS: XSS OK.
			}

			print( '</ul></section>' );
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

	print( esc_url( $image ) );
}

/**
 * Get the featured video for a post.
 *
 * @param string $post_id The post_id to find the video for.
 */
function bytegazette_the_featured_video( $post_id ) {
	static $video_strings = array(
		'dailymotion',
		'hulu',
		'video',
		'vimeo',
		'wordPress.tv',
		'youtube',
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
	$found   = false;
	$content = do_shortcode( apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) ) );
	$embeds  = get_media_embedded_in_content( $content );

	if ( ! empty( $embeds ) ) {
		foreach ( $embeds as $embed ) {
			if ( ! $found ) {
				foreach ( $embed_strings as $embed_string ) {
					if ( strpos( $embed, $embed_string ) ) {
						$found = true;
						print( $embed );
						break;
					}
				}
			}
		}
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

		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'bytegazette' ) );
			if ( $tags_list ) {
				printf( '<span class="thetags"><i class="material-icons">label</i>' . esc_html__( '%1$s', 'bytegazette' ) . '</span>', $tags_list );
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
		$sidebar_layout = get_theme_mod( 'sidebar_layout', ByteGazette::SIDEBAR_LAYOUT );

		if ( is_home() ) {
			$sidebar_layout = get_theme_mod( 'front_sidebar', $sidebar_layout );
		} elseif ( is_singular() ) {
			$sidebar_layout = get_theme_mod( 'sidebar_layout', $sidebar_layout );
		} elseif ( is_archive() ) {
			$sidebar_layout = get_theme_mod( 'sidebar_layout', $sidebar_layout );
		}

		if ( in_array( $sidebar_layout, array( 'left', 'right', 'none' ), true ) ) {
			return $sidebar_layout;
		}

		return ByteGazette::SIDEBAR_LAYOUT;
	}
endif;

if ( ! function_exists( 'bytegazette_get_sidebar_width' ) ) :
	/**
	 * Get the sidebar width as configured.
	 */
	function bytegazette_get_sidebar_width() {
		$sidebar_width = get_theme_mod( 'sidebar_layout', ByteGazette::SIDEBAR_WIDTH );

		if ( in_array( $sidebar_width, array( '1_2', '1_3', '1_4', '1_6' ), true ) ) {
			return $sidebar_width;
		}

		return ByteGazette::SIDEBAR_WIDTH;
	}
endif;

if ( ! function_exists( 'bytegazette_get_sidebar_width_class' ) ) :
	/**
	 * Get the sidebar width form configured sidebar width.
	 */
	function bytegazette_get_sidebar_body_class() {
		$sidebar_layout = bytegazette_get_sidebar_layout();

		if ( 'none' !== $sidebar_layout ) {
			$sidebar_width = bytegazette_get_sidebar_width();

			switch ( $sidebar_width ) {
				case '1_2':
					return "sidebar-$sidebar_layout sidebar-1-2";
				case '1_3':
					return "sidebar-$sidebar_layout sidebar-1-3";
				case '1_4':
					return "sidebar-$sidebar_layout sidebar-1-4";
				case '1_6':
					return "sidebar-$sidebar_layout sidebar-1-6";
			}
		}

		return "sidebar-$sidebar_layout";
	}
endif;

if ( ! function_exists( 'bytegazette_entry_author' ) ) :
	/**
	 * Display HTML with meta information for Author.
	 */
	function bytegazette_entry_author() {

		if ( 'post' === get_post_type() ) {
			printf(
				// translator: 1: post author.
				_x( '%s', 'post author', 'bytegazette' ),
				'<span class="author vcard"><span class="url fn"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span></span>'
			);
		}
	}
endif;

if ( ! function_exists( 'bytegazette_entry_comments' ) ) :
	/**
	 * Display HTML with meta information for Comments number.
	 */
	function bytegazette_entry_comments() {
		if ( 'post' === get_post_type() ) {
			printf( '<span>%s</span>', esc_attr( get_comments_number() ) );
		}
	}
endif;

if ( ! function_exists( 'bytegazette_truncate_string' ) ) :
	/**
	 * Truncate string to x letters/words.
	 *
	 * @param string $str The string to truncate.
	 * @param int    $length The max length of string to truncate.
	 * @param string $units letters|words Weather to truncate to max letters or max words.
	 * @param string $ellipsis The ellipsis character to append fot truncated string.
	 */
	function bytegazette_truncate_string( $str, $length = 40, $units = 'letters', $ellipsis = '&nbsp;&hellip;' ) {

		if ( 'letters' === $units ) {

			if ( mb_strlen( $str ) > $length ) {
				return mb_substr( $str, 0, $length ) . $ellipsis;
			} else {
				return $str;
			}
		} else {
			$words = explode( ' ', $str );

			if ( count( $words ) > $length ) {
				return implode( ' ', array_slice( $words, 0, $length ) ) . $ellipsis;
			} else {
				return $str;
			}
		}
	}
endif;

