<?php
/**
 * Wolmart Single Product Cart Form
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )      => array(
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Add To Cart Sticky', 'wolmart-core' ),
			'param_name' => 'sp_sticky',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'std'        => 'yes',
		),
	),
	esc_html__( 'Button & QTY', 'wolmart-core' ) => array(
		esc_html__( 'Button', 'wolmart-core' )   => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'sp_btn_typo',
				'selectors'  => array(
					'{{WRAPPER}} .cart .button',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'param_name' => 'sp_btn_border',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cart .button' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'param_name' => 'sp_btn_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .cart .button' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_btn_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'param_name' => 'sp_btn_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .cart .button' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}}; border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'sp_btn_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .cart .button' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'sp_btn_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .cart .button',
					'hover'  => '{{WRAPPER}} .cart .button:hover',
					'active' => '{{WRAPPER}} .cart .button:active',
				),
				'choices'    => array( 'color', 'background', 'border' ),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Transition', 'wolmart-core' ),
				'param_name' => 'sp_btn_transition',
				'units'      => array(
					's',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cart .button' => 'transition: all {{VALUE}}{{UNIT}}',
				),
			),
		),
		esc_html__( 'Quantity', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Spacing', 'wolmart-core' ),
				'param_name' => 'quantity_space',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'responsive' => true,
				'selectors'  => array(
					'body:not(.rtl) {{WRAPPER}} .quantity, body.rtl {{WRAPPER}} .quantity' => "margin-{$right}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'sp_qty_typo',
				'selectors'  => array(
					'{{WRAPPER}} .quantity .qty, {{WRAPPER}} .quantity button',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'param_name' => 'sp_qty_border',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .quantity .qty, {{WRAPPER}} .quantity button' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'param_name' => 'sp_qty_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .quantity .qty, {{WRAPPER}} .quantity button' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_qty_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'param_name' => 'sp_qty_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .quantity .qty, {{WRAPPER}} .quantity button' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}}; border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'sp_qty_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .quantity .qty, {{WRAPPER}} .quantity button' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'sp_qty_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .quantity .qty, {{WRAPPER}} .quantity button',
					'hover'  => '{{WRAPPER}} .quantity .qty:hover, {{WRAPPER}} .quantity button:hover',
					'active' => '{{WRAPPER}} .quantity .qty:active, {{WRAPPER}} .quantity button:active',
				),
				'choices'    => array( 'color', 'background', 'border' ),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Transition', 'wolmart-core' ),
				'param_name' => 'sp_qty_transition',
				'units'      => array(
					's',
				),
				'selectors'  => array(
					'{{WRAPPER}} .quantity .qty, {{WRAPPER}} .quantity button' => 'transition: all {{VALUE}}{{UNIT}}',
				),
			),
		),
	),
	esc_html__( 'Variations', 'wolmart-core' )   => array(
		esc_html__( 'General', 'wolmart-core' )      => array(
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Spacing', 'wolmart-core' ),
				'param_name' => 'sp_variations_spacing',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .variations' => 'margin-bottom: {{VALUE}}{{UNIT}};',
				),
			),
		),
		esc_html__( 'Label', 'wolmart-core' )        => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_variations_label_color',
				'selectors'  => array(
					'{{WRAPPER}} .cart label' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'sp_variations_label_typo',
				'selectors'  => array(
					'{{WRAPPER}} .cart label',
				),
			),
		),
		esc_html__( 'List Field', 'wolmart-core' )   => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_variations_list_color',
				'selectors'  => array(
					'{{WRAPPER}} .variations button' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
				'param_name' => 'sp_variations_list_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .variations button' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Color', 'wolmart-core' ),
				'param_name' => 'sp_variations_list_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .variations button' => 'border: 1px solid {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'sp_variations_list_typo',
				'selectors'  => array(
					'{{WRAPPER}} .variations button',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'param_name' => 'sp_variations_list_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .variations button' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}}; border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Select Field', 'wolmart-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_variations_select_color',
				'selectors'  => array(
					'{{WRAPPER}} .cart select' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
				'param_name' => 'sp_variations_select_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .cart select' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Color', 'wolmart-core' ),
				'param_name' => 'sp_variations_select_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .cart select' => 'border: 1px solid {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'sp_variations_select_typo',
				'selectors'  => array(
					'{{WRAPPER}} .cart select',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'param_name' => 'sp_variations_select_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .cart select' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}}; border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Cart Form', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_cart_form',
		'icon'            => 'wolmart-icon wolmart-icon-sp-cart-form',
		'class'           => 'wolmart_sp_cart_form',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create wolmart single product cart form.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Cart_Form extends WPBakeryShortCode {

	}
}
