<?php
defined( 'ABSPATH' ) || die;

/**
 * Creative Grid Functions
 * Creative Grid Functions
 */

use Elementor\Controls_Manager;
use Elementor\Wolmart_Controls_Manager;

/**
 * Register elementor layout controls for creative grid.
 */

function wolmart_elementor_creative_layout_controls( $self, $condition_key, $widget = '' ) {

	/**
	 * Using Isotope
	 */
	$self->add_control(
		'creative_mode',
		array(
			'label'     => esc_html__( 'Creative Layout', 'wolmart-core' ),
			'type'      => Wolmart_Controls_Manager::IMAGE_CHOOSE,
			'default'   => 1,
			'options'   => wolmart_creative_preset_imgs(),
			'condition' => array(
				$condition_key => 'creative',
			),
			'width'     => 1,
		)
	);

	$self->add_control(
		'creative_height',
		array(
			'label'     => esc_html__( 'Change Grid Height', 'wolmart-core' ),
			'type'      => Controls_Manager::SLIDER,
			'default'   => array(
				'size' => 600,
			),
			'range'     => array(
				'px' => array(
					'step' => 5,
					'min'  => 100,
					'max'  => 1000,
				),
			),
			'condition' => array(
				$condition_key => 'creative',
			),
		)
	);

	$self->add_control(
		'creative_height_ratio',
		array(
			'label'     => esc_html__( 'Grid Mobile Height (%)', 'wolmart-core' ),
			'type'      => Controls_Manager::SLIDER,
			'default'   => array(
				'size' => 75,
			),
			'range'     => array(
				'%' => array(
					'step' => 1,
					'min'  => 30,
					'max'  => 100,
				),
			),
			'condition' => array(
				$condition_key => 'creative',
			),
		)
	);

	$self->add_control(
		'grid_float',
		array(
			'label'       => esc_html__( 'Use Float Grid', 'wolmart-core' ),
			'description' => esc_html__( 'The Layout will be built with only float style not using isotope plugin. This is very useful for some simple creative layouts.', 'wolmart-core' ),
			'type'        => Controls_Manager::SWITCHER,
			'condition'   => array(
				$condition_key => 'creative',
			),
		)
	);
}
