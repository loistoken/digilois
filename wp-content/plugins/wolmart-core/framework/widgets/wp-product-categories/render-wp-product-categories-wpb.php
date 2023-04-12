<?php
/**
 * Block Shortcode Render
 *
 * @since 1.0.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'title'        => esc_html__( 'Product categories', 'wolmart-core' ),
			'orderby'      => 'name',
			'count'        => 0,
			'hierarchical' => 'yes',
			'hide_empty'   => 'yes',
			'max_depth'    => 1,
		),
		$atts
	)
);

global $wp_query, $post;

$list_args = array(
	'show_count'   => $count,
	'hierarchical' => $hierarchical,
	'taxonomy'     => 'product_cat',
	'hide_empty'   => $hide_empty,
	'depth'        => $max_depth,
);

if ( 'order' == $orderby ) {
	$list_args['orderby']  = 'meta_value_num';
	$list_args['meta_key'] = 'order';
}

$list_args['title_li'] = '';

echo '<nav class="widget woocommerce widget_product_categories widget-collapsible">';
if ( $title ) {
	echo '<h3 class="widget-title">' . $title . '</h3>';
}
echo '<ul class="product-categories">';
wp_list_categories( $list_args );
echo '</ul>';
echo '</nav>';
