<?php
/**
 * Wolmart Critical Css Table for Optimize
 *
 * @author     D-THEMES
 * @package    Wolmart Wordpress FrameWork
 * @subpackage Core
 * @since      1.2.0
 */
defined( 'ABSPATH' ) || die;

// Preload WP List Table Library
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}


if ( ! class_exists( 'Wolmart_Critical_Table' ) ) {
	class Wolmart_Critical_Table extends WP_List_Table {
		/**
		 * The URI.
		 *
		 * @since 1.2.0
		 */
		public $url = '';

		/**
		 * The constructor.
		 *
		 * @since 1.2.0
		 */
		public function __construct() {
			parent::__construct();
			$this->url = remove_query_arg( array( 'action', 'action2', 'post' ), wp_unslash( $_SERVER['REQUEST_URI'] ) );
		}

		/**
		 * Gets a list of CSS classes for the table tag.
		 *
		 * @since 1.2.0
		 */
		public function get_table_classes() {
			return array( 'widefat', 'striped' );
		}

		/**
		 * Gets a list of columns.
		 *
		 * @since 1.2.0
		 */
		public function get_columns() {
			return array(
				'cb'            => '<input type="checkbox" />',
				'critical_page' => esc_html__( 'Pages', 'wolmart-core' ),
				'mobile_css'    => esc_html__( 'Mobile CSS', 'wolmart-core' ),
				'desktop_css'   => esc_html__( 'Desktop CSS', 'wolmart-core' ),
				'recompile'     => esc_html__( 'Recompile', 'wolmart-core' ),
			);
		}

		/**
		 * Prepare the items for the table.
		 *
		 * @since 1.2.0
		 */
		public function prepare_items() {
			$columns      = $this->get_columns();
			$per_page     = 10;
			$current_page = $this->get_pagenum();
			$this->items  = $this->table_data( $per_page, $current_page );
			$total        = Wolmart_Critical::get_instance()->get_total();

			$this->set_pagination_args(
				array(
					'total_items' => $total,
					'per_page'    => $per_page,
				)
			);

			$this->_column_headers = array( $columns, array(), array() );
		}

		/**
		 * Get the table data.
		 *
		 * @since 1.2.0
		 */
		private function table_data( $per_page = -1, $current_page = 0 ) {
			$data         = array();
			$per_page     = (int) $per_page;
			$current_page = (int) $current_page;

			$args = array(
				'limit'  => $per_page,
				'offset' => ( $current_page - 1 ) * $per_page,
				'where'  => array(),
			);

			if ( isset( $_GET['orderby'] ) ) {
				$args['order_by'] = sanitize_text_field( wp_unslash( $_GET['orderby'] ) );
				$args['order']    = isset( $_GET['order'] ) ? sanitize_text_field( wp_unslash( $_GET['order'] ) ) : 'ASC';
			}

			foreach ( Wolmart_Critical::get_instance()->get_data( $args ) as $row ) {
				if ( ! empty( $row->meta_value ) ) {
					$data[] = array(
						'id'            => $row->id,
						'critical_page' => empty( $row->post_id ) ? $row->critical_page : $row->post_id,
						'mobile_css'    => isset( $row->meta_value ) ? true : false,
						'desktop_css'   => isset( $row->meta_value ) ? true : false,
					);
				}
			}

			return $data;
		}

		/**
		 * Handles the default column output.
		 *
		 * @since 1.2.0
		 */
		public function column_default( $item, $column_id ) {
			if ( isset( $item[ $column_id ] ) ) {
				return $item[ $column_id ];
			}
			return '';
		}

		/**
		 * Get checkbox field html.
		 *
		 * @since 1.2.0
		 */
		public function column_cb( $item ) {
			return "<input type='checkbox' name='post[]' value='{$item['id']}' />";
		}

		/**
		 * Get page field.
		 *
		 * @since 1.2.0
		 */
		public function column_critical_page( $item ) {
			$markup = $item['critical_page'];
			if ( is_numeric( $markup ) ) {
				$post   = get_post( $markup );
				$markup = '<a href="' . esc_url( get_permalink( $post ) ) . '" target="_blank" rel="noopener">' . get_the_title( $post ) . '</a>';
			} elseif ( 'homepage' === $item['id'] ) {
				$markup = '<a href="' . esc_url( get_home_url() ) . '" target="_blank" rel="noopener">' . $markup . '</a>';
			}
			$actions['delete'] = sprintf( '<a href="' . esc_url( $this->url ) . '&action=%s&post=%s">' . esc_html__( 'Delete', 'wolmart-core' ) . '</a>', 'delete_css', esc_attr( $item['id'] ) );

			return $markup . $this->row_actions( $actions );
		}

		/**
		 * Get desktop css field.
		 *
		 * @since 1.2.0
		 */
		public function column_desktop_css( $item ) {

			$icon = '<i class="fas fa-check"></i>';
			if ( empty( $item['desktop_css'] ) ) {
				$icon = '-';
			}
			return '<span>' . $icon . '</span>';
		}

		/**
		 * Get column css field.
		 *
		 * @since 1.2.0
		 */
		public function column_mobile_css( $item ) {

			$icon = '<i class="fas fa-check"></i>';
			if ( empty( $item['mobile_css'] ) ) {
				$icon = '-';
			}

			return '<span>' . $icon . '</span>';
		}

		/**
		 * Get recompile field html.
		 *
		 * @since 1.2.0
		 */
		public function column_recompile( $item ) {
			return '<a href="#" class="wolmart-recompile-row button">' . esc_html__( 'Recompile', 'wolmart-core' ) . '</a>';
		}

		/**
		 * Message to be displayed when there are no items.
		 *
		 * @since 1.2.0
		 */
		public function no_items() {
			esc_attr_e( 'No critical CSS data found.', 'wolmart-core' );
		}

		/**
		 * Retrieves the list of bulk actions available for this table.
		 *
		 * @since 1.2.0
		 */
		public function get_bulk_actions() {
			$actions = array(
				'wolmart_bulk_delete_critical'    => esc_html__( 'Delete', 'wolmart-core' ),
				'wolmart_bulk_recompile_critical' => esc_html__( 'Recompile', 'wolmart-core' ),
			);
			return $actions;
		}

		/**
		 * Generates content for a single row of the table.
		 *
		 * @since 1.2.0
		 */
		public function single_row( $item ) {
			echo '<tr data-page-id="' . ( is_numeric( $item['critical_page'] ) ? $item['critical_page'] : 'homepage' ) . '" data-id="' . $item['id'] . '">';
			$this->single_row_columns( $item );
			echo '</tr>';
		}
	}
}
