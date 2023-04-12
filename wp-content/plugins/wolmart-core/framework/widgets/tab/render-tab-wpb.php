<?php
/**
 * Tab Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-tab-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php

$extra_class = ' tab';
$settings    = array(
	'tab_type'   => isset( $atts['tab_type'] ) ? $atts['tab_type'] : '',
	'tab_v_type' => isset( $atts['tab_v_type'] ) ? $atts['tab_v_type'] : '',
	'tab_h_type' => isset( $atts['tab_h_type'] ) ? $atts['tab_h_type'] : '',
);
if ( isset( $atts['tab_navs_pos'] ) ) {
	$settings['tab_navs_pos'] = str_replace( '``', '"', $atts['tab_navs_pos'] );
	$settings['tab_navs_pos'] = json_decode( $settings['tab_navs_pos'], true );
}

if ( 'vertical' == $settings['tab_type'] ) {
	$extra_class .= ' tab-vertical';

	switch ( $settings['tab_v_type'] ) { // vertical tab type
		case 'simple':
			$extra_class .= ' tab-simple';
			break;
		case 'solid':
			$extra_class .= ' tab-nav-solid';
			break;
	}
} else {
	switch ( $settings['tab_h_type'] ) { // horizontal tab type
		case 'simple':
			$extra_class .= ' tab-nav-simple tab-nav-boxed';
			break;
		case 'solid1':
			$extra_class .= ' tab-nav-boxed tab-nav-solid';
			break;
		case 'solid2':
			$extra_class .= ' tab-nav-boxed tab-nav-solid tab-nav-round';
			break;
		case 'outline1':
			$extra_class .= ' tab-nav-boxed tab-nav-boxed tab-outline';
			break;
		case 'outline2':
			$extra_class .= ' tab-nav-boxed tab-nav-boxed tab-outline2';
			break;
		case 'link':
			$extra_class .= ' tab-nav-boxed tab-nav-underline';
			break;
	}

	if ( ! empty( $settings['tab_navs_pos'] ) ) {
		$breaks = array( 'xl', 'lg', 'md', 'sm', 'xs' );
		foreach ( $breaks as $break ) {
			if ( ! empty( $settings['tab_navs_pos'][ $break ] ) ) {
				$prefix       = 'xl' == $break ? '' : ( '-' . $break );
				$extra_class .= ' tab-nav' . $prefix . '-' . $settings['tab_navs_pos'][ $break ];
			}
		}
	}
}

$atts['content'] = do_shortcode( $atts['content'] );

echo '<div class="' . $extra_class . '">';
echo '<ul class="nav nav-tabs">';

if ( ! vc_is_inline() ) {
	global $wolmart_wpb_tab;
	if ( ! empty( $wolmart_wpb_tab ) ) {
		for ( $i = 0; $i < count( $wolmart_wpb_tab ); $i ++ ) {
			echo '<li class="nav-item">';
			echo '<a class="nav-link' . ( 0 == $i ? ' active' : '' ) . '" href="#">' . wolmart_strip_script_tags( $wolmart_wpb_tab[ $i ] ) . '</a>';
			echo '</li>';
		}
		$wolmart_wpb_tab = array();
	}
}

echo '</ul>';
echo '<div class="tab-content">';
echo wolmart_strip_script_tags( $atts['content'] );
echo '</div>';
echo '</div>';
?>
</div>
<?php
