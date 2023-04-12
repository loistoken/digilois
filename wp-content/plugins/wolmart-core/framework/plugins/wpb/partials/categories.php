<?php

if ( ! function_exists( 'wolmart_wpb_categories_select_controls' ) ) {
	function wolmart_wpb_categories_select_controls() {
		return array(
			array(
				'type'        => 'autocomplete',
				'param_name'  => 'category_ids',
				'heading'     => esc_html__( 'Category IDs', 'wolmart-core' ),
				'description' => esc_html__( 'comma separated list of category ids', 'wolmart-core' ),
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'run_as_filter',
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'heading'     => esc_html__( 'Filter Products', 'wolmart-core' ),
				'description' => esc_html__( 'In a same section, this will interact with products widget so taht you\'ll be able to filter products by category.', 'wolmart-core' ),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'show_all_filter',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'heading'    => esc_html__( 'Show \'All\'', 'wolmart-core' ),
				'dependency' => array(
					'element' => 'run_as_filter',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'run_as_filter_shop',
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'heading'     => esc_html__( 'Filter Products in Shop', 'wolmart-core' ),
				'description' => esc_html__( 'You\'ll be able to filter products by category in shop page in case that ajax filter is enabled in theme options.', 'wolmart-core' ),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'show_subcategories',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'heading'    => esc_html__( 'Show Subcategories', 'wolmart-core' ),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'hide_empty',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'heading'    => esc_html__( 'Hide Empty', 'wolmart-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'count',
				'heading'     => esc_html__( 'Category Count', 'wolmart-core' ),
				'description' => esc_html__( '0 value will show all categories.', 'wolmart-core' ),
				'std'         => '4',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'orderby',
				'heading'    => esc_html__( 'Order By', 'wolmart-core' ),
				'std'        => 'name',
				'value'      => array(
					esc_html__( 'Name', 'wolmart-core' )   => 'name',
					esc_html__( 'ID', 'wolmart-core' )     => 'id',
					esc_html__( 'Slug', 'wolmart-core' )   => 'slug',
					esc_html__( 'Modified', 'wolmart-core' ) => 'modified',
					esc_html__( 'Product Count', 'wolmart-core' ) => 'count',
					esc_html__( 'Parent', 'wolmart-core' ) => 'parent',
					esc_html__( 'Description', 'wolmart-core' ) => 'description',
					esc_html__( 'Term Group', 'wolmart-core' ) => 'term_group',
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
				'std'        => 'DESC',
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_categories_type_controls' ) ) {
	function wolmart_wpb_categories_type_controls() {
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
				'param_name'   => 'category_type',
				'heading'      => esc_html__( 'Category Type', 'wolmart-core' ),
				'button_width' => '350',
				'value'        => array(
					'default'   => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-1.jpg',
						'title' => esc_html__( 'Default', 'wolmart-core' ),
					),
					'frame'     => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-2.jpg',
						'title' => esc_html__( 'Frame', 'wolmart-core' ),
					),
					'banner'    => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-3.jpg',
						'title' => esc_html__( 'Banner', 'wolmart-core' ),
					),
					'simple'    => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-4.jpg',
						'title' => esc_html__( 'Simple', 'wolmart-core' ),
					),
					'icon'      => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-5.jpg',
						'title' => esc_html__( 'Icon', 'wolmart-core' ),
					),
					'classic'   => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-6.jpg',
						'title' => esc_html__( 'Classic', 'wolmart-core' ),
					),
					'classic-2' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-7.jpg',
						'title' => esc_html__( 'Classic 2', 'wolmart-core' ),
					),
					'ellipse'   => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-8.jpg',
						'title' => esc_html__( 'Ellipse', 'wolmart-core' ),
					),
					'ellipse-2' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-9.jpg',
						'title' => esc_html__( 'Ellipse 2', 'wolmart-core' ),
					),
					'group'     => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-10.jpg',
						'title' => esc_html__( 'Group', 'wolmart-core' ),
					),
					'group-2'   => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-11.jpg',
						'title' => esc_html__( 'Group 2', 'wolmart-core' ),
					),
					'label'     => array(
						'image' => WOLMART_CORE_URI . '/assets/images/categories/category-12.jpg',
						'title' => esc_html__( 'Label', 'wolmart-core' ),
					),
				),
				'std'          => 'default',
				'dependency'   => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'show_icon',
				'heading'     => esc_html__( 'Show Icon', 'wolmart-core' ),
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'description' => esc_html__( 'This option works only for the last 3 category types', 'wolmart-core' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'subcat_cnt',
				'heading'     => esc_html__( 'Subcategory Count', 'wolmart-core' ),
				'description' => esc_html__( 'This option only works in group type categories', 'wolmart-core' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'overlay',
				'heading'    => esc_html__( 'Overlay Effect', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'No', 'wolmart-core' )    => '',
					esc_html__( 'Light', 'wolmart-core' ) => 'light',
					esc_html__( 'Dark', 'wolmart-core' )  => 'dark',
					esc_html__( 'Zoom', 'wolmart-core' )  => 'zoom',
					esc_html__( 'Zoom and Light', 'wolmart-core' ) => 'zoom_light',
					esc_html__( 'Zoom and Dark', 'wolmart-core' ) => 'zoom_dark',
				),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_categories_wrap_style_controls' ) ) {
	function wolmart_wpb_categories_wrap_style_controls() {
		return array(
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'cat_padding',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'param_name' => 'category_min_height',
				'heading'    => esc_html__( 'Min Height', 'wolmart-core' ),
				'units'      => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category img' => 'min-height:{{VALUE}}{{UNIT}}; object-fit: cover;',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'cat_bg',
				'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'cat_color',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category' => 'color: {{VALUE}};',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_categories_icon_style_controls' ) ) {
	function wolmart_wpb_categories_icon_style_controls() {
		return array(
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'icon_margin',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} figure i' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'icon_padding',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} figure' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'param_name' => 'icon_size',
				'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
				'with_units' => true,
				'selectors'  => array(
					'{{WRAPPER}} figure i' => 'font-size: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'icon_color',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} figure i' => 'color: {{VALUE}};',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_categories_content_style_controls' ) ) {
	function wolmart_wpb_categories_content_style_controls() {
		return array(
			array(
				'type'       => 'wolmart_button_group',
				'param_name' => 'content_origin',
				'heading'    => esc_html__( 'Origin X, Y', 'wolmart-core' ),
				'value'      => array(
					'default' => array(
						'title' => esc_html__( 'Default Default', 'wolmart-core' ),
					),
					't-m'     => array(
						'title' => esc_html__( 'Default Center', 'wolmart-core' ),
					),
					't-c'     => array(
						'title' => esc_html__( 'Center Default', 'wolmart-core' ),
					),
					't-mc'    => array(
						'title' => esc_html__( 'Center Center', 'wolmart-core' ),
					),
				),
				'std'        => 'default',
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'content_pos',
				'heading'    => esc_html__( 'Content Position', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'top: {{TOP}};right: {{RIGHT}};bottom: {{BOTTOM}};left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'content_padding',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'units'      => array(
					'px',
					'em',
					'%',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'param_name' => 'content_align',
				'heading'    => esc_html__( 'Content Align', 'wolmart-core' ),
				'value'      => array(
					'default'        => array(
						'title' => esc_html__( 'Default', 'wolmart-core' ),
						'icon'  => 'fas fa-ban',
					),
					'content-left'   => array(
						'title' => esc_html__( 'Left', 'wolmart-core' ),
						'icon'  => 'fas fa-align-left',
					),
					'content-center' => array(
						'title' => esc_html__( 'Center', 'wolmart-core' ),
						'icon'  => 'fas fa-align-center',
					),
					'content-right'  => array(
						'title' => esc_html__( 'Right', 'wolmart-core' ),
						'icon'  => 'fas fa-align-right',
					),
				),
				'std'        => 'default',
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'content_radius',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'param_name' => 'content_colors',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .product-category .category-content',
					'hover'  => '{{WRAPPER}} .product-category:hover .category-content',
				),
				'choices'    => array( 'color', 'background-color' ),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_categories_name_style_controls' ) ) {
	function wolmart_wpb_categories_name_style_controls() {
		return array(
			array(
				'type'       => 'colorpicker',
				'param_name' => 'title_color',
				'heading'    => esc_html__( 'Text Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .woocommerce-loop-category__title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'param_name' => 'title_typography',
				'heading'    => esc_html__( 'Text Typography', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .woocommerce-loop-category__title',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'title_margin',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .woocommerce-loop-category__title' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_categories_count_style_controls' ) ) {
	function wolmart_wpb_categories_count_style_controls() {
		return array(
			array(
				'type'       => 'colorpicker',
				'param_name' => 'count_color',
				'heading'    => esc_html__( 'Count Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category mark' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'param_name' => 'count_typography',
				'heading'    => esc_html__( 'Count Typography', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category mark',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_categories_button_style_controls' ) ) {
	function wolmart_wpb_categories_button_style_controls() {
		return array(
			array(
				'type'       => 'wolmart_typography',
				'param_name' => 'button_typography',
				'heading'    => esc_html__( 'Button Typography', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .btn',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'param_name' => 'button_colors',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .product-category .btn',
					'hover'  => '{{WRAPPER}} .product-category .btn:hover, {{WRAPPER}} .product-category .btn:focus',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'button_border_type',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-style:{{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'button_border_width',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-top:{{TOP}};border-right:{{RIGHT}};border-bottom:{{BOTTOM}};border-left:{{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'button_border_type',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'button_border_radius',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'button_margin',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .btn' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'button_padding',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .btn' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
		);
	}
}
