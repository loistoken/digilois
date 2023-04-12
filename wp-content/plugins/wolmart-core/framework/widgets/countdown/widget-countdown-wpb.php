<?php
/**
 * Wolmart Countdown
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Content', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'align',
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
			'selectors'  => array(
				'{{WRAPPER}} .countdown-container' => 'justify-content: {{VALUE}};',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'type',
			'heading'    => esc_html__( 'Type', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'Block', 'wolmart-core' )  => 'block',
				esc_html__( 'Inline', 'wolmart-core' ) => 'inline',
			),
			'std'        => 'block',
		),
		array(
			'type'       => 'wolmart_datetimepicker',
			'param_name' => 'date',
			'heading'    => esc_html__( 'Target Date', 'wolmart-core' ),
			'value'      => '',
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'timezone',
			'heading'    => esc_html__( 'Timezone', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'WordPress Defined Timezone', 'wolmart-core' )    => '',
				esc_html__( 'User System Timezone', 'wolmart-core' )   => 'user_timezone',
			),
			'std'        => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Label', 'wolmart-core' ),
			'param_name'  => 'label',
			'value'       => 'Offer Ends In',
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'inline',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'label_type',
			'heading'    => esc_html__( 'Unit Type', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'Full', 'wolmart-core' )  => '',
				esc_html__( 'Short', 'wolmart-core' ) => 'short',
			),
			'std'        => '',
			'dependency' => array(
				'element' => 'type',
				'value'   => 'block',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'label_pos',
			'heading'    => esc_html__( 'Unit Position', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'Inner', 'wolmart-core' )  => '',
				esc_html__( 'Outer', 'wolmart-core' )  => 'outer',
				esc_html__( 'Custom', 'wolmart-core' ) => 'custom',
			),
			'std'        => '',
			'dependency' => array(
				'element' => 'type',
				'value'   => 'block',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Label Position', 'wolmart-core' ),
			'param_name' => 'label_dimension',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}} .countdown .countdown-period' => 'bottom: {{VALUE}}{{UNIT}};',
			),
			'dependency' => array(
				'element' => 'label_pos',
				'value'   => 'custom',
			),
		),
		array(
			'type'       => 'wolmart_multiselect',
			'param_name' => 'date_format',
			'heading'    => esc_html__( 'Units', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'Year', 'wolmart-core' )   => 'Y',
				esc_html__( 'Month', 'wolmart-core' )  => 'O',
				esc_html__( 'Week', 'wolmart-core' )   => 'W',
				esc_html__( 'Day', 'wolmart-core' )    => 'D',
				esc_html__( 'Hour', 'wolmart-core' )   => 'H',
				esc_html__( 'Minute', 'wolmart-core' ) => 'M',
				esc_html__( 'Second', 'wolmart-core' ) => 'S',
			),
			'std'        => 'D,H,M,S',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Hide Spliter', 'wolmart-core' ),
			'param_name' => 'hide_split',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'block',
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		esc_html__( 'Dimension', 'wolmart-core' )  => array(
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Item Padding', 'wolmart-core' ),
				'param_name' => 'item_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Label Margin', 'wolmart-core' ),
				'param_name' => 'label_margin',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-label' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'inline',
				),
			),
		),
		esc_html__( 'Typography', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Amount', 'wolmart-core' ),
				'param_name' => 'countdown_amount',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-container .countdown-amount',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Unit, Label', 'wolmart-core' ),
				'param_name' => 'countdown_label',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-period',
					'{{WRAPPER}} .countdown-label',
				),
			),
		),
		esc_html__( 'Color', 'wolmart-core' )      => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Section Background', 'wolmart-core' ),
				'param_name' => 'countdown_section_color',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Amount', 'wolmart-core' ),
				'param_name' => 'countdown_amount_color',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-amount' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Unit, Label', 'wolmart-core' ),
				'param_name' => 'countdown_label_color',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-period' => 'color: {{VALUE}};',
					'{{WRAPPER}} .countdown-label'  => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Separator Color', 'wolmart-core' ),
				'param_name' => 'countdown_separator_color',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section:after' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Border', 'wolmart-core' )     => array(
			array(
				'type'       => 'dropdown',
				'param_name' => 'border-type',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => '',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'std'        => '',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section' => 'border-style: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'block',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'param_name' => 'border-radius',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section' => 'border-radius: {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'block',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Countdown', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_countdown',
		'icon'            => 'wolmart-icon wolmart-icon-timer',
		'class'           => 'wolmart_countdown',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart countdown.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Countdown extends WPBakeryShortCode {

	}
}
