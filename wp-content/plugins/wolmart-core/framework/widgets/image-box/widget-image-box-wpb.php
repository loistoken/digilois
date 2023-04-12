<?php
/**
 * ImageBox Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Choose Images', 'wolmart-core' ),
			'param_name'  => 'image',
			'value'       => '',
			'description' => esc_html__( 'Select images from media library.', 'wolmart-core' ),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'thumbnail',
			'std'        => 'full',
			'heading'    => esc_html__( 'Image Size', 'wolmart-core' ),
			'value'      => wolmart_get_image_sizes(),
		),
		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Link Url', 'wolmart-core' ),
			'param_name' => 'link',
			'value'      => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'wolmart-core' ),
			'param_name'  => 'title',
			'value'       => 'Input Title Here',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Subtitle', 'wolmart-core' ),
			'param_name'  => 'subtitle',
			'value'       => 'Input SubTitle Here',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea_raw_html',
			'heading'     => esc_html__( 'Content', 'wolmart-core' ),
			'param_name'  => 'content',
			// @codingStandardsIgnoreLine
			'value'       => base64_encode( '<div class="social-icons">
									<a href="#" class="social-icon framed use-hover social-facebook"><i class="fab fa-facebook-f"></i></a>
									<a href="#" class="social-icon framed use-hover social-twitter"><i class="fab fa-twitter"></i></a>
									<a href="#" class="social-icon framed use-hover social-linkedin"><i class="fab fa-linkedin-in"></i></a>
								</div>'
			),
			'admin_label' => true,
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'type',
			'heading'    => esc_html__( 'Imagebox Type', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'Default', 'wolmart-core' ) => 'default',
				esc_html__( 'Outer Title', 'wolmart-core' ) => 'outer',
				esc_html__( 'Inner Title', 'wolmart-core' ) => 'inner',
			),
			'std'        => 'default',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'imagebox_align',
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
			'selectors'  => array(
				'{{WRAPPER}} .image-box' => 'text-align: {{VALUE}}',
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		esc_html__( 'Title', 'wolmart-core' )       => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .title a' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Title Typography', 'wolmart-core' ),
				'param_name' => 'title_typography',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .title',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Title Margin', 'wolmart-core' ),
				'param_name' => 'title_mg',
				'responsive' => false,
				'selectors'  => array(
					'{{WRAPPER}} .image-box .title' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Sub title', 'wolmart-core' )   => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'subtitle_color',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .subtitle' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'SubTitle Typography', 'wolmart-core' ),
				'param_name' => 'subtitle_typography',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .subtitle',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'SubTitle Margin', 'wolmart-core' ),
				'param_name' => 'subtitle_mg',
				'responsive' => false,
				'selectors'  => array(
					'{{WRAPPER}} .image-box .subtitle' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Description', 'wolmart-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'description_color',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .content' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'description_typography',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .content',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'param_name' => 'description_mg',
				'responsive' => false,
				'selectors'  => array(
					'{{WRAPPER}} .image-box .content' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'ImageBox', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_image_box',
		'icon'            => 'wolmart-icon wolmart-icon-image-box',
		'class'           => 'wolmart_image_box',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart image box.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Image_Box extends WPBakeryShortCode {
	}
}
