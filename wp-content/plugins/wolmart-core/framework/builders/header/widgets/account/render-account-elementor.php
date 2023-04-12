<?php
/**
 * Header account template
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */
defined( 'ABSPATH' ) || die;

wp_enqueue_script( 'jquery-magnific-popup' );

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'type'             => '',
			'items'            => array(),
			'login_text'       => '',
			'logout_text'      => '',
			'register_text'    => '',
			'delimiter_text'   => '',
			'account_dropdown' => '',
			'account_avatar'   => '',
			'icon'             => 'w-icon-account',
		),
		$atts
	)
);

$type          = $type ? $type . '-type' : '';
$login_link    = '';
$register_link = '';
$html          = '';
$extra_class   = '';

if ( is_user_logged_in() ) {
	if ( class_exists( 'WooCommerce' ) ) {
		$logout_link = wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) );
	} else {
		$logout_link = wp_logout_url( get_home_url() );
	}

	$html .= '<a class="login logout ' . esc_attr( $type ) . '" href="' . esc_url( $logout_link ) . '">';

	if ( in_array( 'icon', $items ) ) {
		if ( $account_avatar ) {
			$html .= '<span class="account-avatar">' . get_avatar( get_current_user_id() ) . '</span>';
		} else {
			$html .= '<i class="' . esc_attr( $icon ) . '"></i>';
		}
	}
	if ( in_array( 'login', $items ) ) {
		$user  = wp_get_current_user();
		$html .= '<span>' . str_replace( '%name%', $user ? $user->display_name : '', $logout_text ) . '</span>';
	}
	$html .= '</a>';

	if ( $account_dropdown ) {
		$extra_class = ' dropdown account-dropdown';

		if ( ! has_nav_menu( 'account-menu' ) ) {
			$html .= '<div class="dropdown-box menu">';
			$html .= '<ul id="menu-account-menu" class="menu vertical-menu">';
			foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
				if ( 'wishlist' == $endpoint ) {
					$url = defined( 'YITH_WCWL' ) ? YITH_WCWL()->get_wishlist_url() : get_home_url();
				} elseif ( 'vendor_dashboard' == $endpoint ) {
					$url = apply_filters( 'wolmart_account_dashboard_link', '' );
				} else {
					$url = wc_get_account_endpoint_url( $endpoint );
				}
				if ( ! $url ) {
					continue;
				}
				$html .= '<li class="' . wc_get_account_menu_item_classes( $endpoint ) . ' menu-item">';
				$html .= '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
				$html .= '</li>';
			endforeach;
			$html .= '</ul>';
			$html .= '</div>';
		} else {
			$html .= '<div class="dropdown-box">';
			ob_start();
			wp_nav_menu(
				array(
					'theme_location' => 'account-menu',
					'container'      => 'nav',
					'items_wrap'     => '<ul id="%1$s" class="menu vertical-menu">%3$s</ul>',
					'walker'         => new Wolmart_Walker_Nav_Menu(),
					'depth'          => 0,
					'lazy'           => false,
				)
			);
			$html .= ob_get_clean() . '</div>';
		}
	}
} else {
	if ( class_exists( 'WooCommerce' ) ) {
		$login_link = wc_get_page_permalink( 'myaccount' );
		if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
			$register_link = $login_link;
		}
	} else {
		$login_link    = wp_login_url( get_home_url() );
		$active_signup = get_site_option( 'registration', 'none' );
		$active_signup = apply_filters( 'wpmu_active_signup', $active_signup );
		if ( 'none' != $active_signup ) {
			$register_link = wp_registration_url( get_home_url() );
		}
	}

	$html .= '<a class="login ' . esc_attr( $type ) . '" href="' . esc_url( $login_link ) . '">';

	if ( in_array( 'icon', $items ) ) {
		$html .= '<i class="' . esc_attr( $icon ) . '"></i>';
	}

	if ( in_array( 'login', $items ) ) {
		$html .= '<span>' . wolmart_strip_script_tags( $login_text ) . '</span>';
	}

	$html .= '</a>';

	if ( in_array( 'register', $items ) ) {
		if ( in_array( 'login', $items ) ) {
			$html .= '<span class="delimiter">' . esc_html( $delimiter_text ) . '</span>';
		}

		$html .= '<a class="register ' . esc_attr( $type ) . '" href="' . ( $register_link ? esc_url( $login_link ) : esc_url( $register_link ) ) . '">';
		$html .= '<span>' . wolmart_strip_script_tags( $register_text ) . '</span>';
		$html .= '</a>';
	}
}

echo '<div class="account' . esc_attr( $extra_class ) . '">' . $html . '</div>';
