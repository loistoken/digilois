<?php
/**
 * Wolmart Header Elementor Vertical Divider
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Wolmart_Header_V_Divider_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_header_v_divider';
	}

	public function get_title() {
		return esc_html__( 'Vertical Divider', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-h-align-stretch';
	}

	public function get_categories() {
		return array( 'wolmart_header_widget' );
	}

	public function get_keywords() {
		return array( 'wolmart', 'header', 'divider', 'spacing', 'vertical', 'line' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_divider_style',
			array(
				'label' => esc_html__( 'Vertical Divider', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'divider_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .divider' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'divider_height',
				array(
					'label'      => esc_html__( 'Height', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .divider' => 'height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'divider_width',
				array(
					'label'      => esc_html__( 'Width', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .divider' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		require __DIR__ . '/render-v-divider-elementor.php';
	}
}
