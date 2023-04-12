<?php
/**
 * Single Prodcut Counter Render
 *
 * @since 1.0.0
 */

wp_enqueue_script( 'jquery-count-to' );

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'starting_number'         => 0,
			'ending_number'           => 'sale',
			'adding_number'           => 0,
			'prefix'                  => '',
			'suffix'                  => '',
			'duration'                => 0,
			'thousand_separator'      => 'yes',
			'thousand_separator_char' => '',
			'title'                   => esc_html__( 'Sale Products', 'wolmart-core' ),
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-sp-counter-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

if ( false == is_int( $starting_number ) || false == is_int( $adding_number ) || false == is_int( $duration ) ) {
	$starting_number = intval( $starting_number );
	$adding_number   = intval( $adding_number );
	$duration        = intval( $duration );
}
?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {

	global $product;

	if ( 'sale' == $ending_number ) {
		$count_to = $product->get_total_sales();
	} else {
		$count_to = $product->get_stock_quantity();
	}

	if ( $adding_number ) {
		$count_to += $adding_number;
	}

	$counter_attrs = array(
		'class'      => 'wpb-sp-counter-number count-to',
		'data-speed' => $duration,
		'data-to'    => $count_to,
		'data-from'  => $starting_number,
	);

	if ( ! empty( $thousand_separator ) ) {
		$delimiter                       = empty( $thousand_separator_char ) ? ',' : $thousand_separator_char;
		$counter_attrs['data-delimiter'] = $thousand_separator_char;
	}

	$counter_attrs_html = '';
	foreach ( $counter_attrs as $key => $value ) {
		$counter_attrs_html .= $key . '="' . $value . '" ';
	}
	?>
	<div class = "wpb-sp-counter-number-wrapper counter">
		<?php
		echo '<span class="wpb-sp-wolmart-counter-number-prefix">' . wolmart_escaped( $prefix ) . '</span>';
		echo '<span ' . wolmart_escaped( $counter_attrs_html ) . '>' . wolmart_escaped( $starting_number ) . '</span>';
		echo '<span class="wpb-sp-wolmart-counter-number-suffix">' . wolmart_escaped( $suffix ) . '</span>';
		?>
	</div>
	<?php if ( $title ) : ?>
		<div class="wpb-sp-counter-title"><?php echo wolmart_escaped( $title ); ?></div>
	<?php endif; ?>
	<?php
	do_action( 'wolmart_single_product_builder_unset_product' );
}
?>
</div>
<?php
