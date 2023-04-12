<?php
/**
 * Brands Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )          => array(
		array(
			'type'       => 'autocomplete',
			'param_name' => 'brands',
			'heading'    => esc_html__( 'Select Brands', 'wolmart-core' ),
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'hide_empty',
			'heading'    => esc_html__( 'Hide Empty', 'wolmart-core' ),
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
		),
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'count',
			'heading'    => esc_html__( 'Brands Count', 'wolmart-core' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Order By', 'wolmart-core' ),
			'param_name' => 'orderby',
			'value'      => array(
				esc_html__( 'Name', 'wolmart-core' )       => 'name',
				esc_html__( 'ID', 'wolmart-core' )         => 'id',
				esc_html__( 'Slug', 'wolmart-core' )       => 'slug',
				esc_html__( 'Modified', 'wolmart-core' )   => 'modified',
				esc_html__( 'Product Count', 'wolmart-core' ) => 'count',
				esc_html__( 'Parent', 'wolmart-core' )     => 'parent',
				esc_html__( 'Description', 'wolmart-core' ) => 'description',
				esc_html__( 'Term Group', 'wolmart-core' ) => 'term_group',
			),
			'std'        => 'name',
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
	),
	esc_html__( 'Layout', 'wolmart-core' )           => array(
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'layout_type',
			'heading'    => esc_html__( 'Layout', 'wolmart-core' ),
			'value'      => array(
				'grid'   => array(
					'title' => esc_html__( 'Grid', 'wolmart-core' ),
				),
				'slider' => array(
					'title' => esc_html__( 'Slider', 'wolmart-core' ),
				),
			),
			'std'        => 'grid',
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'thumbnail',
			'heading'    => esc_html__( 'Image Size', 'wolmart-core' ),
			'value'      => array_flip( wolmart_get_image_sizes() ),
		),
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'row_cnt',
			'heading'    => esc_html__( 'Rows', 'wolmart-core' ),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'col_cnt',
			'heading'    => esc_html__( 'Columns', 'wolmart-core' ),
			'responsive' => true,
		),
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'col_sp',
			'heading'    => esc_html__( 'Columns Spacing', 'wolmart-core' ),
			'std'        => 'md',
			'value'      => array(
				'no' => array(
					'title' => esc_html__( 'No space', 'wolmart-core' ),
				),
				'xs' => array(
					'title' => esc_html__( 'Extra Small', 'wolmart-core' ),
				),
				'sm' => array(
					'title' => esc_html__( 'Small', 'wolmart-core' ),
				),
				'md' => array(
					'title' => esc_html__( 'Medium', 'wolmart-core' ),
				),
				'lg' => array(
					'title' => esc_html__( 'Large', 'wolmart-core' ),
				),
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'slider_vertical_align',
			'heading'    => esc_html__( 'Vertical Align', 'wolmart-core' ),
			'value'      => array(
				'top'         => array(
					'title' => esc_html__( 'Top', 'wolmart-core' ),
				),
				'middle'      => array(
					'title' => esc_html__( 'Middle', 'wolmart-core' ),
				),
				'bottom'      => array(
					'title' => esc_html__( 'Bottom', 'wolmart-core' ),
				),
				'same-height' => array(
					'title' => esc_html__( 'Stretch', 'wolmart-core' ),
				),
			),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'slider_image_expand',
			'heading'    => esc_html__( 'Image Full Width', 'wolmart-core' ),
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'slider_horizontal_align',
			'heading'    => esc_html__( 'Horizontal Align', 'wolmart-core' ),
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} figure' => 'display: flex; justify-content:{{VALUE}};',
			),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'grid_vertical_align',
			'heading'    => esc_html__( 'Vertical Align', 'wolmart-core' ),
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Top', 'wolmart-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Middle', 'wolmart-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Bottom', 'wolmart-core' ),
				),
				'stretch'    => array(
					'title' => esc_html__( 'Stretch', 'wolmart-core' ),
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} figure' => 'display: flex; align-items:{{VALUE}}; height: 100%;',
			),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'grid',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'grid_image_expand',
			'heading'    => esc_html__( 'Image Full Width', 'wolmart-core' ),
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'selectors'  => array(
				'{{WRAPPER}} figure a, {{WRAPPER}} figure img' => 'width: 100%;',
			),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'grid',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'grid_horizontal_align',
			'heading'    => esc_html__( 'Horizontal Align', 'wolmart-core' ),
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} figure' => 'display: flex; justify-content:{{VALUE}};',
			),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'grid',
			),
		),
	),
	esc_html__( 'Brands Type', 'wolmart-core' )      => array(
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'brand_type',
			'value'      => array(
				'1' => array(
					'title' => esc_html__( 'Type 1', 'wolmart-core' ),
				),
				'2' => array(
					'title' => esc_html__( 'Type 2', 'wolmart-core' ),
				),
				'3' => array(
					'title' => esc_html__( 'Type 3', 'wolmart-core' ),
				),
			),
			'std'        => '1',
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_brand_rating',
			'heading'    => esc_html__( 'Show Brand Rating', 'wolmart-core' ),
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'brand_type',
				'value'   => array( '2', '3' ),
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_brand_products',
			'heading'    => esc_html__( 'Show Brand Products', 'wolmart-core' ),
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'brand_type',
				'value'   => '3',
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )            => array(
		esc_html__( 'Brand Name', 'wolmart-core' )    => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'brand_name_typo',
				'selectors'  => array(
					'{{WRAPPER}} .brand-name',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'brand_name_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .brand-name a',
					'hover'  => '{{WRAPPER}} .brand-name a:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Product Count', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'brand_product_count_typo',
				'selectors'  => array(
					'{{WRAPPER}} .brand-product-count',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'brand_product_count_color',
				'selectors'  => array(
					'{{WRAPPER}} .brand-product-count' => 'color: {{VALUE}};',
				),
			),
		),
	),
	esc_html__( 'Carousel Options', 'wolmart-core' ) => array(
		esc_html__( 'Options', 'wolmart-core' ) => array(
			'wolmart_wpb_slider_general_controls',
		),
		esc_html__( 'Nav', 'wolmart-core' )     => array(
			'wolmart_wpb_slider_nav_controls',
		),
		esc_html__( 'Dots', 'wolmart-core' )    => array(
			'wolmart_wpb_slider_dots_controls',
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Product Brands', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_brands',
		'icon'            => 'wolmart-icon wolmart-icon-brands',
		'class'           => 'wolmart_brands',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart product brands.', 'wolmart-core' ),
		'params'          => $params,
	)
);

// Brand Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_brands_brands_callback', 'wolmart_wpb_shortcode_brand_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_brands_brands_render', 'wolmart_wpb_shortcode_brand_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Brands extends WPBakeryShortCode {
	}
}
