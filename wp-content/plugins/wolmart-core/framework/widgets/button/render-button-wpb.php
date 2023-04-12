<?php
/**
 * Button Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$atts['builder'] = 'wpb';
if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

if ( ! empty( $atts['icon'] ) ) {
	$atts['icon'] = array(
		'value' => $atts['icon'],
	);
}

$wrapper_attrs = array(
	'class' => 'wolmart-button-container ' . $atts['shortcode_class'] . $atts['style_class'],
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
require __DIR__ . '/render-button-elementor.php';
?>
</div>
<?php
