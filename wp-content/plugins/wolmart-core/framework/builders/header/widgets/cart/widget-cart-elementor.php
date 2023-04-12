<?php
/**
 * Wolmart Header Elementor Cart
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Wolmart_Header_Cart_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_header_cart';
	}

	public function get_title() {
		return esc_html__( 'Cart', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-cart-medium';
	}

	public function get_categories() {
		return array( 'wolmart_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'wolmart', 'cart', 'shop', 'mini', 'bag' );
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
			'section_cart_content',
			array(
				'label' => esc_html__( 'Cart', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'icon_type',
				array(
					'label'   => esc_html__( 'Cart Icon Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'badge',
					'options' => array(
						'badge' => esc_html__( 'Badge Type', 'wolmart-core' ),
						'label' => esc_html__( 'Label Type', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'     => esc_html__( 'Cart Icon', 'wolmart-core' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => 'w-icon-cart',
						'library' => 'wolmart-icons',
					),
					'condition' => array(
						'icon_type' => 'badge',
					),
				)
			);

			$this->add_control(
				'show_label',
				array(
					'label'   => esc_html__( 'Show Label', 'wolmart-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'label',
				array(
					'label'     => esc_html__( 'Cart Label', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => esc_html__( 'My Cart', 'wolmart-core' ),
					'condition' => array(
						'show_label' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_price',
				array(
					'label'   => esc_html__( 'Show Cart Total Price', 'wolmart-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'delimiter',
				array(
					'label'     => esc_html__( 'Delimiter', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '/',
					'condition' => array(
						'show_label' => 'yes',
						'show_price' => 'yes',
					),
				)
			);

			$this->add_control(
				'count_pfx',
				array(
					'label'     => esc_html__( 'Cart Count Prefix', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '(',
					'condition' => array(
						'icon_type' => 'label',
					),
				)
			);

			$this->add_control(
				'count_sfx',
				array(
					'label'     => esc_html__( 'Cart Count suffix', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 'items )',
					'condition' => array(
						'icon_type' => 'label',
					),
				)
			);

			$this->add_control(
				'cart_off_canvas',
				array(
					'label'     => esc_html__( 'Off Canvas', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'separator' => 'before',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cart_style',
			array(
				'label' => esc_html__( 'Cart Toggle', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'cart_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_cart_color' );
				$this->start_controls_tab(
					'tab_cart_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'cart_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .cart-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_cart_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'cart_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .cart-dropdown:hover .cart-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'cart_label_heading',
				array(
					'label'     => esc_html__( 'Cart Label', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cart_typography',
					'selector' => '.elementor-element-{{ID}} .cart-toggle, .elementor-element-{{ID}} .cart-count',
				)
			);

			$this->add_responsive_control(
				'cart_delimiter_space',
				array(
					'label'      => esc_html__( 'Delimiter Space (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-name-delimiter' => 'margin: 0 {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'cart_price_heading',
				array(
					'label'     => esc_html__( 'Cart Price', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cart_price_typography',
					'selector' => '.elementor-element-{{ID}} .cart-price',
				)
			);

			$this->add_responsive_control(
				'cart_price_margin',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'cart_icon_heading',
				array(
					'label'     => esc_html__( 'Cart Icon', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => array(
						'icon_type' => 'badge',
					),
				)
			);

			$this->add_responsive_control(
				'cart_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-dropdown .cart-toggle i' => 'font-size: {{SIZE}}px;',
					),
					'condition'  => array(
						'icon_type' => 'badge',
					),
				)
			);

			$this->add_responsive_control(
				'cart_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .block-type .cart-label + i' => 'margin-bottom: {{SIZE}}px;',
						'.elementor-element-{{ID}} .inline-type .cart-label + i' => 'margin-left: {{SIZE}}px;',
					),
					'condition'  => array(
						'icon_type' => 'badge',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cart_badge_style',
			array(
				'label'     => esc_html__( 'Badge', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'icon_type' => 'badge',
				),
			)
		);

			$this->add_responsive_control(
				'badge_size',
				array(
					'label'      => esc_html__( 'Badge Size', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'badge_h_position',
				array(
					'label'      => esc_html__( 'Horizontal Position', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'left: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'badge_v_position',
				array(
					'label'      => esc_html__( 'Vertical Position', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'badge_count_bg_color',
				array(
					'label'     => esc_html__( 'Count Background Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						'icon_type' => 'badge',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'badge_count_bd_color',
				array(
					'label'     => esc_html__( 'Count Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						'icon_type' => 'badge',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$atts     = array(
			'icon_type'       => $settings['icon_type'],
			'cart_off_canvas' => $settings['cart_off_canvas'],
			'title'           => $settings['show_label'],
			'label'           => $settings['label'],
			'price'           => $settings['show_price'],
			'delimiter'       => $settings['delimiter'],
			'pfx'             => $settings['count_pfx'],
			'sfx'             => $settings['count_sfx'],
			'icon'            => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : 'w-icon-cart',
		);
		require __DIR__ . '/render-cart-elementor.php';
	}
}
