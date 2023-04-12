<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart IconList Widget Render
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'view'         => 'block',
			'title'        => '',
			'icon_h_align' => 'start',
			'icon_v_align' => 'middle',
			'class'        => '',
			'icon_list'    => '',
		),
		$atts
	)
);

$html = '<div class="wolmart-icon-lists ' . esc_attr( $view ) . '-type align-items-' . esc_attr( 'block' == $view ? $icon_h_align : $icon_v_align ) . '">';

if ( $title ) {
	$html .= '<h4 class="list-title">' . wolmart_strip_script_tags( $title ) . '</h4>';
}

if ( is_array( $icon_list ) ) {
	foreach ( $icon_list as $icon_item ) {
		$html .= '<a href="' . ( empty( $icon_item['link']['url'] ) ? '#' : esc_url( $icon_item['link']['url'] ) ) . '" class="wolmart-icon-list-item">';
		if ( ! empty( $icon_item['selected_icon']['value'] ) ) {
			$html .= '<i class="' . esc_attr( $icon_item['selected_icon']['value'] ) . '"></i>';
		}
		$html .= wolmart_strip_script_tags( $icon_item['text'] ) . '</a>';
	}
}

$html .= '</div>';

echo do_shortcode( wolmart_escaped( $html ) );
