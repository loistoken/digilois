<?php
/**
 * Banner Element
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )  => array(
		'wolmart_wpb_banner_general_controls',
	),
	esc_html__( 'Effect', 'wolmart-core' )   => array(
		'wolmart_wpb_banner_effect_controls',
	),
	esc_html__( 'Parallax', 'wolmart-core' ) => array(
		'wolmart_wpb_banner_parallax_controls',
	),
	esc_html__( 'Video', 'wolmart-core' )    => array(
		'wolmart_wpb_banner_video_controls',
	),

);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Banner', 'wolmart-core' ),
		'base'                    => 'wpb_wolmart_banner',
		'icon'                    => 'wolmart-icon wolmart-icon-banner',
		'class'                   => 'wolmart_banner',
		'controls'                => 'full',
		'category'                => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'             => esc_html__( 'Create wolmart banner.', 'wolmart-core' ),
		'as_parent'               => array( 'only' => 'wpb_wolmart_banner_layer' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'default_content'         => '[wpb_wolmart_banner_layer banner_origin="t-m" layer_pos="{``top``:{``xl``:``50%``},``right``:{``xl``:``2rem``},``left``:{``xl``:``2rem``}}" align="center" layer_width="{``xl``:````}" layer_height="{``xl``:````}"][wpb_wolmart_heading heading_title="' . base64_encode( esc_html__( 'This is a simple banner​', 'wolmart-core' ) ) . '" decoration="simple" title_align="title-center"][wpb_wolmart_heading heading_title=' . base64_encode( esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibheuismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'wolmart-core' ) ) . ' html_tag="p" decoration="simple" title_align="title-center" extra_class="mt-4"][wpb_wolmart_button button_align="center" button_skin="btn-white" extra_class="mt-4"][/wpb_wolmart_banner_layer]',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Banner extends WPBakeryShortCodesContainer {

	}
}
