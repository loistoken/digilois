<?php
/**
 * Wolmart Elementor Single Product Ratings Widget
 */
defined( 'ABSPATH' ) || die;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


class Wolmart_Single_Product_Rating_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_sproduct_rating';
	}

	public function get_title() {
		return esc_html__( 'Product Rating', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-product-rating';
	}

	public function get_categories() {
		return array( 'wolmart_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'rating', 'reviews' );
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
			'section_product_rating',
			array(
				'label' => esc_html__( 'Style', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'sp_type',
				array(
					'label'   => esc_html__( 'Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'star',
					'options' => array(
						'star'   => esc_html__( 'Star', 'wolmart-core' ),
						'number' => esc_html__( 'Number', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'sp_align',
				array(
					'label'     => esc_html__( 'Align', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'flex-start' => array(
							'title' => esc_html__( 'Left', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => esc_html__( 'Center', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Right', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .woocommerce-product-rating' => 'justify-content: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'sp_number_typo',
					'label'     => esc_html__( 'Typography', 'wolmart-core' ),
					'selector'  => '.elementor-element-{{ID}} .woocommerce-product-rating',
					'condition' => array(
						'sp_type' => 'number',
					),
				)
			);

			$this->add_control(
				'stars_text_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .woocommerce-product-rating' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_type' => 'number',
					),
				)
			);

			$this->add_control(
				'heading_star_style',
				array(
					'label'     => esc_html__( 'Star', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_responsive_control(
				'icon_size',
				array(
					'label'     => esc_html__( 'Size', 'wolmart-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_responsive_control(
				'icon_space',
				array(
					'label'     => esc_html__( 'Spacing', 'wolmart-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 50,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating' => 'letter-spacing: {{SIZE}}{{UNIT}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_control(
				'stars_unmarked_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating span:after' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_control(
				'stars_color',
				array(
					'label'     => esc_html__( 'Black Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating:before' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_control(
				'sp_reviews',
				array(
					'label'     => esc_html__( 'Reviews', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'wolmart-core' ),
					'label_on'  => esc_html__( 'Show', 'wolmart-core' ),
					'default'   => 'yes',
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'sp_review_typo',
					'label'     => esc_html__( 'Typography', 'wolmart-core' ),
					'selector'  => '.elementor-element-{{ID}} .woocommerce-review-link',
					'condition' => array(
						'sp_reviews' => 'yes',
					),
				)
			);

			$this->add_control(
				'sp_review_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .woocommerce-review-link' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_reviews' => 'yes',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {

			$settings = $this->get_settings_for_display();

			if ( 'number' == $settings['sp_type'] ) {
				add_filter( 'wolmart_single_product_rating_show_number', '__return_true' );
			}
			if ( '' == $settings['sp_reviews'] ) {
				add_filter( 'wolmart_single_product_show_review', '__return_false' );
			}

			woocommerce_template_single_rating();

			if ( 'number' == $settings['sp_type'] ) {
				remove_filter( 'wolmart_single_product_rating_show_number', '__return_true' );
			}
			if ( '' == $settings['sp_reviews'] ) {
				remove_filter( 'wolmart_single_product_show_review', '__return_false' );
			}

			do_action( 'wolmart_single_product_builder_unset_product' );
		}
	}
}
