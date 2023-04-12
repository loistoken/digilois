<?php
/**
 * Wolmart Element Wrapper shortcode
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Scroll Effects', 'wolmart-core' )     => array(

		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Viewport', 'wolmart-core' ),
			'param_name' => 'viewport',
			'value'      => array(
				esc_html__( 'Default', 'wolmart-core' ) => 'centered',
				esc_html__( 'Top - Bottom', 'wolmart-core' ) => 'top_bottom',
				esc_html__( 'Top - Center', 'wolmart-core' ) => 'center_top',
				esc_html__( 'Center - Bottom', 'wolmart-core' ) => 'center_bottom',
			),
			'std'        => 'centered',
		),
		esc_html__( 'Vertical Scroll', 'wolmart-core' )   => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Effect', 'wolmart-core' ),
				'param_name' => 'vertical_scroll',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'std'        => 'yes',
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Direction', 'wolmart-core' ),
				'param_name' => 'v_direction',
				'value'      => array(
					'up'     => array(
						'title' => esc_html__( 'Up', 'wolmart-core' ),
					),
					'bottom' => array(
						'title' => esc_html__( 'Down', 'wolmart-core' ),
					),
				),
				'std'        => 'up',
				'dependency' => array(
					'element' => 'vertical_scroll',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Speed', 'wolmart-core' ),
				'param_name' => 'v_speed',
				'value'      => 3,
				'dependency' => array(
					'element' => 'vertical_scroll',
					'value'   => 'yes',
				),
			),
		),
		esc_html__( 'Horizontal Scroll', 'wolmart-core' ) => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Effect', 'wolmart-core' ),
				'param_name' => 'horizontal_scroll',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Direction', 'wolmart-core' ),
				'param_name' => 'h_direction',
				'value'      => array(
					'left'  => array(
						'title' => esc_html__( 'To Left', 'wolmart-core' ),
					),
					'right' => array(
						'title' => esc_html__( 'To Right', 'wolmart-core' ),
					),
				),
				'std'        => 'left',
				'dependency' => array(
					'element' => 'horizontal_scroll',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Speed', 'wolmart-core' ),
				'param_name' => 'h_speed',
				'value'      => 3,
				'dependency' => array(
					'element' => 'horizontal_scroll',
					'value'   => 'yes',
				),
			),
		),
		esc_html__( 'Transparency', 'wolmart-core' )      => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Effect', 'wolmart-core' ),
				'param_name' => 'transparency_scroll',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Direction', 'wolmart-core' ),
				'param_name' => 't_direction',
				'value'      => array(
					'in'  => array(
						'title' => esc_html__( 'Fade In', 'wolmart-core' ),
					),
					'out' => array(
						'title' => esc_html__( 'Fade Out', 'wolmart-core' ),
					),
				),
				'std'        => 'in',
				'dependency' => array(
					'element' => 'transparency_scroll',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Speed', 'wolmart-core' ),
				'param_name' => 't_speed',
				'value'      => 3,
				'dependency' => array(
					'element' => 'transparency_scroll',
					'value'   => 'yes',
				),
			),
		),
		esc_html__( 'Rotate', 'wolmart-core' )            => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Effect', 'wolmart-core' ),
				'param_name' => 'rotate_scroll',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Direction', 'wolmart-core' ),
				'param_name' => 'r_direction',
				'value'      => array(
					'left'  => array(
						'title' => esc_html__( 'To Left', 'wolmart-core' ),
					),
					'right' => array(
						'title' => esc_html__( 'To Right', 'wolmart-core' ),
					),
				),
				'std'        => 'left',
				'dependency' => array(
					'element' => 'rotate_scroll',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Speed', 'wolmart-core' ),
				'param_name' => 'r_speed',
				'value'      => 3,
				'dependency' => array(
					'element' => 'rotate_scroll',
					'value'   => 'yes',
				),
			),
		),
		esc_html__( 'Scale', 'wolmart-core' )             => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Effect', 'wolmart-core' ),
				'param_name' => 'scale_scroll',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Direction', 'wolmart-core' ),
				'param_name' => 's_direction',
				'value'      => array(
					'in'  => array(
						'title' => esc_html__( 'Scale Up', 'wolmart-core' ),
					),
					'out' => array(
						'title' => esc_html__( 'Scale Down', 'wolmart-core' ),
					),
				),
				'std'        => 'in',
				'dependency' => array(
					'element' => 'scale_scroll',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Speed', 'wolmart-core' ),
				'param_name' => 's_speed',
				'value'      => 3,
				'dependency' => array(
					'element' => 'scale_scroll',
					'value'   => 'yes',
				),
			),
		),
	),
	esc_html__( 'Mouse Track Effect', 'wolmart-core' ) => array(
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Enable Effect', 'wolmart-core' ),
			'param_name' => 'mouse_track',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Enable Relative', 'wolmart-core' ),
			'param_name' => 'track_relative',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'mouse_track',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Direction', 'wolmart-core' ),
			'param_name' => 'track_direction',
			'value'      => array(
				'opposite' => array(
					'title' => esc_html__( 'Opposite', 'wolmart-core' ),
				),
				'direct'   => array(
					'title' => esc_html__( 'Direct', 'wolmart-core' ),
				),
			),
			'std'        => 'opposite',
			'dependency' => array(
				'element' => 'mouse_track',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Speed', 'wolmart-core' ),
			'param_name' => 'track_speed',
			'value'      => 1,
			'dependency' => array(
				'element' => 'mouse_track',
				'value'   => 'yes',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Floating Wrapper', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_floating_wrapper',
		'icon'            => 'wolmart-icon wolmart-icon-floating',
		'class'           => 'wolmart_floating_wrapper',
		'as_parent'       => array( 'except' => '' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart floating wrapper.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Floating_Wrapper extends WPBakeryShortCodesContainer {
	}
}
