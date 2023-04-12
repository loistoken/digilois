<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Heading Widget
 *
 * Wolmart Widget to display heading.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;


class Wolmart_Heading_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'wolmart_widget_heading';
	}

	public function get_title() {
		return esc_html__( 'Heading', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'heading', 'title', 'subtitle', 'text', 'wolmart', 'dynamic' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-heading';
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {

		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		$this->start_controls_section(
			'section_heading_title',
			array(
				'label' => esc_html__( 'Title', 'wolmart-core' ),
			)
		);

		$this->add_control(
			'content_type',
			array(
				'label'   => esc_html__( 'Content', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'custom'  => esc_html__( 'Custom Text', 'wolmart-core' ),
					'dynamic' => esc_html__( 'Dynamic Content', 'wolmart-core' ),
				),
				'default' => 'custom',
			)
		);

		$this->add_control(
			'dynamic_content',
			array(
				'label'     => esc_html__( 'Dynamic Content', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'title'       => esc_html__( 'Page Title', 'wolmart-core' ),
					'subtitle'    => esc_html__( 'Page Subtitle', 'wolmart-core' ),
					'product_cnt' => esc_html__( 'Products Count', 'wolmart-core' ),
				),
				'default'   => 'title',
				'condition' => array(
					'content_type' => 'dynamic',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'wolmart-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'Add Your Heading Text Here', 'wolmart-core' ),
				'placeholder' => esc_html__( 'Enter your title', 'wolmart-core' ),
				'condition'   => array(
					'content_type' => 'custom',
				),
			)
		);

		$this->add_control(
			'tag',
			array(
				'label'   => esc_html__( 'HTML Tag', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'p',
				),
				'default' => 'h2',
			)
		);

		$this->add_control(
			'decoration',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Type', 'wolmart-core' ),
				'default' => '',
				'options' => array(
					''          => esc_html__( 'Simple', 'wolmart-core' ),
					'cross'     => esc_html__( 'Cross', 'wolmart-core' ),
					'underline' => esc_html__( 'Underline', 'wolmart-core' ),
				),
			)
		);

		$this->add_control(
			'title_align',
			array(
				'label'   => esc_html__( 'Title Align', 'wolmart-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'title-left',
				'options' => array(
					'title-left'   => array(
						'title' => esc_html__( 'Left', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'title-center' => array(
						'title' => esc_html__( 'Center', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'title-right'  => array(
						'title' => esc_html__( 'Right', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
			)
		);

		$this->add_responsive_control(
			'decoration_spacing',
			array(
				'label'      => esc_html__( 'Decoration Spacing', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .title::before' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .title::after'  => 'margin-left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'decoration' => 'cross',
				),
			)
		);

		$this->add_control(
			'border_color',
			array(
				'label'     => esc_html__( 'Decoration Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .title-cross .title::before, .elementor-element-{{ID}} .title-cross .title::after, .elementor-element-{{ID}} .title-underline::after' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'decoration' => 'cross',
				),
			)
		);

		$this->add_control(
			'show_link',
			array(
				'label'   => esc_html__( 'Show Link?', 'wolmart-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_link',
			array(
				'label'     => esc_html__( 'Link', 'wolmart-core' ),
				'condition' => array(
					'show_link' => 'yes',
				),
			)
		);

		$this->add_control(
			'link_url',
			array(
				'label'   => esc_html__( 'Link Url', 'wolmart-core' ),
				'type'    => Controls_Manager::URL,
				'default' => array(
					'url' => '',
				),
			)
		);

		$this->add_control(
			'link_label',
			array(
				'label'   => esc_html__( 'Link Label', 'wolmart-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'link',
			)
		);

		$this->add_control(
			'icon',
			array(
				'label' => esc_html__( 'Icon', 'wolmart-core' ),
				'type'  => Controls_Manager::ICONS,
			)
		);

		$this->add_control(
			'icon_pos',
			array(
				'label'   => esc_html__( 'Icon Position', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => array(
					'after'  => esc_html__( 'After', 'wolmart-core' ),
					'before' => esc_html__( 'Before', 'wolmart-core' ),
				),
			)
		);

		$this->add_control(
			'icon_space',
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
					'.elementor-element-{{ID}} .icon-before i' => "margin-{$right}: {{SIZE}}px;",
					'.elementor-element-{{ID}} .icon-after i'  => "margin-{$left}: {{SIZE}}px;",
				),
			)
		);

		$this->add_control(
			'icon_size',
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
					'.elementor-element-{{ID}} i' => 'font-size: {{SIZE}}px;',
				),
			)
		);

		$this->add_responsive_control(
			'link_align',
			array(
				'label'   => esc_html__( 'Link Align', 'wolmart-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'link-left'  => array(
						'title' => esc_html__( 'Left', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'link-right' => array(
						'title' => esc_html__( 'Right', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'link-right',
			)
		);

		$this->add_responsive_control(
			'show_divider',
			array(
				'label'     => esc_html__( 'Show Divider?', 'donad-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'link_align' => 'link-left',
				),
			)
		);

		$this->add_control(
			'link_gap',
			array(
				'label'      => esc_html__( 'Link Space', 'wolmart-core' ),
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
					'.elementor-element-{{ID}} .link' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_title_style',
			array(
				'label' => esc_html__( 'Title', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'title_spacing',
			array(
				'label'      => esc_html__( 'Title Padding', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '.elementor-element-{{ID}} .title',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_link_style',
			array(
				'label' => esc_html__( 'Link', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'link_spacing',
			array(
				'label'      => esc_html__( 'Link Spacing', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'link_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '.elementor-element-{{ID}} .link',
			)
		);

		$this->start_controls_tabs( 'tabs_heading_link' );

		$this->start_controls_tab(
			'tab_link_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'wolmart-core' ),
			)
		);

		$this->add_control(
			'link_color',
			array(
				'label'     => esc_html__( 'Link Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_link_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'wolmart-core' ),
			)
		);

		$this->add_control(
			'link_hover_color',
			array(
				'label'     => esc_html__( 'Link Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .link:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		$this->add_inline_editing_attributes( 'link_label' );
		if ( 'custom' == $atts['content_type'] ) {
			$this->add_inline_editing_attributes( 'title' );
		}
		require __DIR__ . '/render-heading-elementor.php';
	}
}
