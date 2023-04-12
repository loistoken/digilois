<?php
/**
 * Wolmart WPBakery Accordion Header Callback
 *
 * adds heading control for element option
 * follow below example of accordion_header control
 *
 * array(
 *      'type'       => 'wolmart_accordion_header',
 *      'heading'    => esc_html__( 'Cart Type Options', 'wolmart-core' ),
 *      'param_name' => 'test_accordion_header',
 *      'group'      => 'General',
 * ),
 *
 * @since 1.0.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function wolmart_accordion_header_callback( $settings, $value ) {
	$heading = isset( $settings['heading'] ) ? $settings['heading'] : '';

	$html = sprintf( '<h3 class="wolmart-wpb-accordion-header">%1$s</h3>', $heading );

	return $html;
}

vc_add_shortcode_param( 'wolmart_accordion_header', 'wolmart_accordion_header_callback' );
