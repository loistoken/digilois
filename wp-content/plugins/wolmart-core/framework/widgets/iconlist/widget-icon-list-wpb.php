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
			'param_name' => 'view',
			'heading'    => esc_html__( 'Layout', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'Default', 'wolmart-core' ) => 'block',
				esc_html__( 'Inline', 'wolmart-core' )  => 'inline',
			),
			'std'        => 'block',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'icon_h_align',
			'value'      => array(
				'start'  => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
				),
				'end'    => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
				),
			),
			'dependency' => array(
				'element' => 'view',
				'value'   => 'block',
			),
			'std'        => 'start',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'icon_v_align',
			'value'      => array(
				'start'  => array(
					'title' => esc_html__( 'Top', 'wolmart-core' ),
				),
				'center' => array(
					'title' => esc_html__( 'Middle', 'wolmart-core' ),
				),
				'end'    => array(
					'title' => esc_html__( 'Bottom', 'wolmart-core' ),
				),
			),
			'dependency' => array(
				'element' => 'view',
				'value'   => 'inline',
			),
			'std'        => 'center',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'wolmart-core' ),
			'param_name'  => 'title',
			'placeholder' => esc_html( 'Enter your title', 'wolmart-core' ),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		esc_html__( 'Title', 'wolmart-core' )     => array(
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'param_name' => 'title_margin',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .list-title' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'title_typography',
				'selectors'  => array(
					'{{WRAPPER}} .list-title',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .list-title' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'List Item', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'item_typography',
				'selectors'  => array(
					'{{WRAPPER}} .wolmart-icon-list-item',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'item_padding',
				'responsive' => true,
				'std'        => '{``top``:{``xl``:``5``,``xs``:````,``sm``:````,``md``:````,``lg``:````},``right``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``10``},``bottom``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``5``},``left``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``10``}}',
				'selectors'  => array(
					'{{WRAPPER}} .wolmart-icon-list-item' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'item_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .wolmart-icon-list-item',
					'hover'  => '{{WRAPPER}} .wolmart-icon-list-item:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Divider', 'wolmart-core' )   => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Divider', 'wolmart-core' ),
				'param_name' => 'divider',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'selectors'  => array(
					'{{WRAPPER}} .wolmart-icon-list-item:not(:last-child):after' => 'content:"";',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'wolmart-core' ),
				'param_name' => 'divider_style',
				'value'      => array(
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
				),
				'std'        => 'solid',
				'dependency' => array(
					'element' => 'divider',
					'value'   => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wolmart-icon-list-item:not(:last-child):after' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Width', 'wolmart-core' ),
				'param_name' => 'divider_width',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'dependency' => array(
					'element' => 'divider',
					'value'   => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}}.block-type .wolmart-icon-list-item:not(:last-child):after' => 'width: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}}.inline-type .wolmart-icon-list-item:not(:last-child):after' => 'border-right-width: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}}.inline-type .wolmart-icon-list-item:not(:last-child)' => 'margin-right: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Height', 'wolmart-core' ),
				'param_name' => 'divider_height',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'dependency' => array(
					'element' => 'divider',
					'value'   => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}}.block-type .wolmart-icon-list-item:not(:last-child):after' => 'border-bottom-width: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}}.block-type .wolmart-icon-list-item:not(:last-child)' => 'margin-bottom: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}}.inline-type .wolmart-icon-list-item:not(:last-child):after' => 'height: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'divider_color',
				'selectors'  => array(
					'{{WRAPPER}} .wolmart-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Icon', 'wolmart-core' )      => array(
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Size', 'wolmart-core' ),
				'param_name' => 'icon_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wolmart-icon-list-item i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'icon_padding',
				'responsive' => true,
				'std'        => '{``top``:{``xl``:``0``,``xs``:````,``sm``:````,``md``:````,``lg``:````},``right``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``5``},``bottom``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``0``},``left``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``0``}}',
				'selectors'  => array(
					'{{WRAPPER}} .wolmart-icon-list-item i' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'icon_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}}  .wolmart-icon-list-item i',
					'hover'  => '{{WRAPPER}}  .wolmart-icon-list-item i:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Icon List', 'wolmart-core' ),
		'base'                    => 'wpb_wolmart_icon_list',
		'icon'                    => 'wolmart-icon wolmart-icon-list',
		'class'                   => 'wpb_wolmart_icon_list',
		'controls'                => 'full',
		'category'                => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'             => esc_html__( 'Create wolmart icon list.', 'wolmart-core' ),
		'as_parent'               => array( 'only' => 'wpb_wolmart_icon_list_item' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'default_content'         => '[wpb_wolmart_icon_list_item][wpb_wolmart_icon_list_item selected_icon="fas fa-times"][wpb_wolmart_icon_list_item selected_icon="fas fa-dot-circle"][/wpb_wolmart_icon_list]',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Icon_List extends WPBakeryShortCodesContainer {

	}
}
