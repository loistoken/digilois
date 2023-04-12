<?php
/**
 * Product Attribute Guide Addon
 *
 * @package Wolmart Core WordPress Framework
 * @version 1.0.0
 */

function wolmart_product_attribute_add_guide_options() {
	//  Add, edit, or delete guide options
	$guide_block       = isset( $_POST['guide_block'] ) ? absint( $_POST['guide_block'] ) : ''; // WPCS: input var ok, CSRF ok.
	$guide_text        = isset( $_POST['guide_text'] ) ? wc_clean( wp_unslash( $_POST['guide_text'] ) ) : ''; // WPCS: input var ok, CSRF ok.
	$guide_icon        = isset( $_POST['guide_icon'] ) ? wc_clean( wp_unslash( $_POST['guide_icon'] ) ) : ''; // WPCS: input var ok, CSRF ok.
	$att_name          = isset( $_POST['attribute_name'] ) ? wc_sanitize_taxonomy_name( wp_unslash( $_POST['attribute_name'] ) ) : ''; // WPCS: input var ok, CSRF ok, sanitization ok.
	$wolmart_pa_blocks = get_option( 'wolmart_pa_blocks', array() );
	if ( ! empty( $_POST['add_new_attribute'] ) || ( ! empty( $_POST['save_attribute'] ) && ! empty( $_GET['edit'] ) ) ) { // WPCS: CSRF ok.
		$wolmart_pa_blocks[ $att_name ] = array(
			'block' => $guide_block,
			'text'  => $guide_text,
			'icon'  => $guide_icon,
		);
	} elseif ( ! empty( $_GET['delete'] ) && isset( $wolmart_pa_blocks[ $att_name ] ) ) {
		unset( $wolmart_pa_blocks[ $att_name ] );
	}
	update_option( 'wolmart_pa_blocks', $wolmart_pa_blocks );
}


// Show guide input controls
wolmart_product_attribute_add_guide_options();
add_action( 'woocommerce_after_add_attribute_fields', 'wolmart_wc_product_attribute_add_guide_options' );
add_action( 'woocommerce_after_edit_attribute_fields', 'wolmart_wc_product_attribute_edit_guide_options' );


function wolmart_wc_product_attribute_add_guide_options() {
	// Get blocks
	$posts = get_posts(
		array(
			'post_type'   => 'wolmart_template',
			'meta_key'    => 'wolmart_template_type',
			'meta_value'  => 'block',
			'numberposts' => -1,
		)
	);
	sort( $posts );
	?>
	<div class="form-field">
		<label for="guide_block"><?php esc_html_e( 'Guide block', 'wolmart-core' ); ?></label>
		<select name="guide_block" id="guide_block">
			<option value=""></option>
	<?php foreach ( $posts as $post ) : ?>
				<option value="<?php echo esc_attr( $post->ID ); ?>"><?php echo esc_html( $post->post_title ); ?></option>
			<?php endforeach; ?>
		</select>
		<p class="description"><?php esc_html_e( 'Guide block for the attribute(shown in product data tabs).', 'wolmart-core' ); ?></p>
	</div>
	<div class="form-field">
		<label for="guide_text"><?php esc_html_e( 'Guide link text', 'wolmart-core' ); ?></label>
		<input name="guide_text" id="guide_text" type="text" maxlength="64" />
		<p class="description"><?php esc_html_e( 'Link text for guide block.', 'wolmart-core' ); ?></p>
	</div>
	<div class="form-field">
		<label for="guide_icon"><?php esc_html_e( 'Guide link icon', 'wolmart-core' ); ?></label>
		<input name="guide_icon" id="guide_icon" type="text" maxlength="64" />
		<p class="description"><?php esc_html_e( 'Icon class for guide link.', 'wolmart-core' ); ?></p>
	</div>
	<?php
}

function wolmart_wc_product_attribute_edit_guide_options() {
	$guide_block = isset( $_POST['guide_block'] ) ? absint( $_POST['guide_block'] ) : ''; // WPCS: input var ok, CSRF ok.
	$guide_text  = isset( $_POST['guide_text'] ) ? wc_clean( wp_unslash( $_POST['guide_text'] ) ) : ''; // WPCS: input var ok, CSRF ok.
	$guide_icon  = isset( $_POST['guide_icon'] ) ? wc_clean( wp_unslash( $_POST['guide_icon'] ) ) : ''; // WPCS: input var ok, CSRF ok.
	$edit        = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;

	if ( $edit ) {
		global $wpdb;
		$attribute = $wpdb->get_row(
			$wpdb->prepare( "SELECT attribute_name FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_id = %d", $edit )
		);

		if ( $attribute ) {
			$att_name = $attribute->attribute_name;

			$wolmart_pa_blocks = get_option( 'wolmart_pa_blocks', array() );
			if ( isset( $wolmart_pa_blocks[ $att_name ] ) ) {
				$guide_block = $wolmart_pa_blocks[ $att_name ]['block'];
				$guide_text  = $wolmart_pa_blocks[ $att_name ]['text'];
				$guide_icon  = $wolmart_pa_blocks[ $att_name ]['icon'];
			}
		}
	}

	// Get blocks
	$posts = get_posts(
		array(
			'post_type'   => 'wolmart_template',
			'meta_key'    => 'wolmart_template_type',
			'meta_value'  => 'block',
			'numberposts' => -1,
		)
	);
	sort( $posts );

	// Form
	?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="guide_block"><?php esc_html_e( 'Guide block', 'wolmart-core' ); ?></label>
		</th>
		<td>
			<select name="guide_block" id="guide_block">
				<option value=""></option>
		<?php foreach ( $posts as $post ) : ?>
					<option value="<?php echo esc_attr( $post->ID ); ?>" <?php selected( $guide_block, $post->ID ); ?>><?php echo esc_html( $post->post_title ); ?></option>
				<?php endforeach; ?>
			</select>
			<p class="description"><?php esc_html_e( 'Guide block for the attribute(shown in product data tabs).', 'wolmart-core' ); ?></p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="guide_text"><?php esc_html_e( 'Guide link text', 'wolmart-core' ); ?></label>
		</th>
		<td>
			<input name="guide_text" id="guide_text" type="text" value="<?php echo esc_attr( $guide_text ); ?>" maxlength="28" />
			<p class="description"><?php esc_html_e( 'Link text for guide block.', 'wolmart-core' ); ?></p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="guide_icon"><?php esc_html_e( 'Guide icon', 'wolmart-core' ); ?></label>
		</th>
		<td>
			<input name="guide_icon" id="guide_icon" type="text" value="<?php echo esc_attr( $guide_icon ); ?>" maxlength="64" />
			<p class="description"><?php esc_html_e( 'Icon class for guide title.', 'wolmart-core' ); ?></p>
		</td>
	</tr>
	<?php
}
