<?php
/**
 * Core Framework Addons
 *
 * 1. Load addons
 * 2. Addons List
 *
 * @package Wolmart Core WordPress Framework
 * @version 1.0
 */


/**************************************/
/* 1. Load addons                     */
/**************************************/

add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_share' );
add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_save_search_keywords' );

if ( class_exists( 'WooCommerce' ) ) {
	if ( class_exists( 'WeDevs_Dokan' ) || class_exists( 'WCFM' ) || class_exists( 'WCMp' ) || class_exists( 'WC_Vendors' ) || defined( 'MVX_PLUGIN_VERSION' ) ) {
		add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_vendors' );
	}
	add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_product_helpful_comments' );
	add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_product_ordering' );
	add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_product_brand' );
	add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_product_360_gallery' );
	add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_product_video_popup' );
	add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_product_image_comments' );
	add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_product_compare' );
	add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_product_attribute_guide' );
	add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_product_attribute_list_type' );
}

add_action( 'wolmart_framework_addons', 'wolmart_setup_addon_ai_generator' );

/**************************************/
/* 2. Addons List                     */
/**************************************/

// ADDON: Share
if ( ! function_exists( 'wolmart_setup_addon_share' ) ) {
	function wolmart_setup_addon_share( $request ) {
		wolmart_core_require_once( '/addons/share/share.php' );
	}
}

// ADDON: Save Search Keywords
if ( ! function_exists( 'wolmart_setup_addon_save_search_keywords' ) ) {
	function wolmart_setup_addon_save_search_keywords( $request ) {
		wolmart_core_require_once( '/addons/save-search/save-search.php' );
	}
}

// ADDON: Vendors
if ( ! function_exists( 'wolmart_setup_addon_vendors' ) ) {
	function wolmart_setup_addon_vendors( $request ) {
		wolmart_core_require_once( '/addons/vendors/vendors.php' );
	}
}

// ADDON: Helpful Comments for Single Product
if ( ! function_exists( 'wolmart_setup_addon_product_helpful_comments' ) ) {
	function wolmart_setup_addon_product_helpful_comments( $request ) {
		if ( 'yes' == get_option( 'woocommerce_enable_reviews' ) ) {
			wolmart_core_require_once( '/addons/product-helpful-comments/product-helpful-comments.php' );
		}
	}
}

// ADDON: Product Ordering
if ( ! function_exists( 'wolmart_setup_addon_product_ordering' ) ) {
	function wolmart_setup_addon_product_ordering( $request ) {
		wolmart_core_require_once( '/addons/product-ordering/product-ordering.php' );
	}
}

// ADDON: Custom Product Taxonomies
if ( ! function_exists( 'wolmart_setup_addon_product_brand' ) ) {
	function wolmart_setup_addon_product_brand( $request ) {
		wolmart_core_require_once( '/addons/product-brand/product-brand.php' );
	}
}

// ADDON: 360 Degree Gallery
if ( ! function_exists( 'wolmart_setup_addon_product_360_gallery' ) ) {
	function wolmart_setup_addon_product_360_gallery( $request ) {
		wolmart_core_require_once( '/addons/product-360-gallery/product-360-gallery.php' );
	}
}

// ADDON: Product Video Popup
if ( ! function_exists( 'wolmart_setup_addon_product_video_popup' ) ) {
	function wolmart_setup_addon_product_video_popup( $request ) {
		wolmart_core_require_once( '/addons/product-video-popup/product-video-popup.php' );
	}
}

// ADDON: Product Image Comment & Comment Admin
if ( ! function_exists( 'wolmart_setup_addon_product_image_comments' ) ) {
	function wolmart_setup_addon_product_image_comments( $request ) {
		wolmart_core_require_once( '/addons/product-image-comments/product-image-comments.php' );
		if ( $request['can_manage'] ) {
			wolmart_core_require_once( '/addons/product-image-comments/product-image-comments-admin.php' );
		}
	}
}

// ADDON: Product Compare
if ( ! function_exists( 'wolmart_setup_addon_product_compare' ) ) {
	function wolmart_setup_addon_product_compare( $request ) {
		if ( function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'compare_available' ) ) {
			wolmart_core_require_once( '/addons/product-compare/product-compare.php' );
		}
	}
}

// ADDON: Product Attribute Guide
if ( ! function_exists( 'wolmart_setup_addon_product_attribute_guide' ) ) {
	function wolmart_setup_addon_product_attribute_guide( $request ) {
		if ( is_admin() && 'edit.php' == $GLOBALS['pagenow'] &&
			isset( $_REQUEST['post_type'] ) && 'product' == $_REQUEST['post_type'] &&
			isset( $_REQUEST['page'] ) && 'product_attributes' == $_REQUEST['page'] ) {
			wolmart_core_require_once( '/addons/product-attribute-guide/product-attribute-guide.php' );
		}
	}
}

// ADDON: Product Attribute List Type
if ( ! function_exists( 'wolmart_setup_addon_product_attribute_list_type' ) ) {
	function wolmart_setup_addon_product_attribute_list_type( $request ) {
		wolmart_core_require_once( '/addons/product-attribute-list-type/product-attribute-list-type.php' );
	}
}

// ADDON: Content Generator with OpenAI
if ( ! function_exists( 'wolmart_setup_addon_ai_generator' ) ) {
	function wolmart_setup_addon_ai_generator( $request ) {
		wolmart_core_require_once( '/addons/ai-generator/class-content-generator.php' );
	}
}