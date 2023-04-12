<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Wolmart Image Box Widget
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

class Wolmart_Image_Box_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_imagebox';
	}

	public function get_title() {
		return esc_html__( 'Image Box', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-image-box';
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'image box', 'imagebox', 'feature', 'member', 'wolmart' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		$this->start_controls_section(
			'imagebox_content',
			array(
				'label' => esc_html__( 'Image Box', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'image',
				array(
					'label'   => esc_html__( 'Choose Image', 'wolmart-core' ),
					'type'    => Controls_Manager::MEDIA,
					'default' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'      => 'image',
					'default'   => 'full',
					'separator' => 'none',
				)
			);

			$this->add_control(
				'title',
				array(
					'label'   => esc_html__( 'Title', 'wolmart-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => 'Input Title Here',
				)
			);

			$this->add_control(
				'subtitle',
				array(
					'label'   => esc_html__( 'Subtitle', 'wolmart-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => 'Input SubTitle Here',
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

			$this->add_control(
				'content',
				array(
					'label'   => esc_html__( 'Content', 'wolmart-core' ),
					'type'    => Controls_Manager::TEXTAREA,
					'rows'    => '10',
					'default' => '<div class="social-icons">
									<a href="#" class="social-icon framed social-facebook"><i class="fab fa-facebook-f"></i></a>
									<a href="#" class="social-icon framed social-twitter"><i class="fab fa-twitter"></i></a>
									<a href="#" class="social-icon framed social-linkedin"><i class="fab fa-linkedin-in"></i></a>
								</div>',
				)
			);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Imagebox Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''      => esc_html__( 'Default', 'wolmart-core' ),
						'outer' => esc_html__( 'Outer Title', 'wolmart-core' ),
						'inner' => esc_html__( 'Inner Title', 'wolmart-core' ),
					),
				)
			);

			$this->add_responsive_control(
				'imagebox_align',
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
					'default'   => 'center',
					'selectors' => array(
						'.elementor-element-{{ID}} .image-box' => 'text-align: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			array(
				'label' => esc_html__( 'Title', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'title_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
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
					'label'    => esc_html__( 'Typography', 'wolmart-core' ),
					'selector' => '.elementor-element-{{ID}} .title',
				)
			);

			$this->add_control(
				'title_mg',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_style',
			array(
				'label' => esc_html__( 'Subtitle', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'subtitle_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .subtitle' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'subtitle_typography',
					'label'    => esc_html__( 'Typography', 'wolmart-core' ),
					'selector' => '.elementor-element-{{ID}} .subtitle',
				)
			);

			$this->add_control(
				'subtitle_mg',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'description_style',
			array(
				'label' => esc_html__( 'Description', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'description_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .content' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'description_typography',
					'label'    => esc_html__( 'Typography', 'wolmart-core' ),
					'selector' => '.elementor-element-{{ID}} .content',
				)
			);

			$this->add_control(
				'description_mg',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
						'rem',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'title' );
		$this->add_inline_editing_attributes( 'subtitle' );
		$this->add_inline_editing_attributes( 'content' );

		require __DIR__ . '/render-image-box-elementor.php';
	}
}
