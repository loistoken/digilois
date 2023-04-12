<?php
/**
 * Wolmart Multi Select
 *
 * adds multi select control for element option
 * follow below example of wolmart_multiselect control
 *
 * array(
 *      'type'       => 'wolmart_multiselect',
 *      'heading'    => esc_html__( 'Show Information', 'wolmart-core' ),
 *      'param_name' => 'show_info',
 *      'value'      => array(
 *          esc_html__( 'Category', 'wolmart-core' ) => 'category',
 *          esc_html__( 'Label', 'wolmart-core' )    => 'label',
 *          esc_html__( 'Price', 'wolmart-core' )    => 'price',
 *          esc_html__( 'Rating', 'wolmart-core' )   => 'rating',
 *          esc_html__( 'Attribute', 'wolmart-core' ) => 'attribute',
 *          esc_html__( 'Add To Cart', 'wolmart-core' ) => 'addtocart',
 *          esc_html__( 'Compare', 'wolmart-core' )  => 'compare',
 *          esc_html__( 'Quickview', 'wolmart-core' ) => 'quickview',
 *          esc_html__( 'Wishlist', 'wolmart-core' ) => 'wishlist',
 *          esc_html__( 'Short Description', 'wolmart-core' ) => 'short_desc',
 *      ),
 *      'dependency' => array(
 *          'element'            => 'follow_theme_option',
 *          'value_not_equal_to' => 'yes',
 *      ),
 * ),
 *
 *
 * @since 1.0.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function wolmart_multiselect_callback( $settings, $value ) {
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$class      = 'wolmart-wpb-multiselect-container';

	if ( empty( $value ) ) {
		$value = array();
	} elseif ( ! is_array( $value ) ) {
		$value = explode( ',', $value );
	}

	$html .= '<select name="' . $settings['param_name'] . '" class="wolmart-multiselect-container wpb_vc_param_value wpb-input wpb-select ' . esc_attr( $settings['param_name'] ) . ' ' . $type . '" value="' . esc_attr( $value ) . '"  multiple="true">';

	if ( ! empty( $settings['value'] ) ) {
		foreach ( $settings['value'] as $option_label => $option_value ) {
			$selected            = '';
			$option_value_string = (string) $option_value;
			if ( ! empty( $value ) && in_array( $option_value_string, $value ) ) {
				$selected = 'selected="selected"';
			}
			$option_class = str_replace( '#', 'hash-', $option_value );
			$html        .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '" ' . $selected . '>' . htmlspecialchars( $option_label ) . '</option>';
		}
	}
	$html .= '</select>';

	return $html;
}

vc_add_shortcode_param( 'wolmart_multiselect', 'wolmart_multiselect_callback' );
