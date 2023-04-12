<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Countdown Widget
 *
 * Wolmart Widget to display countdown.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

class Wolmart_Countdown_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_countdown';
	}

	public function get_title() {
		return esc_html__( 'Countdown', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-countdown';
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'countdown', 'counter', 'timer' );
	}

	public function get_script_depends() {
		return array( 'jquery-countdown' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_countdown',
			array(
				'label' => esc_html__( 'Countdown', 'wolmart-core' ),
			)
		);
		$this->add_control(
			'align',
			array(
				'label'     => esc_html__( 'Alignment', 'wolmart-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'flex-start',
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
					'.elementor-element-{{ID}} .countdown-container' => 'justify-content: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'type',
			array(
				'label'   => esc_html__( 'Type', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'block',
				'options' => array(
					'block'  => esc_html__( 'Block', 'wolmart-core' ),
					'inline' => esc_html__( 'Inline', 'wolmart-core' ),
				),
			)
		);
		$this->add_control(
			'date',
			array(
				'label'   => esc_html__( 'Target Date', 'wolmart-core' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => '',
			)
		);
		$this->add_control(
			'timezone',
			array(
				'label'   => esc_html__( 'Timezone', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''              => esc_html__( 'WordPress Defined Timezone', 'wolmart-core' ),
					'user_timezone' => esc_html__( 'User System Timezone', 'wolmart-core' ),
				),
			)
		);
		$this->add_control(
			'label',
			array(
				'label'     => esc_html__( 'Label', 'wolmart-core' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Offer Ends In',
				'condition' => array(
					'type' => 'inline',
				),
			)
		);
		$this->add_control(
			'label_type',
			array(
				'label'     => esc_html__( 'Unit Type', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''      => esc_html__( 'Full', 'wolmart-core' ),
					'short' => esc_html__( 'Short', 'wolmart-core' ),
				),
				'condition' => array(
					'type' => 'block',
				),
			)
		);
		$this->add_control(
			'label_pos',
			array(
				'label'     => esc_html__( 'Unit Position', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''       => esc_html__( 'Inner', 'wolmart-core' ),
					'outer'  => esc_html__( 'Outer', 'wolmart-core' ),
					'custom' => esc_html__( 'Custom', 'wolmart-core' ),
				),
				'condition' => array(
					'type' => 'block',
				),
			)
		);

		$this->add_responsive_control(
			'label_dimension',
			array(
				'label'      => esc_html__( 'Label Position', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -50,
						'max'  => 50,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .countdown .countdown-period' => 'bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'label_pos' => 'custom',
				),
			)
		);

		$this->add_control(
			'date_format',
			array(
				'label'    => esc_html__( 'Units', 'wolmart-core' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'default'  => array(
					'D',
					'H',
					'M',
					'S',
				),
				'options'  => array(
					'Y' => esc_html__( 'Year', 'wolmart-core' ),
					'O' => esc_html__( 'Month', 'wolmart-core' ),
					'W' => esc_html__( 'Week', 'wolmart-core' ),
					'D' => esc_html__( 'Day', 'wolmart-core' ),
					'H' => esc_html__( 'Hour', 'wolmart-core' ),
					'M' => esc_html__( 'Minute', 'wolmart-core' ),
					'S' => esc_html__( 'Second', 'wolmart-core' ),
				),
			)
		);
		$this->add_control(
			'hide_split',
			array(
				'label'     => esc_html__( 'Hide Spliter', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'type' => 'block',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_dimension',
			array(
				'label' => esc_html__( 'Dimension', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'      => esc_html__( 'Item Padding', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .countdown-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'item_spacing',
			array(
				'label'     => esc_html__( 'Item Spacing (px)', 'wolmart-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '20',
				'selectors' => array(
					'.elementor-element-{{ID}} .countdown-section:not(:last-child)' => 'margin-right: {{VALUE}}px;',
					'.elementor-element-{{ID}} .countdown-section:not(:last-child):after' => 'margin-left: calc({{SIZE}}px / 2 - 2px);',
				),
			)
		);

		$this->add_responsive_control(
			'label_margin',
			array(
				'label'      => esc_html__( 'Label Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .countdown-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'type' => 'inline',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_typography',
			array(
				'label' => esc_html__( 'Typography', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'countdown_amount',
				'label'    => esc_html__( 'Amount', 'wolmart-core' ),
				'selector' => '.elementor-element-{{ID}} .countdown-container .countdown-amount',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'countdown_label',
				'label'    => esc_html__( 'Unit, Label', 'wolmart-core' ),
				'selector' => '.elementor-element-{{ID}} .countdown-period, .elementor-element-{{ID}} .countdown-label',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_color',
			array(
				'label' => esc_html__( 'Color', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'countdown_section_color',
			array(
				'label'     => esc_html__( 'Section Background', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .countdown-section' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'countdown_amount_color',
			array(
				'label'     => esc_html__( 'Amount', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .countdown-amount' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'countdown_label_color',
			array(
				'label'     => esc_html__( 'Unit, Label', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .countdown-period' => 'color: {{VALUE}};',
					'.elementor-element-{{ID}} .countdown-label'  => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'countdown_separator_color',
			array(
				'label'     => esc_html__( 'Seperator', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .countdown-section:after' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_border',
			array(
				'label' => esc_html__( 'Border', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'border',
				'selector' => '.elementor-element-{{ID}} .countdown-section',
			)
		);

		$this->add_control(
			'border-radius',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Border-radius', 'wolmart-core' ),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .countdown-section' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-countdown-elementor.php';
	}
}
