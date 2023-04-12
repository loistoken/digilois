<?php
/**
 * Filter Item Shortcode Render
 *
 * @since 1.0.0
 */

global $wolmart_wpb_filter;

if ( isset( $atts['name'] ) ) {
	$wolmart_wpb_filter[] = array(
		'name'      => $atts['name'],
		'query_opt' => isset( $atts['query_opt'] ) ? $atts['query_opt'] : 'or',
	);
}
