<?php
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

/**
 * Register elementor layout controls for slider.
 */

function wolmart_elementor_slider_layout_controls( $self, $condition_key ) {

	$self->add_control(
		'slider_vertical_align',
		array(
			'label'     => esc_html__( 'Vertical Align', 'wolmart-core' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => array(
				'top'         => array(
					'title' => esc_html__( 'Top', 'wolmart-core' ),
					'icon'  => 'eicon-v-align-top',
				),
				'middle'      => array(
					'title' => esc_html__( 'Middle', 'wolmart-core' ),
					'icon'  => 'eicon-v-align-middle',
				),
				'bottom'      => array(
					'title' => esc_html__( 'Bottom', 'wolmart-core' ),
					'icon'  => 'eicon-v-align-bottom',
				),
				'same-height' => array(
					'title' => esc_html__( 'Stretch', 'wolmart-core' ),
					'icon'  => 'eicon-v-align-stretch',
				),
			),
			'condition' => array(
				$condition_key => 'slider',
			),
		)
	);
}

/**
 * Register elementor style controls for slider.
 */

function wolmart_elementor_slider_style_controls( $self, $condition_key = '' ) {

	if ( empty( $condition_key ) ) {
		$self->start_controls_section(
			'slider_style',
			array(
				'label' => esc_html__( 'Slider', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
	} else {
		$self->start_controls_section(
			'slider_style',
			array(
				'label'     => esc_html__( 'Slider', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					$condition_key => 'slider',
				),
			)
		);
	}
		$self->add_control(
			'style_heading_slider_options',
			array(
				'label' => esc_html__( 'Options', 'wolmart-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$self->add_control(
			'slide_effect',
			array(
				'label'   => esc_html__( 'Slide Effect', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => array(
					'slide' => esc_html__( 'Slide', 'wolmart-core' ),
					'fade'  => esc_html__( 'Fade', 'wolmart-core' ),
				),
			)
		);

		$self->add_control(
			'loop',
			array(
				'label' => esc_html__( 'Enable Loop', 'wolmart-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		// $self->add_control(
		// 	'fullheight',
		// 	array(
		// 		'type'  => Controls_Manager::SWITCHER,
		// 		'label' => esc_html__( 'Full Height', 'wolmart-core' ),
		// 	)
		// );

		$self->add_control(
			'autoplay',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Autoplay', 'wolmart-core' ),
				'condition' => array(
					'loop' => 'yes',
				),
			)
		);

		$self->add_control(
			'autoplay_timeout',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Autoplay Timeout', 'wolmart-core' ),
				'default'   => 5000,
				'condition' => array(
					'autoplay' => 'yes',
					'loop'     => 'yes',
				),
			)
		);

		$self->add_control(
			'autoheight',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Auto Height', 'wolmart-core' ),
			)
		);

		$self->add_control(
			'style_heading_nav',
			array(
				'label'     => esc_html__( 'Navs', 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_control(
			'show_nav',
			array(
				'label' => esc_html__( 'Nav', 'wolmart-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$self->add_control(
			'nav_hide',
			array(
				'label'   => esc_html__( 'Nav Auto Hide', 'wolmart-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$self->add_control(
			'nav_type',
			array(
				'label'   => esc_html__( 'Nav Type', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simple',
				'options' => array(
					'simple' => esc_html__( 'Simple', 'wolmart-core' ),
					'circle' => esc_html__( 'Circle', 'wolmart-core' ),
					'full'   => esc_html__( 'Full', 'wolmart-core' ),
				),
			)
		);

		$self->add_control(
			'nav_pos',
			array(
				'label'     => esc_html__( 'Nav Position', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					'inner'  => esc_html__( 'Inner', 'wolmart-core' ),
					''       => esc_html__( 'Outer', 'wolmart-core' ),
					'top'    => esc_html__( 'Top', 'wolmart-core' ),
					'bottom' => esc_html__( 'Bottom', 'wolmart-core' ),
				),
				'condition' => array(
					'nav_type!' => 'full',
				),
			)
		);

		$self->add_responsive_control(
			'nav_h_position',
			array(
				'label'      => esc_html__( 'Nav Horizontal Position', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-button-prev' => ( is_rtl() ? 'right' : 'left' ) . ': {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .slider-button-next' => ( is_rtl() ? 'left' : 'right' ) . ': {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'nav_pos!' => array( 'top', 'bottom' ),
				),
			)
		);

		$self->add_responsive_control(
			'nav_top_h_position',
			array(
				'label'      => esc_html__( 'Nav Horizontal Position', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-button' => ( is_rtl() ? 'left' : 'right' ) . ': {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'nav_pos' => array( 'top', 'bottom' ),
				),
			)
		);

		$self->add_responsive_control(
			'nav_v_position_top',
			array(
				'label'      => esc_html__( 'Nav Vertical Position', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-button' => 'top: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'nav_pos' => 'top',
				),
			)
		);

		$self->add_responsive_control(
			'nav_v_position_bottom',
			array(
				'label'      => esc_html__( 'Nav Vertical Position', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-button' => 'bottom: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'nav_pos' => 'bottom',
				),
			)
		);

		$self->add_responsive_control(
			'nav_v_position',
			array(
				'label'      => esc_html__( 'Nav Vertical Position', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-button' => 'top: {{SIZE}}{{UNIT}}; transform: none;',
				),
				'condition'  => array(
					'nav_pos!' => array( 'top', 'bottom' ),
				),
			)
		);
		$self->add_responsive_control(
			'slider_nav_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Nav Size', 'wolmart-core' ),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 10,
						'max'  => 100,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button' => 'font-size: {{SIZE}}px',
				),
			)
		);

		$self->start_controls_tabs( 'tabs_nav_style' );

		$self->start_controls_tab(
			'tab_nav_normal',
			array(
				'label' => esc_html__( 'Normal', 'wolmart-core' ),
			)
		);

		$self->add_control(
			'nav_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'nav_box_shadow',
				'selector' => '.elementor-element-{{ID}} .slider-button',
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_nav_hover',
			array(
				'label' => esc_html__( 'Hover', 'wolmart-core' ),
			)
		);

		$self->add_control(
			'nav_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button:not(.disabled):hover' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_back_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button:not(.disabled):hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button:not(.disabled):hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'nav_box_shadow_hover',
				'selector' => '.elementor-element-{{ID}} .slider-button:not(.disabled):hover',
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_nav_disabled',
			array(
				'label' => esc_html__( 'Disabled', 'wolmart-core' ),
			)
		);

		$self->add_control(
			'nav_color_disabled',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button.disabled' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_back_color_disabled',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button.disabled' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_border_color_disabled',
			array(
				'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-button.disabled' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'nav_box_shadow_disabled',
				'selector' => '.elementor-element-{{ID}} .slider-button.disabled',
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_control(
			'style_heading_dot',
			array(
				'label'     => esc_html__( 'Dots', 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

	$show_dots_options = array(
		'label' => esc_html__( 'Dots', 'wolmart-core' ),
		'type'  => Controls_Manager::SWITCHER,
	);
	if ( 'use_as' == $condition_key ) {
		$show_dots_options['condition'] = array(
			'dots_type!' => 'thumb',
		);
	}
	$self->add_control( 'show_dots', $show_dots_options );

	$dot_default = '';
	if ( 'use_as' == $condition_key ) {
		$self->add_control(
			'dots_type',
			array(
				'label'   => esc_html__( 'Dots Type', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''      => esc_html__( 'Default', 'wolmart-core' ),
					'thumb' => esc_html__( 'Thumbnail', 'wolmart-core' ),
				),
			)
		);

		$self->add_control(
			'thumbs',
			array(
				'label'      => esc_html__( 'Add Thumbnails', 'wolmart-core' ),
				'type'       => Controls_Manager::GALLERY,
				'default'    => array(),
				'show_label' => false,
				'condition'  => array(
					'dots_type' => 'thumb',
				),
			)
		);

		$self->add_responsive_control(
			'dots_thumb_spacing',
			array(
				'label'      => esc_html__( 'Dots Spacing', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => '25',
				),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -200,
						'max'  => 200,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'condition'  => array(
					'dots_type' => 'thumb',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-thumb-dots .slider-pagination-bullet' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$dot_default = array( 'dots_type' => '' );
	}

		$self->add_control(
			'dots_skin',
			array(
				'label'     => esc_html__( 'Dots Skin', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''      => esc_html__( 'Default', 'wolmart-core' ),
					'white' => esc_html__( 'White', 'wolmart-core' ),
					'grey'  => esc_html__( 'Grey', 'wolmart-core' ),
					'dark'  => esc_html__( 'Dark', 'wolmart-core' ),
				),
				'condition' => $dot_default,
			)
		);

		$self->add_control(
			'dots_pos',
			array(
				'label'   => esc_html__( 'Dots Position', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'inner'  => esc_html__( 'Inner', 'wolmart-core' ),
					''       => esc_html__( 'Close', 'wolmart-core' ),
					'outer'  => esc_html__( 'Outer', 'wolmart-core' ),
					'custom' => esc_html__( 'Custom', 'wolmart-core' ),
				),
			)
		);

		$self->add_responsive_control(
			'dots_h_position',
			array(
				'label'      => esc_html__( 'Dot Vertical Position', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => '25',
				),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -200,
						'max'  => 200,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-pagination' => 'display: flex; position: absolute; bottom: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .slider-thumb-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'dots_pos' => 'custom',
				),
			)
		);

		$self->add_responsive_control(
			'dots_v_position',
			array(
				'label'      => esc_html__( 'Dot Horizontal Position', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => '%',
					'size' => '50',
				),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -200,
						'max'  => 200,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .slider-pagination' => 'display: flex; position: absolute; left: {{SIZE}}{{UNIT}}; transform: translateX(-50%);',
					'.elementor-element-{{ID}} .slider-thumb-dots' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'dots_pos' => 'custom',
				),
			)
		);

		$self->add_responsive_control(
			'slider_dots_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Dots Size', 'wolmart-core' ),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 5,
						'max'  => 100,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet.active' => 'width: calc({{SIZE}}{{UNIT}} * 2.25); height: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .slider-thumb-dots .slider-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .slider-pagination ~ .slider-thumb-dots' => 'margin-top: calc(-{{SIZE}}{{UNIT}} / 2)',
				),
			)
		);

		$self->start_controls_tabs( 'tabs_dot_style' );

		$self->start_controls_tab(
			'tab_dot_normal',
			array(
				'label'     => esc_html__( 'Normal', 'wolmart-core' ),
				'condition' => $dot_default,
			)
		);

		$self->add_control(
			'dot_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet' => 'background-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_control(
			'dot_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet' => 'border-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'dot_box_shadow',
				'selector'  => '.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet',
				'condition' => $dot_default,
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_dot_hover',
			array(
				'label'     => esc_html__( 'Hover', 'wolmart-core' ),
				'condition' => $dot_default,
			)
		);

		$self->add_control(
			'dot_back_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet:hover' => 'background-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_control(
			'dot_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet:hover' => 'border-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'dot_box_shadow_hover',
				'selector'  => '.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet:hover',
				'condition' => $dot_default,
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_dot_active',
			array(
				'label'     => esc_html__( 'Active', 'wolmart-core' ),
				'condition' => $dot_default,
			)
		);

		$self->add_control(
			'dot_back_color_active',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet.active' => 'background-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_control(
			'dot_border_color_active',
			array(
				'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet.active' => 'border-color: {{VALUE}};',
				),
				'condition' => $dot_default,
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'dot_box_shadow_active',
				'selector'  => '.elementor-element-{{ID}} .slider-pagination .slider-pagination-bullet.active',
				'condition' => $dot_default,
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

	$self->end_controls_section();
}

/**
 * Elementor content-template for slider.
 */
function wolmart_elementor_slider_template() {

	wp_enqueue_script( 'swiper' );
	?>
	var breakpoints = <?php echo json_encode( wolmart_get_breakpoints() ); ?>;
	var extra_options = {};

	extra_class += ' slider-wrapper';

	// Layout
	if ( 'lg' == settings.col_sp || 'xs' == settings.col_sp || 'sm' == settings.col_sp || 'no' == settings.col_sp ) {
		extra_class += ' gutter-' + settings.col_sp;
	}

	var col_cnt = wolmart_get_responsive_cols({
		xl: settings.col_cnt_xl,
		lg: settings.col_cnt,
		md: settings.col_cnt_tablet,
		sm: settings.col_cnt_mobile,
		min: settings.col_cnt_min,
	});
	extra_class += ' ' + wolmart_get_col_class( col_cnt );

	// Nav & Dot

	var statusClass = '';

	if ( 'full' == settings.nav_type ) {
		statusClass += ' slider-nav-full';
	} else {
		if ( 'circle' == settings.nav_type ) {
			statusClass += ' slider-nav-circle';
		}
		if ( 'top' == settings.nav_pos ) {
			statusClass += ' slider-nav-top';
		} else if ( 'bottom' == settings.nav_pos ) {
			statusClass += ' slider-nav-bottom';
		} else if ( 'inner' != settings.nav_pos ) {
			statusClass += ' slider-nav-outer';
		}
	}
	if ( 'yes' == settings.nav_hide ) {
		statusClass += ' slider-nav-fade';
	}
	if ( settings.dots_skin ) {
		statusClass += ' slider-dots-' + settings.dots_skin;
	}
	if ( 'inner' == settings.dots_pos ) {
		statusClass += ' slider-dots-inner';
	}
	if ( 'outer' == settings.dots_pos ) {
		statusClass += ' slider-dots-outer';
	}
	if ( 'yes' == settings.fullheight ) {
		statusClass += ' slider-full-height';
	}
	if ( 'yes' == settings.box_shadow_slider ) {
		statusClass += ' slider-shadow';
	}

	if ( 'top' == settings.slider_vertical_align ||
		'middle' == settings.slider_vertical_align ||
		'bottom' == settings.slider_vertical_align ||
		'same-height' == settings.slider_vertical_align ) {
		statusClass += ' slider-' + settings.slider_vertical_align;
	}

	// Options
	if ( settings.slide_effect ) {
		extra_options['effect'] = settings.slide_effect;
	}

	extra_options['navigation'] = 'yes' == settings.show_nav;
	extra_options['pagination'] = 'yes' == settings.show_dots;
	if ( 'no' !== settings.col_sp ) {
		if ( 'sm' == settings.col_sp ) {
			extra_options['spaceBetween'] = 10;
		}
		else if ( 'lg' == settings.col_sp ) {
			extra_options['spaceBetween'] = 30;
		}
		else if ( 'xs' == settings.col_sp ) {
			extra_options['spaceBetween'] = 2;
		}
		else {
			extra_options['spaceBetween'] = 20;
		}
	}
	if ( 'yes' == settings.autoplay ) {
		extra_options['autoplay'] = true;
		extra_options['autoplayHoverPause'] = true;
		extra_options['loop'] = true;
	}
	if ( 5000 != settings.autoplay_timeout ) {
		extra_options['autoplayTimeout'] = settings.autoplay_timeout;
	}
	if ( 'yes' == settings.autoheight) {
		extra_options['autoHeight'] = true;
	}
	if ( 'yes' == settings.autoheight) {
		extra_options['autoHeight'] = true;
	}

	if ( 'thumb' == settings.dots_type ) {
		extra_options['dotsContainer'] = 'preview';
	}

	var responsive = {};
	for ( var w in col_cnt ) {
		responsive[ breakpoints[ w ] ] = {
			slidesPerView: col_cnt[w]
		}
	}
	extra_options['statusClass'] = statusClass;

	if ( col_cnt.xl ) {
		extra_options['slidesPerView'] = col_cnt.xl;
	} else if ( col_cnt.lg ) {
		extra_options['slidesPerView'] = col_cnt.lg;
	}
	extra_options.breakpoints = responsive;

	extra_attrs += ' data-slider-options="' + JSON.stringify( extra_options ).replaceAll('"', '\'') + '"';
	<?php
}
