<?php
/**
 * Header Search Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-hb-search-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

$args = array(
	'aria_label' => array(
		'type'             => isset( $atts['type'] ) ? $atts['type'] : 'hs-simple',
		'where'            => 'header',
		'search_post_type' => isset( $atts['search_type'] ) ? $atts['search_type'] : '',
		'search_label'     => isset( $atts['label'] ) ? $atts['label'] : '',
		'placeholder'      => isset( $atts['placeholder'] ) && $atts['placeholder'] ? $atts['placeholder'] : esc_html__( 'Search in...', 'wolmart-core' ),
		'search_right'     => false,
		'icon'             => isset( $atts['icon'] ) && $atts['icon'] ? $atts['icon'] : 'w-icon-search',
	),
);

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
// HB Search Render
get_search_form( $args );
?>
</div>
<?php
