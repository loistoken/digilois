<?php

if ( ! function_exists( 'wolmart_wpb_images_select_controls' ) ) {
	function wolmart_wpb_images_select_controls() {
		return array(
			array(
				'type'        => 'attach_images',
				'heading'     => esc_html__( 'Add Images', 'wolmart-core' ),
				'param_name'  => 'images',
				'value'       => '',
				'description' => esc_html__( 'Select images from media library.', 'wolmart-core' ),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'caption_type',
				'heading'    => esc_html__( 'Caption', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )  => 'none',
					esc_html__( 'Title', 'wolmart-core' ) => 'title',
					esc_html__( 'Caption', 'wolmart-core' ) => 'caption',
					esc_html__( 'Description', 'wolmart-core' ) => 'description',
				),
				'std'        => 'none',
			),
		);
	}
}
