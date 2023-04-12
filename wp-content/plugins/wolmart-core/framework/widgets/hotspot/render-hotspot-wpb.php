<?php
/**
 * Hotspot Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

$atts['icon'] = array(
	'value' => ! empty( $atts['icon'] ) ? $atts['icon'] : 'w-icon-plus',
);

$atts['page_builder'] = 'wpb';

$wrapper_attrs = array(
	'class' => 'wolmart-wpb-hotspot-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
// Button Render
require __DIR__ . '/render-hotspot-elementor.php';
?>
</div>
<?php
