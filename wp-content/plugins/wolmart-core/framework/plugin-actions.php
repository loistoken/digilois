<?php
/**
 * Plugin Actions, Filters
 *
 * @package Wolmart Core WordPress Framework
 * @version 1.0
 */
defined( 'ABSPATH' ) || die;

add_action( 'after_setup_theme', 'wolmart_setup_make_script_async' );

add_action( 'admin_print_footer_scripts', 'wolmart_print_footer_scripts', 30 );

// update image srcset meta
add_filter( 'wp_calculate_image_srcset', 'wolmart_image_srcset_filter_sizes', 10, 2 );


if ( ! function_exists( 'wolmart_print_footer_scripts' ) ) {
	/**
	 * Print footer scripts
	 *
	 * @since 1.0
	 */
	function wolmart_print_footer_scripts() {
		echo '<script id="wolmart-core-admin-js-extra">';
		echo 'var wolmart_core_vars = ' . json_encode(
			apply_filters(
				'wolmart_core_admin_localize_vars',
				array(
					'ajax_url'   => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'      => wp_create_nonce( 'wolmart-core-nonce' ),
					'assets_url' => WOLMART_CORE_URI,
				)
			)
		) . ';';
		echo '</script>';
	}
}

if ( ! function_exists( 'wolmart_setup_make_script_async' ) ) {
	/**
	 * Add a filter to make scripts async.
	 *
	 * @since 1.0
	 */
	function wolmart_setup_make_script_async() {
		// Set scripts as async
		if ( ! wolmart_is_wpb_preview() && function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'resource_async_js' ) ) {
			add_filter( 'script_loader_tag', 'wolmart_make_script_async', 10, 2 );
		}
	}
}

if ( ! function_exists( 'wolmart_make_script_async' ) ) {
	/**
	 * Set scripts as async
	 *
	 * @since 1.0
	 *
	 * @param string $tag
	 * @param string $handle
	 * @return string Async script tag
	 */
	function wolmart_make_script_async( $tag, $handle ) {
		$async_scripts = apply_filters(
			'wolmart_async_scripts',
			array(
				'jquery-parallax',
				'swiper',
				'jquery-autocomplete',
				'wolmart-live-search',
				'jquery-countdown',
				'jquery-magnific-popup',
				'jquery-cookie',
				'wolmart-theme-async',
			)
		);

		if ( in_array( $handle, $async_scripts ) ) {
			return str_replace( ' src', ' async="async" src', $tag );
		}
		return $tag;
	}
}

if ( ! function_exists( 'wolmart_image_srcset_filter_sizes' ) ) {
	/**
	 * Remove srcset in img tag.
	 *
	 * @since 1.2.0
	 */
	function wolmart_image_srcset_filter_sizes( $sources, $size_array ) {
		foreach ( $sources as $width => $source ) {
			if ( isset( $source['descriptor'] ) && 'w' == $source['descriptor'] && ( $width < apply_filters( 'wolmart_mini_screen_size', 320 ) || (int) $width > (int) $size_array[0] ) ) {
				unset( $sources[ $width ] );
			}
		}
		return $sources;
	}
}
