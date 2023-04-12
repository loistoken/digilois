<?php
/**
 * Wolmart Responsive Callback
 *
 * adds responsive control for element option
 * follow below example of wolmart_responsive control
 *
 *
 * @since 1.0.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function wolmart_responsive_callback( $settings, $value ) {
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$form_value = $value;
	$value      = ! empty( $value ) ? json_decode( $value, true ) : array();
	$class      = 'wolmart-wpb-responsive-container';

	ob_start();
	?>
	<div class="<?php echo esc_attr( $class ); ?>"
		data-xl="<?php echo esc_attr( ! empty( $value['xl'] ) ? 'true' : '' ); ?>"
		data-lg="<?php echo esc_attr( ! empty( $value['lg'] ) ? 'true' : '' ); ?>"
		data-md="<?php echo esc_attr( ! empty( $value['md'] ) ? 'true' : '' ); ?>"
		data-sm="<?php echo esc_attr( ! empty( $value['sm'] ) ? 'true' : '' ); ?>"
		data-xs="<?php echo esc_attr( ! empty( $value['xs'] ) ? 'true' : '' ); ?>"
	>
	<ul class="wolmart-wpb-responsive">
	<li data-width="xl" title=">= 1200px" class="active" data-size="100%">
		<i class="vc-composer-icon vc-c-icon-layout_default"></i>
		<span class="<?php echo esc_attr( ! empty( $value['xl'] ) ? 'hide' : '' ); ?>"></span>
	</li>
	<li data-width="lg" title=">= 992px" data-size="1024px">
		<i class="vc-composer-icon vc-c-icon-layout_landscape-tablets"></i>
		<span class="<?php echo esc_attr( ! empty( $value['lg'] ) ? 'hide' : '' ); ?>"></span>
	</li>
	<li data-width="md" title=">= 768px" data-size="768px">
		<i class="vc-composer-icon vc-c-icon-layout_portrait-tablets"></i>
		<span class="<?php echo esc_attr( ! empty( $value['md'] ) ? 'hide' : '' ); ?>"></span>
	</li>
	<li data-width="sm" title=">= 576px" data-size="480px">
		<i class="vc-composer-icon vc-c-icon-layout_landscape-smartphones"></i>
		<span class="<?php echo esc_attr( ! empty( $value['sm'] ) ? 'hide' : '' ); ?>"></span>
	</li>
	<li data-width="xs" title="< 576px" data-size="320px">
		<i class="vc-composer-icon vc-c-icon-layout_portrait-smartphones"></i>
		<span class="<?php echo esc_attr( ! empty( $value['xs'] ) ? 'hide' : '' ); ?>"></span>
	</li>
	</ul>
	</div>
	<?php
	$html .= ob_get_clean();
	$html .= '<input type="hidden" name="' . esc_attr( $param_name ) . '" class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $type ) . '_field" value="' . esc_attr( $form_value ) . '" ' . ' />';

	return $html;
}
vc_add_shortcode_param( 'wolmart_responsive', 'wolmart_responsive_callback', WOLMART_CORE_PLUGINS_URI . '/wpb/params/responsive.js' );
