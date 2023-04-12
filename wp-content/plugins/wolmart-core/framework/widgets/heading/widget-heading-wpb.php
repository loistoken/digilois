<?php
/**
 * Wolmart Heading
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'        => 'wolmart_button_group',
			'heading'     => esc_html__( 'Content', 'wolmart-core' ),
			'param_name'  => 'content_type',
			'value'       => array(
				'custom'  => array(
					'title' => esc_html__( 'Custom', 'wolmart-core' ),
				),
				'dynamic' => array(
					'title' => esc_html__( 'Dynamic', 'wolmart-core' ),
				),
			),
			'std'         => 'custom',
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea_raw_html',
			'heading'    => esc_html__( 'Title', 'wolmart-core' ),
			'param_name' => 'heading_title',
			'value'      => base64_encode( esc_html__( 'Add Your Heading Text Here', 'wolmart-core' ) ),
			'dependency' => array(
				'element' => 'content_type',
				'value'   => 'custom',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Dynamic Content', 'wolmart-core' ),
			'param_name' => 'dynamic_content',
			'value'      => array(
				esc_html__( 'Page Title', 'wolmart-core' ) => 'title',
				esc_html__( 'Page Subtitle', 'wolmart-core' ) => 'subtitle',
				esc_html__( 'Products Count', 'wolmart-core' ) => 'product_cnt',
			),
			'dependency' => array(
				'element' => 'content_type',
				'value'   => 'dynamic',
			),
		),
		array(
			'type'        => 'wolmart_dropdown',
			'heading'     => esc_html__( 'HTML Tag', 'wolmart-core' ),
			'param_name'  => 'html_tag',
			'value'       => array(
				'H1'   => 'h1',
				'H2'   => 'h2',
				'H3'   => 'h3',
				'H4'   => 'h4',
				'H5'   => 'h5',
				'H6'   => 'h6',
				'P'    => 'p',
				'Div'  => 'div',
				'Span' => 'span',
			),
			'std'         => 'h2',
			'admin_label' => true,
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Type', 'wolmart-core' ),
			'param_name' => 'decoration',
			'value'      => array(
				'simple'    => array(
					'title' => esc_html__( 'Simple', 'wolmart-core' ),
				),
				'cross'     => array(
					'title' => esc_html__( 'Cross', 'wolmart-core' ),
				),
				'underline' => array(
					'title' => esc_html__( 'Underline', 'wolmart-core' ),
				),
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Title Align', 'wolmart-core' ),
			'param_name' => 'title_align',
			'value'      => array(
				'title-left'   => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'title-center' => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'title-right'  => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => 'title-left',
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Decoration Spacing', 'wolmart-core' ),
			'param_name' => 'decoration_spacing',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'em',
				'%',
			),
			'value'      => '',
			'selectors'  => array(
				'{{WRAPPER}} .title::before' => 'margin-right: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .title::after'  => 'margin-left: {{VALUE}}{{UNIT}};',
			),
			'dependency' => array(
				'element' => 'decoration',
				'value'   => 'cross',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Decoration Color', 'wolmart-core' ),
			'param_name' => 'border_color',
			'selectors'  => array(
				'{{WRAPPER}}.title-cross .title::before, {{WRAPPER}}.title-cross .title::after, {{WRAPPER}}.title-underline::after' => 'background-color: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'decoration',
				'value'   => 'cross',
			),
		),
	),
	esc_html__( 'Link', 'wolmart-core' )    => array(
		array(
			'type'        => 'checkbox',
			'param_name'  => 'show_link',
			'heading'     => esc_html__( 'Show Link?', 'wolmart-core' ),
			'value'       => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
			'admin_label' => true,
		),
		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Link Url', 'wolmart-core' ),
			'param_name' => 'link_url',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Link Label', 'wolmart-core' ),
			'param_name' => 'link_label',
			'value'      => 'Link',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'wolmart-core' ),
			'param_name' => 'icon',
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Icon Position', 'wolmart-core' ),
			'param_name' => 'icon_pos',
			'value'      => array(
				'before' => array(
					'title' => esc_html__( 'Before', 'wolmart-core' ),
				),
				'after'  => array(
					'title' => esc_html__( 'After', 'wolmart-core' ),
				),
			),
			'std'        => 'after',
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Spacing', 'wolmart-core' ),
			'param_name' => 'icon_space',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}}.icon-before i' => 'margin-right: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}}.icon-after i'  => 'margin-left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
			'param_name' => 'icon_size',
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
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Link Align', 'wolmart-core' ),
			'param_name' => 'link_align',
			'value'      => array(
				'link-left'  => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'link-right' => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Link Space', 'wolmart-core' ),
			'param_name' => 'link_gap',
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .link' => 'margin-left: {{VALUE}}{{UNIT}};',
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Title Padding', 'wolmart-core' ),
			'param_name' => 'title_spacing',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .title' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Title Color', 'wolmart-core' ),
			'param_name' => 'title_color',
			'selectors'  => array(
				'{{WRAPPER}} .title' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Title Typography', 'wolmart-core' ),
			'param_name' => 'title_typography',
			'selectors'  => array(
				'{{WRAPPER}} .title',
			),
		),
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Link Typography', 'wolmart-core' ),
			'param_name' => 'link_typography',
			'selectors'  => array(
				'{{WRAPPER}} .link',
			),
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Link Colors', 'wolmart-core' ),
			'param_name' => 'link_colors',
			'group'      => esc_html__( 'General', 'wolmart-core' ),
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .link',
				'hover'  => '{{WRAPPER}} .link:hover',
			),
			'choices'    => array( 'color' ),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Heading', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_heading',
		'icon'            => 'wolmart-icon wolmart-icon-heading',
		'class'           => 'wolmart_heading',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart heading.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Heading extends WPBakeryShortCode {
	}
}
