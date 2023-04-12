<?php
/**
 * Wolmart WPBakery Dimension Callback
 *
 * adds dimension control for element option
 * follow below example of wolmart_dimension control
 *
 * array(
 *      'type'        => 'wolmart_dimension',
 *      'heading'     => __( 'Buttton Padding', 'wolmart-core' ),
 *      'param_name'  => 'btn_padding',
 *      'responsive'  => true,
 *      'value'       => '',
 *      'group'       => 'General',
 *      'selectors'   => array(
 *          '{{WRAPPER}}.btn' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
 *      )
 * )
 *
 * @since 1.0.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function wolmart_dimension_callback( $settings, $value ) {
	$param_name    = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type          = isset( $settings['type'] ) ? $settings['type'] : '';
	$is_responsive = isset( $settings['responsive'] ) ? $settings['responsive'] : false;
	$units         = isset( $settings['units'] ) ? $settings['units'] : array();
	$class         = 'wolmart-wpb-dimension-container';

	if ( $is_responsive ) {
		$class .= ' wolmart-responsive-control';
	}

	$responsive_value = json_decode( $value, true );
	$saved_unit       = ! empty( $responsive_value['unit'] ) ? $responsive_value['unit'] : '';
	$html             = '<div class="' . esc_attr( $class ) . '">';
	$dimensions       = array(
		'top'    => esc_html__( 'Top', 'wolmart-core' ),
		'right'  => esc_html__( 'Right', 'wolmart-core' ),
		'bottom' => esc_html__( 'Bottom', 'wolmart-core' ),
		'left'   => esc_html__( 'Left', 'wolmart-core' ),
	);

	foreach ( $dimensions as $dimension => $label ) {
		ob_start();
		$dimension_class = 'wolmart-wpb-dimension-wrap ' . $dimension;
		?>
		<div class="<?php echo esc_attr( $dimension_class ); ?>">
		<input type="text"
			class="wolmart-wpb-dimension"
			value="<?php echo esc_html( $responsive_value[ $dimension ]['xl'] ); ?>"
			data-xl="<?php echo ( isset( $responsive_value[ $dimension ]['xl'] ) ? esc_html( $responsive_value[ $dimension ]['xl'] ) : '' ); ?>"
			data-lg="<?php echo ( isset( $responsive_value[ $dimension ]['lg'] ) ? esc_html( $responsive_value[ $dimension ]['lg'] ) : '' ); ?>"
			data-md="<?php echo ( isset( $responsive_value[ $dimension ]['md'] ) ? esc_html( $responsive_value[ $dimension ]['md'] ) : '' ); ?>"
			data-sm="<?php echo ( isset( $responsive_value[ $dimension ]['sm'] ) ? esc_html( $responsive_value[ $dimension ]['sm'] ) : '' ); ?>"
			data-xs="<?php echo ( isset( $responsive_value[ $dimension ]['xs'] ) ? esc_html( $responsive_value[ $dimension ]['xs'] ) : '' ); ?>"
			/>
		<label><?php echo esc_html( $label ); ?></label>
		</div>
		<?php
		$html .= ob_get_clean();
	}

	if ( $is_responsive ) {
		ob_start();
		?>
		<div class="wolmart-responsive-dropdown">
			<a class="wolmart-responsive-toggle" title="Toggle Responsive Option"><i class="vc-composer-icon vc-c-icon-layout_default"></i></a>
			<ul class="wolmart-responsive-span">
				<li data-width="xl" title=">= 1200px" class="active" data-size="100%"><i class="vc-composer-icon vc-c-icon-layout_default"></i></li>
				<li data-width="lg" title=">= 992px" data-size="1024px"><i class="vc-composer-icon vc-c-icon-layout_landscape-tablets"></i></li>
				<li data-width="md" title=">= 768px" data-size="768px"><i class="vc-composer-icon vc-c-icon-layout_portrait-tablets"></i></li>
				<li data-width="sm" title=">= 576px" data-size="480px"><i class="vc-composer-icon vc-c-icon-layout_landscape-smartphones"></i></li>
				<li data-width="xs" title="< 576px" data-size="320px"><i class="vc-composer-icon vc-c-icon-layout_portrait-smartphones"></i></li>
			</ul>
		</div>
		<?php
		$html .= ob_get_clean();
	}

	$html .= '</div>';
	$html .= '<input type="hidden" name="' . esc_attr( $param_name ) . '" class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $type ) . '_field" value="' . esc_attr( $value ) . '" ' . ' />';
	return $html;
}

vc_add_shortcode_param( 'wolmart_dimension', 'wolmart_dimension_callback', WOLMART_CORE_PLUGINS_URI . '/wpb/params/dimension.js' );
