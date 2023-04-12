<?php
/**
 * Initialize WPBakery
 *
 * @since 1.0.0
 */

// direct load is not allowed
defined( 'ABSPATH' ) || die;

if ( ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

// WP Bakery
define( 'WOLMART_CORE_WPB', WOLMART_CORE_PLUGINS . '/wpb' );

if ( ! class_exists( 'Wolmart_WPB' ) ) :
	class Wolmart_WPB extends Wolmart_Base {

		/**
		 * Is WPBakery?
		 *
		 * @since 1.0.0
		 * @var boolean $is_wpb
		 */
		public static $is_wpb = true;

		/**
		 * Shortcodes
		 *
		 * @since 1.0.0
		 * @var array $shortcodes Array of custom shortcodes
		 */
		public $shortcodes;

		/**
		 * Params
		 *
		 * @since 1.0.0
		 * @var array $params Array of custom control names
		 */
		public static $params = array(
			'button-group',
			'color-group',
			'number',
			'dimension',
			'heading',
			'typography',
			'multiselect',
			'responsive',
			'datetimepicker',
			'dropdown',
		);

		/**
		 * Dimension Patterns
		 *
		 * @since 1.0.0
		 * @var array $dimensions
		 */
		public static $dimensions = array(
			'top'    => '{{TOP}}',
			'right'  => '{{RIGHT}}',
			'bottom' => '{{BOTTOM}}',
			'left'   => '{{LEFT}}',
		);

		public function __construct() {
			require_once WOLMART_CORE_WPB . '/core-wpb-functions.php';

			$this->shortcodes = array(
				'button',
				'heading',
				'hotspot',
				'carousel',
				'banner',
				'banner_layer',
				'block',
				'breadcrumb',
				'testimonial',
				'logo',
				'masonry',
				'masonry_item',
				'infobox',
				'counter',
				'countdown',
				'menu',
				'posts_grid',
				'posts_slider',
				'images_grid',
				'images_slider',
				'images_masonry',
				'image_box',
				'videopopup',
				'videoplayer',
				'share_icons',
				'share_icon',
				'icon_list',
				'icon_list_item',
				'tab',
				'tab_item',
				'accordion',
				'accordion_item',
				'floating_wrapper',
				'wrapper',
			);

			if ( class_exists( 'WooCommerce' ) ) {
				$this->shortcodes = array_merge(
					$this->shortcodes,
					array(
						'subcategories',
						'categories_grid',
						'categories_slider',
						'categories_masonry',
						'products_grid',
						'products_slider',
						'products_masonry',
						'singleproducts',
						'brands',
						'wp_product_categories',
						'filter',
						'filter_item',
						'products_layout',
						'products_banner_item',
						'products_single_item',
					)
				);
			}

			if ( class_exists( 'WeDevs_Dokan' ) || class_exists( 'WCMp' ) || class_exists( 'WCFM' ) || class_exists( 'WC_Vendors' ) ) {
				$this->shortcodes = array_merge(
					$this->shortcodes,
					array(
						'vendor',
					)
				);
			}

			$this->add_shortcodes();

			// registers wolmart addons for wpb page builder including studio, resize, template condition
			add_filter( 'vc_nav_controls', array( $this, 'add_addon_list_html' ) );
			add_filter( 'vc_nav_front_controls', array( $this, 'add_addon_list_html' ) );

			// trick to run BuilderAddons function in admin.js
			if ( wolmart_is_wpb_preview() ) {
				add_filter( 'wolmart_builder_addon_html', array( $this, 'add_addon_html_to_vars' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'editor_scripts' ) );
			}

			add_filter( 'vc_base_build_shortcodes_custom_css', array( $this, 'add_shortcodes_custom_css' ), 10, 2 );

			foreach ( $this::$params as $param ) {
				require_once WOLMART_CORE_WPB . '/params/' . $param . '.php';
			}

			require_once WOLMART_CORE_WPB . '/existing.php';

			if ( vc_is_inline() ) {
				wolmart_remove_all_admin_notices();
			}

			// Init Google Fonts
			$this->init_google_fonts();

			// Init Wolmart Icons
			$this->init_wolmart_icons();

			add_action( 'wp_ajax_vc_save', array( $this, 'save_custom_panel_options' ), 9 );
			add_action( 'save_post', array( $this, 'save_custom_panel_options' ), 1 );

			add_action( 'wolmart_before_enqueue_theme_style', array( $this, 'add_global_css' ) );
			add_action( 'wolmart_after_enqueue_theme_style', array( $this, 'add_wpb_css' ) );

			// Change load ordering of custom & shortcode css
			add_action(
				'template_redirect',
				function() {
					remove_action( 'wp_head', array( Vc_Manager::getInstance()->vc(), 'addFrontCss' ), 1000 );
					add_action(
						get_theme_mod( 'resource_merge_stylesheets' ) ? 'wp_footer' : 'wp_head', // Enqueue custom CSS in footer when merge stylesheets option is enabled.
						function() {
							$wpb = Vc_Manager::getInstance()->vc();
							$wpb->addShortcodesCustomCss();
							$wpb->addPageCustomCss();
						},
						1000
					);
				}
			);

			// lazy load background images for wpbakery page builder.
			add_action( 'wp_enqueue_scripts', array( $this, 'init_vc_custom_styles' ), 8 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_vc_editor_preview_style' ), 999 );
		}

		/**
		 * Init Wolmart Icons
		 *
		 * @since 1.0.0
		 */
		public function init_wolmart_icons() {
			require_once WOLMART_CORE_WPB . '/lib/icons.php';
			add_action(
				'admin_enqueue_scripts',
				function() {
					if ( wolmart_is_wpb_preview() && defined( 'WOLMART_VERSION' ) ) {
						wp_enqueue_style( 'wolmart-icons', WOLMART_ASSETS . '/vendor/wolmart-icons/css/icons.min.css', array(), WOLMART_VERSION );
					}
				}
			);
		}

		/**
		 * Enqueue wpb editor style and script
		 *
		 * @since 1.0.0
		 */
		public function editor_scripts() {
			wp_enqueue_style( 'wolmart-js-composer-editor', WOLMART_CORE_PLUGINS_URI . '/wpb/assets/wpb-admin' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), WOLMART_VERSION );
			wp_enqueue_script( 'wolmart-wpb-admin-js', WOLMART_CORE_PLUGINS_URI . '/wpb/assets/wpb-admin' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.js' : '.min.js' ), array(), WOLMART_CORE_VERSION, true );

			$wpb_backend_ajax = false;
			if ( defined( 'WPB_VC_VERSION' ) && ! empty( $_REQUEST['post'] ) && ( 'post-new.php' == $GLOBALS['pagenow'] || 'post.php' == $GLOBALS['pagenow'] ) ) {
				$post_type = get_post_type( $_REQUEST['post'] );
				if ( ( 'page' == $post_type ) || ( 'wolmart_template' == $post_type ) ) {
					$wpb_backend_ajax = true;
				}
			}

			wp_localize_script(
				'wolmart-wpb-admin-js',
				'wolmart_wpb_admin_vars',
				apply_filters(
					'wolmart_core_wpb_admin_localize_vars',
					array(
						'ajax_url'         => esc_url( admin_url( 'admin-ajax.php' ) ),
						'wpb_backend_ajax' => $wpb_backend_ajax,
					)
				)
			);
		}
		/**
		 * Init Google Fonts
		 *
		 * @since 1.0.0
		 */
		public function init_google_fonts() {
			// Backend Editor Save
			add_action(
				'save_post',
				function( $id ) {
					if ( ! vc_user_access()->wpAny(
						array(
							'edit_post',
							$id,
						)
					)->get() ) {
						return;
					}
					$this->save_google_fonts( $id );
				},
				99
			);
			// Frontend Editor Save
			add_action(
				'wp_ajax_vc_save',
				function() {
					$post_id = intval( vc_post_param( 'post_id' ) );
					vc_user_access()->checkAdminNonce()->validateDie()->wpAny( 'edit_posts', 'edit_pages' )->validateDie()->canEdit( $post_id )->validateDie();

					if ( $post_id > 0 ) {
						$this->save_google_fonts( $post_id );
					}
				},
				99
			);
		}

		/**
		 * add_addon_list_html
		 *
		 * registers wolmart addons for wpb page builder including below items
		 * - studio
		 * - edit area resize
		 * - template condition
		 * - popup options
		 *
		 * @since 1.0.0
		 * @param array $list
		 */
		public function add_addon_list_html( $list ) {
			$html  = '<li class="wolmart-wpb-addons">';
			$html .= '<a class="vc_icon-btn wolmart-wpb-addons-trigger" title="' . esc_html( 'Wolmart Addons', 'wolmart-core' ) . '"><span class="vc-composer-icon wolmart-mini-logo"></span></a>';
			$html .= '<ul class="dropdown wolmart-addons-dropdown">';

			$html .= '<li><a id="wpb-wolmart-studio-trigger" class="wolmart-wpb-addon-item"><i class="fas fa-layer-group"></i>' . esc_html( 'Wolmart Studio', 'wolmart-core' ) . '</a></li>';

			$post_type          = get_post_type( get_the_ID() );
			$post_type_category = get_post_meta( get_the_ID(), 'wolmart_template_type', true );

			if ( 'wolmart_template' == $post_type && 'popup' == $post_type_category ) {
				$html .= '<li><a id="wolmart-popup-options" class="wolmart-wpb-addon-item"><i class="far fa-sun"></i>' . esc_html( 'Popup Options', 'wolmart-core' ) . '</a></li>';

				$this->add_custom_panel( 'popup_panel', 'vc_ui-panel-popup-options.tpl.php' );
			}

			$html  .= '</ul>';
			$html  .= '</li>';
			$list[] = array( 'wolmart_addon', $html );
			return $list;
		}

		/**
		 * add_custom_panel
		 *
		 * adds custom panel to frontend and backend
		 *
		 * @since 1.0.0
		 */
		public function add_custom_panel( $id, $template ) {
			add_filter(
				'vc_path_filter',
				function( $path ) use ( $id, $template ) {
					if ( false !== strpos( $path, 'editors/popups/class-vc-post-settings.php' ) ) {
						add_filter(
							'wolmart_core_admin_localize_vars',
							function( $vars ) use ( $id, $template ) {
								if ( empty( $vars['wpb_preview_panels'] ) ) {
									$vars['wpb_preview_panels'] = array();
								}
								ob_start();
								include WOLMART_CORE_WPB . '/panels/' . $template;
								$vars['wpb_preview_panels'][ $id ] = ob_get_clean();
								return $vars;
							}
						);
					}

					return $path;
				}
			);
		}

		/**
		 * save_custom_panel_options
		 *
		 * saves custom panel options on ajax save event
		 * - popup options
		 * - edit area size
		 * - page css
		 *
		 * @since 1.0.0
		 */
		public function save_custom_panel_options( $post_id ) {
			if ( isset( $post_id ) && is_numeric( $post_id ) ) { // post save
				// save popup options
				if ( ! empty( $_POST['wolmart_popup_options'] ) ) {
					update_post_meta( $post_id, 'popup_options', $_POST['wolmart_popup_options'] );
				}
			} else { // ajax save
				$post_id = intval( vc_post_param( 'post_id' ) );
				vc_user_access()->checkAdminNonce()->validateDie()->wpAny( 'edit_posts', 'edit_pages' )->validateDie()->canEdit( $post_id )->validateDie();

				// save popup options
				$popup_options = vc_post_param( 'wolmart_popup_options' );
				if ( $post_id > 0 && ! empty( $popup_options ) ) {
					update_post_meta( $post_id, 'popup_options', $popup_options );
				}

				// save page css
				$page_css = vc_post_param( 'pageCss' );
				if ( $post_id > 0 && isset( $page_css ) ) {
					update_post_meta( $post_id, 'page_css', wp_slash( $page_css ) );
				}
			}
		}

		/**
		 * add_addon_html_to_vars
		 *
		 * tricks to run BuilderAddons function in admin.js
		 *
		 * @since 1.0.0
		 * @param array $html
		 */
		public function add_addon_html_to_vars( $html ) {
			$html[] = array(
				'wpb' => '',
			);

			return $html;
		}

		/**
		 * add_global_css
		 *
		 * enqueue JS Composer default style in header
		 *
		 * @since 1.0.0
		 */
		public function add_global_css() {
			if ( ! wp_style_is( 'js_composer_front' ) ) {
				wp_enqueue_style( 'js_composer_front' );
			}

			// WPBakery Page Builder
			$used_wpb_shortcodes = function_exists( 'wolmart_get_option' ) ? wolmart_get_option( 'used_wpb_shortcodes', false ) : get_theme_mod( 'used_wpb_shortcodes', false );
			if ( ! empty( $used_wpb_shortcodes ) && ! wolmart_is_wpb_preview() ) {
				$upload_dir = wp_upload_dir();
				$upload_url = $upload_dir['baseurl'];
				$css_file   = $upload_dir['basedir'] . '/wolmart_styles/js_composer.css';
				if ( file_exists( $css_file ) ) {
					$inline_styles = wp_styles()->get_data( 'js_composer_front', 'after' );
					wp_deregister_style( 'js_composer_front' );
					wp_dequeue_style( 'js_composer_front' );
					wp_enqueue_style( 'js_composer_front', $upload_url . '/wolmart_styles/js_composer.css', array(), WOLMART_VERSION );
					if ( ! empty( $inline_styles ) ) {
						$inline_styles = implode( "\n", $inline_styles );
						wp_add_inline_style( 'js_composer_front', $inline_styles );
					}
				}
			}

			if ( defined( 'WOLMART_VERSION' ) ) {
				wp_enqueue_style( 'wolmart-animation', WOLMART_ASSETS . '/vendor/animate/animate.min.css' );
			}
		}

		/**
		 * add_wpb_css
		 *
		 * enqueue JS Composer default style in header
		 *
		 * @since 1.0.0
		 */
		public function add_wpb_css() {

			wp_enqueue_style( 'wolmart-wpb-style', WOLMART_PLUGINS_URI . '/wpb/wpb' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );

			// load block css
			global $wolmart_layout;
			$wolmart_layout['used_blocks'] = wolmart_get_page_blocks();

			if ( ! empty( $wolmart_layout['used_blocks'] ) ) {
				foreach ( $wolmart_layout['used_blocks'] as $block_id => $enqueued ) {
					if ( ! ( wolmart_is_wpb_preview() && isset( $_REQUEST['post_id'] ) && $_REQUEST['post_id'] == $block_id ) ) {
						$block_css  = get_post_meta( (int) $block_id, '_wpb_shortcodes_custom_css', true );
						$block_css .= get_post_meta( (int) $block_id, '_wpb_post_custom_css', true );
						$block_css .= get_post_meta( (int) $block_id, 'page_css', true );

						if ( $block_css ) {
							$block_css = function_exists( 'wolmart_minify_css' ) ? wolmart_minify_css( $block_css ) : $block_css;
						}

						wp_add_inline_style( 'wolmart-style', $block_css );
						$wolmart_layout['used_blocks'][ $block_id ]['css'] = true;
					}
				}
			}
		}

		/**
		 * Save used google fonts list
		 *
		 * @since 1.0.0
		 *
		 * @param integer $id
		 */
		public function save_google_fonts( $id ) {
			$post  = get_post( $id );
			$fonts = $this->get_google_fonts( $post->post_content );

			if ( ! empty( $fonts ) ) {
				update_post_meta( $id, 'wolmart_vc_google_fonts', rawurlencode( json_encode( $fonts ) ) );
			}
		}

		/**
		 * Get used google fonts
		 *
		 * @since 1.0.0
		 *
		 * @param string $content
		 */
		public function get_google_fonts( $content ) {
			$fonts = array();

			WPBMap::addAllMappedShortcodes();
			preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );

			foreach ( $shortcodes[2] as $index => $tag ) {
				// Get attributes
				$atts      = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
				$shortcode = WPBMap::getShortCode( $tag );
				if ( ! empty( $shortcode['params'] ) ) {
					foreach ( $shortcode['params'] as $param ) {
						if ( 'wolmart_typography' === $param['type'] ) {
							if ( ! empty( $param['param_name'] ) && ! empty( $atts[ $param['param_name'] ] ) ) {
								$typography = json_decode( str_replace( '``', '"', $atts[ $param['param_name'] ] ), true );
								$font       = array();

								if ( ! empty( $typography['family'] ) && 'Inherit' != $typography['family'] && 'Default' != $typography['family'] ) {
									if ( 'regular' == $typography['variant'] ) {
										$typography['variant'] = '400';
									}
									if ( empty( $fonts[ $typography['family'] ] ) ) {
										$font[ $typography['family'] ] = array( $typography['variant'] );
										$fonts                         = array_merge( $fonts, $font );
									} else {
										if ( ! in_array( $typography['variant'], $fonts[ $typography['family'] ] ) ) {
											$fonts[ $typography['family'] ][] = $typography['variant'];
										}
									}
								}
							}
						}
					}
				}
			}

			foreach ( $shortcodes[5] as $shortcode_content ) {
				$fonts = array_merge_recursive( $fonts, $this->get_google_fonts( $shortcode_content ) );
			}

			return $fonts;
		}

		/**
		 * Add Shortcodes
		 *
		 * @since 1.0.0
		 */
		public function add_shortcodes( $shortcodes = array(), $path = 'elements' ) {

			require_once WOLMART_CORE_FRAMEWORK . '/core-functions.php';
			require_once WOLMART_CORE_WPB . '/partials/extra.php';
			require_once WOLMART_CORE_WPB . '/partials/design-option.php';

			$is_wpb = defined( 'WPB_VC_VERSION' );
			$left   = is_rtl() ? 'right' : 'left';
			$right  = 'left' == $left ? 'right' : 'left';

			if ( empty( $shortcodes ) ) {
				$shortcodes = $this->shortcodes;
			}

			foreach ( $shortcodes as $shortcode ) {
				if ( 'sp_fbt' == $shortcode || 'sp_vendor_products' == $shortcode ) {
					continue;
				}
				$callback = function( $atts, $content = null ) use ( $shortcode, $path ) {

					ob_start();

					$style_class = '';
					if ( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ) {
						if ( isset( $atts['css'] ) ) {
							$style_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), 'wpb_wolmart_' . $shortcode, $atts );
						}
					}
					// Frontend editor
					if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
						$style_array = $this->wolmart_generate_shortcode_css( 'wpb_wolmart_' . $shortcode, $atts );

						$style = '<style>';

						foreach ( $style_array as $key => $value ) {
							if ( 'responsive' == $key ) {
								$style .= $value;
							} else {
								$style .= $key . '{' . $value . '}';
							}
						}

						$style .= '</style>';
						wolmart_filter_inline_css( $style );

						// Google Fonts
						$weights = array();
						$sc      = WPBMap::getShortCode( 'wpb_wolmart_' . $shortcode );
						if ( ! empty( $sc['params'] ) ) {
							foreach ( $sc['params'] as $param ) {
								if ( ! empty( $param['type'] ) && 'wolmart_typography' === $param['type'] ) {
									if ( isset( $atts[ $param['param_name'] ] ) ) {
										$typography = json_decode( str_replace( '``', '"', $atts[ $param['param_name'] ] ), true );
										$font       = array();

										if ( ! empty( $typography['family'] ) && 'Inherit' != $typography['family'] && 'Default' != $typography['family'] ) {
											if ( empty( $weights[ $typography['family'] ] ) ) {
												$font[ $typography['family'] ] = array( $typography['variant'] );
												$weights                       = array_merge( $weights, $font );
											} else {
												if ( ! in_array( $typography['variant'], $weights[ $typography['family'] ] ) ) {
													$weights[ $typography['family'] ][] = $typography['variant'];
												}
											}
										}
									}
								}
							}
						}

						foreach ( $weights as $family => $weight ) {
							$fonts[] = str_replace( ' ', '+', $family ) . ':' . implode( ',', $weight );
						}

						if ( ! empty( $fonts ) ) {
							wp_enqueue_style( strtolower( implode( '', $fonts ) ), esc_url( '//fonts.googleapis.com/css?family=' . implode( '%7C', $fonts ) ) );
						}
					}

					// Shortcode class
					if ( empty( $atts ) ) {
						$atts = array();
					}
					$atts['tag']             = 'wpb_wolmart_' . $shortcode;
					$atts['shortcode']       = $shortcode;
					$atts['shortcode_class'] = '';
					$atts['style_class']     = $style_class;
					$atts['content']         = $content;
					$sc                      = WPBMap::getShortCode( 'wpb_wolmart_' . $shortcode );

					if ( ! empty( $sc['params'] ) ) {
						$atts['shortcode_class'] = ' wpb_custom_' . wolmart_get_global_hashcode( $atts, 'wpb_wolmart_' . $shortcode, $sc['params'] );
					}

					$shortcode_filename = str_replace( '_', '-', $shortcode );
					if ( 'hb-' == substr( $shortcode_filename, 0, 3 ) || 'sp-' == substr( $shortcode_filename, 0, 3 ) ) {
						$shortcode_filename = substr( $shortcode_filename, 3 );
					}
					$prefix = $shortcode_filename;
					if ( 'elements' == $path ) {
						if ( 'banner' == substr( $shortcode_filename, 0, 6 ) ) {
							$prefix = 'banner';
						} elseif ( 'posts' == substr( $shortcode_filename, 0, 5 ) ) {
							$prefix = 'posts';
						} elseif ( 'images' == substr( $shortcode_filename, 0, 6 ) ) {
							$prefix = 'image-gallery';
						} elseif ( 'products' == substr( $shortcode_filename, 0, 8 ) ) {
							$prefix = 'products';
						} elseif ( 'video' == substr( $shortcode_filename, 0, 5 ) ) {
							$prefix = 'video';
						} elseif ( 'share' == substr( $shortcode_filename, 0, 5 ) ) {
							$prefix = 'share';
						} elseif ( 'masonry' == substr( $shortcode_filename, 0, 7 ) ) {
							$prefix = 'masonry';
						} elseif ( 'icon-list' == substr( $shortcode_filename, 0, 9 ) ) {
							$prefix = 'iconlist';
						} elseif ( 'tab' == substr( $shortcode_filename, 0, 3 ) ) {
							$prefix = 'tab';
						} elseif ( 'accordion' == substr( $shortcode_filename, 0, 9 ) ) {
							$prefix = 'accordion';
						} elseif ( 'categories' == substr( $shortcode_filename, 0, 10 ) ) {
							$prefix = 'categories';
						} elseif ( 'filter' == substr( $shortcode_filename, 0, 6 ) ) {
							$prefix = 'filter';
						}
						$prefix = '/widgets/' . $prefix;
					} elseif ( 'header' == $path ) {
						$prefix = '/builders/header/widgets/' . $prefix;
					} elseif ( 'single-product' == $path ) {
						$prefix = '/builders/single-product/widgets/' . $prefix;
					}

					ob_start();
					require wolmart_core_path( $prefix . '/render-' . $shortcode_filename . '-wpb.php' );
					echo ob_get_clean();

					return ob_get_clean();
				};
				if ( ! shortcode_exists( 'wpb_wolmart_' . $shortcode ) ) {
					add_shortcode( 'wpb_wolmart_' . $shortcode, $callback );
				}
				add_action(
					'vc_after_init',
					function() use ( $shortcode, $left, $right, $path ) {
						$shortcode_filename = str_replace( '_', '-', $shortcode );
						if ( 'hb-' == substr( $shortcode_filename, 0, 3 ) || 'sp-' == substr( $shortcode_filename, 0, 3 ) ) {
							$shortcode_filename = substr( $shortcode_filename, 3 );
						}
						$prefix = $shortcode_filename;
						if ( 'elements' == $path ) {
							if ( 'banner' == substr( $prefix, 0, 6 ) ) {
								$prefix = 'banner';
							} elseif ( 'posts' == substr( $prefix, 0, 5 ) ) {
								$prefix = 'posts';
							} elseif ( 'images' == substr( $prefix, 0, 6 ) ) {
								$prefix = 'image-gallery';
							} elseif ( 'products' == substr( $prefix, 0, 8 ) ) {
								$prefix = 'products';
							} elseif ( 'video' == substr( $prefix, 0, 5 ) ) {
								$prefix = 'video';
							} elseif ( 'share' == substr( $prefix, 0, 5 ) ) {
								$prefix = 'share';
							} elseif ( 'masonry' == substr( $prefix, 0, 7 ) ) {
								$prefix = 'masonry';
							} elseif ( 'icon-list' == substr( $prefix, 0, 9 ) ) {
								$prefix = 'iconlist';
							} elseif ( 'tab' == substr( $prefix, 0, 3 ) ) {
								$prefix = 'tab';
							} elseif ( 'accordion' == substr( $prefix, 0, 9 ) ) {
								$prefix = 'accordion';
							} elseif ( 'categories' == substr( $prefix, 0, 10 ) ) {
								$prefix = 'categories';
							} elseif ( 'filter' == substr( $prefix, 0, 6 ) ) {
								$prefix = 'filter';
							}
							$prefix = '/widgets/' . $prefix;
						} elseif ( 'header' == $path ) {
							$prefix = '/builders/header/widgets/' . $prefix;
						} elseif ( 'single-product' == $path ) {
							$prefix = '/builders/single-product/widgets/' . $prefix;
						}
						require_once wolmart_core_path( $prefix . '/widget-' . $shortcode_filename . '-wpb.php' );
					}
				);
			}
		}

		/**
		 * Add custom css of shortcodes
		 *
		 * @since  1.0
		 *
		 * @param  string $css
		 * @param  string $id
		 *
		 * @return string
		 */
		public function add_shortcodes_custom_css( $css, $id ) {
			$post = get_post( $id );

			$css_array = $this->parse_shortcodes_custom_css( $post->post_content );

			foreach ( $css_array as $key => $value ) {
				if ( 'responsive' == $key ) {
					if ( ! is_array( $value ) ) {
						$css .= $value;
					} else {
						$value = array_unique( $value );
						$css  .= implode( '', $value );
					}
				} else {
					if ( ! is_array( $value ) ) {
						$css .= $key . '{' . $value . '}';
					} else {
						$value = array_unique( $value );
						$css  .= $key . '{' . implode( '', $value ) . '}';
					}
				}
			}

			return $css;
		}

		/**
		 * Parse shortcodes custom css
		 *
		 * @param string $content
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public function parse_shortcodes_custom_css( $content ) {
			$css = array();

			WPBMap::addAllMappedShortcodes();
			preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );

			foreach ( $shortcodes[2] as $index => $tag ) {
				// Get attributes
				$atts = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
				$css  = array_merge_recursive( $css, $this->wolmart_generate_shortcode_css( $tag, $atts ) );
			}

			foreach ( $shortcodes[5] as $shortcode_content ) {
				$css = array_merge_recursive( $css, $this->parse_shortcodes_custom_css( $shortcode_content ) );
			}

			return $css;
		}

		/**
		 * Generate Shortcode CSS
		 *
		 * @param string $tag
		 * @param array $atts
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public function wolmart_generate_shortcode_css( $tag, $atts ) {
			$css = array();
			if ( defined( 'WPB_VC_VERSION' ) ) {
				$shortcode = WPBMap::getShortCode( $tag );

				// Get attributes
				if ( empty( $atts ) ) {
					$atts = array(
						'tag' => $tag,
					);
				} else {
					$atts['tag'] = $tag;
				}

				if ( isset( $shortcode['params'] ) && ! empty( $shortcode['params'] ) ) {
					$shortcode_class = '.wpb_custom_' . wolmart_get_global_hashcode( $atts, $tag, $shortcode['params'] );

					foreach ( $shortcode['params'] as $param ) {
						if ( isset( $param['selectors'] ) && ( isset( $atts[ $param['param_name'] ] ) || isset( $param['std'] ) ) ) {

							foreach ( $param['selectors'] as $key => $value ) {
								if ( isset( $param['std'] ) ) {
									$saved_value = $param['std'];
								}
								if ( isset( $atts[ $param['param_name'] ] ) ) {
									$saved_value = $atts[ $param['param_name'] ];
								}

								if ( 'wolmart_number' == $param['type'] && ! empty( $param['units'] ) && is_array( $param['units'] ) ) {
									$saved_value       = str_replace( '``', '"', $saved_value );
									$responsive_values = json_decode( $saved_value, true );
									if ( ! empty( $responsive_values['xl'] ) || ( isset( $responsive_values['xl'] ) && '0' === $responsive_values['xl'] ) ) {
										$saved_value = $responsive_values['xl'];
									} else {
										$saved_value = '';
									}
								} elseif ( 'wolmart_dimension' == $param['type'] ) {
									$saved_value      = str_replace( '``', '"', $saved_value );
									$dimension_values = json_decode( $saved_value, true );
								} elseif ( 'wolmart_typography' == $param['type'] ) {
									$saved_value = str_replace( '``', '"', $saved_value );
									$saved_value = json_decode( $saved_value, true );
									$typography  = '';
									if ( ! empty( $saved_value['family'] ) && 'Default' != $saved_value['family'] ) {
										if ( 'Inherit' == $saved_value['family'] ) {
											$typography .= 'font-family:inherit;';
										} else {
											$typography .= "font-family:'" . $saved_value['family'] . "';";
										}
									}
									if ( ! empty( $saved_value['variant'] ) ) {
										preg_match( '/^\d+|(regular)|(italic)/', $saved_value['variant'], $weight );
										if ( ! empty( $weight ) ) {
											if ( 'regular' == $weight[0] || 'italic' == $weight[0] ) {
												$weight[0] = 400;
											}
											$typography .= 'font-weight:' . $weight[0] . ';';
										}
										preg_match( '/(italic)/', $saved_value['variant'], $weight );
										if ( ! empty( $weight ) ) {
											$typography .= 'font-style:' . $weight[0] . ';';
										}
									}
									if ( ! empty( $saved_value['size'] ) && wolmart_check_units( $saved_value['size'] ) ) {
										$typography .= 'font-size:' . wolmart_check_units( $saved_value['size'] ) . ';';
									}
									if ( ! empty( $saved_value['letter_spacing'] ) || ( isset( $saved_value['letter_spacing'] ) && '0' === $saved_value['letter_spacing'] ) ) {
										$typography .= 'letter-spacing:' . $saved_value['letter_spacing'] . ';';
									}
									if ( ! empty( $saved_value['line_height'] ) || ( isset( $saved_value['line_height'] ) && '0' === $saved_value['line_height'] ) ) {
										$typography .= 'line-height:' . $saved_value['line_height'] . ';';
									}
									if ( ! empty( $saved_value['text_transform'] ) || ( isset( $saved_value['text_transform'] ) && '0' === $saved_value['text_transform'] ) ) {
										$typography .= 'text-transform:' . $saved_value['text_transform'] . ';';
									}
								}

								if ( ! empty( $param['units'] ) && is_array( $param['units'] ) ) {
									if ( empty( $responsive_values['unit'] ) ) {
										$value = str_replace( '{{UNIT}}', $param['units'][0], $value );
									} else {
										$value = str_replace( '{{UNIT}}', $responsive_values['unit'], $value );
									}
								}

								if ( ! empty( $param['responsive'] ) && $param['responsive'] ) {
									if ( isset( $param['std'] ) ) {
										$saved_value = $param['std'];
									}
									if ( isset( $atts[ $param['param_name'] ] ) ) {
										$saved_value = $atts[ $param['param_name'] ];
									}
									$saved_value       = str_replace( '``', '"', $saved_value );
									$key               = str_replace( '{{WRAPPER}}', $shortcode_class, $key );
									$responsive_values = json_decode( $saved_value, true );
									$style             = '';

									// Generate Responsive CSS
									$breakpoints = array(
										'lg' => '1199px',
										'md' => '991px',
										'sm' => '767px',
										'xs' => '575px',
									);

									if ( 'wolmart_dimension' == $param['type'] ) {
										$temp_value = $value;
										foreach ( $this::$dimensions as $dimension => $pattern ) {
											if ( isset( $dimension_values[ $dimension ]['xl'] ) ) {
												$temp = wolmart_check_units( $dimension_values[ $dimension ]['xl'] );
												if ( ! $temp ) {
													$temp_value = preg_replace( '/([^;]*)(\{\{' . strtoupper( $dimension ) . '\}\})([^;]*)(;*)/', '', $temp_value );
												} else {
													$temp_value = str_replace( $pattern, $temp, $temp_value );
												}
											}
										}
										$style = $key . '{' . $temp_value . '}';
										foreach ( $breakpoints as $breakpoint => $width ) {
											$temp_value = $value;
											foreach ( $this::$dimensions as $dimension => $pattern ) {
												if ( isset( $dimension_values[ $dimension ][ $breakpoint ] ) ) {
													$temp = wolmart_check_units( $dimension_values[ $dimension ][ $breakpoint ] );
													if ( ! $temp ) {
														$temp_value = preg_replace( '/([^;]*)(\{\{' . strtoupper( $dimension ) . '\}\})([^;]*)(;*)/', '', $temp_value );
													} else {
														$temp_value = str_replace( $pattern, $temp, $temp_value );
													}
												}
											}
											if ( ! empty( $temp_value ) ) {
												$style .= '@media (max-width:' . $width . '){';
												$style .= $key . '{' . $temp_value . '}}';
											}
										}
									} else {
										if ( ! empty( $responsive_values['xl'] ) || ( isset( $responsive_values['xl'] ) && '0' === $responsive_values['xl'] ) ) {
											if ( ! empty( $param['with_units'] ) && $param['with_units'] ) {
												$responsive_values['xl'] = wolmart_check_units( $responsive_values['xl'] );
												if ( false === $responsive_values['xl'] ) {
													break;
												}
											}
											$style = $key . '{' . str_replace( '{{VALUE}}', $responsive_values['xl'], $value ) . '}';
										}
										foreach ( $breakpoints as $breakpoint => $width ) {
											if ( ! empty( $param['with_units'] ) && $param['with_units'] ) {
												$responsive_values[ $breakpoint ] = wolmart_check_units( $responsive_values[ $breakpoint ] );
											}
											if ( ! empty( $responsive_values[ $breakpoint ] ) || ( isset( $responsive_values[ $breakpoint ] ) && '0' === $responsive_values[ $breakpoint ] ) ) {
												$style .= '@media (max-width:' . $width . '){';
												$style .= $key . '{' . str_replace( '{{VALUE}}', $responsive_values[ $breakpoint ], $value ) . '}}';
											}
										}
									}

									if ( empty( $css['responsive'] ) ) {
										$css['responsive'] = $style;
									} else {
										$css['responsive'] .= $style;
									}
								} else {
									if ( ! empty( $param['with_units'] ) && $param['with_units'] ) {
										$saved_value = wolmart_check_units( $saved_value );

										if ( ! $saved_value ) {
											continue;
										}
									}
									if ( 'wolmart_dimension' == $param['type'] ) { // Dimension
										foreach ( $this::$dimensions as $dimension => $pattern ) {
											$temp = wolmart_check_units( $dimension_values[ $dimension ]['xl'] );
											if ( ! $temp ) {
												$value = preg_replace( '/([^;]*)(\{\{' . strtoupper( $dimension ) . '\}\})([^;]*)(;*)/', '', $value );
											} else {
												$value = str_replace( $pattern, $temp, $value );
											}
										}

										if ( empty( $css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] ) ) {
											$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] = $value;
										} else {
											$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] .= $value;
										}
									} elseif ( 'wolmart_color_group' == $param['type'] ) { // Color Group
										$colors = json_decode( str_replace( '``', '"', $saved_value ), true );

										if ( ! empty( $colors[ $key ] ) ) {
											foreach ( $colors[ $key ] as $k => $v ) {
												if ( empty( $css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] ) ) {
													$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] = $k . ': ' . $v . ';';
												} else {
													$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] .= $k . ': ' . $v . ';';
												}
											}
										}
									} elseif ( 'wolmart_typography' == $param['type'] && ! empty( $typography ) ) {
										if ( empty( $css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] ) ) {
											$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] = $typography;
										} else {
											$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] .= $typography;
										}
									} elseif ( 'checkbox' == $param['type'] && ( empty( $saved_value ) && 'yes' == $saved_value ) ) {
										if ( empty( $css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] ) ) {
											$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] = $value;
										} else {
											$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] .= $value;
										}
									} else { // Others
										if ( ! empty( $saved_value ) || ( isset( $saved_value ) && '0' === $saved_value ) ) {
											if ( empty( $css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] ) ) {
												$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] = str_replace( '{{VALUE}}', $saved_value, $value );
											} else {
												$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] .= str_replace( '{{VALUE}}', $saved_value, $value );
											}
										}
									}
								}
							}
						}
					}
				}
			}
			return $css;
		}

		/**
		 * lazy load background images for wpbakery page builder.
		 *
		 * @since 1.0.0
		 */
		public function init_vc_custom_styles() {

			remove_action( 'wp_head', array( vc_manager()->vc(), 'addFrontCss' ), 1000 );
			remove_action( 'wp_enqueue_scripts', array( vc_manager()->vc(), 'addFrontCss' ) );
			ob_start();
			vc_manager()->vc()->addFrontCss();
			$css = wolmart_strip_script_tags( ob_get_clean() );
			if ( $css ) {
				if ( is_singular() && function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'lazyload' ) && ! vc_is_inline() ) {
					global $post;
					preg_match_all( '/\.vc_custom_([^{]*)[^}]*((background-image):[^}]*|(background):[^}]*url\([^}]*)}/', $css, $matches );
					if ( isset( $matches[0] ) && ! empty( $matches[0] ) ) {
						foreach ( $matches[0] as $key => $value ) {
							if ( ! isset( $matches[1][ $key ] ) || empty( $matches[1][ $key ] ) ) {
								continue;
							}
							if ( preg_match( '/\[(vc_row|vc_column|vc_row_inner|vc_column_inner)\s[^]]*.vc_custom_' . trim( $matches[1][ $key ] ) . '[^]]*\]/', $post->post_content ) ) {
								if ( ! empty( $matches[3][ $key ] ) ) {
									$css = preg_replace( '/\.vc_custom_' . $matches[1][ $key ] . '([^}]*)(background-image:[^;]*;)/', '.vc_custom_' . $matches[1][ $key ] . '$1', $css );
								} else {
									$css = preg_replace( '/\.vc_custom_' . $matches[1][ $key ] . '([^}]*)(background)(:\s#[A-Fa-f0-9]{3,6}\s)(url\([^)]*\))\s(!important;)/', '.vc_custom_' . $matches[1][ $key ] . '$1background-color$3$5', $css );
								}
							}
						}
					}
				}
				$this->js_composer_internal_styles = $css;
			}
		}

		/**
		 * Enqueue vc editor preview style
		 *
		 * @since 1.0.0
		 */
		public function enqueue_vc_editor_preview_style() {
			if ( vc_is_inline() ) {
				wp_enqueue_style( 'wolmart-js-composer-editor-preview', WOLMART_CORE_PLUGINS_URI . '/wpb/assets/wpb-preview' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), WOLMART_CORE_VERSION );
			}
		}
	}
endif;

Wolmart_WPB::get_instance();
