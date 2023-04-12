<?php
defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'className'         => '',
			'id'                => '',
			'preset'            => 'btn-primary',
			'shape'             => '',
			'btn_size'          => '',
			'type'              => '',
			'link_hover_type'   => '',
			'icon_class'        => '',
			'icon_pos'          => 'left',
			'icon_hover_effect' => '',
			'icon_infinite'     => false,
			'text'              => 'Click Here',
			'link'              => '#',
			'align'             => 'left',
			'size'              => 14,
			'icon_size'         => 14,
			'icon_margin'       => 5,
			'col'               => '',
			'bg_col'            => '',
			'bd_col'            => '',
			'hover_col'         => '',
			'hover_bg_col'      => '',
			'hover_bd_col'      => '',
			'pt'                => '',
			'pr'                => '',
			'pb'                => '',
			'pl'                => '',
			'border_radius'     => '',
		),
		$atts
	)
);

$block_style = '';
$b_class     = array( 'btn' );
$b_style     = '';
$i_style     = '';
$hover_style = '';

$b_class[] = $preset;
$b_class[] = $shape;
$b_class[] = $type;
if ( 'btn-link' == $type ) {
	$b_class[] = $link_hover_type;
}
$b_class[] = $btn_size;

if ( $icon_class ) {
	$b_class[] = 'btn-icon-' . $icon_pos;
	$b_class[] = $icon_hover_effect;
	if ( $icon_infinite ) {
		$b_class[] = 'btn-infinite';
	}
}

if ( '' == $size ) {
	$size = 14;
}
$b_style .= 'font-size: ' . $size;
if ( ! preg_replace( '/[0-9.]/', '', $size ) ) {
	$b_style .= 'px';
}
$b_style .= ';';

if ( '' != $icon_size ) {
	$i_style .= 'font-size: ' . $icon_size;
	if ( ! preg_replace( '/[0-9.]/', '', $icon_size ) ) {
		$i_style .= 'px';
	}
	$i_style .= ';';
}

$i_style .= 'margin-' . ( 'left' == $icon_pos ? 'right' : 'left' ) . ': ' . $icon_margin . 'px;';
$b_style .= 'padding: ' . $pt . 'px ' . $pr . 'px ' . $pb . 'px ' . $pl . 'px' . ';';

if ( $col || $bg_col || $bd_col || $hover_col || $hover_bg_col || $hover_bd_col ) {
	$b_style     .= 'color: ' . $col . ';' .
				'background-color: ' . $bg_col . ';' .
				'border-color: ' . $bd_col . ';';
	$hover_style .= 'color: ' . $hover_col . ';' .
				'background-color: ' . $hover_bg_col . ';' .
				'border-color: ' . $hover_bd_col . ';';
}

if ( '' != $border_radius ) {
	$b_style .= 'border-radius: ' . intval( $border_radius ) . 'px;';
}

$block_style .= 'text-align: ' . $align;
if ( 'justify' == $align ) {
	$b_style .= 'width: 100%;';
}

echo '<div id="wolmart_gtnbg_button_' . $id . '" class="' . esc_attr( $className ) . '">';

ob_start();
echo '<style>';

echo '#wolmart_gtnbg_button_' . $id . '{' . $block_style . '}';
echo '#wolmart_gtnbg_button_' . $id . ' .btn{' . $b_style . '}';
echo '#wolmart_gtnbg_button_' . $id . ' .btn:hover{' . $hover_style . '}';
echo '#wolmart_gtnbg_button_' . $id . ' .btn i{' . $i_style . '}';

echo '</style>';
wolmart_filter_inline_css( ob_get_clean() );

echo '<a class="' . implode( ' ', $b_class ) . '" href="' . esc_url( $link ) . '">';

if ( $icon_class && 'left' == $icon_pos ) {
	echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
}

echo wolmart_strip_script_tags( $text );

if ( $icon_class && 'right' == $icon_pos ) {
	echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
}

echo '</a>';
echo '</div>';
