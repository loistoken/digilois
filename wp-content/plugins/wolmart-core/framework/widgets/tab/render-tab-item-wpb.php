<?php
/**
 * Tab Item Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class'          => 'wolmart-tab-item-container tab-pane ' . $atts['shortcode_class'] . $atts['style_class'],
	'data-tab-title' => empty( $atts['tab_title'] ) ? 'Tab' : wolmart_strip_script_tags( $atts['tab_title'] ),
);

global $wolmart_wpb_tab;
if ( ! $wolmart_wpb_tab ) {
	$wrapper_attrs['class'] .= ' active';
	$wolmart_wpb_tab         = array();
}
$wolmart_wpb_tab[] = empty( $atts['tab_title'] ) ? 'Tab' : $atts['tab_title'];

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
echo do_shortcode( $atts['content'] );
?>
</div>
<?php
