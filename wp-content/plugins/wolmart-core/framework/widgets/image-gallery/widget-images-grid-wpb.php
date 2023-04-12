<?php
/**
 * Wolmart Image Gallery
 *
 * @since 1.0.0
 */

// $creative_layout = wolmart_product_grid_preset();
$creative_layout = array();

foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => WOLMART_CORE_URI . $item,
	);
}

$params = array(
	esc_html__( 'Images', 'wolmart-core' ) => array(
		'wolmart_wpb_images_select_controls',
	),
	esc_html__( 'Layout', 'wolmart-core' ) => array(
		'wolmart_wpb_elements_layout_controls',
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params, 'wpb_wolmart_images_grid' ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Images Grid', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_images_grid',
		'icon'            => 'wolmart-icon wolmart-icon-images-grid',
		'class'           => 'wolmart_images wolmart_images_grid image-gallery',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart images grid.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Images_Grid extends WPBakeryShortCode {
	}
}
