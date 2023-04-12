<?php
/**
 * Share Icon Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'social_type',
			'heading'    => esc_html__( 'Type', 'wolmart-core' ),
			'value'      => array(
				'left'    => array(
					'title' => esc_html__( 'Default', 'wolmart-core' ),
				),
				'stacked' => array(
					'title' => esc_html__( 'Stacked', 'wolmart-core' ),
				),
				'framed'  => array(
					'title' => esc_html__( 'Framed', 'wolmart-core' ),
				),
			),
			'std'        => 'stacked',
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'icon',
			'heading'     => esc_html__( 'Select Icon', 'wolmart-core' ),
			'value'       => array(
				esc_html__( 'facebook', 'wolmart-core' )  => 'facebook',
				esc_html__( 'twitter', 'wolmart-core' )   => 'twitter',
				esc_html__( 'linkedin', 'wolmart-core' )  => 'linkedin',
				esc_html__( 'email', 'wolmart-core' )     => 'email',
				esc_html__( 'google', 'wolmart-core' )    => 'google',
				esc_html__( 'pinterest', 'wolmart-core' ) => 'pinterest',
				esc_html__( 'reddit', 'wolmart-core' )    => 'reddit',
				esc_html__( 'tumblr', 'wolmart-core' )    => 'tumblr',
				esc_html__( 'vk', 'wolmart-core' )        => 'vk',
				esc_html__( 'whatsapp', 'wolmart-core' )  => 'whatsapp',
				esc_html__( 'xing', 'wolmart-core' )      => 'xing',
			),
			'std'         => 'facebook',
			'admin_label' => true,
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Link Url', 'wolmart-core' ),
			'description' => esc_html__( 'Please leave it blank to share this page or input URL for social login', 'wolmart-core' ),
			'param_name'  => 'link',
			'value'       => '',
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Icon Colors', 'wolmart-core' ),
			'param_name' => 'icon_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}}.social-icon',
				'hover'  => '{{WRAPPER}}.social-icon:hover',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
			'dependency' => array(
				'element'   => 'icon',
				'not_empty' => true,
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'        => esc_html__( 'Share Icon', 'wolmart-core' ),
		'base'        => 'wpb_wolmart_share_icon',
		'icon'        => 'wolmart-icon wolmart-icon-share',
		'class'       => 'wpb_wolmart_share_icon',
		'controls'    => 'full',
		'category'    => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description' => esc_html__( 'Create wolmart share icon.', 'wolmart-core' ),
		'as_child'    => array( 'only' => 'wpb_wolmart_share_icons' ),
		'params'      => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Share_Icon extends WPBakeryShortCode {

	}
}
