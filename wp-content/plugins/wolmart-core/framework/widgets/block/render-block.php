<?php
/**
 * Render template for block widget.
 *
 * @package Wolmart Core WordPress Plugin
 * @since 1.0
 * @version 1.2.3 - Elementor Pro Compatibility issue.
 */

if ( ! post_type_exists( 'wolmart_template' ) ) {
	return;
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'name' => '',
		),
		$atts
	)
);

if ( ! $name ) {
	return;
}

// Get post ID.
$post_id = 0;

if ( is_numeric( $name ) ) {
	$post_id = absint( $name );
} else {
	global $wpdb;
	$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_name = %s", 'wolmart_template', $name ) );
}
$post_id = (int) $post_id;

if ( $post_id ) {

	// Polylang
	if ( function_exists( 'pll_get_post' ) && pll_get_post( $post_id ) ) {
		$lang_id = pll_get_post( $post_id );
		if ( $lang_id ) {
			$post_id = $lang_id;
		}
	}

	// WPML
	if ( function_exists( 'icl_object_id' ) ) {
		$lang_id = icl_object_id( $post_id, 'wolmart_template', false, ICL_LANGUAGE_CODE );
		if ( $lang_id ) {
			$post_id = $lang_id;
		}
	}

	$the_post = get_post( $post_id, null, 'display' );

	if ( 'publish' != $the_post->post_status ) {
		return;
	}

	if ( $the_post ) {

		// Tooltip to edit
		$edit_link = '';
		if ( current_user_can( 'edit_pages' ) && ! is_customize_preview() &&
			( ! function_exists( 'wolmart_is_elementor_preview' ) || ! wolmart_is_elementor_preview() ) &&
			( ! function_exists( 'wolmart_is_wpb_preview' ) || ! wolmart_is_wpb_preview() ) &&
			apply_filters( 'wolmart_show_templates_edit_link', true ) ) {

			if ( defined( 'ELEMENTOR_VERSION' ) && get_post_meta( $post_id, '_elementor_edit_mode', true ) ) {
				$edit_link = admin_url( 'post.php?post=' . $post_id . '&action=elementor' );
			} else {
				$edit_link = admin_url( 'post.php?post=' . $post_id . '&action=edit' );
			}

			$builder_type = get_post_meta( $post_id, 'wolmart_template_type', true );
			if ( ! $builder_type ) {
				$builder_type = esc_html__( 'Template', 'wolmart-core' );
			}
		}

		if ( defined( 'ELEMENTOR_VERSION' ) && get_post_meta( $post_id, '_elementor_edit_mode', true ) ) {

			$elements_data = get_post_meta( $post_id, '_elementor_data', true );
			if ( $elements_data ) {
				$elements_data = json_decode( $elements_data, true );
			}

			if ( ! empty( $elements_data ) ) {

				do_action( 'wolmart_before_elementor_block_content', $the_post, 'wolmart_template' );
				if ( ! wolmart_is_elementor_preview() || ! isset( $_REQUEST['elementor-preview'] ) || $_REQUEST['elementor-preview'] != $post_id ) { // Check if current elementor block is editing
					global $wolmart_layout;

					if ( ! ( $wolmart_layout && isset( $wolmart_layout['used_blocks'] ) && isset( $wolmart_layout['used_blocks'][ $post_id ] ) && $wolmart_layout['used_blocks'][ $post_id ]['css'] ) ) {
						$css_file = new Elementor\Core\Files\CSS\Post( $post_id );
						$css_file->print_css();

						$block_css = get_post_meta( (int) $post_id, 'page_css', true );
						if ( $block_css ) {
							$style  = '';
							$style .= '<style id="block_' . (int) $post_id . '_css">';
							$style .= function_exists( 'wolmart_minify_css' ) ? wolmart_minify_css( $block_css ) : $block_css;
							$style .= '</style>';

							echo apply_filters( 'wolmart_elementor_block_style', wolmart_filter_inline_css( $style, false ) );
						}
					}

					// load block js in theme-assets.php file
					if ( ! ( $wolmart_layout && isset( $wolmart_layout['used_blocks'] ) && isset( $wolmart_layout['used_blocks'][ $post_id ] ) && $wolmart_layout['used_blocks'][ $post_id ]['js'] || ( function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'resource_jquery_footer' ) ) ) ) {
						$block_js = get_post_meta( (int) $post_id, 'page_js', true );
						if ( $block_js ) {
							$style  = '';
							$style .= '<script id="block_' . (int) $post_id . '_js">';

							$block_js = str_replace( ']]>', ']]&gt;', $block_js );
							$block_js = preg_replace( '/<script.*?\/script>/s', '', $block_js ) ? : $block_js;
							$block_js = preg_replace( '/<style.*?\/style>/s', '', $block_js ) ? : $block_js;

							$style .= $block_js;
							$style .= '</script>';

							echo apply_filters( 'wolmart_elementor_block_script', $style );

							$wolmart_layout['used_blocks'][ $post_id ]['js'] = true;
						}
					}
				}

				$el_attr  = '';
				$el_class = '';

				if ( wolmart_is_elementor_preview() && is_single( $post_id ) && ! ( 'wolmart_template' == get_post_type( $post_id ) && 'product_layout' == get_post_meta( $post_id, 'wolmart_template_type', true ) ) ) {
					$el_attr = ' data-el-class="elementor-' . (int) $post_id . '"';
				} else {
					$el_class = ' elementor-' . (int) $post_id;
				}

				if ( $edit_link ) {
					/* translators: template name */
					echo '<div class="wolmart-edit-link d-none" data-title="' . sprintf( esc_html__( 'Edit %1$s: %2$s', 'wolmart-core' ), esc_attr( str_replace( '_', ' ', $builder_type ) ), esc_attr( get_the_title( $post_id ) ) ) . '" data-link="' . esc_url( $edit_link ) . '"></div>';
				}
				echo '<div class="wolmart-block elementor' . esc_attr( $el_class ) . '"' . $el_attr . ' data-block-id="' . (int) $post_id . '" data-elementor-id="' . esc_attr( $post_id ) . '" data-elementor-type="wolmart-block">';

				$document    = Elementor\Plugin::$instance->documents->get_doc_for_frontend( $post_id );
				$switch_flag = false;

				if ( ! empty( $document ) && $document->is_built_with_elementor() ) {
					Elementor\Plugin::$instance->documents->switch_to_document( $document );
					$switch_flag = true;
				}

				foreach ( $elements_data as $element_data ) {

					$element = Elementor\Plugin::$instance->elements_manager->create_element_instance( $element_data );

					if ( ! $element ) {
						continue;
					}

					ob_start();
					$element->print_element();
					echo apply_filters( 'wolmart_lazyload_images', ob_get_clean() );
				}

				if ( $switch_flag ) {
					Elementor\Plugin::$instance->documents->restore_document();
				}

				echo '</div>';

				do_action( 'wolmart_after_elementor_block_content', $the_post, 'wolmart_template' );

				return;

			} else {
				global $post;
				$post = $the_post;
				setup_postdata( $the_post );
				the_content();
			}
		} else {
			// not elementor page
			do_action( 'wolmart_before_block_content', $the_post, 'wolmart_template' );
			if ( ! isset( $the_post->post_content ) ) {
				return;
			}
			$post_content = $the_post->post_content;

			global $wolmart_layout;


			if ( ! ( $wolmart_layout && isset( $wolmart_layout['used_blocks'] ) && isset( $wolmart_layout['used_blocks'][ $post_id ] ) && $wolmart_layout['used_blocks'][ $post_id ]['css'] ) && ! ( wolmart_is_elementor_preview() && wolmart_is_wpb_preview() && wolmart_is_vc_preview() && isset( $_REQUEST['post_id'] ) && $_REQUEST['post_id'] == $post_id ) ) {
				$block_css = '';

				if ( defined( 'WPB_VC_VERSION' ) ) {
					$block_css .= get_post_meta( (int) $post_id, '_wpb_shortcodes_custom_css', true );
					$block_css .= get_post_meta( (int) $post_id, '_wpb_post_custom_css', true );
				}

				$block_css .= get_post_meta( (int) $post_id, 'page_css', true );
				if ( $block_css ) {
					ob_start();
					echo '<style id="block_' . (int) $post_id . '_css">';
					echo function_exists( 'wolmart_minify_css' ) ? wolmart_minify_css( $block_css ) : $block_css;
					echo '</style>';
					wolmart_filter_inline_css( ob_get_clean() );
				}
			}

			if ( $edit_link ) {
				/* translators: %1$s represents template type, %2$s represents post title. */
				echo '<div class="wolmart-edit-link d-none" data-title="' . sprintf( esc_html__( 'Edit %1$s: %2$s', 'wolmart-core' ), esc_attr( str_replace( '_', ' ', $builder_type ) ), esc_attr( get_the_title( $post_id ) ) ) . '" data-link="' . esc_url( $edit_link ) . '"></div>';
			}
			echo '<div class="wolmart-block" data-block-id="' . (int) $post_id . '">';
			if ( function_exists( 'has_blocks' ) && has_blocks( $the_post ) ) {
				echo do_shortcode( do_blocks( $post_content ) );
			} else {
				echo do_shortcode( $post_content );
			}
			echo '</div>';

			do_action( 'wolmart_after_block_content', $the_post, 'wolmart_template' );
		}
	}
}
