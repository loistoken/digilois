<?php
/**
 * Products Layout Banner Item Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Layout', 'wolmart-core' )   => array(
		array(
			'type'        => 'wolmart_number',
			'param_name'  => 'item_no',
			'std'         => 1,
			'heading'     => esc_html__( 'Insert At', 'wolmart-core' ),
			'description' => esc_html__( 'Input item index where this banner should be inserted before.', 'wolmart-core' ),
		),
		array(
			'type'       => 'wolmart_heading',
			'tag'        => 'h3',
			'label'      => esc_html__( 'Creative Layout Options', 'wolmart-core' ),
			'param_name' => 'creative_item_heading',
		),
		array(
			'type'        => 'wolmart_number',
			'heading'     => esc_html__( 'Banner Column Size', 'wolmart-core' ),
			'param_name'  => 'item_col_span',
			'std'         => '{"xl":"2","unit":"","xs":"","sm":"","md":"","lg":""}',
			'responsive'  => true,
			'description' => esc_html__( 'Control column size of banner in this layout. This option works only for creative layout.', 'wolmart-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
			'selectors'   => array(
				'.creative-grid > {{WRAPPER}}' => 'grid-column-end: span {{VALUE}}',
			),
		),
		array(
			'type'        => 'wolmart_number',
			'heading'     => esc_html__( 'Banner Row Size', 'wolmart-core' ),
			'param_name'  => 'item_row_span',
			'std'         => '{"xl":"1","unit":"","xs":"","sm":"","md":"","lg":""}',
			'responsive'  => true,
			'description' => esc_html__( 'Control row size of banner in this layout. This option works only for creative layout.', 'wolmart-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
			'selectors'   => array(
				'.creative-grid > {{WRAPPER}}' => 'grid-row-end: span {{VALUE}}',
			),
		),
	),
	esc_html__( 'General', 'wolmart-core' )  => array(
		'wolmart_wpb_banner_general_controls',
	),
	esc_html__( 'Effect', 'wolmart-core' )   => array(
		'wolmart_wpb_banner_effect_controls',
	),
	esc_html__( 'Parallax', 'wolmart-core' ) => array(
		'wolmart_wpb_banner_parallax_controls',
	),
	esc_html__( 'Video', 'wolmart-core' )    => array(
		'wolmart_wpb_banner_video_controls',
	),

);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Banner Inner Products Layout', 'wolmart-core' ),
		'base'                    => 'wpb_wolmart_products_banner_item',
		'icon'                    => 'wolmart-icon wolmart-icon-banner',
		'class'                   => 'wolmart_products_banner_item',
		'controls'                => 'full',
		'category'                => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'             => esc_html__( 'Create wolmart banner item inside products layout.', 'wolmart-core' ),
		'as_parent'               => array( 'only' => 'wpb_wolmart_banner_layer' ),
		'as_child'                => array( 'only' => 'wpb_wolmart_products_layout' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_wpb_wolmart_products_banner_item extends WPBakeryShortCodesContainer {

	}
}
