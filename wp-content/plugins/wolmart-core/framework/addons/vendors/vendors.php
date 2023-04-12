<?php
/**
 * Wolmart Vendors class
 *
 * Available plugins are: Dokan, WCFM, WC Marketplace, WC Vendors
 *
 * @version 1.0
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Wolmart_Vendors' ) ) {
	/**
	 * Wolmart Vendors Class
	 *
	 * @since 1.0
	 */
	class Wolmart_Vendors extends Wolmart_Base {

		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'wp_ajax_wolmart_get_vendors', array( $this, 'get_vendors' ) );
			add_action( 'wp_ajax_nopriv_wolmart_get_vendors', array( $this, 'get_vendors' ) );

			if ( apply_filters( 'wolmart_resource_disable_dokan', function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'resource_disable_dokan' ) ) && ! is_user_logged_in() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'resource_disable_dokan' ), 99 );
			}

			if ( defined( 'DOKAN_PLUGIN_VERSION' ) ) {
				/**
				 * Compatibility with dokan plugin
				 */
				add_action( 'admin_enqueue_scripts', array( $this, 'deregister_dokan_chart' ), 30 );
			}
		}

		/**
		 * Deregister dokan chart
		 *
		 * Compatibility with dokan plugin
		 * - WordPress color picker doesn't work because of dokan chart.
		 * - Register dokan chart js only in dokan dashboard page
		 *
		 * @since 1.0
		 *
		 * @return array Top selling vendors
		 */
		public function deregister_dokan_chart() {
			if ( ( empty( $_GET['post'] ) || 'product' != get_post_type( $_GET['post'] ) ) && ( empty( $_GET['page'] ) || 'dokan' != $_GET['page'] ) ) {
				wp_deregister_script( 'dokan-chart' );
			}
		}


		/**
		 * Disable dokan resource in home page or shop pages.
		 *
		 * @since 1.0.0
		 */
		public function resource_disable_dokan() {

			if ( ! ( ( ! function_exists( 'dokan_is_seller_dashboard' ) || dokan_is_seller_dashboard() || ( get_query_var( 'edit' ) && is_singular( 'product' ) ) ) || apply_filters( 'dokan_forced_load_scripts', false ) ||
			! function_exists( 'dokan_is_store_page' ) || dokan_is_store_page() || dokan_is_store_review_page() || is_account_page() || is_product() || dokan_is_store_listing() ) ) {
				wp_dequeue_style( 'dokan-style' );
				wp_deregister_style( 'dokan-style' );
				wp_dequeue_style( 'dokan-fontawesome' );
				if ( is_rtl() ) {
					wp_dequeue_style( 'dokan-rtl-style' );
				}
			}

			// use theme's magnific popup instead of dokan's.
			wp_dequeue_script( 'dokan-popup' );
			wp_deregister_script( 'dokan-popup' );
		}

		/**
		 * Get top selling vendors
		 *
		 * @since 1.0
		 *
		 * @return array Top selling vendors
		 */
		public static function get_top_selling_vendors( $limit, $period ) {

			global  $wpdb;

			$cache_key = 'wolmart-best-seller-' . $limit;
			// $sellers   = wp_cache_get( $cache_key, 'wolmart-elementor-widget' );
			$sellers = false;
			$results = array();

            // phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
			if ( false == $sellers ) {
				if ( class_exists( 'WeDevs_Dokan' ) ) { // get best sellers using dokan vendor plugins
					$sellers = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT seller_id, total_sale 
                                FROM (
                                    SELECT seller_id, SUM(order_total) AS total_sale 
                                        FROM $wpdb->dokan_orders AS wdo 
										WHERE wdo.order_status = 'wc-completed'
										GROUP BY seller_id 
                                ) AS wpdo 
                            LEFT JOIN $wpdb->usermeta AS wum ON wpdo.seller_id = wum.user_id 
                            WHERE wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND wum.meta_value LIKE %s
                            ORDER BY total_sale DESC
                            LIMIT %d",
							'%seller%',
							$limit
						)
					);
				}

				if ( class_exists( 'WCFM' ) ) { // get best sellers using wcfm market place plugin
					$sellers = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT seller_id, total_sale
                                FROM (
                                    SELECT vendor_id AS seller_id, SUM(total_sales) AS total_sale
                                        FROM $wpdb->wcfm_marketplace_orders AS wcfmo
                                        LEFT JOIN {$wpdb->prefix}wc_order_stats ON wcfmo.order_id = {$wpdb->prefix}wc_order_stats.order_id
                                        WHERE {$wpdb->prefix}wc_order_stats.status = 'wc-completed' AND" . wolmart_query_time_range_filter( 'wp_posts', 'post_date', $period ) .
										" GROUP BY seller_id
                                ) AS wpfmo
                                LEFT JOIN $wpdb->usermeta AS wum ON wpfmo.seller_id = wum.user_id
                                WHERE wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND wum.meta_value LIKE %s
                                ORDER BY total_sale
                                LIMIT %d",
							'%wcfm_vendor%',
							$limit
						)
					);
				}

				if ( class_exists( 'WC_Vendors' ) ) { // get best sellers using wc vendor plugin
					$sellers = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT seller_id, total_sale
                                FROM (
                                    SELECT vendor_id AS seller_id, SUM(total_due) AS total_sale
                                        FROM {$wpdb->prefix}pv_commission AS wcvo
                                        LEFT JOIN {$wpdb->prefix}wc_order_stats ON wcvo.order_id = {$wpdb->prefix}wc_order_stats.order_id
                                        WHERE {$wpdb->prefix}wc_order_stats.status = 'wc-completed' AND" . wolmart_query_time_range_filter( $wpdb->prefix . 'wc_order_stats', 'date_created', $period ) .
										" GROUP BY seller_id
                                ) AS wcv
                                LEFT JOIN $wpdb->usermeta AS wum ON wcv.seller_id = wum.user_id
                                WHERE wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND wum.meta_value LIKE %s
                                ORDER BY total_sale DESC
                                LIMIT %d",
							'%vendor%',
							$limit
						)
					);
				}

				if ( defined( 'MVX_PLUGIN_VERSION' ) ) { // get best sellers using MVX plugin
					$sellers = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT seller_id, total_sale
                                FROM (
                                    SELECT vendor_id AS seller_id, order_id, SUM(net_total) AS total_sale
                                        FROM {$wpdb->prefix}mvx_vendor_orders AS mvxvo
                                        LEFT JOIN {$wpdb->prefix}wc_order_stats ON mvxvo.order_id = {$wpdb->prefix}wc_order_stats.order_id
                                        WHERE {$wpdb->prefix}wc_order_stats.status = 'wc-completed' AND" . wolmart_query_time_range_filter( $wpdb->prefix . 'wc_order_stats', 'date_created', $period ) .
										" GROUP BY seller_id
                                ) AS wcvo
                                LEFT JOIN $wpdb->usermeta AS wum ON wcvo.seller_id = wum.user_id
                                WHERE wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND wum.meta_value LIKE %s
                                ORDER BY total_sale
                                DESC LIMIT %d",
							'%dc-vendor%',
							$limit
						)
					);
				}

				if ( class_exists( 'WCMp' ) ) { // get best sellers using wc-marketplace vendor plugin
					$sellers = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT seller_id, total_sale
                                FROM (
                                    SELECT vendor_id AS seller_id, order_id, SUM(net_total) AS total_sale
                                        FROM {$wpdb->prefix}wcmp_vendor_orders AS wcmvo
                                        LEFT JOIN {$wpdb->prefix}wc_order_stats ON wcmvo.order_id = {$wpdb->prefix}wc_order_stats.order_id
                                        WHERE {$wpdb->prefix}wc_order_stats.status = 'wc-completed' AND" . wolmart_query_time_range_filter( $wpdb->prefix . 'wc_order_stats', 'date_created', $period ) .
										" GROUP BY seller_id
                                ) AS wcvo
                                LEFT JOIN $wpdb->usermeta AS wum ON wcvo.seller_id = wum.user_id
                                WHERE wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND wum.meta_value LIKE %s
                                ORDER BY total_sale
                                DESC LIMIT %d",
							'%dc-vendor%',
							$limit
						)
					);
				}

				wp_cache_set( $cache_key, $sellers, 'wolmart-elementor-widget', 3600 * 6 );
			}
            // phpcs:enable WordPress.DB.PreparedSQL.NotPrepared
			if ( is_array( $sellers ) && count( $sellers ) > 0 ) {
				foreach ( $sellers as $seller ) {
					$result    = array(
						'id'         => $seller->seller_id,
						'total_sale' => $seller->total_sale,
					);
					$results[] = $result;
				}
			}

			return apply_filters( 'wolmart_get_top_selling_vendors', $results );
		}

		/**
		 * Get top rating vendors
		 *
		 * @since 1.0
		 *
		 * @return array Top rating vendors
		 */
		public static function get_top_rating_vendors( $limit = 5 ) {
			global $wpdb;

			$cache_key = 'wolmart-top-rated-seller-' . $limit;
			$sellers   = wp_cache_get( $cache_key, 'wolmart-elementor-widget' );
			$results   = array();

			if ( false == $sellers ) {
				if ( class_exists( 'WeDevs_Dokan' ) ) {
					if ( class_exists( 'Dokan_Pro' ) ) {
						$sellers = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT 
                                    temp1.post_id,
                                    temp1.meta_value AS seller_id,
                                    AVG(temp2.meta_value) AS rating 
                                FROM
                                $wpdb->postmeta AS temp1 
                                INNER JOIN $wpdb->postmeta AS temp2
                                    ON temp1.post_id = temp2.post_id 
                                WHERE temp1.meta_key = 'store_id' 
                                    AND temp2.meta_key = 'rating' 
                                GROUP BY seller_id
                                ORDER BY rating DESC
                                LIMIT %d",
								$limit
							)
						);
					} else {
						$sellers = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT 
                                    p.ID,
                                    AVG(wcm.meta_value) AS rating,
                                    p.post_author AS seller_id
                                FROM
                                $wpdb->posts AS p
                                INNER JOIN $wpdb->comments AS wc
                                    ON p.ID = wc.comment_post_ID
                                LEFT JOIN $wpdb->commentmeta AS wcm
                                    ON wcm.comment_id = wc.comment_ID
                                LEFT JOIN $wpdb->usermeta AS wpu
                                    ON p.post_author = wpu.user_id
                                WHERE p.post_type = 'product'
                                AND	p.post_status = 'publish'
                                AND ( 
                                    wcm.meta_key = 'rating' 
                                    OR wcm.meta_key IS NULL
                                )
                                AND wc.comment_approved = 1
                                AND wpu.meta_value LIKE %s
                                GROUP BY p.post_author
                                ORDER BY rating DESC
                                LIMIT %d",
								'%seller%',
								$limit
							)
						);
					}
				}

				if ( class_exists( 'WCFM' ) ) {
					$sellers = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT 
                                user_id AS seller_id,
                                meta_value AS rating 
                            FROM
                            $wpdb->usermeta as wpu
                            WHERE wpu.meta_key = '_wcfmmp_avg_review_rating' 
                            GROUP BY seller_id
                            ORDER BY rating DESC
                            LIMIT %d",
							$limit
						)
					);
				}

				if ( defined( 'MVX_PLUGIN_VERSION' ) ) {
					$sellers = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT
                                templ.meta_value AS seller_id,
                                templ.comment_id,
                                $wpdb->commentmeta.meta_value AS rating 
                            FROM
                                $wpdb->commentmeta AS templ 
                            JOIN $wpdb->commentmeta ON templ.comment_id = $wpdb->commentmeta.comment_id 
                            WHERE templ.meta_key = 'vendor_rating_id' AND $wpdb->commentmeta.meta_key = 'vendor_rating'
                            GROUP BY seller_id
                            ORDER BY rating DESC
                            LIMIT %d",
							$limit
						)
					);
				}

				if ( class_exists( 'WCMp' ) ) {
					$sellers = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT
                                templ.meta_value AS seller_id,
                                templ.comment_id,
                                $wpdb->commentmeta.meta_value AS rating 
                            FROM
                                $wpdb->commentmeta AS templ 
                            JOIN $wpdb->commentmeta ON templ.comment_id = $wpdb->commentmeta.comment_id 
                            WHERE templ.meta_key = 'vendor_rating_id' AND $wpdb->commentmeta.meta_key = 'vendor_rating'
                            GROUP BY seller_id
                            ORDER BY rating DESC
                            LIMIT %d",
							$limit
						)
					);
				}

				if ( class_exists( 'WC_Vendors' ) ) {
					if ( class_exists( 'WCVendors_Pro_Ratings_Controller' ) ) {
						$sellers = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT
									vendor_id as seller_id,
									AVG(rating) AS rating
								FROM {$wpdb->prefix}wcv_feedback
								GROUP BY vendor_id
								ORDER BY rating DESC
								LIMIT %d",
								$limit
							)
						);
					} else {
						$sellers = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT 
                                    p.ID,
                                    AVG(wcm.meta_value) AS rating,
                                    p.post_author AS seller_id
                                FROM
                                $wpdb->posts AS p
                                INNER JOIN $wpdb->comments AS wc
                                    ON p.ID = wc.comment_post_ID
                                LEFT JOIN $wpdb->commentmeta AS wcm
                                    ON wcm.comment_id = wc.comment_ID
                                LEFT JOIN $wpdb->usermeta AS wpu
                                    ON p.`post_author` = wpu.`user_id`
                                WHERE p.post_type = 'product'
                                AND	p.post_status = 'publish'
                                AND ( 
                                    wcm.meta_key = 'rating' 
                                    OR wcm.meta_key IS NULL
                                )
                                AND wc.comment_approved = 1
                                AND wpu.`meta_value` LIKE %s
                                GROUP BY p.post_author
                                ORDER BY rating DESC
                                LIMIT %d",
								'%vendor%',
								$limit
							)
						);
					}
				}

				wp_cache_set( $cache_key, $sellers, 'wolmart-elementor-widget', 3600 * 6 );
			}

			if ( is_array( $sellers ) && count( $sellers ) > 0 ) {
				foreach ( $sellers as $seller ) {
					$result    = array(
						'id'     => $seller->seller_id,
						'rating' => $seller->rating,
					);
					$results[] = $result;
				}
			}

			return apply_filters( 'wolmart_get_top_rating_vendors', $results );
		}


		/**
		 * Get Vendors for ajax request
		 *
		 * @since 1.0
		 *
		 * @return string vendor_list_template
		 */
		public function get_vendors() {
			$vendors = wolmart_get_vendors();
		}
	}
}

/**
 * Create instance
 */
Wolmart_Vendors::get_instance();



////////////////////////////////////////////////////////////
////////     			Vendors Helper               ///////
////////////////////////////////////////////////////////////

/**
 * wolmart_query_time_range_filter
 *
 * Query helper function
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_query_time_range_filter' ) ) {
	function wolmart_query_time_range_filter( $table_handler, $time, $interval = 'all' ) {
		$sql = ' 1=1';
		switch ( $interval ) {
			case 'year':
				$sql .= " AND YEAR( {$table_handler}.{$time} ) = YEAR( CURDATE() )";
				break;

			case 'month':
				$sql .= " AND MONTH( {$table_handler}.{$time} ) = MONTH( NOW() )";
				break;
			case 'week':
				$sql .= " AND ( {$table_handler}.{$time} ) BETWEEN DATE_SUB( NOW(), INTERVAL 7 DAY ) AND NOW()";
				break;
			case 'default':
			case 'all':
				break;
		}

		return $sql;
	}
}


/**
 * wolmart_get_vendors
 *
 * Get all vendors
 *
 * @param array $args
 * @param string $orderby
 * @param integer $limit
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_get_vendors' ) ) {
	function wolmart_get_vendors( $args = array(), $orderby = 'registered', $limit = -1 ) {
		$query_args = array(
			'role'       => array( 'seller' ),
			'number'     => $limit,
			'offset'     => 0,
			'orderby'    => $orderby,
			'order'      => 'DESC',
			'status'     => 'approved',
			'featured'   => '', // yes or no
			'meta_query' => array(),
		);

		if ( class_exists( 'WeDevs_Dokan' ) ) {
			$query_args['role'] = array( 'seller' );
		} elseif ( class_exists( 'WCMp' ) ) {
			$query_args['role'] = array( 'dc_vendor' );
		} elseif ( class_exists( 'WCFMmp' ) ) {
			$query_args['role'] = array( 'wcfm_vendor' );
		} elseif ( class_exists( 'WC_Vendors' ) ) {
			$query_args['role'] = array( 'vendor' );
		} elseif ( defined( 'MVX_PLUGIN_VERSION' ) ) {
			$query_args['role'] = array( 'dc_vendor' );
		}

		$query_args = array_merge( $query_args, $args );
		$options    = array();
		$query      = new WP_User_Query( $query_args );
		$results    = $query->get_results();

		foreach ( $results as $result ) {
			if ( is_numeric( $result ) ) {
				$the_user = get_user_by( 'id', $result );

				if ( $the_user ) {
					$options[] = array(
						'id'   => $the_user->ID,
						'text' => $the_user->display_name,
					);
				}
			} elseif ( is_a( $result, 'WP_User' ) ) {
				$options[] = array(
					'id'   => $result->ID,
					'text' => $result->display_name,
				);
			}
		}

		return $options;
	}
}


/**
 * wolmart_get_vendor_total_sale
 *
 * Get total sale of vendors
 *
 * @param integer $vendor_id - required parameter
 * @param string $tbl_handler - required parameter
 * @param string $field_name - optional parameter
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_get_vendor_total_sale' ) ) {
	function wolmart_get_vendor_total_sale( $vendor_id, $tbl_handler, $field_name = 'vendor_id' ) {
		global $wpdb;

		$cache_key  = 'wolmart_vendor_total_sale_' . $vendor_id;
		$total_sale = wp_cache_get( $cache_key, 'wolmart-total-sale' );

		// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$total_sales = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT SUM(total_sales) AS total_sale
					FROM {$wpdb->prefix}{$tbl_handler} AS wpdo
					LEFT JOIN {$wpdb->prefix}wc_order_stats as wos ON wpdo.order_id = wos.order_id
					WHERE wpdo.{$field_name}=%d AND wos.status='wc-completed'",
				$vendor_id
			)
		);
		// phpcs:enable WordPress.DB.PreparedSQL.InterpolatedNotPrepared

		$total_sale = $total_sales ? $total_sales[0] : esc_html__( 'N/A', 'wolmart-core' );

		wp_cache_set( $cache_key, $total_sale, 'wolmart-elementor-widget', 3600 * 6 );
		wp_reset_postdata();

		return $total_sale;
	}
}



/**
 * wolmart_get_sellers
 *
 * Get Vendors
 *
 * @param integer $limit
 * @param string $orderby
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_get_sellers' ) ) {
	function wolmart_get_sellers( $limit = 5, $orderby = 'registered' ) {

		$results = array();

		$query_args = array(
			'role'       => array( 'seller' ),
			'number'     => $limit,
			'offset'     => 0,
			'orderby'    => $orderby,
			'order'      => 'DESC',
			'status'     => 'approved',
			'featured'   => '', // yes or no
			'meta_query' => array(),
		);

		if ( class_exists( 'WeDevs_Dokan' ) ) {
			$query_args['role'] = array( 'seller' );
		} elseif ( class_exists( 'WCMp' ) || defined( 'MVX_PLUGIN_VERSION' ) ) {
			$query_args['role'] = array( 'dc_vendor' );
		} elseif ( class_exists( 'WCFMmp' ) ) {
			$query_args['role'] = array( 'wcfm_vendor' );
		} elseif ( class_exists( 'WC_Vendors' ) ) {
			$query_args['role'] = array( 'vendor' );
		} 

		$query   = new WP_User_Query( $query_args );
		$sellers = $query->get_results();

		foreach ( $sellers as $seller ) {
			$result    = array(
				'id'   => $seller->ID,
				'text' => $seller->display_name,
			);
			$results[] = $result;
		}

		return apply_filters( 'wolmart_get_sellers', $results );
	}
}



/**
 * wolmart_get_dokan_vendor_info
 *
 * Get Dokan vendor information
 *
 * @param object $vendor
 * @return object $vendor
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_get_dokan_vendor_info' ) ) {
	function wolmart_get_dokan_vendor_info( $vendor ) {

		$store_info = dokan_get_store_info( $vendor['id'] );
		if ( $store_info ) {
			$vendor['store_name']     = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'wolmart-core' );
			$vendor['store_url']      = dokan_get_store_url( $vendor['id'] );
			$vendor_review            = dokan_get_seller_rating( $vendor['id'] );
			$vendor['rating']         = is_numeric( $vendor_review['rating'] ) ? $vendor_review['rating'] : 0;
			$vendor['products_count'] = count_user_posts( $vendor['id'], 'product' );
			$vendor['banner']         = ! empty( $store_info['banner'] ) ? absint( $store_info['banner'] ) : 0;

			if ( ! isset( $vendor['total_sale'] ) ) {
				$result = wolmart_get_vendor_total_sale( $vendor['id'], 'dokan_orders', 'seller_id' );
				if ( $result ) {
					$vendor['total_sale'] = is_numeric( $result->total_sale ) ? $result->total_sale : 0;
				}
			}
		} else {
			$vendor = false;
		}

		return apply_filters( 'wolmart_get_dokan_vendors', $vendor );
	}
}


/**
 * wolmart_get_wcfm_vendor_info
 *
 * Get WCFM vendor information
 *
 * @param object $vendor
 * @return object $vendor
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_get_wcfm_vendor_info' ) ) {
	function wolmart_get_wcfm_vendor_info( $vendor ) {

		// phpcs:disable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		global $WCFMmp;

		$store_user = class_exists( 'WCFMmp' ) ? wcfmmp_get_store( $vendor['id'] ) : false;

		if ( $store_user ) {
			$store_info               = wcfmmp_get_store_info( $vendor['id'] );
			$vendor['store_name']     = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'wolmart-core' );
			$vendor['store_url']      = wcfmmp_get_store_url( $vendor['id'] );

			if ( apply_filters( 'wcfm_is_pref_vendor_reviews', true ) && apply_filters( 'wcfm_is_allow_review_rating', true ) ) {
				$vendor_rating = $WCFMmp->wcfmmp_reviews->get_vendor_review_rating( $vendor['id'] );
			}

			$vendor['rating']         = $vendor_rating ? $vendor_rating : 0;
			$vendor['products_count'] = count_user_posts( $vendor['id'], 'product' );
			$vendor_data              = get_user_meta( $vendor['id'], 'wcfmmp_profile_settings', true );
			$vendor['banner']         = isset( $vendor_data['banner'] ) ? absint( $vendor_data['banner'] ) : 0;
			// $vendor['avatar_url']     = $store_user->get_avatar();
			$vendor['avatar_id'] = $store_user->get_info_part( 'gravatar' );
			// phpcs:enable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			if ( ! isset( $vendor['total_sale'] ) ) {
				$result = wolmart_get_vendor_total_sale( $vendor['id'], 'wcfm_marketplace_orders' );
				if ( $result ) {
					$vendor['total_sale'] = is_numeric( $result->total_sale ) ? $result->total_sale : 0;
				}
			}
		} else {
			$vendor = false;
		}

		return apply_filters( 'wolmart_get_wcfm_vendor_info', $vendor );
	}
}


/**
 * wolmart_get_wcmp_vendor_info
 *
 * Get WCMp vendor information
 *
 * @param object $vendor
 * @return object $vendor
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_get_wcmp_vendor_info' ) ) {
	function wolmart_get_wcmp_vendor_info( $vendor ) {
		// phpcs:disable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		global $MVX;

		$mvx_vendor = get_mvx_vendor( $vendor['id'] );

		if ( $mvx_vendor ) {
			$vendor['store_name']     = apply_filters( 'mvx_vendor_lists_single_button_text', $mvx_vendor->page_title );
			$vendor['store_url']      = $mvx_vendor->get_permalink();
			$rating_info              = mvx_get_vendor_review_info( $mvx_vendor->term_id );
			$vendor['rating']         = $rating_info['avg_rating'];
			$vendor_image             = get_user_meta( $vendor['id'], '_vendor_profile_image', true );
			$vendor['banner']         = get_user_meta( $vendor['id'], '_vendor_banner', true ) ? get_user_meta( $vendor['id'], '_vendor_banner', true ) : 0;
			$vendor['avatar_url']     = ( isset( $vendor_image ) && $vendor_image > 0 ) ? wp_get_attachment_url( $vendor_image ) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
			$vendor['products_count'] = count_user_posts( $vendor['id'], 'product' );
			// phpcs:enable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			if ( ! isset( $vendor['total_sale'] ) ) {
				$result = wolmart_get_vendor_total_sale( $vendor['id'], 'mvx_vendor_orders' );
				if ( $result ) {
					$vendor['total_sale'] = is_numeric( $result->total_sale ) ? $result->total_sale : 0;
				}
			}
		} else {
			$vendor = false;
		}

		return apply_filters( 'wolmart_get_mvx_vendor_info', $vendor );
	}
}

/**
 * wolmart_get_mvx_vendor_info
 *
 * Get WCMp vendor information
 *
 * @param object $vendor
 * @return object $vendor
 * @since 1.4.0
 */
if ( ! function_exists( 'wolmart_get_mvx_vendor_info' ) ) {
	function wolmart_get_mvx_vendor_info( $vendor ) {
		// phpcs:disable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		global $MVX;

		$mvx_vendor = get_mvx_vendor( $vendor['id'] );

		if ( $mvx_vendor ) {
			$vendor['store_name']     = apply_filters( 'mvx_vendor_lists_single_button_text', $mvx_vendor->page_title );
			$vendor['store_url']      = $mvx_vendor->get_permalink();
			$rating_info              = mvx_get_vendor_review_info( $mvx_vendor->term_id );
			$vendor['rating']         = $rating_info['avg_rating'];
			$vendor_image             = get_user_meta( $vendor['id'], '_vendor_profile_image', true );
			$vendor['banner']         = get_user_meta( $vendor['id'], '_vendor_banner', true ) ? get_user_meta( $vendor['id'], '_vendor_banner', true ) : 0;
			$vendor['avatar_url']     = ( isset( $vendor_image ) && $vendor_image > 0 ) ? wp_get_attachment_url( $vendor_image ) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
			$vendor['products_count'] = count_user_posts( $vendor['id'], 'product' );
			// phpcs:enable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			if ( ! isset( $vendor['total_sale'] ) ) {
				$result = wolmart_get_vendor_total_sale( $vendor['id'], 'mvx_vendor_orders' );
				if ( $result ) {
					$vendor['total_sale'] = is_numeric( $result->total_sale ) ? $result->total_sale : 0;
				}
			}
		} else {
			$vendor = false;
		}

		return apply_filters( 'wolmart_get_mvx_vendor_info', $vendor );
	}
}

/**
 * wolmart_get_wc_vendor_info
 *
 * Get WC Vendor info
 *
 * @param object $vendor
 * @return object $vendor
 * @since 1.0.0
 */
if ( ! function_exists( 'wolmart_get_wc_vendor_info' ) ) {
	function wolmart_get_wc_vendor_info( $vendor ) {
		global $wpdb;

		$vendor['store_name'] = get_user_meta( $vendor['id'], 'pv_shop_name', true );

		if ( $vendor['store_name'] ) {
			$vendor['store_url'] = WCV_Vendors::get_vendor_shop_page( $vendor['id'] );
			$vendor['banner']    = get_user_meta( $vendor['id'], '_wcv_store_banner_id', true );

			$rating = 0;
			if ( class_exists( 'WCVendors_Pro_Ratings_Controller' ) ) {
				$rating = $wpdb->get_var(
					$wpdb->prepare(
						"SELECT
						AVG(rating) as rating FROM {$wpdb->prefix}wcv_feedback
						WHERE vendor_id = %d ",
						$vendor['id']
					)
				);
			}
			$vendor['rating']         = $rating;
			$vendor['products_count'] = count_user_posts( $vendor['id'], 'product' );

			if ( ! isset( $vendor['total_sale'] ) ) {
				$result = wolmart_get_vendor_total_sale( $vendor['id'], 'pv_commission' );
				if ( $result ) {
					$vendor['total_sale'] = is_numeric( $result->total_sale ) ? $result->total_sale : 0;
				}
			}
		} else {
			$vendor = false;
		}

		return apply_filters( 'wolmart_get_wc_vendor_info', $vendor );
	}
}
