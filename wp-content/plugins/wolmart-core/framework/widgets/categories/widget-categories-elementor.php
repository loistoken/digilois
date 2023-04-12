<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Categories Widget
 *
 * Wolmart Widget to display product categories.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Wolmart_Controls_Manager;

class Wolmart_Categories_Elementor_Widget extends \Elementor\Widget_Base {

	// Showing Link Conditions
	private $show_link_conditions = array( 'icon', 'badge' );

	// Showing Count Conditions
	private $show_cnt_conditions = array( '', 'badge', 'banner', 'icon', 'ellipse', 'group-2', 'center' );

	public function get_name() {
		return 'wolmart_widget_categories';
	}

	public function get_title() {
		return esc_html__( 'Product Categories', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'product categories', 'shop', 'woocommerce', 'filter' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-product-categories';
	}

	public function get_script_depends() {
		$depends = array( 'swiper' );
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_categories_selector',
			array(
				'label' => esc_html__( 'Categories Selector', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'category_ids',
				array(
					'label'       => esc_html__( 'Select Categories', 'wolmart-core' ),
					'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
					'options'     => 'product_cat',
					'label_block' => true,
					'multiple'    => true,
				)
			);

			$this->add_control(
				'run_as_filter',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Filter Products', 'wolmart-core' ),
					'description' => esc_html__( 'In a same section, this will interact with products widget so taht you\'ll be able to filter products by category.', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'show_all_filter',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Show \'All\'', 'wolmart-core' ),
					'condition' => array(
						'run_as_filter' => 'yes',
					),
				)
			);

			$this->add_control(
				'run_as_filter_shop',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Filter Products in Shop', 'wolmart-core' ),
					'description' => esc_html__( 'You\'ll be able to filter products by category in shop page in case that ajax filter is enabled in theme options.', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'show_subcategories',
				array(
					'type'  => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Show Subcategories', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'hide_empty',
				array(
					'type'  => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Hide Empty', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'count',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Category Count', 'wolmart-core' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 24,
						),
					),
					'description' => esc_html__( '0 value will show all categories.', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'orderby',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Order By', 'wolmart-core' ),
					'default' => '',
					'options' => array(
						''            => esc_html__( 'Default', 'wolmart-core' ),
						'name'        => esc_html__( 'Name', 'wolmart-core' ),
						'id'          => esc_html__( 'ID', 'wolmart-core' ),
						'slug'        => esc_html__( 'Slug', 'wolmart-core' ),
						'modified'    => esc_html__( 'Modified', 'wolmart-core' ),
						'count'       => esc_html__( 'Product Count', 'wolmart-core' ),
						'parent'      => esc_html__( 'Parent', 'wolmart-core' ),
						'description' => esc_html__( 'Description', 'wolmart-core' ),
						'term_group'  => esc_html__( 'Term Group', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'orderway',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Order Way', 'wolmart-core' ),
					'options' => array(
						'ASC' => esc_html__( 'Ascending', 'wolmart-core' ),
						''    => esc_html__( 'Descending', 'wolmart-core' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_categories_layout',
			array(
				'label' => esc_html__( 'Layout', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'   => esc_html__( 'Categories Layout', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'grid',
					'options' => array(
						'grid'     => esc_html__( 'Grid', 'wolmart-core' ),
						'slider'   => esc_html__( 'Slider', 'wolmart-core' ),
						'creative' => esc_html__( 'Creative Grid', 'wolmart-core' ),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'    => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
					'default' => 'woocommerce_thumbnail',
				)
			);

			wolmart_elementor_grid_layout_controls( $this, 'layout_type', true, 'category' );

			wolmart_elementor_slider_layout_controls( $this, 'layout_type' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_category_type',
			array(
				'label' => esc_html__( 'Category Type', 'wolmart-core' ),
			)
		);
			$this->add_control(
				'follow_theme_option',
				array(
					'label'   => esc_html__( 'Follow Theme Option', 'wolmart-core' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				)
			);

			$this->add_control(
				'category_type',
				array(
					'label'     => esc_html__( 'Category Type', 'wolmart-core' ),
					'type'      => Wolmart_Controls_Manager::IMAGE_CHOOSE,
					'default'   => '',
					'options'   => array(
						''          => 'assets/images/categories/category-1.jpg',
						'frame'     => 'assets/images/categories/category-2.jpg',
						'banner'    => 'assets/images/categories/category-3.jpg',
						'simple'    => 'assets/images/categories/category-4.jpg',
						'icon'      => 'assets/images/categories/category-5.jpg',
						'classic'   => 'assets/images/categories/category-6.jpg',
						'classic-2' => 'assets/images/categories/category-7.jpg',
						'ellipse'   => 'assets/images/categories/category-8.jpg',
						'ellipse-2' => 'assets/images/categories/category-9.jpg',
						'group'     => 'assets/images/categories/category-10.jpg',
						'group-2'   => 'assets/images/categories/category-11.jpg',
						'label'     => 'assets/images/categories/category-12.jpg',
					),
					'condition' => array(
						'follow_theme_option' => '',
					),
					'width'     => 3,
				)
			);

			$this->add_responsive_control(
				'active_border_width',
				array(
					'label'     => esc_html__( 'Active Border Width', 'wolmart-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 6,
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 20,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .product-category:hover figure, .elementor-element-{{ID}} .product.active figure' => 'border-width:{{SIZE}}{{UNIT}};',
					),
					'condition' => array(
						'category_type' => 'ellipse-2',
					),
				)
			);

			$this->add_control(
				'show_icon',
				array(
					'label'     => esc_html__( 'Show Icon', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => '',
					'condition' => array(
						'category_type'       => array( 'group', 'group-2', 'label' ),
						'follow_theme_option' => '',
					),
				)
			);

			$this->add_control(
				'subcat_cnt',
				array(
					'label'     => esc_html__( 'Subcategory Count', 'wolmart-core' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 5,
					'condition' => array(
						'category_type'       => array( 'group', 'group-2' ),
						'follow_theme_option' => '',
					),
				)
			);

			$this->add_control(
				'overlay',
				array(
					'type'       => Controls_Manager::SELECT,
					'label'      => esc_html__( 'Overlay Effect', 'wolmart-core' ),
					'options'    => array(
						''           => esc_html__( 'No', 'wolmart-core' ),
						'light'      => esc_html__( 'Light', 'wolmart-core' ),
						'dark'       => esc_html__( 'Dark', 'wolmart-core' ),
						'zoom'       => esc_html__( 'Zoom', 'wolmart-core' ),
						'zoom_light' => esc_html__( 'Zoom and Light', 'wolmart-core' ),
						'zoom_dark'  => esc_html__( 'Zoom and Dark', 'wolmart-core' ),
					),
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'follow_theme_option',
								'operator' => '==',
								'value'    => '',
							),
							array(
								'relation' => 'or',
								'terms'    => array(
									array(
										'name'     => 'show_icon',
										'operator' => '==',
										'value'    => '',
									),
									array(
										'name'     => 'category_type',
										'operator' => '!in',
										'value'    => array( 'icon', 'group', 'group-2' ),
									),
								),
							),
						),
					),
				)
			);

		$this->end_controls_section();

		// $this->start_controls_section(
		// 	'section_style_cat',
		// 	array(
		// 		'label' => esc_html__( 'Category ', 'wolmart-core' ),
		// 		'tab'   => Controls_Manager::TAB_STYLE,
		// 	)
		// );
		// 	$this->add_responsive_control(
		// 		'cat_padding',
		// 		array(
		// 			'label'      => esc_html__( 'Padding', 'wolmart-core' ),
		// 			'type'       => Controls_Manager::DIMENSIONS,
		// 			'size_units' => array( 'px', 'em', '%' ),
		// 			'selectors'  => array(
		// 				'.elementor-element-{{ID}} .product-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 			),
		// 		)
		// 	);

		// 	$this->add_responsive_control(
		// 		'category_min_height',
		// 		array(
		// 			'label'      => esc_html__( 'Min Height', 'wolmart-core' ),
		// 			'type'       => Controls_Manager::SLIDER,
		// 			'default'    => array(
		// 				'unit' => 'px',
		// 			),
		// 			'size_units' => array(
		// 				'px',
		// 				'rem',
		// 				'%',
		// 				'vh',
		// 			),
		// 			'range'      => array(
		// 				'px' => array(
		// 					'step' => 1,
		// 					'min'  => 0,
		// 					'max'  => 700,
		// 				),
		// 			),
		// 			'selectors'  => array(
		// 				'.elementor-element-{{ID}} .product-category img' => 'min-height:{{SIZE}}{{UNIT}}; object-fit: cover;',
		// 			),
		// 		)
		// 	);

		// 	$this->add_control(
		// 		'cat_bg',
		// 		array(
		// 			'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
		// 			'type'      => Controls_Manager::COLOR,
		// 			'selectors' => array(
		// 				'.elementor-element-{{ID}} .product-category' => 'background-color: {{VALUE}};',
		// 			),
		// 		)
		// 	);

		// 	$this->add_control(
		// 		'cat_color',
		// 		array(
		// 			'label'     => esc_html__( 'Color', 'wolmart-core' ),
		// 			'type'      => Controls_Manager::COLOR,
		// 			'selectors' => array(
		// 				'.elementor-element-{{ID}} .product-category' => 'color: {{VALUE}};',
		// 			),
		// 		)
		// 	);

		// $this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			array(
				'label'     => esc_html__( 'Category Icon', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_icon' => 'yes',
				),
			)
		);

			$this->add_responsive_control(
				'icon_margin',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} figure i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'icon_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} figure' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'icon_typography',
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '.elementor-element-{{ID}} figure i',
				)
			);

			$this->add_control(
				'icon_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} figure i' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Category Content', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'content_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'content_align',
				array(
					'label'   => esc_html__( 'Content Align', 'wolmart-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => array(
						'content-left'   => array(
							'title' => esc_html__( 'Left', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'content-center' => array(
							'title' => esc_html__( 'Center', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'content-right'  => array(
							'title' => esc_html__( 'Right', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
				)
			);

			$this->add_control(
				'content_pos_heading',
				array(
					'label'     => esc_html__( 'Position', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => array(
						'category_type' => 'banner',
					),
				)
			);

			$this->add_control(
				'content_origin',
				array(
					'label'     => esc_html__( 'Origin X, Y', 'wolmart-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						''     => esc_html__( 'Default Default', 'wolmart-core' ),
						't-m'  => esc_html__( 'Default Center', 'wolmart-core' ),
						't-c'  => esc_html__( 'Center Default', 'wolmart-core' ),
						't-mc' => esc_html__( 'Center Center', 'wolmart-core' ),
					),
					'default'   => '',
					'condition' => array(
						'category_type' => 'banner',
					),
				)
			);

			$this->start_controls_tabs( 'content_position_tabs' );

			$this->start_controls_tab(
				'content_pos_left_tab',
				array(
					'label'     => esc_html__( 'Left', 'wolmart-core' ),
					'condition' => array(
						'category_type' => 'banner',
					),
				)
			);

			$this->add_responsive_control(
				'content_left',
				array(
					'label'      => esc_html__( 'Left Offset', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'size' => '3.7',
						'unit' => 'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => sprintf( 'left: %s', ! ( '{{SIZE}}' ) ? 'auto' : '{{SIZE}}{{UNIT}}' ),
					),
					'condition'  => array(
						'category_type' => 'banner',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'content_pos_top_tab',
				array(
					'label'     => esc_html__( 'Top', 'wolmart-core' ),
					'condition' => array(
						'category_type' => 'banner',
					),
				)
			);

			$this->add_responsive_control(
				'content_top',
				array(
					'label'      => esc_html__( 'Top Offset', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'size' => '3.8',
						'unit' => 'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'top:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'category_type' => 'banner',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'content_pos_right_tab',
				array(
					'label'     => esc_html__( 'Right', 'wolmart-core' ),
					'condition' => array(
						'category_type' => 'banner',
					),
				)
			);

			$this->add_responsive_control(
				'content_right',
				array(
					'label'      => esc_html__( 'Right Offset', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'right:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'category_type' => 'banner',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'content_pos_bottom_tab',
				array(
					'label'     => esc_html__( 'Bottom', 'wolmart-core' ),
					'condition' => array(
						'category_type' => 'banner',
					),
				)
			);

			$this->add_responsive_control(
				'content_bottom',
				array(
					'label'      => esc_html__( 'Bottom Offset', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'bottom:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'category_type' => 'banner',
					),
				)
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Category Name', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'title_typography',
					'selector' => '.elementor-element-{{ID}} .product-category .woocommerce-loop-category__title',
				)
			);

			$this->start_controls_tabs( 'tabs_cat_name_style' );

				$this->start_controls_tab(
					'tab_cat_name_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);
					$this->add_control(
						'title_color',
						array(
							'label'     => esc_html__( 'Text Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .woocommerce-loop-category__title' => 'color: {{VALUE}};',
							),
						)
					);
				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_cat_name_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);
					$this->add_control(
						'title_color_hover',
						array(
							'label'     => esc_html__( 'Text Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category:hover .woocommerce-loop-category__title, .elementor-element-{{ID}} .product.active .woocommerce-loop-category__title' => 'color: {{VALUE}};',
							),
						)
					);
				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'title_margin',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .woocommerce-loop-category__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_count',
			array(
				'label' => esc_html__( 'Products Count', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'count_color',
				array(
					'label'     => esc_html__( 'Text Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-category mark' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'count_typography',
					'selector' => '.elementor-element-{{ID}} .product-category mark',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			array(
				'label' => esc_html__( 'Button', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'typography',
					'scheme'   => Typography::TYPOGRAPHY_4,
					'selector' => '.elementor-element-{{ID}} .product-category .btn',
				)
			);

			$this->start_controls_tabs( 'tabs_button_style' );

				$this->start_controls_tab(
					'tab_button_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'btn_color',
						array(
							'label'     => esc_html__( 'Text Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_border_color',
						array(
							'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_button_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'btn_hover_color',
						array(
							'label'     => esc_html__( 'Text Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn:hover, .elementor-element-{{ID}} .product-category .btn:focus' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn:hover, .elementor-element-{{ID}} .product-category .btn:focus' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_border_color',
						array(
							'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'button_margin',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'button_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		wolmart_elementor_slider_style_controls( $this, 'layout_type' );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		if ( ! empty( $atts['category_ids'] ) && is_array( $atts['category_ids'] ) ) {
			$atts['category_ids'] = sanitize_text_field( implode( ',', $atts['category_ids'] ) );
		}
		require __DIR__ . '/render-categories.php';
	}

	protected function content_template() {}
}
