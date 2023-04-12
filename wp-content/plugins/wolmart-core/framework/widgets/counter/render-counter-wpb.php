<?php
/**
 * Wolmart Counter Render
 *
 * @since 1.0.0
 */

wp_enqueue_script( 'jquery-count-to' );

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'starting_number'         => 0,
			'res_number'              => 50,
			'prefix'                  => '',
			'suffix'                  => '',
			'duration'                => 0,
			'thousand_separator'      => 'yes',
			'thousand_separator_char' => '',
			'title'                   => esc_html__( 'Cool Number', 'wolmart-core' ),
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-counter-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

if ( false == is_int( $starting_number ) || false == is_int( $res_number ) || false == is_int( $duration ) ) {
	$starting_number = intval( $starting_number );
	$res_number      = intval( $res_number );
	$duration        = intval( $duration );
}
?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php


	$counter_attrs = array(
		'class'      => 'wpb-wolmart-counter-number count-to',
		'data-speed' => $duration,
		'data-to'    => $res_number,
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
		<div class = "wpb-wolmart-counter-number-wrapper counter">
			<?php
			echo '<span class="wpb-wolmart-counter-number-prefix">' . wolmart_escaped( $prefix ) . '</span>';
			echo '<span ' . wolmart_escaped( $counter_attrs_html ) . '>' . wolmart_escaped( $starting_number ) . '</span>';
			echo '<span class="wpb-wolmart-counter-number-suffix">' . wolmart_escaped( $suffix ) . '</span>';
			?>
		</div>
		<?php if ( $title ) : ?>
			<h3 class="wpb-wolmart-counter-title mb-0"><?php echo wolmart_escaped( $title ); ?></h3>
		<?php endif; ?>
	<?php
	do_action( 'wolmart_single_product_builder_unset_product' );

	?>
</div>
<?php
