<?php
/**
 * Wolmart Header Elementor Wishlist
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Wolmart_Header_Wishlist_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_header_wishlist';
	}

	public function get_title() {
		return esc_html__( 'Wishlist', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon w-icon-heart';
	}

	public function get_categories() {
		return array( 'wolmart_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'wolmart', 'wish', 'love', 'like', 'list' );
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
			'section_wishlist_content',
			array(
				'label' => esc_html__( 'Wishlist', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Wishlist Type', 'wolmart-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'inline',
					'options' => array(
						'block'  => array(
							'title' => esc_html__( 'Block', 'wolmart-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'inline' => array(
							'title' => esc_html__( 'Inline', 'wolmart-core' ),
							'icon'  => 'eicon-h-align-right',
						),
					),
				)
			);

			$this->add_control(
				'miniwishlist',
				array(
					'label'   => esc_html__( 'Mini Wish List', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''          => esc_html__( 'Do not show', 'wolmart-core' ),
						'dropdown'  => esc_html__( 'Dropdown', 'wolmart-core' ),
						'offcanvas' => esc_html__( 'Off-Canvas', 'wolmart-core' ),
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
					'label'       => esc_html__( 'Label', 'wolmart-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Wishlist', 'wolmart-core' ),
					'condition'   => array(
						'show_label' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_count',
				array(
					'label'     => esc_html__( 'Show Count', 'wolmart-core' ),
					'default'   => '',
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'show_icon' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_icon',
				array(
					'label'   => esc_html__( 'Show Icon', 'wolmart-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'     => esc_html__( 'Icon', 'wolmart-core' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => 'w-icon-heart',
						'library' => 'wolmart-icons',
					),
					'condition' => array(
						'show_icon' => 'yes',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wishlist_style',
			array(
				'label' => esc_html__( 'Wishlist', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'wishlist_typography',
					'selector' => '.elementor-element-{{ID}} .wishlist',
				)
			);

			$this->add_responsive_control(
				'wishlist_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .elementor-widget-container > .wishlist, .elementor-element-{{ID}} .wishlist-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'account_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .wishlist i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'account_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .block-type i + span' => 'margin-top: {{SIZE}}px;',
						'.elementor-element-{{ID}} .inline-type i + span' => 'margin-left: {{SIZE}}px;',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_account_color' );
				$this->start_controls_tab(
					'tab_account_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'account_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .wishlist' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_account_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'account_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .wishlist:hover' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'wishlist_count_heading',
				array(
					'label'     => esc_html__( 'Count', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wishlist_dropdown_style',
			array(
				'label' => esc_html__( 'Dropdown', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'dropdown_position',
				array(
					'label'       => esc_html__( 'Dropdown Position', 'wolmart-core' ),
					'description' => esc_html__( 'Left offset of dropdown', 'wolmart-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array( 'px', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .dropdown-box' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
					),
					'condition'   => array(
						'miniwishlist' => 'dropdown',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wishlist_badge_style',
			array(
				'label' => esc_html__( 'Badge', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'badge_size',
				array(
					'label'      => esc_html__( 'Badge Size', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .wish-count' => 'font-size: {{SIZE}}px;',
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
						'.elementor-element-{{ID}} .wish-count' => 'left: {{SIZE}}{{UNIT}};',
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
						'.elementor-element-{{ID}} .wish-count' => 'top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'badge_count_bg_color',
				array(
					'label'     => esc_html__( 'Count Background Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .wish-count' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'badge_count_color',
				array(
					'label'     => esc_html__( 'Count Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .wish-count' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$atts     = array(
			'type'         => $settings['type'],
			'show_label'   => 'yes' == $settings['show_label'],
			'show_count'   => 'yes' == $settings['show_count'],
			'show_icon'    => 'yes' == $settings['show_icon'],
			'label'        => isset( $settings['label'] ) && $settings['label'] ? $settings['label'] : esc_html__( 'Wishlist', 'wolmart-core' ),
			'icon'         => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : 'w-icon-heart',
			'miniwishlist' => $settings['miniwishlist'],
		);
		require __DIR__ . '/render-wishlist-elementor.php';
	}
}
