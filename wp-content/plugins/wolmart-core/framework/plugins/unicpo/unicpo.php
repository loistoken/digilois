<?php
/**
 * Uni CPO Compatibility
 *
 * @since 1.1.0
 */

remove_filter( 'woocommerce_loop_add_to_cart_link', 'uni_cpo_add_to_cart_button', 10 );
add_filter( 'woocommerce_loop_add_to_cart_link', 'wolmart_uni_cpo_add_to_cart_button', 10, 3 );

add_action( 'wp_enqueue_scripts', 'wolmart_uni_cpo_style', 50 );

if ( ! function_exists( 'wolmart_uni_cpo_add_to_cart_button' ) ) {
	function wolmart_uni_cpo_add_to_cart_button( $link, $product, $args ) {
		$product_id   = intval( $product->get_id() );
		$product_data = Uni_Cpo_Product::get_product_data_by_id( $product_id );

		if ( $product->is_in_stock() ) {
			$button_text = esc_html__( 'Select options', 'uni-cpo' );
		} else {
			$button_text = esc_html__( 'Out of stock / See details', 'uni-cpo' );
		}

		$class  = $args['class'];
		$class  = str_replace( array( 'product_type_simple', 'add_to_cart_button' ), '', $class );
		$class .= ' product_type_variable product-unicpo';

		if ( 'on' === $product_data['settings_data']['cpo_enable'] ) {
			$link = sprintf(
				'<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s" %s>%s</a>',
				esc_url( get_permalink( $product_id ) ),
				esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $class ) ? $class : 'button' ),
				isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
				esc_html( $button_text )
			);
		}
		return $link;
	}
}

if ( ! function_exists( 'wolmart_uni_cpo_style' ) ) {
	function wolmart_uni_cpo_style() {
		wp_enqueue_style( 'wolmart-uni-cpo-style', WOLMART_CORE_PLUGINS_URI . '/unicpo/unicpo' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array( 'wolmart-style' ), WOLMART_VERSION );
	}
}
