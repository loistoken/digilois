<?php
/**
 * Wolmart Categories
 *
 * @since 1.0.0
 */

$creative_layout = wolmart_creative_preset_imgs();

foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => WOLMART_CORE_URI . $item,
	);
}


$params = array(
	esc_html__( 'General', 'wolmart-core' )          => array(
		'wolmart_wpb_categories_select_controls',
	),
	esc_html__( 'Layout', 'wolmart-core' )           => array(
		'wolmart_wpb_elements_layout_controls',
	),
	esc_html__( 'Type', 'wolmart-core' )             => array(
		'wolmart_wpb_categories_type_controls',
	),
	esc_html__( 'Style', 'wolmart-core' )            => array(
		esc_html__( 'Category', 'wolmart-core' )         => array( 'wolmart_wpb_categories_wrap_style_controls' ),
		esc_html__( 'Category Icon', 'wolmart-core' )    => array( 'wolmart_wpb_categories_icon_style_controls' ),
		esc_html__( 'Category Content', 'wolmart-core' ) => array( 'wolmart_wpb_categories_content_style_controls' ),
		esc_html__( 'Category Name', 'wolmart-core' )    => array( 'wolmart_wpb_categories_name_style_controls' ),
		esc_html__( 'Products Count', 'wolmart-core' )   => array( 'wolmart_wpb_categories_count_style_controls' ),
		esc_html__( 'Button', 'wolmart-core' )           => array( 'wolmart_wpb_categories_button_style_controls' ),
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


$params = array_merge( wolmart_wpb_filter_element_params( $params, 'wpb_wolmart_categories_slider' ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Product Categories Slider', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_categories_slider',
		'icon'            => 'wolmart-icon wolmart-icon-cat-slider',
		'class'           => 'wolmart_categories wolmart_categories_slider',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart product categories with slider layout.', 'wolmart-core' ),
		'params'          => $params,
	)
);

add_filter( 'vc_autocomplete_wpb_wolmart_categories_slider_category_ids_callback', 'wolmart_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_categories_slider_category_ids_render', 'wolmart_wpb_shortcode_product_category_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Categories_Slider extends WPBakeryShortCode {
	}
}
