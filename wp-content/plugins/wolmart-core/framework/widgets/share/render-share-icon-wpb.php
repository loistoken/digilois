<?php
/**
 * ShareIcon Shortcode Render
 *
 * @since 1.0.0
 */


// Preprocess
$permalink = esc_url( apply_filters( 'the_permalink', get_permalink() ) );
$title     = esc_attr( get_the_title() );
$image     = wp_get_attachment_url( get_post_thumbnail_id() );
$excerpt   = esc_attr( get_the_excerpt() );
if ( isset( $atts['icon'] ) && 'whatsapp' == $atts['icon'] ) {
	$title = rawurlencode( $title );
} else {
	$title = urlencode( $title );
}
$share_icons = array(
	esc_html__( 'facebook', 'wolmart-core' )  => array( 'fab fa-facebook-f', 'https://www.facebook.com/sharer.php?u=$permalink' ),
	esc_html__( 'twitter', 'wolmart-core' )   => array( 'fab fa-twitter', 'https://twitter.com/intent/tweet?text=$title&amp;url=$permalink' ),
	esc_html__( 'linkedin', 'wolmart-core' )  => array( 'fab fa-linkedin-in', 'https://www.linkedin.com/shareArticle?mini=true&amp;url=$permalink&amp;title=$title' ),
	esc_html__( 'email', 'wolmart-core' )     => array( 'far fa-envelope', 'mailto:?subject=$title&amp;body=$permalink' ),
	esc_html__( 'google', 'wolmart-core' )    => array( 'fab fa-google-plus-g', 'https://plus.google.com/share?url=$permalink' ),
	esc_html__( 'pinterest', 'wolmart-core' ) => array( 'fab fa-pinterest', 'https://pinterest.com/pin/create/button/?url=$permalink&amp;media=$image' ),
	esc_html__( 'reddit', 'wolmart-core' )    => array( 'fab fa-reddit-alien', 'http://www.reddit.com/submit?url=$permalink&amp;title=$title' ),
	esc_html__( 'tumblr', 'wolmart-core' )    => array( 'fab fa-tumblr', 'http://www.tumblr.com/share/link?url=$permalink&amp;name=$title&amp;description=$excerpt' ),
	esc_html__( 'vk', 'wolmart-core' )        => array( 'fab fa-vk', 'https://vk.com/share.php?url=$permalink&amp;title=$title&amp;image=$image&amp;noparse=true' ),
	esc_html__( 'whatsapp', 'wolmart-core' )  => array( 'fab fa-whatsapp', 'whatsapp://send?text=$title-$permalink' ),
	esc_html__( 'xing', 'wolmart-core' )      => array( 'fab fa-xing', 'https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=$permalink' ),
	esc_html__( 'youtube', 'wolmart-core' )   => array( 'fab fa-youtube', '#' ),
        esc_html__( 'instagram', 'wolmart-core' ) => array( 'fab fa-instagram', '#' ),
);

if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'icon'        => 'facebook',
			'link'        => '',
			'social_type' => 'stacked',
		),
		$atts
	)
);
$share_link_nofollow = wolmart_get_option( 'share_link_nofollow' );
$wrapper_attrs       = array(
	'class' => 'social-icon ' . $atts['shortcode_class'] . $atts['style_class'] . ' social-' . $icon . ( ! empty( $social_type ) ? ' ' . $social_type : '' ),
	'href'  => empty( $link ) ? ( isset( $share_icons[ $icon ] ) ? strtr(
		$share_icons[ $icon ][1],
		array(
			'$permalink' => $permalink,
			'$title'     => $title,
			'$image'     => $image,
			'$excerpt'   => $excerpt,
		)
	) : '#' ) : $link['url'],
	'rel'   => empty( $share_link_nofollow ) ? 'nofollow' : '',
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}
?>
<a <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>

<?php // share icon Render ?>
	<i class="<?php echo esc_attr( isset( $share_icons[ $icon ] ) ? $share_icons[ $icon ][0] : 'fab fa-facebook-f' ); ?>"></i>
</a>
<?php
