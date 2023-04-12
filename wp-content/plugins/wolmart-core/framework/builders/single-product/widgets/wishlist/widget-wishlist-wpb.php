<?php
/**
 * Wolmart Single Product Wishlist
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Content', 'wolmart-core' ) => array(
		esc_html__( 'wishlist', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'wishlist_typo',
				'selectors'  => array(
					'{{WRAPPER}} .yith-wcwl-add-to-wishlist',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
				'param_name' => 'wishlist_icon_size',
				'units'      => array(
					'px',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .yith-wcwl-add-to-wishlist a::before' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Icon Space', 'wolmart-core' ),
				'param_name' => 'wishlist_icon_space',
				'units'      => array(
					'px',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .yith-wcwl-add-to-wishlist a::before' => "margin-{$right}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Normal Color', 'wolmart-core' ),
				'param_name' => 'wishlist_color',
				'selectors'  => array(
					'{{WRAPPER}} .yith-wcwl-add-to-wishlist a' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Hover Color', 'wolmart-core' ),
				'param_name' => 'wishlist_hover_color',
				'selectors'  => array(
					'{{WRAPPER}} .yith-wcwl-add-to-wishlist a:hover' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Wolmart Single Product Wishlist', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_wishlist',
		'icon'            => 'wolmart-icon',
		'class'           => 'wolmart_sp_wishlist',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product wishlist.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Wishlist extends WPBakeryShortCode {

	}
}
