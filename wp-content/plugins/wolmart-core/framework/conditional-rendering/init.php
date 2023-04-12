<?php

/**
 * Conditional Rendering
 *
 * @author     D-THEMES
 * @package    Wolmart
 * @subpackage Core
 * @since      1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Automattic\Jetpack\Device_Detection;

/**
 * Wolmart Conditional Rendering Class
 *
 * @since 2.3.0
 */
class Wolmart_Conditional_Rendering {
	/**
	 * The Instance Object.
	 *
	 * @since 2.3.0
	 */
	public static $instance;

	/**
	 * The device object
	 *
	 * @since 2.3.0
	 */
	public $device;

	/**
	 * Get the instance.
	 *
	 * @since 2.3.0
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * The Constructor.
	 *
	 * @since 2.3.0
	 */
	public function __construct() {
		add_action( 'elementor/element/section/section_general/after_section_end', array( $this, 'add_condition_system' ), 10, 2 );
		add_action( 'elementor/element/column/column_additional/after_section_end', array( $this, 'add_condition_system' ), 10, 2 );
		add_filter( 'elementor/frontend/section/should_render', array( $this, 'should_render' ), 10, 2 );
		add_filter( 'elementor/frontend/column/should_render', array( $this, 'should_render' ), 10, 2 );

		add_action( 'vc_after_init', array( $this, 'add_wpb_condition' ), 25 );
		add_filter( 'wolmart_wpb_should_render', array( $this, 'wpb_should_render' ), 10, 2 );
	}

	/**
	 * Add WPBakery Options
	 *
	 * @since 2.4.0
	 */
	public function add_wpb_condition() {
		if ( function_exists( 'vc_map' ) ) {
			$add_params = array(
				array(
					'param_name'  => 'condition_a',
					'heading'     => esc_html__( 'Condition A', 'wolmart-core' ),
					'description' => esc_html__( 'Select condition type.', 'wolmart-core' ),
					'type'        => 'dropdown',
					'group'       => esc_html__( 'Wolmart Conditional System', 'wolmart-core' ),
					'value'       => array(
						'' => '',
						esc_html__( 'Device', 'wolmart-core' ) => 'device',
						esc_html__( 'Login Status', 'wolmart-core' ) => 'login_status',
						esc_html__( 'User Role', 'wolmart-core' ) => 'user_role',
					),
					'std'         => '',
				),
				array(
					'param_name' => 'comparative_operator',
					'heading'    => esc_html__( 'Comparative Operator', 'wolmart-core' ),
					'type'       => 'dropdown',
					'group'      => esc_html__( 'Wolmart Conditional System', 'wolmart-core' ),
					'value'      => array(
						'' => '',
						esc_html__( '==', 'wolmart-core' ) => 'equal',
						esc_html__( '!=', 'wolmart-core' ) => 'not_equal',
					),
					'std'        => '',
				),
				array(
					'param_name' => 'value_device',
					'heading'    => esc_html__( 'Device', 'wolmart-core' ),
					'type'       => 'dropdown',
					'group'      => esc_html__( 'Wolmart Conditional System', 'wolmart-core' ),
					'value'      => array(
						'' => '',
						__( 'Desktop', 'wolmart-core' ) => 'desktop',
						__( 'Tablet & Mobile', 'wolmart-core' ) => 'tablet_mobile',
						__( 'Tablet', 'wolmart-core' ) => 'tablet',
						__( 'Mobile', 'wolmart-core' ) => 'mobile',
					),
					'dependency' => array(
						'element' => 'condition_a',
						'value'   => 'device',
					),
					'std'        => '',
				),
				array(
					'param_name' => 'value_login',
					'heading'    => esc_html__( 'Status', 'wolmart-core' ),
					'type'       => 'dropdown',
					'group'      => esc_html__( 'Wolmart Conditional System', 'wolmart-core' ),
					'value'      => array(
						'' => '',
						esc_html__( 'Logged In', 'wolmart-core' ) => 'login',
						esc_html__( 'Logged Out', 'wolmart-core' ) => 'logout',
					),
					'dependency' => array(
						'element' => 'condition_a',
						'value'   => 'login_status',
					),
					'std'        => '',
				),
				array(
					'param_name' => 'value_role',
					'heading'    => esc_html__( 'Role', 'wolmart-core' ),
					'type'       => 'dropdown',
					'group'      => esc_html__( 'Wolmart Conditional System', 'wolmart-core' ),
					'value'      => array_flip( $this->get_roles() ),
					'dependency' => array(
						'element' => 'condition_a',
						'value'   => 'user_role',
					),
					'std'        => '',
				),
				array(
					'param_name'  => 'condition_operator',
					'heading'     => esc_html__( 'Operator', 'wolmart-core' ),
					'description' => esc_html__( 'The selected value is used to operate on the conditions below.', 'wolmart-core' ),
					'type'        => 'dropdown',
					'group'       => esc_html__( 'Wolmart Conditional System', 'wolmart-core' ),
					'value'       => array(
						'' => '',
						esc_html__( 'And', 'wolmart-core' ) => 'and',
						esc_html__( 'Or', 'wolmart-core' ) => 'or',
					),
					'std'         => '',
				),
			);
			vc_add_param(
				'vc_section',
				array(
					'type'       => 'param_group',
					'param_name' => 'conditional_render',
					'heading'    => esc_html__( 'Conditional Render', 'wolmart-core' ),
					'params'     => $add_params,
					'group'      => esc_html__( 'Wolmart Conditional System', 'wolmart-core' ),
				)
			);
			vc_add_param(
				'vc_row',
				array(
					'type'       => 'param_group',
					'param_name' => 'conditional_render',
					'heading'    => esc_html__( 'Conditional Render', 'wolmart-core' ),
					'params'     => $add_params,
					'group'      => esc_html__( 'Wolmart Conditional System', 'wolmart-core' ),
				)
			);
			vc_add_param(
				'vc_column',
				array(
					'type'       => 'param_group',
					'param_name' => 'conditional_render',
					'heading'    => esc_html__( 'Conditional Render', 'wolmart-core' ),
					'params'     => $add_params,
					'group'      => esc_html__( 'Wolmart Conditional System', 'wolmart-core' ),
				)
			);
		}
	}

	/**
	 * Add Control
	 *
	 * @since 2.3.0
	 */
	public function add_condition_system( $self ) {
		$self->start_controls_section(
			'section_conditional',
			array(
				'label' => esc_html__( 'Wolmart Conditional System', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'condition_a',
			array(
				'label'       => esc_html__( 'Condition A', 'wolmart-core' ),
				'description' => esc_html__( 'Select condition type.', 'wolmart-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'device'       => esc_html__( 'Device', 'wolmart-core' ),
					'login_status' => esc_html__( 'Login Status', 'wolmart-core' ),
					'user_role'    => esc_html__( 'User Role', 'wolmart-core' ),
				),
			)
		);
		$repeater->add_control(
			'comparative_operator',
			array(
				'label'   => esc_html__( 'Comparative Operator', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'equal'     => esc_html__( '==', 'wolmart-core' ),
					'not_equal' => esc_html__( '!=', 'wolmart-core' ),
				),
			)
		);
		$repeater->add_control(
			'value_device',
			array(
				'label'     => esc_html__( 'Device', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'desktop'       => esc_html__( 'Desktop', 'wolmart-core' ),
					'tablet_mobile' => esc_html__( 'Tablet & Mobile', 'wolmart-core' ),
					'tablet'        => esc_html__( 'Tablet', 'wolmart-core' ),
					'mobile'        => esc_html__( 'Mobile', 'wolmart-core' ),
				),
				'condition' => array(
					'condition_a' => 'device',
				),
			)
		);
		$repeater->add_control(
			'value_login',
			array(
				'label'     => esc_html__( 'Status', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'login'  => esc_html__( 'Logged In', 'wolmart-core' ),
					'logout' => esc_html__( 'Logged Out', 'wolmart-core' ),
				),
				'condition' => array(
					'condition_a' => 'login_status',
				),
			)
		);
		$repeater->add_control(
			'value_role',
			array(
				'label'     => esc_html__( 'Role', 'wolmart-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_roles(),
				'condition' => array(
					'condition_a' => 'user_role',
				),
			)
		);
		$repeater->add_control(
			'condition_operator',
			array(
				'label'       => esc_html__( 'Operator', 'wolmart-core' ),
				'description' => esc_html__( 'The selected value is used to operate on the conditions below.', 'wolmart-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'and' => esc_html__( 'And', 'wolmart-core' ),
					'or'  => esc_html__( 'Or', 'wolmart-core' ),
				),
			)
		);

		$self->add_control(
			'description_conditional_render',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Only when these conditions are matched, will this section be rendered.', 'wolmart-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$self->add_control(
			'conditional_render',
			array(
				'label'         => esc_html__( 'Conditional Render', 'wolmart-core' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field'   => '{{{ condition_a }}}',
			)
		);

		$self->end_controls_section();
	}

	/**
	 * Returns the roles.
	 *
	 * @since 2.3.0
	 */
	public function get_roles() {
		global $wp_roles;
		$roles = array();
		if ( is_array( $wp_roles->roles ) ) {
			foreach ( $wp_roles->roles as $key => $role ) {
				$roles[ $key ] = $role['name'];
			}
		}
		return $roles;
	}

	/**
	 * Get the device
	 *
	 * @since 2.3.0
	 */
	public function get_device( $is_tablet_mobile = false ) {
		if ( ! class_exists( 'Device_Detection' ) ) {
			require_once 'jetpack-device-detection/class-device-detection.php';
			require_once 'jetpack-device-detection/class-user-agent-info.php';
		}
		$critical_mobile = ! empty( $_REQUEST['mobile_url'] );
		if ( ( $critical_mobile || Device_Detection::is_phone() ) && ! $is_tablet_mobile ) {
			return 'mobile';
		} elseif ( Device_Detection::is_tablet() && ! $is_tablet_mobile ) {
			return 'tablet';
		} elseif ( ! wp_is_mobile() ) {
			return 'desktop';
		} elseif ( wp_is_mobile() ) {
			return 'tablet_mobile';
		}
		return '';
	}

	/**
	 * Check if the element should be rendered or not in WPBakery.
	 *
	 * @since 2.4.0
	 */
	public function wpb_should_render( $should_render, $conditional_render ) {
		global $pagenow;
		if ( function_exists( 'vc_is_inline' ) && ! ( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) || vc_is_inline() ) && ! $this->is_render( array( 'conditional_render' => $conditional_render ) ) ) {
			return false;
		}
		return $should_render;
	}

	/**
	 * Check if the element should be rendered or not.
	 *
	 * @since 2.3.0
	 */
	public function should_render( $should_render, $self ) {
		$atts = $self->get_settings_for_display();
		if ( function_exists( 'wolmart_is_elementor_preview' ) && ! wolmart_is_elementor_preview() && ! $this->is_render( $atts ) ) {
			return false;
		}
		return $should_render;
	}

	/**
	 * Is rendering?
	 *
	 * @since 2.3.0
	 */
	public function is_render( $atts ) {

		if ( isset( $atts['conditional_render'] ) && is_array( $atts['conditional_render'] ) ) {
			foreach ( $atts['conditional_render'] as $condition ) {
				if ( ! empty( $condition['condition_a'] ) ) {
					switch ( $condition['condition_a'] ) {
						case 'device':
							if ( ! empty( $condition['value_device'] ) ) {
								$right = $condition['value_device'];
							}
							$left = $this->get_device( isset( $right ) && 'tablet_mobile' == $right ? true : false );
							break;
						case 'login_status':
							$left = is_user_logged_in();
							if ( ! empty( $condition['value_login'] ) ) {
								$right = ( 'login' == $condition['value_login'] ? true : false );
							}
							break;
						case 'user_role':
								$left = wp_get_current_user();
								$left = ( 0 !== $left->ID ) ? $left->roles : array();
							if ( ! empty( $condition['value_role'] ) ) {
								$right = $condition['value_role'];
							}
							break;
					}
					if ( ! empty( $condition['comparative_operator'] ) ) {
						$operator = $condition['comparative_operator'];
					}
					if ( ! empty( $condition['condition_operator'] ) ) {
						$condition_operator = $condition['condition_operator'];
					}
					if ( isset( $left ) && isset( $right ) && isset( $operator ) ) {
						if ( 'equal' == $operator ) {
							if ( is_array( $left ) ) {
								$res = in_array( $right, $left );
							} else {
								$res = ( $left == $right );
							}
						} else {
							if ( is_array( $left ) ) {
								$res = ! in_array( $right, $left );
							} else {
								$res = ( $left != $right );
							}
						}
						if ( isset( $render ) ) {
							if ( isset( $prev_operator ) && 'or' == $prev_operator ) {
								$render = $render || $res;
							} else {
								$render = $render && $res;
							}
						} else {
							$render = $res;
						}
						if ( isset( $condition_operator ) ) {
							$prev_operator = $condition_operator;
						} else { // not select
							$prev_operator = 'and';
						}
					}
				}
			}
		}

		return isset( $render ) ? $render : true;
	}
}

Wolmart_Conditional_Rendering::get_instance();
