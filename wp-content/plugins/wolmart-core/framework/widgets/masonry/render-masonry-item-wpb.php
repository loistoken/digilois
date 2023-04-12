<?php
/**
 * Masonry Item Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-masonry-item-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

if ( ! vc_is_inline() ) {
	$wrapper_attrs['class'] .= ' grid-item';
}

$settings = array_merge( array(), wolmart_wpb_convert_responsive_values( 'creative_width', $atts, 0 ) );
$settings = array_merge( $settings, wolmart_wpb_convert_responsive_values( 'creative_height', $atts, 'preset' ) );
$settings = array_merge( $settings, wolmart_wpb_convert_responsive_values( 'creative_order', $atts, '' ) );

$grid = array();

global $wolmart_wpb_creative_layout;

if ( isset( $wolmart_wpb_creative_layout ) && ! vc_is_inline() ) {
	$idx = $wolmart_wpb_creative_layout['index'];
	if ( $idx < count( $wolmart_wpb_creative_layout['preset'] ) ) {
		foreach ( $wolmart_wpb_creative_layout['preset'][ $idx ] as $key => $value ) {
			if ( 'h' == $key ) {
				continue;
			}

			$grid[ $key ] = $value;
		}
	} else {
		$grid['w']   = '1-4';
		$grid['w-l'] = '1-2';
	}
}

// get grid values
if ( $settings['creative_width_xl'] ) {
	$grid['w'] = $grid['w-xl'] = $grid['w-l'] = $grid['w-m'] = $grid['w-s'] = $settings['creative_width_xl'];
}
if ( $settings['creative_width'] ) {
	$grid['w-xl'] = $grid['w-l'] = $grid['w-m'] = $grid['w-s'] = $settings['creative_width'];
}
if ( $settings['creative_width_tablet'] ) {
	$grid['w-l'] = $grid['w-m'] = $grid['w-s'] = $settings['creative_width_tablet'];
}
if ( $settings['creative_width_mobile'] ) {
	$grid['w-m'] = $grid['w-s'] = $settings['creative_width_mobile'];
}
if ( $settings['creative_width_min'] ) {
	$grid['w-s'] = $settings['creative_width_min'];
}

if ( 'preset' == $settings['creative_height_xl'] ) {
	if ( ! vc_is_inline() ) {
		$grid['h'] = $idx < count( $wolmart_wpb_creative_layout['preset'] ) ? $wolmart_wpb_creative_layout['preset'][ $idx ]['h'] : '1-3';
	}
} elseif ( 'child' != $settings['creative_height_xl'] ) {
	$grid['h'] = $settings['creative_height_xl'];
}
if ( $settings['creative_height'] && 'preset' != $settings['creative_height'] && 'child' != $settings['creative_height'] ) {
	$grid['h-xl'] = $settings['creative_height'];
}
if ( $settings['creative_height_tablet'] && 'preset' != $settings['creative_height_tablet'] && 'child' != $settings['creative_height_tablet'] ) {
	$grid['h-l'] = $settings['creative_height_tablet'];
}
if ( $settings['creative_height_mobile'] && 'preset' != $settings['creative_height_mobile'] && 'child' != $settings['creative_height_mobile'] ) {
	$grid['h-m'] = $settings['creative_height_mobile'];
}
if ( $settings['creative_height_min'] && 'preset' != $settings['creative_height_min'] && 'child' != $settings['creative_height_min'] ) {
	$grid['h-s'] = $settings['creative_height_min'];
}

if ( $settings['creative_order'] ) {
	$wrapper_attrs['data-creative-order'] = $settings['creative_order'];
} elseif ( ! vc_is_inline() ) {
	$wrapper_attrs['data-creative-order'] = $idx + 1;
}
if ( $settings['creative_order_xl'] ) {
	$wrapper_attrs['data-creative-order-xl'] = $settings['creative_order_xl'];
} elseif ( ! vc_is_inline() ) {
	$wrapper_attrs['data-creative-order-xl'] = $idx + 1;
}
if ( $settings['creative_order_tablet'] ) {
	$wrapper_attrs['data-creative-order-lg'] = $settings['creative_order_tablet'];
} elseif ( ! vc_is_inline() ) {
	$wrapper_attrs['data-creative-order-lg'] = $idx + 1;
}
if ( $settings['creative_order_mobile'] ) {
	$wrapper_attrs['data-creative-order-md'] = $settings['creative_order_mobile'];
} elseif ( ! vc_is_inline() ) {
	$wrapper_attrs['data-creative-order-md'] = $idx + 1;
}
if ( $settings['creative_order_min'] ) {
	$wrapper_attrs['data-creative-order-sm'] = $settings['creative_order_min'];
} elseif ( ! vc_is_inline() ) {
	$wrapper_attrs['data-creative-order-sm'] = $idx + 1;
}

foreach ( $grid as $key => $value ) {
	if ( false !== strpos( $key, 'w' ) && is_numeric( $value ) && 1 != $value ) {
		if ( 0 == 100 % $value ) {
			if ( 100 == $value ) {
				$grid[ $key ] = '1';
			} else {
				$grid[ $key ] = '1-' . ( 100 / $value );
			}
		} else {
			for ( $i = 1; $i <= 100; ++$i ) {
				$val       = $value * $i;
				$val_round = round( $val );
				if ( abs( round( $val - $val_round, 2, PHP_ROUND_HALF_UP ) ) <= 0.01 ) {
					$g            = wolmart_get_gcd( 100, $val_round );
					$grid[ $key ] = ( $val_round / $g ) . '-' . ( $i * 100 / $g );
					break;
				}
			}
		}
	}
}

if ( ! vc_is_inline() ) {
	foreach ( $grid as $key => $value ) {
		if ( $value ) {
			$wrapper_attrs['class'] .= ' ' . $key . '-' . $value;
		}
	}
}

if ( isset( $wolmart_wpb_creative_layout ) && ! vc_is_inline() ) {
	$wolmart_wpb_creative_layout['layout'][ $idx ] = $grid;
	$wolmart_wpb_creative_layout['index']          = ++$idx;
}

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

if ( vc_is_inline() ) {
	$wrapper_attr_html .= ' data-creative-item=' . json_encode( $grid );
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
<?php
echo do_shortcode( $atts['content'] );
?>
</div>
<?php

