<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Posts Widget Render
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Posts Selector
			'post_ids'                   => '',
			'categories'                 => '',
			'count'                      => array( 'size' => 4 ),
			'orderby'                    => '',
			'orderway'                   => '',

			// Posts Layout
			'layout_type'                => 'grid',
			'row_cnt'                    => 1,
			'col_cnt'                    => array( 'size' => 4 ),
			'thumbnail_size'             => 'wolmart-post-small',
			'thumbnail_custom_dimension' => '',
			'creative_cols'              => '',
			'creative_cols_tablet'       => '',
			'creative_cols_mobile'       => '',
			'items_list'                 => '',
			'loadmore_type'              => '',
			'loadmore_label'             => esc_html__( 'Load More', 'wolmart-core' ),

			// Post Type
			'follow_theme_option'        => '',
			'post_type'                  => '',
			'overlay'                    => '',
			'show_info'                  => array(),
			'show_datebox'               => '',
			'read_more_label'            => esc_html__( 'Read More', 'wolmart-core' ),
			'read_more_custom'           => false,
			'excerpt_custom'             => '',
			'excerpt_length'             => 20,
			'excerpt_type'               => 'words',

			// Style
			'content_align'              => '',
			'page_builder'               => '',
			'wrapper_id'                 => '',
		),
		$atts
	)
);

if ( ! is_array( $count ) ) {
	$count = json_decode( $count, true );
}
if ( ! is_array( $col_cnt ) ) {
	$col_cnt = json_decode( $col_cnt, true );
}
if ( ! is_array( $show_info ) ) {
	$show_info = explode( ',', $show_info );
}
if ( ! is_array( $excerpt_length ) ) {
	$excerpt_length = json_decode( $excerpt_length, true );
}

$excerpt_limit = empty( $excerpt_length ) ? '' : ( defined( 'WPB_VC_VERSION' ) ? $excerpt_length : $excerpt_length['size'] );

// Generate a Query ////////////////////////////////////////////////////////////

$posts_per_page = $count['size'];

$args = array(
	'post_type'      => 'post',
	'posts_per_page' => $posts_per_page,
);

if ( $post_ids ) {
	$args['post__in'] = $post_ids;
	$orderby          = 'post__in';
}

if ( $categories ) {
	$cat_arr = $categories;
	if ( isset( $cat_arr[0] ) && is_numeric( trim( $cat_arr[0] ) ) ) {
		$args['cat'] = $categories;
	} else {
		$args['category_name'] = $categories;
	}
}

if ( $orderby ) {
	$args['orderby'] = $orderby;
}
if ( $orderway ) {
	$args['order'] = $orderway;
}

$posts = new WP_Query( $args );

// Process Posts /////////////////////////////////////////////////////////////////

if ( $posts->have_posts() ) {

	$extra_class = array( 'posts' );
	$extra_attrs = '';

	// Props

	$props = array(
		'widget'       => true,
		'posts_layout' => $layout_type,
	);

	if ( ! $follow_theme_option ) {
		$props['type']            = $post_type;
		$props['overlay']         = $overlay;
		$props['show_info']       = $show_info;
		$props['show_datebox']    = $show_datebox;
		$props['excerpt_length']  = 'yes' == $excerpt_custom ? $excerpt_limit : '';
		$props['excerpt_type']    = 'yes' == $excerpt_custom ? $excerpt_type : '';
		$props['read_more_label'] = wolmart_widget_button_get_label( $atts, '', $read_more_label ? $read_more_label : esc_html__( 'Read More', 'wolmart-core' ) );
		$props['read_more_class'] = $read_more_custom ? implode( ' ', wolmart_widget_button_get_class( $atts ) ) : '';
	} else {
		$props['follow_theme_option'] = 'yes';
	}
	$props['thumbnail_size']             = $thumbnail_size;
	$props['thumbnail_custom_dimension'] = $thumbnail_custom_dimension;

	// Layout

	$col_cnt          = wolmart_elementor_grid_col_cnt( $atts );
	$grid_space_class = wolmart_get_grid_space_class( $atts );

	if ( $grid_space_class ) {
		$extra_class[] = $grid_space_class;
	}

	if ( 'grid' == $layout_type || 'slider' == $layout_type ) {
		$extra_class[] = wolmart_get_col_class( $col_cnt );

	} elseif ( 'creative' == $layout_type ) {
		if ( is_array( $items_list ) ) {
			$extra_class[] = 'row creative-grid';
			if ( function_exists( 'wolmart_is_elementor_preview' ) && wolmart_is_elementor_preview() ) {
				$extra_class[] = 'editor-mode';
			}
			$props['repeaters'] = array(
				'ids'    => array(),
				'images' => array(),
			);
			foreach ( $items_list as $item ) {
				$props['repeaters']['ids'][ (int) $item['item_no'] ]    = 'elementor-repeater-item-' . $item['_id'];
				$props['repeaters']['images'][ (int) $item['item_no'] ] = $item['item_thumb_size'];
			}
			$props['post_idx'] = 0;
		}
	}

	if ( 'slider' == $layout_type ) {
		$extra_class[] = wolmart_get_slider_class( $atts );
		$extra_attrs  .= ' data-slider-options="' . esc_attr(
			json_encode(
				wolmart_get_slider_attrs( $atts, $col_cnt )
			)
		) . '"';

		$props['row_cnt'] = $row_cnt;
		if ( 1 < $row_cnt ) {
			$props['post_idx'] = 0;
		}
	}
	if ( in_array( $content_align, array( 'left', 'center', 'right' ) ) ) {
		$extra_class[] = 'text-' . $content_align;
	}

	// Load More Properties

	if ( function_exists( 'wolmart_loadmore_attributes' ) ) {
		if ( 'scroll' == $loadmore_type ) {
			$extra_class[] = 'load-scroll';
		}
		$extra_attrs .= ' ' . wolmart_loadmore_attributes( $props, $args, $loadmore_type, $posts->max_num_pages );
	}

	echo '<div class="' . esc_attr( implode( ' ', apply_filters( 'wolmart_post_loop_wrapper_classes', $extra_class ) ) ) . '"' . wolmart_escaped( $extra_attrs ) . '>';

	while ( $posts->have_posts() ) {
		$posts->the_post();

		wolmart_get_template_part( 'posts/post', null, $props );
		if ( ( 'creative' == $layout_type || 'slider' == $layout_type ) && isset( $props['post_idx'] ) ) {
			++ $props['post_idx'];
		}
	}

	echo '</div>';
}

if ( function_exists( 'wolmart_loadmore_html' ) && 'slider' != $layout_type && $loadmore_type ) {
	if ( 1 < $posts->max_num_pages ) {
		wolmart_loadmore_html( $posts, $loadmore_type, $loadmore_label );
	}
}

wp_reset_postdata();
