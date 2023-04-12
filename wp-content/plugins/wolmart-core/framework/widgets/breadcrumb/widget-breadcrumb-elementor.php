<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Breadcrumb Widget
 *
 * Wolmart Widget to display WC breadcrumb.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Wolmart_Breadcrumb_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_breadcrumb';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumb', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-product-breadcrumbs';
	}

	public function get_keywords() {
		return array( 'breadcrumb', 'wolmart' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_breadcrumb',
			array(
				'label' => esc_html__( 'Breadcrumb', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'delimiter',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Breadcrumb Delimiter', 'wolmart-core' ),
					'placeholder' => esc_html__( '/', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'delimiter_icon',
				array(
					'label' => esc_html__( 'Delimiter Icon', 'wolmart-core' ),
					'type'  => Controls_Manager::ICONS,
				)
			);

			$this->add_control(
				'home_icon',
				array(
					'type'  => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Show Home Icon', 'wolmart-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_breadcrumb_style',
			array(
				'label' => esc_html__( 'Breadcrumb Style', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'breadcrumb_typography',
					'label'    => esc_html__( 'Typography', 'wolmart-core' ),
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '.elementor-element-{{ID}} .breadcrumb',
				)
			);

			$this->add_responsive_control(
				'align',
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
						'.elementor-element-{{ID}} .breadcrumb' => 'justify-content: {{VALUE}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_link_col' );
				$this->start_controls_tab(
					'tab_link_col',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'link_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .breadcrumb' => 'color: {{VALUE}};',
								'.elementor-element-{{ID}} .breadcrumb a' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_link_col_active',
					array(
						'label' => esc_html__( 'Active', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'link_color_active',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .breadcrumb' => 'color: {{VALUE}};',
								'.elementor-element-{{ID}} .breadcrumb a' => 'opacity: 1;',
								'.elementor-element-{{ID}} .breadcrumb a:hover' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'delimiter_size',
				array(
					'label'      => esc_html__( 'Delimiter Size', 'wolmart-core' ),
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
					'separator'  => 'before',
					'selectors'  => array(
						'.elementor-element-{{ID}} .delimiter' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'delimiter_space',
				array(
					'label'      => esc_html__( 'Delimiter Space', 'wolmart-core' ),
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
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .delimiter' => 'margin: 0 {{SIZE}}{{UNIT}}',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-breadcrumb.php';
	}

	protected function content_template() {}
}
