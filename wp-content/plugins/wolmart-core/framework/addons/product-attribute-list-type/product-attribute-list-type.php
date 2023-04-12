<?php

// direct load is not allowed
defined( 'ABSPATH' ) || die;

$is_list_added        = false;
$attribute_taxonomies = wc_get_attribute_taxonomies();
foreach ( $attribute_taxonomies as $tax ) {
	if ( 'list' == $tax->attribute_type ) {
		add_action( wc_attribute_taxonomy_name( $tax->attribute_name ) . '_edit_form_fields', 'wolmart_attr_edit_form_fields', 100, 2 );
		$is_list_added = true;
	}
}
if ( $is_list_added ) {
	add_action( 'created_term', 'wolmart_save_attr_meta', 100, 3 );
	add_action( 'edit_term', 'wolmart_save_attr_meta', 100, 3 );
	add_action( 'delete_term', 'wolmart_delete_attr_meta', 10, 5 );
}
add_filter( 'product_attributes_type_selector', 'wolmart_product_attributes_add_list_type' );
add_action( 'woocommerce_product_option_terms', 'wolmart_wc_product_option_terms', 10, 3 );


function wolmart_product_attributes_add_list_type( $types ) {
	$types['list'] = esc_html__( 'List', 'wolmart-core' );
	return $types;
}

function wolmart_wc_product_option_terms( $attribute_taxonomy, $i, $attribute ) {
	if ( 'list' == $attribute_taxonomy->attribute_type ) :
		?>
		<select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'woocommerce' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo esc_attr( $i ); ?>][]">
			<?php
			$args      = array(
				'orderby'    => ! empty( $attribute_taxonomy->attribute_orderby ) ? $attribute_taxonomy->attribute_orderby : 'name',
				'hide_empty' => 0,
			);
			$all_terms = get_terms( $attribute->get_taxonomy(), apply_filters( 'woocommerce_product_attribute_terms', $args ) );
			if ( $all_terms ) {
				foreach ( $all_terms as $term ) {
					$options = $attribute->get_options();
					$options = ! empty( $options ) ? $options : array();
					echo '<option value="' . esc_attr( $term->term_id ) . '"' . wc_selected( $term->term_id, $options ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
				}
			}
			?>
		</select>
		<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'woocommerce' ); ?></button>
		<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'woocommerce' ); ?></button>
		<button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'woocommerce' ); ?></button>
		<?php
	endif;
}

function wolmart_save_attr_meta( $term_id, $tt_id, $taxonomy ) {
	if ( 'pa_' != substr( $taxonomy, 0, 3 ) ) {
		return;
	}

	$args = array( 'attr_label', 'attr_color' );

	foreach ( $args as $arg ) {
		if ( ! empty( $_POST[ $arg ] ) ) {
			if ( 'cat_col_cnt' == $arg ) {
				update_term_meta( $term_id, $arg, intval( $_POST[ $arg ] ) );
			} else {
				update_term_meta( $term_id, $arg, sanitize_text_field( $_POST[ $arg ] ) );
			}
		} else {
			delete_term_meta( $term_id, $arg );
		}
	}
}

function wolmart_delete_attr_meta( $term_id, $tt_id, $taxonomy, $deleted_term, $object_ids ) {
	if ( 'pa_' != substr( $taxonomy, 0, 3 ) ) {
		return;
	}

	$args = array( 'attr_label', 'attr_color' );

	foreach ( $args as $arg ) {
		delete_term_meta( $term_id, $arg );
	}
}

function wolmart_attr_edit_form_fields( $tag, $taxonomy ) {
	if ( 'pa_' != substr( $taxonomy, 0, 3 ) ) {
		return;
	}

	$attribute_taxonomies = wc_get_attribute_taxonomies();

	if ( $attribute_taxonomies ) {
		foreach ( $attribute_taxonomies as $tax ) {
			if ( 'list' == $tax->attribute_type &&
				wc_attribute_taxonomy_name( $tax->attribute_name ) == $taxonomy ) {
				?>
				<tr class="form-field">
					<th scope="row"><label for="name"><?php esc_html_e( 'Swatch Label', 'wolmart-core' ); ?></label></th>
					<td>
						<input name="attr_label" id="attr_label" type="text" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'attr_label', true ) ); ?>" placeholder="Short text with 1 or 2 letters...">
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="name"><?php esc_html_e( 'Swatch Color', 'wolmart-core' ); ?></label></th>
					<td>
						<input type="text" class="wolmart-color-picker" id="attr_color" name="attr_color" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'attr_color', true ) ); ?>">
					</td>
				</tr>
				<?php
			}
		}
	}
}
