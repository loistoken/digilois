<?php
/**
 * Button Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Button Title', 'wolmart-core' ),
			'param_name'  => 'label',
			'value'       => esc_html( 'Click here', 'wolmart-core' ),
			'admin_label' => true,
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Expand Button', 'wolmart-core' ),
			'param_name' => 'button_expand',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'button_align',
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
			'dependency' => array(
				'element'            => 'button_expand',
				'value_not_equal_to' => 'yes',
			),
			'std'        => 'left',
			'selectors'  => array(
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			),
		),
		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Link Url', 'wolmart-core' ),
			'param_name' => 'link',
			'value'      => '',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Type', 'wolmart-core' ),
			'param_name' => 'button_type',
			'value'      => array(
				esc_html__( 'Default', 'wolmart-core' ) => 'default',
				esc_html__( 'Solid', 'wolmart-core' )   => 'btn-solid',
				esc_html__( 'Outline', 'wolmart-core' ) => 'btn-outline',
				esc_html__( 'Inline', 'wolmart-core' )  => 'btn-link',
			),
			'std'        => 'default',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Size', 'wolmart-core' ),
			'param_name' => 'button_size',
			'value'      => array(
				'btn-sm'  => array(
					'title' => esc_html__( 'Small', 'wolmart-core' ),
				),
				'btn-md'  => array(
					'title' => esc_html__( 'Medium', 'wolmart-core' ),
				),
				'default' => array(
					'title' => esc_html__( 'Normal', 'wolmart-core' ),
				),
				'btn-lg'  => array(
					'title' => esc_html__( 'Large', 'wolmart-core' ),
				),
			),
			'std'        => 'default',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Hover Underline', 'wolmart-core' ),
			'param_name' => 'link_hover_type',
			'value'      => array(
				'default'          => array(
					'title' => esc_html__( 'None', 'wolmart-core' ),
				),
				'btn-underline sm' => array(
					'title' => esc_html__( 'Underline1', 'wolmart-core' ),
				),
				'btn-underline'    => array(
					'title' => esc_html__( 'Underline2', 'wolmart-core' ),
				),
				'btn-underline lg' => array(
					'title' => esc_html__( 'Underline3', 'wolmart-core' ),
				),
			),
			'std'        => 'default',
			'dependency' => array(
				'element' => 'button_type',
				'value'   => 'btn-link',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Box Shadow', 'wolmart-core' ),
			'param_name' => 'shadow',
			'value'      => array(
				esc_html__( 'None', 'wolmart-core' )     => 'default',
				esc_html__( 'Shadow 1', 'wolmart-core' ) => 'btn-shadow-sm',
				esc_html__( 'Shadow 2', 'wolmart-core' ) => 'btn-shadow',
				esc_html__( 'Shadow 3', 'wolmart-core' ) => 'btn-shadow-lg',
			),
			'std'        => 'default',
			'dependency' => array(
				'element'            => 'button_type',
				'value_not_equal_to' => 'btn-link',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Border Style', 'wolmart-core' ),
			'param_name' => 'button_border',
			'label_type' => 'icon',
			'value'      => array(
				'default'     => array(
					'title' => esc_html__( 'Rectangle', 'wolmart-core' ),
					'icon'  => 'attr-icon-square',
				),
				'btn-rounded' => array(
					'title' => esc_html__( 'Rounded', 'wolmart-core' ),
					'icon'  => 'attr-icon-rounded',
				),
				'btn-ellipse' => array(
					'title' => esc_html__( 'Ellipse', 'wolmart-core' ),
					'icon'  => 'attr-icon-ellipse',
				),
			),
			'std'        => 'default',
			'dependency' => array(
				'element'            => 'button_type',
				'value_not_equal_to' => 'btn-link',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Skin', 'wolmart-core' ),
			'param_name' => 'button_skin',
			'value'      => array(
				'default'       => array(
					'title' => esc_html__( 'Default', 'wolmart-core' ),
					'color' => '#eee',
				),
				'btn-primary'   => array(
					'title' => esc_html__( 'Primary', 'wolmart-core' ),
					'color' => 'var(--wolmart-primary-color,#2879FE)',
				),
				'btn-secondary' => array(
					'title' => esc_html__( 'Secondary', 'wolmart-core' ),
					'color' => 'var(--wolmart-secondary-color,#f93)',
				),
				'btn-alert'     => array(
					'title' => esc_html__( 'Alert', 'wolmart-core' ),
					'color' => 'var(--wolmart-alert-color,#a94442)',
				),
				'btn-success'   => array(
					'title' => esc_html__( 'Success', 'wolmart-core' ),
					'color' => 'var(--wolmart-success-color,#799b5a)',
				),
				'btn-dark'      => array(
					'title' => esc_html__( 'Dark', 'wolmart-core' ),
					'color' => 'var(--wolmart-dark-color,#333)',
				),
				'btn-white'     => array(
					'title' => esc_html__( 'white', 'wolmart-core' ),
					'color' => '#fff',
				),
			),
			'std'        => 'default',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Disable Line-break', 'wolmart-core' ),
			'param_name' => 'line_break',
			'value'      => array(
				'nowrap' => array(
					'title' => esc_html__( 'On', 'wolmart-core' ),
				),
				'normal' => array(
					'title' => esc_html__( 'Off', 'wolmart-core' ),
				),
			),
			'std'        => 'nowrap',
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'white-space: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Icon', 'wolmart-core' )    => array(
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Icon?', 'wolmart-core' ),
			'param_name' => 'show_icon',
			'value'      => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Label', 'wolmart-core' ),
			'param_name' => 'show_label',
			'value'      => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
			'std'        => 'yes',
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'wolmart-core' ),
			'param_name' => 'icon',
			'std'        => '',
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Icon Position', 'wolmart-core' ),
			'param_name' => 'icon_pos',
			'value'      => array(
				'after'  => array(
					'title' => esc_html__( 'After', 'wolmart-core' ),
				),
				'before' => array(
					'title' => esc_html__( 'Before', 'wolmart-core' ),
				),
			),
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Spacing', 'wolmart-core' ),
			'param_name' => 'icon_space',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'value'      => '',
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
			'selectors'  => array(
				'{{WRAPPER}} .btn-icon-left:not(.btn-reveal-left) i' => "margin-{$right}: {{VALUE}}{{UNIT}};",
				'{{WRAPPER}} .btn-icon-right:not(.btn-reveal-right) i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
				'{{WRAPPER}} .btn-reveal-left:hover i, {{WRAPPER}} .btn-reveal-left:active i, {{WRAPPER}} .btn-reveal-left:focus i'  => "margin-{$right}: {{VALUE}}{{UNIT}};",
				'{{WRAPPER}} .btn-reveal-right:hover i, {{WRAPPER}} .btn-reveal-right:active i, {{WRAPPER}} .btn-reveal-right:focus i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
			'param_name' => 'icon_size',
			'value'      => '',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
			'selectors'  => array(
				'{{WRAPPER}} .btn i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Icon Hover Effect', 'wolmart-core' ),
			'param_name' => 'icon_hover_effect',
			'value'      => array(
				esc_html__( 'none', 'wolmart-core' )       => 'default',
				esc_html__( 'Slide Left', 'wolmart-core' ) => 'btn-slide-left',
				esc_html__( 'Slide Right', 'wolmart-core' ) => 'btn-slide-right',
				esc_html__( 'Slide Up', 'wolmart-core' )   => 'btn-slide-up',
				esc_html__( 'Slide Down', 'wolmart-core' ) => 'btn-slide-down',
				esc_html__( 'Reveal Left', 'wolmart-core' ) => 'btn-reveal-left',
				esc_html__( 'Reveal Right', 'wolmart-core' ) => 'btn-reveal-right',
			),
			'std'        => 'default',
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Animation Infinite', 'wolmart-core' ),
			'param_name' => 'icon_hover_effect_infinite',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Buttton Padding', 'wolmart-core' ),
			'param_name' => 'button_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Buttton Border Width', 'wolmart-core' ),
			'param_name' => 'button_border_width',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Button Typography', 'wolmart-core' ),
			'param_name' => 'btn_font',
			'selectors'  => array(
				'{{WRAPPER}} .btn',
			),
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
			'param_name' => 'btn_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .btn',
				'hover'  => '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus',
				'active' => '{{WRAPPER}} .btn:active',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Button', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_button',
		'icon'            => 'wolmart-icon wolmart-icon-button',
		'class'           => 'wolmart_button',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart button.', 'wolmart-core' ),
		'params'          => $params,
	)
);


if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Button extends WPBakeryShortCode {
	}
}
