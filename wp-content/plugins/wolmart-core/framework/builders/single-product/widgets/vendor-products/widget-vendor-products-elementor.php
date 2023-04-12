<?php
/**
 * Wolmart Elementor Single Product Linked Products Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;

class Wolmart_Single_Product_Vendor_Products_Elementor_Widget extends Wolmart_Products_Elementor_Widget {

	public function get_name() {
		return 'wolmart_sproduct_vendor_products';
	}

	public function get_title() {
		return esc_html__( 'Vendor Products', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-product-stock';
	}

	public function get_categories() {
		return array( 'wolmart_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'vendor', 'product', 'woocommerce', 'shop', 'store', 'vendor-products' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {
		parent::register_controls();

		$this->remove_control( 'ids' );
		$this->remove_control( 'categories' );

		$this->update_control(
			'status',
			array(
				'label'   => esc_html__( 'Product Status', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'vendor',
				'options' => array(
					'vendor' => esc_html__( 'Vendor Products', 'wolmart-core' ),
				),
			)
		);
	}

	protected function render() {
		if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {
			global $product, $post, $wolmart_layout;
			$author_id = get_post_field( 'post_author', $product->get_id() );
			wc_set_loop_prop( 'name', 'vendor_products' );
			?>
			<section class="more-seller-product products">
				<div class="title-wrapper title-left title-underline2">
					<h2 class="title title-link"><?php echo esc_html( wolmart_get_option( 'product_more_title' ) ); ?></h2>
					<?php
					if ( class_exists( 'WeDevs_Dokan' ) || ( class_exists( 'WCFM' ) && class_exists( 'WCFMmp' ) ) ) {
						$store_url = class_exists( 'WeDevs_Dokan' ) ? dokan_get_store_url( $author_id ) : wcfmmp_get_store_url( $author_id );
						?>
						<a class="btn btn-link btn-slide-right btn-infinite" href="<?php echo esc_url( $store_url ); ?>"><?php esc_html_e( 'More Products', 'wolmart-core' ); ?><i class="w-icon-long-arrow-right"></i></a>
						<?php
					}
					?>
				</div>
				<?php
				$function_product_author = function( $query_args ) use ( $author_id ) {
					$query_args['author'] = $author_id;
					return $query_args;
				};
				add_filter( 'woocommerce_shortcode_products_query', $function_product_author );
				parent::render();
				remove_filter( 'woocommerce_shortcode_products_query', $function_product_author );
			?>
			</section>
			<?php
			do_action( 'wolmart_single_product_builder_unset_product' );
		}
	}
}
