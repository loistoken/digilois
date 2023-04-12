<?php
defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'className'             => '',
			'id'                    => '',
			'content_align'         => 'left',
			'text'                  => 'This is Wolmart Heading',
			'tag'                   => 'h2',
			'family'                => '',
			'size'                  => 20,
			'weight'                => 700,
			'ls'                    => '-0.01em',
			'lh'                    => '1',
			'mt'                    => 0,
			'mr'                    => 0,
			'mb'                    => 0,
			'ml'                    => 0,
			'transform'             => 'none',
			'col'                   => '#333',
			'decoration'            => '',
			'decor_space'           => 30,
			'hide_active_underline' => false,
			'div_ht'                => 2,
			'div_active_ht'         => 2,
			'div_col'               => '#f4f4f4',
			'div_active_col'        => '#2b579a',
		),
		$atts
	)
);

$aclass       = array( 'title-wrapper' );
$custom_style = array();
$aclass[]     = $decoration;
$aclass[]     = $content_align;

$heading_css = array();

$heading_css['text-align'] = $content_align;
if ( $family ) {
	$heading_css['font-family'] = $family . ', ' . ( function_exists( 'wolmart_get_option' ) ? wolmart_get_option( 'typo_default' )['font-family'] . ', ' : '' ) . 'sans-serif';
}
if ( '' == $size ) {
	$size = 20;
}
$heading_css['font-size'] = $size;
if ( ! preg_replace( '/[0-9.]/', '', $heading_css['font-size'] ) ) {
	$heading_css['font-size'] .= 'px';
}
$heading_css['font-weight']    = $weight;
$heading_css['line-height']    = $lh;
$heading_css['text-transform'] = $transform;
$heading_css['color']          = $col;
$heading_css['letter-spacing'] = $ls . ( false !== strpos( $ls, 'em' ) || false !== strpos( $ls, 'rem' ) || false !== strpos( $ls, 'px' ) ? '' : 'px' );

if ( 'left' == $content_align ) {
	$heading_css['justify-content'] = 'flex-start';
} elseif ( 'right' == $content_align ) {
	$heading_css['justify-content'] = 'flex-end';
} else {
	$heading_css['justify-content'] = 'center';
}
echo '<div id="wolmart_gtnbg_heading_' . $id . '" class="' . implode( ' ', $aclass ) . ' ' . esc_attr( $className ) . '">';

ob_start();
echo '<style>';

echo '#wolmart_gtnbg_heading_' . $id . '{
		margin: ' . $mt . 'px ' . $mr . 'px ' . $mb . 'px ' . $ml . 'px;
	}';

echo '#wolmart_gtnbg_heading_' . $id . ' .title {';
foreach ( $heading_css as $key => $value ) {
	echo esc_attr( $key . ':' . $value . ';' );
}
echo '}';

if ( 'title-underline' == $decoration ) {
	$custom_style[] = '#wolmart_gtnbg_heading_' . $id . ' .title-underline::after { height: ' . $div_ht . 'px; background: ' . ( $div_col ? $div_col : '#f4f4f4' ) . '; }';
	if ( $hide_active_underline ) {
		$custom_style[] = '#wolmart_gtnbg_heading_' . $id . ' .title::after { content: none; }';
	} else {
		$custom_style[] = '#wolmart_gtnbg_heading_' . $id . ' .title::after { height: ' . $div_active_ht . 'px; background: ' . ( $div_active_col ? $div_active_col : '#2b579a' ) . '; }';
	}
}
echo implode( ' ', $custom_style );

echo '</style>';
wolmart_filter_inline_css( ob_get_clean() );


echo '<' . $tag . ' class="title">';
echo wolmart_strip_script_tags( $text );
echo '</' . $tag . ' >';
echo '</div>';
