<?php
/**
 * Wolmart_Builder_Header class
 */
defined( 'ABSPATH' ) || die;

define( 'WOLMART_HEADER_BUILDER', WOLMART_BUILDERS . '/header' );

class Wolmart_Builder_Header extends Wolmart_Base {

	public $widgets = array(
		'cart',
		'language_switcher',
		'currency_switcher',
		'mmenu_toggle',
		'v_divider',
		'account',
		'wishlist',
		'compare',
		'search',
		'contact',
	);

	protected static $instance;

	public function __construct() {
		// Use elementor widgets for header builder
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
			add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
		}

		// Use WPBakery elements for header builder
		if ( defined( 'WPB_VC_VERSION' ) ) {
			$this->register_wpb_elements();
		}
	}

	public function register_elementor_category( $self ) {
		global $post, $wolmart_layout;

		$register = false;

		if ( is_admin() ) {
			if ( ! wolmart_is_elementor_preview() || ( $post && 'wolmart_template' == $post->post_type && 'header' == get_post_meta( $post->ID, 'wolmart_template_type', true ) ) ) {
				$register = true;
			}
		} else {
			if ( ! empty( $wolmart_layout['header'] ) && 'hide' != $wolmart_layout['header'] ) {
				$register = true;
			}
		}

		if ( $register ) {
			$self->add_category(
				'wolmart_header_widget',
				array(
					'title'  => esc_html__( 'Wolmart Header', 'wolmart-core' ),
					'active' => true,
				)
			);
		}
	}

	public function register_elementor_widgets( $self ) {
		global $post, $wolmart_layout;

		$register = $post && 'wolmart_template' == $post->post_type && 'header' == get_post_meta( $post->ID, 'wolmart_template_type', true );

		if ( ! $register ) {
			if ( is_admin() ) {
				if ( ! wolmart_is_elementor_preview() ) {
					$register = true;
				}
			} elseif ( ! empty( $wolmart_layout['header'] ) && 'hide' != $wolmart_layout['header'] ) {
				$register = true;
			}
		}

		if ( $register ) {
			sort( $this->widgets );

			foreach ( $this->widgets as $widget ) {
				wolmart_core_require_once( '/builders/header/widgets/' . str_replace( '_', '-', $widget ) . '/widget-' . str_replace( '_', '-', $widget ) . '-elementor.php' );
				$class_name = 'Wolmart_Header_' . ucwords( $widget, '_' ) . '_Elementor_Widget';
				$self->register( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
			}
		}
	}

	public function register_wpb_elements() {
		global $post;

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
			$elements[] = 'hb_' . $widget;
		}

		Wolmart_WPB::get_instance()->add_shortcodes( $elements, 'header' );
	}
}

Wolmart_Builder_Header::get_instance();
