<?php
/**
 * Product + Single Product Item Shortcode Render
 *
 * @since 1.0.0
 */

global $wolmart_products_single_items;

if ( ! isset( $wolmart_products_single_items ) ) {
	$wolmart_products_single_items = array();
}

$atts['editor'] = 'wpb';

$wolmart_products_single_items[] = array(
	'sp_insert'            => isset( $atts['item_no'] ) ? $atts['item_no'] : 1,
	'single_in_products'   => '',
	'sp_id'                => '',
	'products_single_atts' => $atts,
	'sp_class'             => '',
);

if ( isset( $atts['product_ids'] ) ) {

	ob_start();
	require wolmart_core_path( '/widgets/singleproducts/render-singleproducts-wpb.php' );
	$wolmart_products_single_items[ count( $wolmart_products_single_items ) - 1 ]['single_in_products'] = ob_get_clean();
	$wolmart_products_single_items[ count( $wolmart_products_single_items ) - 1 ]['sp_id']              = $atts['product_ids'];
}
