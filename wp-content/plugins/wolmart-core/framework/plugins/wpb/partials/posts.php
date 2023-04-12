<?php

if ( ! function_exists( 'wolmart_wpb_posts_select_controls' ) ) {
	function wolmart_wpb_posts_select_controls() {
		return array(
			array(
				'type'        => 'autocomplete',
				'param_name'  => 'post_ids',
				'heading'     => esc_html__( 'Post IDs', 'wolmart-core' ),
				'description' => esc_html__( 'comma separated list of Post ids', 'wolmart-core' ),
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'        => 'autocomplete',
				'param_name'  => 'categories',
				'heading'     => esc_html__( 'Category IDs or slugs', 'wolmart-core' ),
				'description' => esc_html__( 'comma separated list of category ids or slugs', 'wolmart-core' ),
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'        => 'wolmart_number',
				'param_name'  => 'count',
				'heading'     => esc_html__( 'Posts Count', 'wolmart-core' ),
				'description' => esc_html__( '0 value will show all categories.', 'wolmart-core' ),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'orderby',
				'heading'    => esc_html__( 'Order By', 'wolmart-core' ),
				'std'        => 'ID',
				'value'      => array(
					esc_html__( 'Default', 'wolmart-core' ) => '',
					esc_html__( 'ID', 'wolmart-core' )     => 'ID',
					esc_html__( 'Title', 'wolmart-core' )  => 'title',
					esc_html__( 'Date', 'wolmart-core' )   => 'date',
					esc_html__( 'Modified', 'wolmart-core' ) => 'modified',
					esc_html__( 'Author', 'wolmart-core' ) => 'author',
					esc_html__( 'Comment count', 'wolmart-core' ) => 'comment_count',
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'param_name' => 'orderway',
				'value'      => array(
					'DESC' => array(
						'title' => esc_html__( 'Descending', 'wolmart-core' ),
					),
					'ASC'  => array(
						'title' => esc_html__( 'Ascending', 'wolmart-core' ),
					),
				),
				'std'        => 'DESC',
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_posts_type_controls' ) ) {
	function wolmart_wpb_posts_type_controls() {
		return array(
			array(
				'type'       => 'checkbox',
				'param_name' => 'follow_theme_option',
				'heading'    => esc_html__( 'Follow Theme Option', 'wolmart-core' ),
				'std'        => 'yes',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			),
			array(
				'type'         => 'wolmart_button_group',
				'param_name'   => 'post_type',
				'heading'      => esc_html__( 'Post Type', 'wolmart-core' ),
				'button_width' => '300',
				'std'          => 'default',
				'value'        => array(
					'default' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/posts/post-1.jpg',
						'title' => esc_html__( 'Default', 'wolmart-core' ),
					),
					'list'    => array(
						'image' => WOLMART_CORE_URI . '/assets/images/posts/post-2.jpg',
						'title' => esc_html__( 'List', 'wolmart-core' ),
					),
					'mask'    => array(
						'image' => WOLMART_CORE_URI . '/assets/images/posts/post-3.jpg',
						'title' => esc_html__( 'Mask', 'wolmart-core' ),
					),
					'widget'  => array(
						'image' => WOLMART_CORE_URI . '/assets/images/posts/post-4.jpg',
						'title' => esc_html__( 'Widget', 'wolmart-core' ),
					),
					'list-xs' => array(
						'image' => WOLMART_CORE_URI . '/assets/images/posts/post-5.jpg',
						'title' => esc_html__( 'Calendar', 'wolmart-core' ),
					),
				),
				'dependency'   => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_multiselect',
				'param_name' => 'show_info',
				'heading'    => esc_html__( 'Show Information', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'Featured Image', 'wolmart-core' ) => 'image',
					esc_html__( 'Author', 'wolmart-core' ) => 'author',
					esc_html__( 'Date', 'wolmart-core' )   => 'date',
					esc_html__( 'Comments Count', 'wolmart-core' ) => 'comment',
					esc_html__( 'Category', 'wolmart-core' ) => 'category',
					esc_html__( 'Content', 'wolmart-core' ) => 'content',
					esc_html__( 'Read More', 'wolmart-core' ) => 'readmore',
				),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'std'        => 'image,date,author,category,comment,readmore',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'overlay',
				'heading'    => esc_html__( 'Overlay', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'No', 'wolmart-core' )    => '',
					esc_html__( 'Light', 'wolmart-core' ) => 'light',
					esc_html__( 'Dark', 'wolmart-core' )  => 'dark',
					esc_html__( 'Zoom', 'wolmart-core' )  => 'zoom',
					esc_html__( 'Zoom and Light', 'wolmart-core' ) => 'zoom_light',
					esc_html__( 'Zoom and Dark', 'wolmart-core' ) => 'zoom_dark',
				),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'show_datebox',
				'heading'    => esc_html__( 'Show Date On Featured Image', 'wolmart-core' ),
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'excerpt_custom',
				'heading'     => esc_html__( 'Custom Excerpt', 'wolmart-core' ),
				'description' => esc_html__( 'If you customize excerpt length, you have to set this toggle certainly.', 'wolmart-core' ),
				'value'       => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'excerpt_type',
				'heading'    => esc_html__( 'Excerpt By', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'Words', 'wolmart-core' ) => 'words',
					esc_html__( 'Characters', 'wolmart-core' ) => 'character',
				),
				'std'        => 'words',
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => __( 'Excerpt Length', 'wolmart-core' ),
				'param_name' => 'excerpt_length',
				'std'        => 5,
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_posts_read_more_controls' ) ) {
	function wolmart_wpb_posts_read_more_controls() {
		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		return array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Read More Label', 'wolmart-core' ),
				'param_name'  => 'read_more_label',
				'admin_label' => true,
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Use Custom', 'wolmart-core' ),
				'param_name' => 'read_more_custom',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Type', 'wolmart-core' ),
				'param_name' => 'button_type',
				'value'      => array(
					esc_html__( 'Default', 'wolmart-core' ) => '',
					esc_html__( 'Solid', 'wolmart-core' )  => 'btn-solid',
					esc_html__( 'Outline', 'wolmart-core' ) => 'btn-outline',
					esc_html__( 'Inline', 'wolmart-core' ) => 'btn-link',
				),
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Size', 'wolmart-core' ),
				'param_name' => 'button_size',
				'value'      => array(
					'btn-sm' => array(
						'title' => esc_html__( 'Small', 'wolmart-core' ),
					),
					'btn-md' => array(
						'title' => esc_html__( 'Medium', 'wolmart-core' ),
					),
					''       => array(
						'title' => esc_html__( 'Normal', 'wolmart-core' ),
					),
					'btn-lg' => array(
						'title' => esc_html__( 'Large', 'wolmart-core' ),
					),
				),
				'std'        => '',
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Hover Underline', 'wolmart-core' ),
				'param_name' => 'link_hover_type',
				'value'      => array(
					''                 => array(
						'title' => esc_html__( 'None', 'wolmart-core' ),
					),
					'btn-underline sm' => array(
						'title' => esc_html__( 'Underline1', 'wolmart-core' ),
					),
					'btn-underline'    => array(
						'title' => esc_html__( 'Underline2', 'wolmart-core' ),
					),
					'btn-underline lg' => array(
						'title' => esc_html__( 'Underline3', 'wolmart-core' ),
					),
				),
				'dependency' => array(
					'element' => 'button_type',
					'value'   => 'btn-link',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Box Shadow', 'wolmart-core' ),
				'param_name' => 'shadow',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' ) => '',
					esc_html__( 'Shadow 1', 'wolmart-core' ) => 'btn-shadow-sm',
					esc_html__( 'Shadow 2', 'wolmart-core' ) => 'btn-shadow',
					esc_html__( 'Shadow 3', 'wolmart-core' ) => 'btn-shadow-lg',
				),
				'dependency' => array(
					'element'            => 'button_type',
					'value_not_equal_to' => 'btn-link',
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Border Style', 'wolmart-core' ),
				'param_name' => 'button_border',
				'label_type' => 'icon',
				'value'      => array(
					''            => array(
						'title' => esc_html__( 'Rectangle', 'wolmart-core' ),
						'icon'  => 'attr-icon-square',
					),
					'btn-rounded' => array(
						'title' => esc_html__( 'Rounded', 'wolmart-core' ),
						'icon'  => 'attr-icon-rounded',
					),
					'btn-ellipse' => array(
						'title' => esc_html__( 'Ellipse', 'wolmart-core' ),
						'icon'  => 'attr-icon-ellipse',
					),
				),
				'dependency' => array(
					'element'            => 'button_type',
					'value_not_equal_to' => 'btn-link',
				),
			),
			array(
				'type'        => 'wolmart_button_group',
				'heading'     => esc_html__( 'Skin', 'wolmart-core' ),
				'param_name'  => 'button_skin',
				'value'       => array(
					''              => array(
						'title' => esc_html__( 'Default', 'wolmart-core' ),
						'color' => '#eee',
					),
					'btn-primary'   => array(
						'title' => esc_html__( 'Primary', 'wolmart-core' ),
						'color' => 'var(--wolmart-primary-color,#2879FE)',
					),
					'btn-secondary' => array(
						'title' => esc_html__( 'Secondary', 'wolmart-core' ),
						'color' => 'var(--wolmart-secondary-color,#d26e4b)',
					),
					'btn-alert'     => array(
						'title' => esc_html__( 'Alert', 'wolmart-core' ),
						'color' => 'var(--wolmart-alert-color,#b10001)',
					),
					'btn-success'   => array(
						'title' => esc_html__( 'Success', 'wolmart-core' ),
						'color' => 'var(--wolmart-success-color,#a8c26e)',
					),
					'btn-dark'      => array(
						'title' => esc_html__( 'Dark', 'wolmart-core' ),
						'color' => 'var(--wolmart-dark-color,#222)',
					),
					'btn-white'     => array(
						'title' => esc_html__( 'white', 'wolmart-core' ),
						'color' => '#fff',
					),
				),
				'description' => '',
				'dependency'  => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Disable Line-break', 'wolmart-core' ),
				'param_name' => 'line_break',
				'value'      => array(
					'nowrap' => array(
						'title' => esc_html__( 'On', 'wolmart-core' ),
					),
					'normal' => array(
						'title' => esc_html__( 'Off', 'wolmart-core' ),
					),
				),
				'std'        => 'nowrap',
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'white-space: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Icon?', 'wolmart-core' ),
				'param_name' => 'show_icon',
				'value'      => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Label', 'wolmart-core' ),
				'param_name' => 'show_label',
				'value'      => array( esc_html__( 'Yes, please', 'wolmart-core' ) => 'yes' ),
				'std'        => 'yes',
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'iconpicker',
				'heading'    => esc_html__( 'Icon', 'wolmart-core' ),
				'param_name' => 'icon',
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Icon Position', 'wolmart-core' ),
				'param_name' => 'icon_pos',
				'value'      => array(
					'after'  => array(
						'title' => esc_html__( 'After', 'wolmart-core' ),
					),
					'before' => array(
						'title' => esc_html__( 'Before', 'wolmart-core' ),
					),
				),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Icon Spacing', 'wolmart-core' ),
				'param_name' => 'icon_space',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'value'      => '',
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn-icon-left:not(.btn-reveal-left) i' => "margin-{$right}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .btn-icon-right:not(.btn-reveal-right) i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .btn-reveal-left:hover i, {{WRAPPER}} .btn-reveal-left:active i, {{WRAPPER}} .btn-reveal-left:focus i'  => "margin-{$right}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .btn-reveal-right:hover i, {{WRAPPER}} .btn-reveal-right:active i, {{WRAPPER}} .btn-reveal-right:focus i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Icon Size', 'wolmart-core' ),
				'param_name' => 'icon_size',
				'value'      => '',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Hover Effect', 'wolmart-core' ),
				'param_name' => 'icon_hover_effect',
				'value'      => array(
					esc_html__( 'none', 'wolmart-core' ) => '',
					esc_html__( 'Slide Left', 'wolmart-core' ) => 'btn-slide-left',
					esc_html__( 'Slide Right', 'wolmart-core' ) => 'btn-slide-right',
					esc_html__( 'Slide Up', 'wolmart-core' ) => 'btn-slide-up',
					esc_html__( 'Slide Down', 'wolmart-core' ) => 'btn-slide-down',
					esc_html__( 'Reveal Left', 'wolmart-core' ) => 'btn-reveal-left',
					esc_html__( 'Reveal Right', 'wolmart-core' ) => 'btn-reveal-right',
				),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Animation Infinite', 'wolmart-core' ),
				'param_name' => 'icon_hover_effect_infinite',
				'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'param_name' => 'button_typography',
				'heading'    => esc_html__( 'Button Typography', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post .btn',
				),
			),
			array(
				'type'       => 'wolmart_color_group',
				'param_name' => 'button_colors',
				'heading'    => esc_html__( 'Colors', 'wolmart-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .post .btn',
					'hover'  => '{{WRAPPER}} .post .btn:hover, {{WRAPPER}} .post .btn:focus',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'button_padding',
				'heading'    => esc_html__( 'Button Padding', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post .btn' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'button_border_type',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .post .btn' => 'border-style:{{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'button_border_width',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post .btn' => 'border-top:{{TOP}};border-right:{{RIGHT}};border-bottom:{{BOTTOM}};border-left:{{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'button_border_type',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'button_border_radius',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post .btn' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'button_border_type',
					'value_not_equal_to' => 'none',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_posts_style_controls' ) ) {
	function wolmart_wpb_posts_style_controls() {
		return array(
			array(
				'type'       => 'wolmart_button_group',
				'heading'    => esc_html__( 'Alignment', 'wolmart-core' ),
				'param_name' => 'content_align',
				'value'      => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'wolmart-core' ),
						'icon'  => 'fas fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wolmart-core' ),
						'icon'  => 'fas fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'wolmart-core' ),
						'icon'  => 'fas fa-align-right',
					),
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_posts_meta_style_controls' ) ) {
	function wolmart_wpb_posts_meta_style_controls() {
		return array(
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'meta_margin',
				'heading'    => esc_html__( 'Meta Margin', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-meta' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'meta_color',
				'heading'    => esc_html__( 'Meta Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-meta' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Meta Typography', 'wolmart-core' ),
				'param_name' => 'meta_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-meta',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_posts_title_style_controls' ) ) {
	function wolmart_wpb_posts_title_style_controls() {
		return array(
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'title_margin',
				'heading'    => esc_html__( 'Title Margin', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-title' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'title_color',
				'heading'    => esc_html__( 'Title Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Title Typography', 'wolmart-core' ),
				'param_name' => 'title_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-title',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_posts_cat_style_controls' ) ) {
	function wolmart_wpb_posts_cat_style_controls() {
		return array(
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'cats_margin',
				'heading'    => esc_html__( 'Category Margin', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-cats' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'cats_color',
				'heading'    => esc_html__( 'Category Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-cats' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Category Typography', 'wolmart-core' ),
				'param_name' => 'cats_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-cats',
				),
			),
		);
	}
}

if ( ! function_exists( 'wolmart_wpb_posts_excerpt_style_controls' ) ) {
	function wolmart_wpb_posts_excerpt_style_controls() {
		return array(
			array(
				'type'       => 'wolmart_dimension',
				'param_name' => 'content_margin',
				'heading'    => esc_html__( 'Excerpt Margin', 'wolmart-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-content p' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'content_color',
				'heading'    => esc_html__( 'Excerpt Color', 'wolmart-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-content' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Excerpt Typography', 'wolmart-core' ),
				'param_name' => 'content_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-content p',
				),
			),
		);
	}
}
