<?php
/**
 * Wolmart Admin Meta Boxes
 *
 * @package Wolmart Core WordPress plugin
 * @since 1.0
 */
defined( 'ABSPATH' ) || die;

class Wolmart_Admin_Meta_Boxes extends Wolmart_Base {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Add product category icon meta form fields.
		if ( class_exists( 'WooCommerce' ) ) {
			add_action( 'product_cat_edit_form_fields', array( $this, 'add_product_cat_fields' ), 100 );
			add_action( 'product_cat_add_form_fields', array( $this, 'add_product_cat_fields' ), 100 );
			add_action( 'created_term', array( $this, 'save_term_meta_box' ), 10, 3 );
			add_action( 'edit_term', array( $this, 'save_term_meta_box' ), 100, 3 );
		}

		// Add video and more images to post
		add_filter( 'rwmb_meta_boxes', array( $this, 'add_post_media' ) );

		// Add custom css, js metabox in default page editor.
		add_action( 'save_post_page', array( $this, 'update_page_custom_meta_box' ), 1, 2 );
		if ( 'post-new.php' == $GLOBALS['pagenow'] || ( 'post.php' == $GLOBALS['pagenow'] && ( isset( $_GET['action'] ) && 'edit' == $_GET['action'] ) || ( isset( $_POST['action'] ) && 'editpost' == $_POST['action'] ) ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_code_editor_scripts' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_page_custom_css_js_box' ), 30 );
			add_action( 'save_post', array( $this, 'update_page_custom_meta_box' ), 1, 2 );
		}
	}

	/**
	 * Load code editor scripts for page custom css, js meta box.
	 *
	 * @since 1.0
	 */
	public function load_admin_code_editor_scripts() {
		wp_enqueue_style( 'wp-codemirror' );
		wp_enqueue_style( 'code-editor' );
		wp_enqueue_script( 'csslint' );
		wp_enqueue_script( 'jshint' );
		wp_enqueue_script( 'wp-codemirror' );
		wp_enqueue_script( 'code-editor' );
	}

	/**
	 * Add video and more images to post
	 *
	 * @since 1.0
	 */
	public function add_post_media( $meta_boxes ) {
		$meta_boxes[] = array(
			'title'      => esc_html__( 'Post Option', 'wolmart-core' ),
			'post_types' => array( 'post' ),
			'fields'     => array(
				'supported_images' => array(
					'type'              => 'file_advanced',
					'name'              => esc_html__( 'Supported Images', 'wolmart-core' ),
					'id'                => 'supported_images',
					'save_field'        => true,
					'label_description' => esc_html__( 'These images will be shown as slider with Featured Image.', 'wolmart-core' ),
				),
				'featured_video'   => array(
					'type'              => 'textarea',
					'name'              => esc_html__( 'Featured Video', 'wolmart-core' ),
					'id'                => 'featured_video',
					'save_field'        => true,
					'label_description' => esc_html__( 'Input embed code or use shortcodes. ex) iframe-tag or', 'wolmart-core' ) . ' [video src="url.mp4"]',
				),
			),
		);

		return $meta_boxes;
	}

	/**
	 * Add more form fields to product category.
	 *
	 * @since 1.0
	 */
	public function add_product_cat_fields( $tag ) {
		if ( is_object( $tag ) ) : ?>
			<tr class="form-field">
				<th scope="row"><label for="product_cat_icon"><?php esc_html_e( 'Category Icon', 'wolmart-core' ); ?></label></th>
				<td>
					<input name="product_cat_icon" id="product_cat_icon" type="text" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'product_cat_icon', true ) ); ?>" placeholder="<?php esc_attr_e( 'Input icon class here...', 'wolmart-core' ); ?>">
				</td>
			</tr>
		<?php else : ?>
			<div class="form-field">
				<label for="product_cat_icon"><?php esc_html_e( 'Category Icon', 'wolmart-core' ); ?></label>
				<input name="product_cat_icon" id="product_cat_icon" type="text" placeholder="<?php esc_attr_e( 'Input icon class here...', 'wolmart-core' ); ?>">
			</div>
			<?php
		endif;
	}

	/**
	 * save form field meta box
	 *
	 */
	public function save_term_meta_box( $term_id, $tt_id, $taxonomy ) {
		if ( 'product_cat' == $taxonomy ) {
			if ( isset( $_POST['product_cat_icon'] ) ) {
				update_term_meta( $term_id, 'product_cat_icon', $_POST['product_cat_icon'] );
			} else {
				delete_term_meta( $term_id, 'product_cat_icon' );
			}
		}
	}

	/**
	 * Add meta boxes of page layout options for page.
	 *
	 * @since 1.0
	 */
	public function add_page_custom_css_js_box() {
		add_meta_box( 'wolmart-post-layout-meta-box', esc_html__( 'Wolmart Custom Option', 'wolmart-core' ), array( $this, 'add_page_custom_meta_box' ), null, 'advanced', 'low' );
	}

	/**
	 * page layout options
	 */
	public function add_page_custom_meta_box() {
		?>
		<label for="page_css"><?php esc_html_e( 'Custom CSS', 'wolmart-core' ); ?></label>
		<div class="wolmart-editor">
			<textarea rows="10" name="page_css" id="page_css"><?php echo wp_strip_all_tags( get_post_meta( get_the_ID(), 'page_css', true ) ); ?></textarea>
		</div>
		<?php
		if ( current_user_can( 'unfiltered_html' ) ) {
			?>
			<label for="page_js"><?php esc_html_e( 'Custom JS', 'wolmart-core' ); ?></label>
			<div class="wolmart-editor">
				<textarea rows="10" name="page_js" id="page_js"><?php echo wp_strip_all_tags( get_post_meta( get_the_ID(), 'page_js', true ) ); ?></textarea>
			</div>
			<?php
		}
	}

	/**
	 * Update custom css, js from meta box
	 *
	 * @since 1.0
	 */
	public function update_page_custom_meta_box( $post_id, $post ) {
		if ( ! isset( $_POST['action'] ) || 'editpost' != $_POST['action'] ) {
			return;
		}

		// Custom CSS
		if ( isset( $_POST['page_css'] ) && $_POST['page_css'] ) {
			update_post_meta( $post_id, 'page_css', wp_strip_all_tags( $_POST['page_css'] ) );
		} else {
			delete_post_meta( $post_id, 'page_css' );
		}

		// Custom JS
		if ( current_user_can( 'unfiltered_html' ) ) {
			if ( isset( $_POST['page_js'] ) && $_POST['page_js'] ) {
				$page_js = str_replace( ']]>', ']]&gt;', $_POST['page_js'] );
				$page_js = preg_replace( '/<script.*?\/script>/s', '', $page_js ) ? : $page_js;
				$page_js = preg_replace( '/<style.*?\/style>/s', '', $page_js ) ? : $page_js;

				update_post_meta( $post_id, 'page_js', trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $page_js ) ) );
			} else {
				delete_post_meta( $post_id, 'page_js' );
			}
		}
	}
}

Wolmart_Admin_Meta_Boxes::get_instance();
