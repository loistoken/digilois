<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Wolmart Floating Widget
 *
 * Wolmart Widget to display floating shape with svg.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

class Wolmart_Svg_Floating_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_floating';
	}

	public function get_title() {
		return esc_html__( 'SVG Floating', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-divider-shape';
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'floating', 'svg', 'animate' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'float_content',
			array(
				'label' => esc_html__( 'SVG Floating', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'float_svg',
				array(
					'label'                  => esc_html__( 'Floating SVG', 'wolmart-core' ),
					'description'            => esc_html__( 'Please upload svg file to apply floating effect.', 'wolmart-core' ),
					'type'                   => Controls_Manager::ICONS,
					'exclude_inline_options' => array(
						'icon',
					),
				)
			);

			// $this->add_control(
			// 	'float_svg_description',
			// 	array(
			// 		'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s This floating element is only for %2$sSVG%3$s files. And SVG file should have only %2$sPath%3$s elements.%4$s', 'wolmart-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
			// 		'type'        => 'wolmart_description',
			// 	)
			// );

			$this->add_control(
				'delta',
				array(
					'label'       => esc_html__( 'Offset', 'wolmart-core' ),
					'description' => esc_html__( 'Controls how much different SVG shape should be transformed.', 'wolmart-core' ),
					'type'        => Controls_Manager::SLIDER,
				)
			);

			$this->add_control(
				'speed',
				array(
					'label'       => esc_html__( 'Speed', 'wolmart-core' ),
					'description' => esc_html__( 'Controls how fast SVG shape should be transformed.', 'wolmart-core' ),
					'type'        => Controls_Manager::SLIDER,
				)
			);

			$this->add_control(
				'size',
				array(
					'label'       => esc_html__( 'Size', 'wolmart-core' ),
					'description' => esc_html__( 'Controls size of SVG shape.', 'wolmart-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 20,
						),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'float_style',
			array(
				'label' => esc_html__( 'Style', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'rotate',
				array(
					'label'       => esc_html__( 'Rotate', 'wolmart-core' ),
					'description' => esc_html__( 'Controls how much SVG shape should be rotated.', 'wolmart-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 360,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} svg' => 'transform: rotate({{SIZE}}deg);',
					),
				)
			);

			$this->add_control(
				'opacity',
				array(
					'label'       => esc_html__( 'Opacity', 'wolmart-core' ),
					'description' => esc_html__( 'Controls transparency of SVG shape.', 'wolmart-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 0.1,
							'min'  => 0,
							'max'  => 1,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} svg' => 'opacity: {{SIZE}}',
					),
				)
			);

			$this->add_control(
				'fill_color',
				array(
					'label'       => esc_html__( 'Fill Color', 'wolmart-core' ),
					'description' => esc_html__( 'Choose background color of SVG shape.', 'wolmart-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} svg' => 'fill: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'stroke_color',
				array(
					'label'       => esc_html__( 'Stroke Color', 'wolmart-core' ),
					'description' => esc_html__( 'Choose border color of SVG shape.', 'wolmart-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} svg' => 'stroke: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {

		global $float_atts;

		$delta = $this->get_settings_for_display( 'delta' )['size'];
		$speed = $this->get_settings_for_display( 'speed' )['size'];
		$size  = $this->get_settings_for_display( 'size' )['size'];

		$float_atts = array(
			'delta' => $delta ? $delta : 15,
			'speed' => $speed ? $speed : 10,
			'size'  => $size ? $size : 1,
		);

		ob_start();
		Icons_Manager::render_icon( $this->get_settings_for_display( 'float_svg' ) );
		$html = ob_get_clean();

		$html = preg_replace_callback(
			'|viewBox="([^"]*)"|',
			function( $matches ) {
				global $float_atts;
				$box     = array_map( 'floatval', explode( ' ', $matches[1] ) );
				$box[1] -= $float_atts['delta'];
				$box[3] += $float_atts['delta'] * 2;
				return 'viewBox="' . implode( ' ', $box ) . '" class="float-svg" data-float-options="{&quot;delta&quot;:' . $float_atts['delta'] . ',&quot;speed&quot;:' . $float_atts['speed'] . ',&quot;size&quot;:' . $float_atts['size'] . '}"';
			},
			$html
		);

		$html = preg_replace_callback(
			'|width="([\d\|\.]+)px"|',
			function( $matches ) {
				global $float_atts;
				return 'width="' . round( floatval( $matches[1] ) * $float_atts['size'], 3 ) . 'px"';
			},
			$html
		);

		$html = preg_replace_callback(
			'|height="([\d\|\.]+)px"|',
			function( $matches ) {
				global $float_atts;
				return 'height="' . round( floatval( $matches[1] ) * $float_atts['size'], 3 ) . 'px"';
			},
			$html
		);

		unset( $float_atts );

		echo wolmart_escaped( $html );
	}
}
