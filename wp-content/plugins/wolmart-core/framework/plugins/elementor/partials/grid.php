<?php
defined( 'ABSPATH' ) || die;

/**
 * Grid Functions
 * Load More Functions
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

/**
 * Register elementor layout controls for grid.
 */

function wolmart_elementor_grid_layout_controls( $self, $condition_key, $creative = false, $widget = '' ) {

	$self->add_control(
		'box_shadow_slider',
		array(
			'type'      => Controls_Manager::SWITCHER,
			'label'     => esc_html__( 'Prevent Box Shadow Clip', 'wolmart-core' ),
			'condition' => array(
				$condition_key => array( 'slider' ),
			),
		)
	);

	if ( 'product' == $widget || 'category' == $widget || 'post' == $widget || 'image_gallery' == $widget || 'product_brand' == $widget || 'vendor' == $widget ) {
		$self->add_control(
			'row_cnt',
			array(
				'label'     => esc_html__( 'Rows', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
					'7' => 7,
				),
				'default'   => 1,
				'condition' => array(
					$condition_key => array( 'slider' ),
				),
			)
		);
	}

	$self->add_responsive_control(
		'col_cnt',
		array(
			'type'      => Controls_Manager::SELECT,
			'label'     => esc_html__( 'Columns', 'wolmart-core' ),
			'options'   => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
				'6' => 6,
				'7' => 7,
				'8' => 8,
				''  => esc_html__( 'Default', 'wolmart-core' ),
			),
			'condition' => array(
				$condition_key => array( 'slider', 'grid' ),
			),
		)
	);

	$self->add_control(
		'col_cnt_xl',
		array(
			'label'     => esc_html__( 'Columns ( >= 1200px )', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'options'   => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
				'6' => 6,
				'7' => 7,
				'8' => 8,
				''  => esc_html__( 'Default', 'wolmart-core' ),
			),
			'condition' => array(
				$condition_key => array( 'slider', 'grid' ),
			),
		)
	);

	$self->add_control(
		'col_cnt_min',
		array(
			'label'     => esc_html__( 'Columns ( < 576px )', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'options'   => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
				'6' => 6,
				'7' => 7,
				'8' => 8,
				''  => esc_html__( 'Default', 'wolmart-core' ),
			),
			'condition' => array(
				$condition_key => array( 'slider', 'grid' ),
			),
		)
	);
	if ( $creative ) {
		$self->add_responsive_control(
			'creative_cols',
			array(
				'type'           => Controls_Manager::SLIDER,
				'label'          => esc_html__( 'Columns', 'wolmart-core' ),
				'default'        => array(
					'size' => 4,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 3,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 2,
					'unit' => 'px',
				),
				'size_units'     => array(
					'px',
				),
				'range'          => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 60,
					),
				),
				'condition'      => array(
					$condition_key => 'creative',
				),
				'selectors'      => array(
					'.elementor-element-{{ID}} .creative-grid' => 'grid-template-columns: repeat(auto-fill, calc(100% / {{SIZE}}))',
				),
			)
		);
	}

	$self->add_control(
		'col_sp',
		array(
			'label'   => esc_html__( 'Columns Spacing', 'wolmart-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'md',
			'options' => array(
				'no' => esc_html__( 'No space', 'wolmart-core' ),
				'xs' => esc_html__( 'Extra Small', 'wolmart-core' ),
				'sm' => esc_html__( 'Small', 'wolmart-core' ),
				'md' => esc_html__( 'Medium', 'wolmart-core' ),
				'lg' => esc_html__( 'Large', 'wolmart-core' ),
			),
		)
	);

	if ( $creative ) {
		/**
		 * Using Display Grid Css
		 */
		$repeater = new Repeater();

		$repeater->add_control(
			'item_no',
			array(
				'label'       => esc_html__( 'Item Index', 'wolmart-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Blank for all items.', 'wolmart-core' ),
			)
		);

		$repeater->add_responsive_control(
			'item_col_span',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Column Size', 'wolmart-core' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 12,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-column-end: span {{SIZE}}',
				),
			)
		);

		$repeater->add_responsive_control(
			'item_row_span',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Row Size', 'wolmart-core' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 8,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-row-end: span {{SIZE}}',
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'item_thumb', // Usage: `{name}_size` and `{name}_custom_dimension`
				'label'     => esc_html__( 'Image Size', 'wolmart-core' ),
				'default'   => 'woocommerce_single',
				'condition' => array(
					'item_no!' => '',
				),
			)
		);

		if ( 'product' == $widget ) {
			$repeater->add_control(
				'product_type',
				array(
					'label'     => esc_html__( 'Product Type', 'wolmart-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => array(
						''          => esc_html__( 'Type 1', 'wolmart-core' ),
						'product-2' => esc_html__( 'Type 2', 'wolmart-core' ),
						'product-3' => esc_html__( 'Type 3', 'wolmart-core' ),
						'product-4' => esc_html__( 'Type 4', 'wolmart-core' ),
						'product-5' => esc_html__( 'Type 5', 'wolmart-core' ),
						'product-6' => esc_html__( 'Type 6', 'wolmart-core' ),
						'product-7' => esc_html__( 'Type 7', 'wolmart-core' ),
						'product-8' => esc_html__( 'Type 8', 'wolmart-core' ),
						'widget'    => esc_html__( 'Widget', 'wolmart-core' ),
						'list'      => esc_html__( 'List', 'wolmart-core' ),
					),
					'condition' => array(
						'item_no!' => '',
					),
				)
			);
		}

		$self->add_control(
			'creative_layout_heading',
			array(
				'label'     => __( "Customize each grid item's layout", 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					$condition_key => 'creative',
				),
			)
		);

		$self->add_control(
			'items_list',
			array(
				'label'       => esc_html__( 'Grid Item Layouts', 'wolmart-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'condition'   => array(
					$condition_key => 'creative',
				),
				'default'     => array(
					array(
						'item_no'       => '',
						'item_col_span' => array(
							'size' => 1,
							'unit' => 'px',
						),
						'item_row_span' => array(
							'size' => 1,
							'unit' => 'px',
						),
					),
					array(
						'item_no'       => 2,
						'item_col_span' => array(
							'size' => 2,
							'unit' => 'px',
						),
						'item_row_span' => array(
							'size' => 1,
							'unit' => 'px',
						),
					),
				),
				'title_field' => sprintf( '{{{ item_no ? \'%1$s\' : \'%2$s\' }}}' . ' <strong>{{{ item_no }}}</strong>', esc_html__( 'Index', 'wolmart-core' ), esc_html__( 'Base', 'wolmart-core' ) ),
			)
		);

		$self->add_responsive_control(
			'creative_equal_height',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Different Row Height', 'wolmart-core' ),
				'default'   => 'yes',
				'condition' => array(
					$condition_key => 'creative',
				),
				'separator' => 'after',
				'selectors' => array(
					'.elementor-element-{{ID}} .creative-grid' => 'grid-auto-rows: auto',
				),
			)
		);
	}
}

function wolmart_elementor_grid_template() {
	?>

	function wolmart_get_responsive_cols( cols ) {
		var result = {},
			base = parseInt(cols.lg);

		base || (base = 4);

		if ( 6 < base ) {
			result = {
				lg: base,
				md: 6,
				sm: 4,
				min: 3
			};
		} else if ( 4 < base ) {
			result = {
				lg: base,
				md: 4,
				sm: 3,
				min: 2,
			};
		} else if ( 2 < base ) {
			result = {
				lg: base,
				md: 3,
				sm: 2,
				min: 1,
			};
		} else {
			result = {
				lg: base,
				md: base,
				sm: base,
				min: base,
			};
		}

		for ( var w in cols ) {
			cols[w] > 0 && ( result[w] = cols[w] );
		}

		return result;
	}

	function wolmart_get_col_class( cols ) {
		var cls = ' row';
		for ( var w in cols ) {
			cols[w] > 0 && ( cls += ' cols-' + ( 'min' !== w ? w + '-' : '' ) + cols[w] );
		}
		return cls;
	}

	<?php
}

function wolmart_elementor_loadmore_layout_controls( $self, $condition_key ) {

	$self->add_control(
		'loadmore_type',
		array(
			'label'     => esc_html__( 'Load More', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				''       => esc_html__( 'No', 'wolmart-core' ),
				'button' => esc_html__( 'By button', 'wolmart-core' ),
				'page'   => esc_html__( 'By pagination', 'wolmart-core' ),
				'scroll' => esc_html__( 'By scroll', 'wolmart-core' ),
			),
			'condition' => array(
				$condition_key => array( 'grid', 'creative' ),
			),
		)
	);

	$self->add_control(
		'loadmore_label',
		array(
			'label'       => esc_html__( 'Load More Label', 'wolmart-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => esc_html__( 'Load More', 'wolmart-core' ),
			'condition'   => array(
				'loadmore_type' => 'button',
				$condition_key  => array( 'grid', 'creative' ),
			),
		)
	);
}

function wolmart_elementor_loadmore_button_controls( $self, $condition_key, $name_prefix = '' ) {
	$self->start_controls_section(
		'section_load_more_btn_skin',
		array(
			'label'     => esc_html__( 'Load More Button', 'wolmart-core' ),
			'condition' => array(
				'loadmore_type' => 'button',
				$condition_key  => array( 'grid', 'creative' ),
			),
		)
	);

	wolmart_elementor_button_layout_controls( $self, $condition_key, array( 'grid', 'creative' ), $name_prefix );

	$self->end_controls_section();

	$self->start_controls_section(
		'section_load_more_btn_style',
		array(
			'label'     => esc_html__( 'Load More Button', 'wolmart-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'loadmore_type' => 'button',
				$condition_key  => array( 'grid', 'creative' ),
			),
		)
	);

		$self->add_control(
			$name_prefix . 'button_customize_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Customize Options', 'wolmart-core' ),
				'separator' => 'before',
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => $name_prefix . 'button_typography',
				'label'    => esc_html__( 'Label Typography', 'wolmart-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '.elementor-element-{{ID}} .btn-load',
			)
		);

		$self->add_responsive_control(
			$name_prefix . 'btn_min_width',
			array(
				'label'      => esc_html__( 'Min Width', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 5,
					),
				),
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .btn-load' => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			$name_prefix . 'btn_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .btn-load' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			$name_prefix . 'btn_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .btn-load' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			$name_prefix . 'btn_border_width',
			array(
				'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .btn-load' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
				),
			)
		);

		$self->start_controls_tabs( $name_prefix . 'tabs_btn_cat' );

		$self->start_controls_tab(
			$name_prefix . 'tab_btn_normal',
			array(
				'label' => esc_html__( 'Normal', 'wolmart-core' ),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => $name_prefix . 'btn_box_shadow',
				'selector' => '.elementor-element-{{ID}} .btn-load',
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			$name_prefix . 'tab_btn_hover',
			array(
				'label' => esc_html__( 'Hover', 'wolmart-core' ),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_back_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => $name_prefix . 'btn_box_shadow_hover',
				'selector' => '.elementor-element-{{ID}} .btn-load:hover',
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			$name_prefix . 'tab_btn_active',
			array(
				'label' => esc_html__( 'Active', 'wolmart-core' ),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_color_active',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:not(:focus):active, .elementor-element-{{ID}} .btn-load:focus' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_back_color_active',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:not(:focus):active, .elementor-element-{{ID}} .btn-load:focus' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_border_color_active',
			array(
				'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:not(:focus):active, .elementor-element-{{ID}} .btn-load:focus' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => $name_prefix . 'btn_box_shadow_active',
				'selector' => '.elementor-element-{{ID}} .btn-load:active, .elementor-element-{{ID}} .btn-load:focus',
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

	$self->end_controls_section();
}
