<?php
/**
 * Wolmart Single Product Flash Sale
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Content', 'wolmart-core' ) => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'wolmart-core' ),
			'param_name' => 'sp_icon',
			'std'        => 'w-icon-check',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Label', 'wolmart-core' ),
			'param_name' => 'sp_label',
			'std'        => esc_html__( 'Flash Deals', 'wolmart-core' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Ends Label', 'wolmart-core' ),
			'param_name' => 'sp_ends_label',
			'std'        => esc_html__( 'Ends in:', 'wolmart-core' ),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
			'param_name' => 'sp_bg_color',
			'selectors'  => array(
				'{{WRAPPER}} .product-countdown-container' => 'background-color: {{VALUE}};',
			),
		),
		esc_html__( 'Label', 'wolmart-core' )      => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'sp_label_typo',
				'selectors'  => array(
					'{{WRAPPER}} .product-sale-info',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_label_color',
				'selectors'  => array(
					'{{WRAPPER}} .product-sale-info' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Ends Label', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'sp_ends_typo',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-wrap',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'sp_ends_color',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-wrap' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Flash Sale', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_flash_sale',
		'icon'            => 'wolmart-icon wolmart-icon-sp-flash-sale',
		'class'           => 'wolmart_sp_flash_sale',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product flash sale.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Flash_Sale extends WPBakeryShortCode {

	}
}
