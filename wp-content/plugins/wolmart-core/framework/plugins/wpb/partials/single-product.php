<?php

if ( ! function_exists( 'wolmart_wpb_single_product_type_controls' ) ) {
	function wolmart_wpb_single_product_type_controls() {
		return array(
			array(
				'type'       => 'dropdown',
				'param_name' => 'sp_title_tag',
				'heading'    => esc_html__( 'Title Tag', 'wolmart-core' ),
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				'std'        => 'h2',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'sp_gallery_type',
				'heading'    => esc_html__( 'Gallery Type', 'wolmart-core' ),
				'width'      => '250',
				'value'      => array(
					esc_html__( 'Default', 'wolmart-core' ) => '',
					esc_html__( 'Vertical', 'wolmart-core' ) => 'vertical',
					esc_html__( 'Horizontal', 'wolmart-core' ) => 'horizontal',
					esc_html__( 'Grid Images', 'wolmart-core' ) => 'grid',
					esc_html__( 'Masonry', 'wolmart-core' ) => 'masonry',
					esc_html__( 'Gallery', 'wolmart-core' ) => 'gallery',
				),
				'std'        => '',
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'sp_vertical',
				'heading'    => esc_html__( 'Show Vertical', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			),
			array(
				'type'       => 'wolmart_multiselect',
				'param_name' => 'sp_show_info',
				'heading'    => esc_html__( 'Show Information', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'Gallery', 'wolmart-core' ) => 'gallery',
					esc_html__( 'Title', 'wolmart-core' )  => 'title',
					esc_html__( 'Meta', 'wolmart-core' )   => 'meta',
					esc_html__( 'Price', 'wolmart-core' )  => 'price',
					esc_html__( 'Rating', 'wolmart-core' ) => 'rating',
					esc_html__( 'Description', 'wolmart-core' ) => 'excerpt',
					esc_html__( 'Add To Cart Form', 'wolmart-core' ) => 'addtocart_form',
					esc_html__( 'Divider In Cart Form', 'wolmart-core' ) => 'divider',
					esc_html__( 'Share', 'wolmart-core' )  => 'share',
					esc_html__( 'Wishlist', 'wolmart-core' ) => 'wishlist',
					esc_html__( 'Compare', 'wolmart-core' ) => 'compare',
				),
				'std'        => 'gallery,title,meta,price,rating,excerpt,addtocart_form,divider,share,wishlist,compare',
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Columns', 'wolmart-core' ),
				'param_name' => 'gallery_col_cnt',
				'dependency' => array(
					'element' => 'sp_gallery_type',
					'value'   => array( 'grid', 'masonry', 'gallery' ),
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'param_name' => 'col_sp',
				'heading'    => esc_html__( 'Columns Spacing', 'wolmart-core' ),
				'std'        => 'md',
				'value'      => array(
					'no' => array(
						'title' => esc_html__( 'No space', 'wolmart-core' ),
					),
					'xs' => array(
						'title' => esc_html__( 'Extra Small', 'wolmart-core' ),
					),
					'sm' => array(
						'title' => esc_html__( 'Small', 'wolmart-core' ),
					),
					'md' => array(
						'title' => esc_html__( 'Medium', 'wolmart-core' ),
					),
					'lg' => array(
						'title' => esc_html__( 'Large', 'wolmart-core' ),
					),
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_single_product_style_controls' ) ) {
	function wolmart_wpb_single_product_style_controls() {
		return array(
			// esc_html__( 'Title', 'wolmart-core' )     => array(
				array(
					'type'       => 'wolmart_accordion_header',
					'heading'    => esc_html__( 'General', 'wolmart-core' ),
					'param_name' => 'general-ah',
				),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Summary Max Height', 'wolmart-core' ),
				'param_name' => 'summary_max_height',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .product-single.product-widget .summary' => 'max-height: {{VALUE}}{{UNIT}}; overflow-y: auto;',
				),
			),
			array(
				'type'       => 'wolmart_accordion_header',
				'heading'    => esc_html__( 'Title', 'wolmart-core' ),
				'param_name' => 'title-ah',
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'sp_title_color',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product_title a' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'param_name' => 'sp_title_typo',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product_title',
				),
			),
			// ),
			// esc_html__( 'Price', 'wolmart-core' )     => array(
				array(
					'type'       => 'wolmart_accordion_header',
					'heading'    => esc_html__( 'Price', 'wolmart-core' ),
					'param_name' => 'price-ah',
				),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'sp_price_color',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} p.price' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'param_name' => 'sp_price_typo',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} p.price',
				),
			),
			// ),
			// esc_html__( 'Old Price', 'wolmart-core' ) => array(
				array(
					'type'       => 'wolmart_accordion_header',
					'heading'    => esc_html__( 'Old Price', 'wolmart-core' ),
					'param_name' => 'old-price-ah',
				),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'sp_old_price_color',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .price del' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'param_name' => 'sp_old_price_typo',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .price del',
				),
			),
			// ),
			// esc_html__( 'Countdown', 'wolmart-core' ) => array(
				array(
					'type'       => 'wolmart_accordion_header',
					'heading'    => esc_html__( 'Countdown', 'wolmart-core' ),
					'param_name' => 'countdown-ah',
				),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'sp_countdown_color',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-countdown-container' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'param_name' => 'sp_countdown_typo',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-countdown-container',
				),
			),
		// ),
		);
	}
}

