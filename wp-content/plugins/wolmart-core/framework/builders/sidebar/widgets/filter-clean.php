<?php

// direct load is not allowed
defined( 'ABSPATH' ) || die;

class Wolmart_Filter_Clean_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-filter-clean',
			'description' => esc_html__( 'Display filter clean button in shop sidebar.', 'wolmart-core' ),
		);

		$control_ops = array( 'id_base' => 'filter-clean-widget' );

		parent::__construct( 'filter-clean-widget', esc_html__( 'Wolmart - Filter Clean', 'wolmart-core' ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		if ( ! function_exists( 'wolmart_is_shop' ) || ! wolmart_is_shop() ) {
			return;
		}

		global $wolmart_layout;
		if ( ! empty( $wolmart_layout['top_sidebar'] ) && 'hide' != $wolmart_layout['top_sidebar'] ) {
			return;
		}

		extract( $args ); // @codingStandardsIgnoreLine

		?>

		<div class="filter-actions">
			<label><?php esc_html_e( 'Filter :', 'wolmart-core' ); ?></label>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="filter-clean"><?php esc_html_e( 'Clean All', 'wolmart-core' ); ?></a>
		</div>

		<?php
	}


	public function form( $instance ) {
		?>
		<p><?php esc_html_e( 'Display filter clean button in shop sidebar.', 'wolmart-core' ); ?></p>
		<?php
	}
}
