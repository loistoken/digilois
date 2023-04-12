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
use Elementor\Wolmart_Controls_Manager;

class Wolmart_Products_Single_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_products_single';
	}

	public function get_title() {
		return esc_html__( 'Products + Single', 'wolmart-core' );
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

		wolmart_elementor_products_layout_controls( $this, 'custom_layouts' );

		$this->start_controls_section(
			'section_single_product',
			array(
				'label' => esc_html__( 'Single Product', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'sp_id',
				array(
					'label'       => esc_html__( 'Select a Product', 'wolmart-core' ),
					'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
					'options'     => 'product',
					'label_block' => true,
				)
			);

			$this->add_control(
				'sp_insert',
				array(
					'label'   => esc_html__( 'Single Product Index', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '1',
					'options' => array(
						'1'    => '1',
						'2'    => '2',
						'3'    => '3',
						'4'    => '4',
						'5'    => '5',
						'6'    => '6',
						'7'    => '7',
						'8'    => '8',
						'9'    => '9',
						'last' => esc_html__( 'At last', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'sp_title_tag',
				array(
					'label'   => esc_html__( 'Title Tag', 'elementor' ),
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
				'sp_sales_type',
				array(
					'label'   => esc_html__( 'Sales Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''        => esc_html__( 'In Summary', 'wolmart-core' ),
						'gallery' => esc_html__( 'In Gallery', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'sp_vertical',
				array(
					'label'   => esc_html__( 'Show Vertical', 'wolmart-core' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				)
			);

		$this->add_control(
			'sp_show_in_box',
			array(
				'label' => esc_html__( 'Show In Box', 'wolmart-core' ),
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

		wolmart_elementor_products_select_controls( $this );

		wolmart_elementor_product_type_controls( $this );

		wolmart_elementor_single_product_style_controls( $this );

		wolmart_elementor_slider_style_controls( $this, 'layout_type' );

		// wolmart_elementor_product_style_controls( $this );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-products-single-elementor.php';
	}

	protected function content_template() {}
}
