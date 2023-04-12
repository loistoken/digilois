<?php
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

/**
 * Register elementor style controls for testimonials.
 */
function wolmart_elementor_testimonial_style_controls( $self ) {

	$self->start_controls_section(
		'testimonial_style',
		array(
			'label' => esc_html__( 'Testimonial Style', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->start_controls_tabs( 'tabs_testimonial_style' );

			$self->start_controls_tab(
				'tab_testimonial_normal',
				array(
					'label' => esc_html__( 'Normal', 'wolmart-core' ),
				)
			);
				$self->add_control(
					'testimonial_bg_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .testimonial:not(.testimonial-simple)' => 'background-color: {{VALUE}};',
							'.elementor-element-{{ID}} .testimonial.testimonial-simple .content' => 'background-color: {{VALUE}};',
							'.elementor-element-{{ID}} .testimonial.testimonial-simple .content::before' => 'background-color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					array(
						'name'     => 'testimonial_box_shadow',
						'selector' => '.elementor-element-{{ID}} .testimonial',
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'tab_testimonial_hover',
				array(
					'label' => esc_html__( 'Hover', 'wolmart-core' ),
				)
			);
				$self->add_control(
					'testimonial_bg_hover_color',
					array(
						'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .testimonial:hover' => 'background-color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					array(
						'name'     => 'testimonial_hover_box_shadow',
						'selector' => '.elementor-element-{{ID}} .testimonial:hover',
					)
				);

			$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_control(
			'testimonial_pd',
			array(
				'label'      => esc_html__( 'Padding', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .testimonial' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'testimonial_border_width',
			array(
				'label'      => esc_html__( 'Border Width', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .testimonial' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
				),
			)
		);

		$self->add_responsive_control(
			'testimonial_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .testimonial' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// $self->add_control(
		// 	'testimonial_border_color',
		// 	array(
		// 		'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'selectors' => array(
		// 			'.elementor-element-{{ID}} .testimonial' => 'border-color: {{VALUE}};',
		// 		),
		// 	)
		// );

	$self->end_controls_section();

	$self->start_controls_section(
		'avatar_style',
		array(
			'label' => esc_html__( 'Avatar', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'avatar_sz',
			array(
				'label'      => esc_html__( 'Size', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'em',
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 300,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .testimonial .avatar img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .testimonial-simple .content::after, .elementor-element-{{ID}} .testimonial-simple .content::before' => 'left: calc(2rem + {{SIZE}}{{UNIT}} / 2 - 1rem)',
					'.elementor-element-{{ID}} .testimonial-simple.inversed .content::after, .elementor-element-{{ID}} .testimonial-simple.inversed .content::before' => 'right: calc(3rem + {{SIZE}}{{UNIT}} / 2 - 1rem); left: auto;',
					'.elementor-element-{{ID}} .avatar::before' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'avatar_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .avatar::before' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'avatar_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .avatar' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'avatar_shadow',
				'selector' => '.elementor-element-{{ID}} .avatar',
			)
		);

		$self->add_control(
			'avatar_divider',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$self->add_control(
			'avatar_pd',
			array(
				'label'      => esc_html__( 'Padding', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .testimonial .avatar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'avatar_mg',
			array(
				'label'      => esc_html__( 'Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .testimonial .avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'avatar_border',
				'selector' => '.elementor-element-{{ID}} .avatar',
			)
		);

		$self->add_control(
			'avatar_br',
			array(
				'label'      => esc_html__( 'Border Radius', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'title_style',
		array(
			'label' => esc_html__( 'Title', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .comment-title' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'wolmart-core' ),
				'selector' => '.elementor-element-{{ID}} .comment-title',
			)
		);

		$self->add_control(
			'title_mg',
			array(
				'label'      => esc_html__( 'Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .comment-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'comment_style',
		array(
			'label' => esc_html__( 'Comment', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'comment_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .comment' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'comment_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .testimonial.testimonial-simple .content' => 'border-color: {{VALUE}};',
					'.elementor-element-{{ID}} .testimonial.testimonial-simple .content::after' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'testimonial_type' => array( 'simple' ),
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'comment_typography',
				'label'    => esc_html__( 'Comment', 'wolmart-core' ),
				'selector' => '.elementor-element-{{ID}} .comment',
			)
		);

		$self->add_control(
			'comment_pd',
			array(
				'label'      => esc_html__( 'Padding', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'comment_mg',
			array(
				'label'      => esc_html__( 'Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'name_style',
		array(
			'label' => esc_html__( 'Name', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'name_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .name' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'label'    => esc_html__( 'Name', 'wolmart-core' ),
				'selector' => '.elementor-element-{{ID}} .name',
			)
		);

		$self->add_control(
			'name_mg',
			array(
				'label'      => esc_html__( 'Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'role_style',
		array(
			'label' => esc_html__( 'Role', 'wolmart-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'role_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .role' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'role_typography',
				'label'    => esc_html__( 'Role', 'wolmart-core' ),
				'selector' => '.elementor-element-{{ID}} .role',
			)
		);

		$self->add_control(
			'role_mg',
			array(
				'label'      => esc_html__( 'Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .role' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'rating_style',
		array(
			'label'     => esc_html__( 'Rating', 'wolmart-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'testimonial_type!' => 'simple',
			),
		)
	);

		$self->add_control(
			'rating_sz',
			array(
				'label'      => esc_html__( 'Size', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .ratings-full' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'rating_sp',
			array(
				'label'      => esc_html__( 'Star Spacing', 'wolmart-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
			)
		);

		$self->add_control(
			'rating_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .ratings-full .ratings::before' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'rating_blank_color',
			array(
				'label'     => esc_html__( 'Blank Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .ratings-full::before' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'rating_mg',
			array(
				'label'      => esc_html__( 'Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .ratings-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();
}

/**
 * Register elementor content controls for testimonials
 */
function wolmart_elementor_testimonial_content_controls( $self ) {
	$self->add_control(
		'name',
		[
			'label'   => esc_html__( 'Name', 'wolmart-core' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'John Doe',
		]
	);

	$self->add_control(
		'role',
		[
			'label'   => esc_html__( 'Role', 'wolmart-core' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Customer',
		]
	);

	$self->add_control(
		'title',
		[
			'label'   => esc_html__( 'Title', 'wolmart-core' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '',
		]
	);

	$self->add_control(
		'content',
		[
			'label'   => esc_html__( 'Content', 'wolmart-core' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => '10',
			'default' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.',
		]
	);

	$self->add_control(
		'avatar',
		[
			'label' => esc_html__( 'Choose Avatar', 'wolmart-core' ),
			'type'  => Controls_Manager::MEDIA,
		]
	);

	$self->add_control(
		'link',
		[
			'label'       => esc_html__( 'Link', 'wolmart-core' ),
			'type'        => Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'wolmart-core' ),
		]
	);

	$self->add_group_control(
		Group_Control_Image_Size::get_type(),
		[
			'name'      => 'avatar',
			'default'   => 'full',
			'separator' => 'none',
		]
	);

	$self->add_control(
		'rating',
		[
			'label'   => esc_html__( 'Rating', 'wolmart-core' ),
			'type'    => Controls_Manager::NUMBER,
			'min'     => 0,
			'max'     => 5,
			'step'    => 0.1,
			'default' => '',
		]
	);
}

/**
 * Register elementor type controls for testimonials.
 */
function wolmart_elementor_testimonial_type_controls( $self ) {
	$self->add_control(
		'testimonial_type',
		array(
			'label'   => esc_html__( 'Testimonial Type', 'wolmart-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'simple',
			'options' => array(
				'simple' => esc_html__( 'Simple', 'wolmart-core' ),
				'boxed'  => esc_html__( 'Boxed', 'wolmart-core' ),
				'aside'  => esc_html__( 'Aside', 'wolmart-core' ),
			),
		)
	);

	$self->add_control(
		'testimonial_inverse',
		array(
			'label'     => esc_html__( 'Inversed', 'wolmart-core' ),
			'type'      => Controls_Manager::SWITCHER,
			'condition' => array(
				'testimonial_type' => array( 'simple', 'aside' ),
			),
		)
	);

	$self->add_control(
		'avatar_pos',
		[
			'label'     => esc_html__( 'Avatar Position', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'top',
			'options'   => [
				'top'    => esc_html__( 'Top', 'wolmart-core' ),
				'bottom' => esc_html__( 'Bottom', 'wolmart-core' ),
			],
			'condition' => array(
				'testimonial_type' => array( 'boxed' ),
			),
		]
	);

	$self->add_control(
		'commenter_pos',
		[
			'label'     => esc_html__( 'Commenter Position', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'after',
			'options'   => [
				'before' => esc_html__( 'Before Comment', 'wolmart-core' ),
				'after'  => esc_html__( 'After Comment', 'wolmart-core' ),
			],
			'condition' => array(
				'testimonial_type' => array( 'boxed' ),
			),
		]
	);

	$self->add_control(
		'aside_commenter_pos',
		[
			'label'     => esc_html__( 'Commentor Position', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'after_avatar',
			'options'   => [
				'after_avatar'   => esc_html( 'After Avatar', 'wolmart-core' ),
				'before_comment' => esc_html__( 'Before Comment', 'wolmart-core' ),
				'after_comment'  => esc_html__( 'After Comment', 'wolmart-core' ),
			],
			'condition' => array(
				'testimonial_type' => array( 'aside' ),
			),
		]
	);

	$self->add_control(
		'rating_pos',
		[
			'label'     => esc_html__( 'Rating Position', 'wolmart-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'before_title',
			'options'   => [
				'before_title'   => esc_html__( 'Before Title', 'wolmart-core' ),
				'after_title'    => esc_html__( 'After Title', 'wolmart-core' ),
				'before_comment' => esc_html__( 'Before Comment', 'wolmart-core' ),
				'after_comment'  => esc_html__( 'After Comment', 'wolmart-core' ),
			],
			'condition' => array(
				'testimonial_type' => array( 'boxed', 'aside' ),
			),
		]
	);

	$self->add_control(
		'v_align',
		[
			'label'     => esc_html__( 'Vertical Alignment', 'wolmart-core' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'center',
			'options'   => [
				'left'   => [
					'title' => esc_html__( 'Left', 'wolmart-core' ),
					'icon'  => 'eicon-text-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'wolmart-core' ),
					'icon'  => 'eicon-text-align-center',
				],
				'right'  => [
					'title' => esc_html__( 'Right', 'wolmart-core' ),
					'icon'  => 'eicon-text-align-right',
				],
			],
			'selectors' => array(
				'.elementor-element-{{ID}} .testimonial' => 'text-align: {{VALUE}};',
			),
			'condition' => array(
				'testimonial_type' => array( 'boxed', 'aside' ),
			),
		]
	);

	$self->add_control(
		'h_align',
		[
			'label'     => esc_html__( 'Horizontal Alignment', 'wolmart-core' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'center',
			'options'   => [
				'flex-start' => [
					'title' => esc_html__( 'Top', 'wolmart-core' ),
					'icon'  => 'eicon-v-align-top',
				],
				'center'     => [
					'title' => esc_html__( 'Middle', 'wolmart-core' ),
					'icon'  => 'eicon-v-align-middle',
				],
				'flex-end'   => [
					'title' => esc_html__( 'Bottom', 'wolmart-core' ),
					'icon'  => 'eicon-v-align-bottom',
				],
			],
			'selectors' => array(
				'.elementor-element-{{ID}} .testimonial' => 'align-items: {{VALUE}};',
				'.elementor-element-{{ID}} .commenter'   => 'align-items: {{VALUE}};',
			),
			'condition' => array(
				'testimonial_type' => array( 'aside' ),
			),
		]
	);
}
