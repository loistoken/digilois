<?php
defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Products Selector
			'products_selector_list' => [],
		),
		$atts
	)
);

if ( count( $products_selector_list ) ) {
	echo '<ul class="nav nav-tabs">';
	$active_class = ' active';
	foreach ( $products_selector_list as $products_selector ) {
		echo '<li class="nav-item"><a class="nav-link' . ( $active_class ? $active_class : '' ) . '" href="#">' . esc_html( $products_selector['tab_title'] ) . '</a></li>';
		$active_class = '';
	}
	echo '</ul>';

	echo '<div class="tab-content tab-templates">';
	$active_class = ' in active';
	foreach ( $products_selector_list as $products_selector ) {
		echo '<div class="tab-pane' . ( $active_class ? $active_class : '' ) . '">';
		if ( ! $active_class ) {
			echo '<script type="text/template" class="load-template">';
		}

		$new_atts = array_merge( $atts, $products_selector );
		wolmart_products_widget_render( $new_atts );

		if ( ! $active_class ) {
			echo '</script>';
		}
		$active_class = '';
		echo '</div>';
	}
	echo '</div>';
}
