<?php
/**
 * Wolmart Ajax Select2 Control
 *
 * @package Wolmart WordPress Framework
 * @version 1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Base_Data_Control;

class Wolmart_Control_Ajaxselect2 extends Base_Data_Control {

	/**
	 * Get select2 control type.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'ajaxselect2';
	}

	/**
	 * Get select2 control default settings.
	 *
	 * @since 1.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'options'        => [],
			'multiple'       => false,
			'select2options' => [],
		];
	}

	/**
	 * Enqueue control scripts and styles.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'wolmart-ajax-select2-control', WOLMART_CORE_ELEMENTOR_URI . '/controls/ajaxselect2-editor.js' );
	}

	/**
	 * Render select2 control output in the editor.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		$rest_api    = get_site_url( '' ) . '/wp-json/ajaxselect2/v1';
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select 
					id="<?php echo esc_attr( $control_uid ); ?>"
					class="elementor-ajaxselect2" 
					type="ajaxselect2" {{ multiple }} 
					data-setting="{{ data.name }}"
					data-ajax-url="<?php echo esc_url( $rest_api ) . '/{{data.options}}/'; ?>""
				>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
