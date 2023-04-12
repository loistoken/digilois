<?php
/**
 * Header compare template
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */

defined( 'ABSPATH' ) || die;


extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'type'        => 'block',
			'show_icon'   => true,
			'show_count'  => true,
			'show_label'  => true,
			'icon'        => 'w-icon-compare',
			'label'       => esc_html( 'Compare', 'wolmart' ),
			'minicompare' => '',
		),
		$atts
	)
);

$minicompare = isset( $minicompare ) ? ( $minicompare ? $minicompare : '' ) : '';

$count    = 0;
$prod_ids = array();
if ( class_exists( 'Wolmart_Product_Compare' ) ) {
	$cookie_name = Wolmart_Product_Compare::get_instance()->compare_cookie_name();
	if ( isset( $_COOKIE[ $cookie_name ] ) ) {
		$prod_ids = json_decode( wp_unslash( $_COOKIE[ $cookie_name ] ), true );
		$count    = is_array( $prod_ids ) ? count( $prod_ids ) : 0;
	}
}

if ( $minicompare ) {
	echo '<div class="dropdown compare-dropdown mini-basket-dropdown ' . ( 'offcanvas' == $minicompare ? 'compare-offcanvas ' : ' ' ) . $minicompare . '-type" data-minicompare-type="' . $minicompare . '">';
}
?>

<a class="compare-open<?php echo esc_attr( $type ? ( ' ' . $type . '-type ' ) : '' ); ?>" aria-label="<?php echo esc_attr( 'Compare', 'wolmart-core' ); ?>" href="<?php echo function_exists( 'wc_get_page_id' ) ? esc_url( get_permalink( wc_get_page_id( 'compare' ) ) ) : '#'; ?>">
	<?php if ( $show_icon ) : ?>
	<i class="<?php echo esc_attr( $icon ); ?>">
		<?php if ( $show_count ) : ?>
			<span class="compare-count"><?php echo esc_html( $count ); ?></span>
		<?php endif; ?>
	</i>
	<?php endif; ?>
	<?php if ( $show_label ) : ?>
	<span><?php echo esc_html( $label ); ?></span>
	<?php endif; ?>
</a>

<?php
if ( $minicompare ) {
	if ( 'offcanvas' == $minicompare ) :
		?>
		<div class="offcanvas-overlay compare-overlay"></div>
	<?php endif; ?>

	<div class="compare-dropdown-box dropdown-box">
		<?php
		if ( 'offcanvas' == $minicompare ) {
			echo '<div class="popup-header"><h3>' . esc_html__( 'Compare', 'wolmart-core' ) . '</h3><a class="btn btn-link btn-icon-right btn-close" href="#">' . esc_html__( 'close', 'wolmart-core' ) . '<i class="w-icon-long-arrow-' . ( is_rtl() ? 'left' : 'right' ) . '"></i></a></div>';
		}
		?>
		<div class="widget_compare_content">
		<?php if ( empty( $prod_ids ) ) : ?>
			<p class="empty-msg"><?php esc_html_e( 'No products in compare list.', 'wolmart-core' ); ?></p>
		<?php else : ?>
			<ul class="scrollable mini-list compare-list">
			<?php
			foreach ( $prod_ids as $id ) {
				$product = wc_get_product( $id );
				if ( $product ) {
					$product_name      = $product->get_data()['name'];
					$thumbnail         = $product->get_image( 'wolmart-product-thumbnail', array( 'class' => 'do-not-lazyload' ) );
					$product_price     = $product->get_price_html();
					$product_permalink = $product->is_visible() ? $product->get_permalink() : '';

					if ( ! $product_price ) {
						$product_price = '';
					}

					echo '<li class="mini-item compare-item">';

					echo '<div class="mini-item-meta">';

					if ( empty( $product_permalink ) ) {
						echo wolmart_escaped( $product_name );
					} else {
						echo '<a href="' . esc_url( $product_permalink ) . '">' . $product_name . '</a>';
					}
					echo '<span class="quantity">' . $product_price . '</span>';

					echo '</div>';

					if ( empty( $product_permalink ) ) {
						echo wolmart_escaped( $thumbnail );
					} else {
						echo '<a href="' . esc_url( $product_permalink ) . '">' . $thumbnail . '</a>';
					}

					echo '<a href="#" class="remove remove_from_compare" data-product_id="' . $id . '"><i class="fas fa-times"></i></a>';

					echo '</li>';
				}
			}
			?>
			</ul>
			<p class="compare-buttons buttons">
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'compare' ) ) ); ?>" class="button btn btn-dark btn-rounded btn-md btn-block"><?php esc_html_e( 'Go To Compare List', 'wolmart-core' ); ?></a>
			</p>
		<?php endif; ?>

		<?php
			// print templates for js work
			ob_start();
		?>
			<p class="empty-msg"><?php esc_html_e( 'No products in compare list.', 'wolmart-core' ); ?></p>
			<?php
			echo '<script type="text/template" class="wolmart-minicompare-no-item-html">' . ob_get_clean() . '</script>';
			?>

		</div>
	</div>

</div>
	<?php
}
