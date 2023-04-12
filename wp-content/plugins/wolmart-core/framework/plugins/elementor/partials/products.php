<?php
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Wolmart_Controls_Manager;

/**
 * Register elementor products layout controls
 */
function wolmart_elementor_products_layout_controls( $self, $mode = '' ) {

	$self->start_controls_section(
		'section_products_layout',
		array(
			'label' => esc_html__( 'Products Layout', 'wolmart-core' ),
		)
	);

	$self->add_control(
		'layout_type',
		array(
			'label'   => esc_html__( 'Products Layout', 'wolmart-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'custom_layouts' == $mode ? 'creative' : 'grid',
			'options' => array(
				'grid'     => esc_html__( 'Grid', 'wolmart-core' ),
				'slider'   => esc_html__( 'Slider', 'wolmart-core' ),
				'creative' => esc_html__( 'Creative', 'wolmart-core' ),
			),
		)
	);

	$self->add_group_control(
		Group_Control_Image_Size::get_type(),
		array(
			'name'    => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
			'default' => 'woocommerce_thumbnail',
		)
	);

	wolmart_elementor_grid_layout_controls( $self, 'layout_type', true, 'product' );
	wolmart_elementor_slider_layout_controls( $self, 'layout_type' );

	$self->end_controls_section();

	if ( ! $mode ) {

		$self->start_controls_section(
			'product_filter_section',
			array(
				'label' => esc_html__( 'Product Ajax', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			wolmart_elementor_loadmore_layout_controls( $self, 'layout_type' );

			$self->add_control(
				'filter_cat_w',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Filter by Category Widget', 'wolmart-core' ),
					'description' => esc_html__( 'If there is a category widget enabled "Filter Products" option in the same section, you can filter products by category widget.', 'wolmart-core' ),
				)
			);

			$self->add_control(
				'filter_cat',
				array(
					'type'  => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Filter by Category', 'wolmart-core' ),
				)
			);

			$self->add_control(
				'show_all_filter',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Show "All" Filter', 'wolmart-core' ),
					'default'   => 'yes',
					'condition' => array(
						'filter_cat' => 'yes',
					),
				)
			);

		$self->end_controls_section();
	}
}
/**
 * Register elementor products select controls
 */
function wolmart_elementor_products_select_controls( $self, $add_section = true, $widget = '' ) {

	if ( $add_section ) {
		$self->start_controls_section(
			'section_products_selector',
			array(
				'label' => esc_html__( 'Products Selector', 'wolmart-core' ),
			)
		);
	}

	$self->add_control(
		'product_ids',
		array(
			'label'       => esc_html__( 'Select Products', 'wolmart-core' ),
			'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
			'options'     => 'product',
			'label_block' => true,
			'multiple'    => 'true',
		)
	);

	$self->add_control(
		'categories',
		array(
			'label'       => esc_html__( 'Select Categories', 'wolmart-core' ),
			'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
			'options'     => 'product_cat',
			'label_block' => true,
			'multiple'    => 'true',
		)
	);

	$self->add_control(
		'brands',
		array(
			'label'       => esc_html__( 'Select Brands', 'wolmart-core' ),
			'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
			'options'     => 'product_brand',
			'label_block' => true,
			'multiple'    => 'true',
		)
	);

	$self->add_control(
		'count',
		array(
			'type'    => Controls_Manager::SLIDER,
			'label'   => esc_html__( 'Product Count', 'wolmart-core' ),
			'default' => array(
				'unit' => 'px',
				'size' => 10,
			),
			'range'   => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 50,
				),
			),
		)
	);

	$self->add_control(
		'status',
		array(
			'label'   => esc_html__( 'Product Status', 'wolmart-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''         => esc_html__( 'All', 'wolmart-core' ),
				'featured' => esc_html__( 'Featured', 'wolmart-core' ),
				'sale'     => esc_html__( 'On Sale', 'wolmart-core' ),
				'viewed'   => esc_html__( 'Recently Viewed', 'wolmart-core' ),
			),
		)
	);

	if ( 'products' == $widget ) {
		$self->add_control(
			'viewed_mode',
			array(
				'label'     => esc_html__( 'Is Dropdown?', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => array(
					'status' => 'viewed',
				),
			)
		);

		$self->add_control(
			'viewed_icon',
			array(
				'label'   => esc_html__( 'View Icon', 'wolmart-core' ),
				'type'    => Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block'  => false,
				'exclude_inline_options' => array(
					'svg',
				),
				'default' => array(
					'value'   => 'w-icon-return',
					'library' => 'wolmart-icons',
				),
				'condition' => array(
					'status' => 'viewed',
					'viewed_mode' => 'yes',
				),
			)
		);

		$self->add_control(
			'viewed_placeholder',
			array(
				'label'   => esc_html__( 'View Text', 'wolmart-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Recently Viewed', 'wolmart-core' ),
				'condition' => array(
					'status' => array( 'viewed' ),
					'viewed_mode' => 'yes',
				),
			)
		);
	}

	$self->add_control(
		'orderby',
		array(
			'type'      => Controls_Manager::SELECT,
			'label'     => esc_html__( 'Order By', 'wolmart-core' ),
			'default'   => '',
			'options'   => array(
				''               => esc_html__( 'Default', 'wolmart-core' ),
				'ID'             => esc_html__( 'ID', 'wolmart-core' ),
				'title'          => esc_html__( 'Name', 'wolmart-core' ),
				'date'           => esc_html__( 'Date', 'wolmart-core' ),
				'modified'       => esc_html__( 'Modified', 'wolmart-core' ),
				'price'          => esc_html__( 'Price', 'wolmart-core' ),
				'rand'           => esc_html__( 'Random', 'wolmart-core' ),
				'rating'         => esc_html__( 'Rating', 'wolmart-core' ),
				'comment_count'  => esc_html__( 'Comment count', 'wolmart-core' ),
				'popularity'     => esc_html__( 'Total Sales', 'wolmart-core' ),
				'wishqty'        => esc_html__( 'Wish', 'wolmart-core' ),
				'sale_date_to'   => esc_html__( 'Sale End Date', 'wolmart-core' ),
				'sale_date_from' => esc_html__( 'Sale Start Date', 'wolmart-core' ),
			),
			'separator' => 'before',
			'condition' => array(
				'status!' => 'viewed',
			),
		)
	);

	$self->add_control(
		'orderway',
		array(
			'type'    => Controls_Manager::SELECT,
			'label'   => esc_html__( 'Order Way', 'wolmart-core' ),
			'default' => 'ASC',
			'options' => array(
				'ASC'  => esc_html__( 'Ascending', 'wolmart-core' ),
				'DESC' => esc_html__( 'Descending', 'wolmart-core' ),
			),
			'condition' => array(
				'status!' => 'viewed',
			),
		)
	);

	$self->add_control(
		'order_from',
		array(
			'label'       => esc_html__( 'Date From', 'wolmart-core' ),
			'description' => esc_html__( 'Start date that the ordering will be applied', 'wolmart-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''       => '',
				'today'  => esc_html__( 'Today', 'wolmart-core' ),
				'week'   => esc_html__( 'This Week', 'wolmart-core' ),
				'month'  => esc_html__( 'This Month', 'wolmart-core' ),
				'year'   => esc_html__( 'This Year', 'wolmart-core' ),
				'custom' => esc_html__( 'Custom', 'wolmart-core' ),
			),
			'condition'   => array(
				'product_ids' => '',
				'status!' => 'viewed',
			),
		)
	);

	$self->add_control(
		'order_from_date',
		array(
			'label'     => esc_html__( 'Date', 'wolmart-core' ),
			'type'      => Controls_Manager::DATE_TIME,
			'default'   => '',
			'condition' => array(
				'product_ids' => '',
				'order_from'  => 'custom',
				'status!' => 'viewed',
			),
		)
	);

	$self->add_control(
		'order_to',
		array(
			'label'       => esc_html__( 'Date To', 'wolmart-core' ),
			'description' => esc_html__( 'End date that the ordering will be applied', 'wolmart-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''       => '',
				'today'  => esc_html__( 'Today', 'wolmart-core' ),
				'week'   => esc_html__( 'This Week', 'wolmart-core' ),
				'month'  => esc_html__( 'This Month', 'wolmart-core' ),
				'year'   => esc_html__( 'This Year', 'wolmart-core' ),
				'custom' => esc_html__( 'Custom', 'wolmart-core' ),
			),
			'condition'   => array(
				'product_ids' => '',
				'status!' => 'viewed',
			),
		)
	);

	$self->add_control(
		'order_to_date',
		array(
			'label'     => esc_html__( 'Date', 'wolmart-core' ),
			'type'      => Controls_Manager::DATE_TIME,
			'default'   => '',
			'condition' => array(
				'product_ids' => '',
				'order_to'    => 'custom',
			),
		)
	);

	// $self->add_control(
	// 	'hide_out_date',
	// 	array(
	// 		'type'      => Controls_Manager::SWITCHER,
	// 		'label'     => esc_html__( 'Hide Product Out of Date', 'wolmart-core' ),
	// 		'condition' => array(
	// 			'product_ids' => '',
	// 		),
	// 	)
	// );

	if ( $add_section ) {
		$self->end_controls_section();
	}
}

/**
 * Register elementor single product style controls
 */
function wolmart_elementor_single_product_style_controls( $self ) {
	$self->start_controls_section(
		'section_sp_style',
		array(
			'label' => esc_html__( 'Single Product', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'product_summary_height',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Summary Max Height', 'wolmart-core' ),
				'size_units' => array( 'px', 'rem', '%' ),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-single.product-widget .summary' => 'max-height: {{SIZE}}{{UNIT}}; overflow-y: auto;',
				),
			)
		);

		$self->start_controls_tabs(
			'sp_tabs',
			array(
				'separator' => 'before',
			)
		);

			$self->start_controls_tab(
				'sp_title_tab',
				array(
					'label' => esc_html__( 'Title', 'wolmart-core' ),
				)
			);

				$self->add_control(
					'sp_title_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .product_title a' => 'color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'sp_title_typo',
						'scheme'   => Typography::TYPOGRAPHY_1,
						'selector' => '.elementor-element-{{ID}} .product_title',
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'sp_price_tab',
				array(
					'label' => esc_html__( 'Price', 'wolmart-core' ),
				)
			);

				$self->add_control(
					'sp_price_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} p.price' => 'color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'sp_price_typo',
						'scheme'   => Typography::TYPOGRAPHY_1,
						'selector' => '.elementor-element-{{ID}} p.price',
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'sp_old_price_tab',
				array(
					'label' => esc_html__( 'Old Price', 'wolmart-core' ),
				)
			);

				$self->add_control(
					'sp_old_price_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price del' => 'color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'sp_old_price_typo',
						'scheme'   => Typography::TYPOGRAPHY_1,
						'selector' => '.elementor-element-{{ID}} .price del',
					)
				);

			$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_control(
			'style_heading_countdown',
			array(
				'label'     => esc_html__( 'Countdown', 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_control(
			'sp_countdown_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-coundown-container' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'sp_countdown_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-countdown-container' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sp_countdown_typo',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '.elementor-element-{{ID}} .product-countdown-container',
			)
		);

		$self->add_control(
			'style_cart_button',
			array(
				'label'     => esc_html__( 'Add To Cart Button', 'wolmart-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->start_controls_tabs( 'sp_cart_tabs' );

			$self->start_controls_tab(
				'sp_cart_btn_tab',
				array(
					'label' => esc_html__( 'Default', 'wolmart-core' ),
				)
			);

				$self->add_control(
					'sp_cart_btn_bg',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							// Stronger selector to avoid section style from overwriting
							'.elementor-element-{{ID}} .single_add_to_cart_button' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
						),
					)
				);

				$self->add_control(
					'sp_cart_btn_color',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .single_add_to_cart_button' => 'color: {{VALUE}};',
						),
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'sp_cart_btn_tab_hover',
				array(
					'label' => esc_html__( 'Hover', 'wolmart-core' ),
				)
			);

				$self->add_control(
					'sp_cart_btn_bg_hover',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							// Stronger selector to avoid section style from overwriting
							'.elementor-element-{{ID}} .single_add_to_cart_button:not(.disabled):hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
						),
					)
				);

				$self->add_control(
					'sp_cart_btn_color_hover',
					array(
						'label'     => esc_html__( 'Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .single_add_to_cart_button:hover' => 'color: {{VALUE}};',
						),
					)
				);

			$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sp_cart_btn_typo',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '.elementor-element-{{ID}} .single_add_to_cart_button',
			)
		);

	$self->end_controls_section();
}
/**
 * Register elementor product type controls
 */
function wolmart_elementor_product_type_controls( $self ) {

	$self->start_controls_section(
		'section_product_type',
		array(
			'label' => esc_html__( 'Product Type', 'wolmart-core' ),
		)
	);

		$self->add_control(
			'follow_theme_option',
			array(
				'label'   => esc_html__( 'Follow Theme Option', 'wolmart-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$self->add_control(
			'product_type',
			array(
				'label'     => esc_html__( 'Product Type', 'wolmart-core' ),
				'type'      => Wolmart_Controls_Manager::IMAGE_CHOOSE,
				'default'   => '',
				'options'   => array(
					''          => 'assets/images/products/product-1.jpg',
					'product-2' => 'assets/images/products/product-2.jpg',
					'product-3' => 'assets/images/products/product-3.jpg',
					'product-4' => 'assets/images/products/product-4.jpg',
					'product-5' => 'assets/images/products/product-5.jpg',
					'product-6' => 'assets/images/products/product-6.jpg',
					'product-7' => 'assets/images/products/product-7.jpg',
					'product-8' => 'assets/images/products/product-8.jpg',
					'product-9' => 'assets/images/products/product-9.jpg',
					'widget'    => 'assets/images/products/product-widget.jpg',
					'list'      => 'assets/images/products/product-list.jpg',
				),
				'width'     => 3,
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'show_in_box',
			array(
				'label'     => esc_html__( 'Show In Box', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'show_hover_shadow',
			array(
				'label'     => esc_html__( 'Shadow Effect on Hover', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'follow_theme_option' => '',
					'product_type!'       => array( 'product-5', 'product-6', 'product-7' ),
				),
			)
		);

		$self->add_control(
			'show_media_shadow',
			array(
				'label'     => esc_html__( 'Media Shadow Effect on Hover', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'show_info',
			array(
				'type'      => Controls_Manager::SELECT2,
				'label'     => esc_html__( 'Show Information', 'wolmart-core' ),
				'multiple'  => true,
				'default'   => array(
					'category',
					'label',
					'price',
					'rating',
					'countdown',
					'addtocart',
					'compare',
					'quickview',
					'wishlist',
				),
				'options'   => array(
					'category'     => esc_html__( 'Category', 'wolmart-core' ),
					'label'        => esc_html__( 'Label', 'wolmart-core' ),
					'price'        => esc_html__( 'Price', 'wolmart-core' ),
					'rating'       => esc_html__( 'Rating', 'wolmart-core' ),
					'attribute'    => esc_html__( 'Attribute', 'wolmart-core' ),
					'countdown'    => esc_html__( 'Deal Countdown', 'wolmart-core' ),
					'addtocart'    => esc_html__( 'Add To Cart', 'wolmart-core' ),
					'compare'      => esc_html__( 'Compare', 'wolmart-core' ),
					'quickview'    => esc_html__( 'Quickview', 'wolmart-core' ),
					'wishlist'     => esc_html__( 'Wishlist', 'wolmart-core' ),
					'short_desc'   => esc_html__( 'Short Description', 'wolmart-core' ),
					'sold_by'      => esc_html__( 'Sold By', 'wolmart-core' ),
				),
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'desc_line_clamp',
			array(
				'label'      => esc_html__( 'Line Clamp', 'wolmart-core' ),
				'type'       => Controls_Manager::NUMBER,
				'selectors'  => array(
					'.elementor-element-{{ID}} .short-desc p' => 'display: -webkit-box; -webkit-line-clamp: {{VALUE}}; -webkit-box-orient: vertical; overflow: hidden;',
				),
				'default'    => 3,
				'conditions' => array(
					'relation' => 'and',
					'terms'    => array(
						array(
							'name'     => 'show_info',
							'operator' => 'contains',
							'value'    => 'short_desc',
						),
						array(
							'name'     => 'follow_theme_option',
							'operator' => '==',
							'value'    => '',
						),
					),
				),
			)
		);

		// $self->add_control(
		// 	'show_progress',
		// 	array(
		// 		'type'    => Controls_Manager::SELECT,
		// 		'label'   => esc_html__( 'Progress Bar for', 'wolmart-core' ),
		// 		'options' => array(
		// 			''      => esc_html__( 'None', 'wolmart-core' ),
		// 			'sales' => esc_html__( 'Sales', 'wolmart-core' ),
		// 			'stock' => esc_html__( 'Stock', 'wolmart-core' ),
		// 		),
		// 	)
		// );

		$self->add_control(
			'show_progress',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Show Sales Bar', 'wolmart-core' ),
				'condition' => array(
					'product_type!' => array( 'product-2', 'product-3' ),
				),
			)
		);

		$self->add_control(
			'show_labels',
			array(
				'type'     => Controls_Manager::SELECT2,
				'label'    => esc_html__( 'Show Labels', 'wolmart-core' ),
				'multiple' => true,
				'default'  => array(
					'top',
					'sale',
					'new',
					'stock',
				),
				'options'  => array(
					'top'   => esc_html__( 'Top', 'wolmart-core' ),
					'sale'  => esc_html__( 'Sale', 'wolmart-core' ),
					'new'   => esc_html__( 'New', 'wolmart-core' ),
					'stock' => esc_html__( 'Stock', 'wolmart-core' ),
				),
			)
		);

	$self->end_controls_section();

}

/**
 * Register elementor product style controls
 */
function wolmart_elementor_product_style_controls( $self ) {

	$self->start_controls_section(
		'section_filter_style',
		array(
			'label'     => esc_html__( 'Category Filter', 'wolmart-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'filter_cat' => 'yes',
			),
		)
	);

		// $self->add_control(
		// 	'style_heading_filter',
		// 	array(
		// 		'label' => esc_html__( 'Category Filter Style', 'wolmart-core' ),
		// 		'type'  => Controls_Manager::HEADING,
		// 	)
		// );

		$self->add_responsive_control(
			'filter_margin',
			array(
				'label'      => esc_html__( 'Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// $self->add_responsive_control(
		// 	'filter_padding',
		// 	array(
		// 		'label'      => esc_html__( 'Padding', 'wolmart-core' ),
		// 		'type'       => Controls_Manager::DIMENSIONS,
		// 		'size_units' => array( 'px', 'rem', '%' ),
		// 		'selectors'  => array(
		// 			'.elementor-element-{{ID}} .product-filters' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		),
		// 	)
		// );

		$self->add_responsive_control(
			'filter_item_margin',
			array(
				'label'      => esc_html__( 'Item Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'separator'  => 'before',
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filters > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'filter_item_padding',
			array(
				'label'      => esc_html__( 'Item Padding', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'cat_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'cat_border_width',
			array(
				'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'separator'  => 'after',
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filter' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'filter_typography',
				'selector' => '.elementor-element-{{ID}} .nav-filter',
			)
		);

		$self->add_responsive_control(
			'cat_align',
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
					'.elementor-element-{{ID}} .product-filters' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$self->start_controls_tabs( 'tabs_cat_color' );
			$self->start_controls_tab(
				'tab_cat_normal',
				array(
					'label' => esc_html__( 'Normal', 'wolmart-core' ),
				)
			);

			$self->add_control(
				'cat_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter' => 'color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter' => 'background-color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter' => 'border-color: {{VALUE}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'tab_cat_hover',
				array(
					'label' => esc_html__( 'Hover', 'wolmart-core' ),
				)
			);

			$self->add_control(
				'cat_hover_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter:hover' => 'color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_hover_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter:hover' => 'background-color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_hover_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter:hover' => 'border-color: {{VALUE}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'tab_cat_active',
				array(
					'label' => esc_html__( 'Active', 'wolmart-core' ),
				)
			);

			$self->add_control(
				'cat_active_color',
				array(
					'label'     => esc_html__( 'Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter.active' => 'color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_active_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter.active' => 'background-color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_active_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter.active' => 'border-color: {{VALUE}};',
					),
				)
			);

			$self->end_controls_tab();
		$self->end_controls_tabs();

	$self->end_controls_section();
}

/**
 * Single Product Functions
 * Products Functions
 */
if ( ! function_exists( 'wolmart_single_product_widget_get_title_tag' ) ) {
	function wolmart_single_product_widget_get_title_tag() {
		global $wolmart_spw_settings;
		return isset( $wolmart_spw_settings['sp_title_tag'] ) ? $wolmart_spw_settings['sp_title_tag'] : 'h2';
	}
}
if ( ! function_exists( 'wolmart_single_product_widget_get_gallery_type' ) ) {
	function wolmart_single_product_widget_get_gallery_type() {
		global $wolmart_spw_settings;
		return isset( $wolmart_spw_settings['sp_gallery_type'] ) ? $wolmart_spw_settings['sp_gallery_type'] : '';
	}
}

if ( ! function_exists( 'wolmart_single_product_widget_remove_row_class' ) ) {
	function wolmart_single_product_widget_remove_row_class( $classes ) {
		global $wolmart_spw_settings;

		if ( isset( $wolmart_spw_settings['sp_vertical'] ) && $wolmart_spw_settings['sp_vertical'] ) {
			foreach ( $classes as $i => $class ) {
				if ( 'row' == $class ) {
					array_splice( $classes, $i, 1 );
				}
			}
		}

		return $classes;
	}
}
if ( ! function_exists( 'wolmart_single_product_widget_extend_gallery_class' ) ) {
	function wolmart_single_product_widget_extend_gallery_class( $classes ) {
		global $wolmart_spw_settings;
		$single_product_layout = empty( $wolmart_spw_settings['sp_gallery_type'] ) ? '' : $wolmart_spw_settings['sp_gallery_type'];
		$classes[]             = 'pg-custom';

		if ( 'grid' == $single_product_layout || 'masonry' == $single_product_layout ) {

			foreach ( $classes as $i => $class ) {
				if ( 'cols-sm-2' == $class ) {
					array_splice( $classes, $i, 1 );
				}
			}

			if ( isset( $wolmart_spw_settings['sp_col_cnt'] ) ) {
				$col_cnt   = array(
					'xl'  => isset( $wolmart_spw_settings['sp_col_cnt_xl'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_xl'] : 0,
					'lg'  => isset( $wolmart_spw_settings['sp_col_cnt'] ) ? (int) $wolmart_spw_settings['sp_col_cnt'] : 0,
					'md'  => isset( $wolmart_spw_settings['sp_col_cnt_tablet'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_tablet'] : 0,
					'sm'  => isset( $wolmart_spw_settings['sp_col_cnt_mobile'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_mobile'] : 0,
					'min' => isset( $wolmart_spw_settings['sp_col_cnt_min'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_min'] : 0,
				);
				$classes[] = wolmart_get_col_class( function_exists( 'wolmart_get_responsive_cols' ) ? wolmart_get_responsive_cols( $col_cnt ) : $col_cnt );

				$col_sp = empty( $wolmart_spw_settings['sp_col_sp'] ) ? '' : $wolmart_spw_settings['sp_col_sp'];
				if ( 'lg' == $col_sp || 'sm' == $col_sp || 'xs' == $col_sp || 'no' == $col_sp ) {
					$classes[] = 'gutter-' . $col_sp;
				}
			} else {
				$classes[]        = wolmart_get_col_class( wolmart_elementor_grid_col_cnt( $wolmart_spw_settings ) );
				$grid_space_class = wolmart_get_grid_space_class( $wolmart_spw_settings );
				if ( $grid_space_class ) {
					$classes[] = $grid_space_class;
				}
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'wolmart_single_product_extend_gallery_type_class' ) ) {
	function wolmart_single_product_extend_gallery_type_class( $class ) {
		global $wolmart_spw_settings;

		if ( isset( $wolmart_spw_settings['sp_col_cnt'] ) ) {
			$col_cnt = array(
				'xl'  => isset( $wolmart_spw_settings['sp_col_cnt_xl'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_xl'] : 0,
				'lg'  => isset( $wolmart_spw_settings['sp_col_cnt'] ) ? (int) $wolmart_spw_settings['sp_col_cnt'] : 0,
				'md'  => isset( $wolmart_spw_settings['sp_col_cnt_tablet'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_tablet'] : 0,
				'sm'  => isset( $wolmart_spw_settings['sp_col_cnt_mobile'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_mobile'] : 0,
				'min' => isset( $wolmart_spw_settings['sp_col_cnt_min'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_min'] : 0,
			);
			$class   = wolmart_get_col_class( function_exists( 'wolmart_get_responsive_cols' ) ? wolmart_get_responsive_cols( $col_cnt ) : $col_cnt );

			$col_sp = empty( $wolmart_spw_settings['sp_col_sp'] ) ? '' : $wolmart_spw_settings['sp_col_sp'];
			if ( 'lg' == $col_sp || 'sm' == $col_sp || 'xs' == $col_sp || 'no' == $col_sp ) {
				$class .= ' gutter-' . $col_sp;
			}
		} else {
			$class            = wolmart_get_col_class( wolmart_elementor_grid_col_cnt( $wolmart_spw_settings ) );
			$grid_space_class = wolmart_get_grid_space_class( $wolmart_spw_settings );
			if ( $grid_space_class ) {
				$class .= $grid_space_class;
			}
		}

		return $class;
	}
}

if ( ! function_exists( 'wolmart_single_product_extend_gallery_type_attr' ) ) {
	function wolmart_single_product_extend_gallery_type_attr( $attr ) {
		global $wolmart_spw_settings;

		if ( isset( $wolmart_spw_settings['sp_col_cnt'] ) ) {
			$breakpoints = wolmart_get_breakpoints();

			$col_cnt = array(
				'xl'  => isset( $wolmart_spw_settings['sp_col_cnt_xl'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_xl'] : 0,
				'lg'  => isset( $wolmart_spw_settings['sp_col_cnt'] ) ? (int) $wolmart_spw_settings['sp_col_cnt'] : 0,
				'md'  => isset( $wolmart_spw_settings['sp_col_cnt_tablet'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_tablet'] : 0,
				'sm'  => isset( $wolmart_spw_settings['sp_col_cnt_mobile'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_mobile'] : 0,
				'min' => isset( $wolmart_spw_settings['sp_col_cnt_min'] ) ? (int) $wolmart_spw_settings['sp_col_cnt_min'] : 0,
			);
			$col_cnt = function_exists( 'wolmart_get_responsive_cols' ) ? wolmart_get_responsive_cols( $col_cnt ) : $col_cnt;

			$extra_options = array();

			$margin = wolmart_get_grid_space( isset( $wolmart_spw_settings['sp_col_sp'] ) ? $wolmart_spw_settings['sp_col_sp'] : '' );
			if ( $margin > 0 ) { // default is 0
				$extra_options['margin'] = $margin;
			}

			$responsive = array();
			foreach ( $col_cnt as $w => $c ) {
				$responsive[ $breakpoints[ $w ] ] = array(
					'slidesPerView' => $c,
				);
			}
			if ( isset( $responsive[ $breakpoints['md'] ] ) && ! $responsive[ $breakpoints['md'] ] ) {
				$responsive[ $breakpoints['md'] ] = array();
			}
			if ( isset( $responsive[ $breakpoints['lg'] ] ) && ! $responsive[ $breakpoints['lg'] ] ) {
				$responsive[ $breakpoints['lg'] ] = array();
			}

			$extra_options['responsive'] = $responsive;

			$attr .= ' data-slider-options="' . esc_attr(
				json_encode(
					apply_filters( 'wolmart_single_product_extended_slider_options', $extra_options )
				)
			) . '"';
		} else {
			$attr .= ' data-slider-options="' . esc_attr(
				json_encode(
					wolmart_get_slider_attrs( $wolmart_spw_settings, wolmart_elementor_grid_col_cnt( $wolmart_spw_settings ) )
				)
			) . '"';
		}

		return $attr;
	}
}

if ( ! function_exists( 'wolmart_products_widget_render' ) ) {
	function wolmart_products_widget_render( $atts ) {
		require wolmart_core_path( '/widgets/products/render-products.php' );
	}
}

if ( ! function_exists( 'wolmart_single_product_gallery_countdown' ) ) {
	function wolmart_single_product_gallery_countdown() {
		global $wolmart_spw_settings;

		wolmart_single_product_sale_countdown();
	}
}

if ( ! function_exists( 'wolmart_set_single_product_widget' ) ) {
	function wolmart_set_single_product_widget( $atts ) {
		global $wolmart_spw_settings;
		$wolmart_spw_settings = $atts;

		// Add woocommerce default filters for compatibility with single product
		if ( wolmart_is_elementor_preview() &&
			! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ) ) { // Add only once

			// Add woocommerce actions for compatibility in elementor editor.
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 ) ) {
				add_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
			}
			if ( ! has_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 ) ) {
				add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
			}
		}

		add_filter( 'wolmart_is_single_product_widget', '__return_true' );
		add_filter( 'wolmart_single_product_layout', 'wolmart_single_product_widget_get_gallery_type' );
		add_filter( 'wolmart_single_product_title_tag', 'wolmart_single_product_widget_get_title_tag' );
		add_filter( 'wolmart_single_product_gallery_main_classes', 'wolmart_single_product_widget_extend_gallery_class', 20 );

		if ( ! empty( $atts['sp_vertical'] ) ) {
			remove_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_first_start', 5 );
			remove_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_first_end', 30 );
			remove_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_second_start', 30 );
			remove_action( 'wolmart_after_product_summary_wrap', 'wolmart_single_product_wrap_second_end', 20 );
			add_filter( 'wolmart_single_product_classes', 'wolmart_single_product_widget_remove_row_class', 30 );
		}

		if ( ! empty( $atts['sp_show_info'] ) && is_array( $atts['sp_show_info'] ) ) {
			$sp_show_info = $atts['sp_show_info'];
			if ( ! in_array( 'gallery', $sp_show_info ) ) {
				remove_action( 'woocommerce_before_single_product_summary', 'wolmart_wc_show_product_images_not_sticky_both', 20 );
				remove_action( 'wolmart_before_product_summary', 'wolmart_wc_show_product_images_sticky_both', 5 );
				if ( empty( $atts['sp_vertical'] ) ) {
					remove_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_first_start', 5 );
					remove_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_first_end', 30 );
					remove_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_second_start', 30 );
					remove_action( 'wolmart_after_product_summary_wrap', 'wolmart_single_product_wrap_second_end', 20 );
					add_filter( 'wolmart_single_product_classes', 'wolmart_single_product_widget_remove_row_class', 30 );
				}
			}
			if ( ! in_array( 'title', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! in_array( 'meta', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
			}
			if ( ! in_array( 'price', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9 );
			}
			if ( ! in_array( 'rating', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! in_array( 'excerpt', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! in_array( 'addtocart_form', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			// if ( ! in_array( 'divider', $sp_show_info ) ) {
			// 	remove_action( 'woocommerce_single_product_summary', 'wolmart_single_product_divider', 31 );
			// 	remove_action( 'woocommerce_before_add_to_cart_button', 'wolmart_single_product_divider' );
			// }

			if ( ! in_array( 'share', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			}
			if ( class_exists( 'YITH_WCWL_Frontend' ) && ! in_array( 'wishlist', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'wolmart_print_wishlist_button', 52 );
			}

			if ( ! in_array( 'compare', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'wolmart_single_product_compare', 54 );
			}
		}

		if ( isset( $atts['sp_sales_type'] ) && 'gallery' == $atts['sp_sales_type'] ) {
			remove_action( 'woocommerce_single_product_summary', 'wolmart_single_product_sale_countdown', 9 );
			add_action( 'wolmart_after_wc_gallery_figure', 'wolmart_single_product_gallery_countdown' );
		}

		if ( isset( $atts['sp_gallery_type'] ) && 'gallery' == $atts['sp_gallery_type'] ) {
			add_filter( 'wolmart_single_product_gallery_type_class', 'wolmart_single_product_extend_gallery_type_class' );
			add_filter( 'wolmart_single_product_gallery_type_attr', 'wolmart_single_product_extend_gallery_type_attr' );
		}

		if ( class_exists( 'Wolmart_Skeleton' ) ) {
			Wolmart_Skeleton::prevent_skeleton();
		}
	}
}

if ( ! function_exists( 'wolmart_unset_single_product_widget' ) ) {
	function wolmart_unset_single_product_widget( $atts ) {
		global $wolmart_spw_settings;
		unset( $wolmart_spw_settings );

		// Remove added filters
		remove_filter( 'wolmart_is_single_product_widget', '__return_true' );
		remove_filter( 'wolmart_single_product_layout', 'wolmart_single_product_widget_get_gallery_type' );
		remove_filter( 'wolmart_single_product_title_tag', 'wolmart_single_product_widget_get_title_tag' );
		remove_filter( 'wolmart_single_product_gallery_main_classes', 'wolmart_single_product_widget_extend_gallery_class', 20 );

		if ( ! empty( $atts['sp_vertical'] ) ) {
			add_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_first_start', 5 );
			add_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_first_end', 30 );
			add_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_second_start', 30 );
			add_action( 'wolmart_after_product_summary_wrap', 'wolmart_single_product_wrap_second_end', 20 );
			remove_filter( 'wolmart_single_product_classes', 'wolmart_single_product_widget_remove_row_class', 30 );
		}

		if ( ! empty( $atts['sp_show_info'] ) && is_array( $atts['sp_show_info'] ) ) {
			$sp_show_info = $atts['sp_show_info'];
			if ( ! in_array( 'gallery', $sp_show_info ) ) {
				add_action( 'woocommerce_before_single_product_summary', 'wolmart_wc_show_product_images_not_sticky_both', 20 );
				add_action( 'wolmart_before_product_summary', 'wolmart_wc_show_product_images_sticky_both', 5 );
				if ( empty( $atts['sp_vertical'] ) ) {
					add_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_first_start', 5 );
					add_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_first_end', 30 );
					add_action( 'woocommerce_before_single_product_summary', 'wolmart_single_product_wrap_second_start', 30 );
					add_action( 'wolmart_after_product_summary_wrap', 'wolmart_single_product_wrap_second_end', 20 );
					remove_filter( 'wolmart_single_product_classes', 'wolmart_single_product_widget_remove_row_class', 30 );
				}
			}
			if ( ! in_array( 'title', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! in_array( 'meta', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
			}
			if ( ! in_array( 'price', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9 );
			}
			if ( ! in_array( 'rating', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! in_array( 'excerpt', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! in_array( 'addtocart_form', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			if ( ! in_array( 'divider', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'wolmart_single_product_divider', 31 );
				add_action( 'woocommerce_before_add_to_cart_button', 'wolmart_single_product_divider' );
			}
			if ( ! in_array( 'share', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			}
			if ( class_exists( 'YITH_WCWL_Frontend' ) && ! in_array( 'wishlist', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'wolmart_print_wishlist_button', 52 );
			}
			if ( ! in_array( 'compare', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'wolmart_single_product_compare', 54 );
			}
		}

		if ( isset( $atts['sp_sales_type'] ) && 'gallery' == $atts['sp_sales_type'] ) {
			add_action( 'woocommerce_single_product_summary', 'wolmart_single_product_sale_countdown', 9 );
			remove_action( 'wolmart_after_wc_gallery_figure', 'wolmart_single_product_gallery_countdown' );
		}

		if ( isset( $atts['sp_gallery_type'] ) && 'gallery' == $atts['sp_gallery_type'] ) {
			remove_filter( 'wolmart_single_product_gallery_type_class', 'wolmart_single_product_extend_gallery_type_class' );
			remove_filter( 'wolmart_single_product_gallery_type_attr', 'wolmart_single_product_extend_gallery_type_attr' );
		}

		if ( class_exists( 'Wolmart_Skeleton' ) ) {
			Wolmart_Skeleton::stop_prevent_skeleton();
		}
	}
}
