<?php
/**
 * Wolmart Image Comment Addon
 *
 * @since 1.0
 * @package Wolmart Addon
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Wolmart_Product_Image_Comment' ) ) {

	class Wolmart_Product_Image_Comment extends Wolmart_Base {

		/**
		 * Field name to be uploaded
		 *
		 * @since 1.0
		 * @access public
		 */
		public $field_name = 'wolmart_comment_images';

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
			add_action( 'after_setup_theme', array( $this, 'init' ) );
		}

		/**
		 * Constructor
		 *
		 * @since 1.0
		 * @access public
		 */
		public function init() {
			if ( function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'product_review_image_count' ) && 0 != wolmart_get_option( 'product_review_image_count' ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
				add_action( 'comment_form_submit_field', array( $this, 'add_file_input' ), 10 );
				add_action( 'delete_comment', array( $this, 'delete_image' ), 10 );
				add_action( 'woocommerce_review_after_comment_text', array( $this, 'display_images' ), 30 );
			}

			if ( count( $_FILES ) ) {
				add_filter( 'preprocess_comment', array( $this, 'validate_images' ), 10 );
				add_action( 'comment_post', array( $this, 'save_comment_images' ), 10, 3 );
			}
		}

		/**
		 * Get image mimetypes of comment attachments.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function get_image_mimetypes() {
			return apply_filters(
				'wolmart_product_comment_images_mimetypes',
				array(
					'jpg|jpeg' => 'image/jpeg',
					'png'      => 'image/png',
				)
			);
		}

		/**
		 * Enqueue script
		 *
		 * @since 1.0
		 * @access public
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'wolmart-product-image-comments', WOLMART_CORE_ADDONS_URI . '/product-image-comments/product-image-comments' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.js' : '.min.js' ), array( 'wolmart-theme' ), WOLMART_CORE_VERSION, true );
			wp_localize_script(
				'wolmart-product-image-comments',
				'wolmart_product_image_comments',
				apply_filters(
					'wolmart_product_image_comments',
					array(
						'mime_types'       => apply_filters( 'wolmart_product_comment_images_mimetypes', array( 'image/jpeg', 'image/png' ) ),
						'max_count'        => wolmart_get_option( 'product_review_image_count', 2 ),
						'max_size'         => $this->get_max_size(),
						// translators: %s represents count of images.
						'added_count_text' => esc_html__( 'Added %s images', 'wolmart-core' ),
						'error_msg'        => array(
							// translators: %s represents maximum file size.
							'size_error'      => sprintf( esc_html__( 'Maximum file size is %s', 'wolmart-core' ), $this->get_max_size( true ) ),
							// translators: %s represents maximum count of images.
							'count_error'     => sprintf( esc_html__( 'You can upload only up to %s images', 'wolmart-core' ), wolmart_get_option( 'product_review_image_count', 2 ) ), //phpcs:ignore
							// translators: %s represents image file formats.
							'mime_type_error' => sprintf( esc_html__( 'You are allowed to upload images only in %s formats.', 'wolmart-core' ), apply_filters( 'wolmart_product_comment_images_mimetypes', 'jpeg, png, jpg' ) ), //phpcs:ignore
						),
					)
				)
			);
		}


		/**
		 * Get Maximun size of file to be uploaded
		 *
		 * @since 1.0
		 * @access public
		 */
		public function get_max_size( $formatted = false ) {
			$max_size = (int) wolmart_get_option( 'product_review_image_size', 1 ) * MB_IN_BYTES;
			return $formatted ? size_format( $max_size ) : $max_size;
		}

		/**
		 * Get size of image to be attached to comment
		 *
		 * @since 1.0
		 * @access public
		 * @return array
		 */
		public function get_image_sizes() {
			$sizes = array( 'thumbnail' );

			return $sizes;
		}

		/**
		 * Get attached image ids as array
		 *
		 * @since 1.0
		 * @access public
		 * @param integer comment_id
		 */
		public function get_attached_image_ids_arr( $comment_id = 0 ) {
			if ( ! $comment_id ) {
				$comment    = get_comment();
				$comment_id = $comment ? $comment->comment_ID : '';
			}
			return explode( ',', get_comment_meta( $comment_id, $this->meta_key, true ) );
		}


		/**
		 * Check whether comment has images or not
		 *
		 * @since 1.0
		 * @access public
		 */
		public function has_attached_images( $comment_id = 0 ) {
			if ( ! $comment_id ) {
				$comment    = get_comment();
				$comment_id = $comment ? $comment->comment_ID : '';
			}

			$attached_image_ids_arr = $this->get_attached_image_ids_arr( $comment_id );

			if ( 1 == count( $attached_image_ids_arr ) && '' == $attached_image_ids_arr[0] ) {
				return false;
			}
			return true;
		}


		/**
		 * Add Input field with file type
		 *
		 * @since 1.0
		 * @access public
		 */
		public function add_file_input( $fields ) {

			if ( wolmart_is_product() ) {
				if ( is_user_logged_in() ) {
					$field_name = $this->field_name;
					$max_size   = $this->get_max_size();

					ob_start();
					?>
					<div class="wolmart-comment-images">
						<label for="wolmart-add-image" class="btn btn-link btn-underline">
							<?php esc_html_e( 'Upload Images', 'wolmart-core' ); ?>
							<i class="w-icon-withdraw"></i>
						</label>
						<span></span>
						<input id="wolmart-add-image" name="<?php echo esc_attr( $field_name ); ?>[]" type="file" multiple class="d-none"/>
					</div>
					<?php
					$fields .= ob_get_clean();

				} else {
					$fields = '<p class="comment-image-notice">' . esc_html__( 'You have to login to add images.', 'wolmart-core' ) . '</p>' . $fields;
				}
			}

			return $fields;
		}

		/**
		 * Check whether images are valid or not
		 *
		 * @since 1.0
		 * @access public
		 */
		public function validate_images( $comment_meta ) {

			$field_name = $this->field_name;
			if ( empty( $_FILES[ $field_name ] ) ) {
				return $comment_meta;
			}

			$max_count  = wolmart_get_option( 'product_review_image_count', 2 );
			$max_size   = $this->get_max_size();
			$files      = $_FILES[ $field_name ]; // phpcs:ignore
			$file_names = $files['name'];
			$file_sizes = $files['size'];

			if ( is_array( $file_names ) && count( $file_names ) > $max_count ) {
				// translators: maximum count of images.
				wp_die( sprintf( esc_html__( 'You can upload up to % s images to review', 'wolmart-core' ), $max_count ) );
			}

			foreach ( $file_sizes as $size ) {
				if ( $size > $max_size ) {
					// translators: maximum file size.
					wp_die( sprintf( esc_html__( 'Maximum file size is % s MB', 'wolmart-core' ), size_format( $max_size ) ) ); //phpcs:ignore
				}
			}

			add_filter( 'upload_mimes', array( $this, 'get_image_mimetypes' ), 50 );
			foreach ( $file_names as $name ) {
				if ( $name ) {
					$filetype = wp_check_filetype( $name );

					if ( ! $filetype['ext'] ) {
						// translators: allowed image file format.
						wp_die( sprintf( esc_html__( 'You are allowed to upload images only in % s formats . ', 'wolmart-core' ), apply_filters( 'wolmart_product_comment_images_mimetypes', 'png, jpeg' ) ) );
					}
				}
			}
			remove_filter( 'upload_mimes', array( $this, 'get_image_mimetypes' ), 50 );

			return $comment_meta;
		}


		/**
		 * Upload images
		 *
		 * @since 1.0
		 * @access public
		 */
		public function save_comment_images( $comment_id, $comment_approved, $comment ) {
			$files         = $_FILES[ $this->field_name ];
			$post_id       = $comment['comment_post_ID'];
			$post          = get_post( $post_id );
			$image_ids_str = '';

			if ( ! function_exists( 'media_handle_upload' ) ) {
				require_once ABSPATH . 'wp-admin/includes/image.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/media.php';
			}

			foreach ( $files['name'] as $key => $value ) {
				if ( $files['name'][ $key ] ) {
					$file    = array(
						'error'    => $files['error'][ $key ],
						'name'     => $files['name'][ $key ],
						'size'     => $files['size'][ $key ],
						'tmp_name' => $files['tmp_name'][ $key ],
						'type'     => $files['type'][ $key ],
					);
					$_FILES  = array( $this->field_name => $file );
					$title   = $file['name'];
					$dot_pos = strrpos( $title, '.' );
					if ( $dot_pos ) {
						$title = substr( $title, 0, $dot_pos );
					}

					// Upload image
					add_filter( 'intermediate_image_sizes', array( $this, 'get_image_sizes' ), 10 );
					$attachment_id = media_handle_upload(
						$this->field_name,
						$post_id,
						array(
							'post_title' => $title,
						)
					);
					remove_filter( 'intermediate_image_sizes', array( $this, 'get_image_sizes' ), 10 );

					// Check error
					if ( ! is_wp_error( $attachment_id ) ) {
						$image_ids_str .= $attachment_id . ',';
					}

					// Add alt text for attachement
					// translators: %1$s represents author name, %2$s represents product title.
					add_post_meta( $attachment_id, '_wp_attachment_image_alt', sprintf( esc_html__( 'Attachment image of %1$s\'s review on %2$s', 'wolmart-core' ), $comment['comment_author'], $post->post_title ), true );
				}
			}

			update_comment_meta( $comment_id, $this->meta_key, $image_ids_str );
		}


		/**
		 * Display attached images on comment
		 *
		 * @since 1.0
		 * @access public
		 */
		public function display_images( $comment_content ) {

			if ( ! $this->has_attached_images() || ( ! wolmart_is_product() && ! wolmart_doing_ajax() ) ) {
				return;
			}

			$image_ids = $this->get_attached_image_ids_arr();
			?>
			<div class="review-images">
				<?php
				foreach ( $image_ids as $image_id ) {
					if ( $image_id ) {
						$full_image = wp_get_attachment_image_src( $image_id, 'full' );
						if ( is_array( $full_image ) ) {
							echo wp_get_attachment_image(
								$image_id,
								'thumbnail',
								false,
								array(
									'data-img-src'    => esc_url( $full_image[0] ),
									'data-img-width'  => (int) $full_image[1],
									'data-img-height' => (int) $full_image[2],
								)
							);
						}
					}
				}
				?>
			</div>
			<?php
		}


		/**
		 * Delete Images from comment
		 *
		 * @since 1.0
		 * @access public
		 */
		public function delete_image( $comment_id ) {
			if ( ! $this->has_attached_images( $comment_id ) ) {
				return;
			}

			$image_ids = $this->get_attached_image_ids_arr( $comment_id );

			foreach ( $image_ids as $id ) {
				wp_delete_attachment( $id, true );
			}

			delete_comment_meta( $comment_id, $this->meta_key );
		}
	}
}

Wolmart_Product_Image_Comment::get_instance();
