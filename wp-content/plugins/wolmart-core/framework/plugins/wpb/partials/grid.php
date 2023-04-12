<?php
if ( ! function_exists( 'wolmart_wpb_grid_layout_controls' ) ) {
	function wolmart_wpb_grid_layout_controls() {
		return array(
			array(
				'type'       => 'wolmart_number',
				'param_name' => 'col_cnt',
				'heading'    => esc_html__( 'Columns', 'wolmart-core' ),
				'responsive' => true,
				'dependency' => array(
					'element' => 'layout_type',
					'value'   => array(
						'grid',
						'slider',
					),
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'param_name' => 'col_sp',
				'heading'    => esc_html__( 'Columns Spacing', 'wolmart-core' ),
				'std'        => 'md',
				'value'      => array(
					'no' => array(
						'title' => esc_html__( 'NO', 'wolmart-core' ),
					),
					'xs' => array(
						'title' => esc_html__( 'XS', 'wolmart-core' ),
					),
					'sm' => array(
						'title' => esc_html__( 'SM', 'wolmart-core' ),
					),
					'md' => array(
						'title' => esc_html__( 'MD', 'wolmart-core' ),
					),
					'lg' => array(
						'title' => esc_html__( 'LG', 'wolmart-core' ),
					),
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_loadmore_button_controls' ) ) {
	function wolmart_wpb_loadmore_button_controls() {
		return array(
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Label Typography', 'wolmart-core' ),
				'param_name' => 'loadmore_button_typography',
				'selectors'  => array(
					'{{WRAPPER}} .btn-load',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Min Width', 'wolmart-core' ),
				'param_name' => 'loadmore_btn_min_width',
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn-load' => 'min-width: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'loadmore_btn_padding',
				'selectors'  => array(
					'{{WRAPPER}} .btn-load' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'param_name' => 'loadmore_btn_border_radius',
				'selectors'  => array(
					'{{WRAPPER}} .btn-load' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'param_name' => 'loadmore_btn_border_width',
				'selectors'  => array(
					'{{WRAPPER}} .btn-load' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'loadmore_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .btn-load',
					'hover'  => '{{WRAPPER}} .btn-load:hover',
					'active' => '{{WRAPPER}} .btn-load:not(:focus):active, {{WRAPPER}} .btn-load:focus',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_slider_general_controls' ) ) {
	function wolmart_wpb_slider_general_controls() {
		global $wolmart_animations;
		if ( empty( $wolmart_animations ) ) {
			$wolmart_animations = array();
		}

		return array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Prevent Box Shadow Clip', 'wolmart-core' ),
				'param_name' => 'box_shadow_slider',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Full Height', 'wolmart-core' ),
				'param_name'  => 'fullheight',
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'description' => esc_html__( 'Change gap size of carousel items.', 'wolmart-core' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Scroll per Page', 'wolmart-core' ),
				'param_name'  => 'scroll_per_page',
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'description' => esc_html__( 'Scroll per page not per item.', 'wolmart-core' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Autoplay', 'wolmart-core' ),
				'param_name'  => 'autoplay',
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'description' => esc_html__( 'Enable autoslide of carousel items.', 'wolmart-core' ),
			),
			array(
				'type'        => 'wolmart_number',
				'heading'     => esc_html__( 'Autoplay Timeout', 'wolmart-core' ),
				'param_name'  => 'autoplay_timeout',
				'std'         => 5000,
				'description' => esc_html__( "Change carousel item's autoplay duration.", 'wolmart-core' ),
				'dependency'  => array(
					'element' => 'autoplay',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Auto Height', 'wolmart-core' ),
				'param_name'  => 'autoheight',
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'description' => esc_html__( "Adjust entire slider height to shown items' height", 'wolmart-core' ),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_slider_nav_controls' ) ) {
	function wolmart_wpb_slider_nav_controls() {
		$left  = is_rtl() ? 'right' : 'left';
		$right = is_rtl() ? 'left' : 'right';

		return array(
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Show Nav', 'wolmart-core' ),
				'param_name' => 'show_nav',
				'value'      => array(
					''    => array(
						'title' => esc_html__( 'Hide', 'wolmart-core' ),
					),
					'yes' => array(
						'title' => esc_html__( 'Show', 'wolmart-core' ),
					),
				),
				'std'        => '',
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Nav Auto Hide', 'wolmart-core' ),
				'param_name'  => 'nav_hide',
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'description' => esc_html__( 'Auto hide slider navigation when mouse is out.', 'wolmart-core' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Nav Type', 'wolmart-core' ),
				'param_name' => 'nav_type',
				'std'        => 'simple',
				'value'      => array(
					esc_html__( 'Simple', 'wolmart-core' ) => 'simple',
					esc_html__( 'Circle', 'wolmart-core' ) => 'circle',
					esc_html__( 'Full', 'wolmart-core' )   => 'full',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Nav Position', 'wolmart-core' ),
				'param_name' => 'nav_pos',
				'std'        => 'outer',
				'value'      => array(
					esc_html__( 'Inner', 'wolmart-core' )  => 'inner',
					esc_html__( 'Outer', 'wolmart-core' )  => 'outer',
					esc_html__( 'Top', 'wolmart-core' )    => 'top',
					esc_html__( 'Bottom', 'wolmart-core' ) => 'bottom',
				),
				'dependency' => array(
					'element'            => 'nav_type',
					'value_not_equal_to' => 'full',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Nav Horizontal Position', 'wolmart-core' ),
				'param_name' => 'nav_h_position',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element'            => 'nav_pos',
					'value_not_equal_to' => array( 'top', 'bottom' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider-button-prev' => "{$left}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .slider-button-next' => "{$right}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Nav Horizontal Position', 'wolmart-core' ),
				'param_name' => 'nav_top_h_position',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element' => 'nav_pos',
					'value'   => array( 'top', 'bottom' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider-button' => "{$right}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Nav Vertical Position', 'wolmart-core' ),
				'param_name' => 'nav_v_position',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element'            => 'nav_pos',
					'value_not_equal_to' => array( 'top', 'bottom' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider-button' => 'top: {{VALUE}}{{UNIT}}; transform: none;',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Nav Vertical Position', 'wolmart-core' ),
				'param_name' => 'nav_v_position_top',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element' => 'nav_pos',
					'value'   => 'top',
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider-button' => 'top: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Nav Vertical Position', 'wolmart-core' ),
				'param_name' => 'nav_v_position_bottom',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element' => 'nav_pos',
					'value'   => 'bottom',
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider-button' => 'bottom: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Nav Size', 'wolmart-core' ),
				'param_name' => 'slider_nav_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider-button' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'nav_colors',
				'selectors'  => array(
					'normal'   => '{{WRAPPER}} .slider-button',
					'hover'    => '{{WRAPPER}} .slider-button:not(.disabled):hover',
					'disabled' => '{{WRAPPER}} .slider-button.disabled',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_slider_dots_controls' ) ) {
	function wolmart_wpb_slider_dots_controls( $imagedot = false ) {
		$options = array();

		$show_dots_option = array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Show Dots', 'wolmart-core' ),
			'param_name' => 'show_dots',
			'value'      => array(
				''    => array(
					'title' => esc_html__( 'Hide', 'wolmart-core' ),
				),
				'yes' => array(
					'title' => esc_html__( 'Show', 'wolmart-core' ),
				),
			),
			'std'        => '',
		);

		// if ( $imagedot ) {
		// 	$show_dots_option['dependency'] = array(
		// 		'element' => 'dots_type',
		// 		'value'   => '',
		// 	);
		// }
		$options[] = $show_dots_option;

		if ( $imagedot ) {
			$options[] = array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Dots Type', 'wolmart-core' ),
				'param_name' => 'dots_type',
				'value'      => array(
					esc_html__( 'Default', 'wolmart-core' ) => '',
					esc_html__( 'Image dots', 'wolmart-core' ) => 'thumb',
				),
				'std'        => '',
			);
			$options[] = array(
				'type'        => 'attach_images',
				'heading'     => esc_html__( 'Add Thumbnails', 'js_composer' ),
				'param_name'  => 'thumbs',
				'description' => esc_html__( 'Select images from media library.', 'wolmart-core' ),
				'dependency'  => array(
					'element' => 'dots_type',
					'value'   => 'thumb',
				),
			);
			$options[] = array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Dots Vertical Position', 'wolmart-core' ),
				'param_name' => 'dots_thumb_spacing',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element' => 'dots_type',
					'value'   => 'thumb',
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider-thumb-dots .slider-pagination-bullet' => 'margin-right: {{VALUE}}{{UNIT}};',
				),
			);
		}

		$options[] = array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Dots Skin', 'wolmart-core' ),
			'param_name' => 'dots_skin',
			'std'        => '',
			'value'      => array(
				''      => array(
					'title' => esc_html__( 'Default', 'wolmart-core' ),
					'color' => 'var(--wolmart-primary-color, #2879FE)',
				),
				'white' => array(
					'title' => esc_html__( 'White', 'wolmart-core' ),
					'color' => '#fff',
				),
				'grey'  => array(
					'title' => esc_html__( 'Grey', 'wolmart-core' ),
					'color' => 'var(--wolmart-light-color, #ccc)',
				),
				'dark'  => array(
					'title' => esc_html__( 'Dark', 'wolmart-core' ),
					'color' => 'var(--wolmart-dark-color, $dark-color)',
				),
			),
			'dependency' => array(
				'element'            => 'dots_type',
				'value_not_equal_to' => 'thumb',
			),
		);
		$options[] = array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Dots Position', 'wolmart-core' ),
			'param_name' => 'dots_pos',
			'std'        => 'outer',
			'value'      => array(
				esc_html__( 'Inner', 'wolmart-core' )  => 'inner',
				esc_html__( 'Outer', 'wolmart-core' )  => 'outer',
				esc_html__( 'Close Outer', 'wolmart-core' ) => 'close',
				esc_html__( 'Custom', 'wolmart-core' ) => 'custom',
			),
		);
		$options[] = array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Dots Vertical Position', 'wolmart-core' ),
			'param_name' => 'dots_v_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'%',
			),
			'dependency' => array(
				'element' => 'dots_pos',
				'value'   => 'custom',
			),
			'selectors'  => array(
				'{{WRAPPER}} .slider-pagination' => 'position: absolute; bottom: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .slider-thumb-dots' => 'margin-top: calc( {{VALUE}}{{UNIT}} - 25px);',
			),
		);
		$options[] = array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Dots Horizontal Position', 'wolmart-core' ),
			'param_name' => 'dots_h_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'%',
			),
			'dependency' => array(
				'element' => 'dots_pos',
				'value'   => 'custom',
			),
			'selectors'  => array(
				'{{WRAPPER}} .slider-pagination' => 'position: absolute; left: {{VALUE}}{{UNIT}}; transform: translateX(-50%);',
				'{{WRAPPER}} .slider-thumb-dots' => 'margin-left: calc({{VALUE}}{{UNIT}} - 50%);',
			),
		);
		$options[] = array(
			'type'       => 'wolmart_number',
			'heading'    => esc_html__( 'Dots Size', 'wolmart-core' ),
			'param_name' => 'slider_dots_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'%',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .slider-pagination .slider-pagination-bullet' => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .slider-pagination .slider-pagination-bullet.active' => 'width: calc({{VALUE}}{{UNIT}} * 2.25); height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .slider-thumb-dots .slider-pagination-bullet' => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .slider-pagination ~ .slider-thumb-dots' => 'margin-top: calc(-{{VALUE}}{{UNIT}} / 2);',
			),
		);

		if ( $imagedot ) {
			$options[] = array(
				'type'       => 'wolmart_color_group',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'param_name' => 'thumb_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .slider-thumb-dots .slider-pagination-bullet',
					'hover'  => '{{WRAPPER}} .slider-thumb-dots .slider-pagination-bullet:hover',
					'active' => '{{WRAPPER}} .slider-thumb-dots .slider-pagination-bullet.active',
				),
				'choices'    => array( 'border-color' ),
				'dependency' => array(
					'element' => 'dots_type',
					'value'   => 'thumb',
				),
			);
		}

		$options[] = array(
			'type'       => 'wolmart_color_group',
			'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
			'param_name' => 'dot_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .slider-pagination .slider-pagination-bullet',
				'hover'  => '{{WRAPPER}} .slider-pagination .slider-pagination-bullet:hover',
				'active' => '{{WRAPPER}} .slider-pagination .slider-pagination-bullet.active',
			),
			'choices'    => array( 'background-color', 'border-color' ),
			'dependency' => array(
				'element'            => 'dots_type',
				'value_not_equal_to' => 'thumb',
			),
		);

		return $options;
	}
}

if ( ! function_exists( 'wolmart_wpb_elements_layout_controls' ) ) {
	function wolmart_wpb_elements_layout_controls( $layout_builder = false, $layout = '', $shortcode = '' ) {

		$creative_layout = wolmart_display_grid_preset_imgs();

		foreach ( $creative_layout as $key => $item ) {
			$creative_layout[ $key ] = array(
				'title' => $key,
				'image' => WOLMART_CORE_URI . $item,
			);
		}

		$result = array(
			array(
				'type'       => 'dropdown',
				'param_name' => 'thumbnail_size',
				'heading'    => esc_html__( 'Image Size', 'wolmart-core' ),
				'value'      => wolmart_get_image_sizes(),
			),
		);

		if ( 'slider' == $layout && ( false !== strpos( $shortcode, 'products_' ) || false !== strpos( $shortcode, 'categories_' ) || false !== strpos( $shortcode, 'posts_' ) || false !== strpos( $shortcode, 'images_' ) ) ) {
			$result[] = array(
				'type'       => 'wolmart_number',
				'param_name' => 'row_cnt',
				'heading'    => esc_html__( 'Rows', 'wolmart-core' ),
			);
		}

		if ( ! $layout_builder ) { // in case of Products grid, slider, masonry, Categories, Image gallery
			if ( 'creative' == $layout ) { // in case of Masonry Element
				$result[] = array(
					'type'         => 'wolmart_button_group',
					'param_name'   => 'creative_mode',
					'heading'      => esc_html__( 'Creative Layout', 'wolmart-core' ),
					'std'          => 1,
					'button_width' => '150',
					'value'        => $creative_layout,
				);
			} elseif ( $layout ) { // in case of Grid or Slider Element
				$result[] = array(
					'type'       => 'wolmart_number',
					'param_name' => 'col_cnt',
					'heading'    => esc_html__( 'Columns', 'wolmart-core' ),
					'responsive' => true,
				);
			}
		} else { // in case of Products Layout + Single Product, Banner Element
			array_push(
				$result,
				array(
					'type'       => 'wolmart_number',
					'param_name' => 'col_cnt',
					'heading'    => esc_html__( 'Columns', 'wolmart-core' ),
					'responsive' => true,
					'selectors'  => array(
						'{{WRAPPER}} .creative-grid' => 'grid-template-columns: repeat(auto-fill, calc(100% / {{VALUE}}))',
					),
				),
				array(
					'type'       => 'checkbox',
					'param_name' => 'creative_auto_height',
					'heading'    => esc_html__( 'Auto Row Height', 'wolmart-core' ),
					'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
					'selectors'  => array(
						'{{WRAPPER}} .creative-grid' => 'grid-auto-rows: auto',
					),
				),
				array(
					'type'        => 'wolmart_number',
					'heading'     => esc_html__( 'Base Column Size', 'wolmart - core' ),
					'param_name'  => 'base_col_span',
					'std'         => '{"xl":"1","unit":"","xs":"","sm":"","md":"","lg":""}',
					'responsive'  => true,
					'description' => esc_html__( 'Control column size of normal products in this layout', 'wolmart-core' ),
					'selectors'   => array(
						'{{WRAPPER}} .creative-grid > *' => 'grid-column-end: span {{VALUE}}',
					),
				),
				array(
					'type'        => 'wolmart_number',
					'heading'     => esc_html__( 'Base Row Size', 'wolmart - core' ),
					'param_name'  => 'base_row_span',
					'std'         => '{"xl":"1","unit":"","xs":"","sm":"","md":"","lg":""}',
					'responsive'  => true,
					'description' => esc_html__( 'Control row size of normal products in this layout', 'wolmart-core' ),
					'selectors'   => array(
						'{{WRAPPER}} .creative-grid > *' => 'grid-row-end: span {{VALUE}}',
					),
				)
			);
		}

		$result[] = array(
			'type'       => 'wolmart_button_group',
			'param_name' => 'col_sp',
			'heading'    => esc_html__( 'Columns Spacing', 'wolmart-core' ),
			'std'        => 'md',
			'value'      => array(
				'no' => array(
					'title' => esc_html__( 'NO', 'wolmart-core' ),
				),
				'xs' => array(
					'title' => esc_html__( 'XS', 'wolmart-core' ),
				),
				'sm' => array(
					'title' => esc_html__( 'SM', 'wolmart-core' ),
				),
				'md' => array(
					'title' => esc_html__( 'MD', 'wolmart-core' ),
				),
				'lg' => array(
					'title' => esc_html__( 'LG', 'wolmart-core' ),
				),
			),
		);

		if ( 'grid' == $layout && false !== strpos( $shortcode, 'images_' ) ) {
			$result[] = array(
				'type'       => 'wolmart_button_group',
				'param_name' => 'grid_vertical_align',
				'heading'    => esc_html__( 'Vertical Align', 'wolmart-core' ),
				'value'      => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'wolmart-core' ),
					),
					'center'     => array(
						'title' => esc_html__( 'Middle', 'wolmart-core' ),
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Bottom', 'wolmart-core' ),
					),
					'stretch'    => array(
						'title' => esc_html__( 'Stretch', 'wolmart-core' ),
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .image-wrap' => 'display: flex;align-items: {{VALUE}};',
				),
			);
		}
		if ( 'slider' == $layout ) {
			$result[] = array(
				'type'       => 'wolmart_button_group',
				'param_name' => 'slider_vertical_align',
				'heading'    => esc_html__( 'Vertical Align', 'wolmart-core' ),
				'value'      => array(
					'top'         => array(
						'title' => esc_html__( 'Top', 'wolmart-core' ),
					),
					'middle'      => array(
						'title' => esc_html__( 'Middle', 'wolmart-core' ),
					),
					'bottom'      => array(
						'title' => esc_html__( 'Bottom', 'wolmart-core' ),
					),
					'same-height' => array(
						'title' => esc_html__( 'Stretch', 'wolmart-core' ),
					),
				),
			);
			if ( false !== strpos( $shortcode, 'images_' ) ) {
				array_push(
					$result,
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Image Full Width', 'wolmart-core' ),
						'param_name' => 'slider_image_expand',
						'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
					),
					array(
						'type'       => 'wolmart_button_group',
						'param_name' => 'slider_horizontal_align',
						'heading'    => esc_html__( 'Horizontal Align', 'wolmart-core' ),
						'value'      => array(
							'flex-start' => array(
								'title' => esc_html__( 'Left', 'wolmart-core' ),
							),
							'center'     => array(
								'title' => esc_html__( 'Center', 'wolmart-core' ),
							),
							'flex-end'   => array(
								'title' => esc_html__( 'Right', 'wolmart-core' ),
							),
						),
						'dependency' => array(
							'element'            => 'slider_image_expand',
							'value_not_equal_to' => 'yes',
						),
						'selectors'  => array(
							'{{WRAPPER}} .slider-slide figure' => 'justify-content: {{VALUE}};',
						),
					)
				);
			}
		} elseif ( false !== strpos( $shortcode, 'products_' ) || false !== strpos( $shortcode, 'posts_' ) ) {
			array_push(
				$result,
				array(
					'type'       => 'dropdown',
					'param_name' => 'loadmore_type',
					'heading'    => esc_html__( 'Load More', 'wolmart-core' ),
					'value'      => array(
						esc_html__( 'No', 'wolmart-core' ) => '',
						esc_html__( 'By button', 'wolmart-core' ) => 'button',
						esc_html__( 'By pagination', 'wolmart-core' ) => 'page',
						esc_html__( 'By scroll', 'wolmart-core' ) => 'scroll',
					),
				),
				array(
					'type'        => 'textfield',
					'param_name'  => 'loadmore_label',
					'heading'     => esc_html__( 'Load More Label', 'wolmart-core' ),
					'value'       => '',
					'placeholder' => esc_html__( 'Load More', 'wolmart-core' ),
				)
			);
		}

		if ( false !== strpos( $shortcode, 'products_' ) ) {
			array_push(
				$result,
				array(
					'type'        => 'checkbox',
					'param_name'  => 'filter_cat_w',
					'heading'     => esc_html__( 'Filter by Category Widget', 'wolmart-core' ),
					'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
					'description' => esc_html__( 'If there is a category widget enabled "Filter Products" option in the same section, you can filter products by category widget.', 'wolmart-core' ),
				),
				array(
					'type'       => 'checkbox',
					'param_name' => 'filter_cat',
					'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
					'heading'    => esc_html__( 'Show Category Filter', 'wolmart-core' ),
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Show "All" Filter', 'wolmart-core' ),
					'param_name' => 'show_all_filter',
					'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
					'dependency' => array(
						'element' => 'filter_cat',
						'value'   => 'yes',
					),
				)
			);
		}

		return $result;
	}
}
