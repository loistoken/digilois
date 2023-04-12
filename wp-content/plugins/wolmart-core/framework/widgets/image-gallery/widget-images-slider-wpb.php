<?php
/**
 * Wolmart Image Gallery
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Images', 'wolmart-core' )           => array(
		'wolmart_wpb_images_select_controls',
	),
	esc_html__( 'Layout', 'wolmart-core' )           => array(
		'wolmart_wpb_elements_layout_controls',
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

$params = array_merge( wolmart_wpb_filter_element_params( $params, 'wpb_wolmart_images_slider' ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Images Slider', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_images_slider',
		'icon'            => 'wolmart-icon wolmart-icon-images-slider',
		'class'           => 'wolmart_images wolmart_images_slider image-gallery',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart images slider.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Images_Slider extends WPBakeryShortCode {
	}
}
