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
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Wolmart_Controls_Manager;

class Wolmart_Subcategories_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_subcategories';
	}

	public function get_title() {
		return esc_html__( 'Subcategories List', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-nav-menu';
	}

	public function get_keywords() {
		return array( 'menu', 'dynamic', 'list', 'wolmart' );
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
			'section_list',
			array(
				'label' => esc_html__( 'List', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'list_type',
				array(
					'label'   => esc_html__( 'Type', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'pcat',
					'options' => array(
						'cat'  => esc_html__( 'Categories', 'wolmart-core' ),
						'pcat' => esc_html__( 'Product Categories', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'category_ids',
				array(
					'label'       => esc_html__( 'Select Categories', 'wolmart-core' ),
					'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
					'options'     => 'category',
					'label_block' => true,
					'multiple'    => true,
					'condition'   => array(
						'list_type' => 'cat',
					),
				)
			);

			$this->add_control(
				'product_category_ids',
				array(
					'label'       => esc_html__( 'Select Categories', 'wolmart-core' ),
					'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
					'options'     => 'product_cat',
					'label_block' => true,
					'multiple'    => true,
					'condition'   => array(
						'list_type' => 'pcat',
					),
				)
			);

			$this->add_control(
				'show_subcategories',
				array(
					'type'  => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Show Subcategories', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'list_style',
				array(
					'label'     => esc_html__( 'Style', 'wolmart-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => array(
						''          => esc_html__( 'Simple', 'wolmart-core' ),
						'underline' => esc_html__( 'Underline', 'wolmart-core' ),
					),
					'condition' => array(
						'show_subcategories' => 'yes',
					),
				)
			);

			$this->add_control(
				'count',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Subcategories Count', 'wolmart-core' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 24,
						),
					),
					'description' => esc_html__( '0 value will show all categories.', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'hide_empty',
				array(
					'type'  => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Hide Empty', 'wolmart-core' ),
				)
			);

			$this->add_control(
				'view_all',
				array(
					'type'  => Controls_Manager::TEXT,
					'label' => esc_html__( 'View All Label', 'wolmart-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_type_style',
			array(
				'label'     => esc_html__( 'Title', 'wolmart-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_subcategories' => 'yes',
				),
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'title_typo',
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '.elementor-element-{{ID}} .subcat-title',
				)
			);

			$this->add_control(
				'title_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'title_space',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Space', 'wolmart-core' ),
					'range'     => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 200,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 20,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-title' => 'margin-right: {{SIZE}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_link_style',
			array(
				'label' => esc_html__( 'Link', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'link_typo',
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '.elementor-element-{{ID}} .subcat-nav a',
				)
			);

			$this->add_control(
				'link_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-nav a' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'link__hover_color',
				array(
					'label'     => esc_html__( 'Hover Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-nav a:hover, .elementor-element-{{ID}} .subcat-nav a:focus, .elementor-element-{{ID}} .subcat-nav a:visited' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'link_space',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Space', 'wolmart-core' ),
					'range'     => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 200,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 20,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .subcat-nav a' => 'margin-right: {{SIZE}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-subcategories-elementor.php';
	}
}
