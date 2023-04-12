<?php
/**
 * Wolmart Header Elementor Vertical Divider
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

class Wolmart_Logo_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_header_site_logo';
	}

	public function get_title() {
		return esc_html__( 'Site Logo', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-site-logo';
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'wolmart', 'header', 'logo', 'site' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_logo_content',
			array(
				'label' => esc_html__( 'Image', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_responsive_control(
			'logo_align',
			array(
				'label'     => esc_html__( 'Alignment', 'wolmart-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'.elementor-element-{{ID}}' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'logo', // Usage: `{name}_size` and `{name}_custom_dimension`
				'default' => 'full',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_logo_style',
			array(
				'label' => esc_html__( 'Image', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_logo' );

			$this->start_controls_tab(
				'tab_logo_normal',
				array(
					'label' => esc_html__( 'Normal', 'wolmart-core' ),
				)
			);

				$this->add_responsive_control(
					'logo_width',
					array(
						'label'      => esc_html__( 'Width', 'wolmart-core' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'rem' ),
						'selectors'  => array(
							'.elementor-element-{{ID}} .logo img' => 'width: {{SIZE}}{{UNIT}};',
						),
					)
				);

				$this->add_responsive_control(
					'logo_max_width',
					array(
						'label'      => esc_html__( 'Max Width', 'wolmart-core' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'rem' ),
						'selectors'  => array(
							'.elementor-element-{{ID}} .logo img' => 'max-width: {{SIZE}}{{UNIT}};',
						),
					)
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_logo_sticky',
				array(
					'label' => esc_html__( 'Sticky', 'wolmart-core' ),
				)
			);

				$this->add_responsive_control(
					'logo_width_sticky',
					array(
						'label'      => esc_html__( 'Width', 'wolmart-core' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'rem' ),
						'selectors'  => array(
							'.fixed .elementor-element-{{ID}} .logo img' => 'width: {{SIZE}}{{UNIT}};',
						),
					)
				);

				$this->add_responsive_control(
					'logo_max_width_sticky',
					array(
						'label'      => esc_html__( 'Max Width', 'wolmart-core' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'rem' ),
						'selectors'  => array(
							'.fixed .elementor-element-{{ID}} .logo img' => 'max-width: {{SIZE}}{{UNIT}};',
						),
					)
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts = array( 'thumbnail_size' => $this->get_settings_for_display( 'logo_size' ) );
		require __DIR__ . '/render-logo.php';
	}
}
