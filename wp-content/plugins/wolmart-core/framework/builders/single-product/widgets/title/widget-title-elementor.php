<?php
/**
 * Wolmart Elementor Single Product Title Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;

class Wolmart_Single_Product_Title_Elementor_Widget extends Wolmart_Heading_Elementor_Widget {

	public function get_name() {
		return 'wolmart_sproduct_title';
	}

	public function get_title() {
		return esc_html__( 'Product Title', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-product-title';
	}

	public function get_categories() {
		return array( 'wolmart_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'name', 'title' );
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

		$this->remove_control( 'title' );
	}

	protected function render() {
		if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {
			global $product;

			$atts          = $this->get_settings_for_display();
			$atts['self']  = $this;
			$atts['title'] = $product->get_name();
			$atts['class'] = 'product_title entry-title';

			$this->add_inline_editing_attributes( 'link_label' );

			require wolmart_core_path( '/widgets/heading/render-heading-elementor.php' );

			do_action( 'wolmart_single_product_builder_unset_product' );
		}
	}
}
