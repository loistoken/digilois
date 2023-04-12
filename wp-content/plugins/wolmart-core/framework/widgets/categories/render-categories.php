<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Categories Widget Render
 *
 */

// Category Type Options

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Categories Selector
			'category_ids'               => array(),
			'run_as_filter'              => '',
			'show_all_filter'            => '',
			'run_as_filter_shop'         => '',
			'show_subcategories'         => '',
			'hide_empty'                 => '',
			'count'                      => array( 'size' => 4 ),
			'orderby'                    => 'name',
			'orderway'                   => '',

			// Categories Layout
			'layout_type'                => 'grid',
			'col_sp'                     => '',
			'row_cnt'                    => 1,
			'col_cnt'                    => array( 'size' => 4 ),
			'creative_cols'              => '',
			'creative_cols_tablet'       => '',
			'creative_cols_mobile'       => '',
			'items_list'                 => '',
			'thumbnail_size'             => 'woocommerce_thumbnail',
			'thumbnail_custom_dimension' => '',

			// Category Type
			'follow_theme_option'        => '',
			'category_type'              => '',
			'subcat_cnt'                 => 6,
			'show_icon'                  => '',
			'overlay'                    => '',
			'link_text'                  => esc_html__( 'Shop Now', 'wolmart-core' ),
			'content_align'              => '',
			'content_origin'             => '',
			'page_builder'               => '',
			'wrapper_id'                 => '',
		),
		$atts
	)
);

// Get Count
if ( ! is_array( $count ) ) {
	$count = json_decode( $count, true );
}
if ( ! is_array( $col_cnt ) ) {
	$col_cnt = json_decode( $col_cnt, true );
}
if ( ! is_array( $category_ids ) ) {
	$category_ids = $category_ids ? explode( ',', $category_ids ) : array();
}

$count = (int) $count['size'];


// Wrapper classes & attributes
$wrapper_class = array();
$wrapper_attrs = '';

// Setup filter
if ( $run_as_filter ) {
	wc_set_loop_prop( 'run_as_filter', true );

	if ( $show_all_filter ) {
		wc_set_loop_prop( 'show_all_filter', true );
	}
}
if ( $run_as_filter_shop ) {
	$wrapper_class[] = 'categories-filter-shop';
	wc_set_loop_prop( 'run_as_filter_shop', true );
}


// Grid space
$grid_space_class = wolmart_get_grid_space_class( $atts );
if ( $grid_space_class ) {
	$wrapper_class[] = $grid_space_class;
}

$col_cnt = wolmart_elementor_grid_col_cnt( $atts );

if ( 'slider' == $layout_type ) {

	$wrapper_class[] = wolmart_get_slider_class( $atts );

	$wrapper_attrs .= ' data-slider-options="' . esc_attr(
		json_encode(
			wolmart_get_slider_attrs( $atts, $col_cnt )
		)
	) . '"';

	wc_set_loop_prop( 'row_cnt', $row_cnt );
}

if ( 'creative' == $layout_type ) {
	$wrapper_class[] = 'creative-grid row';

	if ( function_exists( 'wolmart_is_elementor_preview' ) && wolmart_is_elementor_preview() ) {
		$wrapper_class[] = 'editor-mode';
	}

	if ( isset( $atts['creative_mode'] ) ) {
		$wrapper_class[]        = 'preset-grid grid-layout-' . $atts['creative_mode'];
		$props['creative_mode'] = $atts['creative_mode'];
	}
} else {
	wc_set_loop_prop( 'col_cnt', $col_cnt );
}

wc_set_loop_prop( 'cat_index', 0 );
wc_set_loop_prop( 'widget', 'product-category-group' );
wc_set_loop_prop( 'layout_type', $layout_type );
wc_set_loop_prop( 'col_sp', $col_sp );
wc_set_loop_prop( 'thumbnail_size', $thumbnail_size );
if ( 'custom' == $thumbnail_size && $thumbnail_custom_dimension ) {
	wc_set_loop_prop( 'thumbnail_custom_size', $thumbnail_custom_dimension );
}
wc_set_loop_prop( 'wrapper_class', $wrapper_class );
wc_set_loop_prop( 'wrapper_attrs', $wrapper_attrs );

// Preprocess

wc_set_loop_prop( 'follow_theme_option', $follow_theme_option );
if ( 'yes' != $follow_theme_option ) {
	$props = array(
		'category_type'  => $category_type,
		'content_origin' => $content_origin,
		'overlay'        => $overlay,
	);
	if ( ( 'group' == $category_type || 'group-2' == $category_type || 'label' == $category_type ) && 'yes' == $show_icon || 'icon' == $category_type ) {
		$props['show_icon'] = true;
	}
	if ( 'group' == $category_type || 'group-2' == $category_type ) {
		$props['subcat_cnt'] = $subcat_cnt;
	}
	$props['link_text'] = $link_text;
} else {
	$props = array();
}
$props['content_align'] = $content_align;

foreach ( $props as $key => $prop ) {
	wc_set_loop_prop( $key, $prop );
}

if ( 'creative' == $layout_type && is_array( $items_list ) ) {
	$repeaters = array(
		'ids'    => array(),
		'images' => array(),
	);
	foreach ( $items_list as $item ) {
		$repeaters['ids'][ (int) $item['item_no'] ]    = 'elementor-repeater-item-' . $item['_id'];
		$repeaters['images'][ (int) $item['item_no'] ] = $item['item_thumb_size'];
	}
	wc_set_loop_prop( 'repeaters', $repeaters );
}

// Extra Atts

$extra_atts  = '';
$extra_atts .= ' number="' . $count . '"';
$extra_atts .= ' columns="' . $col_cnt['lg'] . '"';
$extra_atts .= ' hide_empty="' . ( 'yes' == $hide_empty ) . '"';

if ( is_array( $category_ids ) && count( $category_ids ) ) {
	if ( $show_subcategories ) {
		$sub_ids = array();

		foreach ( $category_ids as $cat_id ) {
			if ( is_numeric( $cat_id ) ) {
				$terms = get_terms(
					array(
						'taxonomy'   => 'product_cat',
						'hide_empty' => boolval( $hide_empty ),
						'parent'     => $cat_id,
					)
				);
				foreach ( $terms as $term_cat ) {
					$sub_ids[] = $term_cat->term_id;
				}
			}
		}

		$category_ids = $sub_ids;
	}

	$extra_atts .= ' ids="' . esc_attr( implode( ',', $category_ids ) ) . '"'; //'" orderby="include" order="ASC"';
	$extra_atts .= ' orderby="include"  order="ASC"';
} else {
	$extra_atts .= ' orderby="' . esc_attr( $orderby ) . '"';
	$extra_atts .= ' order="' . esc_attr( $orderway ) . '"';
}

// Do Shortcode
echo do_shortcode( '[product_categories' . $extra_atts . ']' );
