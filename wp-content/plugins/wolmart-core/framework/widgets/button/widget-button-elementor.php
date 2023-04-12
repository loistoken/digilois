<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Button Widget
 *
 * Wolmart Widget to display button.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;


class Wolmart_Button_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'wolmart_widget_button';
	}

	public function get_title() {
		return esc_html__( 'Button', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'Button', 'link', 'wolmart' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-button';
	}

	public function get_script_depends() {
		return array();
	}

	public function register_controls() {

		$this->start_controls_section(
			'section_button',
			array(
				'label' => esc_html__( 'Button Options', 'wolmart-core' ),
			)
		);

		$this->add_control(
			'label',
			array(
				'label'   => esc_html__( 'Label', 'wolmart-core' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
				'default' => esc_html__( 'Click here', 'wolmart-core' ),
			)
		);

		$this->add_control(
			'button_expand',
			array(
				'label' => esc_html__( 'Expand', 'wolmart-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_responsive_control(
			'button_align',
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
					'.elementor-element-{{ID}} .elementor-widget-container' => 'text-align: {{VALUE}}',
				),
				'condition' => array(
					'button_expand!' => 'yes',
				),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'   => esc_html__( 'Link Url', 'wolmart-core' ),
				'type'    => Controls_Manager::URL,
				'default' => array(
					'url' => '',
				),
			)
		);

		wolmart_elementor_button_layout_controls( $this );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_video_button',
			array(
				'label' => esc_html__( 'Video Options', 'wolmart-core' ),
			)
		);

		$this->add_control(
			'play_btn',
			array(
				'label'       => esc_html__( 'Use as a play button in section', 'wolmart-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Off', 'wolmart-core' ),
				'label_on'    => esc_html__( 'On', 'wolmart-core' ),
				'description' => esc_html__( 'You can play video whenever you set video in parent section', 'wolmart-core' ),
				'condition'   => array(
					'video_btn' => '',
				),
			)
		);

		$this->add_control(
			'video_btn',
			array(
				'label'       => esc_html__( 'Use as video button', 'wolmart-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Off', 'wolmart-core' ),
				'label_on'    => esc_html__( 'On', 'wolmart-core' ),
				'default'     => '',
				'description' => esc_html__( 'You can play video on lightbox.', 'wolmart-core' ),
				'condition'   => array(
					'play_btn' => '',
				),
			)
		);

		$this->add_control(
			'vtype',
			array(
				'label'     => esc_html__( 'Source', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'youtube',
				'options'   => array(
					'youtube' => esc_html__( 'YouTube', 'wolmart-core' ),
					'vimeo'   => esc_html__( 'Vimeo', 'wolmart-core' ),
					'hosted'  => esc_html__( 'Self Hosted', 'wolmart-core' ),
				),
				'condition' => array(
					'video_btn' => 'yes',
				),
			)
		);

		$this->add_control(
			'video_url',
			array(
				'label'     => esc_html__( 'Video url', 'wolmart-core' ),
				'type'      => Controls_Manager::URL,
				'separator' => 'after',
				'condition' => array(
					'video_btn' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		wolmart_elementor_button_style_controls( $this );
	}

	public function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		$this->add_inline_editing_attributes( 'label' );
		require __DIR__ . '/render-button-elementor.php';
	}
}
