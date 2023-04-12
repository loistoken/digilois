<?php
/**
 * Wolmart Single Product Share
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Style', 'wolmart-core' ) => array(
		esc_html__( 'General', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Size', 'wolmart-core' ),
				'param_name' => 'sp_size',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .social-icons > .social-icon' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
				'param_name' => 'sp_align',
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
				'selectors'  => array(
					'{{WRAPPER}} .social-icons' => 'justify-content: {{VALUE}}; width: 100%;',
				),
			),
		),
		esc_html__( 'Color', 'wolmart-core' )   => array(
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'sp_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .social-icons > .social-icon',
					'hover'  => '{{WRAPPER}} .social-icons > .social-icon:hover',
					'active' => '{{WRAPPER}} .social-icons > .social-icon:active',
				),
				'choices'    => array( 'color', 'background', 'border' ),
			),
		),
		esc_html__( 'Border', 'wolmart-core' )  => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'param_name' => 'sp_share_border',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .social-icons > .social-icon' => 'border-style: {{VALUE}}; width: 2.5em; height: 2.5em;',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'param_name' => 'sp_share_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .social-icons > .social-icon' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_share_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'param_name' => 'sp_share_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .social-icons > .social-icon' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}}; border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_share_border',
					'value_not_equal_to' => 'none',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Share', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_share',
		'icon'            => 'wolmart-icon wolmart-icon-sp-share',
		'class'           => 'wolmart_sp_share',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product share.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Share extends WPBakeryShortCode {

	}
}
