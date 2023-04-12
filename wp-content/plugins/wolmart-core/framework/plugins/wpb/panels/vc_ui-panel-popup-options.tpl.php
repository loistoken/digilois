<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$popup_options = get_post_meta( get_the_ID(), 'popup_options', true );
if ( $popup_options && ! is_array( $popup_options ) ) {
	$popup_options = json_decode( $popup_options, true );
}
if ( ! $popup_options ) {
	$popup_options = array(
		'width'               => '600',
		'h_pos'               => 'center',
		'v_pos'               => 'center',
		'border'              => '',
		'top'                 => '',
		'right'               => '',
		'bottom'              => '',
		'left'                => '',
		'popup_animation'     => '',
		'popup_anim_duration' => 400,
	);
}
?>

<div class="vc_ui-font-open-sans vc_ui-panel-window vc_media-xs vc_ui-panel vc_ui-wolmart-panel" data-vc-panel=".vc_ui-panel-header-header" data-vc-ui-element="panel-wolmart-popup-options" id="vc_ui-panel-wolmart-popup-options">
	<div class="vc_ui-panel-window-inner">
		<?php
		vc_include_template(
			'editors/popups/vc_ui-header.tpl.php',
			array(
				'title'            => esc_html__( 'Wolmart Popup Options', 'js_composer' ),
				'controls'         => array( 'minimize', 'close' ),
				'header_css_class' => 'vc_ui-wolmart-popup-options-header-container',
				'content_template' => '',
			)
		);
		?>
		<div class="vc_ui-panel-content-container">
			<div class="vc_ui-panel-content vc_properties-list vc_edit_form_elements" data-vc-ui-element="panel-content">
				<div class="vc_row">
					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Popup Width', 'wolmart-core' ); ?></div>
						<div class="edit_form_line">
							<input name="popup_width" class="wpb-textinput" type="number" value="<?php echo esc_attr( $popup_options['width'] ); ?>" id="vc_popup-width-field" placeholder="<?php esc_attr_e( 'Default value is 600px.', 'wolmart-core' ); ?>">
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Horizontal Position', 'wolmart-core' ); ?></div>
						<div class="edit_form_line">
							<select name="popup_h_pos" class="wpb-textinput" type="number" id="vc_popup-h_pos-field">
								<option value="flex-start" <?php selected( 'flex-start' == $popup_options['h_pos'] ); ?>><?php esc_html_e( 'Left', 'wolmart-core' ); ?></option>
								<option value="center" <?php selected( 'center' == $popup_options['h_pos'] ); ?>><?php esc_html_e( 'Center', 'wolmart-core' ); ?></option>
								<option value="flex-end" <?php selected( 'flex-end' == $popup_options['h_pos'] ); ?>><?php esc_html_e( 'Right', 'wolmart-core' ); ?></option>
							</select>
						</div>
					</div>
					
					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Vertical Position', 'wolmart-core' ); ?></div>
						<div class="edit_form_line">
							<select name="popup_v_pos" class="wpb-textinput" type="number" id="vc_popup-v_pos-field">
								<option value="flex-start" <?php selected( 'flex-start' == $popup_options['v_pos'] ); ?>><?php esc_html_e( 'Top', 'wolmart-core' ); ?></option>
								<option value="center" <?php selected( 'center' == $popup_options['v_pos'] ); ?>><?php esc_html_e( 'Middle', 'wolmart-core' ); ?></option>
								<option value="flex-end" <?php selected( 'flex-end' == $popup_options['v_pos'] ); ?>><?php esc_html_e( 'Bottom', 'wolmart-core' ); ?></option>
							</select>
						</div>
					</div>
					
					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Border Radius', 'wolmart-core' ); ?></div>
						<div class="edit_form_line">
							<input name="popup_border" class="wpb-textinput" type="number" value="<?php echo esc_attr( $popup_options['border'] ); ?>" id="vc_popup-border-field" placeholder="<?php esc_attr_e( '0px', 'wolmart-core' ); ?>">
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column wpb_edit_form_elements wpb_el_type_wolmart_dimension">
						<div class="wpb_element_label"><?php esc_html_e( 'Margin', 'wolmart-core' ); ?></div>
						<div class="edit_form_line">
							<div class="wolmart-wpb-dimension-container">
								<div class="wolmart-wpb-dimension-wrap top">
									<input type="text" class="wpb-textinput wolmart-wpb-dimension" name="popup_margin_top" value="<?php echo esc_attr( $popup_options['top'] ); ?>" id="vc_popup-margin-top-field">
									<label><?php esc_html_e( 'Top', 'wolmart-core' ); ?></label>
								</div>
								<div class="wolmart-wpb-dimension-wrap right">
									<input type="text" class="wpb-textinput wolmart-wpb-dimension" name="popup_margin_right" value="<?php echo esc_attr( $popup_options['right'] ); ?>" id="vc_popup-margin-right-field">
									<label><?php esc_html_e( 'Right', 'wolmart-core' ); ?></label>
								</div>
								<div class="wolmart-wpb-dimension-wrap bottom">
									<input type="text" class="wpb-textinput wolmart-wpb-dimension" name="popup_margin_bottom" value="<?php echo esc_attr( $popup_options['bottom'] ); ?>" id="vc_popup-margin-bottom-field">
									<label><?php esc_html_e( 'Bottom', 'wolmart-core' ); ?></label>
								</div>
								<div class="wolmart-wpb-dimension-wrap left">
									<input type="text" class="wpb-textinput wolmart-wpb-dimension" name="popup_margin_left" value="<?php echo esc_attr( $popup_options['left'] ); ?>" id="vc_popup-margin-left-field">
									<label><?php esc_html_e( 'Left', 'wolmart-core' ); ?></label>
								</div>
							</div>
						</div>
					</div>

					<?php $animations = wolmart_get_animations( 'in' ); ?>
					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Popup Animation', 'wolmart-core' ); ?></div>
						<div class="edit_form_line">
							<select name="popup_animation" class="wpb-textinput" type="number" id="vc_popup-animation-field">

								<?php foreach ( $animations as $key => $value ) { ?>
									<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key == $popup_options['popup_animation'] ); ?>><?php echo esc_html( $value ); ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Animation Duration (ms)', 'wolmart-core' ); ?></div>
						<div class="edit_form_line">
							<input name="popup_anim_duration" class="wpb-textinput" type="number" value="<?php echo esc_attr( $popup_options['popup_anim_duration'] ); ?>" id="vc_popup-anim-duration-field">
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label" style="font-weight: 400; max-width: 400px;"><?php echo sprintf( esc_html__( 'Please add two classes - "show-popup popup-id-ID" to any elements you want to show this popup on click. %1$se.g) show-popup popup-id-725%2$s', 'wolmart-core' ), '<b>', '</b>' ); ?></div>
					</div>
				</div>
			</div>
		</div>
		<!-- param window footer-->
		<?php
		vc_include_template(
			'editors/popups/vc_ui-footer.tpl.php',
			array(
				'controls' => array(
					array(
						'name'        => 'save',
						'label'       => esc_html__( 'Save changes', 'js_composer' ),
						'css_classes' => 'vc_ui-button-fw',
						'style'       => 'action',
					),
				),
			)
		);
		?>
	</div>
</div>
