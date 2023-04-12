<?php
/**
 * Banner Layer Shortcode Render
 *
 * @since 1.0.0
 */
extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'banner_origin' => 't-mc',
		),
		$atts
	)
);

// Preprocess
$banner_origin_cls  = ' banner-content ';
$banner_origin_cls .= $banner_origin;
$wrapper_attrs      = array(
	'class' => 'wolmart-banner-layer-container ' . $atts['shortcode_class'] . $banner_origin_cls . $atts['style_class'],
);
$anim_attrs         = array(
	'class' => 'banner-content-inner ',
);

// Responsive
if ( ! empty( $atts['responsiveness'] ) ) {
	$responsive = str_replace( '``', '"', $atts['responsiveness'] );
	$responsive = json_decode( $responsive, true );
	// Generate Helper Classes
	$responsive_classes = array(
		'xl' => 'hide-on-xl',
		'lg' => 'hide-on-lg',
		'md' => 'hide-on-md',
		'sm' => 'hide-on-sm',
		'xs' => 'hide-on-xs',
	);

	$style = '';
	foreach ( $responsive_classes as $width => $helper_class ) {
		if ( ! empty( $responsive[ $width ] ) && true == $responsive[ $width ] ) {
			$wrapper_attrs['class'] .= ' ' . $helper_class;
		}
	}
}
// Extra Class
if ( ! empty( $atts['extra_class'] ) ) {
	$wrapper_attrs['class'] .= ' ' . $atts['extra_class'];
}

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}
// Animation
if ( ! empty( $atts['animation_type'] ) ) {
	if ( ! vc_is_inline() ) {
		$anim_attrs['class'] .= ' appear-animate';
	}

	$animation_settings          = array(
		'_animation'          => $atts['animation_type'],
		'_animation_delay'    => ! empty( $atts['animation_delay'] ) ? $atts['animation_delay'] : '0',
		'_animation_duration' => ! empty( $atts['animation_duration'] ) ? $atts['animation_duration'] : '1000',
	);
	$anim_attrs['data-settings'] = esc_attr( json_encode( $animation_settings ) );
}

$anim_attr_html = '';
foreach ( $anim_attrs as $key => $value ) {
	$anim_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
	<?php
	if ( ! empty( $atts['animation_type'] ) ) {
		?>
		<div <?php echo wolmart_escaped( $anim_attr_html ); ?>>
		<?php
	}
	echo do_shortcode( $atts['content'] );
	?>
	<?php if ( ! empty( $atts['animation_type'] ) ) { ?>
	</div>
	<?php } ?>
</div>
<?php
