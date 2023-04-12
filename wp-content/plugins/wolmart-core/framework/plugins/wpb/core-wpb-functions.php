<?php

/**
 * Generate hash code from attribues in WPBakery.
 *
 * @since 1.0.0
 * @param array $params
 * @return string
 */
if ( ! function_exists( 'wolmart_get_global_hashcode' ) ) {
	function wolmart_get_global_hashcode( $atts, $tag, $params ) {
		$result = '';
		if ( is_array( $atts ) ) {
			$callback = function( $item, $key ) use ( $params ) {
				foreach ( $params as $param ) {
					if ( $param['param_name'] == $key && ! empty( $param['selectors'] ) ) {
						return true;
					}
				}
				return false;
			};
			if ( 'wpb_wolmart_masonry' != $tag ) {
				$atts = array_filter(
					$atts,
					$callback,
					ARRAY_FILTER_USE_BOTH
				);
			}
			$keys   = array_keys( $atts );
			$values = array_values( $atts );
			$hash   = $tag . implode( '', $keys ) . implode( '', $values );
			if ( 0 == strlen( $hash ) ) {
				return '0';
			}
			return hash( 'md5', $hash );
		}
		return '0';
	}
}

/**
 * wolmart_wpb_filter_element_params
 *
 * filters params following structure of WPB element params
 *
 * @param array     $unfiltered_params - required param
 * @param string    $shortcode_name    - optional param
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_filter_element_params' ) ) {
	function wolmart_wpb_filter_element_params( $unfiltered_params, $shortcode_name = '' ) {
		require_once WOLMART_CORE_WPB . '/partials/images.php';
		require_once WOLMART_CORE_WPB . '/partials/posts.php';
		require_once WOLMART_CORE_WPB . '/partials/categories.php';
		require_once WOLMART_CORE_WPB . '/partials/products.php';
		require_once WOLMART_CORE_WPB . '/partials/grid.php';
		require_once WOLMART_CORE_WPB . '/partials/banner.php';
		require_once WOLMART_CORE_WPB . '/partials/single-product.php';

		$params                  = array();
		$imagedot_param          = 'wpb_wolmart_carousel' == $shortcode_name;
		$product_wrapper_element = 'wpb_wolmart_products_layout' == $shortcode_name;
		$element_layout          = '';

		if ( false !== strpos( $shortcode_name, '_grid' ) ) {
			$element_layout = 'grid';
		} elseif ( false !== strpos( $shortcode_name, '_slider' ) ) {
			$element_layout = 'slider';
		} elseif ( false !== strpos( $shortcode_name, '_masonry' ) ) {
			$element_layout = 'creative';
		}

		foreach ( $unfiltered_params as $group => $group_options ) {
			if ( ! is_numeric( $group ) ) { // with group
				foreach ( $group_options as $subgroup => $options ) {
					if ( ! is_numeric( $subgroup ) ) { // with accordion
						$params[] = array(
							'type'       => 'wolmart_accordion_header',
							'heading'    => $subgroup,
							'param_name' => str_replace( ' ', '_', strtolower( $subgroup ) ) . '_ah',
							'group'      => $group,
						);

						foreach ( $options as $option ) {
							if ( is_string( $option ) ) {
								if ( 'wolmart_wpb_slider_dots_controls' == $option ) {
									$partials = call_user_func( $option, $imagedot_param );
								} elseif ( 'wolmart_wpb_elements_layout_controls' == $option ) {
									$partials = call_user_func_array( $option, array( $product_wrapper_element, $element_layout, $shortcode_name ) );
								} else {
									$partials = call_user_func( $option );
								}
								foreach ( $partials as $item ) {
									$item['group'] = $group;
									$params[]      = $item;
								}
							} else {
								$option['group'] = $group;
								$params[]        = $option;
							}
						}
					} else {
						if ( is_string( $options ) ) { // partial params
							if ( 'wolmart_wpb_slider_dots_controls' == $options ) {
								$partials = call_user_func( $options, $imagedot_param );
							} elseif ( 'wolmart_wpb_elements_layout_controls' == $options ) {
								$partials = call_user_func_array( $options, array( $product_wrapper_element, $element_layout, $shortcode_name ) );
							} else {
								$partials = call_user_func( $options );
							}
							foreach ( $partials as $item ) {
								$item['group'] = $group;
								$params[]      = $item;
							}
						} else { // without accordion
							$options['group'] = $group;
							$params[]         = $options;
						}
					}
				}
			} else {
				if ( is_string( $group_options ) ) { // partial params
					if ( 'wolmart_wpb_slider_dots_controls' == $group_options ) {
						$partials = call_user_func( $group_options, $imagedot_param );
					} elseif ( 'wolmart_wpb_elements_layout_controls' == $group_options ) {
						$partials = call_user_func_array( $group_options, array( $product_wrapper_element, $element_layout, $shortcode_name ) );
					} else {
						$partials = call_user_func( $option );
					}
					foreach ( $partials as $item ) {
						$params[] = $item;
					}
				} else { // without group
					$params[] = $group_options;
				}
			}
		}

		return $params;
	}
}

/**
 * wolmart_wpb_shortcode_product_id_callback
 *
 * get product id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_product_id_callback' ) ) {
	function wolmart_wpb_shortcode_product_id_callback( $query ) {
		if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
			$vc_vendor_wc = new Vc_Vendor_Woocommerce();
			return $vc_vendor_wc->productIdAutocompleteSuggester( $query );
		}
		return '';
	}
}

/**
 * wolmart_wpb_shortcode_post_id_callback
 *
 * get block id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_post_id_callback' ) ) {
	function wolmart_wpb_shortcode_post_id_callback( $query ) {
		$query_args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
			'name__like'     => sanitize_text_field( $query ),
		);

		$query   = new WP_Query( $query_args );
		$options = array();
		if ( $query->have_posts() ) :
			$posts = $query->get_posts();
			foreach ( $posts as $p ) {
				$options[] = array(
					'value' => (int) $p->ID,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $p->post_title ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * wolmart_wpb_shortcode_vendor_id_callback
 *
 * get block id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_vendor_id_callback' ) ) {
	function wolmart_wpb_shortcode_vendor_id_callback( $query ) {

		global $wpdb;

		$search_value = $query;

		$role = 'seller';

		if ( class_exists( 'WC_Vendors' ) ) {
			$role = 'vendor';
		} elseif ( class_exists( 'WCFM' ) ) {
			$role = 'wcfm_vendor';
		} elseif ( class_exists( 'WCMp' ) ) {
			$role = 'dc_vendor';
		}

		$sellers = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT 
					users.ID AS ID, 
					users.display_name AS display_name
					FROM {$wpdb->users} AS users
					INNER JOIN {$wpdb->usermeta} AS wum
					ON users.ID = wum.user_id
				WHERE users.user_status = 'approved' AND users.display_name LIKE %s AND wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND wum.meta_value LIKE %s",
				'%' . $wpdb->esc_like( stripslashes( $search_value ) ) . '%',
				'%' . $wpdb->esc_like( $role ) . '%'
			),
			ARRAY_A
		);

		if ( ! empty( $sellers ) ) {
			foreach ( $sellers as $seller ) {
				$result[] = array(
					'value' => $seller['ID'],
					'label' => $seller['display_name'],
				);
			}
		}
		return $result;
	}
}


/**
 * wolmart_wpb_shortcode_block_id_callback
 *
 * get block id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_block_id_callback' ) ) {
	function wolmart_wpb_shortcode_block_id_callback( $query ) {
		$query_args = array(
			'post_type'      => 'wolmart_template',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
			'name__like'     => sanitize_text_field( $query ),
			'meta_query'     => array(
				array(
					'key'   => 'wolmart_template_type',
					'value' => 'block',
				),
			),
		);

		$query   = new WP_Query( $query_args );
		$options = array();
		if ( $query->have_posts() ) :
			$posts = $query->get_posts();
			foreach ( $posts as $p ) {
				$options[] = array(
					'value' => (int) $p->ID,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $p->post_title ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * wolmart_wpb_shortcode_category_id_callback
 *
 * get category id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_category_id_callback' ) ) {
	function wolmart_wpb_shortcode_category_id_callback( $query ) {
		$query_args = array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
			'name__like' => sanitize_text_field( $query ),
		);

		$terms   = get_terms( $query_args );
		$options = array();
		if ( count( $terms ) ) :
			foreach ( $terms as $term ) {
				$options[] = array(
					'value' => (int) $term->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * wolmart_wpb_shortcode_product_category_id_callback
 *
 * get product_category id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_product_category_id_callback' ) ) {
	function wolmart_wpb_shortcode_product_category_id_callback( $query ) {
		$query_args = array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'name__like' => sanitize_text_field( $query ),
		);

		$terms   = get_terms( $query_args );
		$options = array();
		if ( count( $terms ) ) :
			foreach ( $terms as $term ) {
				$options[] = array(
					'value' => (int) $term->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * wolmart_wpb_shortcode_brand_id_callback
 *
 * get product_brand id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_brand_id_callback' ) ) {
	function wolmart_wpb_shortcode_brand_id_callback( $query ) {
		$query_args = array(
			'taxonomy'   => 'product_brand',
			'hide_empty' => false,
			'name__like' => sanitize_text_field( $query ),
		);

		$terms   = get_terms( $query_args );
		$options = array();
		if ( count( $terms ) ) :
			foreach ( $terms as $term ) {
				$options[] = array(
					'value' => (int) $term->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				);
			}
		endif;
		return $options;
	}
}


/**
 * wolmart_wpb_shortcode_product_id_render
 *
 * get product id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_product_id_render' ) ) {
	function wolmart_wpb_shortcode_product_id_render( $query ) {
		if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
			$vc_vendor_wc = new Vc_Vendor_Woocommerce();
			return $vc_vendor_wc->productIdAutocompleteRender( $query );
		}
		return '';
	}
}


/**
 * wolmart_wpb_shortcode_vendor_id_render
 *
 * get vendor id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_vendor_id_render' ) ) {
	function wolmart_wpb_shortcode_vendor_id_render( $query ) {
		global $wpdb;

		$search_value = $query['value'];

		$roles = 'seller';
		if ( class_exists( 'WC_Vendors' ) ) {
			$role = 'vendor';
		} elseif ( class_exists( 'WCFM' ) ) {
			$role = 'wcfm_vendor';
		} elseif ( class_exists( 'WCMp' ) ) {
			$role = 'dc_vendor';
		}

		$sellers = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT 
					users.ID AS ID, 
					users.display_name AS display_name,					
					FROM {$wpdb->users} AS users
					INNER JOIN {$wpdb->usermeta} AS usermeta
					ON users.ID = usermeta.user_id
					WHERE users.user_status = 'approved' AND users.ID=%d AND wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND usermeta.meta_value LIKE %s",
				(int) stripslashes( $search_value ),
				'%' . $wpdb->esc_like( $role ) . '%'
			),
			ARRAY_A
		);

		if ( ! empty( $sellers ) ) {
			foreach ( $sellers as $seller ) {
				$result = array(
					'value' => $seller['ID'],
					'label' => $seller['display_name'],
				);
			}
		}
		return $result;
	}
}

/**
 * wolmart_wpb_shortcode_post_id_render
 *
 * get post id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_post_id_render' ) ) {
	function wolmart_wpb_shortcode_post_id_render( $query ) {
		$query_args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
			'p'              => $query['value'],
		);

		$query   = new WP_Query( $query_args );
		$options = array();
		if ( $query->have_posts() ) :
			$posts = $query->get_posts();
			foreach ( $posts as $p ) {
				$options = array(
					'value' => (int) $p->ID,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $p->post_title ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * wolmart_wpb_shortcode_block_id_render
 *
 * get block id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_block_id_render' ) ) {
	function wolmart_wpb_shortcode_block_id_render( $query ) {
		$query_args = array(
			'post_type'      => 'wolmart_template',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
			'p'              => $query['value'],
			'meta_query'     => array(
				array(
					'key'   => 'wolmart_template_type',
					'value' => 'block',
				),
			),
		);

		$query   = new WP_Query( $query_args );
		$options = array();
		if ( $query->have_posts() ) :
			$posts = $query->get_posts();
			foreach ( $posts as $p ) {
				$options = array(
					'value' => (int) $p->ID,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $p->post_title ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * wolmart_wpb_shortcode_category_id_render
 *
 * get category id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_category_id_render' ) ) {
	function wolmart_wpb_shortcode_category_id_render( $query ) {
		$query_args = array(
			'taxonomy'         => 'category',
			'hide_empty'       => false,
			'term_taxonomy_id' => $query['value'],
		);

		$terms   = get_terms( $query_args );
		$options = array();
		if ( count( $terms ) ) :
			foreach ( $terms as $term ) {
				$options = array(
					'value' => (int) $term->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * wolmart_wpb_shortcode_product_category_id_render
 *
 * get product_category id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_product_category_id_render' ) ) {
	function wolmart_wpb_shortcode_product_category_id_render( $query ) {
		$query_args = array(
			'taxonomy'         => 'product_cat',
			'hide_empty'       => false,
			'term_taxonomy_id' => $query['value'],
		);

		$terms   = get_terms( $query_args );
		$options = array();
		if ( count( $terms ) ) :
			foreach ( $terms as $term ) {
				$options = array(
					'value' => (int) $term->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * wolmart_wpb_shortcode_brand_id_render
 *
 * get product_brand id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_brand_id_render' ) ) {
	function wolmart_wpb_shortcode_brand_id_render( $query ) {
		$query_args = array(
			'taxonomy'         => 'product_brand',
			'hide_empty'       => false,
			'term_taxonomy_id' => $query['value'],
		);

		$terms   = get_terms( $query_args );
		$options = array();
		if ( count( $terms ) ) :
			foreach ( $terms as $term ) {
				$options = array(
					'value' => (int) $term->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * wolmart_wpb_shortcode_product_id_param_value
 *
 * get product id for wpb autocomplete
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_product_id_param_value' ) ) {
	function wolmart_wpb_shortcode_product_id_param_value( $current_value, $param_settings, $map_settings, $atts ) {
		if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
			$vc_vendor_wc = new Vc_Vendor_Woocommerce();
			return $vc_vendor_wc->productIdDefaultValue( $current_value, $param_settings, $map_settings, $atts );
		}
		return '';
	}
}

/**
 * wolmart_wpb_convert_responsive_values
 *
 * convert wpb responsive string values to valid array
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_convert_responsive_values' ) ) {
	function wolmart_wpb_convert_responsive_values( $key, $atts, $default = 'unset' ) {
		$res = array();

		if ( is_numeric( $default ) || 'unset' != $default ) {
			$res = array(
				$key . '_xl'     => $default,
				$key             => $default,
				$key . '_tablet' => $default,
				$key . '_mobile' => $default,
				$key . '_min'    => $default,
			);
		}

		if ( isset( $atts[ $key ] ) ) {
			$atts = json_decode( str_replace( '``', '"', $atts[ $key ] ), true );

			if ( isset( $atts['xl'] ) ) {
				$res[ $key . '_xl' ] = $atts['xl'];
			}
			if ( isset( $atts['lg'] ) ) {
				$res[ $key ] = $atts['lg'];
			} elseif ( isset( $res[ $key . '_xl' ] ) ) {
				$res[ $key ] = $res[ $key . '_xl' ];
			}
			if ( isset( $atts['md'] ) ) {
				$res[ $key . '_tablet' ] = $atts['md'];
			}
			if ( isset( $atts['sm'] ) ) {
				$res[ $key . '_mobile' ] = $atts['sm'];
			}
			if ( isset( $atts['xs'] ) ) {
				$res[ $key . '_min' ] = $atts['xs'];
			}
		}

		return $res;
	}
}
