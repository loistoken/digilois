<?php
/**
 * Filter Item Element
 *
 * @since 1.0.0
 */

$attributes  = array();
$taxonomies  = wc_get_attribute_taxonomies();
$default_att = '';

if ( count( $taxonomies ) ) {
	foreach ( $taxonomies as $key => $value ) {
		$attributes[ 'pa_' . $value->attribute_name ] = $value->attribute_label;
	}
	$attributes = array_merge( array( 'default' => esc_html__( 'Select Attribute', 'wolmart-core' ) ), $attributes );
}

if ( empty( $taxonomies ) ) {
	$params = array(
		esc_html__( 'General', 'wolmart-core' ) => array(
			array(
				'type'       => 'wolmart_heading',
				'label'      => sprintf( esc_html__( 'Sorry, there are no product attributes available in this site. Click %1$shere%2$s to add attributes.', 'wolmart-core' ), '<a href="' . esc_url( admin_url() ) . 'edit.php?post_type=product&page=product_attributes" target="blank">', '</a>' ),
				'param_name' => 'no_attribute_description',
				'tag'        => 'p',
			),
		),
	);
} else {
	$params = array(
		esc_html__( 'General', 'wolmart-core' ) => array(
			array(
				'type'       => 'dropdown',
				'param_name' => 'name',
				'heading'    => esc_html__( 'Attribute', 'wolmart-core' ),
				'value'      => array_flip( $attributes ),
				'std'        => 'default',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'query_opt',
				'heading'    => esc_html__( 'Query Type', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'AND', 'wolmart-core' ) => 'and',
					esc_html__( 'OR', 'wolmart-core' )  => 'or',
				),
				'std'        => 'or',
			),
		),
	);
}

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'        => esc_html__( 'Filter Item', 'wolmart-core' ),
		'base'        => 'wpb_wolmart_filter_item',
		'icon'        => 'wolmart-icon wolmart-icon-filter',
		'class'       => 'wpb_wolmart_filter_item',
		'controls'    => 'full',
		'category'    => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description' => esc_html__( 'Create wolmart filter item.', 'wolmart-core' ),
		'as_child'    => array( 'only' => 'wpb_wolmart_filter' ),
		'params'      => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Filter_Item extends WPBakeryShortCode {

	}
}
