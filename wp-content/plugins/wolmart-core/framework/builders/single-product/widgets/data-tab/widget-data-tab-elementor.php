<?php
/**
 * Wolmart Elementor Single Product Data_tab Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

class Wolmart_Single_Product_Data_Tab_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_sproduct_data_tab';
	}

	public function get_title() {
		return esc_html__( 'Product Data Tabs', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-product-tabs';
	}

	public function get_categories() {
		return array( 'wolmart_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'data_tab' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
		}
		return $depends;
	}

	public function before_render() {
		// Add `elementor-widget-theme-post-content` class to avoid conflicts that figure gets zero margin.
		$this->add_render_attribute(
			array(
				'_wrapper' => array(
					'class' => 'elementor-widget-theme-post-content',
				),
			)
		);

		parent::before_render();
	}


	protected function register_controls() {

		$this->start_controls_section(
			'section_product_data_tab',
			array(
				'label' => esc_html__( 'Content', 'wolmart-core' ),
			)
		);

			$this->add_control(
				'sp_tab_type',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Type', 'wolmart-core' ),
					'default' => 'theme',
					'options' => array(
						'theme'     => esc_html__( 'Theme Option', 'wolmart-core' ),
						''          => esc_html__( 'Tab', 'wolmart-core' ),
						'accordion' => esc_html__( 'Accordion', 'wolmart-core' ),
					),
				)
			);

			$this->add_control(
				'sp_tab_link_align',
				array(
					'label'     => esc_html__( 'Align', 'wolmart-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'flex-start' => array(
							'title' => esc_html__( 'Left', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => esc_html__( 'Center', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Right', 'wolmart-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .wc-tabs > .tabs' => 'justify-content: {{VALUE}};',
					),
					'condition' => array(
						'sp_tab_type' => array( '', 'theme' ),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_tab_link_typo',
					'label'    => esc_html__( 'Link Typography', 'wolmart-core' ),
					'selector' => '.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link, .elementor-element-{{ID}} .card-header a',
				)
			);

			$this->start_controls_tabs( 'sp_share_tabs' );
				$this->start_controls_tab(
					'sp_tab_link_tab',
					array(
						'label' => esc_html__( 'Normal', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'sp_tab_link_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link, .elementor-element-{{ID}} .card-header a' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'sp_tab_link_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link, .elementor-element-{{ID}} .card-header a' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'sp_tab_link_border',
							'selector' => '.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link, .elementor-element-{{ID}} .wc-tabs>.card',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_tab_link_hover_tab',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'sp_tab_link_hover_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link:hover, .elementor-element-{{ID}} .card-header a:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'sp_tab_link_hover_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link:hover, .elementor-element-{{ID}} .card-header a:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'sp_tab_link_hover_border',
							'selector' => '.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link:hover, .elementor-element-{{ID}} .wc-tabs>.card:hover a',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_tab_link_active_tab',
					array(
						'label' => esc_html__( 'Active', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'sp_tab_link_active_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link.active, .elementor-element-{{ID}} .card-header .collapse' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'sp_tab_link_active_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link.active, .elementor-element-{{ID}} .card-header .collapse' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'sp_tab_link_active_border',
							'selector' => '.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link.active, .elementor-element-{{ID}} .card.active',
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'sp_tab_link_dimen',
				array(
					'label'      => esc_html__( 'Link Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
					),
					'separator'  => 'before',
					'selectors'  => array(
						'.elementor-element-{{ID}} .wc-tabs>.tabs .nav-link, .elementor-element-{{ID}} .card-header a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'sp_tab_content_dimen',
				array(
					'label'      => esc_html__( 'Content Padding', 'wolmart-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .panel.woocommerce-Tabs-panel'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}

	public function get_tab_type( $type ) {
		$sp_type = $this->get_settings_for_display( 'sp_tab_type' );
		if ( 'accordion' == $sp_type ) {
			$type = $sp_type;
		}
		return $type;
	}

	protected function render() {

		if ( apply_filters( 'wolmart_single_product_builder_set_product', false ) ) {

			add_filter( 'wolmart_single_product_data_tab_type', array( $this, 'get_tab_type' ), 20 );

			woocommerce_output_product_data_tabs();

			remove_filter( 'wolmart_single_product_data_tab_type', array( $this, 'get_tab_type' ), 20 );

			do_action( 'wolmart_single_product_builder_unset_product' );
		}
	}
}
