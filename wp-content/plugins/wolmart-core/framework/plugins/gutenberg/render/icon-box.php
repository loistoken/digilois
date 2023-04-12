<?php
defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'className'     => '',
			'id'            => '',
			'type'          => '',
			'h_align'       => 'left',
			'v_align'       => 'flex-start',
			'content_align' => 'left',
			'pt'            => 0,
			'pr'            => 0,
			'pb'            => 0,
			'pl'            => 0,
			'mt'            => 0,
			'mr'            => 0,
			'mb'            => 0,
			'ml'            => 0,
			'icon_class'    => 'fas fa-star',
			'icon_size'     => 20,
			'icon_style'    => '',
			'border_shape'  => 'circle',
			'icon_pt'       => 10,
			'icon_pr'       => 10,
			'icon_pb'       => 10,
			'icon_pl'       => 10,
			'icon_mt'       => 0,
			'icon_mr'       => 10,
			'icon_mb'       => 0,
			'icon_ml'       => 0,
			'icon_col'      => '#333',
			'icon_bg_col'   => '',
			'heading'       => 'This is Wolmart Icon Box',
			'head_size'     => 16,
			'head_weight'   => 700,
			'head_mt'       => 0,
			'head_mr'       => 0,
			'head_mb'       => 0,
			'head_ml'       => 0,
			'head_col'      => '#333',
			'description'   => 'Input your description here.',
			'desc_size'     => 14,
			'desc_lh'       => 1.4,
			'desc_mt'       => 0,
			'desc_mr'       => 0,
			'desc_mb'       => 0,
			'desc_ml'       => 0,
			'desc_col'      => '#999',
		),
		$atts
	)
);

$aclass         = array();
$content_aclass = array();
$box_css        = array();
$content_css    = array();
$figure_css     = array();
$icon_css       = array();
$head_css       = array();
$desc_css       = array();

if ( ! $type ) {
	$aclass[]         = 'icon-box-side';
	$content_aclass[] = $content_align;
}
if ( 'mixed' == $type ) {
	$aclass[] = 'icon-box-tiny';
}

$box_css['margin']      = $mt . 'px ' . $mr . 'px ' . $mb . 'px ' . $ml . 'px';
$box_css['padding']     = $pt . 'px ' . $pr . 'px ' . $pb . 'px ' . $pl . 'px';
$box_css['text-align']  = $h_align;
$box_css['align-items'] = $v_align;
if ( 'left' == $h_align ) {
	$box_css['justify-content'] = 'flex-start';
} elseif ( 'center' == $h_align ) {
	$box_css['justify-content'] = 'center';
} else {
	$box_css['justify-content'] = 'flex-end';
}

if ( ! $type ) {
	$box_css['display'] = 'flex';
} else {
	$box_css['display'] = 'block';
}

if ( $type ) {
	if ( 'left' == $h_align ) {
		$content_css['justify-content'] = 'flex-start';
	} elseif ( 'center' == $h_align ) {
		$content_css['justify-content'] = 'center';
	} else {
		$content_css['justify-content'] = 'flex-end';
	}
	$content_css['text-align'] = $h_align;
	if ( 'mixed' == $type ) {
		if ( 'left' == $h_align ) {
			$head_css['justify-content'] = 'flex-start';
		} elseif ( 'center' == $h_align ) {
			$head_css['justify-content'] = 'center';
		} else {
			$head_css['justify-content'] = 'flex-end';
		}
	}
} else {
	$content_css['text-align'] = $content_align;
}

if ( '' == $icon_size ) {
	$icon_size = 20;
}
$icon_css['font-size'] = $icon_size;
if ( ! preg_replace( '/[0-9.]/', '', $icon_css['font-size'] ) ) {
	$icon_css['font-size'] .= 'px';
}
$icon_css['color'] = $icon_col;

if ( $icon_style ) {
	$icon_css['padding'] = $icon_pt . 'px ' . $icon_pr . 'px ' . $icon_pb . 'px ' . $icon_pl . 'px';

	if ( 'stacked' == $icon_style ) {
		$icon_css['background-color'] = $icon_col;
		$icon_css['color']            = '#fff';
	} else {
		$icon_css['border'] = '3px solid ' . $icon_bg_col;
	}

	if ( 'circle' == $border_shape ) {
		$icon_css['border-radius'] = '50%';
	}
	if ( 'rounded' == $border_shape ) {
		$icon_css['border-radius'] = '5px';
	}
}
$icon_css['margin'] = $icon_mt . 'px ' . $icon_mr . 'px ' . $icon_mb . 'px ' . $icon_ml . 'px';

if ( '' == $head_size ) {
	$head_size = 16;
}
$head_css['font-size'] = $head_size;
if ( ! preg_replace( '/[0-9.]/', '', $head_css['font-size'] ) ) {
	$head_css['font-size'] .= 'px';
}
if ( '' != $head_weight ) {
	$head_css['font-weight'] = $head_weight;
}
$head_css['margin'] = $head_mt . 'px ' . $head_mr . 'px ' . $head_mb . 'px ' . $head_ml . 'px';
$head_css['color']  = $head_col;

if ( '' == $desc_size ) {
	$desc_size = 14;
}
$desc_css['font-size'] = $desc_size;
if ( ! preg_replace( '/[0-9.]/', '', $desc_css['font-size'] ) ) {
	$desc_css['font-size'] .= 'px';
}
$desc_css['line-height'] = $desc_lh;
$desc_css['margin']      = $desc_mt . 'px ' . $desc_mr . 'px ' . $desc_mb . 'px ' . $desc_ml . 'px';
$desc_css['color']       = $desc_col;

echo '<div id="wolmart_gtnbg_icon_box_' . $id . '" class="' . esc_attr( $className ) . '">';

ob_start();
echo '<style>';

echo '#wolmart_gtnbg_icon_box_' . $id . ' .icon-box {';
foreach ( $box_css as $key => $value ) {
	echo esc_attr( $key . ':' . $value . ';' );
}
echo '}';

echo '#wolmart_gtnbg_icon_box_' . $id . ' .icon-box-content {';
foreach ( $content_css as $key => $value ) {
	echo esc_attr( $key . ':' . $value . ';' );
}
echo '}';

echo '#wolmart_gtnbg_icon_box_' . $id . ' figure{';
foreach ( $figure_css as $key => $value ) {
	echo esc_attr( $key . ':' . $value . ';' );
}
echo '}';

echo '#wolmart_gtnbg_icon_box_' . $id . ' .icon-box i{';
foreach ( $icon_css as $key => $value ) {
	echo esc_attr( $key . ':' . $value . ';' );
}
echo '}';

echo '#wolmart_gtnbg_icon_box_' . $id . ' .icon-box .icon-box-title{';
foreach ( $head_css as $key => $value ) {
	echo esc_attr( $key . ':' . $value . ';' );
}
echo '}';

echo '#wolmart_gtnbg_icon_box_' . $id . ' .icon-box p{';
foreach ( $desc_css as $key => $value ) {
	echo esc_attr( $key . ':' . $value . ';' );
}
echo '}';

echo '#wolmart_gtnbg_icon_box_' . $id . ' .image-body{';
echo 'flex: none;';
echo '}';
echo '</style>';
wolmart_filter_inline_css( ob_get_clean() );

echo '<div class="icon-box ' . implode( ' ', $aclass ) . '">';

if ( 'mixed' !== $type ) {
	echo '<span class="icon-box-icon">';
	echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
	echo '</span>';
}


echo '<div class="icon-box-content ' . implode( ' ', $content_aclass ) . '">';
if ( 'mixed' !== $type ) {
	echo '<h4 class="icon-box-title">' . wolmart_strip_script_tags( $heading ) . '</h4>';
} else {
	echo '<h4 class="icon-box-title">';
	echo '<span class="icon-box-icon">';
	echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
	echo '</span>';
	echo wolmart_strip_script_tags( $heading );
	echo '</h4>';
}

echo '<p class="description">' . wolmart_strip_script_tags( $description ) . '</p>';
echo '</div>';
echo '</div>';
echo '</div>';
