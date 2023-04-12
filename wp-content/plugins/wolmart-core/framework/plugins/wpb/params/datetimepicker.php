<?php
/**
 * Wolmart WPBakery datetimepicker Callback
 *
 * adds datepicker control for element option
 * follow below example of wolmart_heading control
 *
 * array(
 *      'type'        => 'wolmart_datetimepicker',
 *      'label'       => esc_html__( 'Date', 'wolmart-core' ),
 *      'param_name'  => 'test_date',
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
function wolmart_datetimepicker_callback( $settings, $value ) {
	$dependency = '';
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$class      = isset( $settings['class'] ) ? $settings['class'] : '';
	$uni        = uniqid( 'datetimepicker-' . rand() );
	$output     = '<div id="wolmart-date-time' . esc_attr( $uni ) . '" class="wolmart-datetime"><input data-format="yyyy/MM/dd hh:mm:ss" readonly class="wpb_vc_param_value ' . esc_attr( $param_name ) . ' ' . esc_attr( $type ) . ' ' . esc_attr( $class ) . '" name="' . esc_attr( $param_name ) . '" style="width:258px;" value="' . esc_attr( $value ) . '" ' . $dependency . '/><div class="add-on" > <i data-time-icon="far fa-calendar" data-date-icon="far fa-calendar"></i></div></div>';
	$output    .= '<script type="text/javascript"></script>';
	return $output;
}

vc_add_shortcode_param( 'wolmart_datetimepicker', 'wolmart_datetimepicker_callback', WOLMART_CORE_PLUGINS_URI . '/wpb/params/datetimepicker.min.js' );
