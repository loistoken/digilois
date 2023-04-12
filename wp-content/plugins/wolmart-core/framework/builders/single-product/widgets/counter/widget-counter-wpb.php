<?php
/**
 * Wolmart Single Product Counter
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'Content', 'wolmart-core' ) => array(
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Starting Number', 'wolmart-core' ),
			'param_name' => 'starting_number',
			'std'        => 0,
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Additional Count', 'wolmart-core' ),
			'param_name' => 'adding_number',
			'std'        => 0,
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Ending Number', 'wolmart-core' ),
			'param_name' => 'ending_number',
			'value'      => array(
				esc_html__( 'Sale Count', 'wolmart-core' ) => 'sale',
				esc_html__( 'Stock', 'wolmart-core' )      => 'stock',
			),
			'std'        => 'sale',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Number Prefix', 'wolmart-core' ),
			'param_name' => 'prefix',
			'std'        => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Number Suffix', 'wolmart-core' ),
			'param_name' => 'suffix',
			'std'        => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Animation Duration', 'wolmart-core' ),
			'param_name' => 'duration',
			'std'        => 0,
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Thousand Separator', 'wolmart-core' ),
			'param_name' => 'thousand_separator',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Separator', 'wolmart-core' ),
			'param_name' => 'thousand_separator_char',
			'value'      => array(
				esc_html__( 'Default', 'wolmart-core' ) => '',
				esc_html__( 'Dot', 'wolmart-core' )     => '.',
				esc_html__( 'Space', 'wolmart-core' )   => ' ',
			),
			'std'        => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'wolmart-core' ),
			'param_name' => 'title',
			'std'        => esc_html__( 'Sale Products', 'wolmart-core' ),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
			'param_name' => 'counter_align',
			'value'      => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'selectors'  => array(
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		esc_html__( 'Number', 'wolmart-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'number_color',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-number-wrapper' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'number_typo',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-number-wrapper',
				),
			),
		),
		esc_html__( 'Title', 'wolmart-core' )  => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'title_typo',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-title',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Counter', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_sp_counter',
		'icon'            => 'wolmart-icon wolmart-icon-sp-counter',
		'class'           => 'wolmart_sp_counter',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart single product counter.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Sp_Counter extends WPBakeryShortCode {

	}
}
