<?php
/**
 * Share Icons Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'       => 'dropdown',
			'param_name' => 'share_direction',
			'heading'    => esc_html__( 'Share Direction', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'Row', 'wolmart-core' )    => 'flex',
				esc_html__( 'Column', 'wolmart-core' ) => 'block',
			),
			'std'        => 'flex',
			'selectors'  => array(
				'{{WRAPPER}}.social-icons' => 'display:{{VALUE}};',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'border_type',
			'heading'    => esc_html__( 'Border Style', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'Rectangle', 'wolmart-core' ) => '0',
				esc_html__( 'Rounded', 'wolmart-core' )   => '10px',
				esc_html__( 'Circle', 'wolmart-core' )    => '50%',
			),
			'std'        => '50%',
			'selectors'  => array(
				'{{WRAPPER}} .social-icon' => 'border-radius:{{VALUE}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'param_name' => 'icon_border',
			'heading'    => esc_html__( 'Border', 'wolmart-core' ),
			'responsive' => false,
			'selectors'  => array(
				'{{WRAPPER}} .social-icon' => 'border-top:{{TOP}} solid;border-right:{{RIGHT}} solid;border-bottom:{{BOTTOM}} solid;border-left:{{LEFT}} solid;',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
			'param_name' => 'br_radius',
			'responsive' => false,
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .social-icon' => 'border-radius: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Background Size', 'wolmart-core' ),
			'param_name' => 'bg_size',
			'responsive' => false,
			'units'      => array(
				'px',
			),
			'selectors'  => array(
				'{{WRAPPER}} .social-icon' => 'width: {{VALUE}}{{UNIT}};height: {{VALUE}}{{UNIT}};display:inline-flex;align-items:center;justify-content:center;',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
			'param_name' => 'icon_size',
			'responsive' => true,
			'units'      => array(
				'px',
			),
			'selectors'  => array(
				'{{WRAPPER}} .social-icon i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Icon Colors', 'wolmart-core' ),
			'param_name' => 'icon_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .social-icon',
				'hover'  => '{{WRAPPER}} .social-icon:hover',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Column Spacing', 'wolmart-core' ),
			'param_name' => 'icon_spacing',
			'responsive' => true,
			'units'      => array(
				'px',
				'%',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .social-icon'            => 'margin-right: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .social-icon:last-child' => 'margin-right: 0;',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Row Spacing', 'wolmart-core' ),
			'param_name' => 'row_space',
			'responsive' => true,
			'units'      => array(
				'px',
				'%',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .social-icon + .social-icon' => 'margin-top: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Share Icons', 'wolmart-core' ),
		'base'                    => 'wpb_wolmart_share_icons',
		'icon'                    => 'wolmart-icon wolmart-icon-share',
		'class'                   => 'wpb_wolmart_share_icons',
		'controls'                => 'full',
		'category'                => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'             => esc_html__( 'Create wolmart share icons.', 'wolmart-core' ),
		'as_parent'               => array( 'only' => 'wpb_wolmart_share_icon' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'default_content'         => '[wpb_wolmart_share_icon icon="facebook"][wpb_wolmart_share_icon icon="twitter"][wpb_wolmart_share_icon icon="linkedin"]',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Share_Icons extends WPBakeryShortCodesContainer {

	}
}
