<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Wolmart Elementor CountTo Widget
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Wolmart_Controls_Manager;

class Wolmart_Hotspot_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_hotspot';
	}

	public function get_title() {
		return esc_html__( 'Hotspot', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-image-hotspot';
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'hotspot', 'dot' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_hotspot',
			array(
				'label' => esc_html__( 'Hotspot', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'icon',
				array(
					'label'   => esc_html__( 'Icon', 'wolmart-core' ),
					'type'    => Controls_Manager::ICONS,
					'default' => array(
						'value'   => 'w-icon-plus',
						'library' => '',
					),
				)
			);

			$this->add_responsive_control(
				'horizontal',
				array(
					'label'      => esc_html__( 'Horizontal', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 50,
						'unit' => '%',
					),
					'size_units' => array(
						'px',
						'%',
						'vw',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}}' => 'left: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'vertical',
				array(
					'label'      => esc_html__( 'Vertical', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 50,
						'unit' => '%',
					),
					'size_units' => array(
						'px',
						'%',
						'vw',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}}' => 'top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'effect',
				array(
					'label'   => esc_html__( 'Hotspot Effect', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'type1',
					'options' => array(
						''      => esc_html__( 'None', 'wolmart-core' ),
						'type1' => esc_html__( 'Spread', 'wolmart-core' ),
						'type2' => esc_html__( 'Twinkle', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'el_class',
				array(
					'label' => esc_html__( 'Custom Class', 'wolmart-core' ),
					'type'  => Controls_Manager::TEXT,
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Popup Content', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'html',
					'options' => array(
						'html'    => esc_html__( 'Custom Html', 'wolmart-core' ),
						'block'   => esc_html__( 'Block', 'wolmart-core' ),
						'product' => esc_html__( 'Product', 'wolmart-core' ),
						'image'   => esc_html__( 'Image', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'html',
				array(
					'label'     => esc_html__( 'Custom Html', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXTAREA,
					'condition' => array( 'type' => 'html' ),
				)
			);

			$this->add_control(
				'image',
				array(
					'label'     => esc_html__( 'Choose Image', 'wolmart-core' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'condition' => array( 'type' => 'image' ),
				)
			);

			$this->add_control(
				'block',
				array(
					'label'       => esc_html__( 'Select a Block', 'wolmart-core' ),
					'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
					'options'     => 'block',
					'label_block' => true,
					'condition'   => array( 'type' => 'block' ),
				)
			);

			$this->add_control(
				'link',
				array(
					'label'     => esc_html__( 'Link Url', 'wolmart-core' ),
					'type'      => Controls_Manager::URL,
					'default'   => array(
						'url' => '',
					),
					'condition' => array( 'type!' => 'product' ),
				)
			);

			$this->add_control(
				'product',
				array(
					'label'       => esc_html__( 'Product', 'wolmart-core' ),
					'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
					'options'     => 'product',
					'label_block' => true,
					'condition'   => array( 'type' => 'product' ),
				)
			);

			$this->add_control(
				'popup_position',
				array(
					'label'   => esc_html__( 'Popup Position', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'top',
					'options' => array(
						'none'   => esc_html__( 'Do not display', 'wolmart-core' ),
						'top'    => esc_html__( 'Top', 'wolmart-core' ),
						'left'   => esc_html__( 'Left', 'wolmart-core' ),
						'right'  => esc_html__( 'Right', 'wolmart-core' ),
						'bottom' => esc_html__( 'Bottom', 'wolmart-core' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_hotspot',
			array(
				'label' => esc_html__( 'Hotspot', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'size',
				array(
					'label'      => esc_html__( 'Hotspot Size', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 20,
						'unit' => 'px',
					),
					'size_units' => array(
						'px',
						'%',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .hotspot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'icon_size',
				array(
					'label'      => esc_html__( 'Icon Size', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 14,
						'unit' => 'px',
					),
					'size_units' => array(
						'px',
						'em',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'em' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .hotspot i' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .hotspot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_hotspot' );

				$this->start_controls_tab(
					'tab_btn_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'btn_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .hotspot' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_back_color',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .hotspot' => 'background-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_btn_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'btn_color_hover',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .hotspot-wrapper:hover .hotspot' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_back_color_hover',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .hotspot-wrapper:hover .hotspot' => 'background-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'style_popup',
			array(
				'label' => esc_html__( 'Popup', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'popup_width',
				array(
					'label'      => esc_html__( 'Width', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 1000,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .hotspot-box' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-hotspot-elementor.php';
	}
}
