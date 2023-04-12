<?php
/**
 * Wolmart Hotspot
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Hotspot', 'wolmart-core' )       => array(
		array(
			'type'       => 'iconpicker',
			'param_name' => 'icon',
			'heading'    => esc_html__( 'Icon', 'wolmart-core' ),
			'std'        => 'w-icon-plus',
		),
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'horizontal',
			'heading'    => esc_html__( 'Horizontal Position', 'wolmart-core' ),
			'units'      => array(
				'px',
				'%',
				'vw',
				'rem',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}' => 'left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'vertical',
			'heading'    => esc_html__( 'Vertical Position', 'wolmart-core' ),
			'units'      => array(
				'px',
				'%',
				'vw',
				'rem',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}' => 'top: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'effect',
			'heading'    => esc_html__( 'Hotspot Effect', 'wolmart-core' ),
			'value'      => array(
				esc_html__( 'None', 'wolmart-core' )    => '',
				esc_html__( 'Spread', 'wolmart-core' )  => 'type1',
				esc_html__( 'Twinkle', 'wolmart-core' ) => 'type2',
			),
		),
	),
	esc_html__( 'Popup', 'wolmart-core' )         => array(
		array(
			'type'        => 'wolmart_button_group',
			'heading'     => esc_html__( 'Content', 'wolmart-core' ),
			'param_name'  => 'type',
			'value'       => array(
				'html'    => array(
					'title' => esc_html__( 'HTML', 'wolmart-core' ),
				),
				'block'   => array(
					'title' => esc_html__( 'Block', 'wolmart-core' ),
				),
				'product' => array(
					'title' => esc_html__( 'Product', 'wolmart-core' ),
				),
				'image'   => array(
					'title' => esc_html__( 'Image', 'wolmart-core' ),
				),
			),
			'std'         => 'html',
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea',
			'param_name' => 'html',
			'heading'    => esc_html__( 'Custom Html', 'wolmart-core' ),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'html',
			),
		),
		array(
			'type'       => 'autocomplete',
			'param_name' => 'block',
			'heading'    => esc_html__( 'Block', 'wolmart-core' ),
			'settings'   => array(
				'multiple' => false,
				'sortable' => true,
			),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'block',
			),
		),
		array(
			'type'       => 'attach_image',
			'heading'    => esc_html__( 'Choose Image', 'wolmart-core' ),
			'param_name' => 'image',
			'value'      => '',
			'dependency' => array(
				'element' => 'type',
				'value'   => 'image',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'image_size',
			'std'        => 'full',
			'heading'    => esc_html__( 'Image Size', 'wolmart-core' ),
			'value'      => wolmart_get_image_sizes(),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'image',
			),
		),
		array(
			'type'       => 'autocomplete',
			'heading'    => __( 'Product', 'js_composer' ),
			'param_name' => 'product',
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'product',
			),
		),
		array(
			'type'       => 'vc_link',
			'param_name' => 'link',
			'heading'    => esc_html__( 'Link URL', 'wolmart-core' ),
			'dependency' => array(
				'element' => 'type',
				'value'   => array( 'html', 'block', 'image' ),
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'popup_position',
			'heading'    => esc_html__( 'Popup Position', 'wolmart-core' ),
			'value'      => array(
				'none'   => array(
					'title' => esc_html__( 'Hide', 'wolmart-core' ),
				),
				'top'    => array(
					'title' => esc_html__( 'Top', 'wolmart-core' ),
				),
				'left'   => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'wolmart-core' ),
				),
			),
			'std'        => 'top',
		),
	),
	esc_html__( 'Hotspot Style', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'size',
			'heading'    => esc_html__( 'Hotspot Size', 'wolmart-core' ),
			'units'      => array(
				'px',
				'%',
				'rem',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .hotspot' => 'width:{{VALUE}}{{UNIT}};height:{{VALUE}}{{UNIT}};line-height:{{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'icon_size',
			'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
			'units'      => array(
				'px',
				'em',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .hotspot i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'param_name' => 'border_radius',
			'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .hotspot, {{WRAPPER}} .hotspot-wrapper::before' => 'border-radius:{{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
			'param_name' => 'hotspot_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .hotspot',
				'hover'  => '{{WRAPPER}}:hover .hotspot',
			),
			'choices'    => array( 'color', 'background-color' ),
		),
	),
	esc_html__( 'Popup Style', 'wolmart-core' )   => array(
		array(
			'type'       => 'wolmart_number',
			'param_name' => 'popup_width',
			'heading'    => esc_html__( 'Popup Width', 'wolmart-core' ),
			'units'      => array(
				'px',
				'%',
				'rem',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .hotspot-box' => 'width:{{VALUE}}{{UNIT}};min-width:{{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Hotspot', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_hotspot',
		'icon'            => 'wolmart-icon wolmart-icon-hotspot',
		'class'           => 'wolmart_hotspot',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart hotspot.', 'wolmart-core' ),
		'params'          => $params,
	)
);

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_hotspot_product_callback', 'wolmart_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_hotspot_product_render', 'wolmart_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_wolmart_hotspot_product_param_value', 'wolmart_wpb_shortcode_product_id_param_value', 10, 4 );

// Block Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_hotspot_block_callback', 'wolmart_wpb_shortcode_block_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_hotspot_block_render', 'wolmart_wpb_shortcode_block_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Hotspot extends WPBakeryShortCode {
	}
}
