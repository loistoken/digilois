<?php
/**
 * Wolmart Single Product Image
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Content', 'wolmart-core' ) => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Type', 'wolmart-core' ),
			'param_name' => 'sp_type',
			'std'        => 'default',
			'value'      => array(
				esc_html__( 'Default', 'wolmart-core' )    => 'default',
				esc_html__( 'Horizontal', 'wolmart-core' ) => 'horizontal',
				esc_html__( 'Grid', 'wolmart-core' )       => 'grid',
				esc_html__( 'Masonry', 'wolmart-core' )    => 'masonry',
				esc_html__( 'Gallery', 'wolmart-core' )    => 'gallery',
			),
		),
		array(
			'type'        => 'wolmart_number',
			'heading'     => esc_html__( 'Columns', 'wolmart-core' ),
			'param_name'  => 'col_cnt',
			'responsive'  => true,
			'value'       => '',
			'description' => 'Type numbers from 1 to 8.',
			'dependency'  => array(
				'element' => 'sp_type',
				'value'   => array( 'grid', 'gallery' ),
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		esc_html__( 'Image', 'wolmart-core' )      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'param_name' => 'image_border',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-gallery__image img' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'param_name' => 'image_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-gallery__image img' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Border Color', 'wolmart-core' ),
				'param_name' => 'btn_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .woocommerce-product-gallery__image img',
					'hover'  => '{{WRAPPER}} .woocommerce-product-gallery__image a:hover img',
					'active' => '{{WRAPPER}} .woocommerce-product-gallery__image a:active img',
				),
				'choices'    => array( 'color' ),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'param_name' => 'image_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-gallery__image img' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Thumbnails', 'wolmart-core' ) => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'param_name' => 'thumbnail_border',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .product-thumb img' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'param_name' => 'thumbnail_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-thumb img' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Spacing', 'wolmart-core' ),
				'param_name' => 'thumbs_space',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'value'      => '',
				'selectors'  => array(
					'{{WRAPPER}} .product-thumb' => 'margin-bottom: {{VALUE}}{{UNIT}};',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Image', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_image',
		'icon'            => 'wolmart-icon wolmart-icon-sp-image',
		'class'           => 'wolmart_sp_image',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product image.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Image extends WPBakeryShortCode {

	}
}
