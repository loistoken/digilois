<?php
/**
 * Wolmart_Single_Product_Builder class
 */
defined( 'ABSPATH' ) || die;

define( 'WOLMART_SIDEBAR_BUILDER', WOLMART_BUILDERS . '/sidebar' );

class Wolmart_Sidebar_Builder extends Wolmart_Base {

	private static $instance = null;

	public function __construct() {
		if ( isset( $_GET['page'] ) && 'wolmart_sidebar' == $_GET['page'] ) {
			add_filter( 'wolmart_core_admin_localize_vars', array( $this, 'add_localize_vars' ) );
		}
		$this->_init_sidebars();

		add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );
		add_action( 'widgets_init', array( $this, 'add_widgets' ) );

		// Compatabilities
		add_filter( 'widget_nav_menu_args', array( $this, 'make_collapsible_menus' ), 10, 4 );

		// Ajax
		add_action( 'wp_ajax_wolmart_add_widget_area', array( $this, 'add_sidebar' ) );
		add_action( 'wp_ajax_nopriv_wolmart_add_widget_area', array( $this, 'add_sidebar' ) );
		add_action( 'wp_ajax_wolmart_remove_widget_area', array( $this, 'remove_sidebar' ) );
		add_action( 'wp_ajax_nopriv_wolmart_remove_widget_area', array( $this, 'remove_sidebar' ) );
	}

	public function add_widgets() {

		$widgets = array(
			'block',
			'posts',
			'posts_nav',
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$widgets[] = 'brands_nav';
			$widgets[] = 'price_filter';
			$widgets[] = 'products';
			$widgets[] = 'filter_clean';
		}

		foreach ( $widgets as $widget ) {
			include_once WOLMART_BUILDERS . '/sidebar/widgets/' . str_replace( '_', '-', $widget ) . '.php';
			register_widget( 'Wolmart_' . ucwords( $widget, '_' ) . '_Sidebar_Widget' );
		}
	}

	public function add_admin_menus() {
		// Menu - wolmart / sidebar
		add_submenu_page( 'wolmart', esc_html__( 'Sidebars', 'wolmart-core' ), esc_html__( 'Sidebars', 'wolmart-core' ), 'administrator', 'wolmart_sidebar', array( Wolmart_Sidebar_Builder::get_instance(), 'sidebar_view' ) );
	}

	public function make_collapsible_menus( $nav_menu_args, $menu, $args, $instance ) {
		$nav_menu_args['items_wrap'] = '<ul id="%1$s" class="menu collapsible-menu">%3$s</ul>';
		return $nav_menu_args;
	}

	private function _init_sidebars() {
		$sidebars = get_option( 'wolmart_sidebars' );
		if ( $sidebars ) {
			$sidebars       = json_decode( $sidebars, true );
			$this->sidebars = $sidebars;
		} else {
			$this->sidebars = array();
		}
	}

	public function add_localize_vars( $vars ) {
		$vars['sidebars']  = $this->sidebars;
		$vars['admin_url'] = esc_url( admin_url() );
		return $vars;
	}

	public function sidebar_view() {
		if ( class_exists( 'Wolmart_Admin_Panel' ) ) {
			Wolmart_Admin_Panel::get_instance()->view_header( 'sidebars_builder' );
			?>
			<div class="wolmart-admin-panel-header wolmart-row">
				<div class="wolmart-admin-panel-header-inner">
					<h2><?php esc_html_e( 'Sidebars Builder', 'wolmart-core' ); ?></h2>
					<p><?php esc_html_e( 'This enables you to add unlimited widget areas for your stunning site and remove unnecessary sidebars.', 'wolmart-core' ); ?></p>
				</div>
				<button id="add_widget_area" class="button button-dark button-large"><?php esc_html_e( 'Add New Sidebar', 'wolmart-core' ); ?></button>
			</div>
			<div class="wolmart-admin-panel-body wolmart-card-box sidebars-builder">
				<table class="wp-list-table widefat" id="sidebar_table">
					<thead>
						<tr>
							<th scope="col" id="title" class="manage-column column-title column-primary"><?php esc_html_e( 'Title', 'wolmart-core' ); ?></th>
							<th scope="col" id="slug" class="manage-column column-slug"><?php esc_html_e( 'Slug', 'wolmart-core' ); ?></th>
							<th scope="col" id="remove" class="manage-column column-remove"><?php esc_html_e( 'Action', 'wolmart-core' ); ?></th>
						</tr>
					</thead>
					<tbody id="the-list">
					<?php
					global $wp_registered_sidebars;
					$default_sidebars = array();
					foreach ( $wp_registered_sidebars as $key => $value ) {
						echo '<tr id="' . $key . '" class="sidebar">';
							echo '<td class="title column-title"><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">' . $value['name'] . '</a></td>';
							echo '<td class="slug column-slug">' . $key . '</td>';
							echo '<td class="remove column-remove">' . ( in_array( $key, array_keys( $this->sidebars ) ) ? '<a href="#">' . esc_html__( 'Remove', 'wolmart-core' ) . '</a>' : esc_html__( 'Unremovable', 'wolmart-core' ) ) . '</td>';
						echo '</tr>';
					}
					?>
					</tbody>
				</table>
			</div>
				<?php
				Wolmart_Admin_Panel::get_instance()->view_footer();
		}
	}

	public function add_sidebar() {
		if ( ! check_ajax_referer( 'wolmart-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( isset( $_POST['slug'] ) && isset( $_POST['name'] ) ) {
			$this->sidebars[ $_POST['slug'] ] = $_POST['name'];

			update_option( 'wolmart_sidebars', json_encode( $this->sidebars ) );

			wp_send_json_success( esc_html__( 'succesfully registered', 'wolmart-core' ) );
		} else {
			wp_send_json_error( 'no sidebar name or slug' );
		}
	}

	public function remove_sidebar() {
		if ( ! check_ajax_referer( 'wolmart-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( isset( $_POST['slug'] ) ) {
			unset( $this->sidebars[ $_POST['slug'] ] );

			update_option( 'wolmart_sidebars', json_encode( $this->sidebars ) );

			wp_send_json_success( esc_html__( 'succesfully removed', 'wolmart-core' ) );
		} else {
			wp_send_json_error( 'no sidebar name or slug' );
		}
	}
}

Wolmart_Sidebar_Builder::get_instance();
