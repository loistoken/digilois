<?php

defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'id'                      => '',
			'col_cnt_xl'              => '',
			'col_cnt'                 => '1',
			'col_cnt_min'             => '1',
			'col_sp'                  => 'no',
			'slider_vertical_align'   => '',
			'slider_horizontal_align' => '',
			'show_nav'                => false,
			'nav_hide'                => false,
			'nav_type'                => 'simple',
			'nav_pos'                 => '',
			'show_dots'               => false,
			'dots_skin'               => '',
			'dots_pos'                => '',
			'autoplay'                => false,
			'autoplay_timeout'        => 5000,
			'loop'                    => false,
			'pause_onhover'           => false,
			'autoheight'              => false,
			'nav_size'                => 20,
		),
		$atts
	)
);

wp_enqueue_script( 'swiper' );

// Slider Settings
$extra_class = '';
$extra_attr  = '';

$extra_class .= 'slider-wrapper';

// Layout
if ( 'lg' == $col_sp || 'sm' == $col_sp || 'xs' == $col_sp || 'no' == $col_sp ) {
	$extra_class .= ' gutter-' . $col_sp;
}

$col_cnt = array(
	'xl'  => (int) $col_cnt_xl,
	'lg'  => (int) $col_cnt,
	'md'  => (int) $col_cnt,
	'sm'  => (int) $col_cnt,
	'min' => (int) $col_cnt_min,
);


if ( function_exists( 'wolmart_get_responsive_cols' ) ) {
	$col_cnt = wolmart_get_responsive_cols( $col_cnt );
}

if ( function_exists( 'wolmart_get_col_class' ) ) {
	$extra_class .= wolmart_get_col_class( $col_cnt );
}


// Nav & Dots

if ( 'full' == $nav_type ) {
	$extra_class .= ' slider-nav-full';
} else {
	if ( 'circle' == $nav_type ) {
		$extra_class .= ' slider-nav-circle';
	}
	if ( 'top' == $nav_pos ) {
		$extra_class .= ' slider-nav-top';
	} elseif ( 'inner' != $nav_pos ) {
		$extra_class .= ' slider-nav-outer';
	}
}
if ( $nav_hide ) {
	$extra_class .= ' slider-nav-fade';
}

if ( $dots_skin ) {
	$extra_class .= ' slider-dots-' . $dots_skin;
}

if ( 'inner' == $dots_pos ) {
	$extra_class .= ' slider-dots-inner';
}
if ( 'outer' == $dots_pos ) {
	$extra_class .= ' slider-dots-outer';
}

if ( 'top' == $slider_vertical_align ||
	'middle' == $slider_vertical_align ||
	'bottom' == $slider_vertical_align ||
	'same-height' == $slider_vertical_align ) {
	$extra_class .= ' slider-' . $slider_vertical_align;
}

// Options - ( Change Value ) true/false to yes/no
if ( isset( $atts['show_nav'] ) ) {
	$atts['show_nav'] = 'yes';
} else {
	$atts['show_nav'] = '';
}
if ( isset( $atts['show_dots'] ) ) {
	$atts['show_dots'] = 'yes';
} else {
	$atts['show_dots'] = '';
}
if ( isset( $atts['autoplay'] ) ) {
	$atts['autoplay'] = 'yes';
} else {
	$atts['autoplay'] = '';
}
if ( isset( $atts['loop'] ) ) {
	$atts['loop'] = 'yes';
} else {
	$atts['loop'] = '';
}
if ( isset( $atts['pause_onhover'] ) ) {
	$atts['pause_onhover'] = 'yes';
} else {
	$atts['pause_onhover'] = '';
}
if ( isset( $atts['pause_onhover'] ) ) {
	$atts['pause_onhover'] = 'yes';
} else {
	$atts['pause_onhover'] = '';
}

$extra_attrs = ' data-slider-options="' . esc_attr(
	json_encode(
		wolmart_get_slider_attrs( $atts, $col_cnt )
	)
) . '"';

// render HTML
ob_start();
echo '<style>';
echo '#wolmart_gtnbg_slider_' . $id . ' .slider-button { font-size: ' . $nav_size . 'px; }';
echo '</style>';
wolmart_filter_inline_css( ob_get_clean() );

echo '<div class="' . esc_attr( $extra_class ) . '" ' . $extra_attrs . '>';
echo do_shortcode( $content );
echo '</div>';
