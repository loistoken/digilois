<?php
defined( 'ABSPATH' ) || die;


extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Single Product
			'sp_id'                => '',
			'sp_insert'            => '',
			'sp_show_in_box'       => '',
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

if ( $sp_show_in_box ) {
	wc_set_loop_prop( 'sp_show_in_box', 1 );
}

if ( $sp_id ) {
	$selected_post = false;

	if ( ! is_numeric( $sp_id ) && is_string( $sp_id ) ) {
		$sp_id = wolmart_get_post_id_by_name( 'product', $sp_id );
	}

	if ( $sp_id ) {
		$selected_post = get_post( $sp_id );
	}

	if ( $selected_post ) {
		wolmart_set_single_product_widget( $atts );
		global $post, $product;
		$original_post    = $post;
		$original_product = $product;
		$post             = get_post( $selected_post );
		$product          = wc_get_product( $post );
		setup_postdata( $selected_post );

		ob_start();
		wc_get_template_part( 'content', 'single-product' );
		$single_product_html = ob_get_clean();

		wolmart_unset_single_product_widget( $atts );
		$post    = $original_post;
		$product = $original_product;
		wp_reset_postdata();

		wc_set_loop_prop( 'single_in_products', $single_product_html );
		wc_set_loop_prop( 'sp_id', $sp_id );
		wc_set_loop_prop( 'sp_insert', $sp_insert );
	}
} else {
	wc_set_loop_prop( 'products_single_atts', $atts );
}

$GLOBALS['wolmart_current_product_id'] = 0;

wolmart_products_widget_render( $atts );

if ( isset( $GLOBALS['wolmart_current_product_id'] ) ) {
	unset( $GLOBALS['wolmart_current_product_id'] );
}
