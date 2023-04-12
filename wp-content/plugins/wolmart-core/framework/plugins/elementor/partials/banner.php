<?php
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

/**
 * Register banner controls.
 */
function wolmart_elementor_banner_controls( $self, $mode = '' ) {

	$self->start_controls_section(
		'section_banner',
		array(
			'label' => esc_html__( 'Banner', 'wolmart-core' ),
		)
	);

	if ( 'insert_number' == $mode ) {
		$self->add_control(
			'banner_insert',
			array(
				'label'   => esc_html__( 'Banner Index', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'1'    => '1',
					'2'    => '2',
					'3'    => '3',
					'4'    => '4',
					'5'    => '5',
					'6'    => '6',
					'7'    => '7',
					'8'    => '8',
					'9'    => '9',
					'last' => esc_html__( 'At last', 'wolmart-core' ),
				),
			)
		);
	}

	$repeater = new Repeater();

	$repeater->start_controls_tabs( 'tabs_banner_btn_cat' );

		$repeater->start_controls_tab(
			'tab_banner_content',
			array(
				'label' => esc_html__( 'Content', 'wolmart-core' ),
			)
		);

			$repeater->add_control(
				'banner_item_type',
				array(
					'label'   => esc_html__( 'Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'text',
					'options' => array(
						'text'    => esc_html__( 'Text', 'wolmart-core' ),
						'button'  => esc_html__( 'Button', 'wolmart-core' ),
						'image'   => esc_html__( 'Image', 'wolmart-core' ),
						'divider' => esc_html__( 'Divider', 'wolmart-core' ),
					),
				)
			);

			/* Text Item */
			$repeater->add_control(
				'banner_text_content',
				array(
					'label'     => esc_html__( 'Content', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXTAREA,
					'default'   => esc_html__( 'Add Your Text Here', 'wolmart-core' ),
					'condition' => array(
						'banner_item_type' => 'text',
					),
				)
			);

			$repeater->add_control(
				'banner_text_tag',
				array(
					'label'     => esc_html__( 'Tag', 'wolmart-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'h2',
					'options'   => array(
						'h1'   => esc_html__( 'H1', 'wolmart-core' ),
						'h2'   => esc_html__( 'H2', 'wolmart-core' ),
						'h3'   => esc_html__( 'H3', 'wolmart-core' ),
						'h4'   => esc_html__( 'H4', 'wolmart-core' ),
						'h5'   => esc_html__( 'H5', 'wolmart-core' ),
						'h6'   => esc_html__( 'H6', 'wolmart-core' ),
						'p'    => esc_html__( 'p', 'wolmart-core' ),
						'div'  => esc_html__( 'div', 'wolmart-core' ),
						'span' => esc_html__( 'span', 'wolmart-core' ),
					),
					'condition' => array(
						'banner_item_type' => 'text',
					),
				)
			);

			/* Button */
			$repeater->add_control(
				'banner_btn_text',
				array(
					'label'     => esc_html__( 'Text', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => esc_html__( 'Click here', 'wolmart-core' ),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_link',
				array(
					'label'     => esc_html__( 'Link Url', 'wolmart-core' ),
					'type'      => Controls_Manager::URL,
					'default'   => array(
						'url' => '',
					),
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			wolmart_elementor_button_layout_controls( $repeater, 'banner_item_type', 'button' );

			/* Image */
			$repeater->add_control(
				'banner_image',
				array(
					'label'     => esc_html__( 'Choose Image', 'wolmart-core' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'condition' => array(
						'banner_item_type' => 'image',
					),
				)
			);

			$repeater->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'      => 'banner_image',
					'default'   => 'full',
					'separator' => 'none',
					'condition' => array(
						'banner_item_type' => 'image',
					),
				)
			);

			$repeater->add_control(
				'img_link_to',
				array(
					'label'     => esc_html__( 'Link', 'wolmart-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'none',
					'options'   => array(
						'none'   => esc_html__( 'None', 'wolmart-core' ),
						'custom' => esc_html__( 'Custom URL', 'wolmart-core' ),
					),
					'condition' => array(
						'banner_item_type' => 'image',
					),
				)
			);

			$repeater->add_control(
				'img_link',
				array(
					'label'       => esc_html__( 'Link', 'wolmart-core' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'wolmart-core' ),
					'condition'   => array(
						'img_link_to'      => 'custom',
						'banner_item_type' => 'image',
					),
					'show_label'  => false,
				)
			);

			$repeater->add_responsive_control(
				'banner_divider_width',
				array(
					'label'     => esc_html__( 'Width', 'wolmart-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 50,
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'condition' => array(
						'banner_item_type' => 'divider',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'width: {{SIZE}}px',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_divider_height',
				array(
					'label'     => esc_html__( 'Height', 'wolmart-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 4,
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'condition' => array(
						'banner_item_type' => 'divider',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'border-top-width: {{SIZE}}px',
					),
				)
			);

			$repeater->add_control(
				'banner_item_display',
				array(
					'label'     => esc_html__( 'Inline Item', 'wolmart-core' ),
					'separator' => 'before',
					'type'      => Controls_Manager::SWITCHER,
				)
			);

			$repeater->add_control(
				'banner_item_aclass',
				array(
					'label' => esc_html__( 'Custom Class', 'wolmart-core' ),
					'type'  => Controls_Manager::TEXT,
				)
			);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_banner_style',
			array(
				'label' => esc_html__( 'Style', 'wolmart-core' ),
			)
		);

			$repeater->add_control(
				'banner_text_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						'banner_item_type' => 'text',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
					),
				)
			);
			$repeater->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'banner_text_typo',
					'scheme'    => Typography::TYPOGRAPHY_4,
					'condition' => array(
						'banner_item_type!' => array( 'image', 'divider' ),
					),
					'selector'  => '.elementor-element-{{ID}} {{CURRENT_ITEM}}',
				)
			);

			$repeater->add_control(
				'divider_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						'banner_item_type' => 'divider',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'border-color: {{VALUE}};',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_image_width',
				array(
					'label'      => esc_html__( 'Width', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'%',
					),
					'condition'  => array(
						'banner_item_type' => 'image',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner-item{{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_btn_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'condition'  => array(
						'banner_item_type!' => 'text',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_btn_border_width',
				array(
					'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'condition'  => array(
						'banner_item_type' => 'button',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_item_margin',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_item_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default'    => array(
						'unit' => 'px',
					),
					'condition'  => array(
						'banner_item_type!' => 'divider',
					),
					'size_units' => array( 'px', 'em', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$repeater->add_responsive_control(
				'_animation',
				array(
					'label'              => esc_html__( 'Entrance Animation', 'wolmart-core' ),
					'type'               => Controls_Manager::ANIMATION,
					'frontend_available' => true,
					'separator'          => 'before',
				)
			);

			$repeater->add_control(
				'animation_duration',
				array(
					'label'        => esc_html__( 'Animation Duration', 'wolmart-core' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						'slow' => esc_html__( 'Slow', 'wolmart-core' ),
						''     => esc_html__( 'Normal', 'wolmart-core' ),
						'fast' => esc_html__( 'Fast', 'wolmart-core' ),
					),
					'prefix_class' => 'animated-',
					'condition'    => array(
						'_animation!' => '',
					),
				)
			);

			$repeater->add_control(
				'_animation_delay',
				array(
					'label'              => esc_html__( 'Animation Delay', 'wolmart-core' ) . ' (ms)',
					'type'               => Controls_Manager::NUMBER,
					'default'            => '',
					'min'                => 0,
					'step'               => 100,
					'condition'          => array(
						'_animation!' => '',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

		$repeater->end_controls_tab();

	$repeater->end_controls_tabs();

	$presets = array(
		array(
			'banner_item_type'    => 'text',
			'banner_item_display' => '',
			'banner_text_content' => esc_html__( 'This is a simple banner', 'wolmart-core' ),
			'banner_text_tag'     => 'h3',
		),
		array(
			'banner_item_type'    => 'text',
			'banner_item_display' => '',
			'banner_text_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nummy nibh <br/>euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'wolmart-core' ),
			'banner_text_tag'     => 'p',
		),
		array(
			'banner_item_type'    => 'button',
			'banner_item_display' => 'yes',
			'banner_btn_text'     => esc_html__( 'Click here', 'wolmart-core' ),
			'button_type'         => '',
			'button_skin'         => 'btn-white',
		),
	);

	$self->add_control(
		'banner_background_heading',
		array(
			'label' => esc_html__( 'Background', 'wolmart-core' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$self->add_control(
		'banner_background_color',
		array(
			'label'     => esc_html__( 'Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#eee',
			'selectors' => array(
				'.elementor-element-{{ID}} .banner' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'banner_background_image',
		array(
			'label'   => esc_html__( 'Choose Image', 'wolmart-core' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => array(
				'url' => defined( 'WOLMART_ASSETS' ) ? ( WOLMART_ASSETS . '/images/placeholders/banner-placeholder.jpg' ) : \Elementor\Utils::get_placeholder_image_src(),
			),
		)
	);

	$self->add_control(
		'banner_items_heading',
		array(
			'label'     => esc_html__( 'Content', 'wolmart-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'banner_text_color',
		array(
			'label'     => esc_html__( 'Color', 'wolmart-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .banner' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_responsive_control(
		'banner_text_align',
		array(
			'label'     => esc_html__( 'Text Align', 'wolmart-core' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'center',
			'options'   => array(
				'left'    => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'eicon-text-align-left',
				),
				'center'  => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
					'icon'  => 'eicon-text-align-center',
				),
				'right'   => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'eicon-text-align-right',
				),
				'justify' => array(
					'title' => esc_html__( 'Justify', 'wolmart-core' ),
					'icon'  => 'eicon-text-align-justify',
				),
			),
			'selectors' => array(
				'.elementor-element-{{ID}} .banner-content' => 'text-align: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'banner_item_list',
		array(
			'label'       => esc_html__( 'Content Items', 'wolmart-core' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => $presets,
			'title_field' => sprintf( '{{{ banner_item_type == "text" ? \'%1$s\' : ( banner_item_type == "image" ? \'%2$s\' : ( banner_item_type == "button" ? \'%3$s\' : \'%4$s\' ) ) }}}  {{{ banner_item_type == "text" ? banner_text_content : ( banner_item_type == "image" ? banner_image[\'url\'] : ( banner_item_type == "button" ?  banner_btn_text : \'%5$s\' ) ) }}}', '<i class="eicon-t-letter"></i>', '<i class="eicon-image"></i>', '<i class="eicon-button"></i>', '<i class="eicon-divider"></i>', esc_html__( 'Divider', 'wolmart-core' ) ),
		)
	);

	$self->end_controls_section();

	/* Banner Style */
	$self->start_controls_section(
		'section_banner_style',
		array(
			'label' => esc_html__( 'Banner Wrapper', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'stretch_height',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Stretch Height', 'wolmart-core' ),
				'description' => esc_html__( 'You can make your banner height full of its parent', 'wolmart-core' ),
			)
		);

		$self->add_responsive_control(
			'banner_img_pos',
			array(
				'label'     => esc_html__( 'Image Position (%)', 'wolmart-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'%' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .banner-img img' => 'object-position: {{SIZE}}%;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_max_height',
			array(
				'label'      => esc_html__( 'Max Height', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
				),
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 700,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}, .elementor-element-{{ID}} .banner, .elementor-element-{{ID}} img' => 'max-height:{{SIZE}}{{UNIT}};overflow:hidden;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_min_height',
			array(
				'label'      => esc_html__( 'Min Height', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => 450,
				),
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'range'      => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 700,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vh'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .banner' => 'min-height:{{SIZE}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'banner_layer_layout',
		array(
			'label' => esc_html__( 'Banner Content', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'banner_origin',
			array(
				'label'   => esc_html__( 'Origin X, Y', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 't-mc',
				'options' => array(
					't-none' => esc_html__( '---------- ----------', 'wolmart-core' ),
					't-m'    => esc_html__( '---------- Center', 'wolmart-core' ),
					't-c'    => esc_html__( 'Center ----------', 'wolmart-core' ),
					't-mc'   => esc_html__( 'Center Center', 'wolmart-core' ),
				),
			)
		);

		$self->start_controls_tabs(
			'banner_position_tabs',
			array()
		);

		$self->start_controls_tab(
			'banner_pos_left_tab',
			array(
				'label' => esc_html__( 'Left', 'wolmart-core' ),
			)
		);

		$self->add_responsive_control(
			'banner_left',
			array(
				'label'      => esc_html__( 'Left Offset', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'      => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'left:{{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_top_tab',
			array(
				'label' => esc_html__( 'Top', 'wolmart-core' ),
			)
		);

		$self->add_responsive_control(
			'banner_top',
			array(
				'label'      => esc_html__( 'Top Offset', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'      => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'top:{{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_right_tab',
			array(
				'label' => esc_html__( 'Right', 'wolmart-core' ),
			)
		);

		$self->add_responsive_control(
			'banner_right',
			array(
				'label'      => esc_html__( 'Right Offset', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'      => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'right:{{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_bottom_tab',
			array(
				'label' => esc_html__( 'Bottom', 'wolmart-core' ),
			)
		);

		$self->add_responsive_control(
			'banner_bottom',
			array(
				'label'      => esc_html__( 'Bottom Offset', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'      => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'bottom:{{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_control(
			'banner_wrap',
			array(
				'label'     => esc_html__( 'Wrap with', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'separator' => 'before',
				'options'   => array(
					''                => esc_html__( 'None', 'wolmart-core' ),
					'container'       => esc_html__( 'Container', 'wolmart-core' ),
					'container-fluid' => esc_html__( 'Container Fluid', 'wolmart-core' ),
				),
			)
		);

		$self->add_responsive_control(
			'banner_width',
			array(
				'label'      => esc_html__( 'Width', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 1000,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'max-width:{{SIZE}}{{UNIT}}; width: 100%',
				),
			)
		);

		$self->add_responsive_control(
			'banner_content_margin',
			array(
				'label'      => esc_html__( 'Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => array(
					'unit' => 'px',
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'banner_content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => array(
					'unit' => 'px',
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'banner_effect',
		array(
			'label' => esc_html__( 'Banner Effect', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'banner_image_effect',
			array(
				'label' => esc_html__( 'Image Effect', 'wolmart-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$self->add_control(
			'overlay',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Hover Effect', 'wolmart-core' ),
				'options' => array(
					''           => esc_html__( 'No', 'wolmart-core' ),
					'light'      => esc_html__( 'Light', 'wolmart-core' ),
					'dark'       => esc_html__( 'Dark', 'wolmart-core' ),
					'zoom'       => esc_html__( 'Zoom', 'wolmart-core' ),
					'zoom_light' => esc_html__( 'Zoom and Light', 'wolmart-core' ),
					'zoom_dark'  => esc_html__( 'Zoom and Dark', 'wolmart-core' ),
					'effect-1'   => esc_html__( 'Effect 1', 'wolmart-core' ),
					'effect-2'   => esc_html__( 'Effect 2', 'wolmart-core' ),
					'effect-3'   => esc_html__( 'Effect 3', 'wolmart-core' ),
					'effect-4'   => esc_html__( 'Effect 4', 'wolmart-core' ),
				),
			)
		);

		$self->add_control(
			'banner_overlay_color',
			array(
				'label'     => esc_html__( 'Hover Effect Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .banner:before, .elementor-element-{{ID}} .banner:after, .elementor-element-{{ID}} .banner figure:before, .elementor-element-{{ID}} .banner figure:after' => 'background: {{VALUE}};',
					'.elementor-element-{{ID}} .overlay-dark:hover figure:after' => 'opacity: .5;',
				),
				'condition' => array(
					'overlay!' => '',
				),
			)
		);

		$self->add_control(
			'background_effect',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Backgrund Effect', 'wolmart-core' ),
				'options' => array(
					''                   => esc_html__( 'No', 'wolmart-core' ),
					'kenBurnsToRight'    => esc_html__( 'kenBurnsRight', 'wolmart-core' ),
					'kenBurnsToLeft'     => esc_html__( 'kenBurnsLeft', 'wolmart-core' ),
					'kenBurnsToLeftTop'  => esc_html__( 'kenBurnsLeftTop', 'wolmart-core' ),
					'kenBurnsToRightTop' => esc_html__( 'kenBurnsRightTop', 'wolmart-core' ),
				),
			)
		);

		$self->add_control(
			'background_effect_duration',
			array(
				'label'      => esc_html__( 'Background Effect Duration (s)', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					's',
				),
				'default'    => array(
					'size' => 30,
					'unit' => 's',
				),
				'range'      => array(
					's' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 60,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .background-effect' => 'animation-duration:{{SIZE}}s;',
				),
				'condition'  => array(
					'background_effect!' => '',
				),
			)
		);

		$self->add_control(
			'particle_effect',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Particle Effects', 'wolmart-core' ),
				'options' => array(
					''         => esc_html__( 'No', 'wolmart-core' ),
					'snowfall' => esc_html__( 'Snowfall', 'wolmart-core' ),
					'sparkle'  => esc_html__( 'Sparkle', 'wolmart-core' ),
				),
			)
		);

		$self->add_control(
			'parallax',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Enable Parallax', 'wolmart-core' ),
			)
		);

		$self->add_control(
			'banner_content_effect',
			array(
				'label'     => esc_html__( 'Content Effect', 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_responsive_control(
			'_content_animation',
			array(
				'label'              => esc_html__( 'Content Entrance Animation', 'wolmart-core' ),
				'type'               => Controls_Manager::ANIMATION,
				'frontend_available' => true,
			)
		);

		$self->add_control(
			'content_animation_duration',
			array(
				'label'        => esc_html__( 'Animation Duration', 'wolmart-core' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					'slow' => esc_html__( 'Slow', 'wolmart-core' ),
					''     => esc_html__( 'Normal', 'wolmart-core' ),
					'fast' => esc_html__( 'Fast', 'wolmart-core' ),
				),
				'prefix_class' => 'animated-',
				'condition'    => array(
					'_content_animation!' => '',
				),
			)
		);

		$self->add_control(
			'_content_animation_delay',
			array(
				'label'              => esc_html__( 'Animation Delay', 'wolmart-core' ) . ' (ms)',
				'type'               => Controls_Manager::NUMBER,
				'default'            => '',
				'min'                => 0,
				'step'               => 100,
				'condition'          => array(
					'_content_animation!' => '',
				),
				'render_type'        => 'none',
				'frontend_available' => true,
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'parallax_options',
		array(
			'label'     => esc_html__( 'Parallax', 'wolmart-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'parallax' => 'yes',
			),
		)
	);

		$self->add_control(
			'parallax_speed',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Parallax Speed', 'wolmart-core' ),
				'condition' => array(
					'parallax' => 'yes',
				),
				'default'   => array(
					'size' => 1,
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

		$self->add_control(
			'parallax_offset',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Parallax Offset', 'wolmart-core' ),
				'condition'  => array(
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

		$self->add_control(
			'parallax_height',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Parallax Height (%)', 'wolmart-core' ),
				'condition'  => array(
					'parallax' => 'yes',
				),
				'separator'  => 'after',
				'default'    => array(
					'size' => 200,
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

	$self->end_controls_section();
}

/**
 * Render banner.
 */
function wolmart_products_render_banner( $self, $atts ) {
	$atts['self'] = $self;
	require wolmart_core_path( '/widgets/banner/render-banner-elementor.php' );
}

/**
 * Register elementor layout controls for section & column banner.
 */
function wolmart_elementor_banner_layout_controls( $self, $condition_key ) {

	$self->add_responsive_control(
		'banner_min_height',
		array(
			'label'      => esc_html__( 'Min Height', 'wolmart-core' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => array(
				'unit' => 'px',
			),
			'size_units' => array(
				'px',
				'rem',
				'%',
				'vh',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 700,
				),
			),
			'condition'  => array(
				$condition_key => 'banner',
			),
			'selectors'  => array(
				'.elementor .elementor-element-{{ID}}' => 'min-height:{{SIZE}}{{UNIT}};',
				'.elementor-element-{{ID}} > .elementor-container' => 'min-height:{{SIZE}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'banner_max_height',
		array(
			'label'      => esc_html__( 'Max Height', 'wolmart-core' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => array(
				'unit' => 'px',
			),
			'size_units' => array(
				'px',
				'rem',
				'%',
				'vh',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 700,
				),
			),
			'condition'  => array(
				$condition_key => 'banner',
			),
			'selectors'  => array(
				'.elementor .elementor-element-{{ID}}' => 'max-height:{{SIZE}}{{UNIT}};',
				'.elementor-element-{{ID}} > .elementor-container' => 'max-height:{{SIZE}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'banner_img_pos',
		array(
			'label'     => esc_html__( 'Image Position (%)', 'wolmart-core' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => array(
				'%' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 100,
				),
			),
			'condition' => array(
				$condition_key => 'banner',
			),
			'selectors' => array(
				'{{WRAPPER}} .banner-img img' => 'object-position: {{SIZE}}%;',
			),
		)
	);

	$self->add_control(
		'overlay',
		array(
			'type'      => Controls_Manager::SELECT,
			'label'     => esc_html__( 'Banner Overlay', 'wolmart-core' ),
			'options'   => array(
				''           => esc_html__( 'No', 'wolmart-core' ),
				'light'      => esc_html__( 'Light', 'wolmart-core' ),
				'dark'       => esc_html__( 'Dark', 'wolmart-core' ),
				'zoom'       => esc_html__( 'Zoom', 'wolmart-core' ),
				'zoom_light' => esc_html__( 'Zoom and Light', 'wolmart-core' ),
				'zoom_dark'  => esc_html__( 'Zoom and Dark', 'wolmart-core' ),
			),
			'condition' => array(
				$condition_key => 'banner',
			),
		)
	);
}

/**
 * Register elementor layout controls for column banner layer.
 */
function wolmart_elementor_banner_layer_layout_controls( $self, $condition_key ) {

	$self->start_controls_section(
		'banner_layer_layout',
		array(
			'label'     => esc_html__( 'Banner Layer', 'wolmart-core' ),
			'tab'       => Controls_Manager::TAB_LAYOUT,
			'condition' => array(
				$condition_key => 'banner_layer',
			),
		)
	);
		$self->add_control(
			'banner_text_align',
			array(
				'label'     => esc_html__( 'Text Align', 'wolmart-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justify', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'selectors' => array(
					'{{WRAPPER}}' => 'text-align: {{VALUE}}',
				),
				'condition' => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->add_control(
			'banner_origin',
			array(
				'label'     => esc_html__( 'Origin', 'wolmart-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					't-m'  => array(
						'title' => esc_html__( 'Vertical Center', 'wolmart-core' ),
						'icon'  => 'eicon-v-align-middle',
					),
					't-c'  => array(
						'title' => esc_html__( 'Horizontal Center', 'wolmart-core' ),
						'icon'  => 'eicon-h-align-center',
					),
					't-mc' => array(
						'title' => esc_html__( 'Center', 'wolmart-core' ),
						'icon'  => 'eicon-frame-minimize',
					),
				),
				'default'   => 't-mc',
				'condition' => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->start_controls_tabs( 'banner_position_tabs' );

		$self->start_controls_tab(
			'banner_pos_left_tab',
			array(
				'label'     => esc_html__( 'Left', 'wolmart-core' ),
				'condition' => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->add_responsive_control(
			'banner_left',
			array(
				'label'      => esc_html__( 'Left Offset', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'      => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'left:{{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_top_tab',
			array(
				'label'     => esc_html__( 'Top', 'wolmart-core' ),
				'condition' => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->add_responsive_control(
			'banner_top',
			array(
				'label'      => esc_html__( 'Top Offset', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'      => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'top:{{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_right_tab',
			array(
				'label'     => esc_html__( 'Right', 'wolmart-core' ),
				'condition' => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->add_responsive_control(
			'banner_right',
			array(
				'label'      => esc_html__( 'Right Offset', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'      => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'right:{{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_bottom_tab',
			array(
				'label'     => esc_html__( 'Bottom', 'wolmart-core' ),
				'condition' => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->add_responsive_control(
			'banner_bottom',
			array(
				'label'      => esc_html__( 'Bottom Offset', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'      => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'bottom:{{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_responsive_control(
			'banner_width',
			array(
				'label'      => esc_html__( 'Width', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 1000,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
				),
				'separator'  => 'before',
				'selectors'  => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'width:{{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					$condition_key => 'banner_layer',
				),
			)
		);

		$self->add_responsive_control(
			'banner_height',
			array(
				'label'      => esc_html__( 'Height', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 1000,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'height:{{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					$condition_key => 'banner_layer',
				),
			)
		);

	$self->end_controls_section();
}
