<?php
/**
 * Wolmart Image Comment Admin addon
 *
 * @since 1.0
 * @package Wolmart Addon
 */

// Direct access is denied
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Wolmart_Product_Image_Comment_Admin' ) ) {
	class Wolmart_Product_Image_Comment_Admin extends Wolmart_Base {

		/**
		 * Meta key for comment image
		 *
		 * @since 1.0
		 * @access public
		 */
		public $meta_key = '_wolmart_comment_image';

		/**
		 * Constructor
		 *
		 * @since 1.0
		 * @access public
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'add_meta_boxes_comment', array( $this, 'add_metaboxes' ) );
			add_action( 'edit_comment', array( $this, 'save_comment_meta' ), 10, 2 );
		}

		/**
		 * Enqueue scripts
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'wolmart-product-image-comments-admin', WOLMART_CORE_ADDONS_URI . '/product-image-comments/product-image-comments-admin.js', array(), WOLMART_CORE_VERSION, true );
		}

		/**
		 * Get the comment ID
		 *
		 * @since 1.0
		 * @access public
		 */
		public function get_the_comment_id() {
			$comment = get_comment();

			if ( ! $comment ) {
				return '';
			}

			return $comment->comment_ID;
		}


		/**
		 * Add comment metaboxes
		 *
		 * @since 1.0
		 * @access public
		 */
		public function add_metaboxes() {
			add_meta_box( 'wolmart-comment-images-metabox', esc_html__( 'Wolmart Comment Images', 'wolmart-core' ), array( $this, 'render' ), null, 'normal', 'low' );
		}


		/**
		 * Save comment meta
		 *
		 * @since 1.0
		 * @access public
		 */
		public function save_comment_meta( $comment_id, $data ) {
			if ( isset( $_POST[ $this->meta_key ] ) ) {
				$value = sanitize_text_field( $_POST[ $this->meta_key ] );
				update_comment_meta( $comment_id, $this->meta_key, $value );
			}
		}


		/**
		 * Render meta field layout to add metaboxes
		 *
		 * @since 1.0
		 * @access public
		 */
		public function render() {
			$comment_id  = $this->get_the_comment_id();
			$img_ids     = get_comment_meta( $comment_id, $this->meta_key, true );
			$img_ids_arr = explode( ',', $img_ids );

			?>
			<div class="wolmart-comment-meta-box-layout">
				<div class="wolmart-comment-img-preview-area">
					<?php
					$i = 0;
					while ( $i < count( $img_ids_arr ) ) :
						$image_data = wp_get_attachment_image_src( $img_ids_arr[ $i ], 'full' );
						$link       = is_array( $image_data ) && $image_data[0];
						if ( '' != $img_ids_arr[ $i ] ) :
							?>
						<div class="comment-img-wrapper" data-attachment_id="<?php echo esc_attr( $img_ids_arr[ $i ] ); ?>">
							<?php
							echo wp_get_attachment_image(
								$img_ids_arr[ $i ],
								'thumbnail',
								array(
									'class' => 'wolmart-gallery-image',
								)
							);
							?>
							<a href="#" class="button-image-remove"><i class="fa fa-times"></i></a>
						</div>
							<?php
						endif;
						$i ++;
						endwhile;
					?>
				</div>

				<div class="wolmart-comment-action-wrapper">
					<button id="wolmart-comment-image-upload-btn" class="button-image-upload button button-primary">Upload</button>
					<input type="hidden" class="wolmart-upload-input" name="<?php echo esc_attr( $this->meta_key ); ?>" value="<?php echo esc_attr( $img_ids ); ?>"/>
				</div>
			</div>
			<?php
		}
	}
}

Wolmart_Product_Image_Comment_Admin::get_instance();
