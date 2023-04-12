<?php
/**
 * Banner Shortcode Render
 *
 * @since 1.0.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'wrap_with'       => '',
			'banner_image'    => defined( 'WOLMART_ASSETS' ) ? ( WOLMART_ASSETS . '/images/placeholders/banner-placeholder.jpg' ) : '',
			'full_screen'     => '',
			'min_height'      => '300',
			'max_height'      => '',
			'hover_effect'    => '',
			'parallax'        => '',
			'parallax_speed'  => 1,
			'parallax_offset' => 0,
			'parallax_height' => '200',
			'video_banner'    => '',
			'video_url'       => '',
			'video_autoplay'  => '',
			'video_mute'      => '',
			'video_loop'      => '',
			'video_controls'  => '',
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-banner-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}


if ( 'banner' == $atts['shortcode'] ) {
	echo '<div ' . $wrapper_attr_html . '>';
} else {
	global $wolmart_products_banner_items;
	$wolmart_products_banner_items[ count( $wolmart_products_banner_items ) - 1 ]['banner_class'] = $wrapper_attrs['class'];
}

$html             = '';
$wrapper_cls      = 'banner banner-fixed';
$background_cls   = 'background-effect';
$particle_cls     = '';
$parallax_img     = '';
$parallax_options = array();
$video_options    = '';

if ( 'yes' == $full_screen ) {
	$wrapper_cls .= ' banner-full';
}

// effect
if ( $hover_effect ) {
	$wrapper_cls .= ' ' . $hover_effect;
}

// parallax
if ( 'yes' == $parallax ) {
	wp_enqueue_script( 'jquery-parallax' );
	$wrapper_cls .= ' parallax';

	if ( $banner_image ) {
		if ( is_numeric( $banner_image ) ) {
			$img_data     = wp_get_attachment_image_src( $banner_image, 'full' );
			$parallax_img = esc_url( $img_data[0] );
		} else {
			$parallax_img = esc_url( $banner_image );
		}
	}

	if ( is_numeric( $parallax_speed ) || is_numeric( $parallax_speed ) ) {
		$parallax_speed  = intval( $parallax_speed );
		$parallax_offset = intval( $parallax_offset );
	}
	$parallax_options = array(
		'speed'          => $parallax_speed ? 10 / $parallax_speed : 1.5,
		'parallaxHeight' => $parallax_height ? $parallax_height . '%' : '200%',
		'offset'         => $parallax_offset ? $parallax_offset : 0,
	);
	$parallax_options = 'data-parallax-options=' . json_encode( $parallax_options );
}
// video
if ( 'yes' == $video_banner ) {
	$wrapper_cls .= ' video-banner';
	if ( 'yes' == $video_autoplay ) {
		$video_options .= ' autoplay';
	}
	if ( 'yes' == $video_mute ) {
		$video_options .= ' muted="muted"';
	}
	if ( 'yes' == $video_loop ) {
		$video_options .= ' loop';
	}
	if ( 'yes' == $video_controls ) {
		$video_options .= ' controls';
	}
}
if ( 'yes' == $parallax ) {
	$html .= '<div class="' . $wrapper_cls . '" data-image-src="' . $parallax_img . '" ' . esc_attr( $parallax_options ) . '>';
} elseif ( 'yes' == $video_banner && empty( $banner_image ) ) {
	$html .= '<div class="' . $wrapper_cls . '">';
	$html .= '<video ' . $video_options . '><source src="' . esc_url( $video_url ) . '" type="video/mp4"></video>';
} else {
	$html .= '<div class="' . $wrapper_cls . '">';
}

// image
if ( $banner_image ) {
	$html .= '<figure class="banner-img">';
	if ( is_numeric( $banner_image ) ) {
		$attr = array();
		// Display full image for wide banner (width > height * 3).
		$image = wp_get_attachment_image_src( $banner_image, 'full' );
		if ( ! empty( $image[1] ) && ! empty( $image[2] ) && $image[2] && $image[1] / $image[2] > 3 ) {
			$attr['srcset'] = $image[0];
		}
		$html .= wp_get_attachment_image( $banner_image, 'full', false, $attr );

	} elseif ( is_string( $banner_image ) ) {
		$html .= '<img src="' . esc_url( $banner_image ) . '" alt="' . esc_attr__( 'Banner', 'wolmart-core' ) . '"/>';
	}
	$html .= '</figure>';
}

// content
if ( $atts['content'] ) {
	if ( $wrap_with ) {
		$html .= '<div class="' . $wrap_with . '">';
	}
	$html .= do_shortcode( $atts['content'] );
	if ( $wrap_with ) {
		$html .= '</div>';
	}
}

$html .= '</div>';

echo wolmart_escaped( $html );

if ( 'banner' == $atts['shortcode'] ) {
	echo '</div>';
}
