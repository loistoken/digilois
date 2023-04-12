<?php
/**
 * Single Prodcut Image Render
 *
 * @since 1.0.0
 */
extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_type' => '',
			'col_sp'  => 'md',
		),
		$atts
	)
);

$GLOBALS['wolmart_wpb_sp_image_settings'] = $atts;
$GLOBALS['wolmart_wpb_sp_image_settings'] = array_merge(
	$atts,
	array(
		'col_sp' => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
	)
);

// Responsive columns
$GLOBALS['wolmart_wpb_sp_image_settings'] = array_merge( $GLOBALS['wolmart_wpb_sp_image_settings'], wolmart_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $GLOBALS['wolmart_wpb_sp_image_settings']['col_cnt'] ) {
	$GLOBALS['wolmart_wpb_sp_image_settings']['col_cnt'] = $GLOBALS['wolmart_wpb_sp_image_settings']['col_cnt_xl'];
}

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-sp-image-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {

	if ( ! function_exists( 'get_gallery_type' ) ) {
		function get_gallery_type() {
			global $wolmart_wpb_sp_image_settings;
			return isset( $wolmart_wpb_sp_image_settings['sp_type'] ) ? $wolmart_wpb_sp_image_settings['sp_type'] : 'default';
		}
	}

	if ( ! function_exists( 'wolmart_extend_gallery_class' ) ) {
		function wolmart_extend_gallery_class( $classes ) {
			global $wolmart_wpb_sp_image_settings;
			$single_product_layout = isset( $wolmart_wpb_sp_image_settings['sp_type'] ) ? $wolmart_wpb_sp_image_settings['sp_type'] : '';
			$classes[]             = 'pg-custom';

			if ( 'grid' == $single_product_layout || 'masonry' == $single_product_layout ) {

				foreach ( $classes as $i => $class ) {
					if ( 'cols-sm-2' == $class ) {
						array_splice( $classes, $i, 1 );
					}
				}
				$classes[]        = wolmart_get_col_class( wolmart_elementor_grid_col_cnt( $wolmart_wpb_sp_image_settings ) );
				$grid_space_class = wolmart_elementor_grid_space_class( $wolmart_wpb_sp_image_settings );
				if ( $grid_space_class ) {
					$classes[] = $grid_space_class;
				}
			}

			return $classes;
		}
	}

	if ( ! function_exists( 'wolmart_extend_gallery_type_class' ) ) {
		function wolmart_extend_gallery_type_class( $class ) {
			global $wolmart_wpb_sp_image_settings;
			$class            = ' ' . wolmart_get_col_class( wolmart_elementor_grid_col_cnt( $wolmart_wpb_sp_image_settings ) );
			$grid_space_class = wolmart_elementor_grid_space_class( $wolmart_wpb_sp_image_settings );
			if ( $grid_space_class ) {
				$class .= ' ' . $grid_space_class;
			}
			return $class;
		}
	}

	if ( ! function_exists( 'wolmart_extend_gallery_type_attr' ) ) {
		function wolmart_extend_gallery_type_attr( $attr ) {
			global $wolmart_wpb_sp_image_settings;
			$wolmart_wpb_sp_image_settings['show_nav']  = 'yes';
			$wolmart_wpb_sp_image_settings['show_dots'] = 'yes';
			$attr                                      .= ' data-slider-options="' . esc_attr(
				json_encode(
					wolmart_get_slider_attrs( $wolmart_wpb_sp_image_settings, wolmart_elementor_grid_col_cnt( $wolmart_wpb_sp_image_settings ) )
				)
			) . '"';
			return $attr;
		}
	}

	add_filter( 'wolmart_single_product_layout', 'get_gallery_type', 99 );
	add_filter( 'wolmart_single_product_gallery_main_classes', 'wolmart_extend_gallery_class', 20 );
	if ( 'gallery' == $sp_type ) {
		add_filter( 'wolmart_single_product_gallery_type_class', 'wolmart_extend_gallery_type_class' );
		add_filter( 'wolmart_single_product_gallery_type_attr', 'wolmart_extend_gallery_type_attr' );
	}

	woocommerce_show_product_images();

	remove_filter( 'wolmart_single_product_layout', 'get_gallery_type', 99 );
	remove_filter( 'wolmart_single_product_gallery_main_classes', 'wolmart_extend_gallery_class', 20 );
	if ( 'gallery' == $sp_type ) {
		remove_filter( 'wolmart_single_product_gallery_type_class', 'wolmart_extend_gallery_type_class' );
		remove_filter( 'wolmart_single_product_gallery_type_attr', 'wolmart_extend_gallery_type_attr' );
	}

	do_action( 'wolmart_single_product_builder_unset_product' );
}
?>
</div>
<?php
