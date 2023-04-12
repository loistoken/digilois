<?php
/**
 * Wolmart Video Popup
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Style', 'wolmart-core' ) => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Player Icon', 'wolmart-core' ),
			'param_name' => 'button_icon',
			'std'        => 'w-icon-play',
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Player Icon Size', 'wolmart-core' ),
			'param_name' => 'icon_size',
			'units'      => array(
				'px',
			),
			'selectors'  => array(
				'{{WRAPPER}} i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
			'std'        => '{"xl":"35","unit":"","xs":"","sm":"","md":"","lg":""}',
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Button Size', 'wolmart-core' ),
			'param_name' => 'button_size',
			'units'      => array(
				'px',
			),
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
			),
			'std'        => '{"xl":"60","unit":"","xs":"","sm":"","md":"","lg":""}',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'alignment',
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
			'std'        => 'left',
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'button_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
			'std'        => '{"top":{"xl":"10","xs":"","sm":"","md":"","lg":""},"right":{"xs":"","sm":"","md":"","lg":"","xl":"12"},"bottom":{"xs":"","sm":"","md":"","lg":"","xl":"10"},"left":{"xs":"","sm":"","md":"","lg":"","xl":"12"}}',
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
			'param_name' => 'button_bd_width',
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
			'std'        => '{"top":{"xl":"1","xs":"","sm":"","md":"","lg":""},"right":{"xs":"","sm":"","md":"","lg":"","xl":"1"},"bottom":{"xs":"","sm":"","md":"","lg":"","xl":"1"},"left":{"xs":"","sm":"","md":"","lg":"","xl":"1"}}',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Shape', 'wolmart-core' ),
			'param_name' => 'button_border',
			'label_type' => 'icon',
			'value'      => array(
				''            => array(
					'title' => esc_html__( 'Square', 'wolmart-core' ),
					'icon'  => 'attr-icon-square',
				),
				'btn-rounded' => array(
					'title' => esc_html__( 'Rounded', 'wolmart-core' ),
					'icon'  => 'attr-icon-rounded',
				),
				'btn-ellipse' => array(
					'title' => esc_html__( 'Ellipse', 'wolmart-core' ),
					'icon'  => 'attr-icon-ellipse',
				),
			),
			'std'        => 'btn-ellipse',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Skin', 'wolmart-core' ),
			'param_name' => 'button_skin',
			'value'      => array(
				''              => array(
					'title' => esc_html__( 'Default', 'wolmart-core' ),
					'color' => '#eee',
				),
				'btn-primary'   => array(
					'title' => esc_html__( 'Primary', 'wolmart-core' ),
					'color' => 'var(--wolmart-primary-color,#2879FE)',
				),
				'btn-secondary' => array(
					'title' => esc_html__( 'Secondary', 'wolmart-core' ),
					'color' => 'var(--wolmart-secondary-color,#d26e4b)',
				),
				'btn-alert'     => array(
					'title' => esc_html__( 'Alert', 'wolmart-core' ),
					'color' => 'var(--wolmart-alert-color,#b10001)',
				),
				'btn-success'   => array(
					'title' => esc_html__( 'Success', 'wolmart-core' ),
					'color' => 'var(--wolmart-success-color,#a8c26e)',
				),
				'btn-dark'      => array(
					'title' => esc_html__( 'Dark', 'wolmart-core' ),
					'color' => 'var(--wolmart-dark-color,#222)',
				),
				'btn-white'     => array(
					'title' => esc_html__( 'white', 'wolmart-core' ),
					'color' => '#fff',
				),
			),
			'std'        => 'btn-primary',
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
			'param_name' => 'btn_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .btn',
				'hover'  => '{{WRAPPER}} .btn:hover',
				'active' => '{{WRAPPER}} .btn:active',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Wolmart Video Player', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_videoplayer',
		'icon'            => 'wolmart-icon',
		'class'           => 'wolmart_videoplayer',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart video player.', 'wolmart-core' ),
		'as_child'        => array( 'only' => 'wpb_wolmart_banner_layer' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Videoplayer extends WPBakeryShortCode {

	}
}
