<?php
/**
 * Heading Shortcode
 *
 * @since 1.0.0
 */

// Preprocess
if ( ! empty( $atts['link_url'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link_url'] = vc_build_link( $atts['link_url'] );
}

if ( ! empty( $atts['heading_title'] ) ) {
	$atts['heading_title'] = rawurldecode( base64_decode( wp_strip_all_tags( $atts['heading_title'] ) ) );
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'content_type'    => 'custom',
			'dynamic_content' => 'title',
			'heading_title'   => esc_html__( 'Add Your Heading Text Here', 'wolmart-core' ),
			'html_tag'        => 'h2',
			'decoration'      => '',
			'show_link'       => '',
			'link_url'        => '',
			'link_label'      => 'Link',
			'title_align'     => 'title-left',
			'link_align'      => '',
			'icon_pos'        => 'after',
			'icon'            => '',
			'show_divider'    => '',
			'class'           => '',
		),
		$atts
	)
);


$wrapper_attrs = array(
	'class' => 'title-wrapper ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$html = '';

if ( 'dynamic' == $content_type ) {
	global $wolmart_layout;
	$heading_title = '';

	if ( isset( $wolmart_layout ) ) {
		if ( 'title' == $dynamic_content ) {
			Wolmart_Layout_Builder::get_instance()->setup_titles();
			$heading_title = $wolmart_layout['title'];
		} elseif ( 'subtitle' == $dynamic_content ) {
			Wolmart_Layout_Builder::get_instance()->setup_titles();
			$heading_title = $wolmart_layout['subtitle'];
		} elseif ( 'product_cnt' == $dynamic_content ) {
			if ( function_exists( 'wolmart_is_shop' ) && wolmart_is_shop() && wolmart_wc_get_loop_prop( 'total' ) ) {
				$heading_title = wolmart_wc_get_loop_prop( 'total' ) . ' products';
			}
		}
	} else {
		if ( 'title' == $dynamic_content ) {
			$heading_title = esc_html__( 'Page Title', 'wolmart-core' );
		} elseif ( 'subtitle' == $dynamic_content ) {
			$heading_title = esc_html__( 'Page Subtitle', 'wolmart-core' );
		} elseif ( 'product_cnt' == $dynamic_content ) {
			$heading_title = esc_html__( '* Products', 'wolmart-core' );
		}
	}
}

if ( $heading_title || ( 'yes' == $show_link && $link_label ) ) {
	$class = $class ? $class . ' title' : 'title';

	if ( $decoration && 'simple' != $decoration ) {
		$wrapper_attrs['class'] .= ' title-' . $decoration;
	}

	if ( $title_align ) {
		$wrapper_attrs['class'] .= ' ' . $title_align;
	}

	if ( $link_align ) {
		$wrapper_attrs['class'] .= ' ' . $link_align;
	}
	$link_label = '<span>' . esc_html( $link_label ) . '</span>';

	if ( ! empty( $icon ) ) {
		if ( 'before' == $icon_pos ) {
			$wrapper_attrs['class'] .= ' icon-before';
			$link_label              = '<i class="' . $icon . '"></i>' . $link_label;
		} else {
			$wrapper_attrs['class'] .= ' icon-after';
			$link_label             .= '<i class="' . $icon . '"></i>';
		}
	}
	$wrapper_attr_html = '';
	foreach ( $wrapper_attrs as $key => $value ) {
		$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
	}

	$html .= '<div ' . wolmart_escaped( $wrapper_attr_html ) . '>';

	if ( $heading_title ) {
		$html .= sprintf( '<%1$s class="' . esc_attr( $class ) . '">%2$s</%1$s>', $html_tag, do_shortcode( $heading_title ) );
	}

	if ( 'yes' == $show_link ) { // If Link is allowed
		if ( 'yes' == $show_divider ) {
			$html .= '<span class="divider"></span>';
		}
		$html .= sprintf( '<a href="%1$s" class="link">%2$s</a>', ! empty( $link_url['url'] ) ? $link_url['url'] : '#', ( $link_label ) );
	}
	$html .= '</div>';
}

echo wolmart_escaped( $html );
