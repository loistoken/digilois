<?php
/**
 * Wolmart Subcategories
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'        => 'wolmart_button_group',
			'heading'     => esc_html__( 'Category Type', 'wolmart-core' ),
			'param_name'  => 'list_type',
			'value'       => array(
				'cat'  => array(
					'title' => esc_html__( 'Post', 'wolmart-core' ),
				),
				'pcat' => array(
					'title' => esc_html__( 'Product', 'wolmart-core' ),
				),
			),
			'std'         => 'pcat',
			'admin_label' => true,
		),
		array(
			'type'       => 'autocomplete',
			'param_name' => 'category_ids',
			'heading'    => esc_html__( 'Select Categories', 'wolmart-core' ),
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency' => array(
				'element' => 'list_type',
				'value'   => 'cat',
			),
		),
		array(
			'type'       => 'autocomplete',
			'param_name' => 'product_category_ids',
			'heading'    => esc_html__( 'Select Categories', 'wolmart-core' ),
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency' => array(
				'element' => 'list_type',
				'value'   => 'pcat',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_subcategories',
			'heading'    => esc_html__( 'Show Subcategories', 'wolmart-core' ),
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'list_style',
			'heading'    => esc_html__( 'Style', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'Simple', 'wolmart-core' )    => '',
				esc_html__( 'Underline', 'wolmart-core' ) => 'underline',
			),
			'dependency' => array(
				'element' => 'show_subcategories',
				'value'   => 'yes',
			),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'count',
			'heading'     => esc_html__( 'Subcategories Count', 'wolmart-core' ),
			'description' => esc_html__( '0 value will show all categories.', 'wolmart-core' ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'hide_empty',
			'heading'    => esc_html__( 'Hide Empty', 'wolmart-core' ),
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'view_all',
			'heading'    => esc_html__( 'View All Label', 'wolmart-core' ),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		array(
			'type'       => 'wolmart_typography',
			'param_name' => 'title_typo',
			'heading'    => esc_html__( 'Title Typography', 'wolmart-core' ),
			'selectors'  => array(
				'{{WRAPPER}} .subcat-title',
			),
			'dependency' => array(
				'element' => 'show_subcategories',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'colorpicker',
			'param_name' => 'title_color',
			'heading'    => esc_html__( 'Title Color', 'wolmart-core' ),
			'selectors'  => array(
				'{{WRAPPER}} .subcat-title' => 'color: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'show_subcategories',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'title_space',
			'heading'    => esc_html__( 'Title Space', 'wolmart-core' ),
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .subcat-title' => 'margin-right:{{VALUE}}{{UNIT}};',
			),
			'dependency' => array(
				'element' => 'show_subcategories',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'wolmart_typography',
			'param_name' => 'link_typo',
			'heading'    => esc_html__( 'Link Typography', 'wolmart-core' ),
			'selectors'  => array(
				'{{WRAPPER}} .subcat-nav a',
			),
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Link Colors', 'wolmart-core' ),
			'param_name' => 'link_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .subcat-nav a',
				'hover'  => '{{WRAPPER}} .subcat-nav a:hover, {{WRAPPER}} .subcat-nav a:focus, {{WRAPPER}} .subcat-nav a:visited',
			),
			'choices'    => array( 'color' ),
		),
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'link_space',
			'heading'    => esc_html__( 'Link Space', 'wolmart-core' ),
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .subcat-nav a' => 'margin-right:{{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Subcategories', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_subcategories',
		'icon'            => 'wolmart-icon wolmart-icon-subcategories',
		'class'           => 'wolmart_subcategories',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart subcategories.', 'wolmart-core' ),
		'params'          => $params,
	)
);

// Category Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_subcategories_category_ids_callback', 'wolmart_wpb_shortcode_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_subcategories_category_ids_render', 'wolmart_wpb_shortcode_category_id_render', 10, 1 );

// Product Category Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_subcategories_product_category_ids_callback', 'wolmart_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_subcategories_product_category_ids_render', 'wolmart_wpb_shortcode_product_category_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Subcategories extends WPBakeryShortCode {
	}
}
