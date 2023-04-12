<?php
/**
 * Wolmart Elementor Single Product Data_tab Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

class Wolmart_Single_Product_FBT_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_sproduct_fbt';
	}

	public function get_title() {
		return esc_html__( 'Product Frequently Bought Together', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-product-upsell';
	}

	public function get_categories() {
		return array( 'wolmart_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'frequently', 'product', 'woocommerce', 'shop', 'bought', 'together' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
			//          $depends[] = 'wolmart-product-frequently-bought-together-js';
		}
		return $depends;
	}

	public function before_render() {
		// Add `elementor-widget-theme-post-content` class to avoid conflicts that figure gets zero margin.
		$this->add_render_attribute(
			array(
				'_wrapper' => array(
					'class' => 'elementor-widget-theme-post-content',
				),
			)
		);

		parent::before_render();
	}


	protected function register_controls() {

		$this->start_controls_section(
			'section_product_fbt',
			array(
				'label' => esc_html__( 'Content', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'sp_fbt_title',
				array(
					'type'        => Controls_Manager::TEXTAREA,
					'label'       => esc_html__( 'Tab title', 'wolmart-core' ),
					'rows'        => 3,
					'placeholder' => esc_html__( 'Frequently Bought Together', 'wolmart-core' ),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_fbt_typo',
					'label'    => esc_html__( 'Title Typography', 'wolmart-core' ),
					'selector' => '.elementor-element-{{ID}} .product-fbt .title',
				)
			);

			$this->add_control(
				'sp_fbt_title_color',
				array(
					'label'     => esc_html__( 'Title Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'seperator' => 'after',
					'selectors' => array(
						'.elementor-element-{{ID}} .product-fbt .title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'sp_fbt_content_dimen',
				array(
					'label'      => esc_html__( 'Content Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-fbt .products'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}

	public function get_tab_title( $title ) {
		$sp_title = $this->get_settings_for_display( 'sp_fbt_title' );
		if ( $sp_title ) {
			$title = $sp_title;
		}
		return $title;
	}

	protected function render() {

		if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {

			add_filter( 'wolmart_single_product_fbt_title', array( $this, 'get_tab_title' ), 20 );

			if ( class_exists( 'Wolmart_Product_Frequently_Bought_Together' ) ) {
				Wolmart_Product_Frequently_Bought_Together::get_instance()->wolmart_fbt_product();

			}
			remove_filter( 'wolmart_single_product_fbt_title', array( $this, 'get_tab_title' ), 20 );

			do_action( 'wolmart_single_product_builder_unset_product' );
		}
	}
}
