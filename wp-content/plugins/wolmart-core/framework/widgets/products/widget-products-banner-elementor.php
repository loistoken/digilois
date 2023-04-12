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
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Wolmart_Products_Banner_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_products_banner';
	}

	public function get_title() {
		return esc_html__( 'Banner + Products', 'wolmart-core' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce', 'banner' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-products';
	}

	protected function register_controls() {

		wolmart_elementor_banner_controls( $this, 'insert_number' );

		wolmart_elementor_products_layout_controls( $this, 'custom_layouts' );

		wolmart_elementor_products_select_controls( $this );

		wolmart_elementor_product_type_controls( $this );

		wolmart_elementor_slider_style_controls( $this, 'layout_type' );

		// wolmart_elementor_product_style_controls( $this );
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		require __DIR__ . '/render-products-banner-elementor.php';
	}

	protected function content_template() {}
}
