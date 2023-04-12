<?php
/**
 * Products Shortcode Render
 *
 * @since 1.0.0
 */

$wrapper_attrs = array(
	'class' => 'wolmart-wpb-products-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

// Preprocess
$keys = array(
	'count',
);
foreach ( $keys as $key ) {
	if ( ! empty( $atts[ $key ] ) ) {
		$atts[ $key ] = array(
			'size' => (int) $atts[ $key ],
		);
	}
}
$atts['page_builder'] = 'wpb';

if ( ! isset( $atts['follow_theme_option'] ) ) {
	$atts['follow_theme_option'] = 'yes';
}

if ( ! empty( $atts['show_info'] ) ) {
	$atts['show_info'] = explode( ',', $atts['show_info'] );
}

$atts['layout_type'] = 'creative';
$atts['col_sp']      = isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md';

// Responsive columns
$atts = array_merge( $atts, wolmart_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $atts['col_cnt'] ) {
	$atts['col_cnt'] = $atts['col_cnt_xl'];
}

if ( 'products_masonry' == $atts['shortcode'] ) {
	echo '<div ' . $wrapper_attr_html . '>';
}

$atts['creative_mode'] = isset( $atts['creative_mode'] ) ? $atts['creative_mode'] : 1;

// Products Render
require __DIR__ . '/render-products.php';

if ( 'products_masonry' == $atts['shortcode'] ) {
	echo '</div>';
}

