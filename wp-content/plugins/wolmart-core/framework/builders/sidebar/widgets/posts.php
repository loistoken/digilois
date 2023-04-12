<?php

// direct load is not allowed
defined( 'ABSPATH' ) || die;

class Wolmart_Posts_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-posts',
			'description' => esc_html__( 'Display widget typed posts.', 'wolmart-core' ),
		);

		$control_ops = array( 'id_base' => 'posts-widget' );

		parent::__construct( 'posts-widget', esc_html__( 'Wolmart - Posts', 'wolmart-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract( $args ); // @codingStandardsIgnoreLine

		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		$output = '';
		echo $before_widget;

		if ( $title ) {
			echo $before_title . sanitize_text_field( $title ) . $after_title;
		}

		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => isset( $instance['count'] ) ? $instance['count'] : 6,
			'orderby'        => isset( $instance['orderby'] ) ? $instance['orderby'] : '',
			'order'          => isset( $instance['orderway'] ) ? $instance['orderway'] : 'ASC',
		);

		$posts = new WP_Query( $args );

		$count = count( $posts->posts );

		if ( $posts->have_posts() ) {
			if ( ! isset( $instance['slide_cnt'] ) ) {
				$instance['slide_cnt'] = 6;
			}

			if ( $instance['slide_cnt'] < $count ) {

				wp_enqueue_script( 'swiper' );

				echo '<div class="slider-wrapper row cols-1" data-slider-options=' .
					"'" . json_encode(
						array(
							'slidesPerView' => 1,
							'navigation'    => true,
							'autoFix'       => true,
							'pagination'    => false,
							'statusClass'   => 'slider-nav-top',
						)
					) . "'" . '>';
			}

			$props['widget']         = true;
			$props['type']           = 'widget';
			$props['show_info']      = array( 'image', 'date' );
			$props['posts_layout']   = 'grid';
			$props['overlay']        = '';
			$props['show_datebox']   = '';
			$props['excerpt_length'] = '';
			$props['excerpt_type']   = '';
			$props['thumbnail_size'] = 'thumbnail';

			$idx       = 0;
			$slide_cnt = isset( $instance['slide_cnt'] ) ? $instance['slide_cnt'] : 3;

			if ( 0 === (int) $slide_cnt ) {
				$slide_cnt = 3;
			}

			while ( $posts->have_posts() ) {
				$posts->the_post();

				if ( 0 == $idx % $slide_cnt ) {
					if ( 0 != $idx ) {
						echo '</div>';
					}
					echo '<div class="posts-col">';
				}

				wolmart_get_template_part( 'posts/post', null, $props );

				++ $idx;
			}

			echo '</div>';

			if ( $slide_cnt < $count ) {
				echo '</div>';
			}
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']     = $new_instance['title'];
		$instance['orderby']   = $new_instance['orderby'];
		$instance['orderway']  = $new_instance['orderway'];
		$instance['count']     = $new_instance['count'];
		$instance['slide_cnt'] = $new_instance['slide_cnt'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title'     => '',
			'orderby'   => '',
			'orderway'  => 'ASC',
			'count'     => '6',
			'slide_cnt' => '3',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php esc_html_e( 'Title', 'wolmart-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : ''; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>">
				<strong><?php esc_html_e( 'Order By', 'wolmart-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" value="<?php echo isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : ''; ?>">
					<?php

					echo '<option value=""' . selected( $instance['orderby'], '' ) . '>' . esc_html__( 'Default', 'wolmart-core' );
					echo '<option value="ID"' . selected( $instance['orderby'], 'ID' ) . '>' . esc_html__( 'ID', 'wolmart-core' );
					echo '<option value="title"' . selected( $instance['orderby'], 'title' ) . '>' . esc_html__( 'Title', 'wolmart-core' );
					echo '<option value="date"' . selected( $instance['orderby'], 'date' ) . '>' . esc_html__( 'Date', 'wolmart-core' );
					echo '<option value="modified"' . selected( $instance['orderby'], 'modified' ) . '>' . esc_html__( 'Modified', 'wolmart-core' );
					echo '<option value="author"' . selected( $instance['orderby'], 'author' ) . '>' . esc_html__( 'Author', 'wolmart-core' );
					echo '<option value="comment_count"' . selected( $instance['orderby'], 'comment_count' ) . '>' . esc_html__( 'Comment count', 'wolmart-core' );

					?>
				</select>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'orderway' ); ?>">
				<strong><?php esc_html_e( 'Order Way', 'wolmart-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo $this->get_field_id( 'orderway' ); ?>" name="<?php echo $this->get_field_name( 'orderway' ); ?>" value="<?php echo isset( $instance['orderway'] ) ? esc_attr( $instance['orderway'] ) : ''; ?>">
					<?php
					echo '<option value="ASC"' . selected( $instance['orderway'], 'ASC' ) . '>' . esc_html__( 'Ascending', 'wolmart-core' ) . '</option>';
					echo '<option value="DESC"' . selected( $instance['orderway'], 'DESC' ) . '>' . esc_html__( 'Descending', 'wolmart-core' ) . '</option>';
					?>
				</select>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>">
				<strong><?php esc_html_e( 'Total Count', 'wolmart-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo esc_attr( $instance['count'] ); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'slide_cnt' ); ?>">
				<strong><?php esc_html_e( 'Count per Slide', 'wolmart-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'slide_cnt' ); ?>" name="<?php echo $this->get_field_name( 'slide_cnt' ); ?>" value="<?php echo esc_attr( $instance['slide_cnt'] ); ?>" />
			</label>
		</p>
		<?php
	}
}
