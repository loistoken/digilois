<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Breadcrumb Widget Render
 *
 */

remove_filter( 'woocommerce_breadcrumb_defaults', 'wolmart_wc_breadcrumb_args' );
add_filter( 'woocommerce_breadcrumb_defaults', 'wolmart_breadcrumb_args' );

global $wolmart_breadcrumb;

$wolmart_breadcrumb = $atts;
woocommerce_breadcrumb();
