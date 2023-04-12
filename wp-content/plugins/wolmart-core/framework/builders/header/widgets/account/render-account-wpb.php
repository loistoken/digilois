<?php
/**
 * Header Account Shortcode Render
 *
 * @since 1.0.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'wolmart-hb-account-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'wolmart_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

$atts = array(
	'type'             => isset( $atts['type'] ) ? $atts['type'] : 'inline',
	'items'            => isset( $atts['account_items'] ) ? explode( ',', $atts['account_items'] ) : array( 'icon', 'login', 'register' ),
	'login_text'       => isset( $atts['account_login'] ) ? $atts['account_login'] : esc_html__( 'Log in', 'wolmart-core' ),
	'logout_text'      => isset( $atts['account_logout'] ) ? $atts['account_logout'] : esc_html__( 'Log out', 'wolmart-core' ),
	'register_text'    => isset( $atts['account_register'] ) ? $atts['account_register'] : esc_html__( 'Register', 'wolmart-core' ),
	'delimiter_text'   => isset( $atts['account_delimiter'] ) ? $atts['account_delimiter'] : '/',
	'icon'             => isset( $atts['icon'] ) && $atts['icon'] ? $atts['icon'] : 'w-icon-account',
	'account_dropdown' => isset( $atts['account_dropdown'] ) ? 'yes' == $atts['account_dropdown'] : '',
	'account_avatar'   => isset( $atts['account_avatar'] ) ? 'yes' == $atts['account_avatar'] : '',
);

?>
<div <?php echo wolmart_escaped( $wrapper_attr_html ); ?>>
	<?php require __DIR__ . '/render-account-elementor.php'; ?>
</div>
<?php
