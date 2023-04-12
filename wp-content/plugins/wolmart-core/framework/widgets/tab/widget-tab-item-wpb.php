<?php
/**
 * Tab Item Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Tab Item Title', 'wolmart-core' ),
			'param_name'  => 'tab_title',
			'value'       => 'Tab',
			'admin_label' => true,
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Tab Item', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_tab_item',
		'icon'            => 'wolmart-icon wolmart-icon-tab',
		'class'           => 'wolmart_tab_item',
		'as_parent'       => array( 'except' => 'wpb_wolmart_tab_item' ),
		'as_child'        => array( 'only' => 'wpb_wolmart_tab' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart tab item.', 'wolmart-core' ),
		'default_content' => '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Tab_Item extends  WPBakeryShortCodesContainer {
	}
}
