<?php
/**
 * Vendor Shortcode Render
 *
 * @since 1.0.0
 */


// Preprocess
if ( ! empty( $atts['count'] ) ) {
	$atts['count'] = array(
		'size' => (int) $atts['count'],
	);
}

if ( empty( $atts['col_sp'] ) ) {
	$atts['col_sp'] = 'md';
}
$atts['page_builder'] = 'wpb';

// Columns
if ( ! empty( $atts['col_cnt'] ) ) {

	$columns                = json_decode( str_replace( '``', '"', $atts['col_cnt'] ), true );
	$atts['col_cnt_xl']     = $columns['xl'];
	$atts['col_cnt']        = empty( $columns['lg'] ) ? $columns['xl'] : $columns['lg'];
	$atts['col_cnt_tablet'] = $columns['md'];
	$atts['col_cnt_mobile'] = $columns['sm'];
	$atts['col_cnt_min']    = $columns['xs'];
}

$wrapper_attrs = array(
	'class' => 'wolmart-wpb-vendors-container ' . $atts['shortcode_class'] . $atts['style_class'] . ( ! empty( $atts['el_class'] ) ? ( ' ' . $atts['el_class'] ) : '' ),
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

if ( ! empty( $atts['vendor_show_info'] ) ) {
	$atts['vendor_show_info'] = explode( ',', $atts['vendor_show_info'] );
}

if ( ! empty( $atts['vendor_ids'] ) ) {
	$atts['vendor_ids'] = explode( ',', $atts['vendor_ids'] );

	// no one is selected.
	if ( 1 == count( $atts['vendor_ids'] ) && '' == $atts['vendor_ids'][0] ) {
		$atts['vendor_ids'] = [];
	}
}



?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
// vendor Render
require __DIR__ . '/render-vendor.php';
?>
</div>
<?php
