<?php
/**
 * Masonry Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-masonry-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$settings = array(
	'creative_mode'         => isset( $atts['creative_mode'] ) ? $atts['creative_mode'] : 1,
	'col_sp'                => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
	'creative_height'       => isset( $atts['creative_height'] ) ? $atts['creative_height'] : 600,
	'creative_height_ratio' => isset( $atts['creative_height_ratio'] ) ? $atts['creative_height_ratio'] : 75,
	'grid_float'            => isset( $atts['grid_float'] ) ? $atts['grid_float'] : '',
);

$wrapper_attrs['class'] .= ' grid creative-grid gutter-' . $settings['col_sp'] . ' grid-mode-' . $settings['creative_mode'];

if ( isset( $settings['grid_float'] ) && 'yes' == $settings['grid_float'] ) {
	$wrapper_attrs['class'] .= ' grid-float';
} else {
	wp_enqueue_script( 'isotope-pkgd' );
}

global $wolmart_wpb_creative_layout;
$wolmart_wpb_creative_layout = array(
	'preset' => wolmart_creative_layout( $settings['creative_mode'] ),
	'layout' => array(), // layout of children
	'index'  => 0, // index of children
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

$wrapper_attr_html .= "data-creative-breaks='" . json_encode(
	array(
		'sm' => 576,
		'md' => 768,
		'lg' => 992,
		'xl' => 1200,
	)
) . "' ";

if ( vc_is_inline() ) {
	$wrapper_attr_html .= 'data-creative-preset=' . json_encode( $wolmart_wpb_creative_layout['preset'] );
	$wrapper_attr_html .= ' data-creative-id="' . str_replace( ' ', '', $atts['shortcode_class'] ) . '"';
	$wrapper_attr_html .= ' data-creative-height="' . $settings['creative_height'] . '"';
	$wrapper_attr_html .= ' data-creative-height-ratio="' . $settings['creative_height_ratio'] . '"';
}

$content_escaped = do_shortcode( $atts['content'] );

wolmart_creative_layout_style(
	'.' . str_replace( ' ', '', $atts['shortcode_class'] ),
	$wolmart_wpb_creative_layout['layout'],
	$settings['creative_height'],
	$settings['creative_height_ratio'],
	true
);

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
echo wolmart_escaped( $content_escaped );
echo '<div class="grid-space"></div>';
?>
</div>
<?php
