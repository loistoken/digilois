<?php
/**
 * Wolmart Vendors class
 *
 * Available plugins are: Dokan, WCFM, WC Marketplace, WC Vendors
 *
 * @version 1.0
 */

defined( 'ABSPATH' ) || die;

if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
	return;
}

define( 'WOLMART_CORE_ELEMENTOR', WOLMART_CORE_PLUGINS . '/elementor' );
define( 'WOLMART_CORE_ELEMENTOR_URI', WOLMART_CORE_PLUGINS_URI . '/elementor' );

use Elementor\Core\Files\CSS\Global_CSS;
use Elementor\Wolmart_Controls_Manager;

class Wolmart_Core_Elementor extends Wolmart_Base {

	/**
	 * Check if dom is optimized
	 *
	 * @since 1.0
	 *
	 * @var boolean $is_dom_optimized
	 */
	public static $is_dom_optimized = false;

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// Include Partials
		include_once 'partials/banner.php';
		include_once 'partials/creative.php';
		include_once 'partials/grid.php';
		include_once 'partials/slider.php';
		include_once 'partials/button.php';
		include_once 'partials/tab.php';
		include_once 'partials/products.php';
		include_once 'partials/testimonial.php';

		// Register controls, widgets, elements, icons
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
		add_action( 'elementor/controls/register', array( $this, 'register_control' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widget' ) );
		add_action( 'elementor/elements/elements_registered', array( $this, 'register_element' ) );
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'wolmart_add_icon_library' ) );
		add_filter( 'elementor/controls/animations/additional_animations', array( $this, 'add_appear_animations' ), 10, 1 );

		// Load Elementor CSS and JS
		if ( wolmart_is_elementor_preview() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_preview_scripts' ) );
		}

		// Disable elementor resource.
		if ( apply_filters( 'wolmart_resource_disable_elementor', function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'resource_disable_elementor' ) ) && ! current_user_can( 'edit_pages' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'resource_disable_elementor' ), 99 );
			add_action( 'elementor/widget/before_render_content', array( $this, 'enqueue_theme_alternative_scripts' ) );

			// Do not update dynamic css for visitors.
			add_action( 'init', array( $this, 'remove_dynamic_css_update' ) );
		}

		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'load_admin_styles' ) );

		// Include Elementor Admin JS
		add_action(
			'elementor/editor/after_enqueue_scripts',
			function() {
				if ( defined( 'WOLMART_VERSION' ) ) {
					wp_enqueue_style( 'wolmart-icons', WOLMART_ASSETS . '/vendor/wolmart-icons/css/icons.min.css', array(), WOLMART_VERSION );
				}
				wp_enqueue_script( 'wolmart-elementor-admin-js', WOLMART_CORE_ELEMENTOR_URI . '/assets/elementor-admin' . ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js' ), array( 'elementor-editor' ), WOLMART_CORE_VERSION, true );
			}
		);

		// Add Elementor Page Custom CSS
		if ( wp_doing_ajax() ) {
			add_action( 'elementor/document/before_save', array( $this, 'save_page_custom_css_js' ), 10, 2 );
			add_action( 'elementor/document/after_save', array( $this, 'save_elementor_page_css_js' ), 10, 2 );
		}

		// Init Elementor Document Config
		add_filter( 'elementor/document/config', array( $this, 'init_elementor_config' ), 10, 2 );

		// Register Document Controls
		add_action( 'elementor/documents/register_controls', array( $this, 'register_document_controls' ) );

		// Add Custom CSS & JS to Wolmart Elementor Addons
		add_filter( 'wolmart_builder_addon_html', array( $this, 'add_custom_css_js_addon_html' ) );

		// Because elementor removes all callbacks, add it again
		add_action( 'elementor/editor/after_enqueue_scripts', 'wolmart_print_footer_scripts' );

		// Add Template Builder Classes
		add_filter( 'body_class', array( $this, 'add_body_class' ) );

		// Compatabilities
		add_filter( 'elementor/widgets/wordpress/widget_args', array( $this, 'add_wp_widget_args' ), 10, 2 );

		// Load Used Block CSS
		/*
		 * Get Dependent Elementor Styles
		 * Includes Kit style and post style
		 */
		add_action( 'elementor/css-file/post/enqueue', array( $this, 'get_dependent_elementor_styles' ) );
		add_action( 'wolmart_before_enqueue_theme_style', array( $this, 'add_global_css' ) );
		add_action( 'wolmart_after_enqueue_theme_style', array( $this, 'add_elementor_css' ) );
		add_action( 'wolmart_before_enqueue_custom_css', array( $this, 'add_block_css' ) );

		// Elementor Custom Control Manager
		require_once WOLMART_CORE_ELEMENTOR . '/restapi/select2.php';
		require_once WOLMART_CORE_ELEMENTOR . '/controls_manager/controls.php';

		// Elementor Custom Advanced Tab Sections
		require_once WOLMART_CORE_ELEMENTOR . '/tabs_advanced/widget_advanced_tabs.php';
	}

	// Register new Category
	public function register_category( $self ) {
		$self->add_category(
			'wolmart_widget',
			array(
				'title'  => esc_html__( 'Wolmart Widgets', 'wolmart-core' ),
				'active' => true,
			)
		);
	}

	// Register new Control
	public function register_control( $self ) {

		$controls = array(
			'ajaxselect2',
			'description',
			'image_choose',
			'origin_position',
		);

		foreach ( $controls as $control ) {
			include_once WOLMART_CORE_ELEMENTOR . '/controls/' . $control . '.php';
			$class_name = 'Wolmart_Control_' . ucfirst( $control );
			$self->register( new $class_name() );
		}
	}


	public function register_element() {
		include_once WOLMART_CORE_ELEMENTOR . '/elements/section.php';
		Elementor\Plugin::$instance->elements_manager->unregister_element_type( 'section' );
		Elementor\Plugin::$instance->elements_manager->register_element_type( new Wolmart_Element_Section() );

		include_once WOLMART_CORE_ELEMENTOR . '/elements/column.php';
		Elementor\Plugin::$instance->elements_manager->unregister_element_type( 'column' );
		Elementor\Plugin::$instance->elements_manager->register_element_type( new Wolmart_Element_Column() );
	}


	// Register new Widget
	public function register_widget( $self ) {

		$widgets = array(
			'heading',
			'posts',
			'block',
			'banner',
			'countdown',
			'button',
			'image-gallery',
			// 'testimonial',
			'testimonial-group',
			'image-box',
			'share',
			'menu',
			'subcategories',
			'hotspot',
			'logo',
			'iconlist',
			'svg-floating',
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$widgets = array_merge(
				$widgets,
				array(
					'breadcrumb',
					'products',
					'products-tab',
					'products-banner',
					'products-single',
					'categories',
					'brands',
					'singleproducts',
					'filter',
				)
			);

			if ( class_exists( 'WeDevs_Dokan' ) || class_exists( 'WCMp' ) || class_exists( 'WCFM' ) || class_exists( 'WC_Vendors' ) || defined( 'MVX_PLUGIN_VERSION' ) ) {
				$widgets = array_merge(
					$widgets,
					array( 'vendor' )
				);
			}
		}

		array_multisort( $widgets );

		foreach ( $widgets as $widget ) {
			$prefix = $widget;
			if ( 'products' == substr( $widget, 0, 8 ) ) {
				$prefix = 'products';
			} elseif ( 'testimonial' == substr( $widget, 0, 11 ) ) {
				$prefix = 'testimonial';
			}
			wolmart_core_require_once( '/widgets/' . $prefix . '/widget-' . str_replace( '_', '-', $widget ) . '-elementor.php' );
			$class_name = 'Wolmart_' . ucwords( str_replace( '-', '_', $widget ), '_' ) . '_Elementor_Widget';
			$self->register( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
		}
	}

	public function load_admin_styles() {
		wp_enqueue_style( 'wolmart-elementor-admin-style', WOLMART_CORE_ELEMENTOR_URI . '/assets/elementor-admin' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );
	}

	public function load_preview_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.js' : '.min.js';

		// load needed style file in elementor preview
		wp_enqueue_style( 'wolmart-elementor-preview', WOLMART_CORE_ELEMENTOR_URI . '/assets/elementor-preview' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );
		wp_enqueue_script( 'wolmart-elementor-js', WOLMART_CORE_ELEMENTOR_URI . '/assets/elementor' . $suffix, array(), WOLMART_CORE_VERSION, true );
		wp_localize_script(
			'wolmart-elementor-js',
			'wolmart_elementor',
			array(
				'ajax_url'      => esc_js( admin_url( 'admin-ajax.php' ) ),
				'wpnonce'       => wp_create_nonce( 'wolmart-elementor-nonce' ),
				'assets_url'    => WOLMART_CORE_FRAMEWORK_URI,
				'text_untitled' => esc_html__( 'Untitled', 'wolmart-core' ),
			)
		);
	}

	/**
	 * Disable elementor resource for high performance
	 *
	 * @since 1.0
	 */
	public function resource_disable_elementor() {
		wp_dequeue_style( 'e-animations' );
		wp_dequeue_script( 'elementor-frontend' );
		wp_dequeue_script( 'elementor-frontend-modules' );
		wp_dequeue_script( 'elementor-waypoints' );
		wp_dequeue_script( 'elementor-webpack-runtime' );
		wp_deregister_script( 'elementor-frontend' );
		wp_deregister_script( 'elementor-frontend-modules' );
		wp_deregister_script( 'elementor-waypoints' );
		wp_deregister_script( 'elementor-webpack-runtime' );
	}

	/**
	 * Enqueue alternative scripts for disable elementor resource mode.
	 *
	 * @param $widget
	 * @since 1.0
	 */
	public function enqueue_theme_alternative_scripts( $widget ) {
		if ( 'counter' == $widget->get_name() ) {
			wp_enqueue_script( 'jquery-count-to' );
		}
	}

	public function wolmart_add_icon_library( $icons ) {
		if ( defined( 'WOLMART_VERSION' ) ) {
			$icons['wolmart-icons'] = array(
				'name'          => 'wolmart',
				'label'         => esc_html__( 'Wolmart Icons', 'wolmart-core' ),
				'prefix'        => 'w-icon-',
				'displayPrefix' => ' ',
				'labelIcon'     => 'w-icon-gift',
				'fetchJson'     => WOLMART_CORE_ELEMENTOR_URI . '/assets/wolmart-icons.js',
				'ver'           => WOLMART_CORE_VERSION,
				'native'        => false,
			);
		}
		return $icons;
	}

	public function save_page_custom_css_js( $self, $data ) {
		if ( empty( $data['settings'] ) || empty( $_REQUEST['editor_post_id'] ) ) {
			return;
		}
		$post_id = absint( $_REQUEST['editor_post_id'] );

		// save Wolmart elementor page CSS
		if ( ! empty( $data['settings']['page_css'] ) ) {
			update_post_meta( $post_id, 'page_css', wp_slash( $data['settings']['page_css'] ) );
		} else {
			delete_post_meta( $post_id, 'page_css' );
		}

		if ( current_user_can( 'unfiltered_html' ) ) {
			// save Wolmart elementor page JS
			if ( ! empty( $data['settings']['page_js'] ) ) {
				update_post_meta( $post_id, 'page_js', trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $data['settings']['page_js'] ) ) );
			} else {
				delete_post_meta( $post_id, 'page_js' );
			}
		}
	}

	public function save_elementor_page_css_js( $self, $data ) {
		if ( current_user_can( 'unfiltered_html' ) || empty( $data['settings'] ) || empty( $_REQUEST['editor_post_id'] ) ) {
			return;
		}
		$post_id = absint( $_REQUEST['editor_post_id'] );
		if ( ! empty( $data['settings']['page_css'] ) ) {
			$elementor_settings = get_post_meta( $post_id, '_elementor_page_settings', true );
			if ( is_array( $elementor_settings ) ) {
				$elementor_settings['page_css'] = wolmart_strip_script_tags( get_post_meta( $post_id, 'page_css', true ) );
				update_post_meta( $post_id, '_elementor_page_settings', $elementor_settings );
			}
		}
		if ( ! empty( $data['settings']['page_js'] ) ) {
			$elementor_settings = get_post_meta( $post_id, '_elementor_page_settings', true );
			if ( is_array( $elementor_settings ) ) {
				$elementor_settings['page_js'] = wolmart_strip_script_tags( get_post_meta( $post_id, 'page_js', true ) );
				update_post_meta( $post_id, '_elementor_page_settings', $elementor_settings );
			}
		}
	}

	public function init_elementor_config( $config = array(), $post_id = 0 ) {

		if ( ! isset( $config['settings'] ) ) {
			$config['settings'] = array();
		}
		if ( ! isset( $config['settings']['settings'] ) ) {
			$config['settings']['settings'] = array();
		}

		$config['settings']['settings']['page_css'] = get_post_meta( $post_id, 'page_css', true );
		$config['settings']['settings']['page_js']  = get_post_meta( $post_id, 'page_js', true );
		return $config;
	}

	/**
	 * Add custom css, js addon html to bottom of elementor editor panel.
	 *
	 * @since 1.0
	 * @param array $html
	 * @return array $html
	 */
	public function add_custom_css_js_addon_html( $html ) {
		$html[] = array(
			'elementor' => '<li id="wolmart-custom-css"><i class="fab fa-css3"></i>' . esc_html__( 'Page CSS', 'wolmart-core' ) . '</li>',
		);
		$html[] = array(
			'elementor' => '<li id="wolmart-custom-js"><i class="fab fa-js"></i>' . esc_html__( 'Page JS', 'wolmart-core' ) . '</li>',
		);
		return $html;
	}

	public function register_document_controls( $document ) {
		if ( ! $document instanceof Elementor\Core\DocumentTypes\PageBase && ! $document instanceof Elementor\Modules\Library\Documents\Page ) {
			return;
		}

		// Add Template Builder Controls
		$id = (int) $document->get_main_id();

		if ( 'wolmart_template' == get_post_type( $id ) ) {
			$category = get_post_meta( get_the_ID(), 'wolmart_template_type', true );

			if ( $id && 'popup' == get_post_meta( $id, 'wolmart_template_type', true ) ) {

				$selector = '.mfp-wolmart-' . $id;

				$document->start_controls_section(
					'wolmart_popup_settings',
					array(
						'label' => esc_html__( 'Wolmart Popup Settings', 'wolmart-core' ),
						'tab'   => Elementor\Controls_Manager::TAB_SETTINGS,
					)
				);

					$document->add_responsive_control(
						'popup_width',
						array(
							'label'      => esc_html__( 'Width', 'wolmart-core' ),
							'type'       => Elementor\Controls_Manager::SLIDER,
							'default'    => array(
								'size' => 600,
							),
							'size_units' => array(
								'px',
								'vw',
							),
							'range'      => array(
								'vw' => array(
									'step' => 1,
									'min'  => 0,
								),
							),
							'selectors'  => array(
								( $selector . ' .popup' ) => 'width: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$document->add_control(
						'popup_height_type',
						array(
							'label'   => __( 'Height', 'wolmart-core' ),
							'type'    => Elementor\Controls_Manager::SELECT,
							'options' => array(
								''       => esc_html__( 'Fit To Content', 'wolmart-core' ),
								'custom' => esc_html__( 'Custom', 'wolmart-core' ),
							),
						)
					);

					$document->add_responsive_control(
						'popup_height',
						array(
							'label'      => esc_html__( 'Custom Height', 'wolmart-core' ),
							'type'       => Elementor\Controls_Manager::SLIDER,
							'default'    => array(
								'size' => 380,
							),
							'size_units' => array(
								'px',
								'vh',
							),
							'range'      => array(
								'vh' => array(
									'step' => 1,
									'min'  => 0,
									'max'  => 100,
								),
							),
							'condition'  => array(
								'popup_height_type' => 'custom',
							),
							'selectors'  => array(
								( $selector . ' .popup' ) => 'height: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$document->add_control(
						'popup_content_pos_heading',
						array(
							'label'     => __( 'Content Position', 'wolmart-core' ),
							'type'      => Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$document->add_responsive_control(
						'popup_content_h_pos',
						array(
							'label'     => __( 'Horizontal', 'wolmart-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => __( 'Top', 'wolmart-core' ),
									'icon'  => 'eicon-h-align-left',
								),
								'center'     => array(
									'title' => __( 'Middle', 'wolmart-core' ),
									'icon'  => 'eicon-h-align-center',
								),
								'flex-end'   => array(
									'title' => __( 'Bottom', 'wolmart-core' ),
									'icon'  => 'eicon-h-align-right',
								),
							),
							'selectors' => array(
								( $selector . ' .wolmart-popup-content' ) => 'justify-content: {{VALUE}};',
							),
						)
					);

					$document->add_responsive_control(
						'popup_content_v_pos',
						array(
							'label'     => __( 'Vertical', 'wolmart-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => __( 'Top', 'wolmart-core' ),
									'icon'  => 'eicon-v-align-top',
								),
								'center'     => array(
									'title' => __( 'Middle', 'wolmart-core' ),
									'icon'  => 'eicon-v-align-middle',
								),
								'flex-end'   => array(
									'title' => __( 'Bottom', 'wolmart-core' ),
									'icon'  => 'eicon-v-align-bottom',
								),
							),
							'selectors' => array(
								( $selector . ' .wolmart-popup-content' ) => 'align-items: {{VALUE}};',
							),
						)
					);

					$document->add_control(
						'popup_pos_heading',
						array(
							'label'     => __( 'Position', 'wolmart-core' ),
							'type'      => Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$document->add_responsive_control(
						'popup_h_pos',
						array(
							'label'     => __( 'Horizontal', 'wolmart-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => __( 'Left', 'wolmart-core' ),
									'icon'  => 'eicon-h-align-left',
								),
								'center'     => array(
									'title' => __( 'Center', 'wolmart-core' ),
									'icon'  => 'eicon-h-align-center',
								),
								'flex-end'   => array(
									'title' => __( 'Right', 'wolmart-core' ),
									'icon'  => 'eicon-h-align-right',
								),
							),
							'selectors' => array(
								( $selector . ' .mfp-content' ) => 'justify-content: {{VALUE}};',
							),
						)
					);

					$document->add_responsive_control(
						'popup_v_pos',
						array(
							'label'     => __( 'Vertical', 'wolmart-core' ),
							'type'      => Elementor\Controls_Manager::CHOOSE,
							'toggle'    => false,
							'default'   => 'center',
							'options'   => array(
								'flex-start' => array(
									'title' => __( 'Top', 'wolmart-core' ),
									'icon'  => 'eicon-v-align-top',
								),
								'center'     => array(
									'title' => __( 'Middle', 'wolmart-core' ),
									'icon'  => 'eicon-v-align-middle',
								),
								'flex-end'   => array(
									'title' => __( 'Bottom', 'wolmart-core' ),
									'icon'  => 'eicon-v-align-bottom',
								),
							),
							'selectors' => array(
								( $selector . ' .mfp-content' ) => 'align-items: {{VALUE}};',
							),
						)
					);

					$document->add_control(
						'popup_style_heading',
						array(
							'label'     => __( 'Style', 'wolmart-core' ),
							'type'      => Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$document->add_control(
						'popup_overlay_color',
						array(
							'label'     => esc_html__( 'Overlay Color', 'wolmart-core' ),
							'type'      => Elementor\Controls_Manager::COLOR,
							'selectors' => array(
								( '.mfp-bg' . $selector ) => 'background-color: {{VALUE}};',
							),
						)
					);

					$document->add_control(
						'popup_content_color',
						array(
							'label'     => esc_html__( 'Content Color', 'wolmart-core' ),
							'type'      => Elementor\Controls_Manager::COLOR,
							'selectors' => array(
								( $selector . ' .popup .wolmart-popup-content' ) => 'background-color: {{VALUE}};',
							),
						)
					);

					$document->add_group_control(
						Elementor\Group_Control_Box_Shadow::get_type(),
						array(
							'name'     => 'popup_box_shadow',
							'selector' => ( $selector . ' .popup' ),
						)
					);

					$document->add_responsive_control(
						'popup_border_radius',
						array(
							'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
							'type'       => Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => array(
								'px',
								'%',
								'em',
							),
							'selectors'  => array(
								( $selector . ' .popup .wolmart-popup-content' ) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$document->add_responsive_control(
						'popup_margin',
						array(
							'label'      => esc_html__( 'Margin', 'wolmart-core' ),
							'type'       => Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => array(
								'px',
								'%',
								'em',
							),
							'selectors'  => array(
								( $selector . ' .popup' ) => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$document->add_control(
						'popup_animation',
						array(
							'type'      => Elementor\Controls_Manager::SELECT,
							'label'     => esc_html__( 'Popup Animation', 'wolmart-core' ),
							'options'   => wolmart_get_animations( 'in' ),
							'separator' => 'before',
							'default'   => 'default',
						)
					);

					$document->add_control(
						'popup_anim_duration',
						array(
							'type'    => Elementor\Controls_Manager::NUMBER,
							'label'   => esc_html__( 'Animation Duration (ms)', 'wolmart-core' ),
							'default' => 400,
						)
					);

					$document->add_control(
						'popup_desc_click',
						array(
							'type'        => Wolmart_Controls_Manager::DESCRIPTION,
							'description' => sprintf( esc_html__( 'Please add two classes - "show-popup popup-id-ID" to any elements you want to show this popup on click. %1$se.g) show-popup popup-id-725%2$s', 'wolmart-core' ), '<b>', '</b>' ),
						)
					);

				$document->end_controls_section();
			}
		}

		$document->start_controls_section(
			'wolmart_blank_styles',
			array(
				'label' => esc_html__( 'Wolmart Blank Styles', 'wolmart-core' ),
				'tab'   => Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$document->end_controls_section();

		$document->start_controls_section(
			'wolmart_custom_css_settings',
			array(
				'label' => esc_html__( 'Wolmart Custom CSS', 'wolmart-core' ),
				'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

			$document->add_control(
				'page_css',
				array(
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'rows' => 20,
				)
			);

		$document->end_controls_section();

		if ( current_user_can( 'unfiltered_html' ) ) {

			$document->start_controls_section(
				'wolmart_custom_js_settings',
				array(
					'label' => esc_html__( 'Wolmart Custom JS', 'wolmart-core' ),
					'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
				)
			);

			$document->add_control(
				'page_js',
				array(
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'rows' => 20,
				)
			);

			$document->end_controls_section();
		}
	}

	public function add_body_class( $classes ) {
		if ( wolmart_is_elementor_preview() && 'wolmart_template' == get_post_type() ) {
			$template_category = get_post_meta( get_the_ID(), 'wolmart_template_type', true );

			if ( ! $template_category ) {
				$template_category = 'block';
			}

			$classes[] = 'wolmart_' . $template_category . '_template';
		}
		return $classes;
	}

	public function add_appear_animations() {
		return wolmart_get_animations( 'appear' );
	}

	public function add_wp_widget_args( $args, $self ) {
		$args['before_widget'] = '<div class="widget ' . $self->get_widget_instance()->widget_options['classname'] . ' widget-collapsible">';
		$args['after_widget']  = '</div>';
		$args['before_title']  = '<h3 class="widget-title">';
		$args['after_title']   = '</h3>';

		return $args;
	}

	public function get_dependent_elementor_styles( $self ) {
		if ( 'file' == $self->get_meta()['status'] ) { // Re-check if it's not empty after CSS update.
			preg_match( '/post-(\d+).css/', $self->get_url(), $id );
			if ( count( $id ) == 2 ) {
				global $e_post_ids;

				wp_dequeue_style( 'elementor-post-' . $id[1] );

				// wp_register_style( 'elementor-post-' . $id[1], $self->get_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
				wp_register_style( 'elementor-post-' . $id[1], $self->get_url(), array( 'elementor-frontend' ), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

				if ( ! isset( $e_post_ids ) ) {
					$e_post_ids = array();
				}
				$e_post_ids[] = $id[1];
			}
		}
	}

	public function add_global_css() {
		global $wolmart_layout;
		$wolmart_layout['used_blocks'] = wolmart_get_page_blocks();

		if ( ! empty( $wolmart_layout['used_blocks'] ) ) {
			foreach ( $wolmart_layout['used_blocks'] as $block_id => $enqueued ) {
				if ( $this->is_elementor_block( $block_id ) ) {
					if ( ! wp_style_is( 'elementor-frontend' ) ) {
						wp_enqueue_style( 'elementor-icons' );
						wp_enqueue_style( 'elementor-frontend' );
						do_action( 'elementor/frontend/after_enqueue_styles' );
					}

					if ( isset( \Elementor\Plugin::$instance ) ) {

						// $kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
						// if ( $kit_id ) {
						// 	wp_enqueue_style( 'elementor-post-' . $kit_id, wp_upload_dir()['baseurl'] . '/elementor/css/post-' . $kit_id . '.css' );
						// }

						add_action(
							'wp_footer',
							function() {
								try {
									wp_enqueue_script( 'elementor-frontend' );
									$settings = \Elementor\Plugin::$instance->frontend->get_settings();
									\Elementor\Utils::print_js_config( 'elementor-frontend', 'elementorFrontendConfig', $settings );
								} catch ( Exception $e ) {
								}
							}
						);
					}

					if ( 'external' == get_option( 'elementor_css_print_method' ) ) {
						$scheme_css_file = Global_CSS::create( 'global.css' );
						$scheme_css_file->enqueue();
					}

					// $scheme_css_file = Global_CSS::create( 'global.css' );
					// $scheme_css_file->enqueue();

					break;
				}
			}
		}

		global $e_post_ids;
		if ( is_array( $e_post_ids ) ) {
			foreach ( $e_post_ids as $id ) {
				if ( get_the_ID() != $id ) {
					wp_enqueue_style( 'elementor-post-' . $id );
				}
			}
		}
	}

	public function is_elementor_block( $id ) {
		$elements_data = get_post_meta( $id, '_elementor_data', true );
		return $elements_data && get_post_meta( $id, '_elementor_edit_mode', true );
	}

	public function add_elementor_css() {
		// Add Wolmart elementor style
		wp_enqueue_style( 'wolmart-elementor-style', WOLMART_PLUGINS_URI . '/elementor/elementor' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );

		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			wp_enqueue_style( 'wolmart-elementor-pro-style', WOLMART_PLUGINS_URI . '/elementor/elementor-pro' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );
		}

		// Add page css
		if ( is_singular() ) {
			if ( 'internal' !== get_option( 'elementor_css_print_method' ) ) { // external
				wp_enqueue_style( 'elementor-post-' . intval( get_the_ID() ) );
			} elseif ( wp_style_is( 'elementor-frontend' ) ) { // internal
				$inline_styles = wp_styles()->get_data( 'elementor-frontend', 'after' );
				if ( is_array( $inline_styles ) && ! empty( $inline_styles ) ) {
					$post_css = array_pop( $inline_styles );
					if ( $post_css ) {
						wp_styles()->add_data( 'elementor-frontend', 'after', $inline_styles );
						wp_add_inline_style( 'wolmart-theme', $post_css );
					}
				}
			}
		}
	}

	public function add_block_css() {
		global $wolmart_layout;

		if ( ! empty( $wolmart_layout['used_blocks'] ) ) {
			$upload     = wp_upload_dir();
			$upload_dir = $upload['basedir'];
			$upload_url = $upload['baseurl'];

			foreach ( $wolmart_layout['used_blocks'] as $block_id => $enqueued ) {
				if ( 'internal' !== get_option( 'elementor_css_print_method' ) && ( ! wolmart_is_elementor_preview() || ! isset( $_REQUEST['elementor-preview'] ) || $_REQUEST['elementor-preview'] != $block_id ) && $this->is_elementor_block( $block_id ) ) { // Check if current elementor block is editing

					$block_css = get_post_meta( (int) $block_id, 'page_css', true );
					if ( $block_css ) {
						$block_css = function_exists( 'wolmart_minify_css' ) ? wolmart_minify_css( $block_css ) : $block_css;
					}

					$post_css_path = wp_normalize_path( $upload_dir . '/elementor/css/post-' . $block_id . '.css' );
					if ( file_exists( $post_css_path ) ) {
						wp_enqueue_style( 'elementor-post-' . $block_id, $upload_url . '/elementor/css/post-' . $block_id . '.css' );
						wp_add_inline_style( 'elementor-post-' . $block_id, apply_filters( 'wolmart_elementor_block_style', $block_css ) );
					} else {
						$css_file  = new Elementor\Core\Files\CSS\Post( $block_id );
						$elementor_page_css = $css_file->get_content();
						$block_css = $elementor_page_css . apply_filters( 'wolmart_elementor_block_style', $block_css );

						// Save block css as elementor post css.
						// filesystem
						global $wp_filesystem;
						// Initialize the WordPress filesystem, no more using file_put_contents function
						if ( empty( $wp_filesystem ) ) {
							require_once ABSPATH . '/wp-admin/includes/file.php';
							WP_Filesystem();
						}
						$wp_filesystem->put_contents( $post_css_path, $elementor_page_css, FS_CHMOD_FILE );

						// Fix elementor's "max-width: auto" error.
						$block_css = str_replace( 'max-width:auto', 'max-width:none', $block_css );
						wp_add_inline_style( 'wolmart-style', $block_css );
					}

					$wolmart_layout['used_blocks'][ $block_id ]['css'] = true;
				}
			}
		}
	}

	/**
	 * Remove elementor action to update dynamic post css.
	 */
	public function remove_dynamic_css_update() {
		remove_action( 'elementor/css-file/post/enqueue', array( Elementor\Plugin::$instance->dynamic_tags, 'after_enqueue_post_css' ) );
	}
}

/**
 * Create instance
 */
Wolmart_Core_Elementor::get_instance();

if ( ! function_exists( 'wolmart_elementor_if_dom_optimization' ) ) :
	function wolmart_elementor_if_dom_optimization() {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return false;
		}
		if ( version_compare( ELEMENTOR_VERSION, '3.1.0', '>=' ) ) {
			return \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' );
		} elseif ( version_compare( ELEMENTOR_VERSION, '3.0', '>=' ) ) {
			return ( ! \Elementor\Plugin::instance()->get_legacy_mode( 'elementWrappers' ) );
		}
		return false;
	}
endif;
