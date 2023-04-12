<?php
/**
 * Image Box Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

// $settings                 = $atts;
$atts['page_builder'] = 'wpb';
$atts['content']      = rawurldecode( base64_decode( wp_strip_all_tags( $atts['content'] ) ) );
$wrapper_attrs        = array(
	'class' => 'wolmart-imagebox-container ' . $atts['shortcode_class'] . $atts['style_class'],
);
// $atts                     = $settings;

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
// Image Box Render
require __DIR__ . '/render-image-box-elementor.php';
?>
</div>
<?php
