<?php
extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'brands'                     => array(),
			'hide_empty'                 => '',
			'orderby'                    => 'name',
			'orderway'                   => 'ASC',
			'count'                      => 0,

			'thumbnail_size'             => 'woocommerce_thumbnail',
			'thumbnail_custom_dimension' => '',

			'layout_type'                => 'grid',
			'row_cnt'                    => '1',
			'col_sp'                     => '',
			'col_cnt'                    => array( 'size' => 4 ),
			'slider_image_expand'        => '',

			'brand_type'                 => '1',
			'show_brand_rating'          => '',
			'show_brand_products'        => '',
		),
		$atts
	)
);

if ( 0 === (int) $row_cnt ) {
	$row_cnt = 1;
}

if ( ! is_array( $brands ) ) {
	$brands = explode( ',', $brands );
}

if ( $brands ) {
	$brands = get_terms(
		'product_brand',
		array(
			'taxonomy'     => 'product_brand',
			'hierarchical' => false,
			'hide_empty'   => 'yes' == $hide_empty ? true : false,
			'include'      => implode( ',', $brands ),
			'orderby'      => 'include',
			'order'        => $orderway,
			'number'       => $count,
		)
	);
} else {
	$brands = get_terms(
		'product_brand',
		array(
			'taxonomy'     => 'product_brand',
			'hierarchical' => false,
			'hide_empty'   => 'yes' == $hide_empty ? true : false,
			'orderby'      => $orderby,
			'order'        => $orderway,
			'number'       => $count,
		)
	);
}

$brand_arr = array();

if ( ! empty( $brands ) ) {
	foreach ( $brands as $brand ) {
		$brand_arr[] = (object) array(
			'term_id'      => $brand->term_id,
			'thumbnail_id' => absint( get_term_meta( $brand->term_id, 'brand_thumbnail_id', true ) ),
			'slug'         => $brand->slug,
			'name'         => $brand->name,
		);
	}
}


// Layout

$wrapper_class = array();
$wrapper_attrs = '';

$grid_space_class = wolmart_get_grid_space_class( $atts );

if ( $grid_space_class ) {
	$wrapper_class[] = $grid_space_class;
}

$col_cnt = wolmart_elementor_grid_col_cnt( $atts );

if ( $col_cnt ) {
	$wrapper_class[] = wolmart_get_col_class( $col_cnt );
}

if ( 'slider' == $layout_type ) {

	$wrapper_class[] = wolmart_get_slider_class( $atts );

	if ( 'yes' != $slider_image_expand ) {
		$wrapper_class[] = 'slider-image-org';
	}

	$wrapper_class = implode( ' ', $wrapper_class );

	$wrapper_attrs = ' data-slider-options="' . esc_attr(
		json_encode(
			wolmart_get_slider_attrs( $atts, $col_cnt )
		)
	) . '"';

	echo '<div ' . $wrapper_attrs . ' class="product-brands ' . esc_attr( $wrapper_class ) . '">';

} else { // render brands with creative grid

	$wrapper_class[] = wolmart_get_col_class( $col_cnt );

	$wrapper_class = implode( ' ', $wrapper_class );

	echo '<div class="product-brands ' . esc_attr( $wrapper_class ) . '">';
}

$count = 1;

foreach ( $brand_arr as $brand ) {

	if ( 'slider' == $layout_type && 1 != (int) $row_cnt && 1 == $count % (int) $row_cnt ) { // make more than 2 rows slider
		echo '<div class="brand-widget-col">';
	}
	echo '<div class="brand-widget-wrap">';
	if ( 1 == $brand_type ) {
		?>
		<figure class="brand-widget-1">
			<a href="<?php echo esc_url( get_term_link( $brand->term_id, 'product_brand' ) ); ?>">
				<?php
				if ( $brand->thumbnail_id ) {
					echo wp_get_attachment_image( $brand->thumbnail_id, $thumbnail_size );
				} else {
					echo wc_placeholder_img( $thumbnail_size );
				}
				?>
			</a>
		</figure>
		<?php
	} elseif ( 2 == $brand_type ) {
		?>
		<div class="brand-widget brand-widget-2 brand-widget-circle">
			<?php
			// Get products by brand
			$args = array(
				'post_type' => 'product',
				'tax_query' => array(
					array(
						'taxonomy' => 'product_brand',
						'field'    => 'slug',
						'terms'    => sanitize_text_field( $brand->slug ),
						'operator' => 'IN',
					),
				),
				'meta_key'  => 'total_sales',
				'orderby'   => 'meta_value_num',
			);

			$list = new WP_Query( $args );

			if ( $list->have_posts() ) {
				$index = 0;
				while ( $list->have_posts() && $index < 1 ) {
					global $post;

					$list->the_post();
					?>
					<figure class="brand-product-media">
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
			}
			if ( 'yes' == $show_brand_rating ) :
				?>
			<div class="ratings-container">
				<?php
				$rating = get_term_meta( $brand->term_id, 'rating', true ) ? get_term_meta( $brand->term_id, 'rating', true ) : 0;
				echo wc_get_rating_html( $rating );
				?>
			</div>
			<?php endif; ?>
			<h4 class="brand-name">
				<a href="<?php echo esc_url( get_term_link( $brand->term_id, 'product_brand' ) ); ?>"><?php echo esc_html( $brand->name ); ?></a>
			</h4>
		</div>
		<?php
	} else {
		?>
		<div class="brand-widget brand-widget-3">
			<?php
			$args = array(
				'post_type' => 'product',
				'tax_query' => array(
					array(
						'taxonomy' => 'product_brand',
						'field'    => 'slug',
						'terms'    => sanitize_text_field( $brand->slug ),
						'operator' => 'IN',
					),
				),
				'meta_key'  => 'total_sales',
				'orderby'   => 'meta_value_num',
				'posts_per_page' => 3,
			);
			$list = new WP_Query( $args );
			?>

			<div class="brand-detail">
				<figure class="brand-logo">
					<a href="<?php echo esc_url( get_term_link( $brand->term_id, 'product_brand' ) ); ?>">
						<?php echo wp_get_attachment_image( $brand->thumbnail_id, $thumbnail_size ); ?>
					</a>
				</figure>
				<div class="brand-info">
					<h4 class="brand-name">
						<a href="<?php echo esc_url( get_term_link( $brand->term_id, 'product_brand' ) ); ?>"><?php echo esc_html( $brand->name ); ?></a>
					</h4>
					<span class="brand-product-count">(<?php echo esc_attr( $list->found_posts ) . esc_html__( ' Products', 'wolmart-core' ); ?> )</span>
					<?php
					if ( 'yes' == $show_brand_rating ) :
						?>
					<div class="ratings-container">
						<?php
						$rating = get_term_meta( $brand->term_id, 'rating', true ) ? get_term_meta( $brand->term_id, 'rating', true ) : 0;
						echo wc_get_rating_html( $rating );
						?>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php if ( $list->have_posts() && 'yes' == $show_brand_products ) : ?>
				<div class="brand-products row cols-3 gutter-xs">
					<?php
					$index = 0;
					while ( $list->have_posts() && $index < 3 ) {
						global $post;
						$list->the_post();
						?>
						<div class="brand-product">
							<figure class="product-media">
								<a href="<?php esc_url( the_permalink() ); ?>">
								<?php
								echo get_the_post_thumbnail( $post->ID, $thumbnail_size );
								?>
								</a>
							</figure>
						</div>
						<?php
						$index++;
					}
					wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
	++$count;
	echo '</div>';
	if ( 'slider' == $layout_type && 1 != (int) $row_cnt && 1 == $count % (int) $row_cnt ) {
		echo '</div>';
	}
}

echo '</div>';
