<?php
if ( ! function_exists( 'wolmart_get_wpb_design_controls' ) ) {
	function wolmart_get_wpb_design_controls() {
		return array(
			array(
				'type'       => 'css_editor',
				'heading'    => esc_html__( 'CSS box', 'wolmart-core' ),
				'param_name' => 'css',
				'group'      => esc_html__( 'Design Options', 'wolmart-core' ),
			),
		);
	}
}
