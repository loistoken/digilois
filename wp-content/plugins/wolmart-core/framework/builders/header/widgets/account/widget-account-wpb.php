<?php
/**
 * Header Account Button
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )          => array(
		array(
			'type'       => 'wolmart_multiselect',
			'heading'    => esc_html__( 'Show Items', 'wolmart-core' ),
			'param_name' => 'account_items',
			'value'      => array(
				esc_html__( 'User Icon', 'wolmart-core' ) => 'icon',
				esc_html__( 'Login/Logout Label', 'wolmart-core' ) => 'login',
				esc_html__( 'Register Label', 'wolmart-core' ) => 'register',
			),
			'std'        => 'icon,login,register',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Dropdown Align', 'wolmart-core' ),
			'param_name' => 'dropdown_align',
			'value'      => array(
				'auto' => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'fas fa-align-left',
				),
				''     => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => '',
			'selectors'  => array(
				'{{WRAPPER}} .dropdown-box' => 'right: {{VALUE}};',
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'wolmart-core' ),
			'param_name' => 'icon',
			'std'        => 'w-icon-account',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Login Text', 'wolmart-core' ),
			'param_name' => 'account_login',
			'std'        => esc_html__( 'Log in', 'wolmart-core' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Logout Text', 'wolmart-core' ),
			'param_name' => 'account_logout',
			'std'        => esc_html__( 'Log out', 'wolmart-core' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Register Text', 'wolmart-core' ),
			'param_name' => 'account_register',
			'std'        => esc_html__( 'Register', 'wolmart-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Delimiter Text', 'wolmart-core' ),
			'param_name'  => 'account_delimiter',
			'description' => esc_html__( 'Account Delimiter will be shown between Login and Register links', 'wolmart-core' ),
			'std'         => '/',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Enable Social Login', 'wolmart-core' ),
			'param_name' => 'social_login',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
		),
	),
	esc_html__( 'Loggined Options', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_heading',
			'label'      => esc_html__( 'When user is logged in', 'wolmart-core' ),
			'tag'        => 'h4',
			'param_name' => 'account_loggined_heading',
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Menu Dropdown', 'wolmart-core' ),
			'param_name'  => 'account_dropdown',
			'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'description' => esc_html__( 'Menu that is located in Account Menu will be shown.', 'wolmart-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Logout Text', 'wolmart-core' ),
			'param_name'  => 'account_logout',
			'std'         => 'Log out',
			'description' => esc_html__( 'Please input %name% where you want to show current user name. ( ex: Hi, %name%! )', 'wolmart-core' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Avatar', 'wolmart-core' ),
			'param_name' => 'account_avatar',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
		),
	),
	esc_html__( 'Styles', 'wolmart-core' )           => array(
		esc_html__( 'Account Styles', 'wolmart-core' )   => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Account Typography', 'wolmart-core' ),
				'param_name' => 'account_typography',
				'selectors'  => array(
					'{{WRAPPER}} .account a',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
				'param_name' => 'account_icon',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .account i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Icon Space', 'wolmart-core' ),
				'param_name' => 'account_icon_space',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .block-type i + span'  => 'margin-top: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .inline-type i + span' => 'margin-left: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'account_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .account > a',
					'hover'  => '{{WRAPPER}} .account > a:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Delimiter Styles', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Delimiter Typography', 'wolmart-core' ),
				'param_name' => 'deimiter_typography',
				'selectors'  => array(
					'{{WRAPPER}} .account .delimiter',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Delimiter Color', 'wolmart-core' ),
				'param_name' => 'delimiter_color',
				'selectors'  => array(
					'{{WRAPPER}} .account .delimiter' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Delimiter Space', 'wolmart-core' ),
				'param_name' => 'account_delimiter_space',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .account .delimiter' => 'margin-left: {{VALUE}}{{UNIT}}; margin-right: {{VALUE}}{{UNIT}}; ',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Account', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_hb_account',
		'icon'            => 'wolmart-icon wolmart-icon-account',
		'class'           => 'wolmart_hb_account',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Header', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart account.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_HB_Account extends WPBakeryShortCode {
	}
}
