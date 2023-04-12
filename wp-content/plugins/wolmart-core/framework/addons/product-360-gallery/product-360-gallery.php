<?php
/**
 * Wolmart Product 360 Degree Gallery Addon
 *
 * @since 1.0.0
 * @package Wolmart WordPress Plugin
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Wolmart_Product_360_Gallery' ) ) {

	class Wolmart_Product_360_Gallery extends Wolmart_Base {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			// Add metabox to add gallery images
			add_filter( 'rwmb_meta_boxes', array( $this, 'add_meta_boxes' ) );
			add_action( 'template_redirect', array( $this, 'add_frontend_actions' ) );
		}


		/**
		 * Get post meta and render it in product view
		 *
		 * @since 1.0.0
		 */
		public function add_frontend_actions() {
			$this->images = get_post_meta( get_the_ID(), 'wolmart_product_360_view', false );
			$images       = array();

			if ( $this->images ) {
				foreach ( $this->images as $image ) {
					$image_src = wp_get_attachment_image_src( $image, 'full' );
					if ( ! empty( $image_src[0] ) ) {
						$images[] = $image_src[0];
					}
				}
				$this->images = implode( ',', $images );

				add_action( 'wolmart_single_product_gallery_buttons', array( $this, 'get_degree_viewer_btn' ), 20 );
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
				add_filter( 'wolmart_vars', array( $this, 'add_images_var' ) );
			}
		}


		/**
		 * Add meta boxes
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function add_meta_boxes( $meta_boxes ) {

			$meta_boxes[] = array(
				'id'         => 'wolmart-product-360-view',
				'title'      => esc_html__( 'Product 360 View Gallery', 'wolmart-core' ),
				'post_types' => array( 'product' ),
				'context'    => 'side',
				'priority'   => 'low',
				'fields'     => array(
					array(
						'id'   => 'wolmart_product_360_view',
						'type' => 'image_advanced',
					),
				),
			);

			return $meta_boxes;
		}


		/**
		 * Load 360 degree viewer style & script
		 *
		 * @since 1.0.0
		 */
		public function enqueue_scripts() {

			wp_enqueue_style( 'wolmart-product-360-gallery', WOLMART_CORE_ADDONS_URI . '/product-360-gallery/product-360-gallery.min.css', null, WOLMART_CORE_VERSION, 'all' );
			wp_enqueue_script( 'three-sixty' );
			wp_enqueue_script( 'wolmart-product-360-gallery', WOLMART_CORE_ADDONS_URI . '/product-360-gallery/product-360-gallery' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.js' : '.min.js' ), array( 'wolmart-theme' ), WOLMART_CORE_VERSION, true );
		}


		/**
		 * Pass degree viewer images to js
		 *
		 * @since 1.0.0
		 */
		public function add_images_var( $vars ) {
			$vars['threesixty_data'] = $this->images;
			return $vars;
		}

		/**
		 * Print Degree viewer button in product image.
		 *
		 * @since 1.0.0
		 */
		public function get_degree_viewer_btn( $buttons ) {
			return $buttons . '<button class="product-gallery-btn open-product-degree-viewer w-icon-rotate-3d" title="' . esc_html__( 'Product 360 Degree Gallery', 'wolmart-core' ) . '"></button>';
		}
	}

}

Wolmart_Product_360_Gallery::get_instance();
