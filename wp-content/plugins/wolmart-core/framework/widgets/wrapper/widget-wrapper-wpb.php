<?php
/**
 * Wolmart Element Wrapper shortcode
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'        => 'wolmart_dropdown',
			'heading'     => esc_html__( 'Tag', 'wolmart-core' ),
			'param_name'  => 'html_tag',
			'value'       => array(
				'Div'     => 'div',
				'Section' => 'section',
				'H1'      => 'h1',
				'H2'      => 'h2',
				'H3'      => 'h3',
				'H4'      => 'h4',
				'H5'      => 'h5',
				'H6'      => 'h6',
				'P'       => 'p',
				'Span'    => 'span',
			),
			'std'         => 'div',
			'admin_label' => true,
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Element Wrapper', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_wrapper',
		'icon'            => 'wolmart-icon wolmart-icon-element-wrapper',
		'class'           => 'wolmart_wrapper',
		'as_parent'       => array( 'except' => 'wpb_wolmart_wrapper' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart element wrapper.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Wrapper extends WPBakeryShortCodesContainer {
	}
}
