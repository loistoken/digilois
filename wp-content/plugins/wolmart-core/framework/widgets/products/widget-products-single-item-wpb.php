<?php
/**
 * Products Layout Single Product Item Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Layout', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_heading',
			'tag'        => 'p',
			'label'      => esc_html__( 'This element works only for creative products layout.', 'wolmart-core' ),
			'param_name' => 'creative_item_heading',
		),
		array(
			'type'        => 'autocomplete',
			'param_name'  => 'product_ids',
			'heading'     => esc_html__( 'Product IDs', 'wolmart-core' ),
			'description' => esc_html__( 'If this field is empty, it displays below index of user-selected products as single product.', 'wolmart-core' ),
			'settings'    => array(
				'sortable' => true,
			),
		),
		array(
			'type'        => 'wolmart_number',
			'param_name'  => 'item_no',
			'heading'     => esc_html__( 'Insert At', 'wolmart-core' ),
			'description' => esc_html__( 'Input item index where this single product should be inserted before.', 'wolmart-core' ),
		),
		array(
			'type'        => 'wolmart_number',
			'heading'     => esc_html__( 'Single Product Column Size', 'wolmart-core' ),
			'param_name'  => 'item_col_span',
			'std'         => '{"xl":"2","unit":"","xs":"","sm":"","md":"","lg":""}',
			'responsive'  => true,
			'description' => esc_html__( 'Control column size of single product in this layout. This option works only for creative layout.', 'wolmart-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
			'selectors'   => array(
				'.creative-grid > {{WRAPPER}}' => 'grid-column-end: span {{VALUE}}',
			),
		),
		array(
			'type'        => 'wolmart_number',
			'heading'     => esc_html__( 'Single Product Row Size', 'wolmart-core' ),
			'param_name'  => 'item_row_span',
			'std'         => '{"xl":"1","unit":"","xs":"","sm":"","md":"","lg":""}',
			'responsive'  => true,
			'description' => esc_html__( 'Control row size of single product in this layout. This option works only for creative layout.', 'wolmart-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
			'selectors'   => array(
				'.creative-grid > {{WRAPPER}}' => 'grid-row-end: span {{VALUE}}',
			),
		),
	),
	esc_html__( 'Type', 'wolmart-core' )   => array(
		'wolmart_wpb_single_product_type_controls',
	),
	esc_html__( 'Style', 'wolmart-core' )  => array(
		'wolmart_wpb_single_product_style_controls',
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Inner Products Layout', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_products_single_item',
		'icon'            => 'wolmart-icon wolmart-icon-single-product',
		'class'           => 'wolmart_products_single_item',
		'controls'        => 'full',
		'content_element' => true,
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product item inside creative products layout.', 'wolmart-core' ),
		'as_child'        => array( 'only' => 'wpb_wolmart_products_layout' ),
		'params'          => $params,
	)
);

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_products_single_item_product_ids_callback', 'wolmart_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_products_single_item_product_ids_render', 'wolmart_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_wolmart_products_single_item_product_ids_param_value', 'wolmart_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Products_Single_Item extends WPBakeryShortCode {
	}
}
