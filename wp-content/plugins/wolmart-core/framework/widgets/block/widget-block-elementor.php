<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Block Widget
 *
 * Wolmart Widget to display custom block.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Wolmart_Controls_Manager;

class Wolmart_Block_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_block';
	}

	public function get_title() {
		return esc_html__( 'Block', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-apps';
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'block' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_block',
			array(
				'label' => esc_html__( 'Block', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'name',
				array(
					'label'       => esc_html__( 'Select a Block', 'wolmart-core' ),
					'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
					'options'     => 'block',
					'label_block' => true,
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-block.php';
	}

	protected function content_template() {}
}
