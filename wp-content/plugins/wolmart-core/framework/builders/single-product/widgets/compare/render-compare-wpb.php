<?php
/**
 * Single Prodcut Compare Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-sp-compare-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {

	wolmart_single_product_compare();

	do_action( 'wolmart_single_product_builder_unset_product' );
}
?>
</div>
<?php
