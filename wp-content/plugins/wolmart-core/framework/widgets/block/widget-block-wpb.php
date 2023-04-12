<?php
/**
 * Wolmart Block
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		array(
			'type'       => 'autocomplete',
			'param_name' => 'block_id',
			'heading'    => esc_html__( 'Block ID', 'wolmart-core' ),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Block', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_block',
		'icon'            => 'wolmart-icon wolmart-icon-block',
		'class'           => 'wolmart_blcok',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart block.', 'wolmart-core' ),
		'params'          => $params,
	)
);

// Block Id Autocomplete
add_filter( 'vc_autocomplete_wpb_wolmart_block_block_id_callback', 'wolmart_wpb_shortcode_block_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_block_block_id_render', 'wolmart_wpb_shortcode_block_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Block extends WPBakeryShortCode {

	}
}
