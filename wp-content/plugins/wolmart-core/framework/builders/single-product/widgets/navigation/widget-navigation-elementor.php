<?php
/**
 * Wolmart Elementor Single Product Prev-Next Navigation Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;

class Wolmart_Single_Product_Navigation_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_sproduct_navigation';
	}

	public function get_title() {
		return esc_html__( 'Product Navigation', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-post-navigation';
	}

	public function get_categories() {
		return array( 'wolmart_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'navigation', 'prev', 'next' );
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
			'section_product_navigation',
			array(
				'label' => esc_html__( 'Style', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
						'.elementor-element-{{ID}} .product-navigation' => 'justify-content: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_typo',
					'label'    => esc_html__( 'Typography', 'wolmart-core' ),
					'selector' => '{{WRAPPER}} .product-nav span span',
				)
			);

			$this->add_control(
				'sp_size',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Icon Size', 'wolmart-core' ),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} i' => 'font-size: {{SIZE}}px',
					),
					'separator' => 'before',
				)
			);

			$this->add_control(
				'sp_prev_icon',
				array(
					'label'                  => esc_html__( 'Prev Icon', 'elementor' ),
					'type'                   => Controls_Manager::ICONS,
					'fa4compatibility'       => 'icon',
					'default'                => array(
						'value'   => 'w-icon-angle-left',
						'library' => '',
					),
					'recommended'            => array(
						'fa-solid'   => array(
							'chevron-down',
							'angle-down',
							'angle-double-down',
							'caret-down',
							'caret-square-down',
						),
						'fa-regular' => array(
							'caret-square-down',
						),
					),
					'exclude_inline_options' => array(
						'icon',
					),
					'includes'               => array( 'icon' ),
					'skin'                   => 'inline',
					'label_block'            => false,
				)
			);

			$this->add_control(
				'sp_next_icon',
				array(
					'label'                  => esc_html__( 'Next Icon', 'elementor' ),
					'type'                   => Controls_Manager::ICONS,
					'fa4compatibility'       => 'icon',
					'default'                => array(
						'value'   => 'w-icon-angle-right',
						'library' => '',
					),
					'recommended'            => array(
						'fa-solid'   => array(
							'chevron-down',
							'angle-down',
							'angle-double-down',
							'caret-down',
							'caret-square-down',
						),
						'fa-regular' => array(
							'caret-square-down',
						),
					),
					'exclude_inline_options' => array(
						'icon',
					),
					'skin'                   => 'inline',
					'label_block'            => false,
				)
			);

			$this->start_controls_tabs( 'sp_tabs' );
				$this->start_controls_tab(
					'sp_normal_tab',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'sp_i_color',
						array(
							'label'     => esc_html__( 'Icon Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} i' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'sp_hover_tab',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'sp_i_color_hover',
						array(
							'label'     => esc_html__( 'Icon Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} li:hover i' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function get_prev_icon() {
		return $this->prev_icon;
	}

	public function get_next_icon() {
		return $this->next_icon;
	}

	protected function render() {
		if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {

			$settings = $this->get_settings_for_display();

			$this->prev_icon = $settings['sp_prev_icon']['value'];
			$this->next_icon = $settings['sp_next_icon']['value'];

			add_filter( 'wolmart_check_single_next_prev_nav', '__return_true' );
			add_filter( 'wolmart_single_product_nav_prev_icon', array( $this, 'get_prev_icon' ) );
			add_filter( 'wolmart_single_product_nav_next_icon', array( $this, 'get_next_icon' ) );

			echo '<div class="product-navigation">' . wolmart_single_product_navigation() . '</div>';

			remove_filter( 'wolmart_check_single_next_prev_nav', '__return_true' );
			remove_filter( 'wolmart_single_product_nav_prev_icon', array( $this, 'get_prev_icon' ) );
			remove_filter( 'wolmart_single_product_nav_next_icon', array( $this, 'get_next_icon' ) );

			do_action( 'wolmart_single_product_builder_unset_product' );
		}
	}
}
