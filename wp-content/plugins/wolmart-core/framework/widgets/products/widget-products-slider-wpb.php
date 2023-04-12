<?php
/**
 * Wolmart Products
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )          => array(
		'wolmart_wpb_products_select_controls',
	),
	esc_html__( 'Layout', 'wolmart-core' )           => array(
		'wolmart_wpb_elements_layout_controls',
	),
	esc_html__( 'Type', 'wolmart-core' )             => array(
		'wolmart_wpb_products_type_controls',
	),
	esc_html__( 'Style', 'wolmart-core' )            => array(
		'wolmart_wpb_products_style_controls',
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

$params = array_merge( wolmart_wpb_filter_element_params( $params, 'wpb_wolmart_products_slider' ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Products Slider', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_products_slider',
		'icon'            => 'wolmart-icon wolmart-icon-products-slider',
		'class'           => 'wolmart_products wolmart_products_slider',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart products with slider layout.', 'wolmart-core' ),
		'params'          => $params,
	)
);

// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_products_slider_categories_callback', 'wolmart_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_products_slider_categories_render', 'wolmart_wpb_shortcode_product_category_id_render', 10, 1 );

// Brand Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_products_slider_brands_callback', 'wolmart_wpb_shortcode_brand_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_products_slider_brands_render', 'wolmart_wpb_shortcode_brand_id_render', 10, 1 );

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_products_slider_product_ids_callback', 'wolmart_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_products_slider_product_ids_render', 'wolmart_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_wolmart_products_slider_product_ids_param_value', 'wolmart_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Products_Slider extends WPBakeryShortCode {
	}
}
