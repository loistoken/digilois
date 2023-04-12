<?php
/**
 * InfoBox Shortcode Render
 *
 * @since 1.0.0
 */


// Preprocess
if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'text'          => esc_html( 'List Item', 'wolmart-core' ),
			'selected_icon' => 'fas fa-check',
			'link'          => '',
			'class'         => '',

		),
		$atts
	)
);

$wrapper_attrs = array(
	'class' => 'wolmart-icon-list-item ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

if ( ! empty( $link ) && isset( $link['url'] ) ) {
	$list_url = $link['url'];
} else {
	$list_url = '#';
}
$wrapper_attrs['href'] = esc_url( $list_url );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

echo '<a ' . wolmart_escaped( $wrapper_attr_html ) . '>';

if ( ! empty( $selected_icon ) ) {
	echo '<i class="' . esc_attr( $selected_icon ) . '"></i>';
}
echo wolmart_escaped( $text );
?>
</a>
<?php
