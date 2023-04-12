<?php
/**
 * Header wishlist template
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */

defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'type'         => 'block',
			'show_label'   => true,
			'show_count'   => false,
			'show_icon'    => true,
			'label'        => esc_html__( 'Wishlist', 'wolmart-core' ),
			'icon'         => 'w-icon-heart',
			'miniwishlist' => '',
		),
		$atts
	)
);


if ( class_exists( 'YITH_WCWL' ) ) :
	$wc_link  = YITH_WCWL()->get_wishlist_url();
	$wc_count = yith_wcwl_count_products();

	$wishlist       = YITH_WCWL_Wishlist_Factory::get_current_wishlist( array() );
	$wishlist_items = array();
	if ( $wishlist && $wishlist->has_items() ) {
		$wishlist_items = $wishlist->get_items();
	}

	if ( $miniwishlist ) {
		echo '<div class="dropdown wishlist-dropdown mini-basket-dropdown ' . ( 'offcanvas' == $miniwishlist ? 'wishlist-offcanvas ' : ' ' ) . $miniwishlist . '-type" data-miniwishlist-type="' . $miniwishlist . '">';
	}
	?>
	<a class="wishlist <?php echo esc_attr( $type . '-type' ); ?>" href="<?php echo esc_url( $wc_link ); ?>" aria-label="<?php echo esc_attr( 'Wishlist', 'wolmart-core' ) ?>">
		<?php if ( $show_icon ) : ?>
		<i class="<?php echo esc_attr( $icon ); ?>">
			<?php if ( $show_count ) : ?>
				<span class="wish-count"><?php echo esc_html( $wc_count ); ?></span>
			<?php endif; ?>
		</i>
		<?php endif; ?>
		<?php if ( $show_label ) : ?>
		<span><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
	</a>
	<?php
endif;
