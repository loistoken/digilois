<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Wolmart Testimonial Widget
 *
 * Wolmart Widget to display testimonial.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Wolmart_Testimonial_Group_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_testimonial_group';
	}

	public function get_title() {
		return esc_html__( 'Testimonials', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-testimonial-carousel';
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'testimonial', 'rating', 'comment', 'review', 'customer', 'slider', 'grid', 'group' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_testimonial_group',
			array(
				'label' => esc_html__( 'Testimonials', 'wolmart-core' ),
			)
		);

			$repeater = new Repeater();

			wolmart_elementor_testimonial_content_controls( $repeater );

			$presets = array(
				array(
					'name'    => esc_html__( 'John Doe', 'wolmart-core' ),
					'role'    => esc_html__( 'Programmer', 'wolmart-core' ),
					'title'   => '',
					'content' => esc_html__( 'There are many good electronics in Wolmart Shop.', 'wolmart-core' ),
				),
				array(
					'name'    => esc_html__( 'Henry Harry', 'wolmart-core' ),
					'role'    => esc_html__( 'Banker', 'wolmart-core' ),
					'title'   => '',
					'content' => esc_html__( 'Here, shopping is very convenient and trustful.', 'wolmart-core' ),
				),
				array(
					'name'    => esc_html__( 'Tom Jakson', 'wolmart-core' ),
					'role'    => esc_html__( 'Vendor', 'wolmart-core' ),
					'title'   => '',
					'content' => esc_html__( 'I love customers and I will be loyal to them.', 'wolmart-core' ),
				),
			);

			$this->add_control(
				'testimonial_group_list',
				array(
					'label'   => esc_html__( 'Testimonial Group', 'wolmart-core' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => $presets,
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_testimonials_layout',
			array(
				'label' => esc_html__( 'Testimonials Layout', 'wolmart core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'   => esc_html__( 'Testimonials Layout', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'grid',
					'options' => array(
						'grid'   => esc_html__( 'Grid', 'wolmart-core' ),
						'slider' => esc_html__( 'Slider', 'wolmart-core' ),
					),
				)
			);

			wolmart_elementor_grid_layout_controls( $this, 'layout_type' );

		$this->end_controls_section();

		$this->start_controls_section(
			'testimonial_general',
			array(
				'label' => esc_html__( 'Testimonial Type', 'wolmart-core' ),
			)
		);

			wolmart_elementor_testimonial_type_controls( $this );

			$this->add_control(
				'content_line',
				array(
					'label'     => esc_html__( 'Maximum Content Line', 'wolmart-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '4',
					'selectors' => array(
						'.elementor-element-{{ID}} .testimonial .comment' => '-webkit-line-clamp: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'star_icon',
				array(
					'label'   => esc_html__( 'Star Icon', 'wolmart-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''        => 'Theme',
						'fa-icon' => 'Font Awesome',
					),
				)
			);

		$this->end_controls_section();

		wolmart_elementor_testimonial_style_controls( $this );

		wolmart_elementor_slider_style_controls( $this, 'layout_type' );
	}


	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-testimonial-group-elementor.php';
	}
}
