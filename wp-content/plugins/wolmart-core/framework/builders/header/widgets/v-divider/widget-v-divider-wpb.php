<?php
/**
 * Header V-Divider Button
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'wolmart-core' ),
			'param_name' => 'divider_color',
			'selectors'  => array(
				'{{WRAPPER}} .divider' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Height', 'wolmart-core' ),
			'param_name' => 'divider_height',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
				'vh',
			),
			'selectors'  => array(
				'{{WRAPPER}} .divider' => 'height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Width', 'wolmart-core' ),
			'param_name' => 'divider_width',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
				'vw',
			),
			'selectors'  => array(
				'{{WRAPPER}} .divider' => 'width: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Vertical Divider', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_hb_v_divider',
		'icon'            => 'wolmart-icon wolmart-icon-vertical-divider',
		'class'           => 'wolmart_hb_v_divider',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Header', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart vertical divider.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_HB_V_Divider extends WPBakeryShortCode {
	}
}
