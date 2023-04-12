<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Heading Widget Render
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'content_type'    => 'custom',
			'dynamic_content' => 'title',
			'title'           => '',
			'tag'             => 'h2',
			'decoration'      => '',
			'show_link'       => '',
			'link_url'        => '',
			'link_label'      => '',
			'title_align'     => '',
			'link_align'      => '',
			'icon_pos'        => 'after',
			'icon'            => '',
			'show_divider'    => '',
			'class'           => '',

			// For elementor inline editing
			'self'            => '',
		),
		$atts
	)
);

$html = '';

if ( 'dynamic' == $content_type ) {
	global $wolmart_layout;
	$title = '';

	if ( isset( $wolmart_layout ) ) {
		if ( 'title' == $dynamic_content ) {
			Wolmart_Layout_Builder::get_instance()->setup_titles();
			$title = $wolmart_layout['title'];
		} elseif ( 'subtitle' == $dynamic_content ) {
			Wolmart_Layout_Builder::get_instance()->setup_titles();
			$title = $wolmart_layout['subtitle'];
		} elseif ( 'product_cnt' == $dynamic_content ) {
			if ( function_exists( 'wolmart_is_shop' ) && wolmart_is_shop() && wolmart_wc_get_loop_prop( 'total' ) ) {
				$title = wolmart_wc_get_loop_prop( 'total' ) . ' products';
			}
		}
	} else {
		if ( 'title' == $dynamic_content ) {
			$title = esc_html__( 'Page Title', 'wolmart-core' );
		} elseif ( 'subtitle' == $dynamic_content ) {
			$title = esc_html__( 'Page Subtitle', 'wolmart-core' );
		} elseif ( 'product_cnt' == $dynamic_content ) {
			$title = esc_html__( '* Products', 'wolmart-core' );
		}
	}
}

$class = $class ? $class . ' title elementor-heading-title' : 'title elementor-heading-title';

$wrapp_class = '';

if ( $decoration ) {
	$wrapp_class .= ' title-' . $decoration;
}

if ( $title_align ) {
	$wrapp_class .= ' ' . $title_align;
}

if ( $link_align ) {
	$wrapp_class .= ' ' . $link_align;
}


$link_label = '<span ' . ( $self ? $self->get_render_attribute_string( 'link_label' ) : '' ) . '>' . esc_html( $link_label ) . '</span>';

if ( is_array( $icon ) && $icon['value'] ) {
	if ( 'before' == $icon_pos ) {
		$wrapp_class .= ' icon-before';
		$link_label   = '<i class="' . $icon['value'] . '"></i>' . $link_label;
	} else {
		$wrapp_class .= ' icon-after';
		$link_label  .= '<i class="' . $icon['value'] . '"></i>';
	}
}

$html .= '<div class="title-wrapper ' . $wrapp_class . '">';

if ( $self ) {
	$self->add_render_attribute( 'title', 'class', $class );
}

if ( $title ) {
	$html .= sprintf( '<%1$s ' . ( $self ? $self->get_render_attribute_string( 'title' ) : '' ) . '>%2$s</%1$s>', $tag, $title );
}

if ( 'yes' == $show_link ) { // If Link is allowed
	if ( 'yes' == $show_divider ) {
		$html .= '<span class="divider"></span>';
	}
	$html .= sprintf( '<a href="%1$s" class="link"%3$s>%2$s</a>', $link_url['url'] ? $link_url['url'] : '#', $link_label, ( $link_url['is_external'] ? ' target="nofollow"' : '' ) . ( $link_url['nofollow'] ? ' rel="_blank"' : '' ) );
}
$html .= '</div>';

echo do_shortcode( wolmart_escaped( $html ) );
