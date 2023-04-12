<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Menu Widget
 *
 * Wolmart Widget to display menu.
 *
 * @since 1.0
 */


use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Wolmart_Menu_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_menu';
	}

	public function get_title() {
		return esc_html__( 'Menu', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-nav-menu';
	}

	public function get_keywords() {
		return array( 'menu', 'wolmart' );
	}

	public function get_script_depends() {
		return array();
	}


	/**
	 * Get menu items.
	 *
	 * @access public
	 *
	 * @return array Menu Items
	 */
	public function get_menu_items() {
		$menu_items = array();
		$menus      = wp_get_nav_menus();
		foreach ( $menus as $key => $item ) {
			$menu_items[ $item->term_id ] = $item->name;
		}
		return $menu_items;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_menu',
			array(
				'label' => esc_html__( 'Menu', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'menu_id',
				array(
					'label'   => esc_html__( 'Select Menu', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'options' => $this->get_menu_items(),
				)
			);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Select Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'vertical',
					'options' => array(
						'horizontal'  => esc_html__( 'Horizontal', 'wolmart-core' ),
						'vertical'    => esc_html__( 'Vertical', 'wolmart-core' ),
						'collapsible' => esc_html__( 'Vertical Collapsible', 'wolmart-core' ),
						'dropdown'    => esc_html__( 'Toggle Dropdown', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'mobile',
				array(
					'label'     => esc_html__( 'Show as dropdown links in mobile', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'type' => 'horizontal',
					),
				)
			);

			$this->add_control(
				'mobile_label',
				array(
					'label'     => esc_html__( 'Mobile Links Label', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						'type'   => 'horizontal',
						'mobile' => 'yes',
					),
				)
			);

			$this->add_control(
				'mobile_dropdown_pos',
				array(
					'label'     => esc_html__( 'Mobile Dropdown Position', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'dp-left'  => array(
							'title' => esc_html__( 'Left', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'dp-right' => array(
							'title' => esc_html__( 'Right', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'condition' => array(
						'type'   => 'horizontal',
						'mobile' => 'yes',
					),
				)
			);

			$this->add_responsive_control(
				'width',
				array(
					'label'     => esc_html__( 'Width (px)', 'wolmart-core' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 300,
					'condition' => array(
						'type!' => 'horizontal',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .menu, .elementor-element-{{ID}} .toggle-menu' => 'width: {{VALUE}}px;',
					),
				)
			);

			$this->add_control(
				'underline',
				array(
					'label'     => esc_html__( 'Underline on hover', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'type!' => 'dropdown',
					),
				)
			);

			$this->add_control(
				'label',
				array(
					'label'     => esc_html__( 'Toggle Label', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						'type' => 'dropdown',
					),
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'     => esc_html__( 'Toggle Icon Class', 'wolmart-core' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => 'w-icon-category',
						'library' => 'wolmart-icons',
					),
					'condition' => array(
						'type' => 'dropdown',
					),
				)
			);

			$this->add_control(
				'no_bd',
				array(
					'label'     => esc_html__( 'No Border', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'type' => 'dropdown',
					),
				)
			);

			$this->add_control(
				'no_triangle',
				array(
					'label'     => esc_html__( 'No Triangle in Dropdown', 'wolmart-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'selectors' => array(
						'.elementor-element-{{ID}} .menu .menu-item-has-children:after, .elementor-element-{{ID}} .toggle-menu:after' => 'content: none;',
					),
				)
			);

			$this->add_control(
				'show_home',
				array(
					'label'       => esc_html__( 'Show on Homepage', 'wolmart-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'Toggle Menu Dropdown will have no border.', 'wolmart-core' ),
					'condition'   => array(
						'type' => 'dropdown',
					),
				)
			);

			$this->add_control(
				'show_page',
				array(
					'label'       => esc_html__( 'Show on ALL Pages', 'wolmart-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'Menu Dropdown will be shown after loading in all pages.', 'wolmart-core' ),
					'condition'   => array(
						'type' => 'dropdown',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style',
			array(
				'label'     => esc_html__( 'Menu Toggle', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'type' => 'dropdown',
				),
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'toggle_typography',
					'selector' => '.elementor-element-{{ID}} .toggle-menu .dropdown-menu-toggle',
				)
			);

			$this->add_responsive_control(
				'toggle_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .toggle-menu > a i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'toggle_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'wolmart-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .toggle-menu > a i + span' => 'margin-left: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'toggle_border',
				array(
					'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .toggle-menu > a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'toggle_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'elementor' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .toggle-menu > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'toggle_color_tab' );
				$this->start_controls_tab(
					'toggle_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'toggle_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .toggle-menu .dropdown-menu-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .toggle-menu .dropdown-menu-toggle' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .toggle-menu .dropdown-menu-toggle' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'toggle_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'toggle_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .toggle-menu:hover .dropdown-menu-toggle, .elementor-element-{{ID}} .toggle-menu.show .dropdown-menu-toggle, .home .elementor-section:not(.fixed) .elementor-element-{{ID}} .show-home .dropdown-menu-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_hover_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .toggle-menu:hover .dropdown-menu-toggle, .elementor-element-{{ID}} .toggle-menu.show .dropdown-menu-toggle, .home .elementor-section:not(.fixed) .elementor-element-{{ID}} .show-home .dropdown-menu-toggle' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_hover_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .toggle-menu:hover .dropdown-menu-toggle, .elementor-element-{{ID}} .toggle-menu.show .dropdown-menu-toggle, .home .elementor-section:not(.fixed) .elementor-element-{{ID}} .show-home .dropdown-menu-toggle' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'toggle_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'seperator'  => 'before',
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .toggle-menu .dropdown-menu-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ancestor_style',
			array(
				'label' => esc_html__( 'Menu Ancestor', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'ancestor_typography',
					'selector' => '.elementor-element-{{ID}} .menu > li > a',
				)
			);

			$this->add_responsive_control(
				'ancestor_border',
				array(
					'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu > li:not(:last-child) > a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'ancestor_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'elementor' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'ancestor_color_tab' );
				$this->start_controls_tab(
					'ancestor_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'ancestor_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'ancestor_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li > a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'ancestor_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li > a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'ancestor_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'ancestor_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-item > a' => 'color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > li.current-menu-ancestor > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'ancestor_hover_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'background-color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-item > a' => 'color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-ancestor > a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'ancestor_hover_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'border-color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-item > a' => 'border-color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-ancestor > a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'ancestor_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'seperator'  => 'before',
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'ancestor_margin',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .menu > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .menu > li:last-child' => 'margin: 0;',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_submenu_style',
			array(
				'label' => esc_html__( 'Submenu Item', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'submenu_typography',
					'selector' => '.elementor-element-{{ID}} li ul',
				)
			);

			$this->add_responsive_control(
				'submenu_border',
				array(
					'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} li li > a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'submenu_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'elementor' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} li li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'submenu_color_tab' );
				$this->start_controls_tab(
					'submenu_normal',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'submenu_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} li li > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} li li > a' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} li li > a' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'submenu_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

				$this->add_control(
					'submenu_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} li li:hover > a:not(.nolink)' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_hover_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} li li:hover > a:not(.nolink)' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'submenu_hover_border_color',
					array(
						'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} li li:hover > a:not(.nolink)' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'submenu_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'seperator'  => 'before',
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} li li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'submenu_margin',
				array(
					'label'      => esc_html__( 'Margin', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} li li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} li li:last-child' => 'margin: 0;',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dropdown_style',
			array(
				'label' => esc_html__( 'Menu Dropdown Box', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'dropdown_padding',
				array(
					'label'      => esc_html__( 'Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'seperator'  => 'before',
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .toggle-menu .menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						// '.elementor-element-{{ID}} .menu > li > ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .mobile-links nav > ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'dropdown_bg',
				array(
					'label'     => esc_html__( 'Background', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .vertical-menu' => 'background-color: {{VALUE}}',
						'.elementor-element-{{ID}} .menu li > ul' => 'background-color: {{VALUE}}',
						'.elementor-element-{{ID}} .collapsible-menu' => 'background-color: {{VALUE}}',
						'.elementor-element-{{ID}} .toggle-menu::after' => 'border-bottom-color: {{VALUE}}',
						'.elementor-element-{{ID}} .menu > .menu-item-has-children::after' => 'border-bottom-color: {{VALUE}}',
						'.elementor-element-{{ID}} .vertical-menu > .menu-item-has-children::after' => 'border-bottom-color: transparent; border-right-color: {{VALUE}}',
						'.elementor-element-{{ID}} .mobile-links nav' => 'background-color: {{VALUE}}',
						'.elementor-element-{{ID}} .mobile-links::after' => 'border-bottom-color: {{VALUE}}',
					),
				)
			);

			$this->add_responsive_control(
				'dropdown_bd_color',
				array(
					'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .has-border .menu' => 'border-color: {{VALUE}}',
						'.elementor-element-{{ID}} .has-border::before' => 'border-bottom-color: {{VALUE}}',
					),
					'condition' => array(
						'type'   => 'dropdown',
						'no_bd!' => 'yes',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'dropdown_box_shadow',
					'selector' => '.elementor-element-{{ID}} .show .dropdown-box, .elementor-element-{{ID}} li ul,  .home .elementor-element-{{ID}} .show-home .dropdown-box',
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-menu.php';
	}
}
