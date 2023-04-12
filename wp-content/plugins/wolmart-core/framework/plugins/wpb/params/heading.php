<?php
/**
 * Wolmart WPBakery Heading Callback
 *
 * adds heading control for element option
 * follow below example of wolmart_heading control
 *
 * array(
 *      'type'        => 'wolmart_heading',
 *      'label'       => esc_html__( 'Button Heading Test', 'wolmart-core' ),
 *      'param_name'  => 'test_heading',
 *      'tag'         => 'h2',
 *      'class'       => 'wolmart-heading-control-class',
 *      'group'       => 'General',
 * ),
 *
 * @since 1.0.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function wolmart_heading_callback( $settings, $value ) {
	$tag   = isset( $settings['tag'] ) ? $settings['tag'] : 'h3';
	$class = isset( $settings['class'] ) ? $settings['class'] : '';
	$label = isset( $settings['label'] ) ? $settings['label'] : '';

	$html = sprintf( '<%1$s class="wolmart-wpb-heading-container%2$s">%3$s</%4$s>', $tag, ( $class ? ' ' . $class : '' ), $label, $tag );

	return $html;
}

vc_add_shortcode_param( 'wolmart_heading', 'wolmart_heading_callback' );
