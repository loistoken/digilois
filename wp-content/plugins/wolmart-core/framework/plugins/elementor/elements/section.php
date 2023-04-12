<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Section Element
 *
 * Extended Element_Section Class
 * Added Slider, Banner, Creative Grid Functions.
 *
 * @since 1.0
 * @since 1.1.11 - Fixed - elementor section divider not working properly on the frontend.
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Embed;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Modules\DynamicTags\Module as TagsModule;

add_action( 'elementor/frontend/section/before_render', 'wolmart_section_render_attributes', 10, 1 );

class Wolmart_Element_Section extends Elementor\Element_Section {

	public $legacy_mode = true;


	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );
		$this->legacy_mode = ! wolmart_elementor_if_dom_optimization();
	}

	protected function get_html_tag() {
		$html_tag = $this->get_settings( 'html_tag' );

		if ( empty( $html_tag ) ) {
			$html_tag = 'section';
		}

		return Elementor\Utils::validate_html_tag( $html_tag );
	}

	protected function register_controls() {
		parent::register_controls();

		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'Wolmart Settings', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);

			$this->add_control(
				'section_content_type',
				array(
					'label'     => esc_html__( 'Wrap with Container-Fluid', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'layout' => 'boxed',
					),
				)
			);

			$this->add_control(
				'section_content_sticky',
				array(
					'label' => esc_html__( 'Sticky Content', 'wolmart-core' ),
					'type'  => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'section_content_sticky_auto',
				array(
					'label'     => esc_html__( 'Auto Show On Scroll', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'section_content_sticky' => 'yes',
					),
				)
			);

			$this->add_responsive_control(
				'section_sticky_padding',
				array(
					'label'      => esc_html__( 'Sticky Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
					),
					'selectors'  => array(
						'{{WRAPPER}}.fixed' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition'  => array(
						'section_content_sticky' => 'yes',
					),
				)
			);

			$this->add_control(
				'section_sticky_bg',
				array(
					'label'     => esc_html__( 'Sticky Background', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}}.fixed' => 'background-color: {{VALUE}}',
					),
					'separator' => 'after',
					'condition' => array(
						'section_content_sticky' => 'yes',
					),
				)
			);

			$this->add_control(
				'use_as',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Use Section For', 'wolmart-core' ),
					'default' => '',
					'options' => array(
						''          => esc_html__( 'Default', 'wolmart-core' ),
						'slider'    => esc_html__( 'Slider', 'wolmart-core' ),
						'tab'       => esc_html__( 'Tab', 'wolmart-core' ),
						'accordion' => esc_html__( 'Accordion', 'wolmart-core' ),
						'banner'    => esc_html__( 'Banner', 'wolmart-core' ),
						'creative'  => esc_html__( 'Creative Grid', 'wolmart-core' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_creative_grid',
			array(
				'label'     => esc_html__( 'Creative Grid', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'creative',
				),
			)
		);
			wolmart_elementor_creative_layout_controls( $this, 'use_as', 'section' );
		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider',
			array(
				'label'     => esc_html__( 'Slider', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'slider',
				),
			)
		);
			wolmart_elementor_grid_layout_controls( $this, 'use_as' );
			wolmart_elementor_slider_layout_controls( $this, 'use_as' );
		$this->end_controls_section();

		$this->start_controls_section(
			'section_tab',
			array(
				'label'     => esc_html__( 'Tab', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'tab',
				),
			)
		);
		wolmart_elementor_tab_layout_controls( $this, 'use_as' );
		$this->end_controls_section();

		$this->start_controls_section(
			'section_accordion',
			array(
				'label'     => esc_html__( 'Accordion', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'accordion',
				),
			)
		);
			// Accordion Controls
			$this->add_control(
				'accordion_type',
				array(
					'label'     => esc_html__( 'Accordion Type', 'wolmart-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						''       => esc_html__( 'Default', 'wolmart-core' ),
						'simple' => esc_html__( 'Simple', 'wolmart-core' ),
						'border' => esc_html__( 'Border', 'wolmart-core' ),
						'boxed'  => esc_html__( 'Boxed', 'wolmart-core' ),
					),
					'condition' => array(
						'use_as' => 'accordion',
					),
				)
			);

			$this->add_control(
				'accordion_card_space',
				array(
					'label'     => esc_html__( 'Card Space', 'wolmart-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .card:not(:last-child)' => 'margin-bottom: {{SIZE}}px',
					),
					'condition' => array(
						'use_as'         => 'accordion',
						'accordion_type' => 'boxed',
					),
				)
			);

			$this->add_control(
				'accordion_icon',
				array(
					'label'            => esc_html__( 'Toggle Icon', 'wolmart-core' ),
					'type'             => Controls_Manager::ICONS,
					'separator'        => 'before',
					'fa4compatibility' => 'icon',
					'default'          => array(
						'value'   => 'w-icon-plus',
						'library' => 'wolmart-icons',
					),
					'recommended'      => array(
						'fa-solid'   => array(
							'chevron-down',
							'angle-down',
							'angle-double-down',
							'caret-down',
							'caret-square-down',
						),
						'fa-regular' => array(
							'caret-square-down',
						),
					),
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => array(
						'use_as' => 'accordion',
					),
				)
			);

			$this->add_control(
				'accordion_active_icon',
				array(
					'label'            => esc_html__( 'Active Toggle Icon', 'wolmart-core' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon_active',
					'default'          => array(
						'value'   => 'w-icon-minus',
						'library' => 'wolmart-icons',
					),
					'recommended'      => array(
						'fa-solid'   => array(
							'chevron-up',
							'angle-up',
							'angle-double-up',
							'caret-up',
							'caret-square-up',
						),
						'fa-regular' => array(
							'caret-square-up',
						),
					),
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => array(
						'use_as'                 => 'accordion',
						'accordion_icon[value]!' => '',
					),
				)
			);

			$this->add_control(
				'toggle_icon_size',
				array(
					'type'       => Controls_Manager::SLIDER,
					'label'      => esc_html__( 'Toggle Icon Size', 'wolmart-core' ),
					'size_units' => array( 'px', 'rem', 'em' ),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
						'em'  => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
					),
					'condition'  => array(
						'use_as'                 => 'accordion',
						'accordion_icon[value]!' => '',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .toggle-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_banner',
			array(
				'label'     => esc_html__( 'Banner', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'banner',
				),
			)
		);
			wolmart_elementor_banner_layout_controls( $this, 'use_as' );

			$this->add_control(
				'parallax',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Enable Parallax', 'wolmart-core' ),
					'separator' => 'before',
					'condition' => array(
						'use_as' => 'banner',
					),
				)
			);

			$this->add_control(
				'parallax_speed',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Parallax Speed', 'wolmart-core' ),
					'condition' => array(
						'use_as'   => 'banner',
						'parallax' => 'yes',
					),
					'default'   => array(
						'size' => 1.5,
						'unit' => 'px',
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
					),
				)
			);

			$this->add_control(
				'parallax_offset',
				array(
					'type'       => Controls_Manager::SLIDER,
					'label'      => esc_html__( 'Parallax Offset', 'wolmart-core' ),
					'condition'  => array(
						'use_as'   => 'banner',
						'parallax' => 'yes',
					),
					'default'    => array(
						'size' => 0,
						'unit' => 'px',
					),
					'size_units' => array(
						'px',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => -300,
							'max'  => 300,
						),
					),
				)
			);

			$this->add_control(
				'parallax_height',
				array(
					'type'       => Controls_Manager::SLIDER,
					'label'      => esc_html__( 'Parallax Height (%)', 'wolmart-core' ),
					'condition'  => array(
						'use_as'   => 'banner',
						'parallax' => 'yes',
					),
					'default'    => array(
						'size' => 180,
						'unit' => 'px',
					),
					'size_units' => array(
						'px',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 300,
						),
					),
				)
			);

			$this->add_control(
				'video_banner_switch',
				array(
					'label'     => esc_html__( 'Enable Video', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'use_as' => 'banner',
					),
					'separator' => 'before',
				)
			);

		$this->end_controls_section();

		wolmart_elementor_slider_style_controls( $this, 'use_as' );

		wolmart_elementor_tab_style_controls( $this, 'use_as' );

		$this->start_controls_section(
			'accordion_style',
			array(
				'label'     => esc_html__( 'Accordion', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'use_as' => 'accordion',
				),
			)
		);

			$this->add_control(
				'accordion_card_heading',
				array(
					'label' => esc_html__( 'Card', 'wolmart-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_responsive_control(
				'accordion_bd',
				array(
					'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default'    => array(
						'top'    => 1,
						'right'  => 1,
						'bottom' => 1,
						'left'   => 1,
					),
					'size_units' => array(
						'px',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .card' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'accordion_bd_color',
				array(
					'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'separator' => 'after',
					'selectors' => array(
						// Stronger selector to avoid section style from overwriting
						'.elementor-element-{{ID}} .accordion' => 'border-color: {{VALUE}};',
						'.elementor-element-{{ID}} .card' => 'border-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'accordion_header_heading',
				array(
					'label' => esc_html__( 'Card Header', 'wolmart-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_responsive_control(
				'accordion_header_bd',
				array(
					'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .card-header a' => 'border: 1px solid; border-color: inherit; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'accordion_header_pad',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .card-header a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .opened, .elementor-element-{{ID}} .closed' => 'right: {{RIGHT}}{{UNIT}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'panel_header_typography',
					'label'    => esc_html__( 'Typography', 'wolmart-core' ),
					'selector' => '.elementor-element-{{ID}} .card-header a',
				)
			);

			$this->start_controls_tabs( 'accordion_color_tabs' );

				$this->start_controls_tab(
					'accordion_color_normal_tab',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'accordion_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_header_bd_color',
						array(
							'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'accordion_color_hover_tab',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'accordion_color_hover',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_bg_color_hover',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_header_bd_color_hover',
						array(
							'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a:hover' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'accordion_color_active_tab',
					array(
						'label' => esc_html__( 'Active', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'accordion_color_active',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a:not(.expand)' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_bg_color_active',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a:not(.expand)' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_header_bd_color_active',
						array(
							'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a:not(.expand)' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'accordion_content_heading',
				array(
					'label'     => esc_html__( 'Card Body', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_responsive_control(
				'accordion_body_bd',
				array(
					'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .card .card-body' => 'border: 1px solid; border-color: inherit; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'accordion_content_pad',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .card-body .elementor-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'accordion_color_heading',
				array(
					'label'     => esc_html__( 'Header Icon', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'accordion_icon_typography',
					'separator' => 'before',
					'label'     => esc_html__( 'Header Icon Typography', 'wolmart-core' ),
					'selector'  => '.elementor-element-{{ID}} .card-header a > i:first-child',
				)
			);

			$this->add_control(
				'accordion_color_icon_space',
				array(
					'label'     => esc_html__( 'Header Icon Space', 'wolmart-core' ),
					'type'      => Controls_Manager::NUMBER,
					'selectors' => array(
						'.elementor-element-{{ID}} .card-header a > i:first-child' => 'margin-right: {{VALUE}}px;',
					),
				)
			);

		$this->end_controls_section();

		// Section Video Options
		$this->start_controls_section(
			'wolmart_video_section',
			array(
				'label'     => esc_html__( 'Video', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as'              => 'banner',
					'video_banner_switch' => 'yes',
				),
			)
		);

		$this->add_control(
			'video_type',
			array(
				'label'   => esc_html__( 'Source', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'youtube',
				'options' => array(
					'youtube'     => esc_html__( 'YouTube', 'wolmart-core' ),
					'vimeo'       => esc_html__( 'Vimeo', 'wolmart-core' ),
					'dailymotion' => esc_html__( 'Dailymotion', 'wolmart-core' ),
					'hosted'      => esc_html__( 'Self Hosted', 'wolmart-core' ),
				),
			)
		);

		$this->add_control(
			'youtube_url',
			array(
				'label'       => esc_html__( 'Link', 'wolmart-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'placeholder' => esc_html__( 'Enter your URL (YouTube)', 'wolmart-core' ),
				'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'vimeo_url',
			array(
				'label'       => esc_html__( 'Link', 'wolmart-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'placeholder' => esc_html__( 'Enter your URL', 'wolmart-core' ) . ' (Vimeo)',
				'default'     => 'https://vimeo.com/235215203',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'dailymotion_url',
			array(
				'label'       => esc_html__( 'Link', 'wolmart-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'placeholder' => esc_html__( 'Enter your URL (Dailymotion)', 'wolmart-core' ),
				'default'     => 'https://www.dailymotion.com/video/x6tqhqb',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'dailymotion',
				),
			)
		);

		$this->add_control(
			'insert_url',
			array(
				'label'     => esc_html__( 'External URL', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'video_type' => 'hosted',
				),
			)
		);

		$this->add_control(
			'hosted_url',
			array(
				'label'      => esc_html__( 'Choose File', 'wolmart-core' ),
				'type'       => Controls_Manager::MEDIA,
				'dynamic'    => array(
					'active'     => true,
					'categories' => array(
						TagsModule::MEDIA_CATEGORY,
					),
				),
				'media_type' => 'video',
				'condition'  => array(
					'video_type' => 'hosted',
					'insert_url' => '',
				),
			)
		);

		$this->add_control(
			'external_url',
			array(
				'label'        => esc_html__( 'URL', 'wolmart-core' ),
				'type'         => Controls_Manager::URL,
				'autocomplete' => false,
				'options'      => false,
				'label_block'  => true,
				'show_label'   => false,
				'dynamic'      => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'media_type'   => 'video',
				'placeholder'  => esc_html__( 'Enter your URL', 'wolmart-core' ),
				'condition'    => array(
					'video_type' => 'hosted',
					'insert_url' => 'yes',
				),
			)
		);

		$this->add_control(
			'video_options',
			array(
				'label'     => esc_html__( 'Video Options', 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'video_autoplay',
			array(
				'label'   => esc_html__( 'Autoplay', 'wolmart-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'video_mute',
			array(
				'label' => esc_html__( 'Mute', 'wolmart-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'video_loop',
			array(
				'label'     => esc_html__( 'Loop', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'video_type!' => 'dailymotion',
				),
			)
		);

		$this->add_control(
			'video_controls',
			array(
				'label'     => esc_html__( 'Player Controls', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'wolmart-core' ),
				'label_on'  => esc_html__( 'Show', 'wolmart-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type!' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'showinfo',
			array(
				'label'     => esc_html__( 'Video Info', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'wolmart-core' ),
				'label_on'  => esc_html__( 'Show', 'wolmart-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type' => array( 'dailymotion' ),
				),
			)
		);

		$this->add_control(
			'modestbranding',
			array(
				'label'     => esc_html__( 'Modest Branding', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'video_type' => array( 'youtube' ),
					'controls'   => 'yes',
				),
			)
		);

		$this->add_control(
			'logo',
			array(
				'label'     => esc_html__( 'Logo', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'wolmart-core' ),
				'label_on'  => esc_html__( 'Show', 'wolmart-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type' => array( 'dailymotion' ),
				),
			)
		);

		$this->add_control(
			'control_color',
			array(
				'label'     => esc_html__( 'Controls Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'video_type' => array( 'vimeo', 'dailymotion' ),
				),
			)
		);

		// YouTube.
		$this->add_control(
			'yt_privacy',
			array(
				'label'       => esc_html__( 'Privacy Mode', 'wolmart-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'wolmart-core' ),
				'condition'   => array(
					'video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'rel',
			array(
				'label'     => esc_html__( 'Suggested Videos', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''    => esc_html__( 'Current Video Channel', 'wolmart-core' ),
					'yes' => esc_html__( 'Any Video', 'wolmart-core' ),
				),
				'condition' => array(
					'video_type' => 'youtube',
				),
			)
		);

		// Vimeo.
		$this->add_control(
			'vimeo_title',
			array(
				'label'     => esc_html__( 'Intro Title', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'wolmart-core' ),
				'label_on'  => esc_html__( 'Show', 'wolmart-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'vimeo_portrait',
			array(
				'label'     => esc_html__( 'Intro Portrait', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'wolmart-core' ),
				'label_on'  => esc_html__( 'Show', 'wolmart-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'vimeo_byline',
			array(
				'label'     => esc_html__( 'Intro Byline', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'wolmart-core' ),
				'label_on'  => esc_html__( 'Show', 'wolmart-core' ),
				'default'   => 'yes',
				'condition' => array(
					'video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'show_image_overlay',
			array(
				'label'     => esc_html__( 'Image Overlay', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'wolmart-core' ),
				'label_on'  => esc_html__( 'Show', 'wolmart-core' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'lightbox',
			array(
				'label'              => esc_html__( 'Lightbox', 'wolmart-core' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'label_off'          => esc_html__( 'Off', 'wolmart-core' ),
				'label_on'           => esc_html__( 'On', 'wolmart-core' ),
				'condition'          => array(
					'show_image_overlay' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_video_style',
			array(
				'label'     => esc_html__( 'Video', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'use_as'              => 'banner',
					'video_banner_switch' => 'yes',
				),
			)
		);

		$this->add_control(
			'aspect_ratio',
			array(
				'label'              => esc_html__( 'Aspect Ratio', 'wolmart-core' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'169' => '16:9',
					'219' => '21:9',
					'43'  => '4:3',
					'32'  => '3:2',
					'11'  => '1:1',
					'916' => '9:16',
				),
				'default'            => '169',
				'prefix_class'       => 'elementor-aspect-ratio-',
				'frontend_available' => true,
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'video_css_filters',
				'selector' => '.elementor-element-{{ID}} .elementor-wrapper',
			)
		);

		$this->add_responsive_control(
			'video_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .elementor-fit-aspect-ratio' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'play_icon_title',
			array(
				'label'     => esc_html__( 'Play Icon', 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'play_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .elementor-custom-embed-play i' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'play_icon_size',
			array(
				'label'     => esc_html__( 'Size', 'wolmart-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 300,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .elementor-custom-embed-play i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'           => 'play_icon_text_shadow',
				'selector'       => '.elementor-element-{{ID}} .elementor-custom-embed-play i',
				'fields_options' => array(
					'text_shadow_type' => array(
						'label' => _x( 'Shadow', 'Text Shadow Control', 'wolmart-core' ),
					),
				),
				'condition'      => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_lightbox_style',
			array(
				'label'     => esc_html__( 'Lightbox', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'use_as'              => 'banner',
					'video_banner_switch' => 'yes',
					'show_image_overlay'  => 'yes',
					'image_overlay[url]!' => '',
					'lightbox'            => 'yes',
				),
			)
		);

		$this->add_control(
			'lightbox_color',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'#elementor-lightbox-{{ID}}' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'lightbox_ui_color',
			array(
				'label'     => esc_html__( 'UI Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'lightbox_ui_color_hover',
			array(
				'label'     => esc_html__( 'UI Hover Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button:hover' => 'color: {{VALUE}}',
				),
				'separator' => 'after',
			)
		);

		$this->add_control(
			'lightbox_video_width',
			array(
				'label'     => esc_html__( 'Content Width', 'wolmart-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'unit' => '%',
				),
				'range'     => array(
					'%' => array(
						'min' => 30,
					),
				),
				'selectors' => array(
					'(desktop+)#elementor-lightbox-{{ID}} .elementor-video-container' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'lightbox_content_position',
			array(
				'label'                => esc_html__( 'Content Position', 'wolmart-core' ),
				'type'                 => Controls_Manager::SELECT,
				'frontend_available'   => true,
				'options'              => array(
					''    => esc_html__( 'Center', 'wolmart-core' ),
					'top' => esc_html__( 'Top', 'wolmart-core' ),
				),
				'selectors'            => array(
					'#elementor-lightbox-{{ID}} .elementor-video-container' => '{{VALUE}}; transform: translateX(-50%);',
				),
				'selectors_dictionary' => array(
					'top' => 'top: 60px',
				),
			)
		);

		$this->add_responsive_control(
			'lightbox_content_animation',
			array(
				'label'              => esc_html__( 'Entrance Animation', 'wolmart-core' ),
				'type'               => Controls_Manager::ANIMATION,
				'frontend_available' => true,
			)
		);

		$this->end_controls_section();

		$this->update_control(
			'color_link',
			array(
				'selectors' => array(
					'.elementor-element-{{ID}} a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->update_control(
			'color_link_hover',
			array(
				'selectors' => array(
					'.elementor-element-{{ID}} a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_section(
			'wolmart_typography_style',
			array(
				'label' => esc_html__( 'Wolmart Typography', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'telephone_typography',
					'selector' => '.elementor-element-{{ID}}',
				)
			);

		$this->end_controls_section();
	}

	protected function content_template() {
		?>
		<#
		let content_width = '';
		let extra_class = '';
		let extra_attrs = '';
		let wrapper_class = '';
		let wrapper_attrs = '';

		// Banner
		if ( 'yes' == settings.section_content_type && settings.layout == 'boxed' ) {
			content_width = ' container-fluid';
		}

		if ( 'slider' == settings.use_as ) {
			<?php
			wolmart_elementor_grid_template();
			wolmart_elementor_slider_template();
			if ( ! $this->legacy_mode ) {
				?>
				extra_attrs += ' data-slider-class="' + extra_class + '"';
				extra_class  = '';
				<?php
			}
			?>
			settings.gap = 'no';
		} else if ( 'tab' == settings.use_as ) {
			wrapper_class += ' tab';
			settings.gap = 'no';

			if ( 'vertical' == settings.tab_type ) {
				wrapper_class += ' tab-vertical';

				switch ( settings.tab_v_type ) { // vertical tab type
					case 'simple':
						wrapper_class += ' tab-simple';
						break;
					case 'solid':
						wrapper_class += ' tab-nav-solid';
						break;
				} // in
			} else {
				switch ( settings.tab_h_type ) { // horizontal tab type
					case 'simple':
						wrapper_class += ' tab-nav-simple tab-nav-boxed';
						break;
					case 'solid1':
						wrapper_class += ' tab-nav-boxed tab-nav-solid';
						break;
					case 'solid2':
						wrapper_class += ' tab-nav-boxed tab-nav-solid tab-nav-round';
						break;
					case 'outline1':
						wrapper_class += ' tab-nav-boxed tab-nav-boxed tab-outline';
						break;
					case 'outline2':
						wrapper_class += ' tab-nav-boxed tab-nav-boxed tab-outline2';
						break;
					case 'link':
						wrapper_class += ' tab-nav-boxed tab-nav-underline';
						break;
				}

				switch ( settings.tab_navs_pos ) { // nav position
					case 'center': 
						wrapper_class += ' tab-nav-center';
						break;
					case 'right':
						wrapper_class += ' tab-nav-right';
				}
				switch ( settings.tab_navs_pos_mobile ) { // nav position
					case 'left':
						wrapper_class += ' tab-nav-sm-left';
						break;
					case 'center':
						wrapper_class += ' tab-nav-sm-center';
						break;
					case 'right':
						wrapper_class += ' tab-nav-sm-right';
				}
				switch ( settings.tab_navs_pos_tablet ) { // nav position
					case 'left':
						wrapper_class += ' tab-nav-md-left';
						break;
					case 'center':
						wrapper_class += ' tab-nav-md-center';
						break;
					case 'right':
						wrapper_class += ' tab-nav-md-right';
				}
			}
			#>
			<?php if ( $this->legacy_mode ) { ?>
				<# extra_class += ' tab-content'; #>
			<?php } ?>
			<#
		} else if ( 'accordion' == settings.use_as ) { // use as accordion
			extra_class += ' accordion';
			settings.gap = 'no';

			if( 'simple' == settings.accordion_type ) {
				extra_class += ' accordion-simple';
			} else if( 'border' == settings.accordion_type ) {
				extra_class += ' accordion-border accordion-boxed';
			} else if( 'boxed' == settings.accordion_type ) {
				extra_class += ' accordion-boxed accordion-boxed2';
			}
			extra_attrs += ' data-toggle-icon="' + settings.accordion_icon.value + '"';
			extra_attrs += ' data-toggle-active-icon="' + settings.accordion_active_icon.value + '"';
		} else if ( 'banner' == settings.use_as ) {
			extra_class += ' banner';
			settings.gap = 'no';

			if ( 'yes' == settings.parallax ) {
				var parallax_options = {
					offset: settings.parallax_offset.size ? settings.parallax_offset.size : 0,
					speed: settings.parallax_speed.size ? 10 / settings.parallax_speed.size : 1.5,
					parallaxHeight: settings.parallax_height.size ? settings.parallax_height.size + '%' : '300%',
				};
				extra_attrs += ' data-class="parallax"';
				extra_attrs += " data-image-src='" + settings.background_image.url + "' data-parallax-options='" + JSON.stringify(parallax_options) + "'";
			} else {
				extra_class += ' banner-fixed';
				if ( settings.overlay ) {
					if ( 'light' == settings.overlay ) {
						extra_class += ' overlay-light';
					}
					if ( 'dark' == settings.overlay ) {
						extra_class += ' overlay-dark';
					}
					if ( 'zoom' == settings.overlay ) {
						extra_class += ' overlay-zoom';
					}
					if ( 'zoom_light' == settings.overlay ) {
						extra_class += ' overlay-zoom overlay-light';
					}
					if ( 'zoom_dark' == settings.overlay ) {
						extra_class += ' overlay-zoom overlay-dark';
					}
				}
			}

			if ( 'yes' == settings.video_banner_switch ) {
				extra_class += ' video-banner';
			}
		} else if ( 'creative' == settings.use_as ) {
			let height = settings.creative_height.size;
			let mode = settings.creative_mode;
			let height_ratio = settings.creative_height_ratio.size;
			if ( '' == height ) {
				height = 600;
			}
			if ( '' == mode ) {
				mode = 0;
			}
			if ( ! Number(height_ratio) ) {
				height_ratio = 75;
			}

			extra_class += ' grid creative-grid gutter-' + settings.col_sp + ' grid-mode-' + mode;
			if ( settings.grid_float ) {
				extra_class += ' grid-float';
			}

			extra_attrs += ' data-creative-mode=' + mode;
			extra_attrs += ' data-creative-height=' + height;
			extra_attrs += ' data-creative-height-ratio=' + height_ratio;

			if ( 'no' == settings.col_sp ) {
				settings.gap = 'no';
			} else if ( 'xs' == settings.col_sp ) {
				settings.gap = 'no';
			} else if ( 'sm' == settings.col_sp ) {
				settings.gap = 'narrow';
			} else if ( 'md' == settings.col_sp ) {
				settings.gap = 'default';
			} else if ( 'lg' == settings.col_sp ) {
				settings.gap = 'extended';
			}

			<?php if ( $this->legacy_mode ) { ?>
				settings.gap = 'no';
			<?php } ?>
		}

		if ( settings.background_video_link ) {
			let videoAttributes = 'autoplay muted playsinline';

			if ( ! settings.background_play_once ) {
				videoAttributes += ' loop';
			}

			view.addRenderAttribute( 'background-video-container', 'class', 'elementor-background-video-container' );

			if ( ! settings.background_play_on_mobile ) {
				view.addRenderAttribute( 'background-video-container', 'class', 'elementor-hidden-mobile' );
			}
		#>
			<div {{{ view.getRenderAttributeString( 'background-video-container' ) }}}>
				<div class="elementor-background-video-embed"></div>
				<video class="elementor-background-video-hosted elementor-html5-video" {{ videoAttributes }}></video>
			</div>
		<# } #>
		<div class="elementor-background-overlay"></div>
		<div class="elementor-shape elementor-shape-top"></div>
		<div class="elementor-shape elementor-shape-bottom"></div>

		<?php if ( $this->legacy_mode ) { ?>
			<div class="elementor-container{{ content_width }} elementor-column-gap-{{ settings.gap }} {{ wrapper_class }}" {{{ wrapper_attrs }}}>
		<?php } else { ?>
			<div class="elementor-container{{ content_width }} elementor-column-gap-{{ settings.gap }} {{ wrapper_class }}{{ extra_class }}" {{{ wrapper_attrs }}} {{{ extra_attrs }}}>
		<?php } ?>

		<# if ( 'tab' == settings.use_as ) { #>
			<ul class="nav nav-tabs" role="tablist">
			</ul>
			<?php if ( ! $this->legacy_mode ) { ?>
				<div class="tab-content">
			<?php } ?>
		<# } #>
		<?php if ( $this->legacy_mode ) { ?>
			<div class="elementor-row{{ extra_class }}"{{{ extra_attrs }}}>
		<?php } ?>
		<# if ( 'banner' == settings.use_as && 'yes' != settings.parallax && settings.background_image.url ) { #>
			<figure class="banner-img" style="background-color: {{ settings.background_color }}">
				<img src="{{ settings.background_image.url }}" alt="<?php esc_attr_e( 'Banner', 'wolmart-core' ); ?>">
			</figure>
		<# } #>
		<# if ( 'yes' == settings.video_banner_switch && 'banner' == settings.use_as ) {
			view.addRenderAttribute( 'video_widget_wrapper', 'class', 'elementor-element elementor-widget-video wolmart-section-video' );
			view.addRenderAttribute( 'video_widget_wrapper', 'data-element_type', 'widget' );
			view.addRenderAttribute( 'video_widget_wrapper', 'data-widget_type', 'video.default' );
			view.addRenderAttribute( 'video_widget_wrapper', 'data-settings', JSON.stringify( settings ) );

			view.addRenderAttribute( 'video_wrapper', 'class', 'elementor-wrapper' );
			if ( settings.show_image_overlay && settings.lightbox ) {
				view.addRenderAttribute( 'video_widget_wrapper', 'style', 'position: absolute; left: 0; right: 0; top: 0; bottom: 0;' );
				view.addRenderAttribute( 'video_wrapper', 'style', 'width: 100%; height: 100%;' );
			}
			view.addRenderAttribute( 'video_wrapper', 'class', 'elementor-open-' + ( settings.show_image_overlay && settings.lightbox ? 'lightbox' : 'inline' ) );

			#>
			<div {{{ view.getRenderAttributeString( 'video_widget_wrapper' ) }}} style="position: absolute;">
				<div {{{ view.getRenderAttributeString( 'video_wrapper' ) }}}>
			<#

			let urls = {
				'youtube': settings.youtube_url,
				'vimeo': settings.vimeo_url,
				'dailymotion': settings.dailymotion_url,
				'hosted': settings.hosted_url,
				'external': settings.external_url
			};

			let video_url = urls[settings.video_type],
				video_html = '';

			if ( 'hosted' == settings.video_type ) {
				if ( settings.insert_url ) {
					video_url = urls['external']['url'];
				} else {
					video_url = urls['hosted']['url'];
				}

				if ( video_url ) {
					if ( settings.start || settings.end ) {
						video_url += '#t=';
					}

					if ( settings.start ) {
						video_url += settings.start;
					}

					if ( settings.end ) {
						video_url += ',' + settings.end;
					}
				}
			}
			if ( video_url ) {

				if ( 'hosted' == settings.video_type ) {
					var video_params = {},
						options = [ 'autoplay', 'loop', 'controls' ];

					for ( let i = 0; i < options.length; i ++ ) {
						if ( settings[ 'video_' + options[i] ] ) {
							video_params[ options[i] ] = '';
						}
					}

					if ( settings.video_autoplay ) {
						video_params['autoplay'] = '';
					}
					if ( settings.video_loop ) {
						video_params['loop'] = '';
					}
					if ( settings.video_controls ) {
						video_params['controls'] = '';
					}

					if ( settings.video_mute ) {
						video_params.muted = 'muted';
					}

					view.addRenderAttribute( 'video_tag', 'src', video_url );

					let param_keys = Object.keys( video_params );

					for ( let i = 0; i < param_keys.length; i ++ ) {
						view.addRenderAttribute( 'video_tag', param_keys[i], video_params[param_keys[i]] );
					}
					if ( ! settings.show_image_overlay || ! settings.lightbox ) {
						#>
						<video {{{ view.getRenderAttributeString( 'video_tag' ) }}}></video>
						<#
					}

				} else {
					view.addRenderAttribute( 'video_tag', 'src', video_url );
					if ( ! settings.show_image_overlay || ! settings.lightbox ) {
						#>
						<iframe {{{ view.getRenderAttributeString( 'video_tag' ) }}}></iframe>
						<#
					}
				}

				if ( settings.background_image.url && 'yes' == settings.show_image_overlay ) {
						view.addRenderAttribute( 'image-overlay', 'class', 'elementor-custom-embed-image-overlay' );

						if ( settings.show_image_overlay && settings.lightbox ) {
							let lightbox_url = video_url,
								lightbox_options = {};

							lightbox_options = {
								'type'        : 'video',
								'videoType'   : settings.video_type,
								'url'         : lightbox_url,
								'modalOptions': {
									'entranceAnimation'       : settings.lightbox_content_animation,
									'entranceAnimation_tablet': settings.lightbox_content_animation_tablet,
									'entranceAnimation_mobile': settings.lightbox_content_animation_mobile,
									'videoAspectRatio'        : settings.aspect_ratio,
								},
							};

							if ( 'hosted' == settings.video_type ) {
								lightbox_options['videoParams'] = video_params;
							}

							view.addRenderAttribute( 'image-overlay', 'data-elementor-open-lightbox', 'yes' );
							view.addRenderAttribute( 'image-overlay', 'data-elementor-lightbox', JSON.stringify( lightbox_options ) );
							view.addRenderAttribute( 'image-overlay-lightbox', 'src', settings.background_image.url );

						} else {
							view.addRenderAttribute( 'image-overlay', 'style', 'background-image: url(' + settings.background_image.url + ');' );
						}

						#>
						<div {{{ view.getRenderAttributeString( 'image-overlay' ) }}}>
							<# if ( settings.show_image_overlay && settings.lightbox ) { #>
								<img {{{ view.getRenderAttributeString( 'image-overlay-lightbox' ) }}}>
							<# } #>
							<# if ( 'yes' == settings.show_play_icon ) { #>
								<div class="elementor-custom-embed-play" role="button">
									<i class="eicon-play" aria-hidden="true"></i>
									<span class="elementor-screen-only"></span>
								</div>
							<# } #>
						</div>
						<#
					}
				}
				#>
				</div>
			</div>
		<# } #>
		<?php
		if ( $this->legacy_mode ) {
			echo '</div>';
		}
		?>
		</div>

		<?php if ( $this->legacy_mode ) { ?>
		<# if( 'slider' == settings.use_as && 'thumb' == settings.dots_type ) { #>
			<div class="slider-thumb-dots dots-bordered slider-thumb-dots-{{{view.getID()}}}">
			<#
				if ( settings.thumbs.length ) {
					settings.thumbs.map(function(img) {
					#>
						<button class="slider-pagination-bullet">
							<img src="{{{img['url']}}}">
						</button>
					<#
					});
				}
			#>
			</div>
		<# } #>
		<?php } ?>

		<?php
		if ( ! $this->legacy_mode ) {
			?>
			<# if( 'slider' == settings.use_as && 'thumb' == settings.dots_type ) { #>
				<div class="slider-thumb-dots dots-bordered slider-thumb-dots-{{{view.getID()}}}">
				<#
					if ( settings.thumbs.length ) {
						settings.thumbs.map(function(img) {
						#>
							<button class="slider-pagination-bullet">
								<img src="{{{img['url']}}}">
							</button>
						<#
						});
					}
				#>
				</div>
			<# } #>
			<?php
		}
	}

	public function before_render() {
		$settings = $this->get_settings_for_display();

		global $wolmart_section;
		?>
		<<?php echo esc_html( $this->get_html_tag() ); ?> <?php $this->print_render_attribute_string( '_wrapper' ); ?>>
			<?php
			if ( 'video' == $settings['background_background'] ) :
				if ( $settings['background_video_link'] ) :
					$video_properties = Embed::get_video_properties( $settings['background_video_link'] );

					$this->add_render_attribute( 'background-video-container', 'class', 'elementor-background-video-container' );

					if ( ! $settings['background_play_on_mobile'] ) {
						$this->add_render_attribute( 'background-video-container', 'class', 'elementor-hidden-mobile' );
					}
					?>
					<div <?php $this->print_render_attribute_string( 'background-video-container' ); ?>>
						<?php if ( $video_properties ) : ?>
							<div class="elementor-background-video-embed"></div>
							<?php
						else :
							$video_tag_attributes = 'autoplay muted playsinline';
							if ( 'yes' !== $settings['background_play_once'] ) :
								$video_tag_attributes .= ' loop';
							endif;
							?>
							<video class="elementor-background-video-hosted elementor-html5-video" <?php echo $video_tag_attributes; ?>></video>
						<?php endif; ?>
					</div>
					<?php
				endif;
			endif;

			$has_background_overlay = in_array( $settings['background_overlay_background'], array( 'classic', 'gradient' ), true ) ||
									in_array( $settings['background_overlay_hover_background'], array( 'classic', 'gradient' ), true );

			if ( $has_background_overlay ) :
				?>
				<div class="elementor-background-overlay"></div>
				<?php
			endif;

			if ( $settings['shape_divider_top'] ) {
				$this->print_shape_divider( 'top' );
			}

			if ( $settings['shape_divider_bottom'] ) {
				$this->print_shape_divider( 'bottom' );
			}

			// Additional Settings
			$extra_class  = '';
			$extra_attrs  = '';
			$slider_class = '';
			$slider_attrs = '';

			if ( isset( $settings['use_as'] ) ) {
				if ( 'creative' === $settings['use_as'] ) { // if using as creative grid
					$extra_class .= ' grid creative-grid gutter-' . $settings['col_sp'] . ' grid-mode-' . $settings['creative_mode'];

					if ( 'yes' == $settings['grid_float'] ) {
						$extra_class .= ' grid-float';
					} else {
						wp_enqueue_script( 'isotope-pkgd' );

						$extra_attrs .= " data-creative-breaks='" . json_encode(
							array(
								'md' => wolmart_get_breakpoints( 'md' ),
								'lg' => wolmart_get_breakpoints( 'lg' ),
							)
						) . "'";
					}

					if ( 'no' == $settings['col_sp'] ) {
						$settings['gap'] = 'no';
					} elseif ( 'xs' == $settings['col_sp'] ) {
						$settings['gap'] = 'no';
					} elseif ( 'sm' == $settings['col_sp'] ) {
						$settings['gap'] = 'narrow';
					} elseif ( 'md' == $settings['col_sp'] ) {
						$settings['gap'] = 'default';
					} elseif ( 'lg' == $settings['col_sp'] ) {
						$settings['gap'] = 'extended';
					}

					global $wolmart_section;
					wolmart_creative_layout_style(
						'.elementor-element-' . $this->get_data( 'id' ),
						$wolmart_section['layout'],
						$settings['creative_height']['size'] ? $settings['creative_height']['size'] : 600,
						$settings['creative_height_ratio']['size'] ? $settings['creative_height_ratio']['size'] : 75
					);

					if ( $this->legacy_mode ) {
						$settings['gap'] = 'no';
					}
				} elseif ( 'slider' === $settings['use_as'] ) { // if using as slider

					$col_cnt = wolmart_elementor_grid_col_cnt( $settings );

					$slider_class .= ' ' . wolmart_get_col_class( $col_cnt );
					$slider_class .= ' ' . wolmart_get_grid_space_class( $settings );
					$slider_class .= ' ' . wolmart_get_slider_class( $settings );
					$slider_attrs .= ' data-slider-options="' . esc_attr(
						json_encode(
							wolmart_get_slider_attrs( $settings, $col_cnt, $this->get_data( 'id' ) )
						)
					) . '"';

					if ( $this->legacy_mode ) {
						$extra_class .= $slider_class;
						$extra_attrs .= $slider_attrs;
					}

					$settings['gap'] = 'no';

				} elseif ( 'banner' === $settings['use_as'] ) { // if using as banner
					$extra_class    .= ' banner';
					$settings['gap'] = 'no';

					if ( 'yes' == $settings['parallax'] ) { // if parallax
						wp_enqueue_script( 'jquery-parallax' );
					} else {
						if ( $settings['overlay'] ) {
							$extra_class .= ' ' . wolmart_get_overlay_class( $settings['overlay'] );
						}
						$extra_class .= ' banner-fixed';
					}

					if ( 'yes' == $settings['video_banner_switch'] ) {
						$extra_class .= ' video-banner';
					}
				} elseif ( 'tab' === $settings['use_as'] ) { // if using as tab
					$extra_class    .= ' tab';
					$settings['gap'] = 'no';

					if ( 'vertical' == $settings['tab_type'] ) {
						$extra_class .= ' tab-vertical';

						switch ( $settings['tab_v_type'] ) { // vertical tab type
							case 'simple':
								$extra_class .= ' tab-simple';
								break;
							case 'solid':
								$extra_class .= ' tab-nav-solid';
								break;
						}
					} else {
						switch ( $settings['tab_h_type'] ) { // horizontal tab type
							case 'simple':
								$extra_class .= ' tab-nav-simple tab-nav-boxed';
								break;
							case 'solid1':
								$extra_class .= ' tab-nav-boxed tab-nav-solid';
								break;
							case 'solid2':
								$extra_class .= ' tab-nav-boxed tab-nav-solid tab-nav-round';
								break;
							case 'outline1':
								$extra_class .= ' tab-nav-boxed tab-nav-boxed tab-outline';
								break;
							case 'outline2':
								$extra_class .= ' tab-nav-boxed tab-nav-boxed tab-outline2';
								break;
							case 'link':
								$extra_class .= ' tab-nav-boxed tab-nav-underline';
								break;
						}
						switch ( $settings['tab_navs_pos'] ) { // nav position
							case 'center':
								$extra_class .= ' tab-nav-center';
								break;
							case 'right':
								$extra_class .= ' tab-nav-right';
						}
						switch ( $settings['tab_navs_pos_mobile'] ) { // nav position
							case 'left':
								$extra_class .= ' tab-nav-sm-left';
								break;
							case 'center':
								$extra_class .= ' tab-nav-sm-center';
								break;
							case 'right':
								$extra_class .= ' tab-nav-sm-right';
						}
						switch ( $settings['tab_navs_pos_tablet'] ) { // nav position
							case 'left':
								$extra_class .= ' tab-nav-md-left';
								break;
							case 'center':
								$extra_class .= ' tab-nav-md-center';
								break;
							case 'right':
								$extra_class .= ' tab-nav-md-right';
						}
					}
				} elseif ( 'accordion' === $settings['use_as'] ) { // if using as accordion
					$extra_class    .= ' accordion';
					$settings['gap'] = 'no';

					if ( 'simple' == $settings['accordion_type'] ) {
						$extra_class .= ' accordion-simple';
					} elseif ( 'border' == $settings['accordion_type'] ) {
						$extra_class .= ' accordion-boxed accordion-border';
					} elseif ( 'boxed' == $settings['accordion_type'] ) {
						$extra_class .= ' accordion-boxed accordion-boxed2';
					}
				}
			}
			?>
			<?php if ( $this->legacy_mode ) { ?>
				<div class="<?php echo esc_attr( 'yes' == $settings['section_content_type'] ? 'elementor-container container-fluid' : 'elementor-container' ); ?> elementor-column-gap-<?php echo esc_attr( $settings['gap'] ) . ( 'tab' == $settings['use_as'] ? esc_attr( $extra_class ) : '' ) . ( ( 'slider' == $settings['use_as'] && 'thumb' == $settings['dots_type'] ) ? ' flex-wrap' : '' ); ?>">
			<?php } else { ?>
				<div class="<?php echo esc_attr( 'yes' == $settings['section_content_type'] ? 'elementor-container container-fluid' : 'elementor-container' ); ?> elementor-column-gap-<?php echo esc_attr( $settings['gap'] ) . esc_attr( $extra_class ); ?>" <?php echo wolmart_strip_script_tags( $extra_attrs ); ?>>
				<?php } if ( 'tab' == $settings['use_as'] ) : // add tab navs ?>
					<ul class="nav nav-tabs">
					<?php foreach ( $wolmart_section['tab_data'] as $idx => $data ) : ?>
						<li class="nav-item"><a class="nav-link<?php echo esc_attr( 0 == $idx ? ' active' : '' ); ?>" href="<?php echo esc_attr( $data['id'] ); ?>"><?php echo esc_html( $data['title'] ); ?></a></li>
					<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php if ( $this->legacy_mode ) { ?>
					<div class="elementor-row<?php echo 'tab' == $settings['use_as'] ? ' tab-content' : esc_attr( $extra_class ); ?>"<?php echo wolmart_strip_script_tags( $extra_attrs ); ?>>
					<?php
				} elseif ( 'tab' == $settings['use_as'] ) {
					echo '<div class="tab-content">';
				} elseif ( 'slider' == $settings['use_as'] ) {
					?>
					<div class="<?php echo esc_attr( $slider_class ); ?>" <?php echo wolmart_strip_script_tags( $slider_attrs ); ?>>
					<?php
				}
				if ( 'banner' == $settings['use_as'] && 'yes' != $settings['parallax'] && isset( $settings['background_image'] ) ) :
					$banner_img_id = $settings['background_image']['id'];
					if ( $banner_img_id ) {
						?>
					<figure class="banner-img"
						<?php if ( $settings['background_color'] ) : ?>
							style="background-color:<?php echo esc_attr( $settings['background_color'] ); ?>"
						<?php endif; ?>>
						<?php
						$content = wp_get_attachment_image(
							$banner_img_id,
							'full',
							false,
							$settings['background_color'] ? array( 'style' => 'background-color:' . $settings['background_color'] ) : ''
						);
						echo class_exists( 'Wolmart_LazyLoad_Images' ) ? Wolmart_LazyLoad_Images::add_image_placeholders( $content ) : $content;
						?>
					</figure>
						<?php
					}
				endif;
				if ( 'yes' == $settings['video_banner_switch'] ) :

					$video_url = $settings[ $settings['video_type'] . '_url' ];

					if ( 'hosted' == $settings['video_type'] ) {
						$video_url = $this->get_hosted_video_url();
					}

					if ( empty( $video_url ) ) {
						return;
					}

					if ( 'hosted' == $settings['video_type'] ) {
						ob_start();

						$this->render_hosted_video();

						$video_html = ob_get_clean();
					} else {
						$embed_params = $this->get_embed_params();

						$embed_options = $this->get_embed_options();

						$video_html = Embed::get_embed_html( $video_url, $embed_params, $embed_options );
					}

					if ( empty( $video_html ) ) {
						echo esc_url( $video_url );

						return;
					}

					$this->add_render_attribute( 'video_widget_wrapper', 'class', 'elementor-element elementor-widget-video wolmart-section-video' );
					$this->add_render_attribute( 'video_widget_wrapper', 'data-element_type', 'widget' );
					$this->add_render_attribute( 'video_widget_wrapper', 'data-widget_type', 'video.default' );
					$this->add_render_attribute( 'video_widget_wrapper', 'data-settings', wp_json_encode( $this->get_frontend_settings() ) );

					$this->add_render_attribute( 'video_wrapper', 'class', 'elementor-wrapper' );

					$this->add_render_attribute( 'video_wrapper', 'class', 'elementor-open-' . ( $settings['lightbox'] ? 'lightbox' : 'inline' ) );
					?>


					<div <?php $this->print_render_attribute_string( 'video_widget_wrapper' ); ?>>
						<div <?php $this->print_render_attribute_string( 'video_wrapper' ); ?>>
							<?php
							if ( ! $settings['lightbox'] ) {
								echo $video_html; // XSS ok.
							}
							global $wolmart_section;
							if ( $this->has_image_overlay() ) {
								if ( ! $settings['lightbox'] && isset( $wolmart_section['video_btn'] ) ) {
									$this->add_render_attribute( 'background_image', 'class', 'elementor-custom-embed-image-overlay no-event' );
								} else {
									$this->add_render_attribute( 'background_image', 'class', 'elementor-custom-embed-image-overlay' );
								}

								if ( $settings['lightbox'] ) {
									if ( ! isset( $wolmart_section['video_btn'] ) ) {
										if ( 'hosted' == $settings['video_type'] ) {
											$lightbox_url = $video_url;
										} else {
											$lightbox_url = Embed::get_embed_url( $video_url, $embed_params, $embed_options );
										}

										$lightbox_options = $wolmart_section['lightbox'];

										$this->add_render_attribute(
											'background_image',
											array(
												'data-elementor-open-lightbox' => 'yes',
												'data-elementor-lightbox' => wp_json_encode( $lightbox_options ),
											)
										);

										if ( Plugin::$instance->editor->is_edit_mode() ) {
											$this->add_render_attribute(
												'background_image',
												array(
													'class' => 'elementor-clickable',
												)
											);
										}
									}
								} else {
									$image_overlay = wp_get_attachment_image_src( $settings['background_image']['id'], 'full' );
									$this->add_render_attribute( 'background_image', 'style', 'background-image: url(' . $image_overlay[0] . ');' );
								}
								?>
								<div <?php $this->print_render_attribute_string( 'background_image' ); ?>>
									<?php
									if ( $settings['lightbox'] && ! isset( $wolmart_section['video_btn'] ) ) {
										?>
										<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'background_image' ); ?>
									<?php } ?>
								</div>
							<?php } ?>

					<?php
				endif;
	}

	public function after_render() {
		$settings = $this->get_settings_for_display();

		if ( 'creative' == $settings['use_as'] ) {
			unset( $GLOBALS['wolmart_section'] );
			echo '<div class="grid-space"></div>';
		}
		if ( 'accordion' == $settings['use_as'] ) {
			unset( $GLOBALS['wolmart_section'] );
		}
		?>
				<?php if ( 'yes' == $settings['video_banner_switch'] ) : ?>
					</div>
					</div>
				<?php endif; ?>
				<?php if ( true == $this->legacy_mode ) { ?>
					</div>
					<?php
				} elseif ( 'tab' == $settings['use_as'] ) {
					echo '</div>';
				}
				if ( 'slider' != $settings['use_as'] || 'thumb' != $settings['dots_type'] || $this->legacy_mode ) {
					?>
					</div>
					<?php
				}
				if ( ! $this->legacy_mode && 'slider' == $settings['use_as'] ) {
					?>
					</div>
					<?php
				}
				if ( 'slider' == $settings['use_as'] && 'thumb' == $settings['dots_type'] ) {
					if ( ! $this->legacy_mode ) {
						?>
					</div>
						<?php
					}
					?>
					<div class="slider-thumb-dots dots-bordered <?php echo 'slider-thumb-dots-' . esc_attr( $this->get_data( 'id' ) ); ?>">
						<?php
						if ( count( $settings['thumbs'] ) ) {
							$first = true;
							foreach ( $settings['thumbs'] as $thumb ) {
								echo '<button class="slider-pagination-bullet' . ( $first ? ' active' : '' ) . '">';
								echo wp_get_attachment_image( $thumb['id'] );
								echo '</button>';
								$first = false;
							}
						}
						?>
					</div>
					<?php
				}
				?>
		</<?php echo esc_html( $this->get_html_tag() ); ?>>
		<?php
	}

	public function get_embed_params() {
		$settings = $this->get_settings_for_display();

		$params = array();

		if ( $settings['video_autoplay'] && ! $this->has_image_overlay() ) {
			$params['autoplay'] = '1';
		}

		$params_dictionary = array();

		if ( 'youtube' == $settings['video_type'] ) {
			$params_dictionary = array(
				'video_loop',
				'video_controls',
				'video_mute',
				'rel',
				'modestbranding',
			);

			if ( $settings['video_loop'] ) {
				$video_properties = Embed::get_video_properties( $settings['youtube_url'] );

				$params['playlist'] = $video_properties['video_id'];
			}

			$params['wmode'] = 'opaque';
		} elseif ( 'vimeo' == $settings['video_type'] ) {
			$params_dictionary = array(
				'video_loop',
				'video_mute'     => 'muted',
				'vimeo_title'    => 'title',
				'vimeo_portrait' => 'portrait',
				'vimeo_byline'   => 'byline',
			);

			$params['color'] = str_replace( '#', '', $settings['color'] );

			$params['autopause'] = '0';
		} elseif ( 'dailymotion' == $settings['video_type'] ) {
			$params_dictionary = array(
				'video_controls',
				'video_mute',
				'showinfo' => 'ui-start-screen-info',
				'logo'     => 'ui-logo',
			);

			$params['ui-highlight'] = str_replace( '#', '', $settings['color'] );

			$params['start'] = $settings['start'];

			$params['endscreen-enable'] = '0';
		}

		foreach ( $params_dictionary as $key => $param_name ) {
			$setting_name = $param_name;

			if ( is_string( $key ) ) {
				$setting_name = $key;
			}

			$setting_value = $settings[ $setting_name ] ? '1' : '0';

			$params[ $param_name ] = $setting_value;
		}

		return $params;
	}

	/**
	 * Whether the video has an overlay image or not.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function has_image_overlay() {
		$settings = $this->get_settings_for_display();

		return ! empty( $settings['background_image']['url'] ) && 'yes' == $settings['show_image_overlay'];
	}

	/**
	 * @since 1.0
	 * @access private
	 */
	public function get_embed_options() {
		$settings = $this->get_settings_for_display();

		$embed_options = array();

		if ( 'youtube' == $settings['video_type'] ) {
			$embed_options['privacy'] = $settings['yt_privacy'];
		} elseif ( 'vimeo' == $settings['video_type'] ) {
			$embed_options['start'] = $settings['start'];
		}

		$embed_options['lazy_load'] = ! empty( $settings['lazy_load'] );

		return $embed_options;
	}

	/**
	 * @since 1.0
	 * @access private
	 */
	public function get_hosted_params() {
		$settings = $this->get_settings_for_display();

		$video_params = array();

		foreach ( array( 'autoplay', 'loop', 'controls' ) as $option_name ) {
			if ( $settings[ 'video_' . $option_name ] ) {
				$video_params[ $option_name ] = '';
			}
		}

		if ( $settings['video_mute'] ) {
			$video_params['muted'] = 'muted';
		}

		return $video_params;
	}

	/**
	 * Returns video url
	 *
	 * @since 1.0
	 */
	public function get_hosted_video_url() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['insert_url'] ) ) {
			$video_url = $settings['external_url']['url'];
		} else {
			$video_url = $settings['hosted_url']['url'];
		}

		if ( empty( $video_url ) ) {
			return '';
		}

		return $video_url;
	}

	/**
	 * @since 1.0
	 * @access private
	 */
	public function render_hosted_video() {
		$video_url = $this->get_hosted_video_url();
		if ( empty( $video_url ) ) {
			return;
		}

		$video_params = $this->get_hosted_params();
		?>
		<video class="elementor-video" src="<?php echo esc_url( $video_url ); ?>" <?php echo Utils::render_html_attributes( $video_params ); ?>></video>
		<?php
	}
}

if ( ! function_exists( 'wolmart_section_render_attributes' ) ) {
	/**
	 * Add render attributes for sections.
	 *
	 * @since 1.0
	 */
	function wolmart_section_render_attributes( $self ) {
		$settings = $self->get_settings_for_display();
		$options  = array( 'class' => '' );

		if ( 'creative' == $settings['use_as'] ) { // if creative grid
			global $wolmart_section;
			$wolmart_section = array(
				'section' => 'creative',
				'preset'  => wolmart_creative_layout( $settings['creative_mode'] ),
				'layout'  => array(), // layout of children
				'index'   => 0, // index of children
				'top'     => $self->get_data( 'isInner' ), // check if the column is direct child of this section
			);
		} elseif ( 'slider' == $settings['use_as'] ) {
			if ( 'thumb' == $settings['dots_type'] ) {
				$options['class'] = 'flex-wrap';
			}
		} elseif ( 'banner' == $settings['use_as'] ) {
			if ( 'yes' == $settings['parallax'] ) {
				$options['class'] = 'background-none';
			}
			if ( 'yes' == $settings['parallax'] ) {
				$options['class']                .= ' parallax';
				$options['data-image-src']        = esc_url( $settings['background_image']['url'] );
				$parallax_options                 = array(
					'speed'          => $settings['parallax_speed']['size'] ? 10 / $settings['parallax_speed']['size'] : 1.5,
					'parallaxHeight' => $settings['parallax_height']['size'] ? $settings['parallax_height']['size'] . '%' : '300%',
					'offset'         => $settings['parallax_offset']['size'] ? $settings['parallax_offset']['size'] : 0,
				);
				$options['data-parallax-options'] = json_encode( $parallax_options );
				$options['data-plugin']           = 'parallax';
			} else {
				$options['class'] .= ' background-trans';
			}
		} elseif ( 'tab' == $settings['use_as'] ) {
			global $wolmart_section;
			$wolmart_section = array(
				'section'  => 'tab',
				'index'    => 0,
				'tab_data' => array(),
			);
		} elseif ( 'accordion' == $settings['use_as'] ) {
			global $wolmart_section;

			if ( ! isset( $wolmart_section['section'] ) ) {
				$wolmart_section = array(
					'section'     => 'accordion',
					'parent_id'   => $self->get_data( 'id' ),
					'index'       => 0,
					'icon'        => $settings['accordion_icon'],
					'active_icon' => $settings['accordion_active_icon'],
				);
			}
		} elseif ( $settings['background_image'] && $settings['background_image']['url'] && function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'lazyload' ) ) { // Lazyload background image
			if ( ! is_admin() && ! is_customize_preview() && ! wolmart_doing_ajax() && 'banner' != $settings['use_as'] ) {
				if ( ! $settings['background_color'] ) {
					$options['style'] = 'background-color:' . wolmart_get_option( 'lazyload_bg' ) . ';';
				}
				$options['data-lazy'] = esc_url( $settings['background_image']['url'] );
			}
		}

		if ( 'yes' == $settings['video_banner_switch'] ) {
			global $wolmart_section;
			$wolmart_section['video'] = true;
			if ( 'yes' == $settings['lightbox'] ) {

				$video_url = $settings[ $settings['video_type'] . '_url' ];

				if ( 'hosted' == $settings['video_type'] ) {
					$video_url = $self->get_hosted_video_url();
				}
				if ( 'hosted' != $settings['video_type'] ) {
					$embed_params  = $self->get_embed_params();
					$embed_options = $self->get_embed_options();
				}
				if ( 'hosted' == $settings['video_type'] ) {
					$lightbox_url = $video_url;
				} else {
					$lightbox_url = Embed::get_embed_url( $video_url, $embed_params, $embed_options );
				}

				$lightbox_options = array(
					'type'         => 'video',
					'videoType'    => $settings['video_type'],
					'url'          => $lightbox_url,
					'modalOptions' => array(
						'id'                       => 'elementor-lightbox-' . $self->get_id(),
						'entranceAnimation'        => $settings['lightbox_content_animation'],
						'entranceAnimation_tablet' => $settings['lightbox_content_animation_tablet'],
						'entranceAnimation_mobile' => $settings['lightbox_content_animation_mobile'],
						'videoAspectRatio'         => $settings['aspect_ratio'],
					),
				);

				if ( 'hosted' == $settings['video_type'] ) {
					$lightbox_options['videoParams'] = $self->get_hosted_params();
				}
				$wolmart_section['lightbox'] = $lightbox_options;
			}
		}

		if ( isset( $settings['section_content_sticky'] ) && $settings['section_content_sticky'] ) {
			$options['class'] .= ' sticky-content fix-top';
		}
		if ( isset( $settings['section_content_sticky_auto'] ) && $settings['section_content_sticky_auto'] ) {
			$options['data-sticky-options'] = '{\'scrollMode\': true}';
		}

		$self->add_render_attribute(
			array(
				'_wrapper' => $options,
			)
		);
	}
}
