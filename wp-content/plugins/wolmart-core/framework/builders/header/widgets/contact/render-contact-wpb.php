<?php
/**
 * Header Contact Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-hb-contact-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

if ( ! empty( $atts['contact_telephone_link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['contact_telephone_link'] = vc_build_link( $atts['contact_telephone_link'] );
}

$atts = array(
	'live_chat'      => isset( $atts['contact_link_text'] ) ? $atts['contact_link_text'] : esc_html__( 'Live Chat', 'wolmart-core' ),
	'live_chat_link' => isset( $atts['link'] ) ? $atts['link'] : '',
	'tel_num'        => isset( $atts['contact_telephone'] ) ? $atts['contact_telephone'] : esc_html__( '0(800)123-456', 'wolmart-core' ),
	'tel_num_link'   => isset( $atts['contact_telephone_link'] ) ? $atts['contact_telephone_link'] : '',
	'delimiter'      => isset( $atts['contact_delimiter'] ) ? $atts['contact_delimiter'] : esc_html__( 'or:', 'wolmart-core' ),
	'icon'           => isset( $atts['contact_icon'] ) && $atts['contact_icon'] ? $atts['contact_icon'] : 'w-icon-call',
);

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
	<?php require __DIR__ . '/render-contact-elementor.php'; ?>
</div>
<?php
