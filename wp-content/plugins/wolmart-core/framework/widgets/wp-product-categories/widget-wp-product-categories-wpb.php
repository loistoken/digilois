<?php
/**
 * Wolmart WP Product Categories
 *
 * @since 1.0.0
 */
$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'wolmart-core' ),
			'param_name' => 'title',
			'std'        => 'Product categories',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show product counts', 'wolmart-core' ),
			'param_name' => 'count',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'std'        => 'no',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show hierarchy', 'wolmart-core' ),
			'param_name' => 'hierarchical',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Hide empty categories', 'wolmart-core' ),
			'param_name' => 'hide_empty',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Maximum depth', 'wolmart-core' ),
			'param_name' => 'max_depth',
			'std'        => 1,
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ) );

vc_map(
	array(
		'name'            => esc_html__( 'Product Categories List', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_wp_product_categories',
		'icon'            => 'wolmart-icon wolmart-icon-product-category',
		'class'           => 'wpb_wolmart_wp_product_categories',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart wordpress product categories with listed type.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_WP_Product_Categories extends WPBakeryShortCode {

	}
}
