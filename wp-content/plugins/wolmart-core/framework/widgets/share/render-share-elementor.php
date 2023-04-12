<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Button Widget Render
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'share_buttons' => array(
				array(
					'site' => 'facebook',
					'link' => '',
				),
				array(
					'site' => 'twitter',
					'link' => '',
				),
				array(
					'site' => 'linkedin',
					'link' => '',
				),
			),
			'type'          => 'stacked',
			'custom_color'  => '',

			// For elementor inline editing
			'self'          => '',
		),
		$atts
	)
);
?>

<div class="social-icons">
	<?php
	$custom              = 'yes' == $custom_color ? ' social-custom' : '';
	$share_link_nofollow = wolmart_get_option( 'share_link_nofollow' );

	if ( $share_buttons ) {
		foreach ( $share_buttons as $share ) {
			$link  = $share['link']['url'];
			$share = $share['site'];

			if ( '' == $link ) {
				$permalink = esc_url( apply_filters( 'the_permalink', get_permalink() ) );
				$title     = esc_attr( get_the_title() );
				$image     = wp_get_attachment_url( get_post_thumbnail_id() );

				if ( 'whatsapp' == $share ) {
					$title = rawurlencode( $title );
				} else {
					$title = urlencode( $title );
				}

				if ( $self ) {
					$link = strtr(
						$self->share_icons[ $share ][1],
						array(
							'$permalink' => $permalink,
							'$title'     => $title,
							'$image'     => $image,
						)
					);
				}
			}

			echo '<a href="' . ( $link ? esc_url( $link ) : '#' ) . '" class="social-icon ' . esc_attr( $type . $custom ) . ' social-' . $share . '" target="_blank" title="' . $share . '" rel="noopener noreferrer' . ( ! empty( $share_link_nofollow ) ? ' nofollow' : '' ) . '">';
			if ( $self ) {
				echo '<i class="' . esc_attr( $self->share_icons[ $share ][0] ) . '"></i>';
			}
			echo '</a>';
		}
	}
	?>
</div>

<?php
