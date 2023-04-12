<?php
/**
 * Single Products Shortcode Render
 *
 * @since 1.0.0
 */

$wrapper_attrs = array(
	'class' => 'wolmart-wpb-singleproducts-container ' . $atts['shortcode_class'] . $atts['style_class'],
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

// slider
$atts = array_merge(
	$atts,
	array(
		'col_sp'                => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
		'slider_vertical_align' => isset( $atts['slider_vertical_align'] ) ? $atts['slider_vertical_align'] : '',
		'scroll_per_page'       => isset( $atts['scroll_per_page'] ) ? $atts['scroll_per_page'] : '',
		'fullheight'            => isset( $atts['fullheight'] ) ? $atts['fullheight'] : '',
		'autoplay'              => isset( $atts['autoplay'] ) ? $atts['autoplay'] : '',
		'autoplay_timeout'      => isset( $atts['autoplay_timeout'] ) ? $atts['autoplay_timeout'] : 5000,
		'autoheight'            => isset( $atts['autoheight'] ) ? $atts['autoheight'] : '',
		'nav_hide'              => isset( $atts['nav_hide'] ) ? $atts['nav_hide'] : '',
		'nav_type'              => isset( $atts['nav_type'] ) ? $atts['nav_type'] : 'simple',
		'dots_skin'             => isset( $atts['dots_skin'] ) ? $atts['dots_skin'] : '',
		'dots_pos'              => isset( $atts['dots_pos'] ) ? $atts['dots_pos'] : '',
		'show_nav'              => isset( $atts['show_nav'] ) ? 'yes' == $atts['show_nav'] : '',
		'show_dots'             => isset( $atts['show_dots'] ) ? 'yes' == $atts['show_dots'] : '',
		'nav_pos'               => isset( $atts['nav_pos'] ) ? $atts['nav_pos'] : 'outer',
	)
);
// Columns
if ( ! empty( $atts['col_cnt'] ) ) {
	$columns                = json_decode( str_replace( '``', '"', $atts['col_cnt'] ), true );
	$atts['col_cnt_xl']     = $columns['xl'];
	$atts['col_cnt']        = empty( $columns['lg'] ) ? $columns['xl'] : $columns['lg'];
	$atts['col_cnt_tablet'] = $columns['md'];
	$atts['col_cnt_mobile'] = $columns['sm'];
	$atts['col_cnt_min']    = $columns['xs'];
}
// Responsive nav visibility
$show_nav = wolmart_wpb_convert_responsive_values( 'show_nav', $atts );
if ( isset( $show_nav['show_nav'] ) ) {
	$settings['show_nav'] = $show_nav['show_nav'];
}
if ( isset( $show_nav['show_nav_xl'] ) && empty( $show_nav['show_nav'] ) ) {
	$settings['show_nav'] = $show_nav['show_nav_xl'];
}

// Responsive dots visibility
$show_dots = wolmart_wpb_convert_responsive_values( 'show_dots', $atts );
if ( isset( $show_dots['show_dots'] ) ) {
	$settings['show_dots'] = $show_dots['show_dots'];
}
if ( 'singleproducts' == $atts['shortcode'] ) {
	echo '<div ' . $wrapper_attr_html . '>';
} else {
	global $wolmart_products_single_items;
	if ( ! empty( $wolmart_products_single_items ) ) {
		$wolmart_products_single_items[ count( $wolmart_products_single_items ) - 1 ]['sp_class'] = $wrapper_attrs['class'];
	}
}

// Categories Render
require __DIR__ . '/render-singleproducts.php';

if ( 'singleproducts' == $atts['shortcode'] ) {
	echo '</div>';
}

// Frontend Editor
if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
	$selector = '.' . str_replace( ' ', '', $atts['shortcode_class'] );
	if ( isset( $atts['count']['size'] ) && 1 < $atts['count']['size'] ) {
		?>
			<script>Wolmart.slider('<?php echo wolmart_strip_script_tags( $selector ); ?> .slider-wrapper');</script>
		<?php
	}
}
