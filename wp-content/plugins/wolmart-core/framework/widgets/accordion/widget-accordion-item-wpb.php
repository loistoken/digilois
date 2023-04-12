<?php
/**
 * Accordion Item Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Card Title', 'wolmart-core' ),
			'param_name'  => 'card_title',
			'value'       => 'Card Item',
			'admin_label' => true,
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Card Icon', 'wolmart-core' ),
			'param_name' => 'card_icon',
		),
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Card Icon Typography', 'wolmart-core' ),
			'param_name' => 'card_icon_typography',
			'selectors'  => array(
				'{{WRAPPER}} .card-header a > i:first-child',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Card Icon Space', 'wolmart-core' ),
			'param_name' => 'card_icon_space',
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .card-header a > i:first-child' => 'margin-right: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Wolmart Accordion Item', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_accordion_item',
		'icon'            => 'wolmart-icon wolmart-icon-accordion',
		'class'           => 'wolmart_accordion_item',
		'as_parent'       => array( 'except' => 'wpb_wolmart_accordion_item' ),
		'as_child'        => array( 'only' => 'wpb_wolmart_accordion' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart accordion item.', 'wolmart-core' ),
		// 'default_content' => vc_is_inline() ? '[wpb_wolmart_tab_item tab_title="Tab 1"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_wolmart_tab_item][wpb_wolmart_tab_item tab_title="Tab 2"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_wolmart_tab_item][wpb_wolmart_tab_item tab_title="Tab 3"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_wolmart_tab_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Accordion_Item extends WPBakeryShortCodesContainer {
	}
}
