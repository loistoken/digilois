<?php
/**
 * Wolmart Product Video Popup
 *
 * @since 1.0
 * @package Wolmart WordPress Framework
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Wolmart_Product_Video_Popup' ) ) {

	class Wolmart_Product_Video_Popup extends Wolmart_Base {

		/**
		 * Video
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public $video_code = '';


		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			add_filter( 'rwmb_meta_boxes', array( $this, 'add_meta_boxes' ) );
			add_action( 'template_redirect', array( $this, 'add_front_end_actions' ) );
		}


		/**
		 * Add metaboxes to add video
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function add_meta_boxes( $meta_boxes ) {
			$meta_boxes[] = array(
				'id'         => 'wolmart-product-videos',
				'title'      => esc_html__( 'Product Video', 'wolmart-core' ),
				'post_types' => array( 'product' ),
				'context'    => 'side',
				'priority'   => 'low',
				'fields'     => array(
					array(
						'name' => esc_html__( 'Video URL', 'wolmart-core' ),
						'id'   => 'wolmart_product_video_popup_url',
						'type' => 'input',
						'std'  => false,
						'desc' => esc_html__( 'Enter URL of Youtube or Vimeo or specific filetypes such as mp4, webm, ogv.', 'wolmart-core' ),
					),
				),
			);

			return $meta_boxes;
		}


		/**
		 * Hooks to render video popup in frontend
		 *
		 * @since 1.0.0
		 * @version 1.1.6 Fix youtube video popup issue.
		 *
		 * @access public
		 */
		public function add_front_end_actions() {
			$video_url = get_post_meta( get_the_ID(), 'wolmart_product_video_popup_url', true );

			if ( $video_url && filter_var( $video_url, FILTER_VALIDATE_URL ) ) {

				// In Youtube case.
				if ( false !== strpos( $video_url, 'youtube.com' ) ) {
					$this->video_code = '<iframe src="' . esc_url( $video_url . '?autoplay=1&loop=1' ) . '"></iframe>';
				} else {
						// To use default browser's video player.
						$this->video_code = do_shortcode( '[video src="' . esc_url( $video_url ) . '" ]' );
				}

				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
				add_action( 'wolmart_single_product_gallery_buttons', array( $this, 'get_video_viewer_btn' ), 20 );
				add_filter( 'wolmart_vars', array( $this, 'add_video_var' ) );
			}
		}


		/**
		 * Load product video popup script.
		 *
		 * @since 1.0
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'jquery-fitvids' );
			wp_enqueue_script( 'wolmart-product-video-popup', WOLMART_CORE_ADDONS_URI . '/product-video-popup/product-video-popup.js', array( 'wolmart-theme-async' ), WOLMART_VERSION, true );
		}


		/**
		 * Pass degree viewer images to js.
		 *
		 * @since 1.0
		 */
		public function add_video_var( $vars ) {
			$vars['wvideo_data'] = $this->video_code;
			return $vars;
		}

		/**
		 * Print Video view button in product image.
		 *
		 * @since 1.0
		 */
		public function get_video_viewer_btn( $buttons ) {
			return $buttons . '<button class="product-gallery-btn open-product-video-viewer w-icon-movie" title="' . esc_html__( 'Product Video Thumbnail', 'wolmart-core' ) . '"></button>';
		}
	}
}

Wolmart_Product_Video_Popup::get_instance();
