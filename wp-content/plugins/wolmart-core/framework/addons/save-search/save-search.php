<?php
/**
 * Wolmart Save Search Addon
 *
 * @author     D-THEMES
 * @package    Wolmart Core Framework
 * @subpackage Core
 * @version    1.0
 * @since      1.2.0
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Wolmart_Save_Search' ) ) {
	class Wolmart_Save_Search extends Wolmart_Base {

		public $table_name = '';

		/**
		 * Constructor
		 *
		 * @since 1.2.0
		 */
		public function __construct() {
			global $wpdb;
			add_filter( 'wolmart_customize_fields', array( $this, 'add_customize_fields' ) );
			if ( function_exists( 'wolmart_set_default_option' ) ) {
				wolmart_set_default_option( 'save_search', true );
			}

			$this->table_name = $wpdb->prefix . 'wolmart_search_log';

			// Create tables in database
			if ( function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'save_search' ) ) {
				$this->create_data_tables();
				add_action( 'template_redirect', array( $this, 'save_keyword' ) );
				add_filter( 'wolmart_get_most_used_search_keys', array( $this, 'get_keywords' ) );
			} else {
				$this->drop_data_tables();
			}
		}


		/**
		 * Add customize fields
		 *
		 * @since 1.2.0
		 */
		public function add_customize_fields( $fields ) {
			$fields['save_search'] = array(
				'section' => 'search',
				'type'    => 'toggle',
				'tooltip' => esc_html__( 'You can save search keyword using this feature whenever user searches something. This option must be enabed when you are going to display popular search keywords in elementor search widget.', 'wolmart-core' ),
				'label'   => esc_html__( 'Show popular search keywords.', 'wolmart-core' ),
			);
			return $fields;
		}


		/**
		 * Create tables in database
		 *
		 * @since 1.2.0
		 */
		public function create_data_tables() {
			global $wpdb;

			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE IF NOT EXISTS $this->table_name (
			    id bigint(9) NOT NULL AUTO_INCREMENT,
			    keyword varchar(200) NOT NULL,
			    time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			    user_id bigint(20) NOT NULL DEFAULT '0',
			    ip varchar(40) NOT NULL DEFAULT '',
			    PRIMARY KEY id (id)
            ) $charset_collate;";

			$wpdb->query( $sql ); // phpcs:ignore PHPCS(WordPress.DB.PreparedSQL.NotPrepared)
		}


		/**
		 * Drop tables in database
		 *
		 * @since 1.2.0
		 */
		public function drop_data_tables() {
			global $wpdb;

			$wpdb->query( "DROP TABLE IF EXISTS $this->table_name;" );
		}


		/**
		 * Save keyword in database
		 *
		 * @since 1.2.0
		 */
		public function save_keyword() {

			if ( is_search() ) {

				if ( isset( $_GET['s'] ) ) {
					$query = $_GET['s'];
				}

				$user_agent = '';
				if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
					$user_agent = $_SERVER['HTTP_USER_AGENT'];
					$bots       = array(
						'Google 1'   => 'Mediapartners-Google',
						'Google 2'   => 'Googlebot',
						'Bing'       => 'Bingbot',
						'Yahoo'      => 'Slurp',
						'DuckDuckGo' => 'DuckDuckBot',
						'Baidu'      => 'Baiduspider',
						'Yandex'     => 'YandexBot',
						'Sogou'      => 'Sogou',
						'Exalead'    => 'Exabot',
					);

					/**
					 * Filters the bots Wolmart should block from logs.
					 *
					 * Lets you filter the bots that are blocked from Wolmart search logs.
					 *
					 * @param array $bots An array of bot user agents.
					 */
					$bots = apply_filters( 'wolmart_bots_to_not_log', $bots );
					foreach ( array_values( $bots ) as $lookfor ) {
						if ( false !== stristr( $user_agent, $lookfor ) ) {
							return false;
						}
					}
				}

				/**
				 * Filters the current user for logs.
				 *
				 * The current user is checked before logging a query to omit particular users.
				 * You can use this filter to filter out the user.
				 *
				 * @param object The current user object.
				 */
				$user = apply_filters( 'wolmart_log_get_user', wp_get_current_user() );

				/**
				 * Filters the IP address of the searcher.
				 *
				 * Wolmart may store the IP address of the searches in the logs.
				 *
				 * Do note that storing the IP address may be illegal or get you in GDPR
				 * trouble.
				 *
				 * @param string $ip The IP address, from $_SERVER['REMOTE_ADDR'].
				 */
				$ip = apply_filters( 'wolmart_remote_addr', $_SERVER['REMOTE_ADDR'] );

				/**
				 * Filters whether a query should be logged or not.
				 *
				 * This filter can used to determine whether a query should be logged or not.
				 *
				 * @param boolean $enable_log  Can the query be logged.
				 * @param string  $query      The actual query string.
				 * @param int     $hits       The number of hits found.
				 * @param string  $user_agent The user agent that made the search.
				 * @param string  $ip         The IP address the search came from (or empty).
				 */
				$enable_log = apply_filters( 'wolmart_enable_log', true, $query, $user_agent, $ip );
				if ( $enable_log ) {
					global $wpdb;

					$wpdb->query(
						$wpdb->prepare(
							'INSERT INTO ' . $this->table_name . ' (keyword, user_id, ip, time) VALUES (%s, %d, %s, NOW())', // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,WordPress.DB.PreparedSQL.InterpolatedNotPrepared
							$query,
							$user->ID,
							$ip
						)
					);
					return true;
				}
				return false;
			}
		}


		/**
		 * Get most used keywords
		 *
		 * @since 1.2.0
		 */
		public function get_keywords() {
			global $wpdb;

			$result = $wpdb->get_results(
				"SELECT 
					keyword, 
					count(keyword) AS count 
				FROM {$wpdb->prefix}wolmart_search_log 
				GROUP BY keyword 
				ORDER BY count 
				DESC LIMIT 10" //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			);

			return $result;
		}
	}
}

Wolmart_Save_Search::get_instance();
