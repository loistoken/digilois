<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Products Widget
 *
 * Wolmart Widget to display products.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Wolmart_Products_Tab_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_products_tab';
	}

	public function get_title() {
		return esc_html__( 'Products Tab', 'wolmart-core' );
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce', 'tab' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-products';
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
			'section_products_selector',
			array(
				'label' => esc_html__( 'Products Tab', 'wolmart-core' ),
			)
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'tab_title',
				array(
					'label' => esc_html__( 'Tab Title', 'wolmart-core' ),
					'type'  => Controls_Manager::TEXT,
				)
			);

			wolmart_elementor_products_select_controls( $repeater, false );

			wolmart_elementor_tab_layout_controls( $this );

			$this->add_control(
				'products_selector_list',
				array(
					'label'         => esc_html__( 'Products Selector', 'wolmart-core' ),
					'type'          => Controls_Manager::REPEATER,
					'fields'        => $repeater->get_controls(),
					'default'       => array(
						array(
							'tab_title' => esc_html__( 'New Arrivals', 'wolmart-core' ),
							'count'     => array(
								'unit' => 'px',
								'size' => 6,
							),
							'orderby'   => 'date',
							'orderway'  => 'DESC',
						),
						array(
							'tab_title' => esc_html__( 'Best Seller', 'wolmart-core' ),
							'count'     => array(
								'unit' => 'px',
								'size' => 6,
							),
							'orderby'   => 'popularity',
							'orderway'  => 'DESC',
						),
						array(
							'tab_title' => esc_html__( 'Most Popular', 'wolmart-core' ),
							'count'     => array(
								'unit' => 'px',
								'size' => 6,
							),
							'orderby'   => 'rating',
							'orderway'  => 'DESC',
						),
						array(
							'tab_title' => esc_html__( 'Featured', 'wolmart-core' ),
							'count'     => array(
								'unit' => 'px',
								'size' => 6,
							),
							'status'    => 'featured',
						),
					),
					'title_field'   => '{{{ tab_title }}}',
					'prevent_empty' => false,
				)
			);

		$this->end_controls_section();

		wolmart_elementor_products_layout_controls( $this, 'tab' );

		wolmart_elementor_product_type_controls( $this );

		wolmart_elementor_tab_style_controls( $this );

		wolmart_elementor_slider_style_controls( $this, 'layout_type' );

		// wolmart_elementor_product_style_controls( $this );
	}

	public function render_content() {
		$settings = $this->get_settings_for_display();

		do_action( 'elementor/widget/before_render_content', $this );

		ob_start();

		$skin = $this->get_current_skin();
		if ( $skin ) {
			$skin->set_parent( $this );
			$skin->render_by_mode();
		} else {
			$this->render_by_mode();
		}

		$widget_content = ob_get_clean();

		if ( empty( $widget_content ) ) {
			return;
		}

		$extra_class = ' tab';

		if ( isset( $settings['tab_type'] ) && 'vertical' === $settings['tab_type'] ) {
			$extra_class .= ' tab-vertical';

			if ( isset( $settings['tab_v_type'] ) ) {
				switch ( $settings['tab_v_type'] ) { // vertical tab type
					case 'simple':
						$extra_class .= ' tab-simple';
						break;
					case 'solid':
						$extra_class .= ' tab-nav-solid';
						break;
				}
			}
		} else {
			if ( isset( $settings['tab_h_type'] ) ) {
				switch ( $settings['tab_h_type'] ) { // horizontal tab type
					case 'simple':
						$extra_class .= ' tab-nav-simple tab-nav-boxed';
						break;
					case 'solid1':
						$extra_class .= ' tab-nav-boxed tab-nav-solid';
						break;
					case 'solid2':
						$extra_class .= ' tab-nav-boxed tab-nav-solid tab-nav-round';
						break;
					case 'outline1':
						$extra_class .= ' tab-nav-boxed tab-outline';
						break;
					case 'outline2':
						$extra_class .= ' tab-nav-boxed tab-outline2';
						break;
					case 'link':
						$extra_class .= ' tab-nav-boxed tab-nav-underline';
						break;
				}
			}

			if ( isset( $settings['tab_navs_pos'] ) ) {
				switch ( $settings['tab_navs_pos'] ) { // nav position
					case 'center':
						$extra_class .= ' tab-nav-center';
						break;
					case 'right':
						$extra_class .= ' tab-nav-right';
				}
			}

			if ( isset( $settings['tab_navs_pos_mobile'] ) ) {
				switch ( $settings['tab_navs_pos_mobile'] ) { // nav position
					case 'left':
						$extra_class .= ' tab-nav-sm-left';
						break;
					case 'center':
						$extra_class .= ' tab-nav-sm-center';
						break;
					case 'right':
						$extra_class .= ' tab-nav-sm-right';
				}
			}

			if ( isset( $settings['tab_navs_pos_tablet'] ) ) {
				switch ( $settings['tab_navs_pos_tablet'] ) { // nav position
					case 'left':
						$extra_class .= ' tab-nav-md-left';
						break;
					case 'center':
						$extra_class .= ' tab-nav-md-center';
						break;
					case 'right':
						$extra_class .= ' tab-nav-md-right';
				}
			}
		}
		?>
		<div class="elementor-widget-container<?php echo esc_attr( $extra_class ); ?>">
			<?php
			$widget_content = apply_filters( 'elementor/widget/render_content', $widget_content, $this );
			echo wolmart_escaped( $widget_content );
			?>
		</div>
		<?php
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require __DIR__ . '/render-products-tab-elementor.php';
	}

	protected function content_template() {}
}
