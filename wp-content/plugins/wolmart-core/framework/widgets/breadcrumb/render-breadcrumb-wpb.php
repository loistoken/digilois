<?php
/**
 * Breadcrumb Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess

$wrapper_attrs = array(
	'class' => 'wolmart-breadcrumb-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
$atts['widget'] = 'breadcrumb';
if ( isset( $atts['delimiter_icon'] ) ) {
	$atts['delimiter_icon'] = array( 'value' => $atts['delimiter_icon'] );
}
if ( ! isset( $atts['home_icon'] ) ) {
	$atts['home_icon'] = '';
}

if ( function_exists( 'wolmart_breadcrumb' ) ) {
	global $wolmart_breadcrumb;
	$wolmart_breadcrumb = $atts;

	add_filter( 'woocommerce_breadcrumb_defaults', 'wolmart_breadcrumb_args' );

	wolmart_breadcrumb();
}
?>
</div>
<?php
