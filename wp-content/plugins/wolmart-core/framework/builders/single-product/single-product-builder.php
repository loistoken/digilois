<?php
/**
 * Wolmart_Single_Product_Builder class
 */
defined( 'ABSPATH' ) || die;

define( 'WOLMART_SINGLE_PRODUCT_BUILDER', WOLMART_BUILDERS . '/single-product' );

class Wolmart_Single_Product_Builder extends Wolmart_Base {

	public $widgets = array(
		'image',
		'navigation',
		'title',
		'meta',
		'rating',
		'price',
		'flash_sale',
		'excerpt',
		'cart_form',
		'share',
		'data_tab',
		'fbt',
		'linked_products',
		'vendor_products',
		'wishlist',
		'compare',
		'counter',
	);

	protected $post;
	protected $product           = false;
	protected $is_product_layout = false;

	public function __construct() {
		// setup builder
		add_action( 'init', array( $this, 'find_variable_product_for_preview' ) );  // for editor preview
		add_action( 'wp', array( $this, 'find_variable_product_for_preview' ), 1 ); // for template view
		add_action( 'wp', array( $this, 'setup_product_layout' ), 99 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 30 );

		// add woocommerce class to body
		add_filter( 'body_class', array( $this, 'add_body_class' ), 5 );

		// setup global $product
		add_action( 'wolmart_before_template', array( $this, 'set_post_product' ) );
		add_filter( 'wolmart_single_product_builder_set_product', array( $this, 'set_post_product' ) );
		add_action( 'wolmart_single_product_builder_unset_product', array( $this, 'unset_post_product' ) );

		// Use elementor widgets for single product
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
			add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
		}

		// Use WPBakery elements for single product
		if ( defined( 'WPB_VC_VERSION' ) ) {
			$this->register_wpb_elements();
		}

	}

	public function find_variable_product_for_preview() {

		if ( doing_action( 'wp' ) && 'wolmart_template' == get_post_type() ||
			doing_action( 'init' ) && ( wolmart_is_elementor_preview() || wolmart_is_wpb_preview() ) ) {

			$posts = get_posts(
				array(
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'posts_per_page'      => 100,
					'ignore_sticky_posts' => true,
				)
			);

			if ( ! empty( $posts ) ) {

				// find variable product
				foreach ( $posts as $post ) {
					$this->post    = $post;
					$this->product = wc_get_product( $post );

					if ( 'variable' == $this->product->get_type() ) {
						break;
					}
				}

				// if no variable product exists, get any product
				if ( ! $this->product ) {
					$this->post    = $posts[0];
					$this->product = wc_get_product( $posts[0] );
				}
			}
		}
	}

	public function setup_product_layout() {
		global $post;

		if ( ! empty( $post ) ) {
			if ( 'wolmart_template' != get_post_type() || 'product_layout' != get_post_meta( get_the_ID(), 'wolmart_template_type', true ) ) {
				$this->is_product_layout = false;
				$this->post              = null;
				$this->product           = null;
			}

			if (
				( 'wolmart_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, 'wolmart_template_type', true ) ) ||
				( defined( 'WOLMART_VERSION' ) && is_product() )
			) {
				$this->is_product_layout = true;
			}
		}
	}

	public function get_template() {
		if ( ! $this->is_product_layout ) {
			return false;
		}

		global $post;
		if ( 'wolmart_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, 'wolmart_template_type', true ) ) {
			return $post->ID;
		} else {
			global $wolmart_layout;
			if ( isset( $wolmart_layout['single_product_type'] ) && 'builder' == $wolmart_layout['single_product_type'] && is_numeric( $wolmart_layout['single_product_template'] ) ) {
				return $wolmart_layout['single_product_template'];
			} else {
				return 'default';
			}
		}

		return false;
	}

	public function set_post_product() {
		if ( ! is_product() && $this->product ) {
			global $post, $product;
			$post    = $this->post;
			$product = $this->product;
			setup_postdata( $this->post );
			add_filter( 'wolmart_is_product', '__return_true', 23 );
			return true;
		}
		return $this->is_product_layout;
	}

	public function unset_post_product() {
		if ( ! is_product() && $this->product ) {
			remove_filter( 'wolmart_is_product', '__return_true', 23 );
			wp_reset_postdata();
		}
	}

	public function enqueue_scripts() {
		if ( $this->product ) {
			wp_enqueue_style( 'wolmart-theme-single-product' );
			wp_enqueue_script( 'wc-single-product' );

			if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
				wp_enqueue_script( 'photoswipe-ui-default' );
				wp_enqueue_style( 'photoswipe-default-skin' );
				add_action( 'wp_footer', 'woocommerce_photoswipe' );
			}
		}
	}

	public function add_body_class( $classes ) {
		global $post;
		if ( ! empty( $post ) && $this->is_product_layout ) {
			$classes[] = 'woocommerce';
		}
		return $classes;
	}

	public function register_elementor_category( $self ) {
		global $post;

		if ( $post && 'wolmart_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, 'wolmart_template_type', true ) ) {
			$self->add_category(
				'wolmart_single_product_widget',
				array(
					'title'  => esc_html__( 'Wolmart Single Product', 'wolmart-core' ),
					'active' => true,
				)
			);
		}
	}

	public function register_elementor_widgets( $self ) {
		global $post, $product;

		if ( ( $post && 'wolmart_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, 'wolmart_template_type', true ) ) || ( isset( $product ) ) ) {
			foreach ( $this->widgets as $widget ) {
				wolmart_core_require_once( '/builders/single-product/widgets/' . str_replace( '_', '-', $widget ) . '/widget-' . str_replace( '_', '-', $widget ) . '-elementor.php' );
				$class_name = 'Wolmart_Single_Product_' . ucwords( $widget, '_' ) . '_Elementor_Widget';
				$self->register( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
			}
		}
	}

	public function register_wpb_elements() {
		global $post, $product;

		$post_id   = 0;
		$post_type = '';

		if ( $post ) {
			$post_id   = $post->ID;
			$post_type = $post->post_type;
		} elseif ( wolmart_is_wpb_preview() ) {
			if ( vc_is_inline() ) {
				$post_id   = isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : $_REQUEST['vc_post_id'];
				$post_type = get_post_type( $post_id );
			} elseif ( isset( $_REQUEST['post'] ) ) {
				$post_id   = $_REQUEST['post'];
				$post_type = get_post_type( $post_id );
			}
		}

		$elements = array();

		foreach ( $this->widgets as $widget ) {
			$elements[] = 'sp_' . $widget;
		}

		Wolmart_WPB::get_instance()->add_shortcodes( $elements, 'single-product' );
	}
}

Wolmart_Single_Product_Builder::get_instance();
