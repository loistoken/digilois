<?php
/**
 * Logo Element
 *
 * @since 1.0.0
 */

$params = array(
	array(
		'type'       => 'dropdown',
		'param_name' => 'logo_image_size',
		'heading'    => esc_html__( 'Image Size', 'wolmart-core' ),
		'value'      => wolmart_get_image_sizes(),
	),
	array(
		'type'       => 'wolmart_number',
		'heading'    => esc_html__( 'Width', 'wolmart-core' ),
		'param_name' => 'logo_width',
		'units'      => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'      => '',
		'selectors'  => array(
			'{{WRAPPER}} .logo' => 'width: {{VALUE}}{{UNIT}};',
		),
	),
	array(
		'type'       => 'wolmart_number',
		'heading'    => esc_html__( 'Max Width', 'wolmart-core' ),
		'param_name' => 'logo_max_width',
		'units'      => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'      => '',
		'selectors'  => array(
			'{{WRAPPER}} .logo' => 'max-width: {{VALUE}}{{UNIT}};',
		),
	),
	array(
		'type'       => 'wolmart_number',
		'heading'    => esc_html__( 'Width on Sticky', 'wolmart-core' ),
		'param_name' => 'logo_width_sticky',
		'units'      => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'      => '',
		'selectors'  => array(
			'.fixed {{WRAPPER}} .logo' => 'width: {{VALUE}}{{UNIT}};',
		),
	),
	array(
		'type'       => 'wolmart_number',
		'heading'    => esc_html__( 'Max Width on Sticky', 'wolmart-core' ),
		'param_name' => 'logo_max_width_sticky',
		'units'      => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'      => '',
		'selectors'  => array(
			'.fixed {{WRAPPER}} .logo' => 'max-width: {{VALUE}}{{UNIT}};',
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Logo', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_logo',
		'icon'            => 'wolmart-icon wolmart-icon-logo',
		'class'           => 'wolmart_logo',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart site logo.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Logo extends WPBakeryShortCode {
	}
}
