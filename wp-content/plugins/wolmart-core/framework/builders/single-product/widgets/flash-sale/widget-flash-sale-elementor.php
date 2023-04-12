<?php
/**
  * Wolmart Elementor Single Product Flash Sale Widget
  */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

class Wolmart_Single_Product_Flash_Sale_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_sproduct_flash_sale';
	}

	public function get_title() {
		return esc_html__( 'Product Flash Sale', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-countdown';
	}

	public function get_categories() {
		return array( 'wolmart_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'flash', 'sale', 'countdown' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
		}
			return $depends;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_product_flash_style',
			array(
				'label' => esc_html__( 'Style', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'sp_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-countdown-container' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'heading_end_style',
			array(
				'label'     => esc_html__( 'Label', 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sp_ends_typo',
				'selector' => '.elementor-element-{{ID}} .countdown-wrap"',
			)
		);

		$this->add_control(
			'sp_ends_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .countdown-wrap' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'heading_period_style',
			array(
				'label'     => esc_html__( 'Period', 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sp_amount_typo',
				'selector' => '.elementor-element-{{ID}} .countdown-amount',
			)
		);

		$this->add_control(
			'sp_amount_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .countdown-amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {

			global $product;

			if ( function_exists( 'wolmart_single_product_sale_countdown' ) ) {
				wolmart_single_product_sale_countdown();
			}

			do_action( 'wolmart_single_product_builder_unset_product' );
		}
	}
}
