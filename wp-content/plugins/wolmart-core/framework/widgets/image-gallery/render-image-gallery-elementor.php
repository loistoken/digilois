<?php
/**
 * Wolmart Image Gallery Widget Render
 *
 */

defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'layout_type'         => '',
			'images'              => '',
			'caption_type'        => '',
			'thumbnail_size'      => 'thumbnail',
			'slider_image_expand' => '',
			'items_list'          => '',
			'row_cnt'             => 1,
			'col_sp'              => 'md',
		),
		$atts
	)
);

if ( 0 === (int) $row_cnt ) {
	$row_cnt = 1;
}

// Layout
$extra_class = 'image-gallery';
$extra_attrs = '';
if ( 'creative' != $layout_type ) {
	$col_cnt      = wolmart_elementor_grid_col_cnt( $atts );
	$extra_class .= ' ' . wolmart_get_col_class( $col_cnt );
}
$extra_class .= ' ' . wolmart_get_grid_space_class( $atts );
if ( 'creative' == $layout_type ) {
	$extra_class .= ' row creative-grid grid-gallery';
	if ( function_exists( 'wolmart_is_elementor_preview' ) && wolmart_is_elementor_preview() ) {
		$extra_class .= ' editor-mode';
	}
	if ( isset( $atts['creative_mode'] ) ) {
		$extra_class .= 'preset-grid grid-layout-' . $atts['creative_mode'];
	}
	if ( is_array( $items_list ) ) {
		$repeaters = array(
			'ids'    => array(),
			'images' => array(),
		);
		foreach ( $items_list as $item ) {
			$repeaters['ids'][ (int) $item['item_no'] ]    = 'elementor-repeater-item-' . $item['_id'];
			$repeaters['images'][ (int) $item['item_no'] ] = $item['item_thumb_size'];
		}
	}
} elseif ( 'slider' == $layout_type ) {
	$extra_class .= ' slider-image-gallery';

	if ( '' == $slider_image_expand ) {
		$extra_class .= ' slider-image-org';
	}

	$extra_class .= ' ' . wolmart_get_grid_space_class( $atts );
	$extra_class .= ' ' . wolmart_get_slider_class( $atts );
	$extra_attrs .= ' data-slider-options="' . esc_attr(
		json_encode(
			wolmart_get_slider_attrs( $atts, $col_cnt )
		)
	) . '"';
}

?>

<ul class="<?php echo esc_attr( $extra_class ); ?>"<?php echo $extra_attrs; ?>>
	<?php
	foreach ( $images as $index => $attachment ) :
		$img_class = 'grid' == $layout_type ? 'grid-item image-wrap' : 'image-wrap';
		if ( isset( $atts['creative_mode'] ) ) {
			$item_thumb_size = wolmart_get_creative_image_sizes( $atts['creative_mode'], $index );
		}
		$item_thumb_size = empty( $item_thumb_size ) ? $thumbnail_size : $item_thumb_size;
		$img_wrap_class  = '';
		$wrap_attrs      = '';
		if ( 'creative' == $layout_type ) {
			$img_wrap_class = 'grid-item';
			$img_wrap_attr  = '';
			if ( isset( $repeaters ) ) {
				if ( isset( $repeaters['ids'][ $index + 1 ] ) ) {
					$img_wrap_class .= ' ' . $repeaters['ids'][ $index + 1 ];
					$item_thumb_size = $repeaters['images'][ $index + 1 ];
				}

				if ( isset( $repeaters['ids'][0] ) ) {
					$img_wrap_class .= ' ' . $repeaters['ids'][0];
				}
			}
			$wrap_attrs = ' data-grid-idx="' . ( $index + 1 ) . '"';
		} elseif ( 'slider' == $layout_type && 1 != $row_cnt ) {
			if ( 1 == ( $index + 1 ) % (int) $row_cnt ) {
				echo '<li class="gallery-col"><ul>';
			}
		}
		echo '<li class="' . esc_attr( $img_wrap_class ) . '"' . esc_attr( $wrap_attrs ) . '>';
		?>
		<figure class="<?php echo esc_attr( $img_class ); ?>">
			<?php
			echo wp_get_attachment_image( $attachment['id'], $item_thumb_size );

			$image_caption = '';
			if ( $caption_type ) {
				$attachment_post = get_post( $attachment['id'] );
				if ( 'caption' == $caption_type ) {
					$image_caption = $attachment_post->post_excerpt;
				} elseif ( 'title' == $caption_type ) {
					$image_caption = $attachment_post->post_title;
				} else {
					$image_caption = $attachment_post->post_content;
				}
			}

			if ( ! empty( $image_caption ) ) {
				echo '<figcaption class="elementor-image-carousel-caption">' . wolmart_strip_script_tags( $image_caption ) . '</figcaption>';
			}
			?>
		</figure>
		<?php
		echo '</li>';
		if ( 'slider' == $layout_type && 1 != $row_cnt ) {
			if ( 0 == ( $index + 1 ) % (int) $row_cnt ) {
				echo '</ul></li>';
			}
		}
	endforeach;
	?>
</ul>
