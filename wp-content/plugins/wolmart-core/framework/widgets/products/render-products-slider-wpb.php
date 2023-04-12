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
$atts['layout_type'] = 'slider';

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
// Responsive columns
$atts = array_merge( $atts, wolmart_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $atts['col_cnt'] ) {
	$atts['col_cnt'] = $atts['col_cnt_xl'];
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

echo '<div ' . $wrapper_attr_html . '>';

// Products Render
require __DIR__ . '/render-products.php';

echo '</div>';

// Frontend Editor
if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
	$selector = '.' . str_replace( ' ', '', $atts['shortcode_class'] );
	?>
		<script>Wolmart.slider('<?php echo wolmart_strip_script_tags( $selector ); ?> .slider-wrapper');</script>
	<?php
}
