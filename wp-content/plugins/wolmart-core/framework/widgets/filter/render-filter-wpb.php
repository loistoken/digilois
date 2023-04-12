<?php
/**
 * Filter Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-filter-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

global $wolmart_wpb_filter;
do_shortcode( $atts['content'] );

$settings = array(
	'align'      => isset( $atts['align'] ) ? $atts['align'] : 'center',
	'btn_label'  => isset( $atts['btn_label'] ) ? $atts['btn_label'] : esc_html__( 'Filter', 'wolmart-core' ),
	'btn_skin'   => isset( $atts['btn_skin'] ) ? $atts['btn_skin'] : 'btn-primary',
	'attributes' => $wolmart_wpb_filter,
);

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
// Filter Render
require __DIR__ . '/render-filter.php';
?>
</div>
<?php
