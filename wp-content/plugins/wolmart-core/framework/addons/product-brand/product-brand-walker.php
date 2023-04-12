<?php
/**
 * Wolmart_WC_Product_Brand_List_Walker class
 *
 * @package WooCommerce\Classes\Walkers
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || die;

if ( class_exists( 'Wolmart_WC_Product_Brand_List_Walker', false ) ) {
	return;
}

include_once WC()->plugin_path() . '/includes/walkers/class-wc-product-cat-list-walker.php';

/**
 * Product brand list walker class.
 */
class Wolmart_WC_Product_Brand_List_Walker extends WC_Product_Cat_List_Walker {

	public $tree_type = 'product_brand';
}
