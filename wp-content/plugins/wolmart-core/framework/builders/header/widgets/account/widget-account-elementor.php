<?php
/**
 * Wolmart Header Elementor Account
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Wolmart_Header_Account_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_header_account';
	}

	public function get_title() {
		return esc_html__( 'Account', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-lock-user';
	}

	public function get_categories() {
		return array( 'wolmart_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'wolmart', 'account', 'login', 'register', 'sign' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_account_content',
			array(
				'label' => esc_html__( 'Account', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'account_items',
				array(
					'label'    => esc_html__( 'Show Items', 'wolmart-core' ),
					'type'     => Controls_Manager::SELECT2,
					'multiple' => true,
					'default'  => array(
						'icon',
						'login',
					),
					'options'  => array(
						'icon'     => esc_html__( 'User Icon', 'wolmart-core' ),
						'login'    => esc_html__( 'Login/Logout Label', 'wolmart-core' ),
						'register' => esc_html__( 'Register Label', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'dropdown_align',
				array(
					'label'     => esc_html__( 'Dropdown Align', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'auto' => array(
							'title' => esc_html__( 'Left', 'wolmart-core' ),
							'icon'  => 'eicon-h-align-left',
						),
						''     => array(
							'title' => esc_html__( 'Right', 'wolmart-core' ),
							'icon'  => 'eicon-h-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .dropdown-box' => 'right: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'      => esc_html__( 'Icon', 'wolmart-core' ),
					'type'       => Controls_Manager::ICONS,
					'default'    => array(
						'value'   => 'w-icon-account',
						'library' => 'wolmart-icons',
					),
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'account_items',
								'operator' => 'contains',
								'value'    => 'icon',
							),
						),
					),
				)
			);

			$this->add_control(
				'account_login',
				array(
					'label'      => esc_html__( 'Login Text', 'wolmart-core' ),
					'type'       => Controls_Manager::TEXT,
					'default'    => esc_html__( 'Log in', 'wolmart-core' ),
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'account_items',
								'operator' => 'contains',
								'value'    => 'login',
							),
						),
					),
				)
			);

			$this->add_control(
				'account_register',
				array(
					'label'      => esc_html__( 'Register Text', 'wolmart-core' ),
					'type'       => Controls_Manager::TEXT,
					'default'    => esc_html__( 'Register', 'wolmart-core' ),
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'account_items',
								'operator' => 'contains',
								'value'    => 'register',
							),
						),
					),
				)
			);

			$this->add_control(
				'account_delimiter',
				array(
					'label'       => esc_html__( 'Delimiter Text', 'wolmart-core' ),
					'description' => esc_html__( 'Account Delimiter will be shown between Login and Register links', 'wolmart-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '/',
					'conditions'  => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'account_items',
								'operator' => 'contains',
								'value'    => 'login',
							),
							array(
								'name'     => 'account_items',
								'operator' => 'contains',
								'value'    => 'register',
							),
						),
					),
				)
			);

			$this->add_control(
				'social_login',
				array(
					'label'   => esc_html__( 'Enable Social Login', 'wolmart-core' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				)
			);

			$this->add_control(
				'label_heading2',
				array(
					'label'     => esc_html__( 'When user is logged in...', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'account_dropdown',
				array(
					'label'       => esc_html__( 'Menu Dropdown', 'wolmart-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'default'     => '',
					'description' => esc_html__( 'Menu that is located in Account Menu will be shown.', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'account_logout',
				array(
					'label'       => esc_html__( 'Logout Text', 'wolmart-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'Log out',
					'description' => esc_html__( 'Please input %name% where you want to show current user name. ( ex: Hi, %name%! )', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'account_avatar',
				array(
					'label'   => esc_html__( 'Show Avatar', 'wolmart-core' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_account_style',
			array(
				'label' => esc_html__( 'Account', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'account_typography',
					'selector' => '.elementor-element-{{ID}} .account a',
				)
			);

			$this->add_responsive_control(
				'account_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .account i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'account_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .block-type i + span' => 'margin-top: {{SIZE}}px;',
						'.elementor-element-{{ID}} .inline-type i + span' => 'margin-left: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'account_avatar_size',
				array(
					'label'      => esc_html__( 'Avatar Size (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .account-avatar' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'account_avatar_space',
				array(
					'label'      => esc_html__( 'Avatar Space (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .inline-type .account-avatar' => 'margin-right: {{SIZE}}px;',
						'.elementor-element-{{ID}} .block-type .account-avatar' => 'margin-bottom: {{SIZE}}px;',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_account_color' );
				$this->start_controls_tab(
					'tab_account_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'account_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .account > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_account_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'account_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .account > a:hover' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'delimiter_heading',
				array(
					'label'     => esc_html__( 'Delimiter', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'deimiter_typography',
					'selector' => '.elementor-element-{{ID}} .account .delimiter',
				)
			);

			$this->add_control(
				'delimiter_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .account .delimiter' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'account_delimiter_space',
				array(
					'label'      => esc_html__( 'Delimiter Space (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .account .delimiter' => 'margin-left: {{SIZE}}px; margin-right: {{SIZE}}px;',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$atts     = array(
			'type'             => 'inline',
			'items'            => $settings['account_items'],
			'login_text'       => $settings['account_login'] ? $settings['account_login'] : 'Log in',
			'logout_text'      => $settings['account_logout'] ? $settings['account_logout'] : 'Log out',
			'register_text'    => $settings['account_register'] ? $settings['account_register'] : 'Register',
			'delimiter_text'   => $settings['account_delimiter'],
			'icon'             => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : 'w-icon-account',
			'account_dropdown' => 'yes' == $settings['account_dropdown'],
			'account_avatar'   => 'yes' == $settings['account_avatar'],
		);
		require __DIR__ . '/render-account-elementor.php';
	}
}
