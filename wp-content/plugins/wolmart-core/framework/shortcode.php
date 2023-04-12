<?php
/**
 * Core Framework Shortcodes
 *
 * @package Wolmart Core WordPress Framework
 * @version 1.0
 */

add_shortcode( 'wolmart_year', 'wolmart_shortcode_year' );
add_shortcode( 'wolmart_products', 'wolmart_shortcode_product' );
add_shortcode( 'wolmart_product_category', 'wolmart_shortcode_product_category' );
add_shortcode( 'wolmart_posts', 'wolmart_shortcode_posts' );
add_shortcode( 'wolmart_block', 'wolmart_shortcode_block' );
add_shortcode( 'wolmart_single_product', 'wolmart_shortcode_single_product' );
add_shortcode( 'wolmart_menu', 'wolmart_shortcode_menu' );
add_shortcode( 'wolmart_linked_products', 'wolmart_shortcode_linked_product' );
add_shortcode( 'wolmart_breadcrumb', 'wolmart_shortcode_breadcrumb' );
add_shortcode( 'wolmart_filter', 'wolmart_shortcode_filter' );
add_shortcode( 'wolmart_vendors', 'wolmart_shorcode_vendors' );

function wolmart_shortcode_year() {
	return date( 'Y' );
}

function wolmart_shortcode_product( $atts, $content = null ) {
	ob_start();
	require wolmart_core_path( '/widgets/products/render-products.php', $atts );
	return ob_get_clean();
}

function wolmart_shortcode_product_category( $atts, $content = null ) {
	ob_start();
	require wolmart_core_path( '/widgets/categories/render-categories.php', $atts );
	return ob_get_clean();
}

function wolmart_shortcode_posts( $atts, $content = null ) {
	ob_start();
	require wolmart_core_path( '/widgets/posts/render-posts.php', $atts );
	return ob_get_clean();
}


function wolmart_shortcode_block( $atts, $content = null ) {
	ob_start();
	require wolmart_core_path( '/widgets/block/render-block.php', $atts );
	return ob_get_clean();
}


function wolmart_shortcode_single_product( $atts, $content = null ) {
	ob_start();
	require wolmart_core_path( '/widgets/singleproducts/render-singleproducts.php', $atts );
	return ob_get_clean();
}


function wolmart_shortcode_menu( $atts, $content = null ) {
	ob_start();
	require wolmart_core_path( '/widgets/menu/render-menu.php', $atts );
	return ob_get_clean();
}


function wolmart_shortcode_linked_product( $atts, $content = null ) {
	ob_start();
	if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {
		require wolmart_core_path( '/widgets/products/render-products.php', $atts );
		do_action( 'wolmart_single_product_builder_unset_product' );
	}
	return ob_get_clean();
}

function wolmart_shortcode_breadcrumb( $atts, $content = null ) {
	ob_start();
	require wolmart_core_path( '/widgets/breadcrumb/render-breadcrumb.php', $atts );
	return ob_get_clean();
}


function wolmart_shortcode_filter( $settings, $content = null ) {
	ob_start();
	require wolmart_core_path( '/widgets/filter/render-filter.php', $atts );
	return ob_get_clean();
}

function wolmart_shortcode_vendors( $atts, $content = null ) {
	ob_start();
	require wolmart_core_path( '/widgets/vendor/render-vendor.php', $atts );
	return ob_get_clean();
}
