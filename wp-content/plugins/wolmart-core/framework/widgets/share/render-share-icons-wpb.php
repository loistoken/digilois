<?php
/**
 * Share Icons Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess


$wrapper_attrs = array(
	'class' => 'wolmart-shareicon-container social-icons ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
// share icon Render

// content
if ( $atts['content'] ) {
	echo do_shortcode( $atts['content'] );
}

?>
</div>
<?php
