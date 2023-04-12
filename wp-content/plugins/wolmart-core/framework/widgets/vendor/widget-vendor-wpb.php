<?php
/**
 * Vendor Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )          => array(
		array(
			'type'       => 'dropdown',
			'param_name' => 'vendor_select_type',
			'heading'    => esc_html__( 'Select', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'Individually', 'wolmart-core' ) => 'individual',
				esc_html__( 'Group', 'wolmart-core' ) => 'group',
			),
			'std'        => 'individual',
		),
		array(
			'type'       => 'autocomplete',
			'param_name' => 'vendor_ids',
			'heading'    => esc_html__( 'Select Vendors', 'wolmart-core' ),
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency' => array(
				'element' => 'vendor_select_type',
				'value'   => 'individual',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'vendor_category',
			'heading'    => esc_html__( 'Vendor Type', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'General', 'wolmart-core' ) => '',
				esc_html__( 'Top Selling Vendors', 'wolmart-core' ) => 'sale',
				esc_html__( 'Top Rating Vendors', 'wolmart-core' ) => 'rating',
				esc_html__( 'Newly Added Vendors', 'wolmart-core' ) => 'recent',
			),
			'std'        => '',
			'dependency' => array(
				'element' => 'vendor_select_type',
				'value'   => 'group',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'vendor_count',
			'heading'    => esc_html__( 'Vendor Count', 'wolmart-core' ),
			'std'        => 4,
			'dependency' => array(
				'element' => 'vendor_select_type',
				'value'   => 'group',
			),
		),
	),
	esc_html__( 'Layout', 'wolmart-core' )           => array(
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'layout_type',
			'heading'    => esc_html__( 'Vendors Layout', 'wolmart-core' ),
			'value'      => array(
				'grid'   => array(
					'title' => esc_html__( 'Grid', 'wolmart-core' ),
				),
				'slider' => array(
					'title' => esc_html__( 'Slider', 'wolmart-core' ),
				),
			),
		),
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'col_cnt',
			'heading'    => esc_html__( 'Columns', 'wolmart-core' ),
			'responsive' => true,
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => array(
					'grid',
					'slider',
				),
			),
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
	),
	esc_html__( 'Vendor Type', 'wolmart-core' )      => array(
		array(
			'type'         => 'wolmart_button_group',
			'param_name'   => 'vendor_type',
			'heading'      => esc_html__( 'Display Type', 'wolmart-core' ),
			'button_width' => '250',
			'value'        => array(
				'vendor-1' => array(
					'image' => WOLMART_CORE_URI . '/assets/images/vendors/type-1.jpg',
					'title' => esc_html__( 'Type 1', 'wolmart-core' ),
				),
				'vendor-2' => array(
					'image' => WOLMART_CORE_URI . '/assets/images/vendors/type-2.jpg',
					'title' => esc_html__( 'Type 2', 'wolmart-core' ),
				),
				'vendor-3' => array(
					'image' => WOLMART_CORE_URI . '/assets/images/vendors/type-3.jpg',
					'title' => esc_html__( 'Type 3', 'wolmart-core' ),
				),
			),
			'std'          => 'vendor-1',
		),
		array(
			'type'       => 'wolmart_multiselect',
			'heading'    => esc_html__( 'Show Information', 'wolmart-core' ),
			'param_name' => 'vendor_show_info',
			'value'      => array(
				esc_html__( 'Name', 'wolmart-core' )     => 'name',
				esc_html__( 'Avatar', 'wolmart-core' )   => 'avatar',
				esc_html__( 'Rating', 'wolmart-core' )   => 'rating',
				esc_html__( 'Products Count', 'wolmart-core' ) => 'product_count',
				esc_html__( 'Products', 'wolmart-core' ) => 'products',
			),
			'std'        => 'name,avatar,rating,product_count,products',
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_total_sale',
			'heading'    => esc_html__( 'Show Total Sale', 'wolmart-core' ),
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'vendor_category',
				'value'   => 'sale',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_vendor_link',
			'heading'    => esc_html__( 'Show Visit Vendor Link', 'wolmart-core' ),
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'vendor_type',
				'value'   => array( 'vendor-1', 'vendor-3' ),
			),
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'vendor_link_text',
			'heading'    => esc_html__( 'Link Text', 'wolmart-core' ),
			'std'        => esc_html__( 'Browse This Vendor', 'wolmart-core' ),
			'dependency' => array(
				'element' => 'show_vendor_link',
				'value'   => 'yes',
			),
		),
	),
	esc_html__( 'Vendor Product', 'wolmart-core' )   => array(
		array(
			'type'       => 'dropdown',
			'param_name' => 'thumbnail_size',
			'heading'    => esc_html__( 'Product Image Size', 'wolmart-core' ),
			'value'      => wolmart_get_image_sizes(),
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
	esc_html__( 'Style', 'wolmart-core' )            => array(
		esc_html__( 'Vendor Name', 'wolmart-core' )   => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Vendor Name Typography', 'wolmart-core' ),
				'param_name' => 'vendor_name_typography',
				'selectors'  => array(
					'{{WRAPPER}} .vendor-name a',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Vendor Name Colors', 'wolmart-core' ),
				'param_name' => 'vendor_name_colors',
				'group'      => esc_html__( 'General', 'wolmart-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .vendor-name a',
					'hover'  => '{{WRAPPER}} .vendor-name a:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Vendor Avatar', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Size', 'wolmart-core' ),
				'param_name' => 'avatar_size_1',
				'value'      => '70',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .vendor-widget .vendor-logo' => 'max-width: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .vendor-widget .vendor-personal' => 'max-width: calc(100% - {{VALUE}}{{UNIT}});',
				),
				'dependency' => array(
					'element' => 'vendor_type',
					'value'   => array( 'vendor-1', 'vendor-2' ),
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Size', 'wolmart-core' ),
				'param_name' => 'avatar_size_2',
				'value'      => '90',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .vendor-widget-3 .vendor-logo' => 'max-width: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .vendor-widget-3 .vendor-personal' => 'margin-top: calc(-{{VALUE}}{{UNIT}} / 2);',
				),
				'dependency' => array(
					'element' => 'vendor_type',
					'value'   => array( 'vendor-3' ),
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Vendors', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_vendor',
		'icon'            => 'wolmart-icon wolmart-icon-vendors',
		'class'           => 'wolmart_vendor',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create Wolmart Vendors.', 'wolmart-core' ),
		'params'          => $params,
	)
);

// Vendor Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_vendor_vendor_ids_callback', 'wolmart_wpb_shortcode_vendor_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_vendor_vendor_ids_render', 'wolmart_wpb_shortcode_vendor_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Vendor extends WPBakeryShortCode {
	}
}
