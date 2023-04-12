<?php
/**
 * Image Gallery Shortcode Render
 *
 * @since 1.0.0
 */
$wrapper_attrs = array(
	'class' => 'wolmart-wpb-image-gallery-container ' . $atts['shortcode_class'] . $atts['style_class'] . ( ! empty( $atts['el_class'] ) ? ( ' ' . $atts['el_class'] ) : '' ),
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

// Preprocess
if ( ! empty( $atts['images'] ) ) {
	$atts['images'] = explode( ',', $atts['images'] );
	foreach ( $atts['images'] as &$value ) {
		$value = array(
			'id' => $value,
		);
	}
} else {
	$atts['images'] = array();
}

$atts['page_builder'] = 'wpb';
$atts['layout_type']  = 'slider';
$atts['count']        = isset( $atts['count'] ) ? array( 'size' => $atts['count'] ) : array( 'size' => 4 );

// slider
$atts = array_merge(
	$atts,
	array(
		'col_sp'                => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
		'slider_vertical_align' => isset( $atts['slider_vertical_align'] ) ? $atts['slider_vertical_align'] : '',
		'fullheight'            => isset( $atts['fullheight'] ) ? $atts['fullheight'] : '',
		'autoplay'              => isset( $atts['autoplay'] ) ? $atts['autoplay'] : '',
		'autoplay_timeout'      => isset( $atts['autoplay_timeout'] ) ?
		$atts['autoplay_timeout'] : 5000,
		'loop'                  => isset( $atts['loop'] ) ? $atts['loop'] : '',
		'pause_onhover'         => isset( $atts['pause_onhover'] ) ? $atts['pause_onhover'] : '',
		'autoheight'            => isset( $atts['autoheight'] ) ? $atts['autoheight'] : '',
		'nav_hide'              => isset( $atts['nav_hide'] ) ? $atts['nav_hide'] : '',
		'nav_type'              => isset( $atts['nav_type'] ) ? $atts['nav_type'] : '',
		'vertical_dots'         => isset( $atts['vertical_dots'] ) ? $atts['vertical_dots'] : '',
		'dots_skin'             => isset( $atts['dots_skin'] ) ? $atts['dots_skin'] : '',
		'dots_pos'              => isset( $atts['dots_pos'] ) ? $atts['dots_pos'] : '',
		'show_nav'              => isset( $atts['show_nav'] ) ? 'yes' == $atts['show_nav'] : '',
		'show_dots'             => isset( $atts['show_dots'] ) ? 'yes' == $atts['show_dots'] : '',
		'nav_pos'               => isset( $atts['nav_pos'] ) ? $atts['nav_pos'] : 'outer',
	)
);

// Responsive columns
$atts = array_merge( $atts, wolmart_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
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
?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
echo '<div class="slider-frame">';
// Image Slider Render
require __DIR__ . '/render-image-gallery-elementor.php';
echo '</div>';
?>
</div>
<?php
// Frontend Editor
if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
	$selector = '.' . str_replace( ' ', '', $atts['shortcode_class'] );
	?>
		<script>Wolmart.slider('<?php echo wolmart_strip_script_tags( $selector ); ?> .slider-wrapper');</script>
	<?php
}
