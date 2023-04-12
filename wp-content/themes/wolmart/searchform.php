<?php
/**
 * The search-form template
 *
 * @package Wolmart WordPress Framework
 * @since 1.2.0
 */

defined( 'ABSPATH' ) || die;

$options          = $args['aria_label'];
$where            = isset( $options ) && isset( $options['where'] ) ? $options['where'] : '';
$live_search      = (bool) wolmart_get_option( 'live_search' );
$search_type      = isset( $options['type'] ) ? $options['type'] : wolmart_get_option( 'search_form_type' );
$class            = $search_type;
$search_post_type = isset( $options['search_post_type'] ) ? $options['search_post_type'] : '';
$icon             = isset( $options['icon'] ) ? $options['icon'] : 'w-icon-search';
$show_keywords    = isset( $options['show_keywords'] ) ? $options['show_keywords'] : '';

if ( function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'save_search' ) && 'yes' == $show_keywords ) {
	$keywords_html     = '<div class="search-keywords-container">
	<span>' . esc_html__( 'Popular Searches:', 'wolmart-core' ) . '</span>';
	$keyword_content   = isset( $options['keyword_content'] ) && $options['keyword_content'] ? $options['keyword_content'] : '';
	$keyword_count     = isset( $options['keyword_count'] ) && $options['keyword_count']['size'] ? $options['keyword_count']['size'] : 8;
	$res_keyword_count = $options['res_keyword_count'] ? (int) $options['res_keyword_count'] : (int) $keyword_count;

	$default_keys = explode( '|', $keyword_content );

	$results = apply_filters( 'wolmart_get_most_used_search_keys', array() );

	if ( count( $default_keys ) > 1 ) {
		foreach ( $default_keys as $item ) {
			array_push(
				$results,
				(object) array(
					'keyword' => sprintf( esc_html__( '%s', 'wolmart-core' ), $item ),
					'count'   => '1',
				)
			);
		}
	}

	$link = get_home_url();

	if ( 0 !== strpos( strrev( $link ), '/' ) ) {
		$link = $link . '/';
	}

	if ( count( $results ) ) {
		$keywords_html .= '<div class="search-keywords-box">';
		$temp           = array();

		foreach ( $results as $key => $keyword ) {

			if ( count( $temp ) == absint( $keyword_count ) ) {
				break;
			}

			if ( in_array( $keyword->keyword, $temp ) ) {
				continue;
			}

			array_push( $temp, $keyword->keyword );

			if ( $search_post_type ) {
				$link = add_query_arg( 'post_type', $search_post_type, $link );
			}

			$link = add_query_arg( 's', $keyword->keyword, $link );

			$link = str_replace( ' ', '%20', $link );

			if ( $link && $keyword->keyword ) {
				$keywords_html .= '<a rel="nofollow" href="' . esc_url( $link ) . '">' . esc_html( $keyword->keyword ) . '</a>';
			}
		}

		$keywords_html .= '</div>';

		echo '<style>';

		echo '@media (max-width:' . ( function_exists( 'wolmart_get_option' ) ? (int) wolmart_get_option( 'container' ) - 1 : 1279 ) . 'px) and (min-width: 992px) {';
		echo '.search-keywords-box a:nth-last-child(-n+' . ( (int) $keyword_count - $res_keyword_count ) . ') { display: none; } }';

		echo '</style>';

	} else {
		$keywords_html .= esc_html__( '&nbsp;No Search keywords', 'wolmart-core' );
	}

	$keywords_html .= '</div>';
}

if ( isset( $options['placeholder'] ) ) {
	$placeholder = $options['placeholder'];
} else {
	if ( 'post' == $search_post_type ) {
		$placeholder = esc_html__( 'Search in Blog', 'wolmart' );
	} else {
		$placeholder = esc_html__( 'Search', 'wolmart' );
	}
}

if ( '' == $where && ! isset( $options['type'] ) ) {
	$search_type = 'hs-simple';
	$class       = 'hs-simple';
}
?>

<div class="search-wrapper <?php echo esc_attr( $class ); ?>">
	<form action="<?php echo esc_url( home_url() ); ?>/" method="get" class="input-wrapper">
		<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_post_type ); ?>"/>

		<?php if ( 'header' == $where && ( 'hs-expanded' == $search_type ) ) : ?>
		<div class="select-box">
			<?php
			$args = array(
				'show_option_all' => esc_html__( 'All Categories', 'wolmart' ),
				'hierarchical'    => 1,
				'class'           => 'cat',
				'echo'            => 1,
				'value_field'     => 'slug',
				'selected'        => 1,
				'depth'           => 1,
			);
			if ( 'product' == $search_post_type && class_exists( 'WooCommerce' ) ) {
				$args['taxonomy'] = 'product_cat';
				$args['name']     = 'product_cat';
			}
			wp_dropdown_categories( $args );
			?>
		</div>
		<?php endif; ?>

		<input type="search" aria-label="<?php esc_attr_e( 'Search', 'wolmart' ); ?>" class="form-control" name="s" placeholder="<?php echo esc_attr( $placeholder ); ?>" required="" autocomplete="off">

		<?php if ( $live_search ) : ?>
			<div class="live-search-list"></div>
		<?php endif; ?>

		<button class="btn btn-search" aria-label="<?php esc_attr_e( 'Search Button', 'wolmart' ); ?>" type="submit">
			<i class="<?php echo esc_attr( $icon ); ?>"></i>
		</button> 
	</form>
	<?php

	if ( function_exists( 'wolmart_get_option' ) && wolmart_get_option( 'save_search' ) && 'yes' == $show_keywords && $keywords_html ) {
		echo wolmart_escaped( $keywords_html );
	}

	?>
</div>
