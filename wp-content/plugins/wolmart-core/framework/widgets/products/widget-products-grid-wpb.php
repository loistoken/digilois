<?php
/**
 * Wolmart Products
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		'wolmart_wpb_products_select_controls',
	),
	esc_html__( 'Layout', 'wolmart-core' )  => array(
		'wolmart_wpb_elements_layout_controls',
	),
	esc_html__( 'Type', 'wolmart-core' )    => array(
		'wolmart_wpb_products_type_controls',
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		'wolmart_wpb_products_style_controls',
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params, 'wpb_wolmart_products_grid' ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Products Grid', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_products_grid',
		'icon'            => 'wolmart-icon wolmart-icon-products-grid',
		'class'           => 'wolmart_products wolmart_products_grid',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart products with grid layout.', 'wolmart-core' ),
		'params'          => $params,
	)
);

// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_products_grid_categories_callback', 'wolmart_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_products_grid_categories_render', 'wolmart_wpb_shortcode_product_category_id_render', 10, 1 );

// Brand Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_products_grid_brands_callback', 'wolmart_wpb_shortcode_brand_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_products_grid_brands_render', 'wolmart_wpb_shortcode_brand_id_render', 10, 1 );

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_products_grid_product_ids_callback', 'wolmart_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_products_grid_product_ids_render', 'wolmart_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_wolmart_products_grid_product_ids_param_value', 'wolmart_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Products_Grid extends WPBakeryShortCode {
	}
}
