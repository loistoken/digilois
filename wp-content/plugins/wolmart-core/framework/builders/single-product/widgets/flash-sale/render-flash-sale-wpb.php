<?php
/**
 * Single Prodcut Flash Sale Render
 *
 * @since 1.0.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_icon'       => 'w-icon-check',
			'sp_label'      => esc_html__( 'Flash Deals', 'wolmart-core' ),
			'sp_ends_label' => esc_html__( 'Ends in:', 'wolmart-core' ),
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-sp-flash-sale-container ' . $atts['shortcode_class'] . $atts['style_class'],
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

	if ( function_exists( 'wolmart_single_product_sale_countdown' ) ) {
		$icon_html = '<i class="' . $sp_icon . '"></i>';
		wolmart_single_product_sale_countdown( $sp_label, $sp_ends_label, $icon_html );
	}
	do_action( 'wolmart_single_product_builder_unset_product' );
}
?>
</div>
<?php
