<?php
/**
 * Header Language Switcher Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-hb-language-switcher-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
	<?php require __DIR__ . '/render-language-switcher-elementor.php'; ?>
</div>
<?php
