<?php
/**
 * Wolmart Posts
 *
 * @since 1.0.0
 */

$creative_layout = wolmart_creative_preset_imgs();

foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => WOLMART_CORE_URI . $item,
	);
}


$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array( 'wolmart_wpb_posts_select_controls' ),
	esc_html__( 'Layout', 'wolmart-core' )  => array( 'wolmart_wpb_elements_layout_controls' ),
	esc_html__( 'Type', 'wolmart-core' )    => array( 'wolmart_wpb_posts_type_controls' ),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		'wolmart_wpb_posts_style_controls',
		esc_html__( 'Meta', 'wolmart-core' )      => array( 'wolmart_wpb_posts_meta_style_controls' ),
		esc_html__( 'Title', 'wolmart-core' )     => array( 'wolmart_wpb_posts_title_style_controls' ),
		esc_html__( 'Category', 'wolmart-core' )  => array( 'wolmart_wpb_posts_cat_style_controls' ),
		esc_html__( 'Excerpt', 'wolmart-core' )   => array( 'wolmart_wpb_posts_excerpt_style_controls' ),
		esc_html__( 'Read More', 'wolmart-core' ) => array( 'wolmart_wpb_posts_read_more_controls' ),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params, 'wpb_wolmart_posts_grid' ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Posts Grid', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_posts_grid',
		'icon'            => 'wolmart-icon wolmart-icon-posts-grid',
		'class'           => 'wolmart_posts wolmart_posts_grid',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart posts with grid layout.', 'wolmart-core' ),
		'params'          => $params,
	)
);


// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_posts_grid_categories_callback', 'wolmart_wpb_shortcode_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_posts_grid_categories_render', 'wolmart_wpb_shortcode_category_id_render', 10, 1 );

// Post Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_posts_grid_post_ids_callback', 'wolmart_wpb_shortcode_post_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_posts_grid_post_ids_render', 'wolmart_wpb_shortcode_post_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Posts_Grid extends WPBakeryShortCode {
	}
}
