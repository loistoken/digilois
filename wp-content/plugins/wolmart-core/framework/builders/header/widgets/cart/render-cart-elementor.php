<?php
/**
 * Header mini-cart template
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */

defined( 'ABSPATH' ) || die;

if ( class_exists( 'WooCommerce' ) ) :
	extract( // @codingStandardsIgnoreLine
		shortcode_atts(
			array(
				'icon_type'       => '',
				'cart_off_canvas' => '',
				'title'           => '',
				'label'           => '',
				'price'           => '',
				'delimiter'       => '',
				'pfx'             => '',
				'sfx'             => '',
				'icon'            => 'w-icon-cart',
			),
			$atts
		)
	);

	$extra_class = $cart_off_canvas ? ' cart-offcanvas' : '';
	?>
	<div class="dropdown mini-basket-dropdown cart-dropdown block-type<?php echo esc_attr( ( $icon_type ? ' ' . $icon_type . '-type ' : ' ' ) . esc_attr( $extra_class ) ); ?>">
		<a class="cart-toggle" href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>">
			<?php if ( $title || $price ) { ?>
			<span class="cart-label">
			<?php } ?>
				<?php if ( $title ) : ?>
				<span class="cart-name"><?php echo esc_html( $label ); ?></span>
					<?php if ( $delimiter ) : ?>
						<span class="cart-name-delimiter"><?php echo esc_html( $delimiter ); ?></span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $price ) : ?>
				<span class="cart-price"><?php echo get_woocommerce_currency_symbol(); ?>0.00</span>
				<?php endif; ?>
			<?php if ( $title || $price ) { ?>
			</span>
			<?php } ?>
			<?php if ( 'badge' == $icon_type ) : ?>
				<i class="<?php echo esc_attr( $icon ); ?>">
					<!-- <span class="cart-count"><i class="fas fa-spinner fa-pulse"></i></span> -->
					<span class="cart-count">0</span>
				</i>
			<?php elseif ( 'label' == $icon_type ) : ?>
				<span class="cart-count-wrap">
				<?php
				$html = '';
				if ( $pfx ) {
					$html .= esc_html( $pfx );
				}
				$html .= '<span class="cart-count"><i class="fas fa-spinner fa-pulse"></i></span>';
				if ( $sfx ) {
					$html .= esc_html( $sfx );
				}
				echo wolmart_escaped( $html );
				?>
				</span>
			<?php endif ?>
		</a>
		<?php if ( ! wolmart_is_elementor_preview() && $cart_off_canvas ) : ?>
			<div class="cart-overlay"></div>
		<?php endif; ?>
		<div class="cart-popup widget_shopping_cart dropdown-box">
			<div class="widget_shopping_cart_content">
				<div class="cart-loading"></div>
			</div>
		</div>
	</div>
	<?php
endif;
