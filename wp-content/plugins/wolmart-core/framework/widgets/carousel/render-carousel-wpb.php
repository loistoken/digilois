<?php
/**
 * Carousel Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-carousel-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
$settings = array(
	'col_sp'                => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
	'slider_vertical_align' => isset( $atts['slider_vertical_align'] ) ? $atts['slider_vertical_align'] : '',
	'fullheight'            => isset( $atts['fullheight'] ) ? $atts['fullheight'] : '',
	'autoplay'              => isset( $atts['autoplay'] ) ? $atts['autoplay'] : '',
	'autoplay_timeout'      => isset( $atts['autoplay_timeout'] ) ? $atts['autoplay_timeout'] : 5000,
	'autoheight'            => isset( $atts['autoheight'] ) ? $atts['autoheight'] : '',
	'nav_hide'              => isset( $atts['nav_hide'] ) ? $atts['nav_hide'] : '',
	'nav_pos'               => isset( $atts['nav_pos'] ) ? $atts['nav_pos'] : 'outer',
	'nav_type'              => isset( $atts['nav_type'] ) ? $atts['nav_type'] : 'simple',
	'dots_type'             => isset( $atts['dots_type'] ) ? $atts['dots_type'] : '',
	'thumbs'                => isset( $atts['thumbs'] ) ? $atts['thumbs'] : '',
	'vertical_dots'         => isset( $atts['vertical_dots'] ) ? $atts['vertical_dots'] : '',
	'dots_skin'             => isset( $atts['dots_skin'] ) ? $atts['dots_skin'] : '',
	'dots_pos'              => isset( $atts['dots_pos'] ) ? $atts['dots_pos'] : '',
	'show_nav'              => isset( $atts['show_nav'] ) ? 'yes' == $atts['show_nav'] : '',
	'show_dots'             => isset( $atts['show_dots'] ) ? 'yes' == $atts['show_dots'] : '',
);

// Responsive columns
$settings = array_merge( $settings, wolmart_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $settings['col_cnt'] ) {
	$settings['col_cnt'] = $settings['col_cnt_xl'];
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

if ( ! empty( $settings['thumbs'] ) ) {
	$settings['thumbs'] = explode( ',', $settings['thumbs'] );
}
$thumb_hash = '';
if ( 'thumb' == $settings['dots_type'] ) {
	$date       = new DateTime();
	$thumb_hash = esc_attr( hash( 'md5', $date->getTimestamp() ) );
}

$col_cnt      = wolmart_elementor_grid_col_cnt( $settings );
$extra_class  = wolmart_get_col_class( $col_cnt );
$extra_class .= ' ' . wolmart_get_grid_space_class( $settings );
$extra_class .= ' ' . wolmart_get_slider_class( $settings );
$extra_attrs  = ' data-slider-options="' . esc_attr(
	json_encode(
		wolmart_get_slider_attrs( $settings, $col_cnt, $thumb_hash )
	)
) . '"';

echo '<div class="slider-frame">';
echo '<div class="' . $extra_class . '" ' . wolmart_strip_script_tags( $extra_attrs ) . '>';
echo do_shortcode( $atts['content'] );
echo '</div>';
echo '</div>';

?>
<?php if ( 'thumb' == $settings['dots_type'] ) : ?>
<div class="slider-thumb-dots dots-bordered <?php echo 'slider-thumb-dots-' . $thumb_hash; ?>">
	<?php
	if ( is_array( $settings['thumbs'] ) && count( $settings['thumbs'] ) > 0 ) {
		$first = true;
		foreach ( $settings['thumbs'] as $thumb ) {
			echo '<button class="slider-pagination-bullet' . ( $first ? ' active' : '' ) . '">';
			echo wp_get_attachment_image( $thumb );
			echo '</button>';
			$first = false;
		}
	}
	?>
</div>
<?php endif; ?>
</div>
<?php
