<?php
/**
 * List Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess

$wrapper_attrs = array(
	'class' => 'wolmart-icon-list-container wolmart-icon-lists ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$atts['view']         = isset( $atts['view'] ) ? $atts['view'] : 'block';
$atts['icon_h_align'] = isset( $atts['icon_h_align'] ) ? $atts['icon_h_align'] : 'start';
$atts['icon_v_align'] = isset( $atts['icon_v_align'] ) ? $atts['icon_v_align'] : 'center';

$wrapper_attrs['class'] .= ' ' . $atts['view'] . '-type align-items-' . ( 'block' == $atts['view'] ? $atts['icon_h_align'] : $atts['icon_v_align'] );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
// Title
if ( ! empty( $atts['title'] ) ) {
	echo '<h4 class="list-title">' . wolmart_strip_script_tags( $atts['title'] ) . '</h4>';
}

// content
if ( $atts['content'] ) {
	echo do_shortcode( $atts['content'] );
}

?>
</div>
<?php
