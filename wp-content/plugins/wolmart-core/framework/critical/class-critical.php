<?php
/**
 * Wolmart Critical Css for Optimize
 *
 * @author     D-THEMES
 * @package    Wolmart Wordpress Framework
 * @subpackage Core
 * @since      1.2.0
 */
defined( 'ABSPATH' ) || die;

/**
 * Generate Critical CSS and critical dashboard.
 *
 * @since 1.2.0
 */
class Wolmart_Critical extends Wolmart_Base {

	/**
	 * The Page slug
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public $page_slug = 'wolmart-critical';

	/**
	 * The critical css.
	 *
	 * @access protected
	 * @since 1.2.0
	 * @var mixed.
	 */
	protected $css = array();

	/**
	 * The Cart id for critical preview
	 *
	 * @since 1.2.0
	 */
	public $cart_product = false;
	/**
	 * Constructor
	 *
	 * @since 1.2.0
	 */
	public function __construct() {
		add_action( 'wolmart_after_framework_init', array( $this, 'init' ) );

		add_action( 'wp_ajax_wolmart_critical_get_page', array( $this, 'get_page' ) );
		add_action( 'wp_ajax_wolmart_save_critical', array( $this, 'save_critical_css' ) );
		add_action( 'wp_ajax_wolmart_clear_merged_css', array( $this, 'clear_merged_css' ) );
		if ( ! empty( $_REQUEST['mobile_url'] ) || ! empty( $_REQUEST['desktop_url'] ) ) {
			show_admin_bar( false );
			add_action( 'init', array( $this, 'iframe_init' ) );
			if ( ! empty( $_REQUEST['mobile_url'] ) ) {
				add_filter( 'wp_is_mobile', '__return_true' );
			}
		} else {
			add_action( 'wp', array( $this, 'has_critical' ) );
		}
	}

	/**
	 * The init function.
	 *
	 * @since 1.2.0
	 */
	public function init() {
		if ( defined( 'WOLMART_VERSION' ) && wolmart_get_option( 'resource_critical_css' ) && is_admin() ) {
			add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );
			$this->table_actions();
		}
	}

	/**
	 * In Frontend, if option is activated, add action for loading critical css.
	 *
	 * @since 1.2.0
	 */
	public function has_critical() {
		if ( defined( 'WOLMART_VERSION' ) && ! wolmart_get_option( 'resource_critical_css' ) || ( function_exists( 'wolmart_is_preview' ) && wolmart_is_preview() ) ) {
			return false;
		}
		if ( is_admin() || is_customize_preview() ) {
			return false;
		}
		$css = '';
		if ( class_exists( 'Wolmart_Optimize_Stylesheets' ) ) {
			$cur_page_id = Wolmart_Optimize_Stylesheets::get_instance()->get_current_page_id();
			if ( is_front_page() ) {
				$css = get_option( 'homepage_critical' );
			} elseif ( $cur_page_id ) {
				$css = get_post_meta( $cur_page_id, 'wolmart_critical_css', true );
			}
		}
		if ( $css ) {
			add_action( 'wp_head', array( $this, 'load_critical_css' ), -10 );
			add_action( 'wp_head', array( $this, 'load_preload' ), -20 );
		}
		$this->css = $css;
	}

	/**
	 * Check if this page has critical CSS
	 *
	 * @since .1.2.0
	 */
	public function is_critical() {
		if ( defined( 'WOLMART_VERSION' ) && wolmart_get_option( 'resource_critical_css' ) && isset( $this->css['mobile']['css'] ) && isset( $this->css['desktop']['css'] ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Load Critical Css
	 *
	 * @since 1.2.0
	 */
	public function load_critical_css() {

		if ( wp_is_mobile() ) {
			echo '<style id="wolmart-critical-css">' . wolmart_strip_script_tags( $this->css['mobile']['css'] ) . '</style>';
		} else {
			echo '<style id="wolmart-critical-css">' . wolmart_strip_script_tags( $this->css['desktop']['css'] ) . '</style>';
		}
	}

	/**
	 * Load Preload
	 *
	 * @since 1.2.0
	 */
	public function load_preload() {
		if ( wp_is_mobile() ) {
			$preloads = empty( $this->css['mobile']['preload'] ) ? false : $this->css['mobile']['preload'];
		} else {
			$preloads = empty( $this->css['desktop']['preload'] ) ? false : $this->css['desktop']['preload'];
		}
		if ( empty( $preloads ) || ! is_array( $preloads ) ) {
			return;
		}
		foreach ( $preloads as $preload ) {
			echo '<link rel="preload" as="image" href="' . esc_url( $preload ) . '"/>' . PHP_EOL;
		}
	}

	/**
	 * Get Preload
	 *
	 * @since 1.2.0
	 */
	public function get_preloads() {
		if ( function_exists( 'wolmart_is_preview' ) && wolmart_is_preview() ) {
			return false;
		}
		if ( ! wolmart_get_option( 'resource_critical_css' ) || ! isset( $this->css['mobile'] ) ) {
			return false;
		}
		if ( wp_is_mobile() ) {
			return empty( $this->css['mobile']['preload'] ) ? false : $this->css['mobile']['preload'];
		} else {
			return empty( $this->css['desktop']['preload'] ) ? false : $this->css['desktop']['preload'];
		}
	}

	/**
	 * Remove default enqueue_steyls if critical iframe.
	 *
	 * @since 1.2.0
	 */
	public function iframe_init() {
		// Cart or Checkout
		add_action(
			'woocommerce_check_cart_items',
			function() {
				wc_get_template( 'cart/cart-empty.php' );
				if ( WC()->cart->is_empty() ) {
					$posts = get_posts(
						array(
							'post_type'           => 'product',
							'post_status'         => 'publish',
							'numberposts'         => 1,
							'ignore_sticky_posts' => true,
						)
					);
					if ( ! empty( $posts ) ) {
						// Get cart key
						$this->cart_product = WC()->cart->add_to_cart( $posts[0]->ID );
					}
				}
			}
		);

		// Release cart
		add_action(
			'wp_footer',
			function() {
				if ( class_exists( 'WooCommerce' ) && $this->cart_product ) {
					WC()->cart->remove_cart_item( $this->cart_product );
				}
			}
		);
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 20 );
	}

	/**
	 * Enqueue styles in critical preview.
	 *
	 * @since 1.2.0
	 */
	public function enqueue_styles() {
		// Disable Animation in critical preview
		$critical_css = apply_filters( 'wolmart_critical_css', '.elementor-invisible{opacity: 1 !important;visibility: visible !important;}', 'critical_preview' );
		echo '<style id="wolmart-critical-css">';
		echo wolmart_strip_script_tags( $critical_css );
		echo '</style>' . PHP_EOL;
	}

	/**
	 * Add admin menus.
	 *
	 * @since 1.2.0
	 */
	public function add_admin_menus() {
		add_submenu_page( 'wolmart', esc_html__( 'Critical CSS', 'wolmart-core' ), esc_html__( 'Critical CSS', 'wolmart-core' ), 'manage_options', $this->page_slug, array( $this, 'view_critical' ), 2 );
	}

	/**
	 * Render critical page.
	 *
	 * @since 1.2.0
	 */
	public function view_critical() {
		if ( ! Wolmart_Admin::get_instance()->is_registered() ) {
			wp_redirect( admin_url( 'admin.php?page=wolmart' ) );
			exit;
		}

		$this->load_assets();

		Wolmart_Admin_Panel::get_instance()->view_header( 'critical_css' );

		// Add individual pages.
		$pages        = get_pages();
		$pages_titles = array();
		foreach ( $pages as $page ) {
			$pages_titles[ $page->ID ] = $page->post_title;
		}
		$critical_nonce = wp_create_nonce( 'wolmart_critical_nonce' );
		?>		
				<div class="wolmart-admin-panel-header">
					<h1><?php esc_html_e( 'Critical CSS', 'wolmart-core' ); ?></h1>
					<p><?php esc_html_e( 'Generate critical css for each page or a particular page in purpose of enhancing optimization and boosting google page speed.', 'wolmart-core' ); ?></p>
				</div>
				<div class="wolmart-admin-panel-body wolmart-card-box">
					<h2><?php esc_html_e( 'Extract and inline critical CSS', 'wolmart-core' ); ?></h2>
					<p style="margin-bottom: 30px;"><?php esc_html_e( 'Critical wizard is a tool that extracts, minifies and inlines above-the-fold CSS. This allows the above-the-fold content to be rendered as soon as possible, even if CSS for other parts of the page has not yet loaded. To speed things up, Critical Wizard is already ready and page critical css is included in the below table. Now you can generate css for any pages as you want.', 'wolmart-core' ); ?></p>
					<form id="wolmart-critical-form">
						<input type="hidden" name="action" value="wolmart_critical_get_page">
						<label for="wolmart-critical-page"><?php esc_html_e( 'Select Page Type', 'wolmart-core' ); ?></label>
						<select id="wolmart-critical-page" name="wolmart_critical_page" class="form-control">
							<?php
								$types = apply_filters(
									'wolmart_critical_page',
									array(
										'homepage'         => esc_html__( 'Homepage', 'wolmart-core' ),
										'all_pages'        => esc_html__( 'All Pages', 'wolmart-core' ),
										'individual_pages' => esc_html__( 'Individual Pages', 'wolmart-core' ),
									)
								);
							?>
							<?php foreach ( $types as $key => $value ) : ?>
								<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
							<?php endforeach; ?>
						</select>
						<br />
						<label class="disabled" for="wolmart-select-particular"><?php esc_html_e( 'Select Individual Pages', 'wolmart-core' ); ?></label>
						<select id="wolmart-select-particular" name="wolmart_select_particular[]" class="form-control" multiple data-placeholder="">
							<?php foreach ( $pages_titles as $page_id => $page_title ) : ?>
								<option value="<?php echo esc_attr( $page_id ); ?>"><?php echo esc_html( $page_title ); ?></option>
							<?php endforeach; ?>
						</select>
						<br />
						<input type="hidden" name="wolmart_critical_nonce" value="<?php echo esc_attr( $critical_nonce ); ?>" />
						<button class="button button-large button-primary"><?php esc_html_e( 'Generate Critical CSS', 'wolmart-core' ); ?></button>
					</form>
					<div class="wolmart-progress">
						<div class="wolmart-progress-bar animate-progress">
						</div>
					</div>
				</div>
			</div> <!-- End .wolmart-admin-panel -->
			<div class="wolmart-admin-panel-body wolmart-pd-custom wolmart-card-box">
				<?php
					wolmart_core_require_once( '/critical/class-critical-table.php' );
					$css_table = new Wolmart_Critical_Table();
					$css_table->get_status_links();
				?>
				<form id="wolmart-critical-table-form" method="get" data-nonce="<?php echo esc_attr( $critical_nonce ); ?>">
					<?php
					$css_table->prepare_items();
					$css_table->display();
					?>
				</form>
			</div>
		</div>	 <!-- End .wolmart-wrap -->
		<?php
		// Instead already inject </div> tag.

		// Wolmart_Admin_Panel::get_instance()->view_footer( $admin_config );
	}

	/**
	 * Get table data.
	 *
	 * @since 1.2.0
	 */
	public function get_data( $args = array() ) {
		global $wpdb;
		$defaults = array(
			'order_by' => '',
			'order'    => 'ASC',
			'limit'    => '',
			'offset'   => 0,
		);
		$args     = wp_parse_args( $args, $defaults );
		$query    = "SELECT meta_id as id, post_id, meta_value FROM $wpdb->postmeta WHERE meta_key=%s AND meta_value!=''";
		// Build the ORDER BY fragment of the query.
		if ( '' !== $args['order_by'] ) {
			$order  = 'ASC' !== strtoupper( $args['order'] ) ? 'DESC' : 'ASC';
			$query .= ' ORDER BY ' . $args['order_by'] . ' ' . $order;
		}
		$result            = array();
		$homepage_critical = get_option( 'homepage_critical' );
		if ( 0 == $args['offset'] && ! empty( $homepage_critical ) && is_array( $homepage_critical ) ) {
			$result[]      = (object) array(
				'id'            => 'homepage',
				'critical_page' => ( 'page' == get_option( 'show_on_front' ) && false !== get_option( 'page_on_front' ) ) ? get_the_title( get_option( 'page_on_front' ) ) . esc_html( ' - Homepage', 'wolmart-core' ) : esc_html( 'Homepage', 'wolmart-core' ),
				'meta_value'    => true,
			);
			$args['limit'] = absint( $args['limit'] ) - 1;
		}
		// Build the LIMIT fragment of the query.
		if ( '' !== $args['limit'] ) {
			$query .= ' LIMIT ' . absint( $args['limit'] );
		}
		// Build the OFFSET fragment of the query.
		if ( 0 !== $args['offset'] ) {
			if ( ! empty( $homepage_critical ) && is_array( $homepage_critical ) ) { // if homepage has critical css
				$args['offset'] -= 1;
			}
			$query .= ' OFFSET ' . absint( $args['offset'] );
		}
		$res = $wpdb->get_results(
			$wpdb->prepare(
				$query, // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				'wolmart_critical_css'
			)
		);
		return array_merge( $result, $res );
	}

	/**
	 * Get Total.
	 *
	 * @since 1.2.0
	 */
	public function get_total() {
		global $wpdb;
		$count = (int) $wpdb->get_var( $wpdb->prepare( "select count(DISTINCT  post_id) from $wpdb->postmeta WHERE meta_value!='' AND meta_key=%s", 'wolmart_critical_css' ) );
		if ( ! empty( get_option( 'homepage_critical' ) ) ) { // if homepage
			$count ++;
		}
		return $count;
	}
	/**
	 * Add table data.
	 *
	 * @since 1.2.0
	 */
	public function add_data( $args = array() ) {
		global $wpdb;
		return $wpdb->insert( $wpdb->postmeta, $args, '%s' );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.2.0
	 */
	public function load_assets() {
		wp_enqueue_style( 'jquery-select2' );
		wp_enqueue_script( 'jquery-select2' );
		wp_enqueue_script( 'wolmart-critical-css', WOLMART_CORE_FRAMEWORK_URI . '/critical/critical-css.min.js', array( 'jquery-core' ), WOLMART_CORE_VERSION, true );
		wp_enqueue_script( 'wolmart-critical-wizard', WOLMART_CORE_FRAMEWORK_URI . '/critical/critical-wizard' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.js' : '.min.js' ), array( 'jquery-core' ), WOLMART_CORE_VERSION, true );
		wp_enqueue_style( 'wolmart-critical-wizard', WOLMART_CORE_FRAMEWORK_URI . '/critical/critical' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), WOLMART_CORE_VERSION );
	}

	/**
	 * Get pages which you want to generate critical css.
	 *
	 * @since 1.2.0
	 */
	public function get_page() {
		check_ajax_referer( 'wolmart_critical_nonce', 'wolmart_critical_nonce' );
		$critical_page = $_REQUEST['wolmart_critical_page'];
		$pages         = array();
		$home_url      = get_home_url(); // Get homepage url.
		if ( 'homepage' == $critical_page ) {
			$url               = $home_url;
			$pages['homepage'] = array(
				'desktop' => add_query_arg( 'desktop_url', 'true', esc_url( $url ) ),
				'mobile'  => add_query_arg( 'mobile_url', 'true', esc_url( $url ) ),
			);
		} elseif ( 'all_pages' == $critical_page ) {
			foreach ( get_pages() as $page ) {
				$url = get_permalink( $page->ID );
				$id  = $page->ID;
				if ( $home_url . '/' == $url ) {
					$id = 'homepage';
				}
				$pages[ $id ] = array(
					'desktop' => add_query_arg( 'desktop_url', 'true', esc_url( $url ) ),
					'mobile'  => add_query_arg( 'mobile_url', 'true', esc_url( $url ) ),
				);
			}
		} elseif ( 'individual_pages' == $critical_page ) {
			if ( empty( $_REQUEST['wolmart_select_particular'] ) ) {
				wp_send_json_error( __( 'No selection of the pages.', 'wolmart-core' ) );
			}
			foreach ( (array) wp_unslash( $_REQUEST['wolmart_select_particular'] ) as $page ) {
				$url = 'homepage' == $page ? $home_url : get_permalink( $page );
				if ( $url ) {
					$id = $page; // page id
					if ( $home_url . '/' == $url ) {
						$id = 'homepage';
					}
					$pages[ $id ] = array(
						'desktop' => add_query_arg( 'desktop_url', 'true', esc_url( $url ) ),
						'mobile'  => add_query_arg( 'mobile_url', 'true', esc_url( $url ) ),
					);
				}
			}
		}
		wp_send_json_success( $pages );
		die;
	}

	/**
	 * Save Critical CSS of the page.
	 *
	 * @since 1.2.0
	 */
	public function save_critical_css() {
		check_ajax_referer( 'wolmart_critical_nonce' );
		if ( ! empty( $_POST['id'] ) ) {
			if ( 'homepage' == $_POST['id'] ) {
				update_option( 'homepage_critical', maybe_unserialize( wp_unslash( $_POST['pageCriticalCss'] ) ) );
			} else {
				update_post_meta( $_POST['id'], 'wolmart_critical_css', maybe_unserialize( wp_unslash( $_POST['pageCriticalCss'] ) ) );
			}
		}
		wp_send_json_success();
		die;
	}

	/**
	 * Clear merged css.
	 *
	 * @since 1.2.1
	 */
	public function clear_merged_css() {
		check_ajax_referer( 'wolmart_critical_nonce' );
		if ( empty( get_theme_mod( 'resource_merge_stylesheets' ) ) ) {
			die;
		}
		$upload_dir  = wp_upload_dir();
		$upload_path = $upload_dir['basedir'] . '/' . 'wolmart_merged_resources/';
		if ( file_exists( $upload_path ) ) {
			foreach ( scandir( $upload_path ) as $file ) {
				if ( ! is_dir( $file ) ) {
					unlink( $upload_path . $file );
				}
			}
			rmdir( $upload_path );
		}
		wp_send_json_success();
		die;
	}

	/**
	 * The Table Actions
	 *
	 * @since 1.2.0
	 */
	public function table_actions() {
		$action = '';
		if ( isset( $_REQUEST['action'] ) ) {
			if ( -1 !== $_REQUEST['action'] && '-1' !== $_REQUEST['action'] ) {
				$action = sanitize_text_field( wp_unslash( $_REQUEST['action'] ) );
			}
		}
		if ( isset( $_REQUEST['action2'] ) ) {
			if ( -1 !== $_REQUEST['action2'] && '-1' !== $_REQUEST['action2'] ) {
				$action = sanitize_text_field( wp_unslash( $_REQUEST['action2'] ) );
			}
		}

		if ( ! empty( $action ) ) {
			if ( 'wolmart_bulk_delete_critical' == $action ) {
				$this->bulk_delete_critical();
			} elseif ( 'delete_css' == $action ) {
				$this->delete_css();
			}
			return false;
		}
		if ( ( isset( $_REQUEST['page'] ) && false !== strpos( $_REQUEST['page'], 'wolmart' ) ) && ( isset( $_REQUEST['action2'] ) || isset( $_REQUEST['action'] ) ) ) {
			$referer = wp_get_referer();
			if ( $referer ) {
				wp_safe_redirect( $referer );
				die;
			}
		}
		return false;
	}

	/**
	 * Redirect to Critical CSS wizard page.
	 *
	 * @since 1.2.0
	 */
	public function redirect_critical_wizard() {
		$url = wp_unslash( $_SERVER['REQUEST_URI'] );
		if ( isset( $_REQUEST['_wp_http_referer'] ) ) {
			$referer = wp_get_referer();
			if ( $referer ) {
				$url = $referer;
			}
		}
		$url = remove_query_arg( array( 'action', 'action2', 'post' ), $url );
		wp_safe_redirect( $url );
		die;
	}

	/**
	 * Bulk delete the critical CSS.
	 *
	 * @since 1.2.0
	 */
	public function bulk_delete_critical() {

		if ( ! isset( $_GET['post'] ) ) {
			$this->redirect_critical_wizard();
		}

		$page_ids = wp_unslash( $_GET['post'] );

		foreach ( $page_ids as $key => $value ) {
			if ( 'homepage' == $value ) {
				unset( $page_ids[ $key ] );
				update_option( 'homepage_critical', '' );
				break;
			}
		}

		// Delete critical css
		global $wpdb;
		$page_ids = sanitize_text_field( implode( ',', $page_ids ) );
		$wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->postmeta . " SET meta_value = '' WHERE meta_id IN ($page_ids)" ) ); // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared

		$this->redirect_critical_wizard();
	}

	/**
	 * Delete the critical CSS.
	 *
	 * @since 1.2.0
	 */
	public function delete_css() {

		$page_id = wp_unslash( $_GET['post'] );
		global $wpdb;
		if ( 'homepage' == $page_id ) {
			update_option( 'homepage_critical', '' );
		} else {
			$wpdb->update( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$wpdb->postmeta,
				array( 'meta_value' => '' ),
				array( 'meta_id' => $page_id ),
				array( '%s' ),
				array( '%d' )
			);
		}
		$this->redirect_critical_wizard();
	}

}

Wolmart_Critical::get_instance();
