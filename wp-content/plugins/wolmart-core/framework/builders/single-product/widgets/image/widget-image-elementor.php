<?php
/**
 * Wolmart Elementor Single Product Image Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

class Wolmart_Single_Product_Image_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_sproduct_image';
	}

	public function get_title() {
		return esc_html__( 'Product Images', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-product-images';
	}

	public function get_categories() {
		return array( 'wolmart_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'image', 'thumbnail', 'gallery' );
	}

	public function get_script_depends() {
		$depends = array( 'swiper' );
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_product_gallery_content',
			array(
				'label' => esc_html__( 'Content', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'sp_type',
				array(
					'label'   => esc_html__( 'Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''           => esc_html__( 'Featured', 'wolmart-core' ),
						'horizontal' => esc_html__( 'Horizontal', 'wolmart-core' ),
						'vertical'   => esc_html__( 'Vertical', 'wolmart-core' ),
						'grid'       => esc_html__( 'Grid', 'wolmart-core' ),
						'masonry'    => esc_html__( 'Masonry', 'wolmart-core' ),
						'gallery'    => esc_html__( 'Gallery', 'wolmart-core' ),
					),
				)
			);

			$this->add_responsive_control(
				'col_cnt',
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
						'sp_type' => array( 'grid', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_cnt_xl',
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
						'sp_type' => array( 'grid', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_cnt_min',
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
						'sp_type' => array( 'grid', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_sp',
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
						'sp_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_gallery_style',
			array(
				'label' => esc_html__( 'Style', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'selector' => '.woocommerce .elementor-element-{{ID}} .woocommerce-product-gallery__image img',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.woocommerce .elementor-element-{{ID}} .woocommerce-product-gallery__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'heading_thumbs_style',
			array(
				'label'     => esc_html__( 'Thumbnails', 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'thumbs_border',
				'selector' => '.woocommerce .elementor-element-{{ID}} .product-thumb img',
			)
		);

		$this->add_responsive_control(
			'thumbs_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.woocommerce .elementor-element-{{ID}} .product-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'spacing_thumbs',
			array(
				'label'      => esc_html__( 'Spacing', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'.woocommerce .elementor-element-{{ID}} .product-thumb' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);
	}

	public function get_gallery_type() {
		return $this->get_settings_for_display( 'sp_type' );
	}

	public function extend_gallery_class( $classes ) {
		$settings              = $this->get_settings_for_display();
		$single_product_layout = $settings['sp_type'];
		$classes[]             = 'pg-custom';

		if ( 'grid' == $single_product_layout || 'masonry' == $single_product_layout ) {

			foreach ( $classes as $i => $class ) {
				if ( 'cols-sm-2' == $class ) {
					array_splice( $classes, $i, 1 );
				}
			}
			$classes[]        = wolmart_get_col_class( wolmart_elementor_grid_col_cnt( $settings ) );
			$grid_space_class = wolmart_get_grid_space_class( $settings );
			if ( $grid_space_class ) {
				$classes[] = $grid_space_class;
			}
		}

		return $classes;
	}

	public function extend_gallery_type_class( $class ) {
		$settings         = $this->get_settings_for_display();
		$class            = ' ' . wolmart_get_col_class( wolmart_elementor_grid_col_cnt( $settings ) );
		$grid_space_class = wolmart_get_grid_space_class( $settings );
		if ( $grid_space_class ) {
			$class .= ' ' . $grid_space_class;
		}
		return $class;
	}

	public function extend_gallery_type_attr( $attr ) {
		$settings              = $this->get_settings_for_display();
		$settings['show_nav']  = 'yes';
		$settings['show_dots'] = 'yes';
		$attr                 .= ' data-slider-options="' . esc_attr(
			json_encode(
				wolmart_get_slider_attrs( $settings, wolmart_elementor_grid_col_cnt( $settings ) )
			)
		) . '"';
		return $attr;
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

		if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {
			$sp_type = $this->get_settings_for_display( 'sp_type' );

			add_filter( 'wolmart_single_product_layout', array( $this, 'get_gallery_type' ), 99 );
			add_filter( 'wolmart_single_product_gallery_main_classes', array( $this, 'extend_gallery_class' ), 20 );
			if ( 'gallery' == $sp_type ) {
				add_filter( 'wolmart_single_product_gallery_type_class', array( $this, 'extend_gallery_type_class' ) );
				add_filter( 'wolmart_single_product_gallery_type_attr', array( $this, 'extend_gallery_type_attr' ) );
			}

			woocommerce_show_product_images();

			remove_filter( 'wolmart_single_product_layout', array( $this, 'get_gallery_type' ), 99 );
			remove_filter( 'wolmart_single_product_gallery_main_classes', array( $this, 'extend_gallery_class' ), 20 );
			if ( 'gallery' == $sp_type ) {
				remove_filter( 'wolmart_single_product_gallery_type_class', array( $this, 'extend_gallery_type_class' ) );
				remove_filter( 'wolmart_single_product_gallery_type_attr', array( $this, 'extend_gallery_type_attr' ) );
			}

			do_action( 'wolmart_single_product_builder_unset_product' );
		}
	}
}
