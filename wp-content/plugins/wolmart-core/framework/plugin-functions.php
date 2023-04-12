<?php
/**
 * Define functions using in Wolmart Core Plugin
 */

if ( ! function_exists( 'wolmart_filtered_term_product_counts' ) ) :
	function wolmart_filtered_term_product_counts( $term_ids, $taxonomy = false, $query_type = false ) {
		global $wpdb;

		if ( ! class_exists( 'WC_Query' ) ) {
			return false;
		}

		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();

		if ( 'or' === $query_type ) {
			foreach ( $tax_query as $key => $query ) {
				if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
					unset( $tax_query[ $key ] );
				}
			}
		}

		if ( 'product_brand' === $taxonomy ) {
			foreach ( $tax_query as $key => $query ) {
				if ( is_array( $query ) ) {
					if ( $query['taxonomy'] === 'product_brand' ) {
						unset( $tax_query[ $key ] );

						if ( preg_match( '/pa_/', $query['taxonomy'] ) ) {
							unset( $tax_query[ $key ] );
						}
					}
				}
			}
		}

		$meta_query     = new WP_Meta_Query( $meta_query );
		$tax_query      = new WP_Tax_Query( $tax_query );
		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		// Generate query
		$query           = array();
		$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
		$query['from']   = "FROM {$wpdb->posts}";
		$query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )
			" . $tax_query_sql['join'] . $meta_query_sql['join'];

		$query['where'] = "
			WHERE {$wpdb->posts}.post_type IN ( 'product' )
			AND {$wpdb->posts}.post_status = 'publish'
			" . $tax_query_sql['where'] . $meta_query_sql['where'] . '
			AND terms.term_id IN (' . implode( ',', array_map( 'absint', $term_ids ) ) . ')
		';

		if ( $search = WC_Query::get_main_search_query_sql() ) {
			$query['where'] .= ' AND ' . $search;
		}

		$query['group_by'] = 'GROUP BY terms.term_id';
		$query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
		$query             = implode( ' ', $query );

		// We have a query - let's see if cached results of this query already exist.
		$query_hash = md5( $query );
		$cache      = apply_filters( 'woocommerce_layered_nav_count_maybe_cache', true );
		if ( true === $cache ) {
			$cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
		} else {
			$cached_counts = array();
		}

		if ( ! isset( $cached_counts[ $query_hash ] ) ) {
			$results                      = $wpdb->get_results( $query, ARRAY_A );
			$counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
			$cached_counts[ $query_hash ] = $counts;
			set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
		}

		return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
	}
endif;

/**
 * Remove filter callbacks
 *
 * @since 1.0.0
 */
function wolmart_clean_filter( $hook, $callback, $priority = 10 ) {
	remove_filter( $hook, $callback, $priority );
}

/**
 * Get the exact parameters of each predefined layouts.
 *
 * @param    int    $index    The index of predefined creative layouts
 */
function wolmart_creative_preset_imgs() {
	return apply_filters(
		'wolmart_creative_preset_imgs',
		array(
			1  => '/assets/images/creative-grid/creative-1.jpg',
			2  => '/assets/images/creative-grid/creative-2.jpg',
			3  => '/assets/images/creative-grid/creative-3.jpg',
			4  => '/assets/images/creative-grid/creative-4.jpg',
			5  => '/assets/images/creative-grid/creative-5.jpg',
			6  => '/assets/images/creative-grid/creative-6.jpg',
			7  => '/assets/images/creative-grid/creative-7.jpg',
			8  => '/assets/images/creative-grid/creative-8.jpg',
			9  => '/assets/images/creative-grid/creative-9.jpg',
			10 => '/assets/images/creative-grid/creative-10.jpg',
			11 => '/assets/images/creative-grid/creative-11.jpg',
			12 => '/assets/images/creative-grid/creative-12.jpg',
			13 => '/assets/images/creative-grid/creative-13.jpg',
		)
	);
}

function wolmart_creative_layout( $index ) {
	$layout = array();
	if ( 1 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'large',
			),
		);
	} elseif ( 2 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	} elseif ( 3 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 4 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'large',
			),
		);
	} elseif ( 5 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-4',
				'h'    => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 6 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	} elseif ( 7 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '2-3',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-s'  => '1',
				'w-l'  => '1-3',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-s'  => '1',
				'w-l'  => '1-3',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-s'  => '1',
				'w-l'  => '1-3',
				'size' => 'medium',
			),
		);
	} elseif ( 8 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '2-3',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '2-3',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-s'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 9 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '2-3',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '2-3',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 10 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	} elseif ( 11 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '5-12',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '1',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '5-12',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	} elseif ( 12 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '7-12',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '5-24',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '5-24',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '5-12',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '9-24',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '5-24',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 13 == (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	}

	return apply_filters( 'wolmart_creative_layout_filter', $layout );
}

function wolmart_creative_layout_style( $wrapper, $layout, $height = 600, $ratio = 75 ) {
	$hs    = array( 'h-1', 'h-1-2', 'h-1-3', 'h-2-3', 'h-1-4', 'h-3-4' );
	$deno  = array();
	$numer = array();
	$ws    = array(
		'w'   => array(),
		'w-l' => array(),
		'w-m' => array(),
		'w-s' => array(),
	);
	$hs    = array(
		'h'   => array(),
		'h-l' => array(),
		'h-m' => array(),
	);

	$breakpoints = wolmart_get_breakpoints();

	ob_start();
	echo '<style>';
	foreach ( $layout as $grid_item ) {
		foreach ( $grid_item as $key => $value ) {
			if ( 'size' == $key ) {
				continue;
			}

			$num = explode( '-', $value );
			if ( isset( $num[1] ) && ! in_array( $num[1], $deno ) ) {
				$deno[] = $num[1];
			}
			if ( ! in_array( $num[0], $numer ) ) {
				$numer[] = $num[0];
			}

			if ( ( 'w' == $key || 'w-l' == $key || 'w-m' == $key || 'w-s' == $key ) && ! in_array( $value, $ws[ $key ] ) ) {
					$ws[ $key ][] = $value;
			}
			if ( ( 'h' == $key || 'h-l' == $key || 'h-m' == $key ) && ! in_array( $value, $hs[ $key ] ) ) {
				$hs[ $key ][] = $value;
			}
		}
	}
	foreach ( $ws as $key => $value ) {
		if ( empty( $value ) ) {
			continue;
		}

		if ( 'w-l' == $key ) {
			echo '@media (max-width: ' . ( $breakpoints['lg'] - 1 ) . 'px) {';
		} elseif ( 'w-m' == $key ) {
			echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
		} elseif ( 'w-s' == $key ) {
			echo '@media (max-width: ' . ( $breakpoints['sm'] - 1 ) . 'px) {';
		}

		foreach ( $value as $item ) {
			$opts  = explode( '-', $item );
			$width = ( ! isset( $opts[1] ) ? 100 : round( 100 * $opts[0] / $opts[1], 4 ) );
			echo esc_attr( $wrapper ) . ' .grid-item.' . $key . '-' . $item . '{flex:0 0 ' . $width . '%;width:' . $width . '%}';
		}

		if ( 'w-l' == $key || 'w-m' == $key || 'w-s' == $key ) {
			echo '}';
		}
	};
	foreach ( $hs as $key => $value ) {
		if ( empty( $value ) ) {
			continue;
		}

		foreach ( $value as $item ) {
			$opts = explode( '-', $item );

			if ( isset( $opts[1] ) ) {
				$h = $height * $opts[0] / $opts[1];
			} else {
				$h = $height;
			}
			if ( 'h' == $key ) {
				echo esc_attr( $wrapper ) . ' .h-' . $item . '{height:' . round( $h, 2 ) . 'px}';
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-' . $item . '{height:' . round( $h * $ratio / 100, 2 ) . 'px}';
				echo '}';
			} elseif ( 'h-l' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['lg'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-l-' . $item . '{height:' . round( $h, 2 ) . 'px}';
				echo '}';
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-l-' . $item . '{height:' . round( $h * $ratio / 100, 2 ) . 'px}';
				echo '}';
			} elseif ( 'h-m' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-m-' . $item . '{height:' . round( $h * $ratio / 100, 2 ) . 'px}';
				echo '}';
			}
		}
	};
	$lcm = 1;
	foreach ( $deno as $value ) {
		$lcm = $lcm * $value / wolmart_get_gcd( $lcm, $value );
	}
	$gcd = $numer[0];
	foreach ( $numer as $value ) {
		$gcd = wolmart_get_gcd( $gcd, $value );
	}
	$sizer          = floor( 100 * $gcd / $lcm * 10000 ) / 10000;
	$space_selector = ' .grid>.grid-space';
	if ( false !== strpos( $wrapper, 'wpb_' ) ) {
		$space_selector = '>.grid-space';
	}
	echo esc_attr( $wrapper ) . $space_selector . '{flex: 0 0 ' . ( $sizer < 0.01 ? 100 : $sizer ) . '%;width:' . ( $sizer < 0.01 ? 100 : $sizer ) . '%}';
	echo '</style>';
	wolmart_filter_inline_css( ob_get_clean() );
}

function wolmart_display_grid_preset_imgs() {
	return array(
		1 => '/assets/images/products-grid/creative-1.jpg',
		2 => '/assets/images/products-grid/creative-2.jpg',
		3 => '/assets/images/products-grid/creative-3.jpg',
		4 => '/assets/images/products-grid/creative-4.jpg',
		5 => '/assets/images/products-grid/creative-5.jpg',
		6 => '/assets/images/products-grid/creative-6.jpg',
		7 => '/assets/images/products-grid/creative-7.jpg',
		8 => '/assets/images/products-grid/creative-8.jpg',
		9 => '/assets/images/products-grid/creative-9.jpg',
	);
}

function wolmart_get_creative_image_sizes( $mode, $idx ) {
	if ( 1 == $mode && 0 == $idx % 7 ) {
		return 'large';
	}
	if ( 2 == $mode && 1 == $idx % 5 ) {
		return 'large';
	}
	if ( 3 == $mode && 0 == $idx % 5 ) {
		return 'large';
	}
	if ( 4 == $mode && 2 == $idx % 5 ) {
		return 'large';
	}
	if ( 5 == $mode && ( 0 == $idx % 4 || 1 == $idx % 4 ) ) {
		return 'large';
	}
	if ( 6 == $mode && ( 0 == $idx % 4 || 2 == $idx % 4 ) ) {
		return 'large';
	}
	if ( 7 == $mode && ( 0 == $idx % 4 || 1 == $idx % 4 ) ) {
		return 'large';
	}
	if ( 8 == $mode && ( 0 == $idx % 4 || 1 == $idx % 4 ) ) {
		return 'large';
	}
	if ( 9 == $mode && 0 == $idx % 10 ) {
		return 'large';
	}
	return '';
}

function wolmart_get_gcd( $a, $b ) {
	while ( $b ) {
		$r = $a % $b;
		$a = $b;
		$b = $r;
	}
	return $a;
}


function wolmart_get_grid_space_class( $settings ) {

	$col_sp = $settings['col_sp'];

	if ( 'lg' == $col_sp || 'sm' == $col_sp || 'xs' == $col_sp || 'no' == $col_sp ) {
		return ' gutter-' . $col_sp;
	}

	return 'gutter-md';
}

/**
 * Check Units
 *
 */
if ( ! function_exists( 'wolmart_check_units' ) ) {
	function wolmart_check_units( $value ) {
		if ( ! preg_match( '/((^\d+(.\d+){0,1})|((-){0,1}.\d+))(px|%|em|rem|pt){0,1}$/', $value ) ) {
			if ( 'auto' == $value || 'inherit' == $value || 'initial' == $value || 'unset' == $value ) {
				return $value;
			}
			return false;
		} elseif ( is_numeric( $value ) ) {
			$value .= 'px';
		}
		return $value;
	}
}


add_filter(
	'wolmart_core_filter_doing_ajax',
	function() {
		// check ajax doing on others
		return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && mb_strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) ? true : false;
	}
);

add_action( 'wp_ajax_wolmart_load_creative_layout', 'wolmart_load_creative_layout' );
add_action( 'wp_ajax_nopriv_wolmart_load_creative_layout', 'wolmart_load_creative_layout' );
function wolmart_load_creative_layout() {
	// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

	$mode = isset( $_POST['mode'] ) ? $_POST['mode'] : 0;

	if ( $mode ) {
		echo json_encode( wolmart_creative_layout( $mode ) );
	} else {
		echo json_encode( array() );
	}

	exit();

	// phpcs:enable
}

/**
 * Is elementor page builder preview?
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_is_elementor_preview' ) ) {
	function wolmart_is_elementor_preview() {
		return defined( 'ELEMENTOR_VERSION' ) && (
				( isset( $_REQUEST['action'] ) && ( 'elementor' == $_REQUEST['action'] || 'elementor_ajax' == $_REQUEST['action'] ) ) ||
				isset( $_REQUEST['elementor-preview'] )
			);
	}
}

/**
 * Is visual composer page builder preview?
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_is_vc_preview' ) ) {
	function wolmart_is_vc_preview() {
		if ( ! defined( 'VCV_VERSION' ) || ! current_user_can( 'edit_posts' ) ) {
			return false;
		}
		if ( isset( $_REQUEST['vcv-action'] ) && 'frontend' == $_REQUEST['vcv-action'] ) {
			return true;
		}
		return false;
	}
}

/**
 * Is wpbakery page builder preview?
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_is_wpb_preview' ) ) {
	function wolmart_is_wpb_preview() {
		if ( defined( 'WPB_VC_VERSION' ) ) {
			if ( wolmart_is_wpb_backend() || vc_is_inline() ) {
				return true;
			}
		}
		return false;
	}
}


/**
 * Is page builder preview?
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_is_preview' ) ) {
	function wolmart_is_preview() {
		return wolmart_is_elementor_preview() || wolmart_is_vc_preview() || wolmart_is_wpb_preview();
	}
}

if ( ! function_exists( 'wolmart_is_wpb_backend' ) ) {
	function wolmart_is_wpb_backend() {
		if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && ( 'post.php' == $GLOBALS['pagenow'] || 'post-new.php' == $GLOBALS['pagenow'] ) && defined( 'WPB_VC_VERSION' ) ) {
			return true;
		}
		return false;
	}
}
if ( ! function_exists( 'wolmart_remove_all_admin_notices' ) ) {
	function wolmart_remove_all_admin_notices() {
		add_action(
			'network_admin_notices',
			function() {
				remove_all_actions( 'network_admin_notices' );
			},
			1
		);
		add_action(
			'user_admin_notices',
			function() {
				remove_all_actions( 'user_admin_notices' );
			},
			1
		);
		add_action(
			'admin_notices',
			function() {
				remove_all_actions( 'admin_notices' );
			},
			1
		);
		add_action(
			'all_admin_notices',
			function() {
				remove_all_actions( 'all_admin_notices' );
			},
			1
		);
	}
}

if ( ! function_exists( 'wolmart_get_grid_space' ) ) {

	/**
	 * Get columns' gutter size value from size string
	 *
	 * @since 1.0
	 *
	 * @param string $col_sp Columns gutter size string
	 *
	 * @return int Gutter size value
	 */
	function wolmart_get_grid_space( $col_sp ) {
		if ( 'no' == $col_sp ) {
			return 0;
		} elseif ( 'sm' == $col_sp ) {
			return 10;
		} elseif ( 'lg' == $col_sp ) {
			return 30;
		} elseif ( 'xs' == $col_sp ) {
			return 2;
		} else {
			return 20;
		}
	}
}

if ( ! function_exists( 'wolmart_get_image_sizes' ) ) {
	function wolmart_get_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array(
			esc_html__( 'Default', 'wolmart-core' ) => '',
			esc_html__( 'Full', 'wolmart-core' )    => 'full',
		);

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[ $_size . ' ( ' . get_option( "{$_size}_size_w" ) . 'x' . get_option( "{$_size}_size_h" ) . ( get_option( "{$_size}_crop" ) ? '' : ', false' ) . ' )' ] = $_size;
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size . ' ( ' . $_wp_additional_image_sizes[ $_size ]['width'] . 'x' . $_wp_additional_image_sizes[ $_size ]['height'] . ( $_wp_additional_image_sizes[ $_size ]['crop'] ? '' : ', false' ) . ' )' ] = $_size;
			}
		}
		return $sizes;
	}
}

/*******************************************
 ********* Render Core Functions ***********
 *******************************************/
/**
 * Get button widget class
 */
function wolmart_widget_button_get_class( $settings ) {
	$class = array();
	if ( isset( $settings['button_type'] ) && $settings['button_type'] ) {
		$class[] = $settings['button_type'];
	}
	if ( isset( $settings['link_hover_type'] ) && $settings['link_hover_type'] ) {
		$class[] = $settings['link_hover_type'];
	}
	if ( isset( $settings['button_size'] ) && $settings['button_size'] ) {
		$class[] = $settings['button_size'];
	}
	if ( isset( $settings['shadow'] ) && $settings['shadow'] ) {
		$class[] = $settings['shadow'];
	}
	if ( isset( $settings['button_border'] ) && $settings['button_border'] ) {
		$class[] = $settings['button_border'];
	}
	if ( isset( $settings['button_skin'] ) && $settings['button_skin'] ) {
		$class[] = $settings['button_skin'];
	}
	if ( ! empty( $settings['btn_class'] ) ) {
		$class[] = $settings['btn_class'];
	}
	if ( isset( $settings['icon_hover_effect_infinite'] ) && 'yes' == $settings['icon_hover_effect_infinite'] ) {
		$class[] = 'btn-infinite';
	}

	if ( isset( $settings['icon'] ) && is_array( $settings['icon'] ) && $settings['icon']['value'] ) {
		if ( isset( $settings['show_label'] ) && ! $settings['show_label'] ) {
			$class[] = 'btn-icon';
		} elseif ( 'before' == $settings['icon_pos'] ) {
			$class[] = 'btn-icon-left';
		} else {
			$class[] = 'btn-icon-right';
		}
		if ( isset( $settings['icon_hover_effect'] ) && $settings['icon_hover_effect'] ) {
			$class[] = $settings['icon_hover_effect'];
		}
	}
	return $class;
}

/**
 * Get button widget label
 */
function wolmart_widget_button_get_label( $settings, $self, $label, $inline_key = '' ) {
	if ( $self && ( ! isset( $self::$is_wpb ) || ! $self::$is_wpb ) && wolmart_is_elementor_preview() ) {
		$label = sprintf( '<span %1$s>%2$s</span>', $inline_key ? $self->get_render_attribute_string( $inline_key ) : '', $label );
	}

	if ( isset( $settings['icon'] ) && is_array( $settings['icon'] ) && $settings['icon']['value'] ) {
		if ( isset( $settings['show_label'] ) && 'yes' != $settings['show_label'] ) {
			$label = '<i class="' . $settings['icon']['value'] . '"></i>';
		} elseif ( 'before' == $settings['icon_pos'] ) {
			$label = '<i class="' . $settings['icon']['value'] . '"></i>' . $label;
		} else {
			$label .= '<i class="' . $settings['icon']['value'] . '"></i>';
		}
	}
	return $label;
}

function wolmart_elementor_loadmore_render_html( $query, $atts ) {

	if ( $query->max_num_pages > 1 ) {

		if ( 'button' == $atts['loadmore_type'] ) {

			echo '<button class="btn btn-load btn-primary">';
			echo empty( $atts['loadmore_label'] ) ? esc_html__( 'Load More', 'wolmart-core' ) : esc_html( $atts['loadmore_label'] );
			echo '</button>';

		} elseif ( 'page' == $atts['loadmore_type'] || '' == $atts['loadmore_type'] ) {
			echo wolmart_get_pagination( $query, 'pagination-load' );
		}
	}
}

function wolmart_elementor_grid_col_cnt( $settings ) {

	$col_cnt = array(
		'xl'  => isset( $settings['col_cnt_xl'] ) ? (int) $settings['col_cnt_xl'] : 0,
		'lg'  => isset( $settings['col_cnt'] ) ? (int) $settings['col_cnt'] : 0,
		'md'  => isset( $settings['col_cnt_tablet'] ) ? (int) $settings['col_cnt_tablet'] : 0,
		'sm'  => isset( $settings['col_cnt_mobile'] ) ? (int) $settings['col_cnt_mobile'] : 0,
		'min' => isset( $settings['col_cnt_min'] ) ? (int) $settings['col_cnt_min'] : 0,
	);

	return function_exists( 'wolmart_get_responsive_cols' ) ? wolmart_get_responsive_cols( $col_cnt ) : $col_cnt;
}

function wolmart_get_post_id_by_name( $post_type, $name ) {
	global $wpdb;
	return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_name = %s", $post_type, $name ) );
}

function wolmart_wc_product_dropdown_brands( $args = array() ) {
	global $wp_query;

	$args = wp_parse_args(
		$args,
		array(
			'pad_counts'         => 1,
			'show_count'         => 1,
			'hierarchical'       => 1,
			'hide_empty'         => 1,
			'show_uncategorized' => 1,
			'orderby'            => 'name',
			'selected'           => isset( $wp_query->query_vars['product_brand'] ) ? $wp_query->query_vars['product_brand'] : '',
			'show_option_none'   => __( 'Select a category', 'woocommerce' ),
			'option_none_value'  => '',
			'value_field'        => 'slug',
			'taxonomy'           => 'product_brand',
			'name'               => 'product_brand',
			'class'              => 'dropdown_product_brand',
		)
	);

	if ( 'order' === $args['orderby'] ) {
		$args['orderby']  = 'meta_value_num';
		$args['meta_key'] = 'order'; // phpcs:ignore
	}

	wp_dropdown_categories( $args );
}

function wolmart_breadcrumb_args( $args ) {
	global $wolmart_breadcrumb;

	$extra_class = '';

	if ( isset( $wolmart_breadcrumb['delimiter_icon'] ) && ! is_array( $wolmart_breadcrumb['delimiter_icon'] ) ) {
		$wolmart_breadcrumb['delimiter_icon'] = json_decode( $wolmart_breadcrumb['delimiter_icon'], true );
	}
	if ( isset( $wolmart_breadcrumb['delimiter_icon'] ) && is_array( $wolmart_breadcrumb['delimiter_icon'] ) && $wolmart_breadcrumb['delimiter_icon']['value'] ) {
		$delimiter = '<i class="' . esc_attr( $wolmart_breadcrumb['delimiter_icon']['value'] ) . '"></i>';
	} elseif ( ! empty( $wolmart_breadcrumb['delimiter'] ) ) {
		$delimiter = wolmart_strip_script_tags( $wolmart_breadcrumb['delimiter'] );
	} else {
		$delimiter = '/';
	}
	if ( 'yes' == $wolmart_breadcrumb['home_icon'] ) {
		$args['home'] = '<i class="w-icon-home"></i>';
		$extra_class .= ' home-icon';
	}

	$args['delimiter']   = '<li class="delimiter">' . $delimiter . '</li>';
	$args['wrap_before'] = '<ul class="breadcrumb' . $extra_class . '">';
	$args['wrap_after']  = '</ul>';
	$args['before']      = '<li>';
	$args['after']       = '</li>';

	remove_filter( 'woocommerce_breadcrumb_defaults', 'wolmart_elementor_breadcrumb_args' );
	if ( function_exists( 'wolmart_wc_breadcrumb_args' ) ) {
		add_filter( 'woocommerce_breadcrumb_defaults', 'wolmart_wc_breadcrumb_args' );
	}

	unset( $wolmart_breadcrumb );
	return apply_filters( 'wolmart_breadcrumb_args', $args );
}


if ( ! function_exists( 'wolmart_get_animations' ) ) {
	function wolmart_get_animations( $type = '' ) {
		$animations_in = array(
			'none'               => esc_html__( 'Default Animation', 'wolmart-core' ),
			'bounce'             => esc_html__( 'Bounce', 'wolmart-core' ),
			'flash'              => esc_html__( 'Flash', 'wolmart-core' ),
			'pulse'              => esc_html__( 'Pulse', 'wolmart-core' ),
			'rubberBand'         => esc_html__( 'RubberBand', 'wolmart-core' ),
			'shake'              => esc_html__( 'Shake', 'wolmart-core' ),
			'headShake'          => esc_html__( 'HeadShake', 'wolmart-core' ),
			'swing'              => esc_html__( 'Swing', 'wolmart-core' ),
			'tada'               => esc_html__( 'Tada', 'wolmart-core' ),
			'wobble'             => esc_html__( 'Wobble', 'wolmart-core' ),
			'jello'              => esc_html__( 'Jello', 'wolmart-core' ),
			'heartBeat'          => esc_html__( 'HearBeat', 'wolmart-core' ),
			'blurIn'             => esc_html__( 'BlurIn', 'wolmart-core' ),
			'bounceIn'           => esc_html__( 'BounceIn', 'wolmart-core' ),
			'bounceInUp'         => esc_html__( 'BounceInUp', 'wolmart-core' ),
			'bounceInDown'       => esc_html__( 'BounceInDown', 'wolmart-core' ),
			'bounceInLeft'       => esc_html__( 'BounceInLeft', 'wolmart-core' ),
			'bounceInRight'      => esc_html__( 'BounceInRight', 'wolmart-core' ),
			'fadeIn'             => esc_html__( 'FadeIn', 'wolmart-core' ),
			'fadeInUp'           => esc_html__( 'FadeInUp', 'wolmart-core' ),
			'fadeInUpBig'        => esc_html__( 'FadeInUpBig', 'wolmart-core' ),
			'fadeInUpShorter'    => esc_html__( 'FadeInUpShort', 'wolmart-core' ),
			'fadeInDown'         => esc_html__( 'FadeInDown', 'wolmart-core' ),
			'fadeInDownBig'      => esc_html__( 'FadeInDownBig', 'wolmart-core' ),
			'fadeInDownShorter'  => esc_html__( 'FadeInDownShort', 'wolmart-core' ),
			'fadeInLeft'         => esc_html__( 'FadeInLeft', 'wolmart-core' ),
			'fadeInLeftBig'      => esc_html__( 'FadeInLeftBig', 'wolmart-core' ),
			'fadeInLeftShorter'  => esc_html__( 'FadeInLeftShort', 'wolmart-core' ),
			'fadeInRight'        => esc_html__( 'FadeInRight', 'wolmart-core' ),
			'fadeInRightBig'     => esc_html__( 'FadeInRightBig', 'wolmart-core' ),
			'fadeInRightShorter' => esc_html__( 'FadeInRightShort', 'wolmart-core' ),
			'flip'               => esc_html__( 'Flip', 'wolmart-core' ),
			'flipInX'            => esc_html__( 'FlipInX', 'wolmart-core' ),
			'flipInY'            => esc_html__( 'FlipInY', 'wolmart-core' ),
			'lightSpeedIn'       => esc_html__( 'LightSpeedIn', 'wolmart-core' ),
			'rotateIn'           => esc_html__( 'RotateIn', 'wolmart-core' ),
			'rotateInUpLeft'     => esc_html__( 'RotateInUpLeft', 'wolmart-core' ),
			'rotateInUpRight'    => esc_html__( 'RotateInUpRight', 'wolmart-core' ),
			'rotateInDownLeft'   => esc_html__( 'RotateInDownLeft', 'wolmart-core' ),
			'rotateInDownRight'  => esc_html__( 'RotateInDownRight', 'wolmart-core' ),
			'hinge'              => esc_html__( 'Hinge', 'wolmart-core' ),
			'jackInTheBox'       => esc_html__( 'JackInTheBox', 'wolmart-core' ),
			'rollIn'             => esc_html__( 'RollIn', 'wolmart-core' ),
			'zoomIn'             => esc_html__( 'ZoomIn', 'wolmart-core' ),
			'zoomInUp'           => esc_html__( 'ZoomInUp', 'wolmart-core' ),
			'zoomInDown'         => esc_html__( 'ZoomInDown', 'wolmart-core' ),
			'zoomInLeft'         => esc_html__( 'ZoomInLeft', 'wolmart-core' ),
			'zoomInRight'        => esc_html__( 'ZoomInRight', 'wolmart-core' ),
			'slideInUp'          => esc_html__( 'SlideInUp', 'wolmart-core' ),
			'slideInDown'        => esc_html__( 'SlideInDown', 'wolmart-core' ),
			'slideInLeft'        => esc_html__( 'SlideInLeft', 'wolmart-core' ),
			'slideInRight'       => esc_html__( 'SlideInRight', 'wolmart-core' ),
			'blurIn'             => esc_html__( 'BlurIn', 'wolmart-core' ),
		);

		$animations_out = array(
			'default'            => esc_html__( 'Default Animation', 'wolmart-core' ),
			'blurOut'            => esc_html__( 'BlurOut', 'wolmart-core' ),
			'bounceOut'          => esc_html__( 'BounceOut', 'wolmart-core' ),
			'bounceOutUp'        => esc_html__( 'BounceOutUp', 'wolmart-core' ),
			'bounceOutDown'      => esc_html__( 'BounceOutDown', 'wolmart-core' ),
			'bounceOutLeft'      => esc_html__( 'BounceOutLeft', 'wolmart-core' ),
			'bounceOutRight'     => esc_html__( 'BounceOutRight', 'wolmart-core' ),
			'fadeOut'            => esc_html__( 'FadeOut', 'wolmart-core' ),
			'fadeOutUp'          => esc_html__( 'FadeOutUp', 'wolmart-core' ),
			'fadeOutUpBig'       => esc_html__( 'FadeOutUpBig', 'wolmart-core' ),
			'fadeOutDown'        => esc_html__( 'FadeOutDown', 'wolmart-core' ),
			'fadeOutDownBig'     => esc_html__( 'FadeOutDownBig', 'wolmart-core' ),
			'fadeOutLeft'        => esc_html__( 'FadeOutLeft', 'wolmart-core' ),
			'fadeOutLeftBig'     => esc_html__( 'FadeOutLeftBig', 'wolmart-core' ),
			'fadeOutRight'       => esc_html__( 'FadeOutRight', 'wolmart-core' ),
			'fadeOutRightBig'    => esc_html__( 'FadeOutRightBig', 'wolmart-core' ),
			'flipOutX'           => esc_html__( 'FlipOutX', 'wolmart-core' ),
			'flipOutY'           => esc_html__( 'FlipOutY', 'wolmart-core' ),
			'lightSpeedOut'      => esc_html__( 'LightSpeedOut', 'wolmart-core' ),
			'rotateOutUpLeft'    => esc_html__( 'RotateOutUpLeft', 'wolmart-core' ),
			'rotateOutRight'     => esc_html__( 'RotateOutUpRight', 'wolmart-core' ),
			'rotateOutDownLeft'  => esc_html__( 'RotateOutDownLeft', 'wolmart-core' ),
			'rotateOutDownRight' => esc_html__( 'RotateOutDownRight', 'wolmart-core' ),
			'rollOut'            => esc_html__( 'RollOut', 'wolmart-core' ),
			'zoomOut'            => esc_html__( 'ZoomOut', 'wolmart-core' ),
			'zoomOutUp'          => esc_html__( 'ZoomOutUp', 'wolmart-core' ),
			'zoomOutDown'        => esc_html__( 'ZoomOutDown', 'wolmart-core' ),
			'zoomOutLeft'        => esc_html__( 'ZoomOutLeft', 'wolmart-core' ),
			'zoomOutRight'       => esc_html__( 'ZoomOutRight', 'wolmart-core' ),
			'slideOutUp'         => esc_html__( 'SlideOutUp', 'wolmart-core' ),
			'slideOutDown'       => esc_html__( 'SlideOutDown', 'wolmart-core' ),
			'slideOutLeft'       => esc_html__( 'SlideOutLeft', 'wolmart-core' ),
			'slideOutRight'      => esc_html__( 'SlideOutRight', 'wolmart-core' ),
		);

		$animations_appear = array(
			'Wolmart Fading' => array(
				'fadeInDownShorter'  => esc_html__( 'Fade In Down Shorter', 'wolmart-core' ),
				'fadeInLeftShorter'  => esc_html__( 'Fade In Left Shorter', 'wolmart-core' ),
				'fadeInRightShorter' => esc_html__( 'Fade In Right Shorter', 'wolmart-core' ),
				'fadeInUpShorter'    => esc_html__( 'Fade In Up Shorter', 'wolmart-core' ),
			),
			'Blur'           => array(
				'blurIn' => esc_html__( 'BlurIn', 'wolmart-core' ),
			),
		);

		if ( 'appear' == $type ) {
			return $animations_appear;
		} elseif ( 'in' == $type ) {
			return $animations_in;
		} elseif ( 'out' == $type ) {
			return $animations_out;
		}

		return array(
			'sliderIn'  => $animations_in,
			'sliderOut' => $animations_out,
			'appear'    => $animations_appear,
		);
	}
}


/**
 * Compile WPBakery Shortcodes
 *
 * @param array $wpb_shortcodes_to_remove
 *
 * @return void
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_wpb_shortcode_compile_css ' ) ) {
	function wolmart_wpb_shortcode_compile_css( $wpb_shortcodes_to_remove ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$style_path = wp_upload_dir()['basedir'] . '/wolmart_styles';
		if ( ! file_exists( $style_path ) ) {
			wp_mkdir_p( $style_path );
		}

		// Initialize the WordPress filesystem, no more using file_put_contents function
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		$is_success = false;

		ob_start();
		include WOLMART_CORE_PLUGINS . '/wpb/less/front.less.php';
		$_config_css = ob_get_clean();

		// compile visual composer css file
		if ( ! class_exists( 'lessc' ) ) {
			require_once WOLMART_CORE_PLUGINS . '/wpb/less/lessphp/lessc.inc.php';
		}
		ob_start();
		$less = new lessc();
		$less->setFormatter( 'compressed' );
		try {
			$less->setImportDir( ABSPATH . 'wp-content/plugins/js_composer/assets/less/lib' );
			echo '' . $less->compile( '@import "../config/variables.less";' . $_config_css );
			$_config_css = ob_get_clean();

			$filename = $style_path . '/js_composer.css';
			wolmart_check_file_write_permission( $filename );

			$wp_filesystem->put_contents( $filename, $_config_css, FS_CHMOD_FILE );
		} catch ( Exception $e ) {
		}
	}
}
