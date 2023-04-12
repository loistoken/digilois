<?php

/**
 * Wolmart Content Generator - generate description, excerpt, meta infos and outline by using GPT-3
 * 
 * @author     D-THEMES
 * @category   WP Wolmart Framework
 * @subpackage Theme
 * @since      1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Wolmart_Content_Generator' ) ) :
	class Wolmart_Content_Generator {

		public function __construct() {
			$post_types = array( 'attachment', 'nav_menu_item', 'revision', 'custom_css', 'customize_changeset', 'oembed_cache', 'user_request', 'wp_block', 'wp_template', 'wp_template_part', 'wp_global_styles', 'wp_navigation', 'product_variation', 'shop_order', 'shop_order_refund', 'shop_order_placehold', 'shop_coupon', 'wolmart_template', 'cptm', 'ptu', 'yith-wcbm-badge' );
			if ( ( 'post-new.php' == $GLOBALS['pagenow'] && isset( $_REQUEST['post_type'] ) && ! in_array( $_REQUEST['post_type'], $post_types ) ) || ( 'post.php' == $GLOBALS['pagenow'] && isset( $_REQUEST['post'] ) && ! in_array( get_post_type( $_REQUEST['post'] ), $post_types ) ) ) {
				add_filter( 'wolmart_admin_vars', array( $this, 'add_ai_vars' ) );
				add_filter( 'rwmb_meta_boxes', array( $this, 'add_meta_boxes' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ), 20 );
			}
		}

		/**
		 * Add AI meta Fields
		 * Except page of plugin which adds custom post type - Post Type Unlimted, Custom Post Type Maker
		 * 
		 * @since 1.5.0
		 */
		public function add_meta_boxes( $meta_boxes ) {
			if ( isset( $_REQUEST['post_type'] ) ) {
				$post_type = $_REQUEST['post_type'];
			} else if ( isset( $_REQUEST['post'] ) ) {
				$post_type = get_post_type( $_REQUEST['post'] );
			}
			$meta_boxes[] = array(
				'id'         => 'wolmart-api-engine',
				'title'      => esc_html__( 'Wolmart AI Engine', 'wolmart-core' ),
				'post_types' => array( $post_type ),
				'context'    => 'side',
				'priority'   => 'high',
				'fields'     => array(
					array(
						'id'    => 'ai_desc_none',
						'class' => 'ai-desc-none',
						'type'  => 'heading',
						'name'  => esc_html__( 'Please input AI key in Theme Option.', 'wolmart-core' ),
						'desc'  => esc_html__( 'You can generate the descriptions and meta infos easily, correctly and in details with AI engine. ', 'wolmart-core' )
					),
					array(
						'id'          => 'prompt_topic',
						'class'       => 'prompt-topic',
						'type'        => 'textarea',
						'placeholder' => esc_html__( 'Please leave empty to generate with the title.', 'wolmart-core' ),
						'name'        => esc_html__( 'Alternative Topic ( Instead of Title )', 'wolmart-core' ),
						'desc'        => esc_html__( 'You can generate with this topic instead of the title.', 'wolmart-core' )
					),
					array(
						'id'      => 'ai_content_type',
						'type'    => 'select',
						'class'   => 'ai-content-type',
						'name'    => esc_html__('Generate Type', 'wolmart-core'),
						'options' => array(
							'description' => esc_html__( 'Description', 'wolmart-core' ),
							'excerpt'     => esc_html__( 'Excerpt', 'wolmart-core' ),
							'outline'     => esc_html__( 'Outline', 'wolmart-core' ),
							'meta_title'  => esc_html__( 'Meta Title', 'wolmart-core' ),
							'meta_desc'   => esc_html__( 'Meta Description', 'wolmart-core' ),
							'meta_key'    => esc_html__( 'Meta Keywords', 'wolmart-core' ),
						),
					),
					array(
						'id'      => 'ai_write_style',
						'type'    => 'select',
						'class'   => 'ai-write-style',
						'name'    => esc_html__( 'Writing Style', 'wolmart-core' ),
						'options' => array(
							''              => esc_html__( 'Normal', 'wolmart-core' ),
							'persuasive'    => esc_html__( 'Persuasive', 'wolmart-core'),
							'infromative'   => esc_html__( 'Infromative', 'wolmart-core'),
							'descriptive'   => esc_html__( 'Descriptive', 'wolmart-core'),
							'creative'      => esc_html__( 'Creative', 'wolmart-core'),
							'narrative'     => esc_html__( 'Narrative', 'wolmart-core'),
							'argumentative' => esc_html__( 'Argumentative', 'wolmart-core'),
							'analytical'    => esc_html__( 'Analytical', 'wolmart-core'),
							'evaluative'    => esc_html__( 'Evaluative', 'wolmart-core'),
						),
					),
					array(
						'id'          => 'user_word',
						'class'       => 'user-word',
						'type'        => 'textarea',
						'name'        => esc_html__( 'Additional Prompt', 'wolmart-core'),
						'placeholder' => esc_html__( 'Ex: Please write at least 10 sentences in Spanish.', 'wolmart-core' ),
						'desc'        => esc_html__( 'You can improve the prompt for generating with this additional prompt.', 'wolmart-core' ),
					),
					'generate_btn' => array(
						'id'    => 'generate_btn',
						'type'  => 'button',
						'std'   => esc_html__( 'Generate', 'wolmart-core' ),
					),
				),
			);
			return $meta_boxes;
		}

		/**
		 * Enqueue js for Ai engine
		 * 
		 * @since 1.5.0
		 */
		public function enqueue_script() {
			if ( function_exists( 'wolmart_get_option' ) && ! empty( wolmart_get_option( 'ai_generate_key' ) ) ) {
				wp_enqueue_script( 'wolmart-ai-engine', WOLMART_CORE_ADDONS_URI . '/ai-generator/ai-generator' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.js' : '.min.js' ), array( 'jquery-core' ), WOLMART_CORE_VERSION, true );
			}
			$this->add_style();
		}

		/**
		 * Add vars to wolmart_admin_vars
		 * 
		 * @since 1.5.0
		 */
		public function add_ai_vars( $vars ) {
			if ( function_exists( 'wolmart_get_option' ) && ! empty( wolmart_get_option( 'ai_generate_key' ) ) ) {
				$vars['ai_key'] = wolmart_get_option( 'ai_generate_key' );
				$screen = get_current_screen();
				if ( 'post' == $screen->id ) {
					$vars['post_type'] = 'blog';
				} else {
					$vars['post_type'] = $screen->id;
				}
			}
			return $vars;
		}

		/**
		 * Add styles for metabox and dialog
		 * 
		 * @since 1.5.0
		 */
		public function add_style() {
			?>
				<style>
					#wolmart-api-engine h4 { padding-top: 0 !important; margin: 0 0 10px 0 !important; font-size: 13px; text-transform: capitalize; }
					#wolmart-api-engine .inside { margin: 12px 0 0 0 !important; }
					#wolmart-api-engine .postbox-header { background-color: #2271b1 !important; }
					#wolmart-api-engine .postbox-header > *,
					#wolmart-api-engine .postbox-header .button,
					#wolmart-api-engine .postbox-header button,
					#wolmart-api-engine .postbox-header span{color: #fff !important;}
			<?php
			if ( function_exists( 'wolmart_get_option' ) && ! empty( wolmart_get_option( 'ai_generate_key' ) ) ) {
				?>
					.wolmart-dialog-wrapper:not(.complete) .wolmart-dialog-footer,
					.wolmart-dialog-wrapper:not(.complete) .wolmart-dialog-close {
						display: none;
					}
					.wolmart-dialog-content { position: relative; }
					.wolmart-dialog-wrapper .output {
						width: 100%;
						height: 100%;
						display: block;
						max-height: 300px;
					}
					.wolmart-dialog-wrapper .wolmart-dialog {
						width: 500px;
					}
					.wolmart-dialog-wrapper:not(.complete) .output {
						visibility: hidden;
    					opacity: 0;
					}
					.wolmart-dialog-wrapper:not(.complete) .loading {
						position: absolute;
						left: 50%;
						top: 50%;
						transform: translate(-50%, -50%);
						color: #222529;
					}
					.wolmart-dialog-wrapper.complete .loading {
						display: none;
					}
					.wolmart-dialog-wrapper:not(.complete) .loading svg {
						display: block;
						animation: rotation 2s infinite linear;
					}
					.wolmart-dialog-wrapper button { font-size: 13px; }
					#wolmart-api-engine select { box-sizing: border-box; }
					#wolmart-api-engine #generate_btn { width: 100%; }
					#wolmart-api-engine .ai-desc-none { display: none; }
					#user_word { height: 100px; }

					/* Seo Plugin */
					.ai-plugin-gen { margin: 0 0 5px 10px !important; height: 100% !important; }
					.ai-plugin-gen svg { margin-right: 3px; transform: scale(1.5); }
					#aioseo-post-settings-meta-description-row .ai-plugin-gen { margin: 0 0 0 auto !important; }
					.aioseo-post-settings-modal #aioseo-post-settings-meta-description-row .add-tags {
						position: static;
						margin-bottom: 10px;
					}
					/* Rank Math Seo */
					.rank-math-editor-general [for="rank-math-editor-description"] {
						display: inline-flex !important;
					}
					.rank-math-editor-general .is-primary { height: 24px !important; vertical-align: middle; }
				<?php
			} else {
				?>
					#wolmart-api-engine #ai_desc_none { font-size: 16px; }
					#wolmart-api-engine .rwmb-field:not(.ai-desc-none) { display: none; }
				<?php
			}
			?>
			</style>
			<?php
		}

	}

	new Wolmart_Content_Generator();
endif;