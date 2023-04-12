<?php
/**
 * Wolmart Single Product Excerpt
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Style', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
			'param_name' => 'sp_typo',
			'selectors'  => array(
				'{{WRAPPER}} p',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'wolmart-core' ),
			'param_name' => 'sp_color',
			'selectors'  => array(
				'{{WRAPPER}} p' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'sp_align',
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
				'{{WRAPPER}} p' => 'text-align: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Excerpt', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_excerpt',
		'icon'            => 'wolmart-icon wolmart-icon-sp-excerpt',
		'class'           => 'wolmart_sp_excerpt',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product excerpt.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Excerpt extends WPBakeryShortCode {

	}
}
