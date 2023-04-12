<?php
/**
 * Countdown Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
wp_enqueue_script( 'jquery-countdown' );

$wrapper_attrs = array(
	'class' => 'wolmart-countdown-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
// countdown Render
require __DIR__ . '/render-countdown-elementor.php';
?>
</div>
<?php
// Frontend Editor
if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
	$selector = '.' . str_replace( ' ', '', $atts['shortcode_class'] );
	?>
		<script>Wolmart.countdown('<?php echo wolmart_strip_script_tags( $selector ); ?> .countdown');</script>
	<?php
}
