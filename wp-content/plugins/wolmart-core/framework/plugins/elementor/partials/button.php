<?php
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

/**
 * Register elementor layout controls for button.
 */
function wolmart_elementor_button_layout_controls( $self, $condition_key = '', $condition_value = 'yes', $name_prefix = '' ) {

	$left  = is_rtl() ? 'right' : 'left';
	$right = 'left' == $left ? 'right' : 'left';

	$self->add_control(
		$name_prefix . 'button_type',
		array(
			'label'     => esc_html__( 'Type', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				''            => esc_html__( 'Default', 'wolmart-core' ),
				'btn-solid'   => esc_html__( 'Solid', 'wolmart-core' ),
				'btn-outline' => esc_html__( 'Outline', 'wolmart-core' ),
				'btn-link'    => esc_html__( 'Link', 'wolmart-core' ),
			),
			'condition' => $condition_key ? array( $condition_key => $condition_value ) : '',
		)
	);

	$self->add_control(
		$name_prefix . 'button_size',
		array(
			'label'     => esc_html__( 'Size', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				'btn-sm' => esc_html__( 'Small', 'wolmart-core' ),
				'btn-md' => esc_html__( 'Medium', 'wolmart-core' ),
				''       => esc_html__( 'Normal', 'wolmart-core' ),
				'btn-lg' => esc_html__( 'Large', 'wolmart-core' ),
			),
			'condition' => $condition_key ? array( $condition_key => $condition_value ) : '',
		)
	);

	$self->add_control(
		$name_prefix . 'link_hover_type',
		array(
			'label'     => esc_html__( 'Hover Underline', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				''                 => esc_html__( 'none', 'wolmart-core' ),
				'btn-underline sm' => esc_html__( 'Underline1', 'wolmart-core' ),
				'btn-underline '   => esc_html__( 'Underline2', 'wolmart-core' ),
				'btn-underline lg' => esc_html__( 'Underline3', 'wolmart-core' ),
			),
			'condition' => $condition_key ? array(
				$condition_key               => $condition_value,
				$name_prefix . 'button_type' => 'btn-link',
			) : array(
				$name_prefix . 'button_type' => 'btn-link',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'shadow',
		array(
			'type'      => Controls_Manager::SELECT,
			'label'     => esc_html__( 'Box Shadow', 'wolmart-core' ),
			'default'   => '',
			'options'   => array(
				''              => esc_html__( 'None', 'wolmart-core' ),
				'btn-shadow-sm' => esc_html__( 'Shadow 1', 'wolmart-core' ),
				'btn-shadow'    => esc_html__( 'Shadow 2', 'wolmart-core' ),
				'btn-shadow-lg' => esc_html__( 'Shadow 3', 'wolmart-core' ),
			),
			'condition' => $condition_key ? array(
				$condition_key                => $condition_value,
				$name_prefix . 'button_type!' => array( 'btn-link', 'btn-outline' ),
			) : array(
				$name_prefix . 'button_type!' => array( 'btn-link', 'btn-outline' ),
			),
		)
	);

	$self->add_control(
		$name_prefix . 'button_border',
		array(
			'label'     => esc_html__( 'Border Style', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				''            => esc_html__( 'Square', 'wolmart-core' ),
				'btn-rounded' => esc_html__( 'Rounded', 'wolmart-core' ),
				'btn-ellipse' => esc_html__( 'Ellipse', 'wolmart-core' ),
			),
			'condition' => $condition_key ? array(
				$condition_key                => $condition_value,
				$name_prefix . 'button_type!' => 'btn-link',
			) : array(
				$name_prefix . 'button_type!' => 'btn-link',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'button_skin',
		array(
			'label'     => esc_html__( 'Skin', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'btn-primary',
			'options'   => array(
				''              => esc_html__( 'Default', 'wolmart-core' ),
				'btn-primary'   => esc_html__( 'Primary', 'wolmart-core' ),
				'btn-secondary' => esc_html__( 'Secondary', 'wolmart-core' ),
				'btn-warning'   => esc_html__( 'Warning', 'wolmart-core' ),
				'btn-danger'    => esc_html__( 'Danger', 'wolmart-core' ),
				'btn-success'   => esc_html__( 'Success', 'wolmart-core' ),
				'btn-dark'      => esc_html__( 'Dark', 'wolmart-core' ),
				'btn-white'     => esc_html__( 'White', 'wolmart-core' ),
			),
			'condition' => $condition_key ? array( $condition_key => $condition_value ) : '',
		)
	);

	if ( 'wolmart_widget_button' == $self->get_name() ) {
		$self->add_control(
			$name_prefix . 'line_break',
			array(
				'label'     => esc_html__( 'Disable Line-break', 'wolmart-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'nowrap',
				'options'   => array(
					'nowrap' => array(
						'title' => esc_html__( 'On', 'wolmart-core' ),
						'icon'  => 'eicon-h-align-right',
					),
					'normal' => array(
						'title' => esc_html__( 'Off', 'wolmart-core' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .btn span' => 'white-space: {{VALUE}};',
				),
				'condition' => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);

		$self->add_control(
			$name_prefix . 'btn_class',
			array(
				'label'     => esc_html__( 'Custom Class', 'wolmart-core' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);
	}

	$self->add_control(
		$name_prefix . 'show_icon',
		array(
			'label'     => esc_html__( 'Show Icon?', 'wolmart-core' ),
			'type'      => Controls_Manager::SWITCHER,
			'condition' => $condition_key ? array( $condition_key => $condition_value ) : '',
		)
	);

		$self->add_control(
			$name_prefix . 'show_label',
			array(
				'label'     => esc_html__( 'Show Label?', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => $condition_key ? array(
					$condition_key                => $condition_value,
					$name_prefix . 'show_icon'    => 'yes',
					$name_prefix . 'icon[value]!' => '',
				) : array(
					'show_icon'    => 'yes',
					'icon[value]!' => '',
				),
			)
		);

	$self->add_control(
		$name_prefix . 'icon',
		array(
			'label'     => esc_html__( 'Icon', 'wolmart-core' ),
			'type'      => Controls_Manager::ICONS,
			'default'   => [
				'value'   => 'w-icon-long-arrow-right',
				'library' => 'wolmart-icons',
			],
			'condition' => $condition_key ? array(
				$condition_key             => $condition_value,
				$name_prefix . 'show_icon' => 'yes',
			) : array(
				'show_icon' => 'yes',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'icon_pos',
		array(
			'label'     => esc_html__( 'Icon Position', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'after',
			'options'   => array(
				'after'  => esc_html__( 'After', 'wolmart-core' ),
				'before' => esc_html__( 'Before', 'wolmart-core' ),
			),
			'condition' => $condition_key ? array(
				$condition_key             => $condition_value,
				$name_prefix . 'show_icon' => 'yes',
			) : array(
				$name_prefix . 'show_icon' => 'yes',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'icon_space',
		array(
			'label'     => esc_html__( 'Icon Spacing (px)', 'wolmart-core' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 30,
				),
			),
			'selectors' => array(
				'.elementor-element-{{ID}} .btn-icon-left:not(.btn-reveal-left) i' => "margin-{$right}: {{SIZE}}px; margin-{$left}: 0;",
				'.elementor-element-{{ID}} .btn-icon-right:not(.btn-reveal-right) i'  => "margin-{$left}: {{SIZE}}px;",
				'.elementor-element-{{ID}} .btn-reveal-left:hover i, .elementor-element-{{ID}} .btn-reveal-left:active i, .elementor-element-{{ID}} .btn-reveal-left:focus i'  => "margin-{$right}: {{SIZE}}px;",
				'.elementor-element-{{ID}} .btn-reveal-right:hover i, .elementor-element-{{ID}} .btn-reveal-right:active i, .elementor-element-{{ID}} .btn-reveal-right:focus i'  => "margin-{$left}: {{SIZE}}px;",
			),
			'condition' => $condition_key ? array(
				$condition_key             => $condition_value,
				$name_prefix . 'show_icon' => 'yes',
			) : array(
				$name_prefix . 'show_icon' => 'yes',
			),
		)
	);

	$selector = '.elementor-element-{{ID}} i';
	if ( 'repeater' == substr( $self->get_name(), 0, 8 ) ) {
		$selector = '.elementor-element-{{ID}} {{CURRENT_ITEM}} i';
	} elseif ( 'wolmart_widget_button' != $self->get_name() ) {
		$selector = '.elementor-element-{{ID}} .btn i';
	}

	$self->add_control(
		$name_prefix . 'icon_size',
		array(
			'label'     => esc_html__( 'Icon Size (px)', 'wolmart-core' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 50,
				),
			),
			'selectors' => array(
				$selector => 'font-size: {{SIZE}}px;',
			),
			'condition' => $condition_key ? array(
				$condition_key             => $condition_value,
				$name_prefix . 'show_icon' => 'yes',
			) : array(
				$name_prefix . 'show_icon' => 'yes',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'icon_hover_effect_infinite',
		array(
			'label'     => esc_html__( 'Animation Infinite', 'wolmart-core' ),
			'type'      => Controls_Manager::SWITCHER,
			'condition' => $condition_key ? array(
				$condition_key                      => $condition_value,
				$name_prefix . 'show_icon'          => 'yes',
				$name_prefix . 'icon_hover_effect!' => array( '', 'btn-reveal-left', 'btn-reveal-right' ),
			) : array(
				'show_icon'                         => 'yes',
				$name_prefix . 'icon_hover_effect!' => array( '', 'btn-reveal-left', 'btn-reveal-right' ),
			),
		)
	);

	$self->add_control(
		$name_prefix . 'icon_hover_effect',
		array(
			'label'     => esc_html__( 'Icon Hover Effect', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				''                 => esc_html__( 'none', 'wolmart-core' ),
				'btn-slide-left'   => esc_html__( 'Slide Left', 'wolmart-core' ),
				'btn-slide-right'  => esc_html__( 'Slide Right', 'wolmart-core' ),
				'btn-slide-up'     => esc_html__( 'Slide Up', 'wolmart-core' ),
				'btn-slide-down'   => esc_html__( 'Slide Down', 'wolmart-core' ),
				'btn-reveal-left'  => esc_html__( 'Reveal Left', 'wolmart-core' ),
				'btn-reveal-right' => esc_html__( 'Reveal Right', 'wolmart-core' ),
			),
			'condition' => $condition_key ? array(
				$condition_key             => $condition_value,
				$name_prefix . 'show_icon' => 'yes',
			) : array(
				$name_prefix . 'show_icon' => 'yes',
			),
		)
	);
}

/**
 * Register elementor style controls for button.
 */
function wolmart_elementor_button_style_controls( $self, $name_prefix = '' ) {
	$self->start_controls_section(
		$name_prefix . 'section_button_style',
		array(
			'label' => esc_html__( 'Button Style', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => $name_prefix . 'button_typography',
			'label'    => esc_html__( 'Label Typography', 'wolmart-core' ),
			'scheme'   => Typography::TYPOGRAPHY_1,
			'selector' => '.elementor-element-{{ID}} .btn',
		)
	);

	$self->add_responsive_control(
		$name_prefix . 'btn_min_width',
		array(
			'label'      => esc_html__( 'Min Width', 'wolmart-core' ),
			'type'       => Controls_Manager::SLIDER,
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 50,
				),
			),
			'size_units' => array(
				'px',
				'%',
				'rem',
			),
			'selectors'  => array(
				'.elementor-element-{{ID}} .btn' => 'min-width: {{SIZE}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		$name_prefix . 'btn_padding',
		array(
			'label'      => esc_html__( 'Padding', 'wolmart-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
				'em',
			),
			'selectors'  => array(
				'.elementor-element-{{ID}} .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		$name_prefix . 'btn_border_radius',
		array(
			'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
				'em',
			),
			'selectors'  => array(
				'.elementor-element-{{ID}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		$name_prefix . 'btn_border_width',
		array(
			'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
				'em',
			),
			'selectors'  => array(
				'.elementor-element-{{ID}} .btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
			),
		)
	);

	$self->start_controls_tabs( $name_prefix . 'tabs_btn_cat' );

	$self->start_controls_tab(
		$name_prefix . 'tab_btn_normal',
		array(
			'label' => esc_html__( 'Normal', 'wolmart-core' ),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_color',
		array(
			'label'     => esc_html__( 'Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_back_color',
		array(
			'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_border_color',
		array(
			'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => $name_prefix . 'btn_box_shadow',
			'selector' => '.elementor-element-{{ID}} .btn',
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		$name_prefix . 'tab_btn_hover',
		array(
			'label' => esc_html__( 'Hover', 'wolmart-core' ),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_color_hover',
		array(
			'label'     => esc_html__( 'Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_back_color_hover',
		array(
			'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:hover' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_border_color_hover',
		array(
			'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:hover' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => $name_prefix . 'btn_box_shadow_hover',
			'selector' => '.elementor-element-{{ID}} .btn:hover',
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		$name_prefix . 'tab_btn_active',
		array(
			'label' => esc_html__( 'Active', 'wolmart-core' ),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_color_active',
		array(
			'label'     => esc_html__( 'Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:not(:focus):active, .elementor-element-{{ID}} .btn:focus' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_back_color_active',
		array(
			'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:not(:focus):active, .elementor-element-{{ID}} .btn:focus' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_border_color_active',
		array(
			'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:not(:focus):active, .elementor-element-{{ID}} .btn:focus' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => $name_prefix . 'btn_box_shadow_active',
			'selector' => '.elementor-element-{{ID}} .btn:active, .elementor-element-{{ID}} .btn:focus',
		)
	);

	$self->end_controls_tab();

	$self->end_controls_tabs();

	$self->end_controls_section();

}
