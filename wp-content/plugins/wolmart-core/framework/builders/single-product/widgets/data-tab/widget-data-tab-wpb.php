<?php
/**
 * Wolmart Single Product Tab Data
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )    => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Type', 'wolmart-core' ),
			'param_name' => 'sp_type',
			'value'      => array(
				esc_html__( 'Theme Option', 'wolmart-core' ) => '',
				esc_html__( 'Tab', 'wolmart-core' )       => 'tab',
				esc_html__( 'Accordion', 'wolmart-core' ) => 'accordion',
			),
			'std'        => '',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'sp_tab_link_align',
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'dependency' => array(
				'element'            => 'sp_type',
				'value_not_equal_to' => 'accordion',
			),
			'std'        => 'left',
			'selectors'  => array(
				'{{WRAPPER}} .wc-tabs > .tabs' => 'justify-content: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Navigation', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
			'param_name' => 'sp_tab_link_typo',
			'selectors'  => array(
				'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'sp_tab_link_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		esc_html__( 'Normal', 'wolmart-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_border',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'border-color: {{VALUE}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_border',
					'value_not_equal_to' => 'none',
				),
			),
		),
		esc_html__( 'Hover', 'wolmart-core' )  => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_hover_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_hover_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_hover_border',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_hover_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_hover_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_hover_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover' => 'border-color: {{VALUE}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_hover_border',
					'value_not_equal_to' => 'none',
				),
			),
		),
		esc_html__( 'Active', 'wolmart-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_active_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header a.active' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_active_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header a.active' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_active_border',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header a.active' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_active_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header a.active' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_active_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_tab_link_active_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header a:active' => 'border-color: {{VALUE}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_active_border',
					'value_not_equal_to' => 'none',
				),
			),
		),
	),
	esc_html__( 'Content', 'wolmart-core' )    => array(
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'sp_tab_link_content_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .panel.woocommerce-Tabs-panel' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Data Tab', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_data_tab',
		'icon'            => 'wolmart-icon wolmart-icon-sp-data',
		'class'           => 'wolmart_sp_data_tab',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product tab data.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Data_Tab extends WPBakeryShortCode {

	}
}
