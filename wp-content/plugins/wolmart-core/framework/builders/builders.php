<?php
/**
 * Wolmart Template
 *
 * @package Wolmart Core WordPress plugin
 * @version 1.0
 */
defined( 'ABSPATH' ) || die;

class Wolmart_Builders extends Wolmart_Base {

	protected $template_types;

	protected $post_id = '';

	public function __construct() {

		$this->_init_template_types();

		add_action( 'init', array( $this, 'register_template_type' ) );

		add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );

		// Print Wolmart Template Builder Page's Header
		if ( current_user_can( 'edit_posts' ) && 'edit.php' == $GLOBALS['pagenow'] && isset( $_REQUEST['post_type'] ) && 'wolmart_template' == $_REQUEST['post_type'] ) {
			add_action( 'all_admin_notices', array( $this, 'print_template_dashboard_header' ) );
			add_filter( 'views_edit-wolmart_template', array( $this, 'print_template_category_tabs' ) );
		}

		// Add "template type" column to posts table.
		add_filter( 'manage_wolmart_template_posts_columns', array( $this, 'admin_column_header' ) );
		add_action( 'manage_wolmart_template_posts_custom_column', array( $this, 'admin_column_content' ), 10, 2 );

		// Ajax
		add_action( 'wp_ajax_wolmart_save_template', array( $this, 'save_wolmart_template' ) );
		add_action( 'wp_ajax_nopriv_wolmart_save_template', array( $this, 'save_wolmart_template' ) );

		// Delete post meta when post is delete
		add_action( 'delete_post', array( $this, 'delete_template' ) );

		// Change Admin Post Query with wolmart template types
		add_action( 'parse_query', array( $this, 'filter_template_type' ) );

		// Resources
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );

		// Add template builder classes to body class
		add_filter( 'body_class', array( $this, 'add_body_class_for_preview' ) );

		add_filter(
			'wolmart_core_admin_localize_vars',
			function( $vars ) {
				$post_id                                   = get_the_ID();
				$vars['template_type']                     = $this->post_id ? get_post_meta( $this->post_id, 'wolmart_template_type', true ) : 'layout';
				$vars['texts']['elementor_addon_settings'] = esc_html__( 'Wolmart Settings', 'wolmart-core' );
				return $vars;
			}
		);

		if ( is_admin() ) {
			if ( wolmart_is_elementor_preview() && isset( $_REQUEST['post'] ) && $_REQUEST['post'] ) {
				$this->post_id = intval( $_REQUEST['post'] );
				add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'load_assets' ), 30 );
				add_filter( 'wolmart_core_admin_localize_vars', array( $this, 'add_addon_htmls' ) );
			} elseif ( wolmart_is_wpb_preview() ) {
				if ( isset( $_REQUEST['post'] ) ) {
					$this->post_id = $_REQUEST['post'];
				} elseif ( isset( $_REQUEST['post_id'] ) ) {
					$this->post_id = $_REQUEST['post_id'];
				} else {
					$this->post_id = 0;
				}
			}
		}
	}

	public function add_admin_menus() {
		// Menu - wolmart / template
		add_submenu_page( 'wolmart', esc_html__( 'Templates', 'wolmart-core' ), esc_html__( 'Templates', 'wolmart-core' ), 'administrator', 'edit.php?post_type=wolmart_template', '', 5 );
	}

	private function _init_template_types() {
		$this->template_types = array(
			'block'  => esc_html__( 'Block Builder', 'wolmart-core' ),
			'header' => esc_html__( 'Header Builder', 'wolmart-core' ),
			'footer' => esc_html__( 'Footer Builder', 'wolmart-core' ),
			'popup'  => esc_html__( 'Popup Builder', 'wolmart-core' ),
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$this->template_types['product_layout'] = esc_html__( 'Single Product Builder', 'wolmart-core' );
		}
	}

	/**
	 * Add addon html to admin's localize vars.
	 *
	 * @since 1.0
	 * @param array $vars
	 * @return array $vars
	 */
	public function add_addon_htmls( $vars ) {
		$vars['builder_addons'] = apply_filters( 'wolmart_builder_addon_html', array() );
		$vars['theme_url']      = esc_url( get_parent_theme_file_uri() );
		return $vars;
	}

	public function load_assets() {
		wp_enqueue_style( 'wolmart-core-admin', WOLMART_BUILDERS_URI . '/builder' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), WOLMART_CORE_VERSION );
		wp_enqueue_script( 'wolmart-core-admin', WOLMART_BUILDERS_URI . '/builder' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.js' : '.min.js' ), array(), false, true );
	}

	public function add_body_class_for_preview( $classes ) {
		if ( 'wolmart_template' == get_post_type() ) {
			$template_category = get_post_meta( get_the_ID(), 'wolmart_template_type', true );

			if ( ! $template_category ) {
				$template_category = 'block';
			}

			$classes[] = 'wolmart_' . $template_category . '_template';
		}
		return $classes;
	}

	public function register_template_type() {
		register_post_type(
			'wolmart_template',
			array(
				'label'               => esc_html__( 'Wolmart Templates', 'wolmart-core' ),
				'exclude_from_search' => true,
				'has_archive'         => false,
				'public'              => true,
				'supports'            => array( 'title', 'editor', 'wolmart', 'wolmart-core' ),
				'can_export'          => true,
				'show_in_rest'        => true,
				'show_in_menu'        => false,
			)
		);
	}

	public function hide_page( $class ) {
		return $class . ' hidden';
	}

	public function print_template_dashboard_header() {
		if ( class_exists( 'Wolmart_Admin_Panel' ) ) {
			Wolmart_Admin_Panel::get_instance()->view_header( 'templates_builder' );
			?>
			<div class="wolmart-admin-panel-header wolmart-row">
				<div class="wolmart-admin-panel-header-inner">
					<h2><?php esc_html_e( 'Templates Builder', 'wolmart-core' ); ?></h2>
					<p><?php esc_html_e( 'Build any part of your site with Wolmart Template Builder. This provides an easy but powerful way to build a full site with hundreds of pre-built templates from Wolmart Studio.', 'wolmart' ); ?></p>
				</div>
				<div class="buttons">
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=wolmart_template' ) ); ?>" class="page-title-action wolmart-add-new-template button button-dark button-large"><?php esc_html_e( 'Add New Template', 'wolmart-core' ); ?></a>
				</div>
			</div>
			<div class="wolmart-admin-panel-body wolmart-card-box templates-builder">
			</div>
			<?php
			Wolmart_Admin_Panel::get_instance()->view_footer();
		}
	}

	public function print_template_category_tabs( $views = array() ) {
		echo '<div class="nav-tab-wrapper" id="wolmart-template-nav">';

		$curslug = '';

		if ( isset( $_GET ) && isset( $_GET['post_type'] ) && 'wolmart_template' == $_GET['post_type'] && isset( $_GET['wolmart_template_type'] ) ) {
			$curslug = $_GET['wolmart_template_type'];
		}

		echo '<a class="nav-tab' . ( '' == $curslug ? ' nav-tab-active' : '' ) . '" href="' . admin_url( 'edit.php?post_type=wolmart_template' ) . '">' . esc_html__( 'All', 'wolmart-core' ) . '</a>';

		foreach ( $this->template_types as $slug => $name ) {
			echo '<a class="nav-tab' . ( $slug == $curslug ? ' nav-tab-active' : '' ) . '" href="' . admin_url( 'edit.php?post_type=wolmart_template&wolmart_template_type=' . $slug ) . '">' . sprintf( esc_html__( '%s', 'wolmart-core' ), $name ) . '</a>';
		}

		echo '</div>';

		wp_enqueue_script( 'jquery-magnific-popup' );

		?>

		<div class="wolmart-modal-overlay"></div>
		<div id="wolmart_new_template" class="wolmart-modal wolmart-new-template-modal">
			<button class="wolmart-modal-close dashicons dashicons-no-alt"></button>
			<div class="wolmart-modal-box">
				<div class="wolmart-modal-header">
					<h2><span class="wolmart-mini-logo"></span><?php esc_html_e( 'New Template', 'wolmart-core' ); ?></h2>
				</div>
				<div class="wolmart-modal-body">
					<div class="wolmart-new-template-description">
						<?php /* translators: $1 and $2 opening and closing strong tags respectively */ ?>
						<h3><?php printf( esc_html__( 'One Click Install %1$sTemplates%2$s', 'wolmart-core' ), '<b>', '</b>' ); ?></h3>

						<p><?php esc_html_e( 'A huge library of online templates are ready for your quick work, and their combination will bring about a new fashionable site.', 'wolmart-core' ); ?></p>
						<?php if ( defined( 'WOLMART_VERSION' ) ) : ?>
							<div class="editors">
								<?php if ( defined( 'ELEMENTOR_VERSION' ) ) : ?>
									<label for="wolmart-elementor-studio">
										<input type="radio" id="wolmart-elementor-studio" name="wolmart-studio-type" value="elementor" checked="checked">
										<img src="<?php echo esc_url( WOLMART_URI . '/assets/images/admin/builder_elementor.png' ); ?>" alt="<?php echo esc_attr__( 'Elementor', 'wolmart-core' ); ?>" title="<?php echo esc_attr__( 'Elementor', 'wolmart-core' ); ?>">
									</label>
								<?php endif; ?>
								<?php if ( defined( 'WPB_VC_VERSION' ) ) : ?>
									<label for="wolmart-js_composer-studio">
										<input type="radio" id="wolmart-js_composer-studio" name="wolmart-studio-type" value="js_composer">
										<img src="<?php echo esc_url( WOLMART_URI . '/assets/images/admin/builder_wpbakery.png' ); ?>" alt="<?php echo esc_attr__( 'WPBakery Page Builder', 'wolmart-core' ); ?>" title="<?php echo esc_attr__( 'WPBakery Page Builder', 'wolmart-core' ); ?>">
									</label>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="wolmart-new-template-form">
						<h4><?php esc_html_e( 'Choose Template Type', 'wolmart-core' ); ?></h4>
						<div class="option">
							<label><?php esc_html_e( 'Select Template Type', 'wolmart-core' ); ?></label>
							<select class="template-type">
							<?php
							foreach ( $this->template_types as $slug => $key ) {
								echo '<option value="' . esc_attr( $slug ) . '" ' . selected( $slug, $curslug ) . '>' . esc_html( $key ) . '</option>';
							}
							?>
							</select>
						</div>
						<div class="option">
							<label><?php esc_html_e( 'Name your template', 'wolmart-core' ); ?></label>
							<input type="text" name="template-name" class="template-name" placeholder="<?php esc_attr_e( 'Enter your template name (required)', 'wolmart-core' ); ?>" />
						</div>
						<div class="option">
							<label><?php esc_html_e( 'From Online Templates', 'wolmart-core' ); ?></label>
							<div class="wolmart-template-input">
								<input id="wolmart-new-template-type" type="hidden" />
								<input id="wolmart-new-template-id" type="hidden" />
								<input id="wolmart-new-template-name" type="text" class="online-template" readonly />
								<button id="wolmart-new-studio-trigger" title="<?php esc_attr_e( 'Wolmart Studio', 'wolmart-core' ); ?>"><i class="fas fa-layer-group"></i>
							</div>
						</div>
						<button class="button" id="wolmart-create-template-type"><?php esc_html_e( 'Create Template', 'wolmart-core' ); ?></button>
					</div>
				</div>
			</div>
		</div>

		<?php
		return $views;
	}

	public function admin_column_header( $defaults ) {
		$date_post = array_search( 'date', $defaults );
		$changed   = array_merge( array_slice( $defaults, 0, $date_post - 1 ), array( 'template_type' => esc_html__( 'Template Type', 'wolmart-core' ) ), array_slice( $defaults, $date_post ) );
		return $changed;
	}

	public function admin_column_content( $column_name, $post_id ) {
		if ( 'template_type' === $column_name ) {
			$type = esc_attr( get_post_meta( $post_id, 'wolmart_template_type', true ) );
			echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=wolmart_template&wolmart_template_type=' . $type ) ) . '">' . str_replace( '_', ' ', $type ) . '</a>';
		}
	}

	public function save_wolmart_template() {
		if ( ! check_ajax_referer( 'wolmart-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( ! isset( $_POST['name'] ) || ! isset( $_POST['type'] ) ) {
			wp_send_json_error( esc_html__( 'no template type or name', 'wolmart-core' ) );
		}

		$post_id = wp_insert_post(
			array(
				'post_title'  => $_POST['name'],
				'post_type'   => 'wolmart_template',
				'post_status' => 'publish',
			)
		);

		wp_save_post_revision( $post_id );
		update_post_meta( $post_id, 'wolmart_template_type', $_POST['type'] );
		if ( isset( $_POST['template_id'] ) && (int) $_POST['template_id'] && isset( $_POST['template_type'] ) && $_POST['template_type'] && isset( $_POST['template_category'] ) && $_POST['template_category'] ) {

			$is_vc_change_layout = false;
			$template_type       = $_POST['template_type'];
			$template_category   = $_POST['template_category'];

			update_post_meta(
				$post_id,
				'wolmart_start_template',
				array(
					'id'   => (int) $_POST['template_id'],
					'type' => $template_type,
				)
			);
			if (
				( 'header' == $template_category || 'footer' == $template_category ) &&
				( 'v' == $template_type || (
					'my' == $template_type && defined( 'VCV_VERSION' ) && 'fe' == get_post_meta( $id, 'vcv-be-editor', true ) &&
					function_exists( 'wolmart_is_vc_preview' ) && wolmart_is_vc_preview() )
				)
			) {
				$is_vc_change_layout = true;
			}

			if ( $is_vc_change_layout ) {
				update_post_meta( $post_id, '_vcv-page-template', 'default' );
				update_post_meta( $post_id, '_vcv-page-template-type', 'theme' );
			}
		}

		wp_send_json_success( $post_id );
	}

	public function delete_template( $post_id ) {
		if ( 'wolmart_template' == get_post_type( $post_id ) ) {
			delete_post_meta( $post_id, 'wolmart_template_type' );
		}
	}

	public function filter_template_type( $query ) {
		if ( is_admin() ) {
			global $pagenow;

			if ( 'edit.php' == $pagenow && isset( $_GET ) && isset( $_GET['post_type'] ) && 'wolmart_template' == $_GET['post_type'] ) {
				$template_type = '';
				if ( isset( $_GET['wolmart_template_type'] ) && $_GET['wolmart_template_type'] ) {
					$template_type = $_GET['wolmart_template_type'];
				}

				$query->query_vars['meta_key']   = 'wolmart_template_type';
				$query->query_vars['meta_value'] = $template_type;
			}
		}
	}
}

Wolmart_Builders::get_instance();
