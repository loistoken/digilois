<?php
/**
 * List item Shortcode Render
 *
 * @since 1.0.0
 */


// Preprocess
if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'title' => esc_html__( 'Free Shipping & Return', 'wolmart-core' ),
			'icon'  => '',
			'link'  => '',
			'class' => '',

		),
		$atts
	)
);

$wrapper_attrs = array(
	'class' => 'wolmart-list-item ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}
?>
<li <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>

<?php // info Box Render ?>
<?php if ( ! empty( $icon ) ) : ?>
	<span class="list-item-icon vertical-middle">
	<?php if ( ! empty( $link ) && isset( $link['url'] ) ) : ?>
		<a href="<?php echo esc_url( $link['url'] ); ?>" >
	<?php endif; ?>
	<i class="<?php echo esc_attr( $icon ); ?>"></i>
	<?php if ( ! empty( $link ) ) : ?>
		</a>
	<?php endif; ?>
	</span>
<?php endif; ?>
	<span class="list-item-content vertical-middle">
	<?php if ( ! empty( $title ) ) : ?>
		<?php if ( ! empty( $link ) && isset( $link['url'] ) ) : ?>
			<a href="<?php echo esc_url( $link['url'] ); ?>" >
		<?php endif; ?>
		<?php echo wolmart_escaped( $title ); ?>
		<?php if ( ! empty( $link ) ) : ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
	</span>
</li>
<?php
