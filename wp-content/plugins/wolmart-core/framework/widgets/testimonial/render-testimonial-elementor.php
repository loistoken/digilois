<?php

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'testimonial_type'    => 'simple',
			'name'                => esc_html__( 'John Doe', 'wolmart-core' ),
			'role'                => esc_html__( 'Customer', 'wolmart-core' ),
			'link'                => '',
			'title'               => '',
			'content'             => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'wolmart-core' ),
			'avatar'              => array( 'url' => '' ),
			'rating'              => '',
			'star_icon'           => '',
			'avatar_pos'          => 'top',
			'commenter_pos'       => 'after',
			'aside_commenter_pos' => 'after_avatar',
			'rating_pos'          => 'before_title',
			'rating_sp'           => array( 'size' => 0 ),
		),
		$atts
	)
);

$html        = '';
$rating_html = '';

if ( defined( 'ELEMENTOR_VERSION' ) ) {
	$image = Elementor\Group_Control_Image_Size::get_attachment_image_html( $atts, 'avatar' );
} else {
	$image = '';
	if ( is_numeric( $avatar ) ) {
		$img_data = wp_get_attachment_image_src( $avatar, 'full' );
		$img_alt  = get_post_meta( $avatar, '_wp_attachment_image_alt', true );
		$img_alt  = $img_alt ? esc_attr( trim( $img_alt ) ) : esc_attr__( 'Testimonial Image', 'wolmart-core' );

		if ( is_array( $img_data ) ) {
			$image = '<img src="' . esc_url( $img_data[0] ) . '" alt="' . $img_alt . '" width="' . esc_attr( $img_data[1] ) . '" height="' . esc_attr( $img_data[2] ) . '">';
		}
	}
}

if ( isset( $link['url'] ) && $link['url'] ) {
	$image = '<a href="' . esc_url( $link['url'] ) . '">' . $image . '</a>';
}

$image = '<div class="avatar">' . $image . '</div>';

$title_escaped = trim( esc_html( $title ) );
$content       = '<p class="comment">' . esc_textarea( $content ) . '</p>';

if ( $rating && 'simple' != $testimonial_type ) {
	$rating            = floatval( $rating );
	$rating_sp['size'] = floatval( $rating_sp['size'] );
	$rating_cls        = '';
	if ( $star_icon ) {
		$rating_cls .= ' ' . $star_icon;
	}
	$rating_w     = 'calc(' . 20 * floatval( $rating ) . '% - ' . $rating_sp['size'] * ( $rating - floor( $rating ) ) . 'px)'; // get rating width
	$rating_html .= '<div class="ratings-container"><div class="ratings-full' . $rating_cls . '" style="letter-spacing: ' . $rating_sp['size'] . 'px;" aria-label="Rated ' . $rating . ' out of 5"><span class="ratings" style="width: ' . $rating_w . '; letter-spacing: ' . $rating_sp['size'] . 'px;"></span></div></div>';
}
$commenter = '<cite><span class="name">' . esc_html( $name ) . '</span><span class="role">' . esc_html( $role ) . '</span></cite>';

if ( 'simple' == $testimonial_type ) {
	$html .= '<blockquote class="testimonial testimonial-simple' . ( 'yes' == $atts['testimonial_inverse'] ? ' inversed' : '' ) . '">';
	$html .= '<div class="content">' . $content . '</div>';
	$html .= '<div class="commenter">' . $image . $commenter . '</div>';
	$html .= '</blockquote>';
} elseif ( 'boxed' == $testimonial_type ) {
	$html .= '<blockquote class="testimonial testimonial-boxed ' . ( 'top' == $avatar_pos ? 'avatar-top' : 'avatar-bottom' ) . '">';
	if ( 'top' == $avatar_pos ) {
		$html .= $image;
	}
	if ( 'before_title' == $rating_pos ) {
		$html .= $rating_html;
	}
	if ( ! empty( $title_escaped ) ) {
		$html .= ' <h5 class="comment-title">' . $title_escaped . '</h5>';
	}
	if ( 'after_title' == $rating_pos ) {
		$html .= $rating_html;
	}
	if ( 'before' == $commenter_pos ) {
		$html .= '<div class="commentor">' . $commenter . '</div>';
	}
	if ( 'before_comment' == $rating_pos ) {
		$html .= $rating_html;
	}

	$html .= '<div class="content">' . $content . '</div>';

	if ( 'after_comment' == $rating_pos ) {
		$html .= $rating_html;
	}
	if ( 'after' == $commenter_pos ) {
		$html .= $commenter;
	}
	if ( 'bottom' == $avatar_pos ) {
		$html .= $image;
	}
	$html .= '</blockquote>';
} elseif ( 'aside' == $testimonial_type ) {
	$html .= '<blockquote class="testimonial testimonial-aside ' . ( 'yes' == $atts['testimonial_inverse'] ? ' inversed' : '' ) . '">';
	$html .= '<div class="commentor">';
	$html .= $image;
	if ( 'after_avatar' == $aside_commenter_pos ) {
		$html .= $commenter;
	}
	$html .= '</div>';
	$html .= '<div class="content">';
	if ( 'before_title' == $rating_pos ) {
		$html .= $rating_html;
	}
	if ( ! empty( $title_escaped ) ) {
		$html .= ' <h5 class="comment-title">' . $title_escaped . '</h5>';
	}
	if ( 'after_title' == $rating_pos ) {
		$html .= $rating_html;
	}
	if ( 'before_comment' == $aside_commenter_pos ) {
		$html .= $commenter;
	}
	$html .= $content;
	if ( 'after_comment' == $rating_pos ) {
		$html .= $rating_html;
	}
	if ( 'after_comment' == $aside_commenter_pos ) {
		$html .= $commenter;
	}
	$html .= '</div>';
	$html .= '</blockquote>';
}

echo $html; //phpcs:ignore
