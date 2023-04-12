<?php
/**
 * Wolmart Elementor Single Product Excerpt Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;

class Wolmart_Single_Product_Excerpt_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_sproduct_excerpt';
	}

	public function get_title() {
		return esc_html__( 'Product Excerpt', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-post-excerpt';
	}

	public function get_categories() {
		return array( 'wolmart_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'excerpt' );
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
			'section_product_excerpt',
			array(
				'label' => esc_html__( 'Style', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_typo',
					'label'    => esc_html__( 'Typography', 'wolmart-core' ),
					'selector' => '.elementor-element-{{ID}} p',
				)
			);

			$this->add_control(
				'sp_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} p' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'sp_align',
				array(
					'label'     => esc_html__( 'Align', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'    => array(
							'title' => esc_html__( 'Left', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => esc_html__( 'Center', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'   => array(
							'title' => esc_html__( 'Right', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-right',
						),
						'justify' => array(
							'title' => esc_html__( 'Justify', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} p' => 'text-align: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {
			woocommerce_template_single_excerpt();
			do_action( 'wolmart_single_product_builder_unset_product' );
		}
	}
}
