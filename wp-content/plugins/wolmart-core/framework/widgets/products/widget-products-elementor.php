<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Products Widget
 *
 * Wolmart Widget to display products.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Wolmart_Products_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_products';
	}

	public function get_title() {
		return esc_html__( 'Products', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce', 'sale', 'featured', 'recently viewed' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-products';
	}

	public function get_script_depends() {
		$depends = array( 'swiper' );
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		wolmart_elementor_products_select_controls( $this, true, 'products' );

		wolmart_elementor_products_layout_controls( $this );

		wolmart_elementor_product_type_controls( $this );

		wolmart_elementor_slider_style_controls( $this, 'layout_type' );

		wolmart_elementor_product_style_controls( $this );

		$right = is_rtl() ? 'left' : 'right';

		$this->start_controls_section(
			'section_view_style',
			array(
				'label' => esc_html__( 'Recently Viewed', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'view_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'separator'  => 'after',
					'selectors'  => array(
						'.elementor-element-{{ID}} .dropdown>a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'view_icon_size',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'View Icon Size', 'wolmart-core' ),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 5,
							'max'  => 40,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .products-view-dropdown>a>i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'view_icon_spacing',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'View Icon Spacing', 'wolmart-core' ),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 30,
						),
					),
					'separator'  => 'after',
					'selectors' => array(
						'.elementor-element-{{ID}} .products-view-dropdown>a>i' => "margin-{$right}: {{SIZE}}px;",
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'view_label_typography',
					'label'     => esc_html__( 'Label Typography', 'wolmart-core' ),
					'scheme'    => Typography::TYPOGRAPHY_1,
					'selector'  => '.elementor-element-{{ID}} .products-view-dropdown>a',
					'condition' => array(
						'viewed_mode' => 'yes',
					),
				)
			);

			$this->start_controls_tabs( 'view_label_color_tabs', array( 'condition' => array( 'viewed_mode' => 'yes' ) ) );

				$this->start_controls_tab(
					'view_label_color_normal_tab',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'view_label_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .products-view-dropdown>a' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'view_label_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .products-view-dropdown>a' => 'background-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'view_label_color_hover_tab',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'view_label_color_hover',
						array(
							'label'     => esc_html__( 'Hover Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .products-view-dropdown>a:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'view_label_bg_color_hover',
						array(
							'label'     => esc_html__( 'Background Hover Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .products-view-dropdown>a:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		wolmart_elementor_loadmore_button_controls( $this, 'layout_type' );

	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-products.php';
	}

	protected function content_template() {}
}
