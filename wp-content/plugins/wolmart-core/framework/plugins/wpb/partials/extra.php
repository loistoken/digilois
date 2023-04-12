<?php
if ( ! function_exists( 'wolmart_get_wpb_extra_controls' ) ) {
	function wolmart_get_wpb_extra_controls() {

		$animations = wolmart_get_animations( 'in' );

		return array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation Type', 'wolmart-core' ),
				'param_name' => 'animation_type',
				'group'      => esc_html__( 'Extra Options', 'wolmart-core' ),
				'value'      => array_flip( $animations ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Animation Duration (ms)', 'wolmart-core' ),
				'param_name' => 'animation_duration',
				'value'      => '1000',
				'group'      => esc_html__( 'Extra Options', 'wolmart-core' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Animation Delay (ms)', 'wolmart-core' ),
				'param_name' => 'animation_delay',
				'value'      => '0',
				'group'      => esc_html__( 'Extra Options', 'wolmart-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'extra_class',
				'heading'     => esc_html__( 'Custom Class', 'wolmart-core' ),
				'value'       => '',
				'group'       => esc_html__( 'Extra Options', 'wolmart-core' ),
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wolmart-core' ),
			),
			array(
				'type'       => 'wolmart_responsive',
				'param_name' => 'responsiveness',
				'heading'    => esc_html__( 'Responsiveness', 'wolmart-core' ),
				'group'      => esc_html__( 'Extra Options', 'wolmart-core' ),
			),
		);
	}
}

add_filter(
	'wolmart_wpb_element_wrapper_atts',
	function( $wrapper_attrs, $atts ) {
		// Responsive
		if ( ! empty( $atts['responsiveness'] ) ) {
			$responsive = str_replace( '``', '"', $atts['responsiveness'] );
			$responsive = json_decode( $responsive, true );
			// Generate Helper Classes
			$responsive_classes = array(
				'xl' => 'hide-on-xl',
				'lg' => 'hide-on-lg',
				'md' => 'hide-on-md',
				'sm' => 'hide-on-sm',
				'xs' => 'hide-on-xs',
			);

			$style = '';
			foreach ( $responsive_classes as $width => $helper_class ) {
				if ( ! empty( $responsive[ $width ] ) && true == $responsive[ $width ] ) {
					$wrapper_attrs['class'] .= ' ' . $helper_class;
				}
			}
		}
		// Extra Class
		if ( ! empty( $atts['extra_class'] ) ) {
			$wrapper_attrs['class'] .= ' ' . $atts['extra_class'];
		}
		// Animation
		if ( ! empty( $atts['animation_type'] ) ) {
			if ( ! vc_is_inline() ) {
				$wrapper_attrs['class'] .= ' appear-animate';
			}

			$animation_settings             = array(
				'_animation'          => $atts['animation_type'],
				'_animation_delay'    => ! empty( $atts['animation_delay'] ) ? $atts['animation_delay'] : '0',
				'_animation_duration' => ! empty( $atts['animation_duration'] ) ? $atts['animation_duration'] : '1000',
			);
			$wrapper_attrs['data-settings'] = esc_attr( json_encode( $animation_settings ) );
		}

		return $wrapper_attrs;
	},
	10,
	2
);
