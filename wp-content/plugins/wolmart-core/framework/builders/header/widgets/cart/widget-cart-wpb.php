<?php
/**
 * Wolmart Header Cart
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		esc_html__( 'Cart Type', 'wolmart-core' )  => array(
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Cart Type', 'wolmart-core' ),
				'param_name' => 'type',
				'std'        => 'inline',
				'value'      => array(
					'block'  => array(
						'title' => esc_html__( 'Block', 'wolmart-core' ),
					),
					'inline' => array(
						'title' => esc_html__( 'Inline', 'wolmart-core' ),
					),
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Cart Icon Type', 'wolmart-core' ),
				'param_name' => 'icon_type',
				'std'        => 'badge',
				'value'      => array(
					'badge' => array(
						'title' => esc_html__( 'Badge Type', 'wolmart-core' ),
					),
					'label' => array(
						'title' => esc_html__( 'Label Type', 'wolmart-core' ),
					),
				),
			),
			array(
				'type'       => 'iconpicker',
				'heading'    => esc_html__( 'Cart Icon', 'wolmart-core' ),
				'param_name' => 'icon',
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'std'        => 'w-icon-cart',
			),
		),
		esc_html__( 'Cart Label', 'wolmart-core' ) => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Label', 'wolmart-core' ),
				'param_name' => 'show_label',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'std'        => 'yes',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Cart Label', 'wolmart-core' ),
				'param_name' => 'label',
				'std'        => esc_html__( 'My Cart', 'wolmart-core' ),
				'dependency' => array(
					'element' => 'show_label',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Cart Total Price', 'wolmart-core' ),
				'param_name' => 'show_price',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'std'        => 'yes',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Delimiter', 'wolmart-core' ),
				'param_name' => 'delimiter',
				'std'        => '/',
				'dependency' => array(
					'element' => 'show_label',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Cart Count Prefix', 'wolmart-core' ),
				'param_name' => 'count_pfx',
				'std'        => '(',
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'label',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Cart Count Suffix', 'wolmart-core' ),
				'param_name' => 'count_sfx',
				'std'        => esc_html__( 'items )', 'wolmart-core' ),
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'label',
				),
			),
		),
		esc_html__( 'Off Canvas', 'wolmart-core' ) => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Off Canvas', 'wolmart-core' ),
				'param_name' => 'cart_off_canvas',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'std'        => 'yes',
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		esc_html__( 'Cart Toggle', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'cart_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .cart-toggle' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'cart_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .cart-toggle',
					'hover'  => '{{WRAPPER}} .cart-dropdown:hover .cart-toggle',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Cart Label', 'wolmart-core' )  => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'cart_typography',
				'selectors'  => array(
					'{{WRAPPER}} .cart-toggle, {{WRAPPER}} .cart-count',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Delimiter Space', 'wolmart-core' ),
				'param_name' => 'cart_delimiter_space',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cart-name-delimiter' => 'margin: 0 {{VALUE}}{{UNIT}};',
				),
			),
		),
		esc_html__( 'Cart Price', 'wolmart-core' )  => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'cart_price_typography',
				'selectors'  => array(
					'{{WRAPPER}} .cart-price',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'param_name' => 'cart_price_margin',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .cart-price' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Cart Icon', 'wolmart-core' )   => array(
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
				'param_name' => 'cart_icon_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cart-dropdown .cart-toggle i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Icon Space', 'wolmart-core' ),
				'param_name' => 'cart_icon_space',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .block-type .cart-label + i' => 'margin-bottom: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .inline-type .cart-label + i' => "margin-{$left}: {{VALUE}}{{UNIT}};",
				),
			),
		),
		esc_html__( 'Badge', 'wolmart-core' )       => array(
			array(
				'type'       => 'wolmart_heading',
				'label'      => esc_html__( 'These options are avaiable only in badge icon type.', 'wolmart-core' ),
				'param_name' => 'cart_badge_style_description',
				'tag'        => 'p',
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Badge Size', 'wolmart-core' ),
				'param_name' => 'badge_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'selectors'  => array(
					'{{WRAPPER}} .badge-type .cart-count' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Horizontal Position', 'wolmart-core' ),
				'param_name' => 'badge_h_position',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'selectors'  => array(
					'{{WRAPPER}} .badge-type .cart-count' => "{$left}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Vertical Position', 'wolmart-core' ),
				'param_name' => 'badge_v_position',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'selectors'  => array(
					'{{WRAPPER}} .badge-type .cart-count' => 'top: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Count Background Color', 'wolmart-core' ),
				'param_name' => 'badge_count_bg_color',
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'selectors'  => array(
					'{{WRAPPER}} .badge-type .cart-count' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Count Color', 'wolmart-core' ),
				'param_name' => 'badge_count_bd_color',
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'selectors'  => array(
					'{{WRAPPER}} .badge-type .cart-count' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Cart Form', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_hb_cart',
		'icon'            => 'wolmart-icon wolmart-icon-cart',
		'class'           => 'wolmart_hb_cart',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Header', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart cart.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_HB_Cart extends WPBakeryShortCode {
	}
}
