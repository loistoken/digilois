<?php
/**
 * Wolmart Breadcrumb
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Delimiter', 'wolmart-core' ),
			'param_name'  => 'delimiter',
			'description' => 'You can use text, number or symbol as delimiter.',
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Delimiter Icon', 'wolmart-core' ),
			'param_name'  => 'delimiter_icon',
			'description' => 'You can use icon as delimiter.',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Home Icon', 'wolmart-core' ),
			'param_name' => 'home_icon',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
			'param_name' => 'breadcrumb_typography',
			'selectors'  => array(
				'{{WRAPPER}} .breadcrumb',
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
				'{{WRAPPER}} .breadcrumb' => 'justify-content: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Normal Color', 'wolmart-core' ),
			'param_name' => 'normal_color',
			'std'        => '#666',
			'value'      => '#666',
			'selectors'  => array(
				'{{WRAPPER}} .breadcrumb'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .breadcrumb a' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Hover Color', 'wolmart-core' ),
			'param_name' => 'hover_color',
			'selectors'  => array(
				'{{WRAPPER}} .breadcrumb a'       => 'opacity: 1;',
				'{{WRAPPER}} .breadcrumb a:hover' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Delimiter Size', 'wolmart-core' ),
			'param_name' => 'delimiter_size',
			'units'      => array(
				'px',
				'rem',
			),
			'value'      => '',
			'selectors'  => array(
				'{{WRAPPER}} .delimiter' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Delimiter Space', 'wolmart-core' ),
			'param_name' => 'delimiter_space',
			'units'      => array(
				'px',
				'rem',
			),
			'value'      => '',
			'selectors'  => array(
				'{{WRAPPER}} .delimiter' => 'margin: 0 {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'button_padding',
			'selectors'  => array(
				'{{WRAPPER}} .breadcrumb' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Breadcrumb', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_breadcrumb',
		'icon'            => 'wolmart-icon wolmart-icon-breadcrumb',
		'class'           => 'wolmart_breadcrumb',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart breadcrumb.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Breadcrumb extends WPBakeryShortCode {

	}
}
