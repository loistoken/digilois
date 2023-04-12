<?php
/**
 * Dokan Dashboard Product Listing status filter
 * Template
 *
 * @since 2.4
 *
 * @package dokan
 */
$active_class = 'all' == $status_class ? 'active' : '';
?>
<ul class="dokan-listing-filter dokan-left subsubsub">
	<li class="<?php echo esc_attr( $active_class ); ?>">
		<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html__( 'All', 'dokan-lite' ); ?><span class="product-count"><?php echo esc_html( $post_counts->total ); ?></span></a> 
	</li>
	<?php foreach ( $statuses as $status => $status_label ) : ?>
		<?php
		if ( empty( $post_counts->{$status} ) ) {
			continue;
		}
		$active_class = $status == $status_class ? 'active' : '';
		?>
		<li class="<?php echo esc_attr( $active_class ); ?>">
			<a href="<?php echo esc_url( add_query_arg( array( 'post_status' => $status ), $permalink ) ); ?>"><?php echo esc_html( $status_label ); ?><span class="product-count"><?php echo esc_html( $post_counts->{$status} ); ?> </span></a>
		</li>
	<?php endforeach ?>
</ul> <!-- .post-statuses-filter -->
