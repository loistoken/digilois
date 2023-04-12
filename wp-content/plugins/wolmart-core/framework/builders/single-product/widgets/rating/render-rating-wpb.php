<?php
/**
 * Single Prodcut Rating Render
 *
 * @since 1.0.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_type'    => 'star',
			'sp_reviews' => 'yes',
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-sp-rating-container ' . $atts['shortcode_class'] . $atts['style_class'],
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
	if ( 'number' == $sp_type ) {
		add_filter( 'wolmart_single_product_rating_show_number', '__return_true' );
	}
	if ( '' == $sp_reviews ) {
		add_filter( 'wolmart_single_product_show_review', '__return_false' );
	}

	woocommerce_template_single_rating();

	if ( 'number' == $sp_type ) {
		remove_filter( 'wolmart_single_product_rating_show_number', '__return_true' );
	}
	if ( '' == $sp_reviews ) {
		remove_filter( 'wolmart_single_product_show_review', '__return_false' );
	}

	do_action( 'wolmart_single_product_builder_unset_product' );
}
?>
</div>
<?php
