<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Button Widget Render
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'attributes'   => array(),
			'btn_label'    => esc_html__( 'Filter', 'wolmart-core' ),
			'btn_skin'     => 'btn-primary',
			'align'        => 'center',
			'page_builder' => '',
		),
		$atts
	)
);

if ( is_array( $attributes ) && count( $attributes ) ) {
	?>

	<div class="wolmart-filters align-<?php echo esc_attr( $align ); ?>">
		<?php
		foreach ( $attributes as $attribute ) {
			if ( 'vc' == $page_builder && ! isset( $attribute['name'] ) ) {
				$attribute['name']      = 'pa_' . $attribute['title'];
				$attribute['query_opt'] = $attribute['queryType'];
			}
			?>
			<div class="wolmart-filter select-ul <?php echo esc_attr( $attribute['name'] ); ?>" data-filter-attr="<?php echo substr( $attribute['name'], 3 ); ?>" data-filter-query="<?php echo esc_attr( $attribute['query_opt'] ); ?>">
				<h3 class="select-ul-toggle"><?php printf( esc_html__( 'Select %s', 'wolmart-core' ), esc_attr( substr( $attribute['name'], strpos( $attribute['name'], 'pa_' ) + 3 ) ) ); ?></h3>
				<?php
				$terms = get_terms(
					array(
						'taxonomy'   => $attribute['name'],
						'hide_empty' => false,
					)
				);
				if ( is_array( $terms ) && count( $terms ) ) :
					?>
				<ul>
					<?php foreach ( $terms as $term ) : ?>
						<li data-value="<?php echo esc_attr( $term->slug ); ?>"><a href="#"><?php echo esc_html( $term->name ); ?></a></li>
				<?php endforeach; ?>
				</ul>
					<?php
				else :
					?>
					<ul><li> No Attribute </li></ul>
					<?php
				endif;
				?>
			</div>
			<?php
		}
		?>

		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn <?php echo esc_attr( $btn_skin ); ?> btn-filter"><?php echo esc_html( $btn_label ? $btn_label : 'Filter' ); ?></a>
	</div>

	<?php
}
