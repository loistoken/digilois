<?php
/**
 * Products + Banner Layout Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-products-layout-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
do_shortcode( $atts['content'] );

// for various banner items
global $wolmart_products_banner_items, $wolmart_products_single_items;

if ( ! empty( $wolmart_products_banner_items ) ) {
	$idxs = array();
	foreach ( $wolmart_products_banner_items as $item ) {
		$idxs[] = $item['banner_insert'];
	}

	array_multisort( $idxs, SORT_ASC, $wolmart_products_banner_items );

	wc_set_loop_prop( 'product_banner', $wolmart_products_banner_items[0]['product_banner'] );
	wc_set_loop_prop( 'banner_insert', $wolmart_products_banner_items[0]['banner_insert'] );
	wc_set_loop_prop( 'banner_class', $wolmart_products_banner_items[0]['banner_class'] );

	array_shift( $wolmart_products_banner_items );
}
if ( ! empty( $wolmart_products_single_items ) ) {
	$idxs = array();
	foreach ( $wolmart_products_single_items as $item ) {
		$idxs[] = $item['sp_insert'];
	}

	array_multisort( $idxs, SORT_ASC, $wolmart_products_single_items );

	wc_set_loop_prop( 'single_in_products', $wolmart_products_single_items[0]['single_in_products'] );
	wc_set_loop_prop( 'sp_id', $wolmart_products_single_items[0]['sp_id'] );
	wc_set_loop_prop( 'sp_insert', $wolmart_products_single_items[0]['sp_insert'] );
	wc_set_loop_prop( 'sp_class', $wolmart_products_single_items[0]['sp_class'] );
	wc_set_loop_prop( 'products_single_atts', $wolmart_products_single_items[0]['products_single_atts'] );

	array_shift( $wolmart_products_single_items );
}

$atts['creative_mode'] = false;

// Responsive columns
// $atts = array_merge( $atts, wolmart_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
// if ( ! $atts['col_cnt'] ) {
// 	$atts['col_cnt'] = $atts['col_cnt_xl'];
// }
require __DIR__ . '/render-products-masonry-wpb.php';

if ( isset( $GLOBALS['wolmart_current_product_id'] ) ) {
	unset( $GLOBALS['wolmart_current_product_id'] );
}
?>
</div>
<?php
