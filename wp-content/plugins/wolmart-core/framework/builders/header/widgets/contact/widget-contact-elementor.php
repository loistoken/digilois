<?php
/**
 * Wolmart Header Elementor Contact
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Wolmart_Header_Contact_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_header_contact';
	}

	public function get_title() {
		return esc_html__( 'Contact', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon fas fa-link';
	}

	public function get_categories() {
		return array( 'wolmart_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'wolmart', 'contact', 'link' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_contact_content',
			array(
				'label' => esc_html__( 'Contact Box', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
			$this->add_control(
				'contact_icon',
				array(
					'label'   => esc_html__( 'Contact Icon', 'wolmart-core' ),
					'type'    => Controls_Manager::ICONS,
					'default' => array(
						'value'   => 'w-icon-call',
						'library' => 'wolmart-icons',
					),
				)
			);

			$this->add_control(
				'contact_link_text',
				array(
					'label'   => esc_html__( 'Live Chat Text', 'wolmart-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Live Chat', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'link',
				array(
					'label'       => esc_html__( 'Live Chat Link', 'wolmart-core' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => 'mailto://youremail',
				)
			);

			$this->add_control(
				'contact_telephone',
				array(
					'label'   => esc_html__( 'Telephone Number', 'wolmart-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( '0(800)123-456', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'contact_telephone_link',
				array(
					'label'       => esc_html__( 'Telephone Link', 'wolmart-core' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => 'tel://1234567890',
				)
			);

			$this->add_control(
				'contact_delimiter',
				array(
					'label'     => esc_html__( 'Delimiter', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => esc_html__( 'or:', 'wolmart-core' ),
					'condition' => array(
						'contact_link_text!' => '',
						'contact_telephone!' => '',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'contact_icon_style',
			array(
				'label' => esc_html__( 'Contact Icon', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'icon_font_size',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					// 'range'      => array(
					// 	'px' => array(
					// 		'step' => 1,
					// 		'min'  => 0,
					// 		'max'  => 30,
					// 	),
					// ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .contact i' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'icon_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .contact i' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'icon_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .contact i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
		$this->end_controls_section();
		$this->start_controls_section(
			'contact_link_style',
			array(
				'label' => esc_html__( 'Live Chat', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'link_typography',
					'selector' => '.elementor-element-{{ID}} .contact-content .live-chat',
				)
			);

			$this->add_control(
				'live_chat_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .contact-content .live-chat' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'live_chat_hover_color',
				array(
					'label'     => esc_html__( 'Hover Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .contact-content .live-chat:hover' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
		$this->start_controls_section(
			'contact_telephone_style',
			array(
				'label' => esc_html__( 'Telephone', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'telephone_typography',
					'selector' => '.elementor-element-{{ID}} .contact-content .telephone',
				)
			);

			$this->add_control(
				'telephone_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .contact-content .telephone' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'telephone_hover_color',
				array(
					'label'     => esc_html__( 'Hover Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .contact:hover .telephone, .elementor-element-{{ID}} .contact:hover i' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
		$this->start_controls_section(
			'contact_delimiter_style',
			array(
				'label' => esc_html__( 'Delimiter', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'delimiter_typography',
					'selector' => '.elementor-element-{{ID}} .contact-content .contact-delimiter',
				)
			);

			$this->add_control(
				'delimiter_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .contact-content .contact-delimiter' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$atts     = array(
			'live_chat'      => $settings['contact_link_text'],
			'live_chat_link' => $settings['link'],
			'tel_num'        => $settings['contact_telephone'],
			'tel_num_link'   => $settings['contact_telephone_link'],
			'delimiter'      => $settings['contact_delimiter'],
			'icon'           => isset( $settings['contact_icon']['value'] ) && $settings['contact_icon']['value'] ? $settings['contact_icon']['value'] : 'w-icon-call',
		);
		require __DIR__ . '/render-contact-elementor.php';
	}
}
