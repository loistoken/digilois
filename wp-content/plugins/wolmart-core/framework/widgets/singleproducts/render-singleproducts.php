<?php

defined( 'ABSPATH' ) || die;

/**
 * Wolmart Single Product Widget Render
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Products Selector
			'product_ids'     => '',
			'categories'      => '',
			'status'          => '',
			'count'           => array( 'size' => 10 ),
			'orderby'         => '',
			'orderway'        => 'ASC',
			'order_from'      => '',
			'order_from_date' => '',
			'order_to'        => '',
			'order_to_date'   => '',
			'hide_out_date'   => '',

			// Single Product
			'sp_title_tag'    => 'h2',
			'sp_gallery_type' => '',
			'sp_show_info'    => '',
			'page_builder'    => 'elementor',
		),
		$atts
	)
);

include_once WOLMART_CORE_PLUGINS . '/elementor/partials/products.php';

do_action( 'wolmart_enqueue_product_widget_related_scripts' );

if ( 'wpb' == $page_builder && $sp_show_info ) {
	$atts['sp_show_info'] = explode( ',', $sp_show_info );
}

// Parse product IDs or slugs
if ( ! empty( $product_ids ) && is_string( $product_ids ) ) {

	$product_ids = explode( ',', str_replace( ' ', '', esc_attr( $product_ids ) ) );

	if ( defined( 'WOLMART_VERSION' ) ) {
		for ( $i = 0; isset( $product_ids[ $i ] );  ++ $i ) {
			if ( ! is_numeric( $product_ids[ $i ] ) ) {
				$product_ids[ $i ] = wolmart_get_post_id_by_name( 'product', $product_ids[ $i ] );
			}
		}
	}
}


// Only 1 Single Product ////////////////////////////////////////////////////////////////////////

if ( $product_ids && 1 == count( $product_ids ) ) {
	global $post, $product;
	$original_post    = $post;
	$original_product = $product;
	$post             = get_post( $product_ids[0] );
	$product          = wc_get_product( $post );
	if ( $product ) {
		wolmart_set_single_product_widget( $atts );
		wc_get_template_part( 'content', 'single-product' );
		wolmart_unset_single_product_widget( $atts );
	}

	$post    = $original_post;
	$product = $original_product;

} else {
	// Several Single Products ///////////////////////////////////////////////////////////////////

	// Get Count
	if ( ! is_array( $count ) ) {
		$count = json_decode( $count, true );
	} else {
		$count = (int) $count['size'];
	}



	if ( $categories && ! is_array( $categories ) ) {
		$categories = explode( ',', $categories );
	}

	$query_args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'posts_per_page'      => $count,
		'fields'              => 'ids',
		'orderby'             => wc_clean( wp_unslash( $orderby ) ),
		'meta_query'          => WC()->query->get_meta_query(),
		'tax_query'           => array(),
	);

	// product status
	if ( 'featured' == $status ) {
		$query_args['tax_query'][] = array(
			'taxonomy'         => 'product_visibility',
			'terms'            => 'featured',
			'field'            => 'name',
			'operator'         => 'IN',
			'include_children' => false,
		);
	} elseif ( 'sale' == $status ) {
		$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
	} elseif ( 'related' == $status || 'upsell' == $status ) {
		global $product;
		if ( ! empty( $product ) ) {
			if ( 'related' == $status ) {
				$product_ids = wc_get_related_products( $product->get_id(), $count, $product->get_upsell_ids() );
			} else {
				$product_ids = $product->get_upsell_ids();
			}
		}
	}

	// If not empty linked products for single product
	if ( ! ( ( 'related' == $status || 'upsell' == $status ) && is_array( $product_ids ) && count( $product_ids ) == 0 ) ) {
		if ( $product_ids ) {
			if ( is_string( $product_ids ) ) {
				// custom IDs
				$product_ids = explode( ',', str_replace( ' ', '', esc_attr( $product_ids ) ) );
				if ( defined( 'WOLMART_VERSION' ) ) {
					for ( $i = 0; isset( $product_ids[ $i ] );  ++ $i ) {
						if ( ! is_numeric( $product_ids[ $i ] ) ) {
							$product_ids[ $i ] = wolmart_get_post_id_by_name( 'product', $product_ids[ $i ] );
						}
					}
				}
			}
			if ( is_array( $product_ids ) ) {
				$query_args['post__in'] = $product_ids;
				$query_args['orderby']  = 'post__in';
			}
		} else {
			// custom ordering
			$query_args['order']   = esc_attr( $orderway );
			$query_args['orderby'] = esc_attr( $orderby );

			if ( $order_from ) {
				if ( 'custom' == $order_from && $order_from_date ) {
					set_query_var( 'order_from', esc_attr( $order_from_date ) );
				} elseif ( 'custom' !== $order_from ) {
					set_query_var( 'order_from', esc_attr( $order_from ) );
				}
			}
			if ( $order_to ) {
				if ( 'custom' == $order_to && $order_to_date ) {
					set_query_var( 'order_to', esc_attr( $order_to_date ) );
				} elseif ( 'custom' !== $order_to ) {
					set_query_var( 'order_to', esc_attr( $order_to ) );
				}
			}
			set_query_var( 'hide_out_date', $hide_out_date );
		}

		if ( is_array( $categories ) && count( $categories ) ) {
			// custom categories
			$query_args['tax_query'] = array_merge(
				WC()->query->get_tax_query(),
				array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => esc_attr( implode( ',', $categories ) ),
					),
				)
			);
		}
	}

	$query = new WP_Query( $query_args );

	if ( $query->have_posts() && defined( 'WC_ABSPATH' ) ) {
		wolmart_set_single_product_widget( $atts );

		// Loop products
		global $post, $product;
		$original_post    = $post;
		$original_product = $product;
		$product_ids      = $query->posts;
		update_meta_cache( 'post', $product_ids );
		update_object_term_cache( $product_ids, 'product' );

		if ( $query->post_count > 1 ) {
			if ( 'wpb' == $page_builder ) {
				echo '<div class="slider-frame">';
			}
			?>
			<div class="products-flipbook row cols-1 <?php echo wolmart_get_slider_class( $atts ); ?>"
				data-slider-options="<?php echo esc_attr( json_encode( wolmart_get_slider_attrs( $atts, array( 'lg' => 1 ) ) ) ); ?>">
			<?php
		}

		foreach ( $product_ids as $product_id ) {
			$post = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $post );
			$product = wc_get_product( $post );
			if ( $product ) {
				$product = wc_get_product( $post );
			}
			wc_get_template_part( 'content', 'single-product' );
		}
		if ( $query->post_count > 1 ) {
			?>
			</div>
			<?php
			if ( 'wpb' == $page_builder ) {
				echo '</div>';
			}
		}

		wolmart_unset_single_product_widget( $atts );
		$post    = $original_post;
		$product = $original_product;
		wp_reset_postdata();
	}
}
