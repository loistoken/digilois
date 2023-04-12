<?php
/**
 * Single Prodcut Navigation Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-sp-navigation-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
$prev_icon = isset( $atts['sp_prev_icon'] ) ? $atts['sp_prev_icon'] : 'w-icon-angle-left';
$next_icon = isset( $atts['sp_next_icon'] ) ? $atts['sp_next_icon'] : 'w-icon-angle-right';
if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {
	add_filter( 'wolmart_check_single_next_prev_nav', '__return_true' );
	add_filter(
		'wolmart_single_product_nav_prev_icon',
		function( $prev_icon ) {
			return $prev_icon;
		}
	);
	add_filter(
		'wolmart_single_product_nav_next_icon',
		function( $next_icon ) {
			return $next_icon;
		}
	);

	echo '<div class="product-navigation">' . wolmart_single_product_navigation() . '</div>';

	do_action( 'wolmart_single_product_builder_unset_product' );
}
?>
</div>
<?php
