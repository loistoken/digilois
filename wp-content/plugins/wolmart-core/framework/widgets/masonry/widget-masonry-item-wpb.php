<?php
/**
 * Masonry Item Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'        => 'wolmart_number',
			'heading'     => esc_html__( 'Grid Item Width', 'wolmart-core' ),
			'param_name'  => 'creative_width',
			'responsive'  => true,
			'units'       => array(
				'%',
			),
			'description' => esc_html( 'Leave it blank to follow creative grid preset.', 'wolmart-core' ),
		),
		array(
			'type'       => 'wolmart_dropdown',
			'heading'    => esc_html__( 'Grid Item Height', 'wolmart-core' ),
			'param_name' => 'creative_height',
			'responsive' => true,
			'value'      => array(
				esc_html__( 'Preset', 'wolmart-core' )   => 'preset',
				'1'                                      => '1',
				'1/2'                                    => '1-2',
				'1/3'                                    => '1-3',
				'2/3'                                    => '2-3',
				'1/4'                                    => '1-4',
				'3/4'                                    => '3-4',
				'1/5'                                    => '1-5',
				'2/5'                                    => '2-5',
				'3/5'                                    => '3-5',
				'4/5'                                    => '4-5',
				esc_html__( 'Children', 'wolmart-core' ) => 'child',
			),
		),
		array(
			'type'        => 'wolmart_dropdown',
			'heading'     => esc_html__( 'Grid Item Order', 'wolmart-core' ),
			'param_name'  => 'creative_order',
			'responsive'  => true,
			'value'       => array(
				esc_html__( 'Default', 'wolmart-core' ) => '',
				'1'                                     => '1',
				'2'                                     => '2',
				'3'                                     => '3',
				'4'                                     => '4',
				'5'                                     => '5',
				'6'                                     => '6',
				'7'                                     => '7',
				'8'                                     => '8',
				'9'                                     => '9',
				'10'                                    => '10',
			),
			'description' => esc_html( 'Item order option does not work for float grid layout.', 'wolmart-core' ),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Masonry Item', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_masonry_item',
		'icon'            => 'wolmart-icon wolmart-icon-masonry',
		'class'           => 'wolmart_masonry_item',
		'as_parent'       => array( 'except' => 'wpb_wolmart_masonry_item' ),
		'as_child'        => array( 'only' => 'wpb_wolmart_masonry' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart creative grid item.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Masonry_Item extends WPBakeryShortCodesContainer {
	}
}
