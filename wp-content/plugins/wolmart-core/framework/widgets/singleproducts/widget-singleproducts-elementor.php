<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Single Product Widget
 *
 * Wolmart Widget to display products.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;

class Wolmart_Singleproducts_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_single_product';
	}

	public function get_title() {
		return esc_html__( 'Single Product', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-single-product';
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'product', 'flipbook', 'lookbook', 'carousel', 'slider', 'shop', 'woocommerce' );
	}

	public function get_style_depends() {
		return array();
	}

	public function get_script_depends() {
		$depends = array();
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		wolmart_elementor_products_select_controls( $this );

		$this->start_controls_section(
			'section_single_product',
			array(
				'label' => esc_html__( 'Single Product', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'sp_title_tag',
				array(
					'label'   => esc_html__( 'Title Tag', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
					),
					'default' => 'h2',
				)
			);

			$this->add_control(
				'sp_gallery_type',
				array(
					'label'   => esc_html__( 'Gallery Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''           => esc_html__( 'Default', 'wolmart-core' ),
						'vertical'   => esc_html__( 'Vertical', 'wolmart-core' ),
						'horizontal' => esc_html__( 'Horizontal', 'wolmart-core' ),
						'grid'       => esc_html__( 'Grid Images', 'wolmart-core' ),
						'masonry'    => esc_html__( 'Masonry', 'wolmart-core' ),
						'gallery'    => esc_html__( 'Gallery', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'sp_vertical',
				array(
					'label' => esc_html__( 'Show Vertical', 'wolmart-core' ),
					'type'  => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'sp_show_info',
				array(
					'type'     => Controls_Manager::SELECT2,
					'label'    => esc_html__( 'Show Information', 'wolmart-core' ),
					'multiple' => true,
					'default'  => array( 'gallery', 'title', 'meta', 'price', 'rating', 'excerpt', 'addtocart_form', 'share', 'wishlist', 'compare', 'divider' ),
					'options'  => array(
						'gallery'        => esc_html__( 'Gallery', 'wolmart-core' ),
						'title'          => esc_html__( 'Title', 'wolmart-core' ),
						'meta'           => esc_html__( 'Meta', 'wolmart-core' ),
						'price'          => esc_html__( 'Price', 'wolmart-core' ),
						'rating'         => esc_html__( 'Rating', 'wolmart-core' ),
						'excerpt'        => esc_html__( 'Description', 'wolmart-core' ),
						'addtocart_form' => esc_html__( 'Add To Cart Form', 'wolmart-core' ),
						'divider'        => esc_html__( 'Divider In Cart Form', 'wolmart-core' ),
						'share'          => esc_html__( 'Share', 'wolmart-core' ),
						'wishlist'       => esc_html__( 'Wishlist', 'wolmart-core' ),
						'compare'        => esc_html__( 'Compare', 'wolmart-core' ),
					),
				)
			);

			$this->add_responsive_control(
				'sp_col_cnt',
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
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_cnt_xl',
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
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_cnt_min',
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
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_sp',
				array(
					'label'     => esc_html__( 'Spacing', 'wolmart-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'md',
					'options'   => array(
						'no' => esc_html__( 'No space', 'wolmart-core' ),
						'xs' => esc_html__( 'Extra Small', 'wolmart-core' ),
						'sm' => esc_html__( 'Small', 'wolmart-core' ),
						'md' => esc_html__( 'Medium', 'wolmart-core' ),
						'lg' => esc_html__( 'Large', 'wolmart-core' ),
					),
					'condition' => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

		$this->end_controls_section();

		wolmart_elementor_single_product_style_controls( $this );

		wolmart_elementor_slider_style_controls(
			$this,
			'',
			array(
				'show_dots' => true,
				'show_nav'  => true,
			)
		);
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

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-singleproducts.php';
	}

	protected function content_template() {}
}
