<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Posts Widget
 *
 * Wolmart Widget to display posts.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Wolmart_Controls_Manager;

class Wolmart_Posts_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_posts';
	}

	public function get_title() {
		return esc_html__( 'Posts', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'blog', 'article', 'posts', 'post', 'recent' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-posts-grid';
	}

	public function get_script_depends() {
		$depends = array( 'swiper' );
		if ( wolmart_is_elementor_preview() ) {
			$depends[] = 'wolmart-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_posts_selector',
			array(
				'label' => esc_html__( 'Posts Selector', 'wolmart-core' ),
			)
		);

		$this->add_control(
			'post_ids',
			array(
				'label'       => esc_html__( 'Select Posts', 'wolmart-core' ),
				'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
				'options'     => 'post',
				'label_block' => true,
				'multiple'    => true,
			)
		);

		$this->add_control(
			'categories',
			array(
				'label'       => esc_html__( 'Select Categories', 'wolmart-core' ),
				'type'        => Wolmart_Controls_Manager::AJAXSELECT2,
				'options'     => 'category',
				'label_block' => true,
				'multiple'    => true,
			)
		);

		$this->add_control(
			'count',
			array(
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Posts Count', 'wolmart-core' ),
				'default' => array(
					'size' => 4,
					'unit' => 'px',
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

		$this->add_control(
			'orderby',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Order By', 'wolmart-core' ),
				'default' => 'ID',
				'options' => array(
					''              => esc_html__( 'Default', 'wolmart-core' ),
					'ID'            => esc_html__( 'ID', 'wolmart-core' ),
					'title'         => esc_html__( 'Title', 'wolmart-core' ),
					'date'          => esc_html__( 'Date', 'wolmart-core' ),
					'modified'      => esc_html__( 'Modified', 'wolmart-core' ),
					'author'        => esc_html__( 'Author', 'wolmart-core' ),
					'comment_count' => esc_html__( 'Comment count', 'wolmart-core' ),
				),
			)
		);

		$this->add_control(
			'orderway',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Order Way', 'wolmart-core' ),
				'default' => 'ASC',
				'options' => array(
					'ASC'  => esc_html__( 'Ascending', 'wolmart-core' ),
					'DESC' => esc_html__( 'Descending', 'wolmart-core' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_posts_layout',
			array(
				'label' => esc_html__( 'Layout', 'wolmart-core' ),
			)
		);

		$this->add_control(
			'layout_type',
			array(
				'label'   => esc_html__( 'Posts Layout', 'wolmart-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'     => esc_html__( 'Grid', 'wolmart-core' ),
					'slider'   => esc_html__( 'Slider', 'wolmart-core' ),
					'creative' => esc_html__( 'Creative Grid', 'wolmart-core' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
				'default' => 'wolmart-post-small',
			)
		);

		wolmart_elementor_grid_layout_controls( $this, 'layout_type', true, 'post' );

		wolmart_elementor_loadmore_layout_controls( $this, 'layout_type' );

		wolmart_elementor_slider_layout_controls( $this, 'layout_type' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_type',
			array(
				'label' => esc_html__( 'Post Type', 'wolmart-core' ),
			)
		);

		$this->add_control(
			'follow_theme_option',
			array(
				'label'   => esc_html__( 'Follow Theme Option', 'wolmart-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		// $this->add_control(
		// 	'post_type',
		// 	array(
		// 		'label'     => esc_html__( 'Post Type', 'wolmart-core' ),
		// 		'type'      => Controls_Manager::SELECT,
		// 		'default'   => '',
		// 		'options'   => array(
		// 			''        => esc_html__( 'Default', 'wolmart-core' ),
		// 			'list'    => esc_html__( 'List', 'wolmart-core' ),
		// 			'mask'    => esc_html__( 'Mask', 'wolmart-core' ),
		// 			'widget'  => esc_html__( 'Widget', 'wolmart-core' ),
		// 			'list-xs' => esc_html__( 'Calendar', 'wolmart-core' ),
		// 		),
		// 		'condition' => array(
		// 			'follow_theme_option' => '',
		// 		),
		// 	)
		// );

		$this->add_control(
			'post_type',
			array(
				'label'     => esc_html__( 'Post Type', 'wolmart-core' ),
				'type'      => Wolmart_Controls_Manager::IMAGE_CHOOSE,
				'default'   => '',
				'options'   => array(
					''        => 'assets/images/posts/post-1.jpg',
					'mask'    => 'assets/images/posts/post-3.jpg',
					'list'    => 'assets/images/posts/post-2.jpg',
					'widget'  => 'assets/images/posts/post-4.jpg',
					'list-xs' => 'assets/images/posts/post-5.jpg',
				),
				'width'     => 3,
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		$this->add_control(
			'show_info',
			array(
				'type'      => Controls_Manager::SELECT2,
				'label'     => esc_html__( 'Show Information', 'wolmart-core' ),
				'multiple'  => true,
				'default'   => array(
					'image',
					'author',
					'date',
					'readmore',
				),
				'options'   => array(
					'image'    => esc_html__( 'Featured Image', 'wolmart-core' ),
					'author'   => esc_html__( 'Author', 'wolmart-core' ),
					'date'     => esc_html__( 'Date', 'wolmart-core' ),
					'comment'  => esc_html__( 'Comments Count', 'wolmart-core' ),
					'category' => esc_html__( 'Category', 'wolmart-core' ),
					'content'  => esc_html__( 'Content', 'wolmart-core' ),
					'readmore' => esc_html__( 'Read More', 'wolmart-core' ),
				),
				'condition' => array(
					'follow_theme_option' => '',
					'post_type!'          => 'mask',
				),
			)
		);

		$this->add_control(
			'overlay',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Overlay', 'wolmart-core' ),
				'options'   => array(
					''           => esc_html__( 'No', 'wolmart-core' ),
					'light'      => esc_html__( 'Light', 'wolmart-core' ),
					'dark'       => esc_html__( 'Dark', 'wolmart-core' ),
					'zoom'       => esc_html__( 'Zoom', 'wolmart-core' ),
					'zoom_light' => esc_html__( 'Zoom and Light', 'wolmart-core' ),
					'zoom_dark'  => esc_html__( 'Zoom and Dark', 'wolmart-core' ),
				),
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		$this->add_control(
			'show_datebox',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Show Date On Featured Image', 'wolmart-core' ),
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		$this->add_control(
			'excerpt_custom',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Custom Excerpt', 'wolmart-core' ),
				'separator' => 'before',
				'condition' => array(
					'follow_theme_option' => '',
					'post_type!'          => 'mask',
				),
			)
		);

		$this->add_control(
			'excerpt_type',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Excerpt By', 'wolmart-core' ),
				'default'   => 'words',
				'options'   => array(
					'words'     => esc_html__( 'Words', 'wolmart-core' ),
					'character' => esc_html__( 'Characters', 'wolmart-core' ),
				),
				'condition' => array(
					'follow_theme_option' => '',
					'excerpt_custom'      => 'yes',
					'post_type!'          => 'mask',
				),
			)
		);

		$this->add_control(
			'excerpt_length',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Excerpt Length', 'wolmart-core' ),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 500,
					),
				),
				'condition' => array(
					'follow_theme_option' => '',
					'excerpt_custom'      => 'yes',
					'post_type!'          => 'mask',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_read_more',
			array(
				'label'     => esc_html__( 'Read More Button', 'wolmart-core' ),
				'condition' => array(
					'follow_theme_option' => '',
					'post_type!'          => 'mask',
				),
			)
		);

		$this->add_control(
			'read_more_label',
			array(
				'label'       => esc_html__( 'Read More Label', 'wolmart-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Read More', 'wolmart-core' ),
				'condition'   => array(
					'follow_theme_option' => '',
				),
			)
		);

		$this->add_control(
			'read_more_custom',
			array(
				'label'     => esc_html__( 'Use Custom', 'wolmart-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		wolmart_elementor_button_layout_controls( $this, 'read_more_custom' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'content_align',
			array(
				'label'   => esc_html__( 'Alignment', 'wolmart-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'wolmart-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
			)
		);

		$this->add_control(
			'style_heading_meta',
			array(
				'label' => esc_html__( 'Meta', 'wolmart-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'meta_margin',
			array(
				'label'      => esc_html__( 'Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .post-author, .elementor-element-{{ID}} .post-date, .elementor-element-{{ID}} .comments-link, .elementor-element-{{ID}} .mark' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'selector' => '.elementor-element-{{ID}} .post-meta>*',
			)
		);

		$this->add_control(
			'style_heading_title',
			array(
				'label' => esc_html__( 'Title', 'wolmart-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .post-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '.elementor-element-{{ID}} .post-title',
			)
		);

		$this->add_control(
			'style_heading_cats',
			array(
				'label' => esc_html__( 'Category', 'wolmart-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'cats_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .post-cats' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cats_typography',
				'selector' => '.elementor-element-{{ID}} .post-cats',
			)
		);

		$this->add_control(
			'style_divider_content',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'style_heading_content',
			array(
				'label' => esc_html__( 'Excerpt', 'wolmart-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'content_margin',
			array(
				'label'      => esc_html__( 'Margin', 'wolmart-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .post-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => esc_html__( 'Color', 'wolmart-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .post-content' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'selector' => '.elementor-element-{{ID}} .post-content p',
			)
		);

		$this->end_controls_section();

		wolmart_elementor_button_style_controls( $this );

		wolmart_elementor_slider_style_controls( $this, 'layout_type' );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-posts.php';
	}

	protected function content_template() {

	}
}
