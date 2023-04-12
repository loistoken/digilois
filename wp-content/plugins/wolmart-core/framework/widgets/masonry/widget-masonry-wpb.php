<?php
/**
 * Masonry Element
 *
 * @since 1.0.0
 */


$creative_layout = wolmart_creative_preset_imgs();

foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => WOLMART_CORE_URI . $item,
	);
}

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'         => 'wolmart_button_group',
			'param_name'   => 'creative_mode',
			'heading'      => esc_html__( 'Creative Layout', 'wolmart-core' ),
			'std'          => 1,
			'button_width' => '100',
			'value'        => $creative_layout,
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Change Grid Height', 'wolmart-core' ),
			'param_name' => 'creative_height',
			'value'      => '600',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Grid Mobile Height (%)', 'wolmart-core' ),
			'param_name' => 'creative_height_ratio',
			'value'      => '75',
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'grid_float',
			'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'heading'     => esc_html__( 'Use Float Grid', 'wolmart-core' ),
			'description' => esc_html__( 'The Layout will be built with only float style not using isotope plugin. This is very useful for some simple creative layouts.', 'wolmart-core' ),
		),
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'col_sp',
			'heading'    => esc_html__( 'Columns Spacing', 'wolmart-core' ),
			'std'        => 'md',
			'value'      => array(
				'no' => array(
					'title' => esc_html__( 'NO', 'wolmart-core' ),
				),
				'xs' => array(
					'title' => esc_html__( 'XS', 'wolmart-core' ),
				),
				'sm' => array(
					'title' => esc_html__( 'S', 'wolmart-core' ),
				),
				'md' => array(
					'title' => esc_html__( 'M', 'wolmart-core' ),
				),
				'lg' => array(
					'title' => esc_html__( 'L', 'wolmart-core' ),
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Masonry', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_masonry',
		'icon'            => 'wolmart-icon wolmart-icon-masonry',
		'class'           => 'wolmart_masonry',
		'as_parent'       => array( 'only' => 'wpb_wolmart_masonry_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart isotope layout.', 'wolmart-core' ),
		'default_content' => vc_is_inline() ? '[wpb_wolmart_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_wolmart_masonry_item][wpb_wolmart_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_wolmart_masonry_item][wpb_wolmart_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_wolmart_masonry_item][wpb_wolmart_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_wolmart_masonry_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Masonry extends WPBakeryShortCodesContainer {
	}
}
