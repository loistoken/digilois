<?php
/**
 * Share Icon Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Text', 'wolmart-core' ),
			'param_name'  => 'text',
			'std'         => esc_html( 'List Item', 'wolmart-core' ),
			'admin_label' => true,
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'wolmart-core' ),
			'param_name' => 'selected_icon',
			'std'        => 'fas fa-check',
		),
		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Link Url', 'wolmart-core' ),
			'param_name' => 'link',
			'value'      => '',
		),

	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
			'param_name' => 'icon_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}}.wolmart-icon-list-item i' => 'font-size: {{VALUE}}{{UNIT}}',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'icon_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}.wolmart-icon-list-item i' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'        => esc_html__( 'Icon List Item', 'wolmart-core' ),
		'base'        => 'wpb_wolmart_icon_list_item',
		'icon'        => 'wolmart-icon wolmart-icon-list',
		'class'       => 'wpb_wolmart_icon_list_item',
		'controls'    => 'full',
		'category'    => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description' => esc_html__( 'Create wolmart icon list item.', 'wolmart-core' ),
		'as_child'    => array( 'only' => 'wpb_wolmart_icon_list' ),
		'params'      => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Icon_List_Item extends WPBakeryShortCode {

	}
}
