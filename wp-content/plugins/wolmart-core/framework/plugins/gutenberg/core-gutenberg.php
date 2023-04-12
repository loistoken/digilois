<?php

/**
 * Add Gutenberg Blocks
 *
 * @since 1.0
 */

if ( ! class_exists( 'Wolmart_Gutenberg' ) ) :
	class Wolmart_Gutenberg {

		public $id;

		/**
		 * Constructor
		 */
		public function __construct() {

			$id = array();

			if ( is_admin() ) {
				add_action(
					'enqueue_block_editor_assets',
					function() {
						wp_enqueue_script( 'imagesloaded' );

						if ( defined( 'WOLMART_VERSION' ) ) {
							wp_enqueue_script( 'swiper' );
							wp_enqueue_script( 'isotope-pkgd' );
						}

						$dependency = array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-data' );
						if ( 'widgets.php' != $GLOBALS['pagenow'] ) {
							$dependency[] = 'wp-editor';
						}

						wp_enqueue_script( 'wolmart_gutenberg_blocks', WOLMART_CORE_PLUGINS_URI . '/gutenberg/assets/blocks.js', $dependency, WOLMART_CORE_VERSION, true );

						wp_localize_script(
							'wolmart_gutenberg_blocks',
							'wolmart_gutenberg_vars',
							array(
								'placeholder_img' => class_exists( 'WooCommerce' ) ? apply_filters( 'woocommerce_placeholder_img_src', wc_placeholder_img_src( 'shop_catalog' ) ) : '',
								'ajax_url'        => esc_js( admin_url( 'admin-ajax.php' ) ),
								'nonce'           => wp_create_nonce( 'wolmart-nonce' ),
								'breakpoints'     => wolmart_get_breakpoints(),
							)
						);
					},
					999
				);

				add_filter( 'block_categories_all', array( $this, 'blocks_categories' ), 10, 1 );
			}

			include WOLMART_CORE_PLUGINS . '/gutenberg/rest/rest-init.php';
			add_action( 'init', array( $this, 'register_block_types' ) );
		}

		public function register_block_types() {
			$wolmart_block = array( 'slider', 'banner', 'products', 'categories', 'posts', 'icon-box', 'heading', 'button' );

			if ( function_exists( 'register_block_type' ) ) {
				for ( $i = 0; $i < count( $wolmart_block ); $i++ ) {
					$this->id[ $wolmart_block[ $i ] ] = 0;

					register_block_type(
						'wolmart/wolmart-' . $wolmart_block[ $i ],
						array(
							'editor_script'   => 'wolmart_gutenberg_blocks',
							'render_callback' => array(
								$this,
								'render_' . str_replace( '-', '_', $wolmart_block[ $i ] ),
							),
						)
					);
				}
			}
		}

		public function blocks_categories( $categories ) {
			return array_merge(
				$categories,
				array(
					array(
						'slug'  => 'wolmart',
						'title' => esc_html__( 'Wolmart', 'wolmart-core' ),
						'icon'  => '',
					),
				)
			);
		}

		public function render_slider( $atts, $content = null ) {
			++ $this->id['slider'];
			$atts['id'] = $this->id['slider'];
			ob_start();
			echo '<div id="wolmart_gtnbg_slider_' . $this->id['slider'] . '" class="' . ( isset( $atts['align'] ) ? 'align' . $atts['align'] . ' ' : '' ) . ( isset( $atts['className'] ) ? $atts['className'] : '' ) . '">';
			require wolmart_core_path( '/plugins/gutenberg/render/slider.php' );
			echo '</div>';
			return ob_get_clean();
		}

		public function render_banner( $atts, $content = null ) {
			++ $this->id['banner'];

			ob_start();
			echo '<div id="wolmart_gtnbg_banner_' . $this->id['banner'] . '" class="' . ( isset( $atts['align'] ) ? 'align' . $atts['align'] . ' ' : '' ) . ( isset( $atts['className'] ) ? $atts['className'] : '' ) . '">';
			require wolmart_core_path( '/plugins/gutenberg/render/banner.php' );
			echo '</div>';
			return ob_get_clean();
		}

		public function render_products( $atts, $content = null ) {
			++ $this->id['products'];

			if ( isset( $atts['status'] ) ) {
				if ( 'on_sale' == $atts['status'] ) {
					$atts['status'] = 'sale_products';
				} elseif ( 'featured' == $atts['status'] ) {
					$atts['status'] = 'featured_products';
				} else {
					$atts['status'] = 'products';
				}
			}

			$atts['count'] = array( 'size' => isset( $atts['count'] ) ? $atts['count'] : 10 );

			foreach ( $atts as $key => $value ) {
				if ( 'boolean' == gettype( $value ) ) {
					if ( $value ) {
						$atts[ $key ] = 'yes';
					} else {
						$atts[ $key ] = '';
					}
				}
			}

			if ( isset( $atts['category_type'] ) && $atts['category_type'] ) {
				$atts['categories'] = array();

				foreach ( $atts['category_list'] as $cat ) {
					if ( $cat['checked'] ) {
						$atts['categories'][] = $cat['id'];
					}
				}

				$atts['categories'] = implode( ',', $atts['categories'] );
			}

			$atts = shortcode_atts(
				array(
					// Products Selector
					'ids'                 => '',
					'categories'          => '',
					'status'              => '',
					'count'               => array( 'size' => 10 ),
					'orderby'             => '',
					'orderway'            => 'ASC',

					// Products Layout
					'col_cnt'             => array( 'size' => 4 ),
					'col_cnt_xl'          => '',
					'col_cnt_tablet'      => '',
					'col_cnt_mobile'      => '',
					'col_cnt_min'         => '',
					'col_sp'              => '',
					'layout_type'         => 'grid',
					'split_line'          => '',
					'show_nav'            => '',
					'nav_hide'            => '',
					'nav_type'            => 'simple',
					'nav_pos'             => '',
					'show_dots'           => '',
					'dots_skin'           => '',
					'dots_pos'            => '',
					'autoplay'            => '',
					'autoplay_timeout'    => '5000',
					'loop'                => '',
					'pause_onhover'       => '',
					'autoheight'          => '',

					// Product Type
					'follow_theme_option' => '',
					'show_labels'         => array( 'hot', 'sale', 'new', 'stock' ),
					'product_type'        => '',
					'classic_hover'       => '',
					'show_in_box'         => '',
					'show_media_shadow'   => '',
					'show_info'           => array( 'category', 'label', 'price', 'rating', 'attribute', 'addtocart', 'quickview', 'wishlist' ),

					'page_builder'        => 'gutenberg',
				),
				$atts
			);

			if ( 'list' == $atts['product_type'] ) {
				$atts['show_info'] . push( 'short_desc' );
			}

			$padding = isset( $atts['padding'] ) ? $atts['padding'] : 0;

			ob_start();
			$style  = '<style type="text/css">';
			$style .= '#wolmart_gtnbg_products_' . $this->id['products'] . ' .product-details{ padding-left: ' . ( ! isset( $atts['content_align'] ) ? $padding : 0 ) . 'px; padding-right: ' . ( isset( $atts['content_align'] ) && 'right-aligned' == $atts['content_align'] ? $padding : 0 ) . 'px; }';
			$style .= '</style>';
			wolmart_filter_inline_css( $style );
			echo '<div id="wolmart_gtnbg_products_' . $this->id['products'] . '" class="' . ( isset( $atts['className'] ) ? $atts['className'] : '' ) . '">';
			require wolmart_core_path( '/widgets/products/render-products.php' );
			echo '</div>';
			return ob_get_clean();
		}

		public function render_categories( $atts, $content = null ) {
			++ $this->id['categories'];

			$atts['count'] = array( 'size' => isset( $atts['count'] ) ? $atts['count'] : 4 );
			foreach ( $atts as $key => $value ) {
				if ( 'boolean' == gettype( $value ) ) {
					if ( $value ) {
						$atts[ $key ] = 'yes';
					} else {
						$atts[ $key ] = '';
					}
				}
			}

			if ( isset( $atts['category'] ) && $atts['category'] && isset( $atts['category_list'] ) ) {
				$atts['categories'] = array();

				foreach ( $atts['category_list'] as $cat ) {
					$atts['categories'][] = $cat['id'];
				}

				$atts['ids'] = implode( ',', $atts['categories'] );
			}

			if ( isset( $atts['col_cnt'] ) ) {
				$atts['col_cnt'] = array( 'size' => $atts['col_cnt'] );
			}

			if ( isset( $atts['creative_height'] ) ) {
				$atts['creative_height'] = array( 'size' => $atts['creative_height'] );
			}

			$atts = shortcode_atts(
				array(
					// Categories Selector
					'ids'                        => array(),
					'show_subcategories'         => '',
					'hide_empty'                 => '',
					'count'                      => array( 'size' => 4 ),
					'orderby'                    => 'name',
					'orderway'                   => '',

					// Categories
					'layout_type'                => 'grid',
					'col_sp'                     => '',
					'creative_mode'              => 1,
					'creative_height'            => array( 'size' => 600 ),
					'creative_height_ratio'      => array( 'size' => 75 ),
					'grid_float'                 => '',
					'thumbnail_size'             => 'woocommerce_thumbnail',
					'thumbnail_custom_dimension' => '',
					'col_cnt'                    => array( 'size' => 4 ),
					'col_cnt_xl'                 => '',
					'col_cnt_tablet'             => '',
					'col_cnt_mobile'             => '',
					'col_cnt_min'                => '',
					'col_sp'                     => '',
					'layout_type'                => 'grid',
					'show_nav'                   => '',
					'nav_hide'                   => '',
					'nav_type'                   => 'simple',
					'nav_pos'                    => '',
					'show_dots'                  => '',
					'dots_skin'                  => '',
					'dots_pos'                   => '',
					'autoplay'                   => '',
					'autoplay_timeout'           => '5000',
					'loop'                       => '',
					'pause_onhover'              => '',
					'autoheight'                 => '',

					// Category Type
					'follow_theme_option'        => '',
					'category_type'              => 'classic',
					'overlay'                    => '',
					'show_count'                 => '',
					'show_link'                  => '',
					'link_text'                  => 'Shop now',

					'page_builder'               => 'gutenberg',
					'wrapper_id'                 => '#wolmart_gtnbg_categories_' . $this->id['categories'],
				),
				$atts
			);

			ob_start();
			$style  = '<style type="text/css">';
			$style .= '#wolmart_gtnbg_categories_' . $this->id['categories'] . ' .category-content{ text-align: ' . ( isset( $atts['content_align'] ) ? $atts['content_align'] : 'left' ) . '; }';
			$style .= '</style>';
			wolmart_filter_inline_css( $style );
			echo '<div id="wolmart_gtnbg_categories_' . $this->id['categories'] . '" class="' . ( isset( $atts['className'] ) ? $atts['className'] : '' ) . '">';
			require wolmart_core_path( '/widgets/categories/render-categories.php' );
			echo '</div>';
			return ob_get_clean();
		}

		public function render_posts( $atts, $content = null ) {
			++ $this->id['posts'];

			$atts['count'] = array( 'size' => isset( $atts['count'] ) ? $atts['count'] : 4 );

			if ( isset( $atts['category_type'] ) && $atts['category_type'] && isset( $atts['category_list'] ) ) {
				$atts['categories'] = array();

				foreach ( $atts['category_list'] as $cat ) {
					if ( $cat['checked'] ) {
						$atts['categories'][] = $cat['id'];
					}
				}

				$atts['categories'] = implode( ',', $atts['categories'] );
			}

			if ( isset( $atts['show_info'] ) ) {
				$infos = array();

				foreach ( $atts['show_info'] as $key => $value ) {
					if ( $value ) {
						$infos[] = $key;
					}
				}

				$atts['show_info'] = $infos;
			}

			foreach ( $atts as $key => $value ) {
				if ( 'boolean' == gettype( $value ) ) {
					if ( $value ) {
						$atts[ $key ] = 'yes';
					} else {
						$atts[ $key ] = '';
					}
				}
			}

			if ( isset( $atts['icon'] ) ) {
				$atts['icon'] = array( 'value' => $atts['icon'] );
			}
			if ( isset( $atts['excerpt_length'] ) ) {
				$atts['excerpt_length'] = array( 'size' => $atts['excerpt_length'] );
			}

			$atts = shortcode_atts(
				array(
					// Posts Selector
					'ids'                        => '',
					'categories'                 => '',
					'count'                      => array( 'size' => 4 ),
					'orderby'                    => '',
					'orderway'                   => '',

					// Posts Layout
					'layout_type'                => 'grid',
					'col_cnt'                    => array( 'size' => 4 ),
					'col_cnt_xl'                 => '',
					'col_cnt_tablet'             => '',
					'col_cnt_mobile'             => '',
					'col_cnt_min'                => '',
					'col_sp'                     => '',
					'show_nav'                   => '',
					'nav_hide'                   => '',
					'nav_type'                   => 'simple',
					'nav_pos'                    => '',
					'show_dots'                  => '',
					'dots_skin'                  => '',
					'dots_pos'                   => '',
					'autoplay'                   => '',
					'autoplay_timeout'           => '5000',
					'loop'                       => '',
					'pause_onhover'              => '',
					'autoheight'                 => '',
					'loadmore_type'              => '',
					'loadmore_label'             => '',

					// Post Type
					'follow_theme_option'        => '',
					'post_type'                  => '',
					'overlay'                    => '',
					'show_info'                  => array(),
					'show_datebox'               => '',
					'read_more_label'            => esc_html__( 'Read More', 'wolmart-core' ),
					'read_more_custom'           => '',
					'excerpt_custom'             => '',
					'excerpt_length'             => array( 'size' => 20 ),
					'excerpt_type'               => 'words',

					// Custom Button
					'button_skin'                => 'btn-dark',
					'button_border'              => '',
					'button_type'                => '',
					'link_hover_type'            => '',
					'button_size'                => '',
					'icon'                       => '',
					'icon_pos'                   => 'after',
					'icon_hover_effect'          => '',
					'icon_hover_effect_infinite' => '',
					'icon_size'                  => '',
					'show_label'                 => 'yes',

					// Style
					'content_align'              => '',
					'page_builder'               => 'gutenberg',
					'wrapper_id'                 => '',
				),
				$atts
			);

			ob_start();
			$style  = '<style type="text/css">';
			$style .= '#wolmart_gtnbg_posts_' . $this->id['posts'] . ' .post-body{ text-align: ' . ( isset( $atts['content_align'] ) ? $atts['content_align'] : 'left' ) . '; }';
			$style .= '#wolmart_gtnbg_posts_' . $this->id['posts'] . ' .btn > i { font-size: ' . ( isset( $atts['icon_size'] ) ? $atts['icon_size'] : 'inherit' ) . ' } }';
			$style .= '</style>';
			wolmart_filter_inline_css( $style );
			echo '<div id="wolmart_gtnbg_posts_' . $this->id['posts'] . '" class="' . ( isset( $atts['className'] ) ? $atts['className'] : '' ) . '">';
			require wolmart_core_path( '/widgets/posts/render-posts.php' );
			echo '</div>';
			return ob_get_clean();
		}

		public function render_icon_box( $atts, $content = null ) {
			++ $this->id['icon-box'];

			$atts['id'] = $this->id['icon-box'];

			ob_start();
			require wolmart_core_path( '/plugins/gutenberg/render/icon-box.php' );
			return ob_get_clean();
		}

		public function render_heading( $atts, $content = null ) {
			++ $this->id['heading'];

			$atts['id'] = $this->id['heading'];

			ob_start();
			require wolmart_core_path( '/plugins/gutenberg/render/heading.php' );
			return ob_get_clean();
		}

		public function render_button( $atts, $content = null ) {
			++ $this->id['button'];

			$atts['id'] = $this->id['button'];

			ob_start();
			require wolmart_core_path( '/plugins/gutenberg/render/button.php' );
			return ob_get_clean();
		}
	}

endif;

new Wolmart_Gutenberg;
