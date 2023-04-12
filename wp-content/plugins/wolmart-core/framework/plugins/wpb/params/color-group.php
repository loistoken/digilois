<?php
/**
 * Wolmart WPBakery ColorGroup Callback
 *
 * adds colorgroup control for element option
 * follow below example of wolmart_color_group control
 *
 * array(
 *      'type'       => 'wolmart_color_group',
 *      'heading'    => __( 'Colors', 'wolmart-core' ),
 *      'param_name' => 'btn_colors',
 *      'group'      => 'General',
 *      'selectors'  => array(
 *          'normal' => '{{WRAPPER}}.btn',
 *          'hover'  => '{{WRAPPER}}.btn:hover',
 *          'active' => '{{WRAPPER}}.btn:active',
 *      ),
 *      'choices'    => array( 'color', 'background', 'border' ),
 * ),
 *
 * @since 1.0.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function wolmart_color_group_callback( $settings, $value ) {
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';

	/* $selectors could include 'normal', 'hover', 'active', 'disabled' */
	$available_selectors = array( 'normal', 'hover', 'active', 'disabled' );
	$selectors           = isset( $settings['selectors'] ) ? array_keys( $settings['selectors'] ) : array( 'normal', 'hover', 'active' );
	/* $choices could include 'color', 'background-color', 'border-color' */
	$available_choices = array(
		'color'            => esc_html__( 'Color', 'wolmart-core' ),
		'background-color' => esc_html__( 'Background Color', 'wolmart-core' ),
		'border-color'     => esc_html__( 'Border Color', 'wolmart-core' ),
	);
	$choices           = isset( $settings['choices'] ) ? $settings['choices'] : array( 'color', 'background-color', 'border-color' );

	$class = 'wolmart-wpb-color-group';
	$html  = '';
	$html .= '<div class="' . esc_attr( $class ) . '">';

	$html .= '<ul class="nav nav-tabs">';

	$idx = 0;

	foreach ( $available_selectors as $selector ) {
		if ( in_array( $selector, $selectors ) ) {
				$html .= '<li class="nav-item"><a href="#" class="nav-link' . ( 0 == $idx ++ ? ' active' : '' ) . '" data-pane-id="' . $selector . '">' . sprintf( esc_html__( '%s', 'wolmart-core' ), ucwords( $selector ) ) . '</a></li>';
		}
	}

		$html .= '</ul>';

		$html .= '<div class="tab-content">';
		$idx   = 0;

	$value_arr = array();
	if ( $value ) {
		$value_arr = json_decode( $value, true );
	}
	foreach ( $available_selectors as $selector ) {
		if ( in_array( $selector, $selectors ) ) {
				$html .= '<div class="tab-pane' . ( 0 == $idx ++ ? ' active' : '' ) . '" id="' . $selector . '">';

			foreach ( $available_choices as $choice => $label ) {
				if ( in_array( $choice, $choices ) ) {
						$html .= sprintf( '<div class="color-group-wrapper" data-choice-id="%s"><label class="color-label">%s</label><div class="color-group"><input name="%s" class="wpb_vc_param_value wpb-textinput %s_field vc_color-control" type="text" value="%s"/></div></div>', $choice, $label, $choice, $settings['type'], empty( $value_arr[ $selector ][ $choice ] ) ? '' : $value_arr[ $selector ][ $choice ] );
				}
			}

				$html .= '</div>';
		}
	}
	$html .= '</div>';

	$html .= '</div>';
	$html .= '<input type="hidden" name="' . esc_attr( $param_name ) . '" class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $type ) . '_field" value=' . ( $value ? $value : '""' ) . ' />';

	return $html;
}

vc_add_shortcode_param( 'wolmart_color_group', 'wolmart_color_group_callback', WOLMART_CORE_PLUGINS_URI . '/wpb/params/color-group.js' );
