<?php
/**
 * Wolmart Single Product Rating
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Style', 'wolmart-core' ) => array(
		esc_html__( 'General', 'wolmart-core' ) => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Type', 'wolmart-core' ),
				'param_name' => 'sp_type',
				'value'      => array(
					esc_html__( 'Star', 'wolmart-core' )   => 'star',
					esc_html__( 'Number', 'wolmart-core' ) => 'number',
				),
				'std'        => 'star',
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
				'param_name' => 'sp_align',
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
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-rating' => 'justify-content: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Number', 'wolmart-core' )  => array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'sp_number_typo',
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-rating',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'number',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'number_color',
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-rating' => 'color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'number',
				),
			),
		),
		esc_html__( 'Star', 'wolmart-core' )    => array(
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Size', 'wolmart-core' ),
				'param_name' => 'icon_size',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .star-rating' => 'font-size: {{VALUE}}{{UNIT}}',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'star',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Spacing', 'wolmart-core' ),
				'param_name' => 'icon_space',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .star-rating' => 'letter-spacing: {{VALUE}}{{UNIT}}',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'star',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'stars_color',
				'selectors'  => array(
					'{{WRAPPER}} .star-rating:before' => 'color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'star',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Unmarked Color', 'wolmart-core' ),
				'param_name' => 'stars_unmarked_color',
				'selectors'  => array(
					'{{WRAPPER}} .star-rating span:after' => 'color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'star',
				),
			),
		),
		esc_html__( 'Reviews', 'wolmart-core' ) => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Reviews Show', 'wolmart-core' ),
				'param_name' => 'sp_reviews',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'std'        => 'yes',
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'sp_review_typo',
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-review-link',
				),
				'dependency' => array(
					'element' => 'sp_reviews',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'stars_review_color',
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-review-link' => 'color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'sp_reviews',
					'value'   => 'yes',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Rating', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_rating',
		'icon'            => 'wolmart-icon wolmart-icon-sp-rating',
		'class'           => 'wolmart_sp_rating',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product rating.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Rating extends WPBakeryShortCode {

	}
}
