<?php
/**
 * Accordion Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )         => array(
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Accordion Type', 'wolmart-core' ),
			'param_name' => 'accordion_type',
			'std'        => '',
			'value'      => array(
				''       => array(
					'title' => esc_html__( 'Default', 'wolmart-core' ),
				),
				'simple' => array(
					'title' => esc_html__( 'Simple', 'wolmart-core' ),
				),
				'border' => array(
					'title' => esc_html__( 'Border', 'wolmart-core' ),
				),
				'boxed'  => array(
					'title' => esc_html__( 'Boxed', 'wolmart-core' ),
				),
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Card Space', 'wolmart-core' ),
			'param_name' => 'accordion_card_space',
			'units'      => array(
				'px',
				'rem',
			),
			'dependency' => array(
				'element' => 'accordion_type',
				'value'   => 'boxed',
			),
			'selectors'  => array(
				'{{WRAPPER}} .card:not(:last-child)' => 'margin-bottom: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Toggle Icon', 'wolmart-core' ),
			'param_name' => 'accordion_icon',
			'std'        => 'w-icon-plus',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Active Toggle Icon', 'wolmart-core' ),
			'param_name' => 'accordion_active_icon',
			'std'        => 'w-icon-minus',
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Toggle Icon Size', 'wolmart-core' ),
			'param_name' => 'toggle_icon_size',
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .toggle-icon' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
	),
	esc_html__( 'Accordion Style', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
			'param_name' => 'accordion_bd',
			'selectors'  => array(
				'{{WRAPPER}} .card' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'wolmart-core' ),
			'param_name' => 'accordion_bd_color',
			'selectors'  => array(
				'{{WRAPPER}} .accordion' => 'border-color: {{VALUE}};',
				'{{WRAPPER}} .card'      => 'border-color: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Card Item Style', 'wolmart-core' ) => array(
		esc_html__( 'Header', 'wolmart-core' )  => array(
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'accordion_header_pad',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .card-header > a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
					'{{WRAPPER}} .opened, {{WRAPPER}} .closed' => 'right: {{RIGHT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'param_name' => 'accordion_header_bd',
				'selectors'  => array(
					'{{WRAPPER}} .card-header a' => 'border: 1px solid; border-color: inherit; border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'panel_header_typography',
				'selectors'  => array(
					'{{WRAPPER}} .card-header > a',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'accordion_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .card-header a',
					'hover'  => '{{WRAPPER}} .card-header a:hover',
					'active' => '{{WRAPPER}} .card-header a:not(.expand)',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Prefix Icon Size', 'wolmart-core' ),
				'param_name' => 'accordion_icon_size',
				'units'      => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .card-header a > i:first-child' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Prefix Icon Space', 'wolmart-core' ),
				'param_name' => 'accordion_icon_space',
				'units'      => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .card-header a > i:first-child' => 'margin-right: {{VALUE}}{{UNIT}};',
				),
			),
		),
		esc_html__( 'Content', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'accordion_content_pad',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .card-body' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Accordion', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_accordion',
		'icon'            => 'wolmart-icon wolmart-icon-accordion',
		'class'           => 'wolmart_accordion',
		'as_parent'       => array( 'only' => 'wpb_wolmart_accordion_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart accordion.', 'wolmart-core' ),
		'default_content' => vc_is_inline() ? '[wpb_wolmart_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_wolmart_accordion_item][wpb_wolmart_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_wolmart_accordion_item][wpb_wolmart_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_wolmart_accordion_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Accordion extends WPBakeryShortCodesContainer {
	}
}
