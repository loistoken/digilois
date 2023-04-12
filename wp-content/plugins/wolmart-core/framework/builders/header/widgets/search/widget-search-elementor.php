<?php
/**
 * Wolmart Header Elementor Search
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Wolmart_Controls_Manager;

class Wolmart_Header_Search_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_header_search';
	}

	public function get_title() {
		return esc_html__( 'Search', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-site-search';
	}

	public function get_categories() {
		return array( 'wolmart_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'wolmart', 'search', 'find' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		$left      = is_rtl() ? 'right' : 'left';
		$right     = 'left' == $left ? 'right' : 'left';
		$container = function_exists( 'wolmart_get_option' ) ? wolmart_get_option( 'container' ) : '1280';

		$this->start_controls_section(
			'section_search_content',
			array(
				'label' => esc_html__( 'Search', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Search Form', 'wolmart-core' ),
					'type'    => Wolmart_Controls_Manager::IMAGE_CHOOSE,
					'default' => 'hs-simple',
					'options' => array(
						'hs-simple'   => 'assets/images/header-search/form-2.jpg',
						'hs-expanded' => 'assets/images/header-search/form-1.jpg',
					),
					'width'   => 3,
				)
			);

			$this->add_control(
				'search_type',
				array(
					'label'       => esc_html__( 'Search Types', 'wolmart-core' ),
					'description' => esc_html__( 'Select post types to search', 'wolmart-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'product',
					'options'     => array(
						''        => esc_html__( 'All', 'wolmart-core' ),
						'product' => esc_html__( 'Product', 'wolmart-core' ),
						'post'    => esc_html__( 'Post', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'show_keywords',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Show Popular Search Keywords', 'wolmart-core' ),
					'description' => sprintf( esc_html__( 'Please go to %1$sCustomize Panel/Advanced/Search%2$s. At first, you need to set show keywords option by navigating to customize panel.', 'wolmart-core' ), '<a href="' . wp_customize_url() . '#search" data-target="search" data-type="section" target="_blank">', '</a>' ),
					'separator'   => 'before',
				)
			);

			$this->add_control(
				'keyword_content',
				array(
					'label'       => esc_html__( 'Default Search Keywords', 'wolmart-core' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'placeholder' => esc_html__( 'value|value', 'wolmart-core' ),
					'condition'   => array(
						'show_keywords' => 'yes',
					),
				)
			);

			$this->add_control(
				'keyword_count',
				array(
					'label'     => esc_html__( 'Max count (Up to 10)', 'wolmart-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 8,
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 10,
						),
					),
					'condition' => array(
						'show_keywords' => 'yes',
					),
				)
			);

			$this->add_control(
				'res_keyword_count',
				array(
					'label'     => sprintf( esc_html__( 'Count between %spx and 992px', 'wolmart-core' ), $container ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 5,
					'separator' => 'after',
					'condition' => array(
						'show_keywords' => 'yes',
					),
				)
			);

			$this->add_control(
				'placeholder',
				array(
					'label'   => esc_html__( 'Search Form Placeholder', 'wolmart-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Search in...', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'   => esc_html__( 'Search Icon', 'wolmart-core' ),
					'type'    => Controls_Manager::ICONS,
					'default' => array(
						'value'   => 'w-icon-search',
						'library' => 'wolmart-icons',
					),
				)
			);

			$this->add_responsive_control(
				'search_width',
				array(
					'label'      => esc_html__( 'Search Width', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 200,
							'max'  => 600,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .hs-expanded' => 'max-width: {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .hs-simple' => 'max-width: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'search_align',
				array(
					'label'     => esc_html__( 'Align', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'0 auto 0 0' => array(
							'title' => esc_html__( 'Left', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'0 auto'     => array(
							'title' => esc_html__( 'Center', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'0 0 0 auto' => array(
							'title' => esc_html__( 'Right', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper' => 'margin: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'search_height',
				array(
					'label'      => esc_html__( 'Search Height', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 46,
							'max'  => 80,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .hs-expanded form' => 'height: {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .hs-simple form' => 'height: {{SIZE}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_input_style',
			array(
				'label' => esc_html__( 'Input Field', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'input_typography',
					'selector' => '.elementor-element-{{ID}} .search-wrapper input.form-control, .elementor-element-{{ID}} select',
				)
			);

			$this->add_control(
				'search_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control, .elementor-element-{{ID}} .search-wrapper input.form-control::placeholder' => 'color: {{VALUE}};',
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'search_bg',
				array(
					'label'     => esc_html__( 'Background', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper form' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'search_bd',
				array(
					'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default'    => array(
						'top'    => '2',
						'right'  => '2',
						'bottom' => '2',
						'left'   => '2',
					),
					'size_units' => array( 'px', 'rem', '%' ),
					'separator'  => 'before',
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper form.input-wrapper' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'search_br',
				array(
					'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .search-wrapper .btn-search' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
						'.elementor-element-{{ID}} .search-wrapper.hs-simple input.form-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .search-wrapper form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'search_bd_color',
				array(
					'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper form.input-wrapper' => 'border-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'search_separator_color',
				array(
					'label'     => esc_html__( 'Separator Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'separator' => 'before',
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper .select-box:after' => 'background: {{VALUE}};',
					),
					'condition' => array(
						'type' => 'hs-expanded',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label' => esc_html__( 'Button', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'icon_size',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .btn-search i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'button_pd',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .btn-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_btn_color' );
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
								'.elementor-element-{{ID}} .search-wrapper .btn-search' => 'color: {{VALUE}};',
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
						'btn_hover_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn-search:hover' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_keywords_style',
			array(
				'label'     => esc_html__( 'Search Keywords', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_keywords' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'keyword_typography',
				'selector' => '.elementor-element-{{ID}} .search-keywords-container',
			)
		);

		$this->add_control(
			'key_top_space',
			array(
				'label'     => esc_html__( 'Top Spacing (px)', 'wolmart-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'separator' => 'after',
				'selectors' => array(
					'.elementor-element-{{ID}} .search-keywords-container' => 'margin-top: {{SIZE}}px;',
				),
			)
		);

		$this->add_control(
			'key_heading_color',
			array(
				'label'     => esc_html__( 'Heading Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => array(
					'.elementor-element-{{ID}} .search-keywords-container>span' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'key_heading_space',
			array(
				'label'     => esc_html__( 'Heading Spacing (px)', 'wolmart-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'separator' => 'after',
				'selectors' => array(
					'.elementor-element-{{ID}} .search-keywords-container>span' => "margin-{$right}: {{SIZE}}px;",
				),
			)
		);

		$this->add_control(
			'key_item_color',
			array(
				'label'     => esc_html__( 'Keyword Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .search-keywords-box>a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'key_item_hover_color',
			array(
				'label'     => esc_html__( 'Keyword Hover Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .search-keywords-box>a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'key_item_border_color',
			array(
				'label'     => esc_html__( 'Keyword Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .search-keywords-box>a' => 'border-left-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'key_item_spacing',
			array(
				'label'      => esc_html__( 'Keyword Padding', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .search-keywords-box>a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		get_search_form(
			array(
				'aria_label' => array(
					'type'              => $settings['type'],
					'where'             => 'header',
					'search_post_type'  => $settings['search_type'],
					'placeholder'       => $settings['placeholder'] ? $settings['placeholder'] : 'Search in...',
					'icon'              => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : 'w-icon-search',
					'show_keywords'     => $settings['show_keywords'],
					'keyword_count'     => $settings['keyword_count'],
					'keyword_content'   => $settings['keyword_content'],
					'res_keyword_count' => $settings['res_keyword_count'],
				),
			)
		);
	}
}
