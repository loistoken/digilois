<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Brands Widget
 *
 * Wolmart Widget to display brands.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Wolmart_Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;


class Wolmart_Brands_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_brands';
	}

	public function get_title() {
		return esc_html__( 'Brands', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'brands', 'brand', 'product' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-photo-library';
	}

	public function get_script_depends() {
		return array( 'swiper' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_brands',
			array(
				'label' => esc_html__( 'Brands Selector', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'brands',
				array(
					'label'       => esc_html__( 'Select Brands', 'wolmart-core' ),
					'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
					'options'     => 'product_brand',
					'label_block' => true,
					'multiple'    => true,
				)
			);

			$this->add_control(
				'hide_empty',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Hide Empty', 'wolmart-core' ),
					'description' => esc_html__( 'Hide brand without any products', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'count',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Brands Count', 'wolmart-core' ),
					'description' => esc_html__( '0 value will show all brands.', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'orderby',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Order By', 'wolmart-core' ),
					'default' => 'name',
					'options' => array(
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
					'default' => 'ASC',
					'options' => array(
						'ASC'  => esc_html__( 'Ascending', 'wolmart-core' ),
						'DESC' => esc_html__( 'Descending', 'wolmart-core' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Layout', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'   => esc_html__( 'Layout', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'grid',
					'options' => array(
						'grid'   => esc_html__( 'Grid', 'wolmart-core' ),
						'slider' => esc_html__( 'Slider', 'wolmart-core' ),
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

			wolmart_elementor_grid_layout_controls( $this, 'layout_type', false, 'product_brand' );

			$this->add_control(
				'slider_vertical_align',
				array(
					'label'     => esc_html__( 'Vertical Align', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'top'         => array(
							'title' => esc_html__( 'Top', 'wolmart-core' ),
							'icon'  => 'eicon-v-align-top',
						),
						'middle'      => array(
							'title' => esc_html__( 'Middle', 'wolmart-core' ),
							'icon'  => 'eicon-v-align-middle',
						),
						'bottom'      => array(
							'title' => esc_html__( 'Bottom', 'wolmart-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'same-height' => array(
							'title' => esc_html__( 'Stretch', 'wolmart-core' ),
							'icon'  => 'eicon-v-align-stretch',
						),
					),
					'condition' => array(
						'brand_type'  => '1',
						'layout_type' => 'slider',
					),
				)
			);

			$this->add_control(
				'slider_image_expand',
				array(
					'label'     => esc_html__( 'Image Full Width', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'brand_type'  => '1',
						'layout_type' => 'slider',
					),
				)
			);

			$this->add_control(
				'slider_horizontal_align',
				array(
					'label'     => esc_html__( 'Horizontal Align', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'flex-start' => array(
							'title' => esc_html__( 'Left', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => esc_html__( 'Center', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Right', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} figure' => 'display: flex; justify-content:{{VALUE}}',
					),
					'condition' => array(
						'brand_type'          => '1',
						'slider_image_expand' => '',
						'layout_type'         => 'slider',
					),
				)
			);

			$this->add_control(
				'grid_vertical_align',
				array(
					'label'     => esc_html__( 'Vertical Align', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'flex-start' => array(
							'title' => esc_html__( 'Top', 'wolmart-core' ),
							'icon'  => 'eicon-v-align-top',
						),
						'center'     => array(
							'title' => esc_html__( 'Middle', 'wolmart-core' ),
							'icon'  => 'eicon-v-align-middle',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Bottom', 'wolmart-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'stretch'    => array(
							'title' => esc_html__( 'Stretch', 'wolmart-core' ),
							'icon'  => 'eicon-v-align-stretch',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} figure' => 'display: flex; align-items:{{VALUE}}; height: 100%;',
					),
					'condition' => array(
						'brand_type'  => '1',
						'layout_type' => 'grid',
					),
				)
			);

			$this->add_control(
				'grid_image_expand',
				array(
					'label'     => esc_html__( 'Image Full Width', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'selectors' => array(
						'.elementor-element-{{ID}} figure a, .elementor-element-{{ID}} figure img' => 'width: 100%;',
					),
					'condition' => array(
						'brand_type'  => '1',
						'layout_type' => 'grid',
					),
				)
			);

			$this->add_control(
				'grid_horizontal_align',
				array(
					'label'     => esc_html__( 'Horizontal Align', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'flex-start' => array(
							'title' => esc_html__( 'Left', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => esc_html__( 'Center', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Right', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} figure' => 'display: flex; justify-content:{{VALUE}}',
					),
					'condition' => array(
						'brand_type'        => '1',
						'grid_image_expand' => '',
						'layout_type'       => 'grid',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_brand_type',
			array(
				'label' => esc_html__( 'Brands Type', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'brand_type',
				array(
					'label'   => esc_html__( 'Display Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '1',
					'options' => array(
						'1' => esc_html__( 'Type 1', 'wolmart-core' ),
						'2' => esc_html__( 'Type 2', 'wolmart-core' ),
						'3' => esc_html__( 'Type 3', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'show_brand_rating',
				array(
					'label'     => esc_html__( 'Show Brand Rating', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'brand_type' => array( '2', '3' ),
					),
				)
			);

			$this->add_control(
				'show_brand_products',
				array(
					'label'     => esc_html__( 'Show Brand Products', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'brand_type' => array( '3' ),
					),
				)
			);

		$this->end_controls_section();

		// Add brand style
		$this->start_controls_section(
			'section_brand_style',
			array(
				'label'     => esc_html__( 'Brand Style', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'brand_type' => array( '2', '3' ),
				),
			)
		);

			// Style for Brand name
			$this->add_control(
				'style_brand_name',
				array(
					'label' => esc_html__( 'Brand Name', 'wolmart-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->start_controls_tabs( 'brand_name_tabs' );
				$this->start_controls_tab(
					'brand_name_default_style',
					array(
						'label' => esc_html__( 'Default', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'brand_name_default_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .brand-name a' => 'color: {{VALUE}};',
							),
						)
					);
				$this->end_controls_tab();

				$this->start_controls_tab(
					'brand_name_hover_style',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'brand_name_hover_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .brand-name a:hover' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'brand_name_typo',
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '.elementor-element-{{ID}} .brand-name',
				)
			);

			// Style for Product Count
			$this->add_control(
				'style_brand_product_count',
				array(
					'label'     => esc_html__( 'Product Count', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'brand_product_count_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .brand-product-count' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'brand_product_count_typo',
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '.elementor-element-{{ID}} .brand-product-count',
				)
			);

		$this->end_controls_section();

		wolmart_elementor_slider_style_controls( $this, 'layout_type' );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-brands-elementor.php';
	}

}
