<?php
/**
 * Header Language Switcher Button
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Switcher Toggle', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
			'param_name' => 'toggle_typography',
			'selectors'  => array(
				'{{WRAPPER}} .switcher .switcher-toggle',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'toggle_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher .switcher-toggle .switcher > li > a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
			'param_name' => 'toggle_border',
			'selectors'  => array(
				'{{WRAPPER}} .switcher .switcher-toggle' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}}; border-style: solid;',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
			'param_name' => 'toggle_border_radius',
			'selectors'  => array(
				'{{WRAPPER}} .switcher .switcher-toggle' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
			'param_name' => 'toggle_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .switcher .switcher-toggle',
				'hover'  => '{{WRAPPER}} .menu > li:hover > a',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
	esc_html__( 'Dropdown Box', 'wolmart-core' )    => array(
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'dropdown_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Position', 'wolmart-core' ),
			'param_name' => 'dropdown_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'left: {{VALUE}}{{UNIT}}; right: auto;',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Border', 'wolmart-core' ),
			'param_name' => 'dropdown_border_style',
			'std'        => 'none',
			'value'      => array(
				esc_html__( 'None', 'wolmart-core' )   => 'none',
				esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
				esc_html__( 'Double', 'wolmart-core' ) => 'double',
				esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
				esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
				esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'border-style: {{VALUE}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
			'param_name' => 'dropdown_border_width',
			'dependency' => array(
				'element'            => 'dropdown_border_style',
				'value_not_equal_to' => 'none',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'wolmart-core' ),
			'param_name' => 'dropdown_border_color',
			'dependency' => array(
				'element'            => 'dropdown_border_style',
				'value_not_equal_to' => 'none',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'border-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
			'param_name' => 'dropdown_bg',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'background-color: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Currency Item', 'wolmart-core' )   => array(
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
			'param_name' => 'item_typography',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'item_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
			'param_name' => 'item_margin',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
			'param_name' => 'item_border',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}}; border-style: solid;',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
			'param_name' => 'item_border_radius',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
			'param_name' => 'item_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .switcher ul a',
				'hover'  => '{{WRAPPER}} .switcher ul > li:hover a',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Language Switcher', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_hb_language_switcher',
		'icon'            => 'wolmart-icon wolmart-icon-language',
		'class'           => 'wolmart_hb_language_switcher',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Header', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart language switcher.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_HB_Language_Switcher extends WPBakeryShortCode {
	}
}
