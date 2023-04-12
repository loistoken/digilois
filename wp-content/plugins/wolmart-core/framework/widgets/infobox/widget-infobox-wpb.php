<?php
/**
 * InfoBox Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'wolmart-core' ),
			'param_name' => 'icon',
			'std'        => 'w-icon-truck',
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'enable_svg',
			'heading'     => esc_html__( 'Enable SVG', 'wolmart-core' ),
			'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'description' => esc_html__( 'Enable to display SVG.', 'wolmart-core' ),
		),
		array(
			'type'        => 'textarea_raw_html',
			'heading'     => esc_html__( 'SVG HTML', 'wolmart-core' ),
			'param_name'  => 'svg_html',
			'placeholder' => esc_html__( 'Your SVG Html...', 'wolmart-core' ),
			'description' => esc_html__( 'Enter your SVG Html here.', 'wolmart-core' ),
			'dependency'  => array(
				'element' => 'enable_svg',
				'value'   => array(
					'yes',
				),
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'wolmart-core' ),
			'param_name'  => 'title',
			'value'       => esc_html__( 'Free Shipping & Return', 'wolmart-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Description', 'wolmart-core' ),
			'param_name'  => 'description',
			'value'       => esc_html__( 'Free shipping on orders over $99', 'wolmart-core' ),
			'admin_label' => true,
		),
		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Link Url', 'wolmart-core' ),
			'param_name' => 'link',
			'value'      => '',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Title HTML Tag', 'wolmart-core' ),
			'param_name' => 'html_tag',
			'value'      => array(
				'H1' => 'h1',
				'H2' => 'h2',
				'H3' => 'h3',
				'H4' => 'h4',
				'H5' => 'h5',
				'H6' => 'h6',
				'p'  => 'p',
			),
			'std'        => 'h3',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Icon Position', 'wolmart-core' ),
			'param_name' => 'icon_pos',
			'value'      => array(
				'left'  => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
				),
				'top'   => array(
					'title' => esc_html__( 'Top', 'wolmart-core' ),
				),
				'right' => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
				),
			),
			'std'        => 'left',
			'dependency' => array(
				'element'   => 'icon',
				'not_empty' => true,
			),
			'selectors'  => array(
				'{{WRAPPER}}.icon-box-right' => 'flex-direction: row-reverse;',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'content_alignment',
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
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}.icon-box'          => 'text-align: {{VALUE}}',
				'{{WRAPPER}} .icon-box-content' => 'text-align: {{VALUE}}',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Vertical Alignment', 'wolmart-core' ),
			'param_name' => 'vertical_alignment',
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Top', 'wolmart-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Middle', 'wolmart-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Bottom', 'wolmart-core' ),
				),
			),
			'std'        => 'center',
			'selectors'  => array(
				'{{WRAPPER}}.icon-box-side' => 'align-items: {{VALUE}}',
			),
			'dependency' => array(
				'element'            => 'icon_pos',
				'value_not_equal_to' => 'top',
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		esc_html__( 'Icon', 'wolmart-core' )    => array(
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'icon_border',
				'heading'    => esc_html__( 'Border', 'wolmart-core' ),
				'responsive' => false,
				'selectors'  => array(
					'{{WRAPPER}} .icon-box-icon' => 'border-top:{{TOP}} solid;border-right:{{RIGHT}} solid;border-bottom:{{BOTTOM}} solid;border-left:{{LEFT}} solid;',
				),
				'dependency' => array(
					'element'   => 'icon',
					'not_empty' => true,
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
					'{{WRAPPER}} .icon-box-icon' => 'border-radius: {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element'   => 'icon',
					'not_empty' => true,
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
					'{{WRAPPER}} .icon-box-icon' => 'width: {{VALUE}}{{UNIT}};height: {{VALUE}}{{UNIT}};flex: 0 0 {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element'   => 'icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Icon Colors', 'wolmart-core' ),
				'param_name' => 'icon_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .icon-box-icon, {{WRAPPER}} .icon-box-icon a',
					'hover'  => '{{WRAPPER}} .icon-box-icon:hover, .icon-box-icon a:hover',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
				'dependency' => array(
					'element'   => 'icon',
					'not_empty' => true,
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
					'{{WRAPPER}} .icon-box-icon' => 'font-size: {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element'   => 'icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Icon Spacing', 'wolmart-core' ),
				'param_name' => 'icon_space',
				'responsive' => true,
				'units'      => array(
					'px',
				),
				'selectors'  => array(
					'{{WRAPPER}}.icon-box-left .icon-box-icon'  => "margin-{$right}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}}.icon-box-right .icon-box-icon' => "margin-{$left}: {{VALUE}}{{UNIT}};margin-{$right}: 0;",
					'{{WRAPPER}}.icon-box-top .icon-box-icon'   => 'margin-bottom: {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element'   => 'icon',
					'not_empty' => true,
				),
			),
		),
		esc_html__( 'Content', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Title Spacing', 'wolmart-core' ),
				'param_name' => 'title_space',
				'responsive' => true,
				'units'      => array(
					'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .icon-box-title' => 'margin-bottom: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Title Typography', 'wolmart-core' ),
				'param_name' => 'title_font',
				'selectors'  => array(
					'{{WRAPPER}} .icon-box-title',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Title Color', 'wolmart-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .icon-box-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Description Spacing', 'wolmart-core' ),
				'param_name' => 'description_space',
				'responsive' => true,
				'units'      => array(
					'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .icon-box-content p' => 'margin-bottom: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Description Typography', 'wolmart-core' ),
				'param_name' => 'description_font',
				'selectors'  => array(
					'{{WRAPPER}} .icon-box-content p',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Description Color', 'wolmart-core' ),
				'param_name' => 'description_color',
				'selectors'  => array(
					'{{WRAPPER}} .icon-box-content p' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'InfoBox', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_infobox',
		'icon'            => 'wolmart-icon wolmart-icon-infobox',
		'class'           => 'wolmart_infobox',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart infobox.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Wolmart_Infobox extends WPBakeryShortCode {
	}
}
