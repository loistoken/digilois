<?php
/*
Plugin Name: Wolmart Core
Plugin URI: https://d-themes.com/wordpress/wolmart
Description: Adds functionality such as Shortcodes, Post Types, Widgets and Page Builders to Wolmart Theme
Version: 1.5.0
Author: D-Themes
Author URI: https://d-themes.com/
License: GPL2
Text Domain: wolmart-core
*/

// Direct load is not allowed
defined( 'ABSPATH' ) || die;

/**************************************/
/* Define Constants                   */
/**************************************/

define( 'WOLMART_CORE_URI', untrailingslashit( plugin_dir_url( __FILE__ ) ) );               // Plugin directory uri
define( 'WOLMART_CORE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );             // Plugin directory path
define( 'WOLMART_CORE_FILE', __FILE__ );                                                     // Plugin file path
define( 'WOLMART_CORE_VERSION', '1.5.0' );                                                     // Plugin Version

function wolmart_core_require_once( $path ) {
	require_once file_exists( WOLMART_CORE_PATH . '/inc' . $path ) ? WOLMART_CORE_PATH . '/inc' . $path : WOLMART_CORE_PATH . '/framework' . $path;
}
function wolmart_core_path( $path ) {
	return file_exists( WOLMART_CORE_PATH . '/inc' . $path ) ? WOLMART_CORE_PATH . '/inc' . $path : WOLMART_CORE_PATH . '/framework' . $path;
}


/**************************************/
/* Wolmart Core Plugin Constructor    */
/**************************************/

class WOLMART_CORE {
	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		// Load plugin
		add_action( 'plugins_loaded', array( $this, 'load' ) );
	}

	/**
	 * Load required files
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function load() {
		// Load text domain
		load_plugin_textdomain( 'wolmart-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		wolmart_core_require_once( '/init.php' );
	}
}

WOLMART_CORE::get_instance();
