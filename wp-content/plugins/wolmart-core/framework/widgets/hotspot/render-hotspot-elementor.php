<?php

use Elementor\Group_Control_Image_Size;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'type'           => 'html',
			'html'           => '',
			'block'          => '',
			'link'           => '#',
			'product'        => '',
			'image'          => array(),
			'icon'           => '',
			'popup_position' => 'top',
			'el_class'       => '',
			'effect'         => '',
			'page_builder'   => '',
			'image_size'     => '',
		),
		$atts
	)
);

if ( $icon && ! is_array( $icon ) ) {
	$icon = json_decode( $icon, true );
	if ( isset( $icon['icon'] ) ) {
		$icon['value'] = $icon['icon'];
	} else {
		$icon['value'] = '';
	}
}

$url        = isset( $link['url'] ) ? esc_url( $link['url'] ) : '#';
$product_id = $product;

if ( ! is_numeric( $product_id ) && is_string( $product_id ) ) {
	$product_id = wolmart_get_post_id_by_name( 'product', $product_id );
}

$wrapper_class = array( 'hotspot-wrapper' );

// Type
$wrapper_class[] = 'hotspot-' . $type;

// Effect
if ( $effect ) {
	$wrapper_class[] = 'hotspot-' . $effect;
}

?>
<div class="<?php echo esc_attr( implode( ' ', $wrapper_class ) ); ?>">
	<a href="<?php echo esc_url( 'product' == $type && $product_id ? get_permalink( $product_id ) : $url ); ?>"
		<?php echo ( ( isset( $link['is_external'] ) && $link['is_external'] ) ? ' target="nofollow"' : '' ) . ( ( isset( $link['nofollow'] ) && $link['nofollow'] ) ? ' rel="_blank"' : '' ); ?>
		class="hotspot<?php echo ( ( 'product' == $type && $product_id ) ? ' btn-quickview' : '' ); ?>"<?php echo ( 'product' == $type && $product_id ) ? ( ' data-product="' . $product_id . '"' ) : ''; ?>>

		<?php if ( $icon['value'] ) : ?>
			<i class="<?php echo esc_attr( $icon['value'] ); ?>"></i>
		<?php endif; ?>
	</a>
	<?php if ( 'none' != $popup_position ) : ?>
	<div class="hotspot-box hotspot-box-<?php echo esc_attr( $popup_position ); ?>">
		<?php
		if ( 'html' == $type ) {
			echo do_shortcode( $html );
		} elseif ( 'block' == $type ) {
			wolmart_print_template( $block );
		} elseif ( 'image' == $type ) {
			$image_html = '';
			if ( ! empty( $image ) ) {
				if ( $page_builder ) {
					$image_html = wp_get_attachment_image( $image, $image_size );
				} else {
					$image_html = Group_Control_Image_Size::get_attachment_image_html( $atts, 'image' );
				}
			}

			echo '<figure>' . $image_html . '</figure>';
		} elseif ( $product_id && class_exists( 'WooCommerce' ) ) {
			$args = array(
				'post_type' => 'product',
				'post__in'  => array( $product_id ),
			);

			$product = new WP_Query( $args );
			while ( $product->have_posts() ) {
				$product->the_post();
				global $post;
				?>
				<div <?php wc_product_class( 'woocommerce product-widget', $post ); ?>>
					<div class="product-media">
						<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
							<?php echo woocommerce_get_product_thumbnail(); ?>
						</a>
						<div class="product-action-vertical product-loop">
							<?php

							$product_item = wc_get_product( $product_id );
							woocommerce_template_loop_add_to_cart(
								array(
									'class' => implode(
										' ',
										array_filter(
											array(
												'btn-product-icon',
												'product_type_' . $product_item->get_type(),
												$product_item->is_purchasable() && $product_item->is_in_stock() ? 'add_to_cart_button' : '',
												$product_item->supports( 'ajax_add_to_cart' ) && $product_item->is_purchasable() && $product_item->is_in_stock() ? 'ajax_add_to_cart' : '',
											)
										)
									),
								)
							);
							?>
						</div>
					</div>
					<div class="product-body">
						<h3 class="woocommerce-loop-product__title product-title">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
						</h3>
						<?php woocommerce_template_loop_price(); ?>
					</div>
				</div>
				<?php
			}
			wp_reset_postdata();
		}
		?>
	</div>
	<?php endif; ?>
</div>
