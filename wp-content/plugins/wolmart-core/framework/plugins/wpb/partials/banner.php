<?php
if ( ! function_exists( 'wolmart_wpb_banner_general_controls' ) ) {
	function wolmart_wpb_banner_general_controls() {
		return array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Wrap with', 'wolmart-core' ),
				'param_name' => 'wrap_with',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' ) => '',
					esc_html__( 'Container', 'wolmart-core' ) => 'container',
					esc_html__( 'Container Fluid', 'wolmart-core' ) => 'container-fluid',
				),
				'std'        => '',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
				'param_name' => 'banner_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .banner'     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .banner img' => 'background-color: transparent;',
				),
			),
			array(
				'type'       => 'attach_image',
				'heading'    => esc_html__( 'Image', 'wolmart-core' ),
				'param_name' => 'banner_image',
				'value'      => '',
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Image Position', 'wolmart-core' ),
				'param_name'  => 'image_position',
				'description' => esc_html__( 'You can input image position like this: center top or 50% 50%.', 'wolmart-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .banner-img img' => 'object-position: {{VALUE}};',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Full Screen', 'wolmart-core' ),
				'param_name' => 'full_screen',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'std'        => 'no',
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Stretch Height', 'wolmart-core' ),
				'param_name'  => 'stretch_height',
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'std'         => 'no',
				'description' => esc_html__( 'You can make your banner height full of its parent.', 'wolmart-core' ),
				'selectors'   => array(
					'{{WRAPPER}} , {{WRAPPER}} .banner, {{WRAPPER}} .banner-img img' => 'height: 100%;',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Min Height', 'wolmart-core' ),
				'responsive' => true,
				'param_name' => 'min_height',
				'units'      => array(
					'px',
					'%',
					'rem',
					'vh',
				),
				'std'        => '{"xl":"300","unit":"px"}',
				'selectors'  => array(
					'{{WRAPPER}} .banner' => 'min-height: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Max Height', 'wolmart-core' ),
				'responsive' => true,
				'param_name' => 'max_height',
				'units'      => array(
					'px',
					'%',
					'rem',
					'vh',
				),
				'selectors'  => array(
					'{{WRAPPER}} .banner, {{WRAPPER}} img' => 'max-height: {{VALUE}}{{UNIT}};overflow: hidden;',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_banner_effect_controls' ) ) {
	function wolmart_wpb_banner_effect_controls() {
		return array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Hover Effect', 'wolmart-core' ),
				'param_name' => 'hover_effect',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )  => '',
					esc_html__( 'Light', 'wolmart-core' ) => 'overlay-light',
					esc_html__( 'Dark', 'wolmart-core' )  => 'overlay-dark',
					esc_html__( 'Zoom', 'wolmart-core' )  => 'overlay-zoom',
					esc_html__( 'Zoom and Light', 'wolmart-core' ) => 'overlay-zoom overlay-light',
					esc_html__( 'Zoom and Dark', 'wolmart-core' ) => 'overlay-zoom overlay-dark',
				),
				'std'        => '',
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_banner_parallax_controls' ) ) {
	function wolmart_wpb_banner_parallax_controls() {
		return array(
			array(
				'type'       => 'checkbox',
				'param_name' => 'parallax',
				'heading'    => esc_html__( 'Enable Parallax', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Parallax Speed', 'wolmart-core' ),
				'param_name' => 'parallax_speed',
				'std'        => 1,
				'dependency' => array(
					'element' => 'parallax',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Parallax Offset', 'wolmart-core' ),
				'param_name' => 'parallax_offset',
				'std'        => 0,
				'dependency' => array(
					'element' => 'parallax',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Parallax Height (%)', 'wolmart-core' ),
				'param_name' => 'parallax_height',
				'std'        => '200',
				'dependency' => array(
					'element' => 'parallax',
					'value'   => 'yes',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_banner_video_controls' ) ) {
	function wolmart_wpb_banner_video_controls() {
		return array(
			array(
				'type'       => 'checkbox',
				'param_name' => 'video_banner',
				'heading'    => esc_html__( 'Enable Video', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Video URL', 'wolmart-core' ),
				'param_name' => 'video_url',
				'dependency' => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'video_autoplay',
				'heading'    => esc_html__( 'Autoplay', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'video_mute',
				'heading'    => esc_html__( 'Mute', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'video_loop',
				'heading'    => esc_html__( 'Loop', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'video_controls',
				'heading'    => esc_html__( 'Player Controls', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
		);
	}
}
