<?php
defined( 'ABSPATH' ) || die;

/**
 * Wolmart Banner Widget
 *
 * Wolmart Widget to display banner.
 *
 * @since 1.0
 */

class Wolmart_Banner_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wolmart_widget_banner';
	}

	public function get_title() {
		return esc_html__( 'Banner', 'wolmart-core' );
	}

	public function get_icon() {
		return 'wolmart-elementor-widget-icon eicon-banner';
	}

	public function get_categories() {
		return array( 'wolmart_widget' );
	}

	public function get_keywords() {
		return array( 'banner' );
	}

	public function get_script_depends() {
		return array( 'jquery-parallax' );
	}

	protected function register_controls() {
		wolmart_elementor_banner_controls( $this );
	}

	public function get_repeater_setting_key( $setting_key, $repeater_key, $repeater_item_index ) {
		return parent::get_repeater_setting_key( $setting_key, $repeater_key, $repeater_item_index );
	}

	public function add_inline_editing_attributes( $key, $toolbar = 'basic' ) {
		parent::add_inline_editing_attributes( $key, $toolbar );
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		require __DIR__ . '/render-banner-elementor.php';
	}

	public function before_render() {
		$atts = $this->get_settings_for_display();
		if ( isset( $atts['stretch_height'] ) && 'yes' === $atts['stretch_height'] ) {
			$this->add_render_attribute( '_wrapper', 'class', 'elementor-widget-wolmart_banner_stretch' );
		}
		?>
		<div <?php $this->print_render_attribute_string( '_wrapper' ); ?>>
		<?php
	}

	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'banner_wrapper', 'class', 'banner' );
		view.addRenderAttribute( 'banner_content', 'class', 'banner-content' );

		if ( settings.overlay ) {
			let overlayClass = '';

			if ( 'light' == settings.overlay || 'dark' == settings.overlay || 'zoom' == settings.overlay ) {
				overlayClass = 'overlay-' + settings.overlay;
			}
			if ( 'zoom_light' == settings.overlay ) {
				overlayClass = 'overlay-zoom overlay-light';
			}
			if ( 'zoom_dark' == settings.overlay ) {
				overlayClass = 'overlay-zoom overlay-dark';
			}
			if ( 'effect-1' == settings.overlay || 'effect-2' == settings.overlay || 'effect-3' == settings.overlay || 'effect-4' == settings.overlay ) {
				overlayClass = 'overlay-' + settings.overlay;
			}

			view.addRenderAttribute( 'banner_wrapper', 'class', overlayClass );
		}

		view.addRenderAttribute( 'banner_wrapper', 'class', 'banner-fixed' );

		view.addRenderAttribute( 'banner_content', 'class', settings.banner_origin );

		// Parallax
		if ( 'yes' == settings.parallax ) {
			let parallax_img     = settings.banner_background_image.url;
			let parallax_options = {
				'speed'          : settings.parallax_speed.size ? 10 / settings.parallax_speed.size : 1.5,
				'parallaxHeight' : settings.parallax_height.size ? settings.parallax_height.size + '%' : '300%',
				'offset'         : settings.parallax_offset.size ? settings.parallax_offset.size : 0,
			};
			view.addRenderAttribute( 'banner_wrapper', 'class', 'parallax' );
			view.addRenderAttribute( 'banner_wrapper', 'data-plugin', 'parallax' );
			view.addRenderAttribute( 'banner_wrapper', 'data-image-src', parallax_img );
			view.addRenderAttribute( 'banner_wrapper', 'data-parallax-options', JSON.stringify( parallax_options ) );
		}

		// Stretch Height
		if ( 'yes' == settings.stretch_height ) {
			view.addRenderAttribute( 'banner_wrapper', 'class', 'banner-stretch' );
		}

		#><div {{{ view.getRenderAttributeString( 'banner_wrapper' ) }}}><#
		
		if ( '' !== settings.background_effect || '' !== settings.particle_effect ) {
			let background_effectClass = 'background-effect ';
			let particle_effectClass   = 'particle-effect ';
			if ( settings.background_effect ) {
				background_effectClass += settings.background_effect;
			}
			if ( settings.particle_effect ) {
				particle_effectClass += settings.particle_effect;
			}

			view.addRenderAttribute( 'backgroundClass', 'class', background_effectClass );
			view.addRenderAttribute( 'particleClass', 'class', particle_effectClass );

			if ( settings.banner_background_image ) {
				let background_img = '';
				if ( settings.particle_effect && !settings.background_effect ) {
					background_img = '';
				} else {
				background_img = 'background-image: url(' + settings.banner_background_image.url + '); background-size: cover;';
				}
				view.addRenderAttribute( 'backgroundClass', 'style', background_img );
			}

			#>
			<div class="background-effect-wrapper">
			<div {{{ view.getRenderAttributeString( 'backgroundClass' ) }}}>
			<# if ( '' !== settings.particle_effect ) { #>
				<div {{{ view.getRenderAttributeString( 'particleClass' ) }}}></div>
			<# } #> 
			</div>
			</div>
			<#
		}

		if ( settings.banner_background_image.url ) {
			#>
			<figure class="banner-img">
				<img src="{{ settings.banner_background_image.url }}">
			</figure>
			<#
		}

		if ( settings.banner_wrap ) {
			#><div class="{{ settings.banner_wrap }}">'<#
		}

		// Showing Items
		#><div {{{ view.getRenderAttributeString( 'banner_content' ) }}}><#

		if ( settings._content_animation ) {
			view.addRenderAttribute( 'banner_content_inner', 'class', 'appear-animate animated-' + settings.content_animation_duration );
			let contentSettings       = {
				'_animation'       : settings._content_animation,
				'_animation_delay' : settings._content_animation_delay ? settings._content_animation_delay : 0,
			};
			view.addRenderAttribute( 'banner_content_inner', 'data-settings', JSON.stringify( contentSettings ) );
			#><div {{{ view.getRenderAttributeString( 'banner_content_inner' ) }}}><#
		}


		_.each( settings.banner_item_list, function( item, index ) {

			let item_key = 'banner_item';
			if ( item.banner_item_type == 'text' ) { // Text
				item_key = view.getRepeaterSettingKey( 'banner_text_content', 'banner_item_list', index );
			}

			view.renderAttributes[item_key] = {};
			view.addRenderAttribute( item_key, 'class', 'banner-item' );
			view.addRenderAttribute( item_key, 'class', 'elementor-repeater-item-' + item._id );

			// Custom Class
			if ( item.banner_item_aclass ) {
				view.addRenderAttribute( item_key, 'class', item.banner_item_aclass );
			}

			// Animation
			let itemSettings = '';
			if ( item._animation ) {
				view.addRenderAttribute( item_key, 'class', 'appear-animate animated-' + settings.animation_duration );
				let itemSettings = {
					'_animation'       : settings._animation,
					'_animation_delay' : settings._animation_delay ? settings._animation_delay : 0,
				};
				view.addRenderAttribute( item_key, 'data-settings', JSON.stringify( itemSettings ) );
			}

			// Item display type
			if ( 'yes' != item.banner_item_display ) {
				view.addRenderAttribute( item_key, 'class', 'item-block' );
			} else {
				view.addRenderAttribute( item_key, 'class', 'item-inline' );
			}

			if ( item.banner_item_type == 'text' ) { // Text

				view.addRenderAttribute( item_key, 'class', 'elementor-banner-item-text' );

				view.addInlineEditingAttributes( item_key );

				#><{{item.banner_text_tag}} {{{ view.getRenderAttributeString( item_key ) }}}>{{{ item.banner_text_content }}}</{{item.banner_text_tag}}><#

			} else if ( item.banner_item_type == 'button' ) { // Button

				btn_class = [];
				if ( item.button_type ) {
					btn_class.push(item.button_type);
				}
				if ( item.link_hover_type ) {
					btn_class.push(item.link_hover_type);
				}
				if ( item.button_size ) {
					btn_class.push(item.button_size);
				}
				if ( item.shadow ) {
					btn_class.push(item.shadow);
				}
				if ( item.button_border ) {
					btn_class.push(item.button_border);
				}
				if ( item.button_skin ) {
					btn_class.push(item.button_skin);
				}
				if ( item.btn_class ) {
					btn_class.push(item.btn_class);
				}
				if ( 'yes' == item.icon_hover_effect_infinite ) {
					btn_class.push('btn-infinite');
				}

				if ( 'yes' == item.show_icon && item.icon && item.icon.value ) {
					if ( 'yes' != item.show_label ) {
						btn_class.push('btn-icon');
					} else if ( 'before' == item.icon_pos ) {
						btn_class.push('btn-icon-left');
					} else {
						btn_class.push('btn-icon-right');
					}
					if ( item.icon_hover_effect ) {
						btn_class.push(item.icon_hover_effect);
					}
				}

				view.addRenderAttribute( item_key, 'href', item.banner_btn_link.url );
				view.addRenderAttribute( item_key, 'class', 'btn' );
				if ( item.banner_btn_aclass ) {
					view.addRenderAttribute( item_key, 'class', item.banner_btn_aclass );
				}
				view.addRenderAttribute( item_key, 'class', btn_class );
					#>
				<a {{{ view.getRenderAttributeString( item_key ) }}}>
					<#
					let btn_text_key = view.getRepeaterSettingKey( 'banner_btn_text', 'banner_item_list', index );

					view.addRenderAttribute( btn_text_key, 'class', 'elementor-banner-item-text' );
					view.addInlineEditingAttributes( btn_text_key );

					let btn_text = '';

					btn_text = item.banner_btn_text;
					if ( item.icon && item.icon.value && 'yes' == item.show_icon ) {
						if ( 'yes' != item.show_label ) {
							#><i class="{{{ item.icon.value }}}"></i><#
						} else if ( 'before' == item.icon_pos ) {
							#>
							<i class="{{{ item.icon.value }}}"></i><span {{{ view.getRenderAttributeString( btn_text_key ) }}}>{{{ btn_text }}}</span>
							<#
						} else {
							#>
							<span {{{ view.getRenderAttributeString( btn_text_key ) }}}>{{{ btn_text }}}</span><i class="{{{ item.icon.value }}}"></i>
							<#
						}
					} else {
						#>
					<span {{{ view.getRenderAttributeString( btn_text_key ) }}}>{{{ btn_text }}}</span>
						<#
					}
					#>
				</a>
					<#
			} else if (item.banner_item_type == 'image') { // Image
				let image = {
					id: item.banner_image.id,
					url: item.banner_image.url,
					size: item.banner_image_size,
					dimension: item.banner_image_custom_dimension,
					model: view.getEditModel()
				};
				let image_url = elementor.imagesManager.getImageUrl( image );
				view.addRenderAttribute( item_key, 'src', image_url );

				#><img {{{ view.getRenderAttributeString( item_key ) }}}><#
			} else { // Divider
				view.addRenderAttribute( item_key, 'class', 'divider-wrap' );
				#><div {{{ view.getRenderAttributeString( item_key ) }}}><hr class="divider"></div><#
			}
		} );
		if ( settings._content_animation ) {
			#></div><#
		}
		#></div><#
		if ( settings.banner_wrap ) {
			#></div><#
		}
		#></div><#
		#>
		<?php
	}
}
