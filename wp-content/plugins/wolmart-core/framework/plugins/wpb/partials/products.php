<?php

if ( ! function_exists( 'wolmart_wpb_products_select_controls' ) ) {
	function wolmart_wpb_products_select_controls() {
		return array(
			array(
				'type'        => 'autocomplete',
				'param_name'  => 'product_ids',
				'heading'     => esc_html__( 'Product IDs', 'wolmart-core' ),
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
				'admin_label' => true,
			),
			array(
				'type'       => 'autocomplete',
				'param_name' => 'categories',
				'heading'    => esc_html__( 'Categories', 'wolmart-core' ),
				'settings'   => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'       => 'autocomplete',
				'param_name' => 'brands',
				'heading'    => esc_html__( 'Brands', 'wolmart-core' ),
				'settings'   => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'       => 'wolmart_number',
				'param_name' => 'count',
				'heading'    => esc_html__( 'Product Count', 'wolmart-core' ),
				'value'      => '10',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'status',
				'heading'    => esc_html__( 'Product Status', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'All', 'wolmart-core' ) => '',
					esc_html__( 'Featured', 'wolmart-core' ) => 'featured',
					esc_html__( 'On Sale', 'wolmart-core' ) => 'sale',
					esc_html__( 'Recently Viewed', 'wolmart-core' ) => 'viewed',
				),
				'std'        => '',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'orderby',
				'heading'    => esc_html__( 'Order By', 'wolmart-core' ),
				'std'        => 'name',
				'value'      => array(
					esc_html__( 'Default', 'wolmart-core' ) => '',
					esc_html__( 'ID', 'wolmart-core' )     => 'ID',
					esc_html__( 'Name', 'wolmart-core' )   => 'title',
					esc_html__( 'Date', 'wolmart-core' )   => 'date',
					esc_html__( 'Modified', 'wolmart-core' ) => 'modified',
					esc_html__( 'Price', 'wolmart-core' )  => 'price',
					esc_html__( 'Random', 'wolmart-core' ) => 'rand',
					esc_html__( 'Rating', 'wolmart-core' ) => 'rating',
					esc_html__( 'Comment count', 'wolmart-core' ) => 'comment_count',
					esc_html__( 'Total Sales', 'wolmart-core' ) => 'popularity',
					esc_html__( 'Wish', 'wolmart-core' )   => 'wishqty',
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'param_name' => 'orderway',
				'value'      => array(
					'DESC' => array(
						'title' => esc_html__( 'Descending', 'wolmart-core' ),
					),
					'ASC'  => array(
						'title' => esc_html__( 'Ascending', 'wolmart-core' ),
					),
				),
				'std'        => 'ASC',
			),
			// array(
			// 	'type'       => 'checkbox',
			// 	'param_name' => 'hide_out_date',
			// 	'heading'    => esc_html__( 'Hide Product Out of Date', 'wolmart-core' ),
			// 	'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			// ),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_products_type_controls' ) ) {
	function wolmart_wpb_products_type_controls() {
		return array(
			array(
				'type'       => 'checkbox',
				'param_name' => 'follow_theme_option',
				'heading'    => esc_html__( 'Follow Theme Option', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'std'        => 'yes',
			),
			array(
				'type'         => 'wolmart_button_group',
				'param_name'   => 'product_type',
				'heading'      => esc_html__( 'Product Type', 'wolmart-core' ),
				'button_width' => '250',
				'value'        => array(
					''          => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-1.jpg',
						'title' => esc_html__( 'Type 1', 'wolmart-core' ),
					),
					'product-2' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-2.jpg',
						'title' => esc_html__( 'Type 2', 'wolmart-core' ),
					),
					'product-3' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-3.jpg',
						'title' => esc_html__( 'Type 3', 'wolmart-core' ),
					),
					'product-4' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-4.jpg',
						'title' => esc_html__( 'Type 4', 'wolmart-core' ),
					),
					'product-5' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-5.jpg',
						'title' => esc_html__( 'Type 5', 'wolmart-core' ),
					),
					'product-6' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-6.jpg',
						'title' => esc_html__( 'Type 6', 'wolmart-core' ),
					),
					'product-7' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-7.jpg',
						'title' => esc_html__( 'Type 7', 'wolmart-core' ),
					),
					'product-8' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-8.jpg',
						'title' => esc_html__( 'Type 8', 'wolmart-core' ),
					),
					'product-9' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-9.jpg',
						'title' => esc_html__( 'Type 9', 'wolmart-core' ),
					),
					'widget'    => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-widget.jpg',
						'title' => esc_html__( 'Type Widget', 'wolmart-core' ),
					),
					'list'      => array(
						'image' => WOLMART_CORE_URI . '/assets/images/products/product-list.jpg',
						'title' => esc_html__( 'Type List', 'wolmart-core' ),
					),
				),
				'std'          => '',
				'dependency'   => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'show_in_box',
				'heading'    => esc_html__( 'Show In Box', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'show_hover_shadow',
				'heading'     => esc_html__( 'Shadow Effect on Hover', 'wolmart-core' ),
				'description' => esc_html__( 'This option does not work for widget & list type products', 'wolmart-core' ),
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'show_media_shadow',
				'heading'    => esc_html__( 'Media Shadow Effect on Hover', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			// Showing Info
			array(
				'type'       => 'wolmart_multiselect',
				'heading'    => esc_html__( 'Show Information', 'wolmart-core' ),
				'param_name' => 'show_info',
				'value'      => array(
					esc_html__( 'Category', 'wolmart-core' ) => 'category',
					esc_html__( 'Label', 'wolmart-core' )  => 'label',
					esc_html__( 'Price', 'wolmart-core' )  => 'price',
					esc_html__( 'Rating', 'wolmart-core' ) => 'rating',
					esc_html__( 'Attribute', 'wolmart-core' ) => 'attribute',
					esc_html__( 'Deal Countdown', 'wolmart-core' ) => 'countdown',
					esc_html__( 'Add To Cart', 'wolmart-core' ) => 'addtocart',
					esc_html__( 'Compare', 'wolmart-core' ) => 'compare',
					esc_html__( 'Quickview', 'wolmart-core' ) => 'quickview',
					esc_html__( 'Wishlist', 'wolmart-core' ) => 'wishlist',
					esc_html__( 'Short Description', 'wolmart-core' ) => 'short_desc',
					esc_html__( 'Sold By', 'wolmart-core' ) => 'sold_by',
				),
				'std'        => 'category,label,price,rating,countdown,addtocart,compare,quickview,wishlist',
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),

			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Line Clamp', 'wolmart - core' ),
				'param_name' => 'desc_line_clamp',
				'value'      => '3',
				'selectors'  => array(
					'{{WRAPPER}} .short-desc p' => 'display: -webkit-box; -webkit-line-clamp: {{VALUE}}; -webkit-box-orient:vertical; overflow: hidden;',
				),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),

			array(
				'type'       => 'checkbox',
				'param_name' => 'show_progress',
				'heading'    => esc_html__( 'Show Sales Bar', 'wolmart - core' ),
				'value'      => array( esc_html__( 'Yes', 'wolmart - core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),

			// Showing Labels
			array(
				'type'       => 'wolmart_multiselect',
				'heading'    => esc_html__( 'Show Labels', 'wolmart - core' ),
				'param_name' => 'show_labels',
				'value'      => array(
					esc_html__( 'Top', 'wolmart - core' )  => 'top',
					esc_html__( 'Sale', 'wolmart - core' ) => 'sale',
					esc_html__( 'new', 'wolmart - core' )  => 'new',
					esc_html__( 'Stock', 'wolmart - core' ) => 'stock',
				),
				'std'        => 'top,sale,new,stock',
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_products_style_controls' ) ) {
	function wolmart_wpb_products_style_controls() {
		return array(
			array(
				'type'       => 'wolmart_accordion_header',
				'heading'    => esc_html__( 'Category Filter', 'wolmart-core' ),
				'param_name' => 'category-filter-style-ah',
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'filter_margin',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-filters' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'filter_item_margin',
				'heading'    => esc_html__( 'Item Margin', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filters > li' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'filter_item_padding',
				'heading'    => esc_html__( 'Item Padding', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'cat_border_radius',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter' => 'border-radius:{{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'cat_border_width',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter' => 'border-style:solid;border-top-width:{{TOP}};border-right-width:{{RIGHT}};border-bottom-width:{{BOTTOM}};border-left-width:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'param_name' => 'filter_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter',
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'param_name' => 'cat_align',
				'heading'    => esc_html__( 'Align', 'wolmart-core' ),
				'value'      => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'wolmart-core' ),
						'icon'  => 'fas fa-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'wolmart-core' ),
						'icon'  => 'fas fa-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'wolmart-core' ),
						'icon'  => 'fas fa-align-right',
					),
				),
				'std'        => 'flex-start',
				'selectors'  => array(
					'{{WRAPPER}} .product-filters' => 'justify-content:{{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'param_name' => 'content_colors',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .nav-filter',
					'hover'  => '{{WRAPPER}} .nav-filter:hover',
					'active' => '{{WRAPPER}} .nav-filter.active',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
		);
	}
}
