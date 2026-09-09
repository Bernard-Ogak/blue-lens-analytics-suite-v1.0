<?php
/**
 * Theme Helper Functions
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Calculate reading time in minutes for blog posts
 *
 * @return int
 */
function bo_safari_get_reading_time() {
	global $post;
	if ( ! $post ) {
		return 1;
	}
	$content    = get_post_field( 'post_content', $post->ID );
	$word_count = str_word_count( strip_tags( $content ) );
	$reading_time = ceil( $word_count / 200 );
	return max( 1, $reading_time );
}

/**
 * Render Breadcrumbs Trail
 */
function bo_safari_render_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="breadcrumbs-trail py-3 text-xs uppercase tracking-wider text-charcoal/70 flex items-center gap-2" aria-label="' . esc_attr__( 'Breadcrumb', 'bo-safari-theme' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="hover:text-champagne">' . esc_html__( 'Home', 'bo-safari-theme' ) . '</a>';
	echo '<span>/</span>';

	if ( is_singular( 'safari' ) ) {
		echo '<a href="' . esc_url( get_post_type_archive_link( 'safari' ) ? get_post_type_archive_link( 'safari' ) : home_url( '/safaris' ) ) . '" class="hover:text-champagne">' . esc_html__( 'Safaris', 'bo-safari-theme' ) . '</a>';
		echo '<span>/</span>';
		echo '<span class="text-safari-green font-semibold">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_singular( 'destination' ) ) {
		echo '<a href="' . esc_url( get_post_type_archive_link( 'destination' ) ? get_post_type_archive_link( 'destination' ) : home_url( '/destinations' ) ) . '" class="hover:text-champagne">' . esc_html__( 'Destinations', 'bo-safari-theme' ) . '</a>';
		echo '<span>/</span>';
		echo '<span class="text-safari-green font-semibold">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_singular( 'post' ) ) {
		echo '<a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '" class="hover:text-champagne">' . esc_html__( 'Journal', 'bo-safari-theme' ) . '</a>';
		echo '<span>/</span>';
		echo '<span class="text-safari-green font-semibold">' . esc_html( get_the_title() ) . '</span>';
	} else {
		echo '<span class="text-safari-green font-semibold">' . esc_html( wp_strip_all_tags( get_the_title() ) ) . '</span>';
	}

	echo '</nav>';
}

/**
 * Render Social Media Share Buttons
 */
function bo_safari_render_social_share() {
	$url   = urlencode( get_permalink() );
	$title = urlencode( get_the_title() );

	echo '<div class="social-share-buttons flex gap-2 items-center text-xs font-semibold uppercase tracking-wider">';
	echo '<span class="text-charcoal/60 mr-2">' . esc_html__( 'Share:', 'bo-safari-theme' ) . '</span>';
	echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" target="_blank" rel="noopener" class="p-2 bg-sand-light rounded hover:bg-champagne hover:text-white">' . esc_html__( 'FB', 'bo-safari-theme' ) . '</a>';
	echo '<a href="https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title . '" target="_blank" rel="noopener" class="p-2 bg-sand-light rounded hover:bg-champagne hover:text-white">' . esc_html__( 'X', 'bo-safari-theme' ) . '</a>';
	echo '<a href="https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&title=' . $title . '" target="_blank" rel="noopener" class="p-2 bg-sand-light rounded hover:bg-champagne hover:text-white">' . esc_html__( 'IN', 'bo-safari-theme' ) . '</a>';
	echo '</div>';
}

/**
 * Render Related Blog Posts
 */
function bo_safari_render_related_posts() {
	$categories = get_the_category();
	if ( empty( $categories ) ) {
		return;
	}

	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post__not_in'   => array( get_the_ID() ),
		'cat'            => $categories[0]->term_id,
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		echo '<div class="grid grid-cols-1 md:grid-cols-3 gap-6">';
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'template-parts/blog/content-card' );
		}
		echo '</div>';
		wp_reset_postdata();
	}
}
