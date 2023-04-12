<?php
/**
 * Wolmart Elementor Single Product Linked Products Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;

class Wolmart_Single_Product_Linked_Products_Elementor_Widget extends Wolmart_Products_Elementor_Widget {

	public function get_name() {
		return 'wolmart_sproduct_linked_products';
	}

	public function get_title() {
		return esc_html__( 'Linked Products', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-product-related';
	}

	public function get_categories() {
		return array( 'wolmart_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'linked_products' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {
		parent::register_controls();

		$this->remove_control( 'ids' );
		$this->remove_control( 'categories' );

		$this->update_control(
			'status',
			array(
				'label'   => esc_html__( 'Product Status', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'related',
				'options' => array(
					'related' => esc_html__( 'Related Products', 'wolmart-core' ),
					'upsell'  => esc_html__( 'Upsell Products', 'wolmart-core' ),
				),
			)
		);
	}

	protected function render() {
		if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {
			parent::render();
			do_action( 'wolmart_single_product_builder_unset_product' );
		}
	}
}
