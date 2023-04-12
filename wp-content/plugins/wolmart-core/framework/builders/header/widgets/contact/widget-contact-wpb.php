<?php
/**
 * Header Contact Link
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )       => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Contact Icon', 'wolmart-core' ),
			'param_name' => 'contact_icon',
			'std'        => 'w-icon-call',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Live Chat Text', 'wolmart-core' ),
			'param_name' => 'contact_link_text',
			'std'        => esc_html__( 'Live Chat', 'wolmart-core' ),
			'dependency' => array(
				'element' => 'show_label',
				'value'   => 'yes',
			),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Live Chat Link', 'wolmart-core' ),
			'param_name'  => 'link',
			'placeholder' => 'mailto://youremail',
			'value'       => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Telephone Number', 'wolmart-core' ),
			'param_name' => 'contact_telephone',
			'std'        => esc_html__( '0(800)123-456', 'wolmart-core' ),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Telephone Link', 'wolmart-core' ),
			'param_name'  => 'contact_telephone_link',
			'placeholder' => 'tel://1234567890',
			'value'       => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Delimiter', 'wolmart-core' ),
			'param_name' => 'contact_delimiter',
			'std'        => esc_html__( 'or:', 'wolmart-core' ),
		),
	),
	esc_html__( 'Contact Style', 'wolmart-core' ) => array(
		esc_html__( 'Contact Icon', 'wolmart-core' ) => array(

			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
				'param_name' => 'icon_font_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .contact i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'icon_color',
				'selectors'  => array(
					'{{WRAPPER}} .contact i' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'icon_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .contact i' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
		),
		esc_html__( 'Live Chat', 'wolmart-core' )    => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'link_typography',
				'selectors'  => array(
					'{{WRAPPER}} .contact-content .live-chat',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'live_chat_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .contact-content .live-chat',
					'hover'  => '{{WRAPPER}} .contact-content .live-chat:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Telephone', 'wolmart-core' )    => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'telephone_typography',
				'selectors'  => array(
					'{{WRAPPER}} .contact-content .telephone',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'telephone_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .contact-content .telephone',
					'hover'  => '{{WRAPPER}} .contact:hover .telephone, {{WRAPPER}} .contact:hover i',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Delimiter', 'wolmart-core' )    => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'delimiter_typography',
				'selectors'  => array(
					'{{WRAPPER}} .contact-content .contact-delimiter',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'delimiter_color',
				'selectors'  => array(
					'{{WRAPPER}} .contact-content .contact-delimiter' => 'color: {{VALUE}};',
				),
			),
		),
	),

);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Contact', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_hb_contact',
		'icon'            => 'wolmart-icon wolmart-icon-contact',
		'class'           => 'wolmart_hb_contact',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Header', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart contact.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_HB_Contact extends WPBakeryShortCode {
	}
}
