<?php
/**
 * Wolmart WPBakery Number Callback
 *
 * follow below example of wolmart_number control
 *
 *
 * @since 1.0.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function wolmart_dropdown_callback( $settings, $value ) {
	$param_name       = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type             = isset( $settings['type'] ) ? $settings['type'] : '';
	$is_responsive    = isset( $settings['responsive'] ) ? $settings['responsive'] : false;
	$responsive_value = array();
	$class            = 'wolmart-wpb-dropdown-container';

	if ( $is_responsive ) {
		$class           .= ' wolmart-responsive-control';
		$responsive_value = json_decode( $value, true );
		$value            = $responsive_value['xl'];
	}

	$html = '<div class="' . esc_attr( $class ) . '">';

	$html .= '<select class="wolmart-wpb-dropdown' . ( $is_responsive ? '' : ' simple-value' ) . '" data-xl="' . ( isset( $responsive_value['xl'] ) ? esc_html( $responsive_value['xl'] ) : '' ) . '"
    data-lg="' . ( isset( $responsive_value['lg'] ) ? esc_html( $responsive_value['lg'] ) : '' ) . '"
    data-md="' . ( isset( $responsive_value['md'] ) ? esc_html( $responsive_value['md'] ) : '' ) . '"
    data-sm="' . ( isset( $responsive_value['sm'] ) ? esc_html( $responsive_value['sm'] ) : '' ) . '"
    data-xs="' . ( isset( $responsive_value['xs'] ) ? esc_html( $responsive_value['xs'] ) : '' ) . '" >';

	if ( ! empty( $settings['value'] ) ) {
		foreach ( $settings['value'] as $option_label => $option_value ) {
			$selected            = '';
			$option_value_string = (string) $option_value;
			$value_string        = (string) $value;
			if ( '' !== $value && $option_value_string === $value_string ) {
				$selected = 'selected="selected"';
			}
			$option_class = str_replace( '#', 'hash-', $option_value );
			$html        .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '" ' . $selected . '>' . htmlspecialchars( $option_label ) . '</option>';
		}
	}
	$html .= '</select>';

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

vc_add_shortcode_param( 'wolmart_dropdown', 'wolmart_dropdown_callback', WOLMART_CORE_PLUGINS_URI . '/wpb/params/dropdown.js' );
