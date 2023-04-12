<?php
/**
 * Carousel Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )          => array(
		array(
			'type'        => 'wolmart_number',
			'heading'     => esc_html__( 'Columns', 'wolmart-core' ),
			'responsive'  => true,
			'param_name'  => 'col_cnt',
			'description' => esc_html__( 'Leave it blank to give default value', 'wolmart-core' ),
		),
		array(
			'type'        => 'wolmart_button_group',
			'heading'     => esc_html__( 'Column Spacing', 'wolmart-core' ),
			'param_name'  => 'col_sp',
			'value'       => array(
				'no' => array(
					'title' => esc_html__( 'NO', 'wolmart-core' ),
				),
				'xs' => array(
					'title' => esc_html__( 'XS', 'wolmart-core' ),
				),
				'sm' => array(
					'title' => esc_html__( 'S', 'wolmart-core' ),
				),
				'md' => array(
					'title' => esc_html__( 'M', 'wolmart-core' ),
				),
				'lg' => array(
					'title' => esc_html__( 'L', 'wolmart-core' ),
				),
			),
			'description' => esc_html__( 'Change gap size of carousel items.', 'wolmart-core' ),
			'std'         => 'md',
		),
		array(
			'type'        => 'wolmart_button_group',
			'heading'     => esc_html__( 'Vertical Align', 'wolmart-core' ),
			'param_name'  => 'slider_vertical_align',
			'value'       => array(
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
			'description' => esc_html__( 'Change vertical alignment of carousel items.', 'wolmart-core' ),
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

$params = array_merge( wolmart_wpb_filter_element_params( $params, 'wpb_wolmart_carousel' ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Carousel', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_carousel',
		'icon'            => 'wolmart-icon wolmart-icon-carousel',
		'class'           => 'wolmart_carousel',
		'as_parent'       => array( 'except' => 'wpb_wolmart_carousel' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart carousel.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Carousel extends WPBakeryShortCodesContainer {
	}
}
