<?php
/**
 * Header Mobile Menu Toggle Button
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Toggle Icon', 'wolmart-core' ),
			'param_name' => 'icon',
			'std'        => 'w-icon-hamburger',
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
			'param_name' => 'icon_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'toggle_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
			'param_name' => 'toggle_border',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle' => 'border-top: {{TOP}} solid;border-right: {{RIGHT}} solid;border-bottom: {{BOTTOM}} solid;border-left: {{LEFT}} solid;',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
			'param_name' => 'toggle_border_radius',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
			'param_name' => 'toggle_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .mobile-menu-toggle',
				'hover'  => '{{WRAPPER}} .mobile-menu-toggle:hover',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Mobile Menu Toggle', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_hb_mmenu_toggle',
		'icon'            => 'wolmart-icon wolmart-icon-mmenu-toggle',
		'class'           => 'wolmart_hb_mmenu_toggle',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Header', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart mobile menu toggle.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_HB_Mmenu_Toggle extends WPBakeryShortCode {
	}
}
