<?php
/**
 * Wolmart Restful API
 *
 * @package Wolmart WordPress Framework
 * @version 1.0
 */
defined( 'ABSPATH' ) || die;

class Wolmart_Rest_Api {

	/**
	 * Ajax Request
	 *
	 * @since 1.0
	 * @access protected
	 */
	protected $request = [];

	/**
	 * Post types
	 *
	 * @since 1.0
	 * @access public
	 */
	public $post_types = [ 'post', 'page', 'product', 'block' ];


	/**
	 * Taxonomies
	 *
	 * @since 1.0
	 * @access public
	 */
	public $taxonomies = [ 'category', 'product_cat', 'product_brand' ];


	/**
	 * Get method from request and implement it
	 *
	 * @since 1.0
	 */
	public function get_action( $request ) {
		if ( isset( $request['method'] ) ) {
			$this->request = $request;
			// return $this->{$request['method']}();

			if ( in_array( $request['method'], $this->post_types ) ) {
				return $this->get_archives( $request['method'] );
			} elseif ( in_array( $request['method'], $this->taxonomies ) ) {
				return $this->get_taxonomies( $request['method'] );
			} else {
				return $this->get_vendors();
			}
		}
	}


	/**
	 * Get vendor list
	 *
	 * @since 1.0
	 * @access public
	 */
	public function get_vendors() {
		$query_args = [];
		if ( isset( $this->request['ids'] ) ) {
			$ids                   = $this->request['ids'];
			$query_args['include'] = $ids;
			$query_args['orderby'] = 'include';

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}

		if ( isset( $this->request['s'] ) ) {
			$query_args['s'] = $this->request['s'];
		}

		$options = wolmart_get_vendors( $query_args );

		return [ 'results' => $options ];
		wp_reset_postdata();
	}


	/**
	 * Get Archives
	 *
	 * @since 1.0
	 * @access public
	 */
	public function get_archives( $post_type = 'post' ) {
		if ( 'block' == $post_type ) {
			$query_args = array(
				'post_type'      => 'wolmart_template',
				'post_status'    => 'publish',
				'meta_key'       => 'wolmart_template_type',
				'meta_value'     => $post_type,
				'posts_per_page' => 15,
			);

		} else {
			$query_args = array(
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => 15,
			);
		}

		if ( isset( $this->request['ids'] ) ) {
			$ids                    = explode( ',', $this->request['ids'] );
			$query_args['post__in'] = $ids;
			$query_args['orderby']  = 'post__in';

			if ( '' == $this->request['ids'] ) {
				return array(
					'result' => [],
				);
			}
		}

		if ( isset( $this->request['s'] ) ) {
			$query_args['s'] = $this->request['s'];
		}

		$query = new WP_Query( $query_args );

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$options[] = [
					'id'   => $post->ID,
					'text' => $post->post_title,
				];
			}
		endif;
		return [ 'results' => $options ];
		wp_reset_postdata();
	}

	/**
	 * Get Taxonomies
	 *
	 * @since 1.0
	 * @access public
	 */
	public function get_taxonomies( $taxonomy = 'category' ) {
		$query_args = array(
			'taxonomy'   => [ $taxonomy ],
			'hide_empty' => false,
		);

		if ( isset( $this->request['ids'] ) ) {
			$ids                   = explode( ',', $this->request['ids'] );
			$query_args['include'] = $ids;
			$query_args['orderby'] = 'include';

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}
		if ( isset( $this->request['s'] ) ) {
			$query_args['name__like'] = $this->request['s'];
		}

		$terms = get_terms( $query_args );

		$options = [];
		$count   = count( $terms );
		if ( $count > 0 ) :
			foreach ( $terms as $term ) {
				$options[] = [
					'id'   => $term->term_id,
					'text' => htmlspecialchars_decode( $term->name ),
				];
			}
		endif;
		return [ 'results' => $options ];
	}
}

/**
 * Get an instance of Wolmart_Rest_Api and
 * call an action
 *
 * @since 1.0
 */
function wolmart_ajax_select_api( WP_REST_Request $request ) {
	$api = new Wolmart_Rest_Api();
	return $api->get_action( $request );
}

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'ajaxselect2/v1',
			'/(?P<method>\w+)/',
			array(
				'methods'             => 'GET',
				'callback'            => 'wolmart_ajax_select_api',
				'permission_callback' => '__return_true',
			)
		);
	}
);
