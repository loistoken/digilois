<?php
/**
 * Wolmart Testimonial
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' )             => array(
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Name', 'wolmart-core' ),
			'param_name' => 'name',
			'std'        => 'John Doe',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Role', 'wolmart-core' ),
			'param_name' => 'role',
			'std'        => 'Customer',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'wolmart-core' ),
			'param_name' => 'title',
			'std'        => '',
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Content', 'wolmart-core' ),
			'param_name' => 'testimonial_content',
			'std'        => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.',
		),
		esc_html__( 'Avatar', 'wolmart-core' ) => array(
			array(
				'type'       => 'attach_image',
				'heading'    => esc_html__( 'Choose Avatar', 'wolmart-core' ),
				'param_name' => 'avatar',
				'value'      => '',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Link', 'wolmart-core' ),
				'param_name' => 'link',
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Rating', 'wolmart-core' ),
				'param_name' => 'rating',
				'std'        => '',
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Maximum Content Line', 'wolmart-core' ),
				'param_name' => 'content_line',
				'std'        => '4',
			),

		),
	),
	esc_html__( 'Layout and Position', 'wolmart-core' ) => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Type', 'wolmart-core' ),
			'param_name' => 'testimonial_type',
			'value'      => array(
				esc_html__( 'Simple', 'wolmart-core' ) => 'simple',
				esc_html__( 'Boxed', 'wolmart-core' )  => 'boxed',
				esc_html__( 'Aside', 'wolmart-core' )  => 'aside',
			),
			'std'        => 'simple',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Inversed', 'wolmart-core' ),
			'param_name' => 'testimonial_inverse',
			'value'      => array( esc_html__( 'Yes', 'wolmart-core' ) => 'yes' ),
			'std'        => 'no',
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => array( 'simple', 'aside' ),
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Avatar Position', 'wolmart-core' ),
			'param_name' => 'avatar_pos',
			'value'      => array(
				esc_html__( 'Top', 'wolmart-core' )    => 'top',
				esc_html__( 'Bottom', 'wolmart-core' ) => 'bottom',
			),
			'std'        => 'top',
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => 'boxed',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Commenter Position', 'wolmart-core' ),
			'param_name' => 'commenter_pos',
			'value'      => array(
				esc_html__( 'Before Comment', 'wolmart-core' ) => 'before',
				esc_html__( 'After Comment', 'wolmart-core' )  => 'after',
			),
			'std'        => 'after',
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => 'boxed',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Rating Position', 'wolmart-core' ),
			'param_name' => 'rating_pos',
			'value'      => array(
				esc_html__( 'Before Title', 'wolmart-core' ) => 'before_title',
				esc_html__( 'After Title', 'wolmart-core' )  => 'after_title',
				esc_html__( 'Before Comment', 'wolmart-core' ) => 'before_comment',
				esc_html__( 'After Comment', 'wolmart-core' )  => 'after_comment',
			),
			'std'        => 'before',
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => array( 'boxed', 'aside' ),
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Vertical Alignment', 'wolmart-core' ),
			'param_name' => 'v_align',
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
			'std'        => 'left',
			'selectors'  => array(
				'{{WRAPPER}} .testimonial' => 'text-align: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => array( 'boxed', 'aside' ),
			),
		),
		array(
			'type'       => 'wolmart_button_group',
			'heading'    => esc_html__( 'Horizontal Alignment', 'wolmart-core' ),
			'param_name' => 'h_align',
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'wolmart-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => 'center',
			'selectors'  => array(
				'{{WRAPPER}} .testimonial, {{WRAPPER}} .commenter' => 'align-items: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => 'aside',
			),
		),
	),
	esc_html__( 'Style', 'wolmart-core' )               => array(
		esc_html__( 'Testimonial Style', 'wolmart-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
				'param_name' => 'testimonial_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .testimonial:not(.testimonial-simple)' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .testimonial.testimonial-simple .content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .testimonial.testimonial-simple .content::before' => 'background-color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Avatar', 'wolmart-core' )            => array(
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Size', 'wolmart-core' ),
				'param_name' => 'avatar_size',
				'value'      => '',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .testimonial .avatar img' => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .testimonial-simple .content::after' => "{$left}: calc(2rem + {{VALUE}}{{UNIT}} / 2 - 1rem);",
					'{{WRAPPER}} .avatar::before'          => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'avatar_color',
				'selectors'  => array(
					'{{WRAPPER}} .avatar:before' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'wolmart-core' ),
				'param_name' => 'avatar_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .avatar' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'avatar_padding',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .testimonial .avatar' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'param_name' => 'avatar_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .testimonial .avatar' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'wolmart-core' ),
				'param_name' => 'avatar_border',
				'value'      => array(
					esc_html__( 'None', 'wolmart-core' )   => 'none',
					esc_html__( 'Solid', 'wolmart-core' )  => 'solid',
					esc_html__( 'Double', 'wolmart-core' ) => 'double',
					esc_html__( 'Dotted', 'wolmart-core' ) => 'dotted',
					esc_html__( 'Dashed', 'wolmart-core' ) => 'dashed',
					esc_html__( 'Groove', 'wolmart-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .avatar' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Width', 'wolmart-core' ),
				'param_name' => 'sp_share_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .avatar' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'avatar_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Color', 'wolmart-core' ),
				'param_name' => 'avatar_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .avatar' => 'border-color: {{VALUE}};',
				),
				'dependency' => array(
					'element'            => 'avatar_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Border Radius', 'wolmart-core' ),
				'param_name' => 'avatar_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .avatar > .social-icon' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}}; border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'avatar_border',
					'value_not_equal_to' => 'none',
				),
			),
		),
		esc_html__( 'Title', 'wolmart-core' )             => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .comment-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'title_typography',
				'selectors'  => array(
					'{{WRAPPER}} .comment-title',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'param_name' => 'title_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .comment-title' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Comment', 'wolmart-core' )           => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'comment_color',
				'selectors'  => array(
					'{{WRAPPER}} .comment' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Color', 'wolmart-core' ),
				'param_name' => 'comment_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .testimonial.testimonial-simple .content' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .testimonial.testimonial-simple .content::after' => 'background-color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'testimonial_type',
					'value'   => 'simple',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'comment_typography',
				'selectors'  => array(
					'{{WRAPPER}} .content .comment',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Padding', 'wolmart-core' ),
				'param_name' => 'comment_padding',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .content' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'param_name' => 'comment_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .comment' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Name', 'wolmart-core' )              => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'name_color',
				'selectors'  => array(
					'{{WRAPPER}} .name' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'name_typography',
				'selectors'  => array(
					'{{WRAPPER}} .name',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'param_name' => 'name_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .name' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Role', 'wolmart-core' )              => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'role_color',
				'selectors'  => array(
					'{{WRAPPER}} .role' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_typography',
				'heading'    => esc_html__( 'Typography', 'wolmart-core' ),
				'param_name' => 'role_typography',
				'selectors'  => array(
					'{{WRAPPER}} .role',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'param_name' => 'role_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .role' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Rating', 'wolmart-core' )            => array(
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Size', 'wolmart-core' ),
				'param_name' => 'rating_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'value'      => '',
				'selectors'  => array(
					'{{WRAPPER}} .ratings-full' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'wolmart_number',
				'heading'    => esc_html__( 'Star Spacing', 'wolmart-core' ),
				'param_name' => 'rating_sp',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'wolmart-core' ),
				'param_name' => 'rating_color',
				'selectors'  => array(
					'{{WRAPPER}} .ratings-full span::before' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Blank Color', 'wolmart-core' ),
				'param_name' => 'rating_blank_color',
				'selectors'  => array(
					'{{WRAPPER}} .ratings-full::before' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'wolmart_dimension',
				'heading'    => esc_html__( 'Margin', 'wolmart-core' ),
				'param_name' => 'rating_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ratings-container' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Testimonial', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_testimonial',
		'icon'            => 'wolmart-icon wolmart-icon-testimonial',
		'class'           => 'wolmart_testimonial',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart testimonial.', 'wolmart-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Testimonial extends WPBakeryShortCode {

	}
}
