<?php
/**
 * Wolmart Single Product Price
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Style', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_typography',
			'heading'    => __( 'Typography', 'wolmart-core' ),
			'param_name' => 'sp_typo',
			'selectors'  => array(
				'{{WRAPPER}} p.price',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'sp_price_align',
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
			'selectors'  => array(
				'{{WRAPPER}} p.price' => 'text-align: {{VALUE}};',
			),
		),
		esc_html__( 'Color', 'wolmart-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Normal', 'wolmart-core' ),
				'param_name' => 'normal_price_color',
				'selectors'  => array(
					'{{WRAPPER}} p.price' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'New', 'wolmart-core' ),
				'param_name' => 'new_price_color',
				'selectors'  => array(
					'{{WRAPPER}} ins' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Old', 'wolmart-core' ),
				'param_name' => 'old_price_color',
				'selectors'  => array(
					'{{WRAPPER}} del' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Price', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_price',
		'icon'            => 'wolmart-icon wolmart-icon-sp-price',
		'class'           => 'wolmart_sp_price',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product price.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Price extends WPBakeryShortCode {

	}
}
