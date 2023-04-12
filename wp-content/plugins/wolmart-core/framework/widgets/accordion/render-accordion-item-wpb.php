<?php
/**
 * Accordion Item Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-accordion-item-container card ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

$settings = array(
	'card_title' => isset( $atts['card_title'] ) ? $atts['card_title'] : esc_html( 'Card Item', 'wolmart-core' ),
	'card_icon'  => isset( $atts['card_icon'] ) ? $atts['card_icon'] : '',
);

global $wolmart_wpb_accordion;
?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<div class="card-header">
	<a href="#" class="<?php echo isset( $wolmart_wpb_accordion ) && 0 == $wolmart_wpb_accordion['index'] ? 'collapse' : 'expand'; ?>">
	<?php
	if ( $settings['card_icon'] ) {
		echo '<i class="' . esc_attr( $settings['card_icon'] ) . '"></i>';
	}
		echo '<span class="title">' . esc_html( $settings['card_title'] ) . '</span>';
	if ( isset( $wolmart_wpb_accordion ) ) {
		if ( $wolmart_wpb_accordion['accordion_icon'] ) {
			echo '<span class="toggle-icon opened"><i class="' . esc_attr( $wolmart_wpb_accordion['accordion_active_icon'] ) . '"></i></span>';
		}
		if ( $wolmart_wpb_accordion['accordion_active_icon'] ) {
			echo '<span class="toggle-icon closed"><i class="' . esc_attr( $wolmart_wpb_accordion['accordion_icon'] ) . '"></i></span>';
		}
	}
	?>
	</a>
</div>
<div class="card-body <?php echo isset( $wolmart_wpb_accordion ) && 0 == $wolmart_wpb_accordion['index'] ? 'expanded' : 'collapsed'; ?>">
<?php
echo do_shortcode( $atts['content'] );
?>
</div>
</div>
<?php
if ( isset( $wolmart_wpb_accordion ) ) {
	$wolmart_wpb_accordion['index'] ++;
}
