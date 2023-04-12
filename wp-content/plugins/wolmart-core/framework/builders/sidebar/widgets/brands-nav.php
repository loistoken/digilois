<?php

// direct load is not allowed
defined( 'ABSPATH' ) || die;

class Wolmart_Brands_Nav_Sidebar_Widget extends WC_Widget {

	public function __construct() {
		$this->widget_cssclass    = 'widget widget_product_brands woocommerce widget_layered_nav woocommerce-widget-layered-nav';
		$this->widget_description = esc_html__( 'A list or dropdown of product brands.', 'wolmart-core' );
		$this->widget_id          = 'wolmart_woo_product_brands';
		$this->widget_name        = esc_html__( 'Wolmart - Product Brands', 'wolmart-core' );
		$this->settings           = array(
			'title'   => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Product brands', 'wolmart-core' ),
				'label' => esc_html__( 'Title', 'wolmart-core' ),
			),
			'orderby' => array(
				'type'    => 'select',
				'std'     => 'name',
				'label'   => esc_html__( 'Order by', 'wolmart-core' ),
				'options' => array(
					'order' => esc_html__( 'Brand order', 'wolmart-core' ),
					'name'  => esc_html__( 'Name', 'wolmart-core' ),
				),
			),
		);

		parent::__construct();
	}

	function widget( $args, $instance ) {

		if ( ! function_exists( 'wolmart_is_shop' ) || ! wolmart_is_shop() ) {
			return;
		}

		global $wp_query, $post;

		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];

		$term_args = array(
			'hide_empty' => false,
		);

		if ( 'order' == $orderby ) {
			$term_args['menu_order'] = 'ASC';
		} else {
			$term_args['orderby']    = 'name';
			$term_args['menu_order'] = false;
		}

		$terms = get_terms( 'product_brand', $term_args );

		if ( is_wp_error( $terms ) ) {
			return;
		}

		if ( 0 === sizeof( $terms ) ) {
			return;
		}

		$this->widget_start( $args, $instance );

		$found = $this->layered_nav_list( $terms, 'product_brand' );

		$this->widget_end( $args );
	}

	protected function get_current_term_slug() {
		return absint( is_tax() ? get_queried_object()->slug : 0 );
	}

	protected function layered_nav_list( $terms, $taxonomy ) {

		echo '<ul class="woocommerce-widget-layered-nav-list">';

		$term_counts = wolmart_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), 'product_brand', 'or' );
		$found       = false;

		$current_term_object = get_queried_object();
		if ( $current_term_object && isset( $current_term_object->term_id ) && $taxonomy == $current_term_object->taxonomy ) {
			$current_term = $current_term_object->slug;
		}

		foreach ( $terms as $term ) {
			$count       = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;
			$filters     = ! empty( $_GET[ $taxonomy ] ) ? explode( ',', wc_clean( $_GET[ $taxonomy ] ) ) : array();
			$already_set = in_array( $term->slug, $filters );

			if ( isset( $current_term ) && $current_term && $current_term == $term->slug ) {
				$already_set = true;
			}

			if ( 0 < $count ) {
				$found = true;
			} elseif ( 0 === $count && ! $already_set ) {
				continue;
			}

			$filter_name = sanitize_title( $taxonomy );
			$filters     = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
			$filters     = array_map( 'sanitize_title', $filters );

			if ( ! in_array( $term->slug, $filters ) ) {
				$filters[] = $term->slug;
			}

			$link = $this->get_current_page_url_exclude_taxonomy( $taxonomy );

			foreach ( $filters as $key => $value ) {
				// Exclude if page is current term's archive
				if ( $value === $this->get_current_term_slug() ) {
					unset( $filters[ $key ] );
				}
				// Exclude if current term is filtered
				if ( $already_set && $value === $term->slug ) {
					unset( $filters[ $key ] );
				}
			}

			if ( ! empty( $filters ) ) {
				$link = add_query_arg( $filter_name, implode( ',', $filters ), $link );
			}

			if ( $count > 0 || $already_set ) {
				$link      = esc_url( apply_filters( 'woocommerce_layered_nav_link', $link, $term, $taxonomy ) );
				$term_html = '<a data-title="' . esc_html( $term->name ) . '" href="' . $link . '">' . esc_html( $term->name ) . '</a>';
			} else {
				$link      = false;
				$term_html = '<span data-title="' . esc_html( $term->name ) . '">' . esc_html( $term->name ) . '</span>';
			}

			$term_html .= ' ' . apply_filters( 'woocommerce_layered_nav_count', '<span class="count">(' . absint( $count ) . ')</span>', $count, $term );

			echo '<li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term ' . ( $already_set ? 'woocommerce-widget-layered-nav-list__item--chosen chosen' : '' ) . '">';
			echo $term_html;
			echo '</li>';
		}

		echo '</ul>';

		return $found;
	}

	/**
	 * Get current page URL with various filtering props supported by WC.
	 *
	 * @return string
	 * @since 1.0
	 */
	protected function get_current_page_url_exclude_taxonomy( $taxonomy ) {
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_shop() ) {
			$link = get_permalink( wc_get_page_id( 'shop' ) );
		} elseif ( is_product_category() ) {
			$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
		} elseif ( is_product_tag() ) {
			$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
		} else {
			$queried_object = get_queried_object();
			$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		}

		// Min/Max.
		if ( isset( $_GET['min_price'] ) ) {
			$link = add_query_arg( 'min_price', wc_clean( wp_unslash( $_GET['min_price'] ) ), $link );
		}

		if ( isset( $_GET['max_price'] ) ) {
			$link = add_query_arg( 'max_price', wc_clean( wp_unslash( $_GET['max_price'] ) ), $link );
		}

		// Order by.
		if ( isset( $_GET['orderby'] ) ) {
			$link = add_query_arg( 'orderby', wc_clean( wp_unslash( $_GET['orderby'] ) ), $link );
		}

		/**
		 * Search Arg.
		 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
		 */
		if ( get_search_query() ) {
			$link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
		}

		// Post Type Arg.
		if ( isset( $_GET['post_type'] ) ) {
			$link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );

			// Prevent post type and page id when pretty permalinks are disabled.
			if ( is_shop() ) {
				$link = remove_query_arg( 'page_id', $link );
			}
		}

		// Min Rating Arg.
		if ( isset( $_GET['rating_filter'] ) ) {
			$link = add_query_arg( 'rating_filter', wc_clean( wp_unslash( $_GET['rating_filter'] ) ), $link );
		}

		// All current filters.
		if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
			foreach ( $_chosen_attributes as $name => $data ) {
				if ( $name === $taxonomy ) {
					continue;
				}
				$filter_name = wc_attribute_taxonomy_slug( $name );
				if ( ! empty( $data['terms'] ) ) {
					$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
				}
				if ( 'or' === $data['query_type'] ) {
					$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
				}
			}
		}

		return apply_filters( 'woocommerce_widget_get_current_page_url', $link, $this );
	}
}
