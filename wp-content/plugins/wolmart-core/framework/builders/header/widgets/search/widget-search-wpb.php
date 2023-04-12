<?php
/**
 * Header Search Button
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )           => array(
		array(
			'type'         => 'wolmart_button_group',
			'heading'      => esc_html__( 'Search Form', 'wolmart-core' ),
			'param_name'   => 'type',
			'std'          => 'hs-simple',
			'button_width' => 200,
			'value'        => array(
				'hs-simple'   => array(
					'title' => esc_html__( 'Simple Type', 'wolmart-core' ),
					'image' => WOLMART_CORE_URI . '/assets/images/header-search/form-2.jpg',
				),
				'hs-expanded' => array(
					'title' => esc_html__( 'Expanded Type', 'wolmart-core' ),
					'image' => WOLMART_CORE_URI . '/assets/images/header-search/form-1.jpg',
				),
			),
		),
		array(
			'type'        => 'wolmart_button_group',
			'heading'     => esc_html__( 'Search Types', 'wolmart-core' ),
			'description' => esc_html__( 'Select post types to search', 'wolmart-core' ),
			'param_name'  => 'search_type',
			'value'       => array(
				''        => array(
					'title' => esc_html__( 'All', 'wolmart-core' ),
				),
				'product' => array(
					'title' => esc_html__( 'Product', 'wolmart-core' ),
				),
				'post'    => array(
					'title' => esc_html__( 'Post', 'wolmart-core' ),
				),
			),
			'std'         => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Search Form Placeholder', 'wolmart-core' ),
			'param_name' => 'placeholder',
			'std'        => esc_html__( 'Search in...', 'wolmart-core' ),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Search Icon', 'wolmart-core' ),
			'param_name' => 'icon',
			'std'        => 'w-icon-search',
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Search Width', 'wolmart-core' ),
			'param_name' => 'search_width',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .hs-expanded' => 'max-width: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .hs-simple'   => 'max-width: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'search_align',
			'value'      => array(
				'0 auto 0 0' => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'0 auto'     => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'0 0 0 auto' => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => '0 auto 0 0',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper' => 'margin: {{VALUE}};',
			),
		),
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Search Height', 'wolmart-core' ),
			'param_name' => 'search_height',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .hs-expanded form' => 'height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .hs-simple form'   => 'height: {{VALUE}}{{UNIT}};',
			),
		),
	),
	esc_html__( 'Input Field Style', 'wolmart-core' ) => array(
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'search_padding',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper input.form-control' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				'{{WRAPPER}} .search-wrapper select' => 'padding-right: {{RIGHT}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_typography',
			'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
			'param_name' => 'input_typography',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper input.form-control, {{WRAPPER}} .search-wrapper input.form-control::placeholder, {{WRAPPER}} select',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'wolmart-core' ),
			'param_name' => 'search_color',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper input.form-control,  {{WRAPPER}} .search-wrapper input.form-control::placeholder' => 'color: {{VALUE}};',
				'{{WRAPPER}} .search-wrapper .select-box' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
			'param_name' => 'search_bg',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper form' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
			'param_name' => 'search_bd',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper form.input-wrapper' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
			'param_name' => 'search_br',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper .select-box' => 'border-top-left-radius: {{TOP}};border-top-right-radius: 0;border-bottom-right-radius: 0;border-bottom-left-radius: {{LEFT}};',
				'{{WRAPPER}} .search-wrapper .btn-search' => 'border-top-left-radius: 0;border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: 0;',
				'{{WRAPPER}} .search-wrapper.hs-simple input.form-control' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
				'{{WRAPPER}} .search-wrapper form'        => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'wolmart-core' ),
			'param_name' => 'search_bd_color',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper form.input-wrapper' => 'border-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Separator Color', 'wolmart-core' ),
			'param_name' => 'search_separator_color',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper .select-box:after' => 'background: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'hs-expanded',
			),
		),
	),
	esc_html__( 'Button Style', 'wolmart-core' )      => array(
		array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
			'param_name' => 'icon_size',
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper .btn-search i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'wolmart_dimension',
			'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
			'param_name' => 'btn_padding',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper .btn-search' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
			'param_name' => 'btn_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .search-wrapper .btn-search',
				'hover'  => '{{WRAPPER}} .search-wrapper .btn-search:hover',
			),
			'choices'    => array( 'color', 'background-color' ),
		),
	),
);

	$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

	vc_map(
		array(
			'name'            => esc_html__( 'Search', 'wolmart-core' ),
			'base'            => 'wpb_wolmart_hb_search',
			'icon'            => 'wolmart-icon wolmart-icon-search',
			'class'           => 'wolmart_hb_search',
			'content_element' => true,
			'controls'        => 'full',
			'category'        => esc_html__( 'Wolmart Header', 'wolmart-core' ),
			'description'     => esc_html__( 'Create wolmart search.', 'wolmart-core' ),
			'params'          => $params,
		)
	);

	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_WPB_Wolmart_HB_Search extends WPBakeryShortCode {
		}
	}
