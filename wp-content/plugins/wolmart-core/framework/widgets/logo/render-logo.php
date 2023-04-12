<?php
/**
 * Header logo template
 *
 * This is the site logo, and it doesn't be lazyloaded.
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */

defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'thumbnail_size' => 'full',
		),
		$atts
	)
);

$logo_id    = function_exists( 'wolmart_get_option' ) ? wolmart_get_option( 'custom_logo' ) : get_theme_mod( 'custom_logo' );
$site_title = get_bloginfo( 'name', 'display' );
?>

<a href="<?php echo esc_url( apply_filters( 'wolmart_header_element_logo_url', home_url( '/' ) ) ); ?>" class="logo" aria-label="<?php echo esc_attr( 'Logo', 'wolmart-core' ); ?>" title="<?php echo esc_attr( $site_title ); ?> - <?php bloginfo( 'description' ); ?>">
	<?php
	if ( $logo_id ) {
		echo str_replace( ' class="', ' class="site-logo skip-data-lazy ', wp_get_attachment_image( $logo_id, empty( $thumbnail_size ) ? 'full' : $thumbnail_size, false, array( 'alt' => esc_attr( $site_title ) ) ) );
	} else {
		echo '<img class="site-logo skip-data-lazy" src="' . WOLMART_ASSETS . '/images/logo.png" width="144" height="45" title="' . esc_attr( $site_title ) . '"/>';
	}
	?>
</a>
