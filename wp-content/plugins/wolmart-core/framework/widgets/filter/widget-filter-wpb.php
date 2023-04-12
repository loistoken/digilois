<?php
/**
 * Filter Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Filter Item Width', 'wolmart-core' ),
			'param_name' => 'filter_width',
			'with_units' => true,
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .wolmart-filter' => 'width: {{VALUE}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Filter Height', 'wolmart-core' ),
			'param_name' => 'filter_height',
			'with_units' => true,
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .btn-filter' => 'height: {{VALUE}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Filter Gap', 'wolmart-core' ),
			'param_name' => 'filter_gap',
			'with_units' => true,
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .align-left > *'   => 'margin-right: {{VALUE}};',
				'{{WRAPPER}} .align-center > *' => 'margin-left: calc( {{VALUE}} / 2 );',
				'{{WRAPPER}} .align-right > *'  => 'margin-left: {{VALUE}};',
			),
			'std'        => '{"xl":"10", "unit":"", "lg":"", "md":"", "sm":"", "xs":""}',
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
			'std'        => 'center',
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
			'param_name' => 'filter_bd_width',
			'selectors'  => array(
				'{{WRAPPER}} .select-ul-toggle' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
			'dependency' => array(
				'element'            => 'filter_bd_style',
				'value_not_equal_to' => 'none',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => __( 'Border Color', 'wolmart-core' ),
			'param_name' => 'filter_bd_color',
			'selectors'  => array(
				'{{WRAPPER}} .select-ul-toggle' => 'border-color: {{VALUE}};',
			),
			'dependency' => array(
				'element'            => 'filter_bd_style',
				'value_not_equal_to' => 'none',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
			'param_name' => 'filter_bd_radius',
			'selectors'  => array(
				'{{WRAPPER}} .select-ul-toggle, {{WRAPPER}} .btn-filter' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Filter Button Label', 'wolmart-core' ),
			'param_name' => 'btn_label',
			'value'      => 'Filter',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Filter Button Skin', 'wolmart-core' ),
			'param_name' => 'btn_skin',
			'std'        => 'btn-primary',
			'value'      => array(
				'btn-primary'   => array(
					'title' => esc_html__( 'Primary', 'wolmart-core' ),
					'color' => 'var(--wolmart-primary-color,#2879FE)',
				),
				'btn-secondary' => array(
					'title' => esc_html__( 'Secondary', 'wolmart-core' ),
					'color' => 'var(--wolmart-secondary-color,#d26e4b)',
				),
				'btn-alert'     => array(
					'title' => esc_html__( 'Alert', 'wolmart-core' ),
					'color' => 'var(--wolmart-alert-color,#b10001)',
				),
				'btn-success'   => array(
					'title' => esc_html__( 'Success', 'wolmart-core' ),
					'color' => 'var(--wolmart-success-color,#a8c26e)',
				),
				'btn-dark'      => array(
					'title' => esc_html__( 'Dark', 'wolmart-core' ),
					'color' => 'var(--wolmart-dark-color,#222)',
				),
				'btn-white'     => array(
					'title' => esc_html__( 'white', 'wolmart-core' ),
					'color' => '#fff',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Product Attribute Filter', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_filter',
		'icon'            => 'wolmart-icon wolmart-icon-filter',
		'class'           => 'wolmart_filter',
		'as_parent'       => array( 'only' => 'wpb_wolmart_filter_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart product attribute filter.', 'wolmart-core' ),
		// 'default_content' => vc_is_inline() ? '[wpb_wolmart_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_wolmart_accordion_item][wpb_wolmart_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_wolmart_accordion_item][wpb_wolmart_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_wolmart_accordion_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Filter extends WPBakeryShortCodesContainer {
	}
}
