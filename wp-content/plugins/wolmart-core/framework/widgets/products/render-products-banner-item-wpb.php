<?php
/**
 * Product + Banner Item Shortcode Render
 *
 * @since 1.0.0
 */

global $wolmart_products_banner_items;

if ( ! isset( $wolmart_products_banner_items ) ) {
	$wolmart_products_banner_items = array();
}

$wolmart_products_banner_items[] = array(
	'banner_insert' => isset( $atts['item_no'] ) ? $atts['item_no'] : 1,
);

ob_start();
require wolmart_core_path( '/widgets/banner/render-banner-wpb.php' );
$wolmart_products_banner_items[ count( $wolmart_products_banner_items ) - 1 ]['product_banner'] = ob_get_clean();
