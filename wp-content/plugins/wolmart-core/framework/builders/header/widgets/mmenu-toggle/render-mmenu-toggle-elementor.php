<?php
/**
 * Header mobile menu toggle template
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */

defined( 'ABSPATH' ) || die;

// disable if mobile menu has no any items
if ( ! function_exists( 'wolmart_get_option' ) || ! wolmart_get_option( 'mobile_menu_items' ) ) {
	return;
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'icon_class' => 'w-icon-hamburger',
		),
		$atts
	)
);
?>
<a href="#" aria-label="<?php echo esc_attr( 'Mobile Menu' ); ?>" class="mobile-menu-toggle d-lg-none"><i class="<?php echo esc_attr( $icon_class ); ?>"></i></a>
<?php
