<?php
/**
 * Menu Shortcode Render
 *
 * @since 1.0.0
 */

if ( isset( $atts['icon'] ) ) {
	$atts['icon'] = array(
		'value' => $atts['icon'],
	);
}

$atts['builder'] = 'wpb';

$wrapper_attrs = array(
	'class' => 'wolmart-menu-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
// Menu Render
require __DIR__ . '/render-menu.php';
?>
</div>
<?php
