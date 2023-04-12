<?php

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'title'        => esc_html__( 'Input Title Here', 'wolmart-core' ),
			'subtitle'     => esc_html__( 'Input SubTitle Here', 'wolmart-core' ),
			'content'      => '<div class="social-icons">
								<a href="#" class="social-icon framed social-facebook"><i class="fab fa-facebook-f"></i></a>
								<a href="#" class="social-icon framed social-twitter"><i class="fab fa-twitter"></i></a>
								<a href="#" class="social-icon framed social-linkedin"><i class="fab fa-linkedin-in"></i></a>
							</div>',
			'image'        => array( 'url' => '' ),
			'thumbnail'    => 'full',
			'type'         => '',
			'page_builder' => '',
			'link'         => '',
		),
		$atts
	)
);

$html  = '';
$image = '';

if ( 'wpb' == $page_builder && ! empty( $atts['image'] ) ) {
	$image = wp_get_attachment_image( $atts['image'], $thumbnail );
} elseif ( defined( 'ELEMENTOR_VERSION' ) ) {
	$image = Elementor\Group_Control_Image_Size::get_attachment_image_html( $atts, 'image' );
}

$link_open  = empty( $link['url'] ) ? '' : '<a href="' . esc_url( $link['url'] ) . '"' . ( empty( $link['is_external'] ) ? '' : ' target="nofollow"' ) . ( empty( $link['nofollow'] ) ? '' : ' rel="_blank"' ) . '>';
$link_close = empty( $link['url'] ) ? '' : '</a>';

if ( $link && $title ) {
	$title = $link_open . $title . $link_close;
}

$title_html    = $title ? '<h3 class="title">' . $title . '</h3>' : '';
$subtitle_html = $subtitle ? '<h4 class="subtitle">' . $subtitle . '</h4>' : '';
$content_html  = $content ? '<div class="content">' . $content . '</div>' : '';

$html = '<div class="image-box ' . esc_attr( $type ) . '">';

if ( ! $type ) {
	$html .= $link_open . '<figure>' . $image . '</figure>' . $link_close . $title_html . $subtitle_html . $content_html;
} elseif ( 'inner' == $type ) {
	$html .= '<figure>' . $image . '<div class="overlay-visible">' . $title_html . $subtitle_html . '</div>' . '<div class="overlay overlay-transparent">' . $content_html . '</div>' . '</figure>';
} elseif ( 'outer' == $type ) {
	$html .= '<figure>' . $image . '<div class="overlay">' . $content_html . '</div>' . '</figure>' . $title_html . $subtitle_html;
}

$html .= '</div>';

echo wolmart_escaped( $html );
