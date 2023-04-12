<?php
/**
 * Menu template
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */
defined( 'ABSPATH' ) || die;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'menu_id'             => '',
			'type'                => 'vertical',
			'mobile'              => '',
			'underline'           => '',
			'label'               => '',
			'icon'                => array( 'value' => 'w-icon-category' ),
			'no_bd'               => '',
			'show_home'           => '',
			'show_page'           => '',
			'mobile_label'        => esc_html__( 'Links', 'wolmart-core' ),
			'mobile_dropdown_pos' => '',
		),
		$atts
	)
);

$menu = (object) array(
	'menu_id'             => $menu_id,
	'type'                => $type,
	'mobile'              => 'yes' == $mobile,
	'mobile_text'         => $mobile_label ? $mobile_label : esc_html__( 'Links', 'wolmart-core' ),
	'underline'           => $underline,
	'label'               => $label,
	'icon'                => isset( $icon['value'] ) ? $icon['value'] : '',
	'no_bd'               => $no_bd,
	'show_home'           => $show_home,
	'show_page'           => $show_page,
	'mobile_dropdown_pos' => $mobile_dropdown_pos,
);

if ( isset( $menu->menu_id ) && wp_get_nav_menu_object( $menu->menu_id ) ) {
	$class      = '';
	$wrap_cls   = '';
	$wrap_cls  .= ' ' . $menu->type . '-menu';
	$wrap_style = '';

	if ( 'horizontal' != $menu->type && isset( $menu->width ) ) {
		$wrap_style .= 'width: ' . (float) $menu->width . 'px';
	}

	if ( 'horizontal' == $menu->type && $menu->mobile ) {
		echo '<div class="dropdown dropdown-menu mobile-links">';
		echo '<a href="#">' . esc_attr( $menu->mobile_text ) . '</a>';
		$class = 'dropdown-box' . ( isset( $menu->mobile_dropdown_pos ) && $menu->mobile_dropdown_pos ? ' ' . $menu->mobile_dropdown_pos : '' );
	} elseif ( 'dropdown' == $menu->type ) {
		$tog_class = array();
		if ( ! $menu->no_bd ) {
			$tog_class[] = 'has-border';
		}
		if ( isset( $menu->show_page ) && $menu->show_page ) {
			$tog_class[] = 'show';
		}
		if ( $menu->show_home && is_front_page() ) {
			$tog_class[] = 'show-home';
		}
		echo '<div class="dropdown toggle-menu ' . implode( ' ', $tog_class ) . '">';
		echo '<a href="#" class="dropdown-menu-toggle">';
		if ( $menu->icon ) {
			echo '<i class="' . esc_attr( $menu->icon ) . '"></i>';
		}
		if ( $menu->label ) {
			echo '<span>' . esc_html( $menu->label ) . '</span>';
		}
		echo '</a>';

		$class     = 'dropdown-box';
		$wrap_cls .= ' vertical-menu';
	}

	if ( isset( $menu->underline ) && $menu->underline ) {
		$wrap_cls .= ' menu-active-underline';
	}

	$class .= ' ' . get_term_field( 'slug', $menu->menu_id );

	$lazyload_menu_enabled = ! wp_doing_ajax() &&
				! is_customize_preview() &&
				! ( function_exists( 'wolmart_is_elementor_preview' ) &&
					wolmart_is_elementor_preview()
				) && wolmart_get_option( 'lazyload_menu' );

	if ( $lazyload_menu_enabled ) {
		$wrap_cls .= ' lazy-menu';
	}

	wp_nav_menu(
		array(
			'menu'            => $menu->menu_id,
			'container'       => 'nav',
			'container_class' => $class,
			'items_wrap'      => '<ul id="%1$s" class="menu ' . esc_attr( $wrap_cls ) . '" style="' . $wrap_style . '">%3$s</ul>',
			'walker'          => new Wolmart_Walker_Nav_Menu(),
			'depth'           => $lazyload_menu_enabled ? 1 : 0,
			'lazy'            => wolmart_get_option( 'lazyload_menu' ),
			'theme_location'  => '',
			'fallback_cb'     => false,
		)
	);

	if ( isset( $menu->mobile ) && $menu->mobile ) {
		echo '</div>';
	} elseif ( 'dropdown' == $menu->type ) {
		echo '</div>';
	}
} else {
	?>
	<nav class="d-none d-lg-block">
		<ul class="menu dummy-menu">
			<?php esc_html_e( 'Select Menu', 'wolmart-core' ); ?>
		</ul>
	</nav>
	<?php
}
