<?php
defined( 'ABSPATH' ) || die;

class Wolmart_RestAPI {
	public function __construct() {
		if ( class_exists( 'WC_REST_Products_Controller' ) ) {
			add_action( 'rest_api_init', array( $this, 'register_RestAPI' ) );
		}
	}

	public function register_RestAPI() {
		// Register router to get Woocommerce Products
		include_once WOLMART_CORE_PLUGINS . '/gutenberg/rest/class_products_controller.php';
		$controller = new Wolmart_Rest_Products_Controller();
		$controller->register_routes();

		register_rest_field(
			'post',
			'featured_image_src',
			array(
				'get_callback'    => array( $this, 'add_post_image' ),
				'update_callback' => null,
				'schema'          => null,
			)
		);

		register_rest_field(
			'post',
			'author_name',
			array(
				'get_callback'    => array( $this, 'add_post_author' ),
				'update_callback' => null,
				'schema'          => null,
			)
		);

		register_rest_field(
			'post',
			'category_names',
			array(
				'get_callback'    => array( $this, 'add_post_category' ),
				'update_callback' => null,
				'schema'          => null,
			)
		);

		register_rest_field(
			'post',
			'comment_count',
			array(
				'get_callback'    => array( $this, 'add_post_comment' ),
				'update_callback' => null,
				'schema'          => null,
			)
		);
	}

	function add_post_image( $object ) {
		$featured_img_full  = wp_get_attachment_image_src(
			$object['featured_media'],
			'full',
			false
		);
		$featured_img_large = wp_get_attachment_image_src(
			$object['featured_media'],
			'blog-large',
			false
		);
		$featured_img_list  = wp_get_attachment_image_src(
			$object['featured_media'],
			'blog-medium',
			false
		);
		$featured_img_grid  = wp_get_attachment_image_src(
			$object['featured_media'],
			'wolmart-post-small',
			false
		);

		return array(
			'full'      => $featured_img_full,
			'landsacpe' => $featured_img_large,
			'list'      => $featured_img_list,
			'grid'      => $featured_img_grid,
		);
	}

	function add_post_author( $object ) {
		return wolmart_strip_script_tags( get_the_author_meta( 'display_name' ) );
	}

	function add_post_category( $object ) {
		return wp_get_post_categories( $object['id'], array( 'fields' => 'names' ) );
	}

	function add_post_comment( $object ) {
		return get_comments_number( $object['id'] );
	}
}

new Wolmart_RestAPI;
