<?php

defined( 'ABSPATH' ) || die;

/**
 * Wolmart Image_Choose Control
 *
 * @since 1.0
 */

use Elementor\Base_Data_Control;

class Wolmart_Control_Description extends Base_Data_Control {
	public function get_type() {
		return 'description';
	}

	public function content_template() {
		$control_uid = $this->get_control_uid( '{{value}}' );
		?>
		<div class="elementor-control-field">
			<p class="elementor-control-description">{{{ data.description }}}</p>
		</div>
		<?php
	}

	protected function get_default_settings() {
		return [
			'options' => [],
			'toggle'  => true,
		];
	}
}
