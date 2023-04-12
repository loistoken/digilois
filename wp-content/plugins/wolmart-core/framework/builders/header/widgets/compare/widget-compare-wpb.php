<?php
/**
 * Header Compare Button
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )       => array(
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Compare Type', 'wolmart-core' ),
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
			'type'        => 'wolmart_button_group',
			'heading'     => esc_html__( 'Mini Compare List', 'wolmart-core' ),
			'param_name'  => 'minicompare',
			'description' => esc_html__( 'Choose where to display mini compare list', 'wolmart-core' ),
			'std'         => '',
			'value'       => array(
				''          => array(
					'title' => esc_html__( 'Simple', 'wolmart-core' ),
				),
				'dropdown'  => array(
					'title' => esc_html__( 'Dropdown', 'wolmart-core' ),
				),
				'offcanvas' => array(
					'title' => esc_html__( 'Off-Canvas', 'wolmart-core' ),
				),
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Icon', 'wolmart-core' ),
			'param_name' => 'show_icon',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Count', 'wolmart-core' ),
			'param_name' => 'show_count',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'std'        => '',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Label', 'wolmart-core' ),
			'param_name' => 'show_label',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Compare Icon', 'wolmart-core' ),
			'param_name' => 'icon',
			'dependency' => array(
				'element' => 'show_icon',
				'value'   => 'yes',
			),
			'std'        => 'w-icon-compare',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Compare Label', 'wolmart-core' ),
			'param_name' => 'label',
			'std'        => esc_html__( 'Compare', 'wolmart-core' ),
			'dependency' => array(
				'element' => 'show_label',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Dropdown Position', 'wolmart-core' ),
			'param_name' => 'dropdown_pos',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'dependency' => array(
				'element' => 'minicompare',
				'value'   => 'dropdown',
			),
			'selectors'  => array(
				'{{WRAPPER}} .dropdown-box' => 'left: {{VALUE}}{{UNIT}}; right: auto;',
			),
		),
	),
	esc_html__( 'Compare Style', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Compare Typography', 'wolmart-core' ),
			'param_name' => 'compare_typography',
			'selectors'  => array(
				'{{WRAPPER}} .compare-open',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
			'param_name' => 'compare_icon',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-open i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Space', 'wolmart-core' ),
			'param_name' => 'compare_icon_space',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .block-type i + span'  => 'margin-top: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .inline-type i + span' => 'margin-left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
			'param_name' => 'compare_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .compare-open',
				'hover'  => '{{WRAPPER}} .compare-open:hover',
			),
			'choices'    => array( 'color' ),
		),
	),
	esc_html__( 'Compare Badge', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Badge Size', 'wolmart-core' ),
			'param_name' => 'badge_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Horizontal Position', 'wolmart-core' ),
			'param_name' => 'badge_h_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Vertical Position', 'wolmart-core' ),
			'param_name' => 'badge_v_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'top: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Count Background Color', 'wolmart-core' ),
			'param_name' => 'badge_count_bg_color',
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Count Color', 'wolmart-core' ),
			'param_name' => 'badge_count_color',
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Compare', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_hb_compare',
		'icon'            => 'wolmart-icon wolmart-icon-compare',
		'class'           => 'wolmart_hb_compare',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Header', 'wolmart-core' ),
		'description'     => esc_html__( 'Mini compare of dropdown, offcanvas type.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_HB_Compare extends WPBakeryShortCode {
	}
}
