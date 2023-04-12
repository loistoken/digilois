<?php
/**
 * Core Framework
 *
 * 1. Load the plugin base
 * 2. Load the other plugin functions
 * 3. Load builders
 * 4. Load addons and shortcodes
 *
 * @package Wolmart Core WordPress Framework
 * @version 1.0
 */
defined( 'ABSPATH' ) || die;

define( 'WOLMART_CORE_FRAMEWORK', WOLMART_CORE_PATH . '/framework' );
define( 'WOLMART_CORE_FRAMEWORK_URI', WOLMART_CORE_URI . '/framework' );
define( 'WOLMART_CORE_PLUGINS', WOLMART_CORE_FRAMEWORK . '/plugins' );
define( 'WOLMART_CORE_PLUGINS_URI', WOLMART_CORE_FRAMEWORK_URI . '/plugins' );
define( 'WOLMART_BUILDERS', WOLMART_CORE_FRAMEWORK . '/builders' );
define( 'WOLMART_BUILDERS_URI', WOLMART_CORE_FRAMEWORK_URI . '/builders' );
define( 'WOLMART_CORE_ADDONS', WOLMART_CORE_FRAMEWORK . '/addons' );
define( 'WOLMART_CORE_ADDONS_URI', WOLMART_CORE_FRAMEWORK_URI . '/addons' );



/**************************************/
/* 1. Load the plugin base            */
/**************************************/
wolmart_core_require_once( '/class-base.php' );
wolmart_core_require_once( '/core-functions.php' );
wolmart_core_require_once( '/plugin-functions.php' );
wolmart_core_require_once( '/plugin-actions.php' );


/**************************************/
/* 2. Load the other plugin functions */
/**************************************/
wolmart_core_require_once( '/plugins/wpb/core-wpb.php' );               // WPBakery
wolmart_core_require_once( '/plugins/elementor/core-elementor.php' );   // Elementor
if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {                             // Elementor Pro Version
	wolmart_core_require_once( '/plugins/elementor/core-elementor-pro.php' );
}
wolmart_core_require_once( '/plugins/gutenberg/core-gutenberg.php' );   // Gutenberg
if ( is_admin() ) {
	wolmart_core_require_once( '/plugins/meta-box/meta-box.php' );             // Meta Box
}

if ( class_exists( 'Uni_Cpo' ) ) {                                      // Uni CPO Functions
	wolmart_core_require_once( '/plugins/unicpo/unicpo.php' );
}

if ( class_exists( 'YITH_YWGC_Gift_Card' ) ) {                          // Yith Gift Cards Functions
	wolmart_core_require_once( '/plugins/yith-gift-card/yith-gift-card.php' );
}

if ( class_exists( 'YITH_WC_Audio_Video' ) ) {							// Yith Featured Video
	wolmart_core_require_once( '/plugins/yith-featured-video/yith-featured-video.php' );
}


/**************************************/
/* 3. Load builders                   */
/**************************************/

if ( ! isset( $_POST['action'] ) || 'wolmart_quickview' != $_POST['action'] ) {
	wolmart_core_require_once( '/builders/builders.php' );
	wolmart_core_require_once( '/builders/sidebar/sidebar-builder.php' );
	wolmart_core_require_once( '/builders/header/header-builder.php' );
	if ( class_exists( 'WooCommerce' ) ) {
		wolmart_core_require_once( '/builders/single-product/single-product-builder.php' );
	}
}


/**************************************/
/* 4. Load addons and shortcodes      */
/**************************************/

wolmart_core_require_once( '/addons/init.php' );
wolmart_core_require_once( '/shortcode.php' );


/**************************************/
/* 5. Critcal CSS      */
/**************************************/

wolmart_core_require_once( '/critical/class-critical.php' );

/**************************************/
/* 6. Conditional Rendering      */
/**************************************/

wolmart_core_require_once( '/conditional-rendering/init.php' );

