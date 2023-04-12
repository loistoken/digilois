<?php

defined( 'ABSPATH' ) || die;

/**
 * Wolmart Elementor Vendors Widget Render
 *
 * @since 1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Select Vendors
			'vendor_select_type' => 'individual',
			'vendor_ids'         => '',
			'vendor_category'    => '',
			'vendor_count'       => '',
			'vendor_period'      => '',
			'thumbnail_size'     => '',

			// Select Vendors Layout
			'col_cnt'            => array( 'size' => 4 ),
			'row_cnt'            => 1,
			'col_sp'             => '',
			'layout_type'        => 'grid',

			// Select Vendor Display Type
			'vendor_type'        => 'vendor-1',
			'vendor_show_info'   => array( 'name', 'avatar', 'rating', 'product_count', 'products' ),
			'show_vendor_link'   => '',
			'show_total_sale'    => '',
			'vendor_link_text'   => esc_html__( 'Browse This Vendor', 'wolmart-core' ),
		),
		$atts
	)
);

$vendors          = array();
$wrapper_class    = array();
$wrapper_attrs    = '';
$grid_space_class = wolmart_get_grid_space_class( $atts );
$col_cnt          = wolmart_elementor_grid_col_cnt( $atts );

$visible = array(
	'products'      => in_array( 'products', $vendor_show_info ),
	'avatar'        => in_array( 'avatar', $vendor_show_info ),
	'name'          => in_array( 'name', $vendor_show_info ),
	'product_count' => in_array( 'product_count', $vendor_show_info ),
	'rating'        => in_array( 'rating', $vendor_show_info ),
);

if ( 'group' == $vendor_select_type ) {
	if ( 'sale' == $vendor_category ) {
		$vendors = Wolmart_Vendors::get_top_selling_vendors( $vendor_count, $vendor_period );
	}

	if ( 'rating' == $vendor_category ) {
		$vendors = Wolmart_Vendors::get_top_rating_vendors( $vendor_count );
	}

	if ( 'recent' == $vendor_category && function_exists( 'wolmart_get_vendors' ) ) {
		$vendors = wolmart_get_vendors( array(), 'registered', $vendor_count );
	}

	if ( '' == $vendor_category && function_exists( 'wolmart_get_vendors' ) ) {
		$vendors = wolmart_get_vendors( array(), '', $vendor_count );
	}
} else {
	if ( ! is_array( $vendor_ids ) || 0 == count( $vendor_ids ) ) {
		if ( function_exists( 'wolmart_get_vendors' ) ) {
			$vendor_ids = wolmart_get_vendors();
	
			foreach ( $vendor_ids as $vid ) {
				$vendor['id'] = $vid['id'];
				$vendors[]    = $vendor;
			}
		}
	} else {
		foreach ( $vendor_ids as $id ) {
			$vendor['id'] = $id;
			$vendors[]    = $vendor;
		}
	}
}


if ( $grid_space_class ) {
	$wrapper_class[] = $grid_space_class;
}

if ( $col_cnt ) {
	$wrapper_class[] = wolmart_get_col_class( $col_cnt );
}

if ( 'slider' == $layout_type ) {
	$wrapper_class[] = wolmart_get_slider_class( $atts );

	$wrapper_class = implode( ' ', $wrapper_class );

	$wrapper_attrs = ' data-slider-options="' . esc_attr(
		json_encode(
			wolmart_get_slider_attrs( $atts, $col_cnt )
		)
	) . '"';

	echo '<div ' . $wrapper_attrs . ' class="wolmart-vendor-group ' . esc_attr( $wrapper_class ) . '">';
} else {
	$wrapper_class[] = wolmart_get_col_class( $col_cnt );

	$wrapper_class = implode( ' ', $wrapper_class );

	echo '<div class="wolmart-vendor-group ' . esc_attr( $wrapper_class ) . '">';
}

if ( 0 == count( $vendors ) ) {
	echo esc_html__( 'There are no vendors matched', 'wolmart-core' );
}

foreach ( $vendors as $vendor_no => $vendor ) {
	if ( class_exists( 'WeDevs_Dokan' ) ) {
		$vendor_info = wolmart_get_dokan_vendor_info( $vendor );
	} elseif ( class_exists( 'WCFM' ) ) {
		$vendor_info = wolmart_get_wcfm_vendor_info( $vendor );
	} elseif ( class_exists( 'WC_Vendors' ) ) {
		$vendor_info = wolmart_get_wc_vendor_info( $vendor );
	} elseif ( class_exists( 'WCMp' ) ) {
		$vendor_info = wolmart_get_wcmp_vendor_info( $vendor );
	} elseif ( defined( 'MVX_PLUGIN_VERSION' ) ) {
		$vendor_info = wolmart_get_mvx_vendor_info( $vendor );
	}

	if ( $vendor_info ) {
		$query = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'showposts'           => 3,
			'meta_key'            => 'total_sales',
			'orderby'             => 'meta_value_num',
			'author'              => $vendor_info['id'],
		);

		$list = new WP_Query( $query );

		if ( 'slider' == $layout_type && 1 < $row_cnt && 1 == ( $vendor_no + 1 ) % (int) $row_cnt ) {
			echo '<div>';
		}

		echo '<div class="vendor-widget-wrap">';

		if ( 'vendor-1' == $vendor_type ) { ?>
			<div class="vendor-widget vendor-widget-1">
				<?php if ( $visible['products'] && $list->have_posts() ) : ?>
				<div class="vendor-products grid-type gutter-xs">
					<?php
					$index = 0;
					while ( $list->have_posts() && $index < 3 ) {
						global $post;
						$list->the_post();
						$class = ( 0 == $index ) ? 'large-item' : ( ( 1 == $index ) ? 'small-item small-item-1' : 'small-item small-item-2' );
						?>
						<figure class="product-media <?php echo esc_attr( $class ); ?>">
							<a href="<?php esc_url( the_permalink() ); ?>">
							<?php
							echo  get_the_post_thumbnail( $post->ID, ( 'large-item' == $class ) ? $thumbnail_size : 'shop_thumbnail' );
							?>
							</a>
						</figure>
						<?php
						++ $index;
					}
					wp_reset_postdata();
					?>
				</div>
				<?php endif; ?>
				<div class="vendor-details">
	
					<?php if ( $visible['avatar'] ) : ?>
					<figure class="vendor-logo">
						<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>">
						<?php
						if ( class_exists( 'WCFM' ) ) {
							echo wp_get_attachment_image( $vendor_info['avatar_id'], 60, false, array( 'alt' => $vendor_info['store_name'] ) );
						} else {
							echo get_avatar( $vendor_info['id'], 60, '', $vendor_info['store_name'] );
						}
						?>
						</a>
					</figure>
					<?php endif; ?>
	
					<?php if ( $visible['name'] || $visible['product_count'] || $visible['rating'] || 'yes' == $show_total_sale ) : ?>
					<div class="vendor-personal">
						<?php if ( $visible['name'] ) : ?>
						<h4 class="vendor-name">
							<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>"  title="<?php echo esc_attr( $vendor_info['store_name'] ); ?>"><?php echo esc_html( $vendor_info['store_name'] ); ?></a>
						</h4>
						<?php endif; ?>
	
						<?php if ( $visible['product_count'] ) : ?>
						<span class="vendor-products-count">(<?php echo $vendor_info['products_count'] . esc_html__( ' Products', 'wolmart-core' ); ?>)</span>
						<?php endif; ?>
	
						<?php if ( $visible['rating'] ) : ?>
						<div class="ratings-container">
							<?php echo wc_get_rating_html( $vendor_info['rating'] ); ?>
						</div>
						<?php endif; ?>
	
						<?php if ( 'yes' == $show_total_sale ) : ?>
						<p class="vendor-sale">
							<?php echo get_woocommerce_currency_symbol() . round( $vendor_info['total_sale'], 2 ) . esc_html__( ' earned', 'wolmart-core' ); ?>
						</p>
						<?php endif; ?>
	
						<?php if ( 'yes' == $show_vendor_link ) : ?>
							<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>" class="visit-vendor-btn" title="<?php echo esc_attr( $vendor_info['store_name'] ); ?>"><?php echo esc_html( $vendor_link_text ); ?></a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
		} elseif ( 'vendor-2' == $vendor_type ) {
			?>
			<div class="vendor-widget vendor-widget-2">
				<div class="vendor-details">
					<?php if ( $visible['avatar'] ) : ?>
					<figure class="vendor-logo">
						<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>">
							<?php
							if ( class_exists( 'WCFM' ) ) {
								echo wp_get_attachment_image( $vendor_info['avatar_id'], 60, false, array( 'alt' => $vendor_info['store_name'] ) );
							} else {
								echo get_avatar( $vendor_info['id'], 60, '', $vendor_info['store_name'] );
							}
							?>
						</a>
					</figure>
					<?php endif; ?>
	
					<?php if ( $visible['name'] || $visible['product_count'] || $visible['rating'] || 'yes' == $show_total_sale ) : ?>
					<div class="vendor-personal">
						<?php if ( $visible['name'] ) : ?>
						<h4 class="vendor-name">
							<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>" title="<?php echo esc_attr( $vendor_info['store_name'] ); ?>"><?php echo esc_html( $vendor_info['store_name'] ); ?></a>
						</h4>
						<?php endif; ?>
	
						<?php if ( $visible['product_count'] ) : ?>
						<span class="vendor-products-count">(<?php echo esc_attr( $vendor_info['products_count'] ) . esc_html__( ' Products', 'wolmart-core' ); ?>)</span>
						<?php endif; ?>
	
						<?php if ( $visible['rating'] ) : ?>
						<div class="ratings-container">
							<?php echo wc_get_rating_html( $vendor_info['rating'] ); ?>
						</div>
						<?php endif; ?>
	
						<?php if ( 'yes' == $show_total_sale ) : ?>
						<p class="vendor-sale">
							<?php echo get_woocommerce_currency_symbol() . round( $vendor_info['total_sale'], 2 ) . esc_html__( ' earned', 'wolmart-core' ); ?>
						</p>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
				<?php if ( $visible['products'] && $list->have_posts() ) : ?>
				<div class="vendor-products row cols-3 gutter-sm">
					<?php
					$index = 0;
					while ( $list->have_posts() && $index < 3 ) {
						global $post;
						$list->the_post();
						?>
						<!-- <div class="vendor-product"> -->
						<figure class="product-media">
							<a href="<?php esc_url( the_permalink() ); ?>">
							<?php
							echo get_the_post_thumbnail( $post->ID, $thumbnail_size );
							?>
							</a>
						</figure>
						<!-- </div> -->
						<?php
						$index++;
					}
					wp_reset_postdata();
					?>
				</div>
				<?php endif; ?>
			</div>
			<?php
		} else {
			?>
			<div class="vendor-widget vendor-widget-3 vendor-widget-banner">
				<figure class="vendor-banner">
					<?php echo wp_get_attachment_image( $vendor_info['banner'], 'full', false, array( 'alt' => $vendor_info['store_name'] ) ); ?> 
				</figure>
	
				<div class="vendor-details">
					<?php if ( $visible['avatar'] ) : ?>
					<figure class="vendor-logo">
						<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>">
						<?php
						if ( class_exists( 'WCFM' ) ) {
							echo wp_get_attachment_image( $vendor_info['avatar_id'], 60 );
						} else {
							echo get_avatar( $vendor_info['id'], 60, '', $vendor_info['store_name'] );
						}
						?>
						</a>
					</figure>
					<?php endif; ?>
	
					<?php if ( $visible['name'] ) : ?>
					<h4 class="vendor-name">
						<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>" title="<?php echo esc_attr( $vendor_info['store_name'] ); ?>"><?php echo esc_html( $vendor_info['store_name'] ); ?></a>
					</h4>
					<?php endif; ?>
	
					<?php if ( $visible['rating'] ) : ?>
					<div class="ratings-container">
						<?php
						echo wc_get_rating_html( $vendor_info['rating'] );
						?>
					</div>
					<?php endif; ?>
	
					<?php if ( $visible['product_count'] ) : ?>
					<p class="vendor-products-count"><?php echo $vendor_info['products_count'] . esc_html__( ' Products', 'wolmart-core' ); ?> </p>
					<?php endif; ?>
	
					<?php if ( 'yes' == $show_vendor_link ) : ?>
					<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>" class="visit-vendor-btn" title="<?php echo esc_attr( $vendor_info['store_name'] ); ?>"><?php echo esc_html( $vendor_link_text ); ?></a>
					<?php endif; ?>
	
					<?php if ( $visible['products'] && $list->have_posts() ) : ?>
					<div class="vendor-products row cols-3 gutter-sm">
						<?php
						$index = 0;
						while ( $list->have_posts() && $index < 3 ) {
							global $post;
							$list->the_post();
							?>
							<figure class="product-media">
								<a href="<?php esc_url( the_permalink() ); ?>">
								<?php
								echo get_the_post_thumbnail( $post->ID, $thumbnail_size );
								?>
								</a>
							</figure>
							<?php
							$index++;
						}
						wp_reset_postdata();
						?>
					</div>
					<?php endif; ?>
	
					<?php if ( 'yes' == $show_total_sale ) : ?>
					<p class="vendor-sale">
						<?php echo get_woocommerce_currency_symbol() . round( $vendor_info['total_sale'], 2 ) . esc_html__( ' earned', 'wolmart-core' ); ?>
					</p>
					<?php endif; ?>
				</div>
	
			</div>
				<?php
		}
		echo '</div>';

		if ( 'slider' == $layout_type && 1 < $row_cnt && 0 == ( $vendor_no + 1 ) % (int) $row_cnt ) {
			echo '</div>';
		}
	}
}
echo '</div>';
