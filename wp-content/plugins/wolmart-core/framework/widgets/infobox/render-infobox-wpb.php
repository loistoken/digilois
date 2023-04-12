<?php
/**
 * InfoBox Shortcode Render
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
			'enable_svg'  => '',
			'svg_html'    => '',
			'title'       => esc_html__( 'Free Shipping & Return', 'wolmart-core' ),
			'description' => esc_html__( 'Free shipping on orders over $99', 'wolmart-core' ),
			'html_tag'    => 'h3',
			'icon_pos'    => 'left',
			'icon'        => 'w-icon-truck',
			'link'        => '',
			'class'       => '',

		),
		$atts
	)
);

$wrapper_attrs = array(
	'class' => 'wolmart-infobox icon-box ' . $atts['shortcode_class'] . $atts['style_class'] . ( 'top' == $icon_pos ? '' : ' icon-box-side' ) . ' icon-box-' . $icon_pos,
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}
?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>

<?php // info Box Render ?>
<?php if ( ! empty( $icon ) || 'yes' == $enable_svg ) : ?>
	<span class="icon-box-icon d-inline-flex align-items-center justify-content-center">
		<?php
		if ( 'yes' == $enable_svg ) {
			if ( ! empty( $svg_html ) ) {
				echo wolmart_escaped( rawurldecode( base64_decode( wp_strip_all_tags( $svg_html ) ) ) );
			}
		} else {
			if ( ! empty( $link ) && isset( $link['url'] ) ) :
				?>
				<a href="<?php echo esc_attr( $link['url'] ); ?>" >
			<?php endif; ?>
			<i class="<?php echo esc_attr( $icon ); ?>"></i>
			<?php if ( ! empty( $link ) && isset( $link['url'] ) ) : ?>
				</a>
				<?php
			endif;
		}
		?>
	</span>
<?php endif; ?>
	<div class="icon-box-content">
	<?php if ( ! empty( $title ) ) : ?>
		<?php if ( ! empty( $link ) && isset( $link['url'] ) ) : ?>
			<a href="<?php echo esc_url( $link['url'] ); ?>" >
		<?php endif; ?>
		<<?php echo wolmart_escaped( $html_tag ); ?> class="icon-box-title"><?php echo wolmart_strip_script_tags( $title ); ?></<?php echo wolmart_escaped( $html_tag ); ?>>
		<?php if ( ! empty( $link ) && isset( $link['url'] ) ) : ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ( ! empty( $description ) ) : ?>
		<p><?php echo wolmart_strip_script_tags( $description ); ?></p>
	<?php endif; ?>
	</div>
</div>
<?php
