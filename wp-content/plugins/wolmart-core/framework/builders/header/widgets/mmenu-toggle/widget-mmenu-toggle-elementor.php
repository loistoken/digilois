<?php
/**
 * Wolmart Header Elementor Mobile Menu Toggle
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Wolmart_Header_Mmenu_Toggle_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_header_mmenu_toggle';
	}

	public function get_title() {
		return esc_html__( 'Mobile Menu Toggle', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon w-icon-hamburger';
	}

	public function get_categories() {
		return array( 'wolmart_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'wolmart', 'toggle', 'menu', 'mobile', 'button' );
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
			'section_toggle_content',
			array(
				'label' => esc_html__( 'Mobile Menu Toggle', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'icon',
				array(
					'label'   => esc_html__( 'Icon', 'wolmart-core' ),
					'type'    => Controls_Manager::ICONS,
					'default' => array(
						'value'   => 'w-icon-hamburger',
						'library' => 'wolmart-icons',
					),
				)
			);

			$this->add_responsive_control(
				'icon_size',
				array(
					'label'      => esc_html__( 'Icon Size', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .mobile-menu-toggle i' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style',
			array(
				'label' => esc_html__( 'Mobile Menu Toggle', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'toggle_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .mobile-menu-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'toggle_border',
				array(
					'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .mobile-menu-toggle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'toggle_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'elementor' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .mobile-menu-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_toggle_color' );
				$this->start_controls_tab(
					'tab_toggle_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'toggle_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .mobile-menu-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .mobile-menu-toggle' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .mobile-menu-toggle' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_toggle_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'toggle_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .mobile-menu-toggle:hover' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_hover_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .mobile-menu-toggle:hover' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_hover_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .mobile-menu-toggle:hover' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$atts     = array(
			'icon_class' => $settings['icon']['value'],
		);
		require __DIR__ . '/render-mmenu-toggle-elementor.php';
	}
}
