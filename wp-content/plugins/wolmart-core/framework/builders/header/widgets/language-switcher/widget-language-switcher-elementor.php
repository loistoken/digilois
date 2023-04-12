<?php
/**
 * Wolmart Header Elementor Language Switcher
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Wolmart_Header_Language_Switcher_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_header_language_switcher';
	}

	public function get_title() {
		return esc_html__( 'Language Switcher', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon fas fa-language';
	}

	public function get_categories() {
		return array( 'wolmart_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'switcher', 'language', 'wolmart', 'multi', 'translate' );
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
			'section_toggle_style',
			array(
				'label' => esc_html__( 'Switcher Toggle', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'toggle_typography',
					'selector' => '.elementor-element-{{ID}} .switcher .switcher-toggle',
				)
			);

			$this->add_responsive_control(
				'toggle_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .switcher .switcher-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'.elementor-element-{{ID}} .switcher .switcher-toggle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
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
						'.elementor-element-{{ID}} .switcher .switcher-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
							'.elementor-element-{{ID}} .switcher .switcher-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .switcher .switcher-toggle' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .switcher .switcher-toggle' => 'border-color: {{VALUE}};',
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
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_hover_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_hover_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dropdown_style',
			array(
				'label' => esc_html__( 'Dropdown Box', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'dropdown_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .switcher ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'dropdown_position',
				array(
					'label'      => esc_html__( 'Position', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .switcher ul' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'      => 'dropdown_border',
					'selector'  => '.elementor-element-{{ID}} .switcher ul',
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'dropdown_box_shadow',
					'selector' => '.elementor-element-{{ID}} .switcher ul',
				)
			);

			$this->add_control(
				'dropdown_bg',
				array(
					'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .switcher ul' => 'background: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_item_style',
			array(
				'label' => esc_html__( 'Sub item', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'item_typography',
					'selector' => '.elementor-element-{{ID}} .switcher ul a',
				)
			);

			$this->add_responsive_control(
				'item_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .switcher ul a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'item_margin',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .switcher ul a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'item_border',
				array(
					'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .switcher ul a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'itemr_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'elementor' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .switcher ul a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_item_color' );
				$this->start_controls_tab(
					'tab_item_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'item_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .switcher ul a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'item_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .switcher ul a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'item_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .switcher ul a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_item_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'item_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .switcher ul > li:hover a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'item_hover_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .switcher ul > li:hover a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'item_hover_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .switcher ul > li:hover a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		require __DIR__ . '/render-language-switcher-elementor.php';
	}
}
