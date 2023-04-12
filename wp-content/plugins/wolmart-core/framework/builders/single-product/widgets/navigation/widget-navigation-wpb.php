<?php
/**
 * Wolmart Single Product Navigation
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Style', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'sp_align',
			'value'      => array(
				''         => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'   => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end' => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-navigation' => 'justify-content: {{VALUE}}',
			),
		),
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
			'param_name' => 'sp_typo',
			'selectors'  => array(
				'{{WRAPPER}} .product-nav span span',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
			'param_name' => 'icon_size',
			'value'      => '',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}} i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Previous Icon', 'wolmart-core' ),
			'param_name' => 'sp_prev_icon',
			'std'        => 'w-icon-angle-left',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Next Icon', 'wolmart-core' ),
			'param_name' => 'sp_next_icon',
			'std'        => 'w-icon-angle-right',
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
			'param_name' => 'nav_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} i',
				'hover'  => '{{WRAPPER}} li:hover i',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Navigation', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_navigation',
		'icon'            => 'wolmart-icon wolmart-icon-sp-nav',
		'class'           => 'wolmart_sp_navigation',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product navigation.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Navigation extends WPBakeryShortCode {
	}
}
