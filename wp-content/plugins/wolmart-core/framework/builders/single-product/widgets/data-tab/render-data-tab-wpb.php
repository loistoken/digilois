<?php
/**
 * Single Prodcut Data Tab Render
 *
 * @since 1.0.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_type' => '',
		),
		$atts
	)
);
$GLOBALS['wolmart_sp_data_tab_settings'] = $atts;
// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-sp-data-tab-container ' . $atts['shortcode_class'] . $atts['style_class'],
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
	if ( ! function_exists( 'wolmart_get_tab_type' ) ) {
		function wolmart_get_tab_type( $type ) {
			global $wolmart_sp_data_tab_settings;
			$sp_type = '';
			if ( isset( $wolmart_sp_data_tab_settings['sp_type'] ) ) {
				$sp_type = $wolmart_sp_data_tab_settings['sp_type'];
			}
			if ( 'accordion' == $sp_type ) {
				$type = $sp_type;
			}

			return $type;
		}
	}

	add_filter( 'wolmart_single_product_data_tab_type', 'wolmart_get_tab_type' );

	woocommerce_output_product_data_tabs();

	remove_filter( 'wolmart_single_product_data_tab_type', 'wolmart_get_tab_type' );

	do_action( 'wolmart_single_product_builder_unset_product' );
}
?>
</div>
<?php
