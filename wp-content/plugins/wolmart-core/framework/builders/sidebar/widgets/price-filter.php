<?php

// direct load is not allowed
defined( 'ABSPATH' ) || die;

class Wolmart_Price_Filter_Sidebar_Widget extends WC_Widget {

	public function __construct() {
		$this->widget_cssclass    = 'widget-price-filter wolmart-price-filter';
		$this->widget_description = esc_html__( 'Display list of price to filter products.', 'wolmart-core' );
		$this->widget_id          = 'wolmart-price-filter';
		$this->widget_name        = esc_html__( 'Wolmart - Price Filter', 'wolmart-core' );
		$this->id_base            = 'wolmart-price-filter';

		parent::__construct();
	}

	function widget( $args, $instance ) {

		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		// If there are not posts and we're not filtering, hide the widget.
		if ( ! WC()->query->get_main_query()->post_count && ! isset( $_GET['min_price'] ) && ! isset( $_GET['max_price'] ) ) { // WPCS: input var ok, CSRF ok.
			return;
		}

		extract( $args ); // @codingStandardsIgnoreLine

		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		$output = '';
		echo $before_widget;

		if ( $title ) {
			echo $before_title . sanitize_text_field( $title ) . $after_title;
		}

		if ( ! $instance['range'] ) {
			$instance['range'] = '0-10, 10-50, 50-100, 100-500, 50000-';
		}

		$steps  = array();
		$ranges = explode( ',', trim( $instance['range'] ) );
		foreach ( $ranges as $range ) {
			$range_set = explode( '-', trim( $range ) );
			if ( 1 == count( $range_set ) ) {
				$steps[] = array( trim( $range_set[0] ) );
			} elseif ( 2 == count( $range_set ) ) {
				if ( trim( $range_set[1] ) ) {
					$steps[] = array( trim( $range_set[0] ), trim( $range_set[1] ) );
				} else {
					$steps[] = array( trim( $range_set[0] ) );
				}
			}
		}

		if ( empty( $steps ) ) {
			$prices = $this->get_filtered_price();
			if ( $prices->min_price < 1 ) {
				$min = 0;
			} else {
				$min_base = pow( 10, strlen( floor( $prices->min_price ) ) );
				$min      = ceil( $prices->min_price / $min_base ) * $min_base / 10;
			}
			if ( $prices->max_price < 1 ) {
				$max = 1;
			} else {
				$max_base = pow( 10, strlen( floor( $prices->max_price ) ) );
				$max      = ceil( $prices->max_price / $max_base ) * $max_base;
			}
			for ( $step = $min; $step < $max; $step = $step * 10 ) {
				$steps[] = array( $step, $step * 10 );
			}
		}

		$steps = apply_filters( 'wolmart_products_filter_price_range', $steps );

		echo '<div class="wolmart-price-range-wrapper">';
		echo '<ul class="wolmart-product-prices">';

		$cur_url = $this->get_current_page_url();

		if ( ! empty( $instance['show_all'] ) ) {
			$all_url = remove_query_arg( array( 'min_price', 'max_price' ), $cur_url );
			if ( $cur_url != $all_url ) {
				echo '<li class="' . ( $cur_url == $all_url ? 'chosen' : '' ) . '"><a href="' . wolmart_woo_widget_clean_link( $all_url ) . '">' . esc_html__( 'All', 'wolmart-core' ) . '</a></li>';
			}
		}
		foreach ( $steps as $step ) {
			$count = $this->get_products_count( $step[0], isset( $step[1] ) ? $step[1] : false );
			if ( ! (int) $count && empty( $instance['show_empty'] ) ) {
				continue;
			}
			if ( ! (int) $step[0] ) {
				// translators: Here "$price" is not text, is price value.
				$format_text_escaped = str_replace( '$price', wc_price( floatval( $step[1] ) ), empty( $instance['prefix'] ) ? esc_html__( 'Under $price', 'wolmart' ) : $instance['prefix'] );
			} elseif ( ! isset( $step[1] ) ) {
				$format_text_escaped = str_replace( '$price', wc_price( floatval( $step[0] ) ), empty( $instance['suffix'] ) ? '$price+' : $instance['suffix'] );
			} elseif ( ! empty( $instance['format'] ) ) {
				$format_text_escaped = str_replace( '$from', wc_price( floatval( $step[0] ) ), esc_html( $instance['format'] ) );
				$format_text_escaped = str_replace( '$to', ( isset( $step[1] ) ? wc_price( floatval( $step[1] ) ) : '' ), $format_text_escaped );
			} else {
				$format_text_escaped = wc_price( floatval( $step[0] ) ) . ' - ' . ( isset( $step[1] ) ? wc_price( floatval( $step[1] ) ) : '' );
			}
			$format_text_escaped = apply_filters( 'wolmart_products_filter_price_range_html', $format_text_escaped, $step );
			$link                = $cur_url;
			$cur_min_price       = isset( $_GET['min_price'] ) ? $_GET['min_price'] : '';
			$cur_max_price       = isset( $_GET['max_price'] ) ? $_GET['max_price'] : '';
			$step[0]             = isset( $step[0] ) ? $step[0] : '';
			$step[1]             = isset( $step[1] ) ? $step[1] : '';

			if ( ! ( $cur_min_price == $step[0] && $cur_max_price == $step[1] ) ) {
				if ( isset( $step[0] ) && $step[0] ) {
					$link = wolmart_add_url_parameters( $link, 'min_price', $step[0] );
				} else {
					$step[0] = '';
				}
				if ( isset( $step[1] ) && $step[1] ) {
					$link = wolmart_add_url_parameters( $link, 'max_price', $step[1] );
				} else {
					$step[1] = '';
				}
			}
			echo '<li' . ( $cur_min_price == $step[0] && $cur_max_price == $step[1] ? ' class="chosen"' : '' ) . '><a href="' . $link . '">' . $format_text_escaped . '</a>' . apply_filters( 'woocommerce_layered_nav_count', '<span class="count">(' . intval( $count ) . ')</span>' ) . '</li>';
		}
		echo '</ul>';

		// Custom range form

		global $wp;

		if ( '' === get_option( 'permalink_structure' ) ) {
			$form_action = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
		} else {
			$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
		}

		$cur_symbol = get_woocommerce_currency_symbol();

		echo '<form class="wolmart-price-range" action="' . esc_url( $form_action ) . '">';
			echo '<input type="number" name="min_price" class="min_price" placeholder="' . $cur_symbol . esc_html__( 'min', 'wolmart-core' ) . '" value="' . ( isset( $_REQUEST['min_price'] ) ? $_REQUEST['min_price'] : '' ) . '">';
			echo '<span class="delimiter"></span>';
			echo '<input type="number" name="max_price" class="max_price" placeholder="' . $cur_symbol . esc_html__( 'max', 'wolmart-core' ) . '" value="' . ( isset( $_REQUEST['max_price'] ) ? $_REQUEST['max_price'] : '' ) . '">';
			echo wc_query_string_form_fields( null, array( 'min_price', 'max_price', 'paged' ), '', true );
			echo '<button type="submit" class="button filter_price">' . esc_html__( 'Go', 'wolmart-core' ) . '</button>';
		echo '</form>';

		echo '</div>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']      = $new_instance['title'];
		$instance['range']      = $new_instance['range'];
		$instance['format']     = $new_instance['format'];
		$instance['prefix']     = $new_instance['prefix'];
		$instance['suffix']     = $new_instance['suffix'];
		$instance['show_empty'] = ! empty( $new_instance['show_empty'] ) ? 1 : 0;
		$instance['show_all']   = ! empty( $new_instance['show_all'] ) ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php esc_html_e( 'Title', 'wolmart-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'range' ); ?>">
				<strong><?php esc_html_e( 'Price Range', 'wolmart-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'range' ); ?>" name="<?php echo $this->get_field_name( 'range' ); ?>" value="<?php echo isset( $instance['range'] ) ? esc_attr( $instance['range'] ) : ''; ?>" placeholder="0-10, 10-50, 50-100, 100-500, 500-" />
				<small><?php esc_html_e( 'Comma separated price ranges.', 'wolmart-core' ); ?></small>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'format' ); ?>">
				<strong><?php esc_html_e( 'Price Range Format', 'wolmart-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'format' ); ?>" name="<?php echo $this->get_field_name( 'format' ); ?>" value="<?php echo isset( $instance['format'] ) ? esc_attr( $instance['format'] ) : ''; ?>" placeholder="$from - $to" />
				<small><?php esc_html_e( 'Input "$from" for first value and "$to" for last value.', 'wolmart-core' ); ?></small>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'prefix' ); ?>">
				<strong><?php esc_html_e( 'Min Price Range Format', 'wolmart-core' ); ?>:</strong>
				<?php // translators: Here "$price" is not text, is price value. ?>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'prefix' ); ?>" name="<?php echo $this->get_field_name( 'prefix' ); ?>" value="<?php echo isset( $instance['prefix'] ) ? esc_attr( $instance['prefix'] ) : ''; ?>" placeholder="<?php esc_html__( 'Under $price', 'wolmart-core' ); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'suffix' ); ?>">
				<strong><?php esc_html_e( 'Max Price Range Format', 'wolmart-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'suffix' ); ?>" name="<?php echo $this->get_field_name( 'suffix' ); ?>" value="<?php echo isset( $instance['suffix'] ) ? esc_attr( $instance['suffix'] ) : ''; ?>" placeholder="$price+" />
			</label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_all' ); ?>" name="<?php echo $this->get_field_name( 'show_all' ); ?>"<?php checked( isset( $instance['show_all'] ) && $instance['show_all'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_all' ); ?>"><?php esc_html_e( 'Show "All"', 'wolmart-core' ); ?></label></p>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_empty' ); ?>" name="<?php echo $this->get_field_name( 'show_empty' ); ?>"<?php checked( isset( $instance['show_empty'] ) && $instance['show_empty'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_empty' ); ?>"><?php esc_html_e( 'Show Empty Prices', 'wolmart-core' ); ?></label></p>
		</p>
		<?php
	}

	private function get_products_count( $min_price = 0, $max_price = false ) {
		global $wpdb;

		if ( $max_price ) {
			return $wpdb->get_var( $wpdb->prepare( "select count(distinct l.product_id) from {$wpdb->wc_product_meta_lookup} AS l INNER JOIN {$wpdb->posts} AS p on p.ID = l.product_id where p.post_type = 'product' and p.post_status = 'publish' and l.tax_class <> 'parent' AND l.min_price >= %f AND l.max_price <= %f", $min_price, $max_price ) );
		} else {
			return $wpdb->get_var( $wpdb->prepare( "select count(distinct l.product_id) from {$wpdb->wc_product_meta_lookup} AS l INNER JOIN {$wpdb->posts} AS p on p.ID = l.product_id where p.post_type = 'product' and p.post_status = 'publish' and l.tax_class <> 'parent' AND l.min_price >= %f", $min_price ) );
		}
	}

	private function get_filtered_price() {
		global $wpdb;

		if ( wc()->query->get_main_query() ) {
			$args = wc()->query->get_main_query()->query_vars;
		} else {
			$args = array();
		}
		$tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
		$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

		if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
			$tax_query[] = array(
				'taxonomy' => $args['taxonomy'],
				'terms'    => array( $args['term'] ),
				'field'    => 'slug',
			);
		}

		foreach ( $meta_query + $tax_query as $key => $query ) {
			if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
				unset( $meta_query[ $key ] );
			}
		}

		$meta_query = new WP_Meta_Query( $meta_query );
		$tax_query  = new WP_Tax_Query( $tax_query );

		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		$sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
		$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
		$sql .= "   WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
					AND {$wpdb->posts}.post_status = %s
					AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND price_meta.meta_value > '' ";
		$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

		if ( wc()->query->get_main_query() && $search = WC_Query::get_main_search_query_sql() ) { // @codingStandardsIgnoreLine
			$sql .= ' AND ' . $search;
		}

		return $wpdb->get_row( $wpdb->prepare( $sql, 'publish' ) ); // @codingStandardsIgnoreLine
	}
}
