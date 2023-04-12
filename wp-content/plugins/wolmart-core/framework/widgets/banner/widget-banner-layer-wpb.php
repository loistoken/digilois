<?php
/**
 * Banner Layer Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Origin', 'wolmart-core' ),
			'param_name' => 'banner_origin',
			'value'      => array(
				esc_html__( 'Default', 'wolmart-core' ) => 't-none',
				esc_html__( 'Vertical Center', 'wolmart-core' ) => 't-m',
				esc_html__( 'Horizontal Center', 'wolmart-core' ) => 't-c',
				esc_html__( 'Center', 'wolmart-core' )  => 't-mc',
			),
			'std'        => 't-mc',
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Position', 'wolmart-core' ),
			'param_name' => 'layer_pos',
			'std'        => '{"top":{"xl":"50%","xs":"","sm":"","md":"","lg":""},"right":{"xs":"","sm":"","md":"","lg":"","xl":""},"bottom":{"xs":"","sm":"","md":"","lg":"","xl":""},"left":{"xs":"","sm":"","md":"","lg":"","xl":"50%"}}',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}' => 'top: {{TOP}};right: {{RIGHT}};bottom: {{BOTTOM}};left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'align',
			'value'      => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => 'left',
			'selectors'  => array(
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Width', 'wolmart-core' ),
			'param_name' => 'layer_width',
			'responsive' => true,
			'value'      => '',
			'std'        => '{"xl":"300","unit":"px"}',
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}}.banner-content' => 'max-width: {{VALUE}}{{UNIT}}; width: 100%;',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Height', 'wolmart-core' ),
			'param_name' => 'layer_height',
			'responsive' => true,
			'value'      => '',
			'units'      => array(
				'px',
				'%',
			),
			'std'        => '{"xl":"300","unit":"px"}',
			'selectors'  => array(
				'{{WRAPPER}}'                       => 'height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .banner-content-inner' => 'height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'layer_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
			'param_name' => 'layer_bgcolor',
			'selectors'  => array(
				'{{WRAPPER}}' => 'background-color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Banner Layer', 'wolmart-core' ),
		'base'                    => 'wpb_wolmart_banner_layer',
		'icon'                    => 'wolmart-icon wolmart-icon-banner',
		'class'                   => 'wpb_wolmart_banner_layer',
		'controls'                => 'full',
		'category'                => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'             => esc_html__( 'Create wolmart banner layer.', 'wolmart-core' ),
		'as_child'                => array( 'only' => 'wpb_wolmart_banner, wpb_wolmart_products_banner_item' ),
		'as_parent'               => array( 'except' => 'wpb_wolmart_banner, wpb_wolmart_banner_layer' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Banner_Layer extends WPBakeryShortCodesContainer {

	}
}
