<?php
/**
 * Categories Shortcode Render
 *
 * @since 1.0.0
 */

$wrapper_attrs = array(
	'class' => 'wolmart-wpb-categories-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

// Preprocess
$atts['page_builder']        = 'wpb';
$atts['layout_type']         = 'grid';
$atts['count']               = isset( $atts['count'] ) ? array( 'size' => $atts['count'] ) : array( 'size' => 4 );
$atts['follow_theme_option'] = isset( $atts['follow_theme_option'] ) ? $atts['follow_theme_option'] : 'yes';
$atts['category_type']       = isset( $atts['category_type'] ) ? $atts['category_type'] : '';
$atts['col_sp']              = isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md';
$atts['content_origin']      = isset( $atts['content_origin'] ) ? $atts['content_origin'] : '';

// Responsive columns
$atts = array_merge( $atts, wolmart_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $atts['col_cnt'] ) {
	$atts['col_cnt'] = $atts['col_cnt_xl'];
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
// Categories Render
require __DIR__ . '/render-categories.php';
?>
</div>
<?php
