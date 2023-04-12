<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Share Widget
 *
 * Wolmart Widget to display share buttons.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

class Wolmart_Share_Elementor_Widget extends \Elementor\Widget_Base {
	public $share_icons = array(
		'facebook'  => array( 'fab fa-facebook-f', 'https://www.facebook.com/sharer.php?u=$permalink' ),
		'twitter'   => array( 'fab fa-twitter', 'https://twitter.com/intent/tweet?text=$title&amp;url=$permalink' ),
		'linkedin'  => array( 'fab fa-linkedin-in', 'https://www.linkedin.com/shareArticle?mini=true&amp;url=$permalink&amp;title=$title' ),
		'email'     => array( 'far fa-envelope', 'mailto:?subject=$title&amp;body=$permalink' ),
		'google'    => array( 'fab fa-google-plus-g', 'https://plus.google.com/share?url=$permalink' ),
		'pinterest' => array( 'fab fa-pinterest', 'https://pinterest.com/pin/create/button/?url=$permalink&amp;media=$image' ),
		'reddit'    => array( 'fab fa-reddit-alien', 'http://www.reddit.com/submit?url=$permalink&amp;title=$title' ),
		'tumblr'    => array( 'fab fa-tumblr', 'http://www.tumblr.com/share/link?url=$permalink&amp;name=$title&amp;description=$excerpt' ),
		'vk'        => array( 'fab fa-vk', 'https://vk.com/share.php?url=$permalink&amp;title=$title&amp;image=$image&amp;noparse=true' ),
		'whatsapp'  => array( 'fab fa-whatsapp', 'whatsapp://send?text=$title-$permalink' ),
		'xing'      => array( 'fab fa-xing', 'https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=$permalink' ),
		'youtube'   => array( 'fab fa-youtube', '#' ),
                'instagram' => array( 'fab fa-instagram', '#' ),
	);

	public function get_name() {
		return 'wolmart_widget_share';
	}

	public function get_title() {
		return esc_html__( 'Social', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'Share', 'Social', 'link', 'wolmart' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-share';
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {

		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		$this->start_controls_section(
			'section_share_content',
			array(
				'label' => esc_html__( 'Share Buttons', 'wolmart-core' ),
			)
		);

			$options = array();

		foreach ( $this->share_icons as $key => $value ) {
			$options[ $key ] = $key;
		}

			$repeater = new Repeater();

				$repeater->add_control(
					'site',
					array(
						'label'   => esc_html__( 'Icon', 'wolmart-core' ),
						'type'    => Controls_Manager::SELECT,
						'options' => $options,
						'default' => 'facebook',
					)
				);

				$repeater->add_control(
					'link',
					array(
						'label'       => esc_html__( 'Link', 'wolmart-core' ),
						'type'        => Controls_Manager::URL,
						'description' => esc_html__( 'Please Leave it blank to share this page or Input URL for a custom link', 'wolmart-core' ),
						'options'     => false,
					)
				);

			$this->add_control(
				'share_buttons',
				array(
					'label'       => esc_html__( 'Share Icons', 'wolmart-core' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array(
							'site' => 'facebook',
							'link' => '',
						),
						array(
							'site' => 'twitter',
							'link' => '',
						),
						array(
							'site' => 'linkedin',
							'link' => '',
						),
					),
					'title_field' => '{{{ site }}}',
				)
			);

			$this->add_control(
				'type',
				array(
					'label'     => esc_html__( 'Type', 'wolmart-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						''        => esc_html__( 'Default', 'wolmart-core' ),
						'stacked' => esc_html__( 'Stacked', 'wolmart-core' ),
						'framed'  => esc_html__( 'Framed', 'wolmart-core' ),
					),
					'default'   => 'stacked',
					'separator' => 'before',
				)
			);

			$this->add_control(
				'border',
				array(
					'label'     => esc_html__( 'Border Style', 'wolmart-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'0'    => esc_html__( 'Rectangle', 'wolmart-core' ),
						'10px' => esc_html__( 'Rounded', 'wolmart-core' ),
						'50%'  => esc_html__( 'Circle', 'wolmart-core' ),
					),
					'default'   => '50%',
					'selectors' => array(
						'.elementor-element-{{ID}} .social-icon' => 'border-radius: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'border_width',
				array(
					'label'     => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'px' => 2,
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
					),
					'condition' => array(
						'border' => '50%',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .social-icon' => 'border-width: {{SIZE}}px',
					),
				)
			);

			$this->add_control(
				'share_direction',
				array(
					'type'      => Controls_Manager::CHOOSE,
					'label'     => esc_html__( 'Direction', 'wolmart-core' ),
					'options'   => array(
						'flex'  => array(
							'title' => esc_html__( 'Row', 'wolmart-core' ),
							'icon'  => 'eicon-arrow-right',
						),
						'block' => array(
							'title' => esc_html__( 'Column', 'wolmart-core' ),
							'icon'  => 'eicon-arrow-down',
						),
					),
					'default'   => 'flex',
					'selectors' => array(
						'.elementor-element-{{ID}} .social-icons' => 'display: {{VALUE}}',
					),
				)
			);

			$this->add_responsive_control(
				'share_align',
				array(
					'label'     => esc_html__( 'Alignment', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'flex-start'    => array(
							'title' => esc_html__( 'Left', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'        => array(
							'title' => esc_html__( 'Center', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'      => array(
							'title' => esc_html__( 'Right', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-right',
						),
						'space-between' => array(
							'title' => esc_html__( 'Justify', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .social-icons' => 'justify-content: {{VALUE}};',
					),
					'condition' => array(
						'share_direction' => 'flex',
					),
				)
			);

			$this->add_control(
				'custom_color',
				array(
					'type'  => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Use Custom Color', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:not(:hover)' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:not(:hover)' => 'border-color: {{VALUE}}',
					),
					'condition' => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'background_color',
				array(
					'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:not(:hover)' => 'background: {{VALUE}};',
					),
					'condition' => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'custom_hover_color',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Use Custom Hover Color', 'wolmart-core' ),
					'condition' => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'hover_color',
				array(
					'label'     => esc_html__( 'Hover Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:hover' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'custom_color'       => 'yes',
						'custom_hover_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'hover_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:hover' => 'border-color: {{VALUE}}',
					),
					'condition' => array(
						'custom_color'       => 'yes',
						'custom_hover_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'hover_bg_color',
				array(
					'label'     => esc_html__( 'Hover Background Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor .elementor-element-{{ID}} .social-custom:hover' => 'background: {{VALUE}};',
					),
					'condition' => array(
						'custom_color'       => 'yes',
						'custom_hover_color' => 'yes',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_share_style',
			array(
				'label' => esc_html__( 'Share Icons Style', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'button_size',
				array(
					'label'      => esc_html__( 'Button Size', 'wolmart-core' ),
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
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .social-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'icon_size',
				array(
					'label'      => esc_html__( 'Icon Size', 'wolmart-core' ),
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
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .social-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'col_space',
				array(
					'label'      => esc_html__( 'Column Gap', 'wolmart-core' ),
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
					),
					'default'    => array(
						'size' => 5,
						'unit' => 'px',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .social-icon' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2); margin-right: calc({{SIZE}}{{UNIT}} / 2);',
						'.elementor-element-{{ID}} .social-icons' => 'margin-left: calc(-{{SIZE}}{{UNIT}} / 2); margin-right: calc(-{{SIZE}}{{UNIT}} / 2);',
					),
				)
			);

			$this->add_responsive_control(
				'row_space',
				array(
					'label'      => esc_html__( 'Row Gap', 'wolmart-core' ),
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
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .social-icon' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: calc({{SIZE}}{{UNIT}} / 2);',
						'.elementor-element-{{ID}} .social-icons' => 'margin-top: calc(-{{SIZE}}{{UNIT}} / 2); margin-bottom: calc(-{{SIZE}}{{UNIT}} / 2);',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		require __DIR__ . '/render-share-elementor.php';
	}
}
