<?php

defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'pt'              => 30,
			'pr'              => 30,
			'pb'              => 30,
			'pl'              => 30,
			'mt'              => 0,
			'mr'              => 0,
			'mb'              => 20,
			'ml'              => 0,
			'fixed_banner'    => false,
			'container_width' => false,
			'bg_col'          => '#ebebeb',
			'bg_image_url'    => '',
			'wrap_class'      => '',
			'parallax'        => false,
			'par_speed'       => 1,
			'par_offset'      => 0,
			'par_height'      => 200,
			'content_align'   => 'left',
			'x_base'          => 'left',
			'y_base'          => 'bottom',
			'x_pos'           => -1,
			'y_pos'           => -1,
			'content_width'   => '',
			'min_height'      => 200,
		),
		$atts
	)
);


$banner_class   = 'banner';
$banner_style   = '';
$parallax_style = '';
$content_class  = 'banner-content';
$content_style  = '';

$banner_style .= 'padding-top: ' . intval( $pt ) . 'px; padding-right: ' . intval( $pr ) . 'px; padding-bottom: ' . intval( $pb ) . 'px; padding-left: ' . intval( $pl ) . 'px;';

if ( $fixed_banner ) {
	$banner_class .= ' banner-fixed';
}
if ( $parallax ) {
	wp_enqueue_script( 'jquery-parallax' );
	$banner_class .= ' parallax';
}
$parallax_style .= 'margin-top: ' . intval( $mt ) . 'px; margin-right: ' . intval( $mr ) . 'px; margin-bottom: ' . intval( $mb ) . 'px; margin-left: ' . intval( $ml ) . 'px;';
$banner_style   .= 'background-color: ' . esc_attr( $bg_col ) . ';';


if ( ! $fixed_banner ) {
	if ( $container_width ) {
		$content_class = 'container ' . $content_class;
	}
	if ( ! $parallax ) {
		$banner_style .= 'background-image: url(' . esc_url( $bg_image_url ) . ');';
	}
} else {
	if ( 'center' == $x_base ) {
		$content_style .= 'left: 50%;';
		$content_style .= 'transform: translateX(-50%);';
	} else {
		$content_style .= $x_base . ': ' . $x_pos . '%;';
	}
	if ( 'middle' == $y_base ) {
		$content_style .= 'top: 50%;';
		$content_style .= 'transform: translateY(-50%);';
	} else {
		$content_style .= $y_base . ': ' . $y_pos . '%;';
	}
	if ( 'center' == $x_base && 'middle' == $y_base ) {
		$content_style .= 'transform: translate(-50%, -50%);';
	}
	if ( $content_width ) {
		$content_style .= 'width: ' . $content_width . '%;';
	}
}
$content_style .= 'text-align:' . $content_align . ';';
$parallax_atts  = array();
if ( ! $fixed_banner && $parallax ) {
	$parallax_atts[] = 'data-plugin="parallax"';
	$parallax_atts[] = 'data-image-src="' . esc_url( $bg_image_url ) . '"';
	$parallax_atts[] = 'data-parallax-options=' . json_encode(
		array(
			'offset'         => $par_offset,
			'speed'          => $par_speed,
			'parallaxHeight' => $par_height . '%',
		)
	);
}

echo '<div class="' . $banner_class . '" style="' . $banner_style . '" ' . implode( ' ', $parallax_atts ) . '>';
if ( $fixed_banner ) {
	if ( $wrap_class ) {
		echo '<div class="' . $wrap_class . '"';
	}
	echo '<figure>';
	echo '<img src="' . esc_url( $bg_image_url ) . '" style="width: 100%; object-fit: cover; min-height: ' . $min_height . 'px">';
	echo '</figure>';
}
echo '<div class="' . $content_class . '" style="' . $content_style . '">';
echo do_shortcode( $content );
echo '</div>';
if ( $fixed_banner && $wrap_class ) {
	echo '</div>';
}
echo '</div>';
