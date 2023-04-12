<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Products Banner Widget Render
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'banner_insert'        => '',
			'layout_type'          => 'grid',
			'creative_cols'        => '',
			'creative_cols_tablet' => '',
			'creative_cols_mobile' => '',
			'items_list'           => '',
		),
		$atts
	)
);

if ( is_array( $items_list ) ) {
	$repeater_ids = array();
	foreach ( $items_list as $item ) {
		$repeater_ids[ (int) $item['item_no'] ] = 'elementor-repeater-item-' . $item['_id'];
	}
	wc_set_loop_prop( 'repeater_ids', $repeater_ids );
}
$GLOBALS['wolmart_current_product_id'] = 0;

ob_start();
require wolmart_core_path( '/widgets/banner/render-banner-elementor.php' );
$banner_html = ob_get_clean();

wc_set_loop_prop( 'product_banner', $banner_html );
wc_set_loop_prop( 'banner_insert', $banner_insert );

wolmart_products_widget_render( $atts );

if ( isset( $GLOBALS['wolmart_current_product_id'] ) ) {
	unset( $GLOBALS['wolmart_current_product_id'] );
}
