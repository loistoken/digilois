<?php
/**
 * Header language switcher template
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */

defined( 'ABSPATH' ) || die;

if ( has_nav_menu( 'lang-switcher' ) ) {
	wp_nav_menu(
		array(
			'theme_location'  => 'lang-switcher',
			'container'       => 'nav',
			'container_class' => '',
			'items_wrap'      => '<ul id="%1$s" class="menu switcher lang-switcher">%3$s</ul>',
			'walker'          => new Wolmart_Walker_Nav_Menu(),
		)
	);
} elseif ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
	$languages = apply_filters( 'wpml_active_languages', array() );
	if ( ! empty( $languages ) && 1 < count( $languages ) ) {
		$active_lang = '';
		$other_langs = '';
		foreach ( $languages as $l ) {
			if ( ! $l['active'] ) {
				$other_langs .= '<li class="menu-item"><a href="' . esc_url( $l['url'] ) . '">';
			}
			if ( $l['country_flag_url'] ) {
				if ( $l['active'] ) {
					$active_lang .= '<img src="' . esc_url( $l['country_flag_url'] ) . '" alt="' . esc_attr( $l['language_code'] ) . '" width="18" height="12px" />';
				} else {
					$other_langs .= '<img src="' . esc_url( $l['country_flag_url'] ) . '" alt="' . esc_attr( $l['language_code'] ) . '" width="18" height="12px" />';
				}
			}
			if ( $l['active'] ) {
				$active_lang .= icl_disp_language( $l['native_name'], $l['translated_name'], apply_filters( 'wolmart_icl_show_native_name', true, $l ) );
			} else {
				$other_langs .= icl_disp_language( $l['native_name'], $l['translated_name'], apply_filters( 'wolmart_icl_show_native_name', true, $l ) );
			}
			if ( ! $l['active'] ) {
				$other_langs .= '</a></li>';
			}
		}
		?>
		<ul class="menu switcher lang-switcher">
			<li class="menu-item-has-children">
				<a class="switcher-toggle" href="#"><?php echo wolmart_strip_script_tags( $active_lang ); ?></a>
				<?php if ( $other_langs ) : ?>
				<ul>
					<?php echo wolmart_strip_script_tags( $other_langs ); ?>
				</ul>
				<?php endif; ?>
			</li>
		</ul>
		<?php
	}
} elseif ( class_exists( 'QTX_Translator' ) ) {
	global $q_config;

	$languages     = qtranxf_getSortedLanguages();
	$flag_location = qtranxf_flag_location();
	if ( is_404() ) {
		$url = esc_url( home_url() );
	} else {
		$url = '';
	}

	if ( ! empty( $languages ) && 1 < count( $languages ) ) {
		$active_lang = '';
		$other_langs = '';
		foreach ( $languages as $language ) {
			if ( $language != $q_config['language'] ) {
				$other_langs .= '<li><a href="' . qtranxf_convertURL( $url, $language, false, true ) . '">';
				$other_langs .= '<img src="' . esc_url( $flag_location . $q_config['flag'][ $language ] ) . '" alt="' . esc_attr( $q_config['language_name'][ $language ] ) . '" width="18px" height="12px"/>';
				$other_langs .= $q_config['language_name'][ $language ];
				$other_langs .= '</a></li>';
			} else {
				$active_lang .= '<img src="' . esc_url( $flag_location . $q_config['flag'][ $language ] ) . '" alt="' . esc_attr( $q_config['language_name'][ $language ] ) . '" width="18px" height="12px"/>';
				$active_lang .= $q_config['language_name'][ $language ];
			}
		}
		?>
		<ul class="menu switcher lang-switcher">
			<li class="menu-item-has-children">
				<a class="switcher-toggle" href="#"><?php echo wolmart_strip_script_tags( $active_lang ); ?></a>
				<?php if ( $other_langs ) : ?>
				<ul>
					<?php echo wolmart_strip_script_tags( $other_langs ); ?>
				</ul>
				<?php endif; ?>
			</li>
		</ul>
		<?php
	}
} else {
	?>
	<ul class="menu switcher lang-switcher">
		<li class="menu-item-has-children">
			<a href="#" class="switcher-toggle"><i class="flag flag-gb"></i><?php esc_html_e( 'ENG', 'wolmart-core' ); ?></a>
			<ul>
				<li><a href="#"><i class="flag flag-gb"></i><?php esc_html_e( 'ENG', 'wolmart-core' ); ?></a></li>
				<li><a href="#"><i class="flag flag-fr"></i><?php esc_html_e( 'FRA', 'wolmart-core' ); ?></a></li>
			</ul>
		</li>
	</ul>
	<?php
}
