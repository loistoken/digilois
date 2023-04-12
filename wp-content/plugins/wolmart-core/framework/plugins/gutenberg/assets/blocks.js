/**
 * Wolmart Gutenberg blocks
 *
 * 1. Slider
 * 2. Banner
 * 3. Products
 * 4. Product Categories
 * 5. Posts
 * 6. Icon-Box
 * 7. Heading
 * 8. Button
 */

var wolmartComponents = {};

jQuery( document ).ready( function ( $ ) {
	'use strict';
	if ( $( '#page_css' ).length && $( '#page_css' ).val() && !$( 'head > style#wolmart_page_css' ).length ) {
		$( '<style></style>' ).attr( 'id', 'wolmart_page_css' ).appendTo( 'head' ).html( $( '#page_css' ).val().replace( '/<script.*?\/script>/s', '' ) );
	}
	$( '#page_css' ).on( 'input', function ( e ) {
		if ( !$( 'head > style#wolmart_page_css' ).length ) {
			$( '<style></style>' ).attr( 'id', 'wolmart_page_css' ).appendTo( 'head' );
		}
		$( 'style#wolmart_page_css' ).html( $( this ).val().replace( '/<script.*?\/script>/s', '' ) );
	} );
} );

/**
 * Register Gutenberg Wolmart Block
 */
( function ( wpI18n, wpBlocks, wpElement, wpBlockEditor, wpComponents, wpData, lodash, apiFetch ) {
	"use strict";

	var el = wpElement.createElement,
		registerBlockType = wpBlocks.registerBlockType,
		InnerBlocks = wpBlockEditor.InnerBlocks;

	componentClassInit( wpI18n, wpElement, wpBlockEditor, wpComponents, apiFetch );

	// Register Wolmart Slider Block
	registerBlockType( 'wolmart/wolmart-slider', {
		title: 'Wolmart Slider',
		icon: 'wolmart',
		category: 'wolmart',
		attributes: {
			col_cnt_xl: { type: 'string', default: '1', },
			col_cnt: { type: 'string', default: '1', },
			col_cnt_min: { type: 'string', default: '1', },
			col_sp: { type: 'string', default: 'no', },
			slider_vertical_align: { type: 'string', default: '', },
			slider_horizontal_align: { type: 'string', default: '', },
			show_nav: { type: 'bool', default: false, },
			nav_hide: { type: 'bool', default: false, },
			nav_type: { type: 'string', default: 'simple', },
			nav_pos: { type: 'string', default: '', },
			show_dots: { type: 'bool', default: false, },
			dots_type: { type: 'string', default: '', },
			dots_pos: { type: 'string', default: '', },
			autoplay: { type: 'bool', default: false, },
			autoplay_timeout: { type: 'int', default: 5000, },
			loop: { type: 'bool', default: false, },
			pause_onhover: { type: 'bool', default: false, },
			autoheight: { type: 'bool', default: false, },
			item_sp: { type: 'int', default: 0, },
			nav_size: { type: 'int', default: 20, },
		},
		supports: {
			align: ['wide', 'full'],
		},
		edit: wolmartComponents.WolmartSlider,
		save: function ( props ) {
			return el( InnerBlocks.Content );
		}
	} );

	// Register Wolmart Banner Block
	registerBlockType( 'wolmart/wolmart-banner', {
		title: 'Wolmart Banner',
		icon: 'wolmart',
		category: 'wolmart',
		attributes: {
			pt: { type: 'int', default: 0, },
			pr: { type: 'int', default: 0, },
			pb: { type: 'int', default: 0, },
			pl: { type: 'int', default: 0, },
			mt: { type: 'int', default: 0, },
			mr: { type: 'int', default: 0, },
			mb: { type: 'int', default: 20, },
			ml: { type: 'int', default: 0, },
			bg_col: { type: 'string', default: '#e2e2e2', },
			bg_image: { type: 'int', default: undefined, },
			bg_image_url: { type: 'string', default: '', },
			container_width: { type: 'bool', default: false, },
			fixed_banner: { type: 'bool', default: false, },
			wrap_class: { type: 'string', default: '', },
			parallax: { type: 'bool', default: false, },
			par_speed: { type: 'int', default: 1, },
			par_offset: { type: 'int', default: 0, },
			par_height: { type: 'int', default: 200, },
			content_align: { type: 'string', default: 'left', },
			x_base: { type: 'string', default: 'left' },
			y_base: { type: 'string', default: 'bottom' },
			x_pos: { type: 'int', default: undefined },
			y_pos: { type: 'int', default: undefined },
			content_width: { type: 'int', default: '', },
			min_height: { type: 'int', default: 200, }
		},
		supports: {
			align: ['wide', 'full'],
		},
		edit: wolmartComponents.WolmartBanner,
		save: function ( props ) {
			return el( InnerBlocks.Content );
		}
	} );

	// Register Wolmart Products Block
	registerBlockType( 'wolmart/wolmart-products', {
		title: 'Wolmart Products',
		icon: 'wolmart',
		category: 'wolmart',
		attributes: {
			status: { type: 'string', default: 'products', },
			category_type: { type: 'string', default: '', },
			category_list: { type: 'array', default: [], },
			count: { type: 'int', default: 10, },
			orderby: { type: 'string', default: 'title', },
			orderway: { type: 'string', default: 'asc', },
			layout_type: { type: 'string', default: 'grid', },
			filter_cat: { type: 'boolean', default: false, },
			split_line: { type: 'boolean', default: false, },
			col_cnt: { type: 'string', default: '4', },
			col_cnt_xl: { type: 'string', default: '', },
			col_cnt_tablet: { type: 'string', default: '', },
			col_cnt_mobile: { type: 'string', default: '', },
			col_cnt_min: { type: 'string', default: '', },
			col_sp: { type: 'string', default: '', },
			slider_vertical_align: { type: 'string', default: '', },
			slider_horizontal_align: { type: 'string', default: '', },
			show_nav: { type: 'bool', default: false, },
			nav_hide: { type: 'bool', default: false, },
			nav_type: { type: 'string', default: 'simple', },
			nav_pos: { type: 'string', default: '', },
			show_dots: { type: 'bool', default: false, },
			dots_type: { type: 'string', default: '', },
			dots_pos: { type: 'string', default: '', },
			autoplay: { type: 'bool', default: false, },
			autoplay_timeout: { type: 'int', default: 5000, },
			loop: { type: 'bool', default: false, },
			pause_onhover: { type: 'bool', default: false, },
			autoheight: { type: 'bool', default: false, },
			item_sp: { type: 'int', default: 0, },
			product_type: { type: 'string', default: '', },
			classic_hover: { type: 'string', default: '', },
			show_in_box: { type: 'boolean', default: false, },
			show_media_shadow: { type: 'boolean', default: false, },
		},
		edit: wolmartComponents.WolmartProducts,
		save: function ( props ) {
			return el( InnerBlocks.Content );
		}
	} );

	// Register Wolmart Categories Block
	registerBlockType( 'wolmart/wolmart-categories', {
		title: 'Wolmart Categories',
		icon: 'wolmart',
		category: 'wolmart',
		attributes: {
			count: { type: 'int', default: 4, },
			category: { type: 'string', default: '', },
			category_list: { type: 'array', default: [], },
			hide_empty: { type: 'boolean', default: false, },
			orderby: { type: 'string', default: 'name', },
			orderway: { type: 'string', default: 'asc', },
			layout_type: { type: 'string', default: 'grid', },
			creative_mode: { type: 'int', default: 1 },
			creative_height: { type: 'int', default: 600 },
			col_cnt: { type: 'string', default: '4', },
			col_cnt_xl: { type: 'string', default: '', },
			col_cnt_tablet: { type: 'string', default: '', },
			col_cnt_mobile: { type: 'string', default: '', },
			col_cnt_min: { type: 'string', default: '', },
			col_sp: { type: 'string', default: '', },
			slider_vertical_align: { type: 'string', default: '', },
			slider_horizontal_align: { type: 'string', default: '', },
			show_nav: { type: 'bool', default: false, },
			nav_hide: { type: 'bool', default: false, },
			nav_type: { type: 'string', default: 'simple', },
			nav_pos: { type: 'string', default: '', },
			show_dots: { type: 'bool', default: false, },
			dots_type: { type: 'string', default: '', },
			dots_pos: { type: 'string', default: '', },
			autoplay: { type: 'bool', default: false, },
			autoplay_timeout: { type: 'int', default: 5000, },
			loop: { type: 'bool', default: false, },
			pause_onhover: { type: 'bool', default: false, },
			autoheight: { type: 'bool', default: false, },
			item_sp: { type: 'int', default: 0, },
			category_type: { type: 'string', default: 'classic', },
			overlay: { type: 'string', default: '', },
			show_count: { type: 'boolean', default: false, },
			show_icon: { type: 'boolean', default: false, },
			show_link: { type: 'boolean', default: false, },
			link_text: { type: 'string', default: 'Shop now', },
		},
		edit: wolmartComponents.WolmartCategories,
		save: function ( props ) {
			return el( InnerBlocks.Content );
		}
	} );

	// Register Wolmart Posts Block
	registerBlockType( 'wolmart/wolmart-posts', {
		title: 'Wolmart Posts',
		icon: 'wolmart',
		category: 'wolmart',
		attributes: {
			count: { type: 'int', default: 4, },
			category_type: { type: 'string', default: '', },
			category_list: { type: 'array', default: [], },
			orderby: { type: 'string', default: 'id', },
			orderway: { type: 'string', default: 'asc', },
			layout_type: { type: 'string', default: 'grid', },
			col_cnt: { type: 'string', default: '4', },
			col_cnt_xl: { type: 'string', default: '', },
			col_cnt_tablet: { type: 'string', default: '', },
			col_cnt_mobile: { type: 'string', default: '', },
			col_cnt_min: { type: 'string', default: '', },
			col_sp: { type: 'string', default: '', },
			slider_vertical_align: { type: 'string', default: '', },
			slider_horizontal_align: { type: 'string', default: '', },
			show_nav: { type: 'bool', default: false, },
			nav_hide: { type: 'bool', default: false, },
			nav_type: { type: 'string', default: 'simple', },
			nav_pos: { type: 'string', default: '', },
			show_dots: { type: 'bool', default: false, },
			dots_type: { type: 'string', default: '', },
			dots_pos: { type: 'string', default: '', },
			autoplay: { type: 'bool', default: false, },
			autoplay_timeout: { type: 'int', default: 5000, },
			loop: { type: 'bool', default: false, },
			pause_onhover: { type: 'bool', default: false, },
			autoheight: { type: 'bool', default: false, },
			item_sp: { type: 'int', default: 0, },
			post_type: { type: 'string', default: '', },
			show_info: { type: 'object', default: { date: true, author: true, category: true, comment: true, image: true, content: true, readmore: true } },
			overlay: { type: 'string', default: '', },
			show_datebox: { type: 'boolean', default: false, },
			content_align: { type: 'string', default: 'left' },
			excerpt_custom: { type: 'boolean', default: false },
			excerpt_type: { type: 'string', default: 'words' },
			excerpt_length: { type: 'int', default: 20 },
			read_more_label: { type: 'string', default: 'Read More' },
			read_more_custom: { type: 'boolean', default: false },
			button_skin: { type: 'string', default: 'btn-dark' },
			button_border: { type: 'string', default: '' },
			button_type: { type: 'string', default: '' },
			link_hover_type: { type: 'string', default: '' },
			button_size: { type: 'string', default: '' },
			icon: { type: 'string', default: '' },
			icon_pos: { type: 'string', default: 'after' },
			icon_size: { type: 'string', default: '' },
			icon_hover_effect: { type: 'string', default: '' },
			icon_hover_effect_infinite: { type: 'bool', default: false },
		},
		edit: wolmartComponents.WolmartPosts,
		save: function ( props ) {
			return el( InnerBlocks.Content );
		}
	} );

	// Register Wolmart Icon-Box Block
	registerBlockType( 'wolmart/wolmart-icon-box', {
		title: 'Wolmart Icon Box',
		icon: 'wolmart',
		category: 'wolmart',
		attributes: {
			type: { type: 'string', default: '' },
			h_align: { type: 'string', default: 'left' },
			v_align: { type: 'string', default: '' },
			content_align: { type: 'string', default: 'left' },
			pt: { type: 'int', default: 0 },
			pr: { type: 'int', default: 0 },
			pb: { type: 'int', default: 0 },
			pl: { type: 'int', default: 0 },
			mt: { type: 'int', default: 0 },
			mr: { type: 'int', default: 0 },
			mb: { type: 'int', default: 0 },
			ml: { type: 'int', default: 0 },
			icon_class: { type: 'string', default: 'fas fa-star' },
			icon_size: { type: 'int', default: 20 },
			icon_style: { type: 'string', default: '' },
			border_shape: { type: 'string', default: 'circle' },
			icon_pt: { type: 'int', default: 10 },
			icon_pr: { type: 'int', default: 10 },
			icon_pb: { type: 'int', default: 10 },
			icon_pl: { type: 'int', default: 10 },
			icon_mt: { type: 'int', default: 0 },
			icon_mr: { type: 'int', default: 10 },
			icon_mb: { type: 'int', default: 0 },
			icon_ml: { type: 'int', default: 0 },
			icon_col: { type: 'string', default: '#333' },
			icon_bg_col: { type: 'string', default: '' },
			heading: { type: 'string', default: 'This is Wolmart Icon Box' },
			head_size: { type: 'int', default: 16 },
			head_weight: { type: 'int', default: 700 },
			head_mt: { type: 'int', default: 0 },
			head_mr: { type: 'int', default: 0 },
			head_mb: { type: 'int', default: 0 },
			head_ml: { type: 'int', default: 0 },
			head_col: { type: 'string', default: '#333' },
			description: { type: 'string', default: 'Input your description here.' },
			desc_size: { type: 'int', default: 14 },
			desc_lh: { type: 'int', default: 1.4 },
			desc_mt: { type: 'int', default: 0 },
			desc_mr: { type: 'int', default: 0 },
			desc_mb: { type: 'int', default: 0 },
			desc_ml: { type: 'int', default: 0 },
			desc_col: { type: 'string', default: '#999' },
		},
		edit: wolmartComponents.WolmartIconBox,
		save: function ( props ) {
			return el( InnerBlocks.Content );
		}
	} );

	// Register Wolmart Heading Block
	registerBlockType( 'wolmart/wolmart-heading', {
		title: 'Wolmart Heading',
		icon: 'wolmart',
		category: 'wolmart',
		attributes: {
			content_align: { type: 'string', default: 'left' },
			text: { type: 'string', default: 'This is Wolmart Heading' },
			tag: { type: 'string', default: 'h2' },
			family: { type: 'string', default: '' },
			size: { type: 'int', default: 20 },
			weight: { type: 'int', default: 700 },
			ls: { type: 'string', default: '-0.01em' },
			lh: { type: 'string', default: '1' },
			transform: { type: 'string', default: 'none' },
			mt: { type: 'int', default: 0 },
			mr: { type: 'int', default: 0 },
			mb: { type: 'int', default: 0 },
			ml: { type: 'int', default: 0 },
			col: { type: 'string', default: '#333' },
			decoration: { type: 'string', default: '' },
			decor_space: { type: 'int', default: 30 },
			hide_active_underline: { type: 'bool', default: false },
			div_ht: { type: 'int', default: 2 },
			div_col: { type: 'string', default: '#f4f4f4' },
			div_active_col: { type: 'string', default: '#2b579a' },
		},
		edit: wolmartComponents.WolmartHeading,
		save: function ( props ) {
			return el( InnerBlocks.Content );
		}
	} );

	// Register Wolmart Button Block
	registerBlockType( 'wolmart/wolmart-button', {
		title: 'Wolmart Button',
		icon: 'wolmart',
		category: 'wolmart',
		attributes: {
			tab: { type: 'int', default: 1 },
			preset: { type: 'string', default: 'btn-primary' },
			shape: { type: 'string', default: '' },
			type: { type: 'string', default: '' },
			btn_size: { type: 'string', default: '' },
			icon_class: { type: 'string', default: '' },
			icon_pos: { type: 'string', default: 'left' },
			icon_hover_effect: { type: 'string', default: 'left' },
			icon_infinite: { type: 'bool', default: false },
			text: { type: 'string', default: 'Click Here' },
			link: { type: 'string', default: '#' },
			align: { type: 'string', default: 'left' },
			size: { type: 'int', default: 14 },
			icon_size: { type: 'int', default: 14 },
			icon_margin: { type: 'int', default: 5 },
			col: { type: 'string' },
			bg_col: { type: 'string' },
			bd_col: { type: 'string' },
			hover_col: { type: 'string' },
			hover_bg_col: { type: 'string' },
			hover_bd_col: { type: 'string' },
			pt: { type: 'int' },
			pr: { type: 'int' },
			pb: { type: 'int' },
			pl: { type: 'int' },
			border_radius: { type: 'int', default: '' },
		},
		edit: wolmartComponents.WolmartButton,
		save: function ( props ) {
			return el( InnerBlocks.Content );
		}
	} );
} )( wp.i18n, wp.blocks, wp.element, wp.blockEditor, wp.components, wp.data, lodash, wp.apiFetch );


// Defines Wolmart Component Classes
function componentClassInit ( wpI18n, wpElement, wpBlockEditor, wpComponents, apiFetch ) {
	var __ = wpI18n.__,
		InnerBlocks = wpBlockEditor.InnerBlocks,
		InspectorControls = wpBlockEditor.InspectorControls,
		el = wpElement.createElement,
		Component = wpElement.Component,
		TextControl = wpComponents.TextControl,
		TextareaControl = wpComponents.TextareaControl,
		SelectControl = wpComponents.SelectControl,
		CheckboxControl = wpComponents.CheckboxControl,
		RangeControl = wpComponents.RangeControl,
		PanelColorSettings = wpBlockEditor.PanelColorSettings,
		RichText = wpBlockEditor.RichText,
		PlainText = wpBlockEditor.PlainText,
		PanelBody = wpComponents.PanelBody,
		ButtonGroup = wpComponents.ButtonGroup,
		Button = wpComponents.Button,
		MediaUpload = wpBlockEditor.MediaUpload,
		IconButton = wpComponents.IconButton,
		ToggleControl = wpComponents.ToggleControl;

	// Common Slider Options
	var sliderStyleOptions = function ( attrs, props ) {
		return el( PanelBody, {
			title: __( 'Slider Style' ),
			initialOpen: false,
		},
			el( ToggleControl, {
				label: __( 'Nav' ),
				checked: attrs.show_nav,
				onChange: ( value ) => { props.setAttributes( { show_nav: value } ); },
			} ),
			el( ToggleControl, {
				label: __( 'Nav Auto Hide' ),
				checked: attrs.nav_hide,
				onChange: ( value ) => { props.setAttributes( { nav_hide: value } ); },
			} ),
			el( SelectControl, {
				label: __( 'Nav Type' ),
				options: [{ label: __( 'Simple' ), value: 'simple' }, { label: __( 'Circle' ), value: 'circle' }, { label: __( 'Full' ), value: 'full' }],
				value: attrs.nav_type,
				onChange: ( value ) => { props.setAttributes( { nav_type: value } ); },
			} ),
			el( SelectControl, {
				label: __( 'Nav Position' ),
				options: [{ label: __( 'Inner' ), value: 'inner' }, { label: __( 'Outer' ), value: '' }, { label: __( 'Top' ), value: 'top' },],
				value: attrs.nav_pos,
				onChange: ( value ) => { props.setAttributes( { nav_pos: value } ); },
			} ),
			el( ToggleControl, {
				label: __( 'Dots' ),
				checked: attrs.show_dots,
				onChange: ( value ) => { props.setAttributes( { show_dots: value } ); },
			} ),
			el( SelectControl, {
				label: __( 'Dots Type' ),
				checked: attrs.dots_type,
				options: [{ label: __( 'Default' ), value: 'default' }, { label: __( 'White' ), value: 'white' }, { label: __( 'Grey' ), value: 'grey' }, { label: __( 'Dark' ), value: 'dark' }],
				onChange: ( value ) => { props.setAttributes( { dots_type: value } ); },
			} ),
			el( SelectControl, {
				label: __( 'Dots Position' ),
				options: [{ label: __( 'Inner' ), value: 'inner' }, { label: __( 'Outer' ), value: '' }],
				value: attrs.dots_pos,
				onChange: ( value ) => { props.setAttributes( { dots_pos: value } ); },
			} ),
			el( ToggleControl, {
				label: __( 'Autoplay' ),
				checked: attrs.autoplay,
				onChange: ( value ) => { props.setAttributes( { autoplay: value } ); },
			} ),
			el( TextControl, {
				label: __( 'Autoplay Timeout' ),
				value: attrs.autoplay_timeout,
				onChange: ( value ) => { props.setAttributes( { autoplay_timeout: value } ); },
			} ),
			el( ToggleControl, {
				label: __( 'Infinite Loop' ),
				checked: attrs.loop,
				onChange: ( value ) => { props.setAttributes( { loop: value } ); },
			} ),
			el( ToggleControl, {
				label: __( 'Pause on Hover' ),
				checked: attrs.pause_onhover,
				onChange: ( value ) => { props.setAttributes( { pause_onhover: value } ); },
			} ),
			el( ToggleControl, {
				label: __( 'Auto Height' ),
				checked: attrs.autoheight,
				onChange: ( value ) => { props.setAttributes( { autoheight: value } ); },
			} ),
		);
	}

	wolmartComponents.WolmartSlider = class WolmartSlider extends Component {
		constructor () {
			super( ...arguments );
		}

		componentDidMount () {
			var attrs = this.props.attributes,
				$selector = jQuery( '#block-' + this.props.clientId + ' .slider-wrapper>div>.block-editor-block-list__layout' );

			$selector.addClass( 'cols-' + attrs.col_cnt )
				.css( 'margin-left', -attrs.item_sp / 2 )
				.css( 'margin-right', -attrs.item_sp / 2 );
			$selector.children().css( 'margin-left', 0 ).css( 'margin-right', 0 )
				.css( 'padding-left', attrs.item_sp / 2 )
				.css( 'padding-right', attrs.item_sp / 2 );
		}

		componentDidUpdate ( prevProps, prevState ) {
			var attrs = this.props.attributes,
				$selector = jQuery( '#block-' + this.props.clientId + ' .slider-wrapper>div>.block-editor-block-list__layout' );

			$selector.attr( 'class', $selector.attr( 'class' ).replace( / cols-.*[0-9]/, '' ) );
			$selector.addClass( 'cols-' + attrs.col_cnt )
				.css( 'margin-left', -attrs.item_sp / 2 )
				.css( 'margin-right', -attrs.item_sp / 2 );
			$selector.children().css( 'margin-left', 0 )
				.css( 'margin-right', 0 )
				.css( 'padding-left', attrs.item_sp / 2 )
				.css( 'padding-right', attrs.item_sp / 2 );
		}

		render () {
			var props = this.props,
				attrs = props.attributes;

			var inspectorControls = el( InspectorControls, {},
				el( PanelBody, {
					title: __( 'Slider Options' ),
					initialOpen: true,
				},
					el( SelectControl, {
						label: __( 'Item count' ),
						value: attrs.col_cnt,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count(>=1200px)' ),
						value: attrs.col_cnt_xl,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_xl: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count(<576px)' ),
						value: attrs.col_cnt_min,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_min: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item Gap' ),
						options: [{ label: __( 'No Space' ), value: 'no' }, { label: __( 'Extremely Small' ), value: 'xs' }, { label: __( 'Small' ), value: 'sm' }, { label: __( 'Medium' ), value: '' }, { label: __( 'Large' ), value: 'lg' },],
						value: attrs.col_sp,
						onChange: ( value ) => { props.setAttributes( { col_sp: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Vertical Align' ),
						options: [{ label: __( 'Top' ), value: 'top' }, { label: __( 'Middle' ), value: 'middle' }, { label: __( 'Bottom' ), value: 'bottom' }, { label: __( 'Stretch' ), value: 'stretch' },],
						value: attrs.slider_vertical_align,
						onChange: ( value ) => { props.setAttributes( { slider_vertical_align: value } ); },
					} ),
				),
				sliderStyleOptions( attrs, props ),
			);

			let extra_class = '',
				extra_attr = '',
				extra_options = {},
				nav = attrs.nav_type.split( ' ' ),
				nav_pos = attrs.nav_pos.split( ' ' );

			extra_class += 'slider-wrapper cols-' + Number( attrs.col_cnt );

			if ( '1' === nav_pos[0] ) {
				extra_class += ' inner-nav';
			}
			if ( '1' === nav_pos[1] ) {
				extra_class += ' inner-dots';
			}

			extra_options["nav"] = '1' === nav[0];
			extra_options["dots"] = '1' === nav[1];
			extra_options["items"] = Math.max( Number( attrs.col_cnt ), 1 );
			extra_options["margin"] = Number( attrs.item_sp );
			extra_options["autoHeight"] = true;
			extra_options["responsive"] = {};
			extra_attr = JSON.stringify( extra_options );

			var renderControls = el(
				'div',
				{ className: extra_class, 'data-slider-options': extra_attr },
				el( InnerBlocks ),
			);

			return [
				inspectorControls,
				renderControls,
			];
		}
	};

	wolmartComponents.WolmartBanner = class WolmartBanner extends Component {
		constructor () {
			super( ...arguments );
		}

		componentDidMount () { }

		componentDidUpdate ( prevProps, prevState ) { }

		render () {
			var props = this.props,
				attrs = props.attributes;

			var inspectorControls = el( InspectorControls, {},
				el( PanelBody, {
					title: __( 'Banner Options' ),
					initialOpen: false,
				},
					el( 'div',
						{ className: 'dimension' },
						el(
							'h4',
							{},
							__( 'Padding' ),
						),
						el( 'div',
							{ className: 'options' },
							el( TextControl, {
								label: __( 'Top' ),
								value: attrs.pt,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pt: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Right' ),
								value: attrs.pr,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pr: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Bottom' ),
								value: attrs.pb,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pb: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Left' ),
								value: attrs.pl,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pl: value } ); },
							} ),
						),
					),
					el( 'div',
						{ className: 'dimension' },
						el(
							'h4',
							{},
							__( 'Margin' ),
						),
						el( 'div',
							{ className: 'options' },
							el( TextControl, {
								label: __( 'Top' ),
								value: attrs.mt,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { mt: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Right' ),
								value: attrs.mr,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { mr: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Bottom' ),
								value: attrs.mb,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { mb: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Left' ),
								value: attrs.ml,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { ml: value } ); },
							} ),
						),
					),
					el( PanelColorSettings, {
						title: __( 'Background Settings' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Background Color' ),
							value: attrs.bg_col,
							onChange: ( value ) => { props.setAttributes( { bg_col: value } ); },
						}]
					} ),
					el( MediaUpload, {
						allowedTypes: ['image'],
						value: attrs.bg_image,
						onSelect: function onSelect ( image ) {
							return props.setAttributes( { bg_image_url: image.url, bg_image: image.id } );
						},
						render: function render ( _ref ) {
							var open = _ref.open;
							return el( IconButton, {
								className: 'components-toolbar__control',
								label: __( 'Banner Image' ),
								icon: 'edit',
								onClick: open
							} );
						}
					} ),
					el( IconButton, {
						className: 'components-toolbar__control',
						label: __( 'Remove image' ),
						icon: 'no',
						onClick: function onClick () {
							return props.setAttributes( { bg_image_url: '', bg_image: undefined } );
						}
					} ),
					el( ToggleControl, {
						label: __( 'Fixed Image Banner' ),
						checked: attrs.fixed_banner,
						onChange: ( value ) => { props.setAttributes( { fixed_banner: value } ); },
					} ),
					attrs.fixed_banner && el( SelectControl, {
						label: __( 'Wrap with' ),
						options: [{ label: __( 'None' ), value: '' }, { label: __( 'Container' ), value: 'container' }, { label: __( 'Container fluid' ), value: 'container-fluid' }],
						value: attrs.wrap_class,
						onChange: ( value ) => { props.setAttributes( { wrap_class: value } ); },
					} ),
					!attrs.fixed_banner && el( ToggleControl, {
						label: __( 'Use Container Width Content' ),
						checked: attrs.container_width,
						onChange: ( value ) => { props.setAttributes( { container_width: value } ); },
					} ),
					!attrs.fixed_banner && el( ToggleControl, {
						label: __( 'Enable Parallax' ),
						checked: attrs.parallax,
						onChange: ( value ) => { props.setAttributes( { parallax: value } ); },
					} ),
					( !attrs.fixed_banner && attrs.parallax ) && el( RangeControl, {
						label: __( 'Parallax Speed' ),
						value: attrs.par_speed,
						min: 0,
						max: 10,
						step: 1,
						onChange: ( value ) => { props.setAttributes( { par_speed: value } ); },
					} ),
					( !attrs.fixed_banner && attrs.parallax ) && el( RangeControl, {
						label: __( 'Parallax Offset' ),
						value: attrs.par_offset,
						min: -300,
						max: 300,
						step: 1,
						onChange: ( value ) => { props.setAttributes( { par_offset: value } ); },
					} ),
					( !attrs.fixed_banner && attrs.parallax ) && el( RangeControl, {
						label: __( 'Parallax Height(%)' ),
						value: attrs.par_height,
						min: 100,
						max: 300,
						step: 1,
						onChange: ( value ) => { props.setAttributes( { par_height: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Align' ),
						options: [{ label: __( 'Left' ), value: 'left' }, { label: __( 'Center' ), value: 'center' }, { label: __( 'Right' ), value: 'right' }],
						value: attrs.content_align,
						onChange: ( value ) => { props.setAttributes( { content_align: value } ); },
					} ),
				),
				attrs.fixed_banner && el( PanelBody, {
					title: __( 'Banner Content Position' ),
					initialOpen: true,
				},
					el( 'p',
						{},
						'X-Base'
					),
					el(
						ButtonGroup,
						{ className: "button_tabs" },
						el( 'button', {
							className: 'left' === attrs.x_base ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { x_base: 'left' } );
							},
						}, __( 'Left' ) ),
						el( 'button', {
							className: 'center' === attrs.x_base ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { x_base: 'center' } );
							},
						}, __( 'Center' ) ),
						el( 'button', {
							className: 'right' === attrs.x_base ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { x_base: 'right' } );
							},
						}, __( 'Right' ) ),
					),
					el( 'p',
						{},
						'Y-Base'
					),
					el(
						ButtonGroup,
						{ className: "button_tabs" },
						el( 'button', {
							className: 'top' === attrs.y_base ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { y_base: 'top' } );
							},
						}, __( 'Top' ) ),
						el( 'button', {
							className: 'middle' === attrs.y_base ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { y_base: 'middle' } );
							},
						}, __( 'Middle' ) ),
						el( 'button', {
							className: 'bottom' === attrs.y_base ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { y_base: 'bottom' } );
							},
						}, __( 'Bottom' ) ),
					),
					'center' !== attrs.x_base && el( RangeControl, {
						label: __( 'X-Pos (%)' ),
						value: attrs.x_pos,
						min: 0,
						max: 100,
						step: 1,
						onChange: ( value ) => { props.setAttributes( { x_pos: value } ); },
					} ),
					'middle' !== attrs.y_base && el( RangeControl, {
						label: __( 'Y-Pos (%)' ),
						value: attrs.y_pos,
						min: 0,
						max: 100,
						step: 1,
						onChange: ( value ) => { props.setAttributes( { y_pos: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Content Width (%)' ),
						type: 'number',
						value: attrs.content_width,
						onChange: ( value ) => { props.setAttributes( { content_width: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Min Height (px)' ),
						type: 'number',
						value: attrs.min_height,
						onChange: ( value ) => { props.setAttributes( { min_height: value } ); },
					} ),
				),
			);

			let banner_class = 'banner',
				banner_style = '',
				content_class = 'banner-content',
				content_style = '';

			if ( attrs.fixed_banner ) {
				banner_class += ' banner-fixed';
			}

			if ( attrs.parallax ) {
				banner_class += ' parallax';
			}

			banner_style += 'margin-top: ' + attrs.mt + 'px; margin-right: ' + attrs.mr + 'px; margin-bottom: ' + attrs.mb + 'px; margin-left: ' + attrs.ml + 'px;';
			banner_style += 'padding-top: ' + attrs.pt + 'px; padding-right: ' + attrs.pr + 'px; padding-bottom: ' + attrs.pb + 'px; padding-left: ' + attrs.pl + 'px;';
			banner_style += 'background-color: ' + attrs.bg_col + ';';
			if ( !attrs.fixed_banner ) {
				if ( attrs.container_width ) {
					content_class = 'container ' + content_class;
				}
				banner_style += 'background-image: url("' + attrs.bg_image_url + '");';
			} else {
				if ( 'center' === attrs.x_base ) {
					content_style += 'left: 50%;';
					content_style += 'transform: translateX(-50%);';
				} else {
					content_style += attrs.x_base + ': ' + attrs.x_pos + '%;';
				}
				if ( 'middle' === attrs.y_base ) {
					content_style += 'top: 50%;';
					content_style += 'transform: translateY(-50%);';
				} else {
					content_style += attrs.y_base + ': ' + attrs.y_pos + '%;';
				}
				if ( 'center' === attrs.x_base && 'middle' === attrs.y_base ) {
					content_style += 'transform: translate(-50%, -50%);';
				}
				if ( attrs.content_width ) {
					content_style += 'width: ' + attrs.content_width + '%;';
				}
			}
			content_style += 'text-align: ' + attrs.content_align + ';';

			var renderControls = el(
				'div',
				{ className: banner_class, style: banner_style, 'data-parallax-options': '{offset: ' + attrs.par_offset + ', speed: ' + attrs.par_speed + ', height: ' + attrs.par_height + '% }' },
				attrs.fixed_banner && el(
					'figure',
					{},
					el(
						'img',
						{ src: attrs.bg_image_url, style: { minHeight: attrs.min_height + 'px', display: 'block', 'object-fit': 'cover' }, }
					),
				),
				( attrs.fixed_banner && attrs.wrap_class ) && el(
					'div',
					{ className: attrs.wrap_class },
					el(
						'div',
						{ className: content_class, style: content_style },
						el( InnerBlocks ),
					),
				),
				( !attrs.fixed_banner || !attrs.wrap_class ) && el(
					'div',
					{ className: content_class, style: content_style },
					el( InnerBlocks ),
				),
			)

			return [
				inspectorControls,
				renderControls,
			];
		}
	};

	wolmartComponents.WolmartProducts = class WolmartProducts extends Component {

		constructor () {
			super( ...arguments );

			this.state = {
				products: [],
				query: '',
			};
		}

		componentDidMount () {
			var _this = this;
			wp.apiFetch( { path: '/wc/v2/products/categories' } ).then( function ( cats ) {

				_this.props.attributes.category_list.map( function ( cat, idx ) {
					if ( -1 === cats.findIndex( obj => obj.id === cat.id ) ) {
						_this.props.attributes.category_list.splice( idx, 1 );
					}
				} );
				cats.map( function ( cat ) {
					if ( -1 === _this.props.attributes.category_list.findIndex( obj => obj.id === cat.id ) ) {
						cat['checked'] = false;
						_this.props.attributes.category_list.push( cat );
					}
				} );
			} );

			_this.fetchProducts();
		}

		componentDidUpdate ( prevProps, prevState ) {
			var attrs = this.props.attributes,
				state = this.state,
				prevAttrs = prevProps.attributes,
				$selector = jQuery( '#block-' + this.props.clientId + ' .products' );
			//Wolmart = window.Wolmart;

			if ( attrs !== prevAttrs || state !== prevState ) {
				productManage( $selector );
			}

			if ( this.getQuery() !== this.state.query ) {
				if ( $selector.data( 'slider' ) ) {
					$selector.data( 'slider' ).destroy();
					$selector.removeData( 'slider' );
				}
				if ( $selector.data( 'isotope' ) ) {
					$selector.isotope( 'destroy' );
				}
				this.fetchProducts();
			}

			if ( 'grid' === attrs.layout_type ) {
				if ( attrs.layout_type !== prevAttrs.layout_type ) {
					if ( $selector.data( 'slider' ) ) {
						$selector.data( 'slider' ).destroy();
						$selector.removeData( 'slider' );
					}
				}
			} else {
				if ( state.products !== prevState.products ||
					attrs.layout_type !== prevAttrs.layout_type ||
					isSliderChanged( attrs, prevAttrs ) ) {
					if ( $selector.data( 'slider' ) ) {
						$selector.data( 'slider' ).destroy();
						$selector.removeData( 'slider' );
					}
					initSlider( $selector );
				}
			}
		}

		render () {
			var _this = this,
				props = this.props,
				attrs = props.attributes;

			var inspectorControls = el( InspectorControls, {},
				el( PanelBody, {
					title: __( 'Products Selector' ),
					initialOpen: false,
				},
					el( SelectControl, {
						label: __( 'Product Status' ),
						options: [{ label: __( 'All' ), value: '' }, { label: __( 'Featured' ), value: 'featured' }, { label: __( 'On Sale' ), value: 'on_sale' }],
						value: attrs.status,
						onChange: ( value ) => { props.setAttributes( { status: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Category' ),
						value: attrs.category_type,
						options: [{ label: __( 'All' ), value: '' }, { label: __( 'Selected' ), value: 'selected' }],
						onChange: ( value ) => { props.setAttributes( { category_type: value } ); },
					} ),
					attrs.category_type === 'selected' && el(
						'div',
						{ className: 'checkbox-list category-list' },
						attrs.category_list.map( function ( cat, index ) {
							return el( CheckboxControl, {
								key: index,
								label: [cat.name, el(
									'span',
									{ key: 'cat-count', style: { fontSize: 'small', color: '#888', marginLeft: 5 } },
									'(',
									cat.count,
									')'
								)],
								checked: cat.checked,
								onChange: ( checked ) => {
									var arr = attrs.category_list.concat();
									arr[index].checked = checked;
									props.setAttributes( { category_list: arr } );
								},
							} );
						} )
					),
					el( RangeControl, {
						label: __( 'Product Count' ),
						value: attrs.count,
						min: 1,
						max: 100,
						step: 1,
						onChange: ( value ) => { props.setAttributes( { count: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Order By' ),
						options: [
							{ value: 'id', label: __( 'ID' ) },
							{ value: 'title', label: __( 'Name' ) },
							{ value: 'date', label: __( 'Date' ) },
							{ value: 'price', label: __( 'Price' ) },
							{ value: 'rating', label: __( 'Rating' ) },
							{ value: 'modified', label: __( 'Modified' ) },
						],
						value: attrs.orderby,
						onChange: ( value ) => { props.setAttributes( { orderby: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Order Way' ),
						options: [
							{ value: 'desc', label: __( 'Descending' ) },
							{ value: 'asc', label: __( 'Ascending' ) },
						],
						value: attrs.orderway,
						onChange: ( value ) => { props.setAttributes( { orderway: value } ); },
					} ),
				),
				el( PanelBody, {
					title: __( 'Products Layout' ),
					initialOpen: false,
				},
					el( SelectControl, {
						label: __( 'Layout Type' ),
						options: [
							{ value: 'grid', label: __( 'Grid' ) },
							{ value: 'slider', label: __( 'Slider' ) },
						],
						value: attrs.layout_type,
						onChange: ( value ) => { props.setAttributes( { layout_type: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count' ),
						value: attrs.col_cnt,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count(>=1200px)' ),
						value: attrs.col_cnt_xl,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_xl: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count(>=768px)' ),
						value: attrs.col_cnt_tablet,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_tablet: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count(>=576px)' ),
						value: attrs.col_cnt_mobile,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_mobile: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count(<576px)' ),
						value: attrs.col_cnt_min,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_min: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item Gap' ),
						options: [{ label: __( 'No Space' ), value: 'no' }, { label: __( 'Extremely Small' ), value: 'xs' }, { label: __( 'Small' ), value: 'sm' }, { label: __( 'Medium' ), value: '' }, { label: __( 'Large' ), value: 'lg' },],
						value: attrs.col_sp,
						onChange: ( value ) => { props.setAttributes( { col_sp: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Vertical Align' ),
						options: [{ label: __( 'Top' ), value: 'top' }, { label: __( 'Middle' ), value: 'middle' }, { label: __( 'Bottom' ), value: 'bottom' }, { label: __( 'Stretch' ), value: 'stretch' },],
						value: attrs.slider_vertical_align,
						onChange: ( value ) => { props.setAttributes( { slider_vertical_align: value } ); },
					} ),
				),
				'slider' === attrs.layout_type && sliderStyleOptions( attrs, props ),
				el( PanelBody, {
					title: __( 'Product Conformation' ),
					initialOpen: false,
				},
					el( SelectControl, {
						label: __( 'Product Type' ),
						options: [{ value: '', label: __( 'Default' ) }, { value: 'classic', label: __( 'Classic' ) }, { value: 'list', label: __( 'List' ) }, { value: 'widget', label: __( 'Widget' ) }],
						value: attrs.product_type,
						onChange: ( value ) => { props.setAttributes( { product_type: value } ); },
					} ),
					'classic' === attrs.product_type && el( SelectControl, {
						label: __( 'Hover Effect' ),
						options: [{ value: '', label: __( 'Default' ) }, { value: 'popup', label: __( 'Popup' ) }, { value: 'slideup', label: __( 'Slide Up' ) }],
						value: attrs.classic_hover,
						onChange: ( value ) => { props.setAttributes( { classic_hover: value } ); },
					} ),
					el( ToggleControl, {
						label: __( 'Show In Box' ),
						checked: attrs.show_in_box,
						onChange: ( value ) => { props.setAttributes( { show_in_box: value } ); },
					} ),
					el( ToggleControl, {
						label: __( 'Media Shadow Effect' ),
						checked: attrs.show_media_shadow,
						onChange: ( value ) => { props.setAttributes( { show_media_shadow: value } ); },
					} ),
				),
			);

			return [
				inspectorControls,

				el(
					'div',
					{ className: 'product-tab' },
					'grid' === attrs.layout_type && attrs.filter_cat && el(
						'ul',
						{ className: 'tabs' },
						el(
							'li',
							{ className: 'nav-item' },
							el(
								'a',
								{ className: 'tab-link', 'data-cat_id': '*' },
								'All',
							),
						),
						attrs.category_list.map( function ( cat, index ) {
							if ( cat.name === 'Uncategorized' )
								return;

							if ( attrs.category_type && !cat.checked ) {
								return;
							}

							return el(
								'li',
								{ className: 'nav-item' },
								el(
									'a',
									{ className: 'tab-link', 'data-cat_id': '.' + cat.name },
									cat.name,
								),
							);
						} ),
					),
					el(
						'ul',
						_this.getWrapperAttrs(),
						_this.state.products.map( function ( product ) {
							return _this.createProductElement( product );
						} ),
						'grid' === attrs.layout_type && attrs.filter_cat && el(
							'div',
							{ className: 'grid-space' },
						)
					)
				),
			];
		}

		getQuery () {
			var attrs = this.props.attributes,
				query_string = '?';
			let cat_flag = 0;

			if ( attrs.status ) {
				query_string += attrs.status + '=1';
			}

			if ( 'selected' === attrs.category_type ) {
				attrs.category_list.map( function ( cat ) {
					if ( cat.checked ) {
						query_string += ( cat_flag ? ',' : '&category=' ) + cat.id;
						cat_flag = 1;
					}
				} );
			}

			query_string += '&per_page=' + ( attrs.count ? attrs.count : 100 );
			query_string += '&orderby=' + attrs.orderby;
			query_string += '&order=' + attrs.orderway;

			var endpoint = '/wolmartrest/wcrest/products' + query_string;
			return endpoint;
		}

		fetchProducts () {
			var _this = this,
				query = this.getQuery();

			this.setState( {
				query: query,
			} )

			apiFetch( { path: query } ).then( function ( products ) {
				_this.setState( {
					products: products,
				} );
			} );
		}

		getWrapperAttrs () {
			let out_attrs = {},
				attrs = this.props.attributes,
				col_cnt = getResponsiveCols( {
					xl: attrs.col_cnt_xl,
					lg: attrs.col_cnt,
					md: attrs.col_cnt_tablet,
					sm: attrs.col_cnt_mobile,
					min: attrs.col_cnt_min,
				} );

			out_attrs['className'] = 'products' + getColClass( col_cnt );

			if ( 'lg' === attrs.col_sp || 'xs' === attrs.col_sp || 'sm' === attrs.col_sp || 'no' === attrs.col_sp ) {
				out_attrs['className'] += ' gutter-' + attrs.col_sp;
			}

			if ( 'grid' === attrs.layout_type ) {
			} else if ( 'slider' === attrs.layout_type ) {
				let extra_options = {};

				out_attrs['className'] += getSliderClass( attrs );

				extra_options = getSliderOptions( attrs );

				out_attrs['data-plugin-options'] = JSON.stringify( extra_options );
			}

			return out_attrs;
		}

		createProductElement ( product ) {
			var cats = [],
				p_wrapper = ['product-wrap'],
				p_class = ['product'],
				attrs = this.props.attributes,
				p_rating;

			p_rating = '<div class="star-rating" role="img" aria-label="Rated ' + product.average_rating + ' out of 5"><span style="width:' + product.average_rating * 100 / 5 + '%">Rated <strong class="rating">' + product.average_rating + '</strong> out of 5</span></div><a href="' + product.permalink + '/#reviews" class="woocommerce-review-link" rel="nofollow">( 0 reviews )</a></div>'

			product.categories.map( function ( category ) {
				cats.push( category.name );
			} );

			if ( 'grid' === attrs.layout_type && attrs.filter_cat ) {
				p_wrapper.push( 'grid-item' );
			}

			// - content align
			p_class.push( 'content-' + attrs.content_align );
			// - show in box
			if ( true === attrs.show_in_box ) {
				p_class.push( 'product-boxed' );
			}
			// - show media shadow
			if ( true === attrs.show_media_shadow ) {
				p_class.push( 'shadow-media' );
			}
			// - classic
			if ( 'classic' === attrs.product_type ) {
				p_class.push( 'product-classic' );

				if ( 'popup' === attrs.classic_hover ) {
					p_class.push( 'product-popup' );
				}

				if ( 'slideup' === attrs.classic_hover ) {
					p_class.push( 'product-slideup' );
				}
			} else if ( 'list' === attrs.product_type ) {
				p_class.push( 'product-list product-classic' );

			} else if ( 'widget' === attrs.product_type ) {
				p_class.push( 'product-list-sm' );
			}

			return el(
				'li',
				{ className: p_wrapper.concat( cats ).join( ' ' ) },
				el(
					'div',
					{ className: p_class.join( ' ' ) },
					el(
						'figure',
						{ className: 'product-media' },
						el(
							'a',
							{ href: '#' },
							el(
								'img',
								{ src: product.images.length ? product.images[0].src : wolmart_gutenberg_vars.placeholder_img },
							),
							2 <= product.images.length && el(
								'img',
								{ src: product.images[1].src },
							),
						),
						'' === attrs.product_type && el(
							'div',
							{ className: 'product-action-vertical' },
							'' === attrs.addtocart_pos && el(
								'a',
								{ className: 'btn-product-icon add_to_cart_button' },
							),
							'' === attrs.wishlist_pos && el(
								'div',
								{ className: 'btn-product-icon yith-wcwl-add-to-wishlist' },
								el(
									'a',
									{}
								),
							),
							'' === attrs.quickview_pos && el(
								'a',
								{ className: 'btn-product-icon btn-quickview' },
								__( 'Quickview' ),
							),
						),
						'' === attrs.product_type && el(
							'div',
							{ className: 'product-action' },
							'bottom' === attrs.quickview_pos && el(
								'a',
								{ className: 'btn-product btn-quickview' },
								__( 'Quickview' ),
							)
						),
					),
					el(
						'div',
						{ className: 'product-details' },
						'widget' !== attrs.product_type && el(
							'div',
							{ className: 'product-cat' },
							cats.join( ', ' ),
						),
						'bottom' === attrs.wishlist_pos && el(
							'div',
							{ className: 'btn-product-icon yith-wcwl-add-to-wishlist' },
							el(
								'a',
								{}
							),
						),
						el(
							'h3',
							{ className: 'woocommerce-loop-product__title' },
							product.name,
						),
						el(
							'span',
							{ className: 'price', dangerouslySetInnerHTML: { __html: product.price_html } },
						),
						'popup' !== attrs.classic_hover && el(
							'div',
							{ className: 'woocommerce-product-rating', dangerouslySetInnerHTML: { __html: p_rating } },
						),
						'list' === attrs.product_type && el(
							'div',
							{ className: 'short-desc', dangerouslySetInnerHTML: { __html: product.short_description } },
						),
						'popup' !== attrs.classic_hover && ( 'classic' === attrs.product_type || 'list' === attrs.product_type ) && el(
							'div',
							{ className: 'product-action' },
							'left' !== attrs.content_align && el(
								'div',
								{ className: 'btn-product-icon yith-wcwl-add-to-wishlist' },
								el(
									'a',
									{}
								),
							),
							'right' === attrs.content_align && el(
								'a',
								{ className: 'btn-product-icon btn-quickview' },
								__( 'Quickview' ),
							),
							el(
								'a',
								{ className: 'btn-product add_to_cart_button' },
								'Add to Cart'
							),
							'left' === attrs.content_align && el(
								'div',
								{ className: 'btn-product-icon yith-wcwl-add-to-wishlist' },
								el(
									'a',
									{}
								),
							),
							'right' !== attrs.content_align && el(
								'a',
								{ className: 'btn-product-icon btn-quickview' },
								__( 'Quickview' ),
							),
						),
					),
					'popup' === attrs.classic_hover && 'classic' === attrs.product_type && el(
						'div',
						{ className: 'product-hide-details' },
						el(
							'div',
							{ className: 'woocommerce-product-rating', dangerouslySetInnerHTML: { __html: p_rating } },
						),
						'list' === attrs.product_type && el(
							'div',
							{ className: 'short-desc', dangerouslySetInnerHTML: { __html: product.short_description } },
						),
						( 'classic' === attrs.product_type || 'list' === attrs.product_type ) && el(
							'div',
							{ className: 'product-action' },
							'left' !== attrs.content_align && el(
								'div',
								{ className: 'btn-product-icon yith-wcwl-add-to-wishlist' },
								el(
									'a',
									{}
								),
							),
							'right' === attrs.content_align && el(
								'a',
								{ className: 'btn-product-icon btn-quickview' },
								__( 'Quickview' ),
							),
							el(
								'a',
								{ className: 'btn-product add_to_cart_button' },
								'Add to Cart'
							),
							'left' === attrs.content_align && el(
								'div',
								{ className: 'btn-product-icon yith-wcwl-add-to-wishlist' },
								el(
									'a',
									{}
								),
							),
							'right' !== attrs.content_align && el(
								'a',
								{ className: 'btn-product-icon btn-quickview' },
								__( 'Quickview' ),
							),
						),
					),
				),
			);
		}
	};

	wolmartComponents.WolmartCategories = class WolmartCategories extends Component {

		constructor () {
			super( ...arguments );

			this.creative_layout = [];

			this.state = {
				categories: [],
				query: '',
			};
		}

		componentDidMount () {
			var _this = this;

			if ( 'creative' === this.props.attributes.layout_type ) {
				this.creative_layout = wolmart_creative_layout( this.props.attributes.creative_mode );
				this.props.setAttributes( { count: this.creative_layout.length } );
			}

			wp.apiFetch( { path: '/wc/v3/products/categories' } ).then( function ( cats ) {
				_this.props.attributes.category_list.map( function ( cat, idx ) {
					if ( -1 === cats.findIndex( obj => obj.id === cat.id ) ) {
						_this.props.attributes.category_list.splice( idx, 1 );
					}
				} );
				cats.map( function ( cat ) {
					if ( -1 === _this.props.attributes.category_list.findIndex( obj => obj.id === cat.id ) ) {
						cat['checked'] = false;
						_this.props.attributes.category_list.push( cat );
					}
				} );
			} );

			this.fetchCategories();
		}

		componentDidUpdate ( prevProps, prevState ) {
			var attrs = this.props.attributes,
				state = this.state,
				prevAttrs = prevProps.attributes,
				$selector = jQuery( '#block-' + this.props.clientId + ' .products' );

			if ( state.query !== this.getQuery() ) {
				if ( $selector.data( 'slider' ) ) {
					$selector.data( 'slider' ).destroy();
					$selector.removeData( 'slider' );
				}
				if ( $selector.data( 'isotope' ) ) {
					$selector.isotope( 'destroy' );
				}
				this.fetchCategories();
			}

			if ( 'grid' === attrs.layout_type ) {
				if ( 'slider' === prevAttrs.layout_type ) {
					if ( $selector.data( 'slider' ) ) {
						$selector.data( 'slider' ).destroy();
						$selector.removeData( 'slider' );
					}
				}

				if ( 'creative' === prevAttrs.layout_type || $selector.data( 'isotope' ) ) {
					$selector.isotope( 'destroy' );
				}
			} else if ( 'slider' === attrs.layout_type ) {
				if ( 'creative' === prevAttrs.layout_type || $selector.data( 'isotope' ) ) {
					$selector.isotope( 'destroy' );
				}

				// if props related to slider, init slider again,
				if ( state.categories !== prevState.categories ||
					attrs.layout_type !== prevAttrs.layout_type ||
					isSliderChanged( attrs, prevAttrs ) ) {
					if ( $selector.data( 'slider' ) ) {
						$selector.data( 'slider' ).destroy();
						$selector.removeData( 'slider' );
					}
					initSlider( $selector );
				}
			} else if ( 'creative' === attrs.layout_type ) {
				if ( 'slider' === prevAttrs.layout_type ) {
					if ( $selector.data( 'slider' ) ) {
						$selector.data( 'slider' ).destroy();
						$selector.removeData( 'slider' );
					}
				}

				if ( state.categories !== prevState.categories ||
					attrs.layout_type !== prevAttrs.layout_type ||
					attrs.creative_layout !== prevAttrs.creative_layout ||
					attrs.creative_height !== prevAttrs.creative_height ||
					attrs.col_sp !== prevAttrs.col_sp ) {
					if ( $selector.data( 'isotope' ) ) {
						$selector.isotope( 'destroy' );
					}
					initIsotopes( $selector );
				}
			}
		}

		render () {
			var _this = this,
				props = this.props,
				attrs = props.attributes;

			var inspectorControls = el( InspectorControls, {},
				el( PanelBody, {
					title: __( 'Categories Selector' ),
					initialOpen: false,
				},
					el( RangeControl, {
						label: __( 'Category Count' ),
						value: attrs.count,
						min: 1,
						max: 20,
						step: 1,
						onChange: ( value ) => { props.setAttributes( { count: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Category' ),
						value: attrs.category,
						options: [{ label: __( 'All' ), value: '' }, { label: __( 'Selected' ), value: 'selected' }],
						onChange: ( value ) => { props.setAttributes( { category: value } ); },
					} ),
					attrs.category === 'selected' && el(
						'div',
						{ className: 'checkbox-list category-list' },
						attrs.category_list.map( function ( cat, index ) {
							return el( CheckboxControl, {
								key: index,
								label: [cat.name, el(
									'span',
									{ key: 'cat-count', style: { fontSize: 'small', color: '#888', marginLeft: 5 } },
									'(',
									cat.count,
									')'
								)],
								checked: cat.checked,
								onChange: ( checked ) => {
									var arr = attrs.category_list.concat();
									arr[index].checked = checked;
									props.setAttributes( { category_list: arr } );
								},
							} );
						} )
					),
					el( ToggleControl, {
						label: __( 'Hide Empty Categories' ),
						checked: attrs.hide_empty,
						onChange: ( value ) => { props.setAttributes( { hide_empty: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Order By' ),
						options: [
							{ value: 'name', label: __( 'Name' ) },
							{ value: 'id', label: __( 'ID' ) },
							{ value: 'count', label: __( 'Product Count' ) },
							{ value: 'description', label: __( 'Description' ) },
							{ value: 'term_group', label: __( 'Term Group' ) },
						],
						value: attrs.orderby,
						onChange: ( value ) => { props.setAttributes( { orderby: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Order Way' ),
						options: [
							{ value: 'desc', label: __( 'Descending' ) },
							{ value: 'asc', label: __( 'Ascending' ) },
						],
						value: attrs.orderway,
						onChange: ( value ) => { props.setAttributes( { orderway: value } ); },
					} ),
				),
				el( PanelBody, {
					title: __( 'Categories Layout' ),
					initialOpen: false,
				},
					el( SelectControl, {
						label: __( 'Layout Type' ),
						options: [
							{ value: 'grid', label: __( 'Grid' ) },
							{ value: 'creative', label: __( 'Creative Grid' ) },
							{ value: 'slider', label: __( 'Slider' ) },
						],
						value: attrs.layout_type,
						onChange: ( value ) => {
							props.setAttributes( { layout_type: value } );

							if ( 'creative' === value ) {
								this.creative_layout = wolmart_creative_layout( attrs.creative_layout );
								props.setAttributes( { count: this.creative_layout.length } );
								props.setAttributes( { category_type: 'inner-content' } );
							}
						},
					} ),
					'creative' === attrs.layout_type && el( SelectControl, {
						label: __( 'Creative Presets' ),
						options: [
							{ value: 1, label: __( 'Preset 1' ) },
							{ value: 2, label: __( 'Preset 2' ) },
							{ value: 3, label: __( 'Preset 3' ) },
							{ value: 4, label: __( 'Preset 4' ) },
							{ value: 5, label: __( 'Preset 5' ) },
							{ value: 6, label: __( 'Preset 6' ) },
							{ value: 7, label: __( 'Preset 7' ) },
							{ value: 8, label: __( 'Preset 8' ) },
							{ value: 9, label: __( 'Preset 9' ) },
							{ value: 10, label: __( 'Preset 10' ) },
							{ value: 11, label: __( 'Preset 11' ) },
						],
						value: attrs.creative_mode,
						onChange: ( value ) => {
							props.setAttributes( { creative_mode: value } );
							this.creative_layout = wolmart_creative_layout( Number( value ) );
							props.setAttributes( { count: this.creative_layout.length } );
						},
					} ),
					'creative' === attrs.layout_type && el( RangeControl, {
						label: __( 'Layout Height' ),
						min: 100,
						max: 1000,
						step: 5,
						value: attrs.creative_height,
						onChange: ( value ) => { props.setAttributes( { creative_height: value } ); },
					} ),
					'creative' !== attrs.layout_type && el( SelectControl, {
						label: __( 'Item count' ),
						value: attrs.col_cnt,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt: value } ); },
					} ),
					'creative' !== attrs.layout_type && el( SelectControl, {
						label: __( 'Item count(>=1200px)' ),
						value: attrs.col_cnt_xl,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_xl: value } ); },
					} ),
					'creative' !== attrs.layout_type && el( SelectControl, {
						label: __( 'Item count(>=768px)' ),
						value: attrs.col_cnt_tablet,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_tablet: value } ); },
					} ),
					'creative' !== attrs.layout_type && el( SelectControl, {
						label: __( 'Item count(>=576px)' ),
						value: attrs.col_cnt_mobile,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_mobile: value } ); },
					} ),
					'creative' !== attrs.layout_type && el( SelectControl, {
						label: __( 'Item count(<576px)' ),
						value: attrs.col_cnt_min,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_min: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item Gap' ),
						options: [{ label: __( 'No Space' ), value: 'no' }, { label: __( 'Extremely Small' ), value: 'xs' }, { label: __( 'Small' ), value: 'sm' }, { label: __( 'Medium' ), value: '' }, { label: __( 'Large' ), value: 'lg' },],
						value: attrs.col_sp,
						onChange: ( value ) => { props.setAttributes( { col_sp: value } ); },
					} ),
					'creative' !== attrs.layout_type && el( SelectControl, {
						label: __( 'Vertical Align' ),
						options: [{ label: __( 'Top' ), value: 'top' }, { label: __( 'Middle' ), value: 'middle' }, { label: __( 'Bottom' ), value: 'bottom' }, { label: __( 'Stretch' ), value: 'stretch' },],
						value: attrs.slider_vertical_align,
						onChange: ( value ) => { props.setAttributes( { slider_vertical_align: value } ); },
					} ),
				),
				'slider' === attrs.layout_type && sliderStyleOptions( attrs, props ),
				el( PanelBody, {
					title: __( 'Category Conformation' ),
					initialOpen: false,
				},
					el( SelectControl, {
						label: __( 'Category Type' ),
						options: [
							{ value: '', label: __( 'Default' ) },
							{ value: 'frame', label: __( 'Frame' ) },
							{ value: 'banner', label: __( 'Banner' ) },
							{ value: 'simple', label: __( 'Simple' ) },
							{ value: 'icon', label: __( 'Icon' ) },
							{ value: 'classic', label: __( 'Classic' ) },
							{ value: 'ellipse', label: __( 'Ellipse' ) },
							{ value: 'ellipse-2', label: __( 'Ellipse 2' ) },
							{ value: 'group', label: __( 'Group' ) },
							{ value: 'group-2', label: __( 'Group 2' ) },
							{ value: 'label', label: __( 'Label' ) },
						],
						value: attrs.category_type,
						onChange: ( value ) => { props.setAttributes( { category_type: value } ); },
					} ),
					el( ToggleControl, {
						label: __( 'Show Icon' ),
						checked: attrs.show_icon,
						onChange: ( value ) => { props.setAttributes( { show_icon: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Overlay Effect' ),
						options: [
							{ value: '', label: __( 'No' ) },
							{ value: 'light', label: __( 'Light' ) },
							{ value: 'dark', label: __( 'Dark' ) },
							{ value: 'zoom', label: __( 'Zoom' ) },
							{ value: 'zoom_light', label: __( 'Zoom and Light' ) },
							{ value: 'zoom_dark', label: __( 'Zoom and Dark' ) },
						],
						value: attrs.overlay,
						onChange: ( value ) => { props.setAttributes( { overlay: value } ); },
					} ),
					el( ToggleControl, {
						label: __( 'Show Products Count' ),
						checked: attrs.show_count,
						onChange: ( value ) => { props.setAttributes( { show_count: value } ); },
					} ),
					el( ToggleControl, {
						label: __( 'Link Button' ),
						checked: attrs.show_link,
						onChange: ( value ) => { props.setAttributes( { show_link: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Link Button Text' ),
						value: attrs.link_text,
						onChange: ( value ) => { props.setAttributes( { link_text: value } ); },
					} ),
				),
			);

			return [
				inspectorControls,

				el(
					'div',
					_this.getWrapperAttrs(),
					_this.state.categories.map( function ( cat, idx ) {
						return _this.createCategoryElement( cat, idx );
					} ),
					'creative' === attrs.layout_type && el(
						'div',
						{ className: 'grid-space' },
					)
				),
			];
		}

		getQuery () {
			var attrs = this.props.attributes,
				query_string = '?';
			let cat_flag = 0;

			if ( 'selected' === attrs.category ) {
				attrs.category_list.map( function ( cat ) {
					if ( cat.checked ) {
						query_string += ( cat_flag ? ',' : '&include=' ) + cat.id;
						cat_flag = 1;
					}
				} );
			}

			query_string += '&per_page=' + ( attrs.count ? attrs.count : 100 );

			if ( attrs.hide_empty ) {
				query_string += '&hide_empty=' + attrs.hide_empty;
			}
			query_string += '&orderby=' + attrs.orderby;
			query_string += '&order=' + attrs.orderway;

			var endpoint = '/wc/v3/products/categories' + query_string;
			return endpoint;
		}

		fetchCategories () {
			var _this = this,
				query = this.getQuery();

			this.setState( {
				query: query,
			} )

			apiFetch( { path: query } ).then( function ( categories ) {
				_this.setState( {
					categories: categories,
				} );
			} );
		}

		getWrapperAttrs () {
			let out_attrs = {},
				attrs = this.props.attributes,
				col_cnt = getResponsiveCols( {
					xl: attrs.col_cnt_xl,
					lg: attrs.col_cnt,
					md: attrs.col_cnt_tablet,
					sm: attrs.col_cnt_mobile,
					min: attrs.col_cnt_min,
				} );

			if ( 'creative' !== attrs.layout_type ) {
				out_attrs['className'] = 'products' + getColClass( col_cnt );
			} else {
				out_attrs['className'] = 'products row';
			}

			if ( 'lg' === attrs.col_sp || 'xs' === attrs.col_sp || 'sm' === attrs.col_sp || 'no' === attrs.col_sp ) {
				out_attrs['className'] += ' gutter-' + attrs.col_sp;
			}

			if ( 'slider' === attrs.layout_type ) {
				let extra_options = {};
				extra_options = getSliderOptions( attrs );

				out_attrs['className'] += getSliderClass( attrs );
				out_attrs['data-plugin-options'] = JSON.stringify( extra_options );
			} else if ( 'creative' === attrs.layout_type ) {
				out_attrs['className'] += ' grid';
				out_attrs['data-plugin'] = 'isotope';
			}

			return out_attrs;
		}

		createCategoryElement ( cat, idx ) {
			var attrs = this.props.attributes,
				cat_class = ['product-category product'],
				content_style = {},
				content_class = ['category-content'],
				col_sp = attrs.col_sp,
				wrap_class = ['category-wrap'],
				wrap_style = {},
				sub_cat_list = '<li>Category 1</li><li>Category 2</li><li>Category 3</li><li>Category 4</li><li>Category 5</li>';

			if ( 'creative' === attrs.layout_type && this.creative_layout[idx] ) {
				var height = this.creative_layout[idx].h;
				wrap_class.push( 'grid-item' );
				wrap_class.push( 'col-' + this.creative_layout[idx].col );
				wrap_class.push( 'h-' + height );

				if ( height === '1' ) {
					wrap_style['height'] = attrs.creative_height;
				} else {
					height = height.split( '-' );
					wrap_style['height'] = attrs.creative_height / height[1] * height[0];
				}
			}

			cat_class.push( attrs.category_type );

			cat_class.push( 'category-' + cat.slug );

			// Category Type
			if ( 'frame' === attrs.category_type ) {
				cat_class.push( 'cat-type-frame cat-type-absolute' );

			} else if ( 'banner' === attrs.category_type ) {
				cat_class.push( 'cat-type-banner cat-type-absolute' );
			} else if ( 'label' === attrs.category_type ) {
				cat_class.push( 'cat-type-block' );

			} else if ( 'icon' === attrs.category_type ) {
				cat_class.push( 'cat-type-icon' );

			} else if ( 'classic' === attrs.category_type ) {
				cat_class.push( 'cat-type-classic cat-type-absolute' );

			} else if ( 'ellipse' === attrs.category_type ) {
				cat_class.push( 'cat-type-ellipse cat-type-absolute' );

			} else if ( 'group' === attrs.category_type ) {
				cat_class.push( 'cat-type-group' );

			} else if ( 'group-2' === attrs.category_type ) {
				cat_class.push( 'cat-type-group2' );

			} else if ( 'center' === attrs.category_type ) {
				cat_class.push( 'cat-type-overlay cat-type-absolute' );
			} else {
				cat_class.push( 'cat-type-default cat-type-absolute' );
			}

			// Content Align
			attrs.content_align && cat_class.push( attrs.content_align );

			// Overlay
			attrs.overlay && cat_class.push( getOverlayClass( attrs.overlay ) );

			return el(
				'div',
				{ className: wrap_class.join( ' ' ), style: wrap_style },
				el(
					'div',
					{ className: cat_class.join( ' ' ) },
					'label' === attrs.category_type && el(
						'a',
						{ href: '#' },
						el(
							'h3',
							{ className: 'woocommerce-loop-category__title' },
							cat.name,
						),
					),
					'label' !== attrs.category_type && el(
						'a',
						{ href: '#' },
						el(
							'figure',
							{},
							!attrs.show_icon && el(
								'img',
								{ src: cat.image && cat.image.src ? cat.image.src : wolmart_gutenberg_vars.placeholder_img },
							),
							attrs.show_icon && ( 'icon' === attrs.category_type || 'group-2' === attrs.category_type ) && el(
								'i',
								{ className: 'w-icon-heart' }
							)
						),
						'group-2' === attrs.category_type && el(
							'h3',
							{ className: 'woocommerce-loop-category__title' },
							cat.name,
						),
					),
					'label' !== attrs.category_type && el(
						'div',
						{ className: 'category-content' },
						( !attrs.category_type || 'icon' === attrs.category_type || 'ellipse' === attrs.category_type || 'center' === attrs.category_type ) && el(
							'h3',
							{ className: 'woocommerce-loop-category__title' },
							el(
								'a',
								{ href: "#" },
								cat.name,
							),
						),
						( 'classic' === attrs.category_type || 'frame' === attrs.category_type || 'banner' === attrs.category_type || 'group' === attrs.category_type ) && el(
							'h3',
							{ className: 'woocommerce-loop-category__title' },
							cat.name,
							'frame' === attrs.category_type && attrs.show_count && el(
								'mark',
								{},
								'(' + cat.count + ')',
							),
						),
						( 'group' === attrs.category_type || 'group-2' === attrs.category_type ) && el(
							'ul',
							{ className: 'category-list', dangerouslySetInnerHTML: { __html: sub_cat_list } },
						),
						attrs.show_count && ( !attrs.category_type && 'icon' == attrs.category_type || 'ellipse' == attrs.category_type || 'classic' == attrs.category_type || 'center' == attrs.category_type || 'banner' == attrs.category_type ) && el(
							'mark',
							{},
							cat.count + ' Products',
						),
						attrs.show_link && ( 'classic' === attrs.category_type || 'frame' === attrs.category_type || 'banner' === attrs.category_type || 'icon' === attrs.category_type ) && el(
							'a',
							{ className: 'frame' === attrs.category_type ? 'btn btn-primary btn-block' : 'btn btn-underline btn-link', href: "#", },
							attrs.link_text,
						)
					),
				),
			);
		}
	};

	wolmartComponents.WolmartPosts = class WolmartPosts extends Component {
		constructor () {
			super( ...arguments );

			this.state = {
				posts: [],
				query: '',
			};
		}

		componentDidMount () {
			var _this = this;

			wp.apiFetch( { path: '/wp/v2/categories' } ).then( function ( cats ) {
				_this.props.attributes.category_list.map( function ( cat, idx ) {
					if ( -1 === cats.findIndex( obj => obj.id === cat.id ) ) {
						_this.props.attributes.category_list.splice( idx, 1 );
					}
				} );
				cats.map( function ( cat ) {
					if ( -1 === _this.props.attributes.category_list.findIndex( obj => obj.id === cat.id ) ) {
						cat['checked'] = false;
						_this.props.attributes.category_list.push( cat );
					}
				} );
			} );

			this.fetchPosts();
		}

		componentDidUpdate ( prevProps, prevState ) {
			var attrs = this.props.attributes,
				state = this.state,
				prevAttrs = prevProps.attributes,
				$selector = jQuery( '#block-' + this.props.clientId + ' .posts' );

			if ( state.query !== this.getQuery() ) {
				if ( $selector.data( 'slider' ) ) {
					$selector.data( 'slider' ).destroy();
					$selector.removeData( 'slider' );
				}
				this.fetchPosts();
			}

			if ( 'grid' === attrs.layout_type ) {
				if ( 'slider' === prevAttrs.layout_type ) {
					if ( $selector.data( 'slider' ) ) {
						$selector.data( 'slider' ).destroy();
						$selector.removeData( 'slider' );
					}
				}
			} else if ( 'slider' === attrs.layout_type ) {
				// if props changes are related to slider, init slider again,
				if ( state.posts !== prevState.posts ||
					attrs.layout_type !== prevAttrs.layout_type ||
					isSliderChanged( attrs, prevAttrs ) ) {
					if ( $selector.data( 'slider' ) ) {
						$selector.data( 'slider' ).destroy();
						$selector.removeData( 'slider' );
					}
					initSlider( $selector );
				}
			}
		}

		render () {
			var _this = this,
				props = this.props,
				attrs = props.attributes;

			var inspectorControls = el( InspectorControls, {},
				el( PanelBody, {
					title: __( 'Posts Selector' ),
					initialOpen: false,
				},
					el( RangeControl, {
						label: __( 'Posts Count' ),
						value: attrs.count,
						min: 1,
						max: 20,
						step: 1,
						onChange: ( value ) => { props.setAttributes( { count: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Category' ),
						value: attrs.category_type,
						options: [{ label: __( 'All' ), value: '' }, { label: __( 'Selected' ), value: 'selected' }],
						onChange: ( value ) => { props.setAttributes( { category_type: value } ); },
					} ),
					attrs.category_type === 'selected' && el(
						'div',
						{ className: 'checkbox-list category-list' },
						attrs.category_list.map( function ( cat, index ) {
							return el( CheckboxControl, {
								key: index,
								label: [cat.name, el(
									'span',
									{ key: 'cat-count', style: { fontSize: 'small', color: '#888', marginLeft: 5 } },
									'(',
									cat.count,
									')'
								)],
								checked: cat.checked,
								onChange: ( checked ) => {
									var arr = attrs.category_list.concat();
									arr[index].checked = checked;
									props.setAttributes( { category_list: arr } );
								},
							} );
						} )
					),
					el( SelectControl, {
						label: __( 'Order By' ),
						options: [
							{ value: 'author', label: __( 'Author' ) },
							{ value: 'id', label: __( 'ID' ) },
							{ value: 'title', label: __( 'Title' ) },
							{ value: 'date', label: __( 'Date' ) },
							{ value: 'modified', label: __( 'Modified' ) },
						],
						value: attrs.orderby,
						onChange: ( value ) => { props.setAttributes( { orderby: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Order Way' ),
						options: [
							{ value: 'desc', label: __( 'Descending' ) },
							{ value: 'asc', label: __( 'Ascending' ) },
						],
						value: attrs.orderway,
						onChange: ( value ) => { props.setAttributes( { orderway: value } ); },
					} ),
				),
				el( PanelBody, {
					title: __( 'Posts Layout' ),
					initialOpen: false,
				},
					el( SelectControl, {
						label: __( 'Layout Type' ),
						options: [
							{ value: 'grid', label: __( 'Grid' ) },
							{ value: 'slider', label: __( 'Slider' ) },
						],
						value: attrs.layout_type,
						onChange: ( value ) => { props.setAttributes( { layout_type: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count' ),
						value: attrs.col_cnt,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count(>=1200px)' ),
						value: attrs.col_cnt_xl,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_xl: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count(>=768px)' ),
						value: attrs.col_cnt_tablet,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_tablet: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count(>=576px)' ),
						value: attrs.col_cnt_mobile,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_mobile: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item count(<576px)' ),
						value: attrs.col_cnt_min,
						options: [{ label: __( 'Auto' ), value: '' }, { label: __( '1' ), value: '1' }, { label: __( '2' ), value: '2' }, { label: __( '3' ), value: '3' }, { label: __( '4' ), value: '4' }, { label: __( '5' ), value: '5' }, { label: __( '6' ), value: '6' }, { label: __( '7' ), value: '7' }, { label: __( '8' ), value: '8' },],
						onChange: ( value ) => { props.setAttributes( { col_cnt_min: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Item Gap' ),
						options: [{ label: __( 'No Space' ), value: 'no' }, { label: __( 'Extremely Small' ), value: 'xs' }, { label: __( 'Small' ), value: 'sm' }, { label: __( 'Medium' ), value: '' }, { label: __( 'Large' ), value: 'lg' },],
						value: attrs.col_sp,
						onChange: ( value ) => { props.setAttributes( { col_sp: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Vertical Align' ),
						options: [{ label: __( 'Top' ), value: 'top' }, { label: __( 'Middle' ), value: 'middle' }, { label: __( 'Bottom' ), value: 'bottom' }, { label: __( 'Stretch' ), value: 'stretch' },],
						value: attrs.slider_vertical_align,
						onChange: ( value ) => { props.setAttributes( { slider_vertical_align: value } ); },
					} ),
				),
				'slider' === attrs.layout_type && sliderStyleOptions( attrs, props ),
				el( PanelBody, {
					title: __( 'Post Conformation' ),
					initialOpen: false,
				},
					el( SelectControl, {
						label: __( 'Post Type' ),
						options: [
							{ value: '', label: __( 'Default' ) },
							{ value: 'list', label: __( 'List' ) },
							{ value: 'mask', label: __( 'Mask' ) },
							{ value: 'mask gradient', label: __( 'Mask Gradient' ) },
							{ value: 'widget', label: __( 'Widget' ) },
							{ value: 'list-xs', label: __( 'Galendar' ) },
						],
						value: attrs.post_type,
						onChange: ( value ) => { props.setAttributes( { post_type: value } ); },
					} ),
					el(
						'div',
						{ className: 'checkbox-list show-info-list' },
						el(
							'p',
							{},
							__( "Check Items you want to show" ),
						),
						Object.keys( attrs.show_info ).map( function ( key, index ) {
							return el( CheckboxControl, {
								label: key,
								checked: attrs.show_info[key],
								onChange: ( checked ) => {
									var obj = Object.assign( {}, attrs.show_info );
									obj[key] = checked;
									props.setAttributes( { show_info: obj } );
								},
							} );
						} ),
					),
					el( SelectControl, {
						label: __( 'Overlay Type' ),
						options: [
							{ value: '', label: __( 'No' ) },
							{ value: 'light', label: __( 'Light' ) },
							{ value: 'dark', label: __( 'Dark' ) },
							{ value: 'zoom', label: __( 'Zoom' ) },
							{ value: 'zoom_light', label: __( 'Zoom and Light' ) },
							{ value: 'zoom_dark', label: __( 'Zoom and Dark' ) },
						],
						value: attrs.overlay,
						onChange: ( value ) => { props.setAttributes( { overlay: value } ); },
					} ),
					el( ToggleControl, {
						label: __( 'Show Date on Featured Image' ),
						checked: attrs.show_datebox,
						onChange: ( value ) => { props.setAttributes( { show_datebox: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Content Align' ),
						options: [{ value: 'left', label: __( 'Left' ) }, { value: 'center', label: __( 'Center' ) }, { value: 'right', label: __( 'Right' ) }],
						value: attrs.content_align,
						onChange: ( value ) => { props.setAttributes( { content_align: value } ); },
					} ),
					el( ToggleControl, {
						label: __( 'Custom Excerpt' ),
						checked: attrs.excerpt_custom,
						onChange: ( value ) => { props.setAttributes( { excerpt_custom: value } ); },
					} ),
					attrs.excerpt_custom && el( SelectControl, {
						label: __( 'Excerpt By' ),
						options: [
							{ value: 'words', label: __( 'Words' ) },
							{ value: 'character', label: __( 'Characters' ) },
						],
						value: attrs.excerpt_type,
						onChange: ( value ) => { props.setAttributes( { excerpt_type: value } ); }
					} ),
					attrs.excerpt_custom && el( RangeControl, {
						label: __( 'Excerpt Length' ),
						value: attrs.excerpt_length,
						min: 1,
						max: 500,
						step: 1,
						onChange: ( value ) => { props.setAttributes( { excerpt_length: value } ); },
					} ),
				),
				el( PanelBody, {
					title: __( 'Read More Button' ),
					initialOpen: false,
				},
					el( TextControl, {
						label: __( 'Read More Label' ),
						value: attrs.read_more_label,
						onChange: ( value ) => { props.setAttributes( { read_more_label: value } ); }
					} ),
					el( ToggleControl, {
						label: __( 'Use Custom' ),
						checked: attrs.read_more_custom,
						onChange: ( checked ) => { props.setAttributes( { read_more_custom: checked } ); }
					} ),
					el( SelectControl, {
						label: __( 'Skin' ),
						value: attrs.button_skin,
						options: [{ label: __( 'Primary' ), value: 'btn-primary' }, { label: __( 'Secondary' ), value: 'btn-secondary' }, { label: __( 'Warning' ), value: 'btn-warning' }, { label: __( 'Danger' ), value: 'btn-danger' }, { label: __( 'Success' ), value: 'btn-success' }, { label: __( 'Dark' ), value: 'btn-dark' }, { label: __( 'White' ), value: 'btn-white' }],
						onChange: ( value ) => { props.setAttributes( { button_skin: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Shape' ),
						value: attrs.button_border,
						options: [{ label: __( 'Rectangle' ), value: '' }, { label: __( 'Rounded' ), value: 'btn-rounded' }, { label: __( 'Ellipse' ), value: 'btn-ellipse' }],
						onChange: ( value ) => { props.setAttributes( { button_border: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Type' ),
						value: attrs.button_type,
						options: [{ label: __( 'Default' ), value: '' }, { label: __( 'Outline' ), value: 'btn-outline' }, { label: __( 'Solid' ), value: 'btn-solid' }, { label: __( 'Link' ), value: 'btn-link' }],
						onChange: ( value ) => { props.setAttributes( { button_type: value } ); },
					} ),
					'btn-link' === attrs.button_type && el( SelectControl, {
						label: __( 'Hover Underline' ),
						value: attrs.link_hover_type,
						options: [{ label: __( 'None' ), value: '' }, { label: __( 'Underline1' ), value: 'btn-underline sm' }, { label: __( 'Underline2' ), value: 'btn-underline' }, { label: __( 'Underline3' ), value: 'btn-underline lg' }],
						onChange: ( value ) => { props.setAttributes( { link_hover_type: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Size' ),
						value: attrs.button_size,
						options: [{ label: __( 'Small' ), value: 'btn-sm' }, { label: __( 'Medium' ), value: 'btn-md' }, { label: __( 'Normal' ), value: '' }, { label: __( 'Large' ), value: 'btn-lg' }],
						onChange: ( value ) => { props.setAttributes( { button_size: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Icon Class' ),
						value: attrs.icon,
						onChange: ( value ) => { props.setAttributes( { icon: value } ); },
					} ),
					el(
						ButtonGroup,
						{ className: "button_tabs" },
						el( 'button', {
							className: 'before' === attrs.icon_pos ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { icon_pos: 'before' } );
							},
						}, __( 'Before' ) ),
						el( 'button', {
							className: 'after' === attrs.icon_pos ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { icon_pos: 'after' } );
							},
						}, __( 'After' ) ),
					),
					el( TextControl, {
						label: __( 'Icon Font Size' ),
						value: attrs.icon_size,
						onChange: ( value ) => { props.setAttributes( { icon_size: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Icon Hover Effect' ),
						value: attrs.icon_hover_effect,
						options: [{ label: __( 'None' ), value: '' }, { label: __( 'Slide left' ), value: 'btn-slide-left' }, { label: __( 'Slide right' ), value: 'btn-slide-right' }, { label: __( 'Slide up' ), value: 'btn-slide-up' }, { label: __( 'Slide down' ), value: 'btn-slide-down' }, { label: __( 'Reveal left' ), value: 'btn-reveal-left' }, { label: __( 'Reveal right' ), value: 'btn-reveal-right' }],
						onChange: ( value ) => { props.setAttributes( { icon_hover_effect: value } ); },
					} ),
					-1 !== String( attrs.icon_hover_effect ).indexOf( 'btn-slide' ) && el( ToggleControl, {
						label: __( 'Animation Infinite' ),
						checked: attrs.icon_hover_effect_infinite,
						onChange: ( checked ) => { props.setAttributes( { icon_hover_effect_infinite: checked } ); },
					} ),
				),
			);

			return [
				inspectorControls,

				el(
					'div',
					_this.getWrapperAttrs(),
					_this.state.posts.map( function ( post, idx ) {
						return _this.createPostElement( post, idx );
					} ),
				),
			];
		}

		getQuery () {
			var attrs = this.props.attributes,
				query_string = '?';
			let cat_flag = 0;

			if ( 'selected' === attrs.category_type ) {
				attrs.category_list.map( function ( cat ) {
					if ( cat.checked ) {
						query_string += ( cat_flag ? ',' : '&categories=' ) + cat.id;
						cat_flag = 1;
					}
				} );
			}

			query_string += '&per_page=' + ( attrs.count ? attrs.count : 100 );
			query_string += '&orderby=' + attrs.orderby;
			query_string += '&order=' + attrs.orderway;

			var endpoint = '/wp/v2/posts' + query_string;
			return endpoint;
		}

		fetchPosts () {
			var _this = this,
				query = this.getQuery();

			this.setState( {
				query: query,
			} )

			apiFetch( { path: query } ).then( function ( posts ) {
				_this.setState( {
					posts: posts,
				} );
			} );
		}

		getWrapperAttrs () {
			let out_attrs = {},
				attrs = this.props.attributes,
				col_cnt = getResponsiveCols( {
					xl: attrs.col_cnt_xl,
					lg: attrs.col_cnt,
					md: attrs.col_cnt_tablet,
					sm: attrs.col_cnt_mobile,
					min: attrs.col_cnt_min,
				} );

			out_attrs['className'] = 'posts ' + getColClass( col_cnt );

			if ( 'lg' === attrs.col_sp || 'xs' === attrs.col_sp || 'sm' === attrs.col_sp || 'no' === attrs.col_sp ) {
				out_attrs['className'] += ' gutter-' + attrs.col_sp;
			}

			if ( 'slider' === attrs.layout_type ) {
				let extra_options = {};

				out_attrs['className'] += getSliderClass( attrs );

				extra_options = getSliderOptions( attrs );

				out_attrs['data-plugin-options'] = JSON.stringify( extra_options );
			}

			return out_attrs;
		}

		createPostElement ( post, idx ) {
			var attrs = this.props.attributes,
				p_class = ['post'],
				content_style = {},
				btn_class = ['btn'],
				col_sp = attrs.col_sp;

			// Post Type
			if ( attrs.post_type ) {
				p_class.push( 'post-' + attrs.post_type );
			}

			// Overlay
			if ( attrs.overlay ) {
				if ( 'zoom_light' === attrs.overlay ) {
					p_class.push( 'overlay-light overlay-zoom' );
				} else if ( 'zoom_dark' === attrs.overlay ) {
					p_class.push( 'overlay-dark overlay-zoom' );
				} else {
					p_class.push( 'overlay-' + attrs.overlay );
				}
			}

			content_style['textAlign'] = attrs.content_align;

			// Button Class
			btn_class.push( attrs.button_skin );
			attrs.button_border && btn_class.push( attrs.button_border );
			attrs.button_type && btn_class.push( attrs.button_type );
			'btn-link' === attrs.button_type && attrs.link_hover_type && btn_class.push( attrs.link_hover_type );
			attrs.button_size && btn_class.push( attrs.button_size );
			attrs.icon_hover_effect && btn_class.push( attrs.icon_hover_effect );
			attrs.icon_hover_effect && attrs.icon_hover_effect_infinite && btn_class.push( 'btn-infinite' );

			if ( 'before' === attrs.icon_pos ) {
				btn_class.push( 'btn-icon-left' );
			} else {
				btn_class.push( 'btn-icon-right' );
			}

			return el(
				'div',
				{ className: 'post-wrap' },
				el(
					'div',
					{ className: p_class.join( ' ' ) },
					-1 !== Object.values( attrs.show_info ).indexOf( true ) && attrs.show_info.image && el(
						'figure',
						{ className: 'post-media' },
						el(
							'a',
							{ href: '#' },
							el(
								'img',
								{ src: post.featured_image_src.grid[0] },
							)
						),
						attrs.show_datebox && el(
							'div',
							{ className: 'post-calendar' },
							el(
								'span',
								{ className: 'post-day' },
								moment( post.date_gmt ).local().format( 'DD' ),
							),
							el(
								'span',
								{ className: 'post-month' },
								moment( post.date_gmt ).local().format( 'MMM' ),
							),
						),
					),
					'list-xs' == attrs.post_type && el(
						'div',
						{ className: 'post-calendar' },
						el(
							'span',
							{ className: 'post-day' },
							moment( post.date_gmt ).local().format( 'DD' ),
						),
						el(
							'span',
							{ className: 'post-month' },
							moment( post.date_gmt ).local().format( 'MMM' ),
						),
					),
					el(
						'div',
						{ className: 'post-details', style: content_style },
						-1 !== Object.values( attrs.show_info ).indexOf( true ) && el(
							'div',
							{ className: "post-meta" },
							attrs.show_info.date && el(
								'span',
								{ className: "post-date" },
								moment( post.date_gmt ).local().format( 'MMMM DD, Y' ),
							),
							attrs.show_info.author && el(
								'span',
								{ className: "post-author" },
								post.author_name,
							),
							attrs.show_info.comment && el(
								'span',
								{ className: "post-comment" },
								post.comment_count + ' Comment' + ( 1 < post.comment_count ? 's' : '' ),
							),
						),
						el(
							'h3',
							{ className: 'post-title' },
							el(
								'a',
								{ dangerouslySetInnerHTML: { __html: post.title.rendered } }
							),
						),
						-1 !== Object.values( attrs.show_info ).indexOf( true ) && attrs.show_info.category && el(
							'div',
							{ className: "post-cats" },
							post.category_names.join( ', ' ),
						),
						-1 !== Object.values( attrs.show_info ).indexOf( true ) && attrs.show_info.content && el(
							'div',
							{ className: 'post-content', dangerouslySetInnerHTML: { __html: post.excerpt.rendered } },
						),
						-1 !== Object.values( attrs.show_info ).indexOf( true ) && attrs.show_info.readmore && el(
							'a',
							{ className: attrs.read_more_custom ? btn_class.join( ' ' ) : 'btn btn-link btn-underline btn-primary btn-reveal-right' },
							attrs.read_more_custom && 'before' === attrs.icon_pos && attrs.icon && el(
								'i',
								{ className: attrs.icon },
							),
							attrs.read_more_label,
							attrs.read_more_custom && 'after' === attrs.icon_pos && attrs.icon && el(
								'i',
								{ className: attrs.icon },
							),
							!attrs.read_more_custom && el(
								'i',
								{ className: 'w-icon-arrow-right' },
							),
						),
					),
				),
			);
		}
	};

	wolmartComponents.WolmartIconBox = class WolmartIconBox extends Component {
		constructor () {
			super( ...arguments );
		}

		componentDidMount () { }

		componentDidUpdate () { }

		render () {
			var _this = this,
				props = this.props,
				attrs = props.attributes;

			var inspectorControls = el( InspectorControls, {},
				el( PanelBody, {
					title: __( 'Icon Box' ),
					initialOpen: false,
				},
					el( SelectControl, {
						label: __( 'Icon Box Type' ),
						value: attrs.type,
						options: [{ label: __( 'List' ), value: '' }, { label: __( 'Grid' ), value: 'grid' }, { label: __( 'Mixed' ), value: 'mixed' }],
						onChange: ( value ) => { props.setAttributes( { type: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Horizontal Align' ),
						value: attrs.h_align,
						options: [{ label: __( 'Left' ), value: 'left' }, { label: __( 'Center' ), value: 'center' }, { label: __( 'Right' ), value: 'right' }],
						onChange: ( value ) => { props.setAttributes( { h_align: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Vertical Align' ),
						value: attrs.v_align,
						options: [{ label: __( 'Top' ), value: 'flex-start' }, { label: __( 'Middle' ), value: 'center' }, { label: __( 'Bottom' ), value: 'flex-end' }],
						onChange: ( value ) => { props.setAttributes( { v_align: value } ); },
					} ),
					!attrs.type && el( SelectControl, {
						label: __( 'Content Align' ),
						value: attrs.content_align,
						options: [{ label: __( 'Left' ), value: 'left' }, { label: __( 'Center' ), value: 'center' }, { label: __( 'Right' ), value: 'right' }],
						onChange: ( value ) => { props.setAttributes( { content_align: value } ); },
					} ),
					el( 'div',
						{ className: 'dimension' },
						el(
							'h4',
							{},
							__( 'Padding' ),
						),
						el( 'div',
							{ className: 'options' },
							el( TextControl, {
								label: __( 'Top' ),
								value: attrs.pt,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pt: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Right' ),
								value: attrs.pr,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pr: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Bottom' ),
								value: attrs.pb,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pb: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Left' ),
								value: attrs.pl,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pl: value } ); },
							} ),
						),
					),
					el( 'div',
						{ className: 'dimension' },
						el(
							'h4',
							{},
							__( 'Margin' ),
						),
						el( 'div',
							{ className: 'options' },
							el( TextControl, {
								label: __( 'Top' ),
								value: attrs.mt,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { mt: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Right' ),
								value: attrs.mr,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { mr: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Bottom' ),
								value: attrs.mb,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { mb: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Left' ),
								value: attrs.ml,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { ml: value } ); },
							} ),
						),
					),
				),
				el( PanelBody, {
					title: __( 'Icon' ),
					initialOpen: false,
				},
					el( TextControl, {
						label: __( 'Icon class ( Font Awesome Font Icons )' ),
						value: attrs.icon_class,
						onChange: ( value ) => { props.setAttributes( { icon_class: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Icon Size ' ),
						value: attrs.icon_size,
						onChange: ( value ) => { props.setAttributes( { icon_size: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Icon Style' ),
						value: attrs.icon_style,
						options: [{ label: __( 'Default' ), value: '' }, { label: __( 'Stacked' ), value: 'stacked' }, { label: __( 'Framed' ), value: 'framed' }],
						onChange: ( value ) => { props.setAttributes( { icon_style: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Border Shape' ),
						value: attrs.border_shape,
						options: [{ label: __( 'Circle' ), value: 'circle' }, { label: __( 'Rounded' ), value: 'rounded' },],
						onChange: ( value ) => { props.setAttributes( { border_shape: value } ); },
					} ),
					attrs.icon_style && el( 'div',
						{ className: 'dimension' },
						el(
							'h4',
							{},
							__( 'Padding' ),
						),
						el( 'div',
							{ className: 'options' },
							el( TextControl, {
								label: __( 'Top' ),
								value: attrs.icon_pt,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { icon_pt: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Right' ),
								value: attrs.icon_pr,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { icon_pr: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Bottom' ),
								value: attrs.icon_pb,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { icon_pb: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Left' ),
								value: attrs.icon_pl,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { icon_pl: value } ); },
							} ),
						),
					),
					el( 'div',
						{ className: 'dimension' },
						el(
							'h4',
							{},
							__( 'Margin' ),
						),
						el( 'div',
							{ className: 'options' },
							el( TextControl, {
								label: __( 'Top' ),
								value: attrs.icon_mt,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { icon_mt: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Right' ),
								value: attrs.icon_mr,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { icon_mr: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Bottom' ),
								value: attrs.icon_mb,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { icon_mb: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Left' ),
								value: attrs.icon_ml,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { icon_ml: value } ); },
							} ),
						),
					),
					el( PanelColorSettings, {
						title: __( 'Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Color' ),
							value: attrs.icon_col,
							onChange: ( value ) => { props.setAttributes( { icon_col: value } ); },
						}]
					} ),
					el( PanelColorSettings, {
						title: __( 'Background Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Background Color' ),
							value: attrs.icon_bg_col,
							onChange: ( value ) => { props.setAttributes( { icon_bg_col: value } ); },
						}]
					} ),
				),
				el( PanelBody, {
					title: __( 'Heading' ),
					initialOpen: false,
				},
					el( TextareaControl, {
						label: __( 'Heading ' ),
						value: attrs.heading,
						onChange: ( value ) => { props.setAttributes( { heading: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Font Size' ),
						min: 1,
						value: attrs.head_size,
						onChange: ( value ) => { props.setAttributes( { head_size: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Font Weight (px) ' ),
						type: 'number',
						min: 300,
						value: attrs.head_weight,
						onChange: ( value ) => { props.setAttributes( { head_weight: value } ); },
					} ),
					el( 'div',
						{ className: 'dimension' },
						el(
							'h4',
							{},
							__( 'Margin' ),
						),
						el( 'div',
							{ className: 'options' },
							el( TextControl, {
								label: __( 'Top' ),
								value: attrs.head_mt,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { head_mt: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Right' ),
								value: attrs.head_mr,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { head_mr: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Bottom' ),
								value: attrs.head_mb,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { head_mb: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Left' ),
								value: attrs.head_ml,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { head_ml: value } ); },
							} ),
						),
					),
					el( PanelColorSettings, {
						title: __( 'Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Color' ),
							value: attrs.head_col,
							onChange: ( value ) => { props.setAttributes( { head_col: value } ); },
						}]
					} ),
				),
				el( PanelBody, {
					title: __( 'Description' ),
					initialOpen: false,
				},
					el( TextareaControl, {
						label: __( 'Description ' ),
						value: attrs.description,
						onChange: ( value ) => { props.setAttributes( { description: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Font Size' ),
						value: attrs.desc_size,
						onChange: ( value ) => { props.setAttributes( { desc_size: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Line Height' ),
						value: attrs.desc_lh,
						onChange: ( value ) => { props.setAttributes( { desc_lh: value } ); },
					} ),
					el( 'div',
						{ className: 'dimension' },
						el(
							'h4',
							{},
							__( 'Margin' ),
						),
						el( 'div',
							{ className: 'options' },
							el( TextControl, {
								label: __( 'Top' ),
								value: attrs.desc_mt,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { desc_mt: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Right' ),
								value: attrs.desc_mr,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { desc_mr: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Bottom' ),
								value: attrs.desc_mb,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { desc_mb: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Left' ),
								value: attrs.desc_ml,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { desc_ml: value } ); },
							} ),
						),
					),
					el( PanelColorSettings, {
						title: __( 'Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Color' ),
							value: attrs.desc_col,
							onChange: ( value ) => { props.setAttributes( { desc_col: value } ); },
						}]
					} ),
				),
			);

			return [
				inspectorControls,
				this.createImageBoxElement(),
			];
		}

		createImageBoxElement () {
			var attrs = this.props.attributes,
				aclass = [],
				content_aclass = [],
				content_style = {},
				box_style = {},
				figure_style = {},
				icon_style = {},
				head_style = {},
				desc_style = {};

			if ( !attrs.type ) {
				aclass.push( 'icon-box-side' );
			}
			if ( 'mixed' === attrs.type ) {
				aclass.push( 'icon-box-tiny' );
			}
			box_style['margin'] = attrs.mt + 'px ' + attrs.mr + 'px ' + attrs.mb + 'px ' + attrs.ml + 'px';
			box_style['padding'] = attrs.pt + 'px ' + attrs.pr + 'px ' + attrs.pb + 'px ' + attrs.pl + 'px';
			box_style['textAlign'] = attrs.h_align;
			box_style['alignItems'] = attrs.v_align;

			if ( 'left' === attrs.h_align ) {
				box_style['justifyContent'] = 'flex-start';
			} else if ( 'center' === attrs.h_align ) {
				box_style['justifyContent'] = 'center';
			} else {
				box_style['justifyContent'] = 'flex-end';
			}

			if ( !attrs.type ) {
				box_style['display'] = 'flex';
			} else {
				box_style['display'] = 'block';
			}

			if ( attrs.type ) {
				if ( 'left' === attrs.h_align ) {
					content_style['justifyContent'] = 'flex-start';
				} else if ( 'center' === attrs.h_align ) {
					content_style['justifyContent'] = 'center';
				} else {
					content_style['justifyContent'] = 'flex-end';
				}
				content_style['textAlign'] = attrs.h_align;
				if ( 'mixed' === attrs.type ) {
					if ( 'left' === attrs.h_align ) {
						head_style['justifyContent'] = 'flex-start';
					} else if ( 'center' === attrs.h_align ) {
						head_style['justifyContent'] = 'center';
					} else {
						head_style['justifyContent'] = 'flex-end';
					}
				}
			} else {
				content_style['textAlign'] = attrs.content_align;
			}

			icon_style['fontSize'] = ( '' === attrs.icon_size ? 20 : attrs.icon_size );
			if ( !String( icon_style['fontSize'] ).replace( /[0-9.]/g, '' ) ) {
				icon_style['fontSize'] += 'px';
			}
			icon_style['color'] = attrs.icon_col;

			if ( attrs.icon_style ) {
				icon_style['padding'] = attrs.icon_pt + 'px ' + attrs.icon_pr + 'px ' + attrs.icon_pb + 'px ' + attrs.icon_pl + 'px';

				if ( 'stacked' === attrs.icon_style ) {
					icon_style['backgroundColor'] = attrs.icon_col;
					icon_style['color'] = '#fff';
				} else {
					icon_style['border'] = '3px solid ' + attrs.icon_bg_col;
				}

				if ( 'circle' === attrs.border_shape ) {
					icon_style['borderRadius'] = '50%';
				}
				if ( 'rounded' === attrs.border_shape ) {
					icon_style['borderRadius'] = '5px';
				}
			}
			icon_style['margin'] = attrs.icon_mt + 'px ' + attrs.icon_mr + 'px ' + attrs.icon_mb + 'px ' + attrs.icon_ml + 'px';

			head_style['fontSize'] = ( '' === attrs.head_size ? 16 : attrs.head_size );
			if ( !String( head_style['fontSize'] ).replace( /[0-9.]/g, '' ) ) {
				head_style['fontSize'] += 'px';
			}
			head_style['fontWeight'] = attrs.head_weight;
			head_style['margin'] = attrs.head_mt + 'px ' + attrs.head_mr + 'px ' + attrs.head_mb + 'px ' + attrs.head_ml + 'px';
			head_style['color'] = attrs.head_col;

			desc_style['fontSize'] = ( '' === attrs.desc_size ? 14 : attrs.desc_size );
			if ( !String( desc_style['fontSize'] ).replace( /[0-9.]/g, '' ) ) {
				desc_style['fontSize'] += 'px';
			}
			desc_style['lineHeight'] = attrs.desc_lh;
			desc_style['margin'] = attrs.desc_mt + 'px ' + attrs.desc_mr + 'px ' + attrs.desc_mb + 'px ' + attrs.desc_ml + 'px';
			desc_style['color'] = attrs.desc_col;

			return el(
				'div',
				{ className: 'icon-box ' + aclass.join( ' ' ), style: box_style },
				'mixed' !== attrs.type && el(
					'span',
					{ style: figure_style, className: 'icon-box-icon' },
					el(
						'i',
						{ className: attrs.icon_class, style: icon_style },
					),
				),

				el(
					'div',
					{ className: 'icon-box-content', style: content_style },
					el( 'h4',
						{
							className: 'icon-box-title',
							style: head_style,
						},
						'mixed' === attrs.type && el(
							'span',
							{ style: figure_style, className: 'icon-box-icon' },
							el(
								'i',
								{ className: attrs.icon_class, style: icon_style },
							),
						),
						attrs.heading,
					),
					el( 'p', {
						className: 'description',
						style: desc_style,
					}, attrs.description ),
				),
			);
		}
	};

	wolmartComponents.WolmartHeading = class WolmartHeading extends Component {
		constructor () {
			super( ...arguments );
		}

		componentDidMount () { }

		componentDidUpdate () { }

		render () {
			var _this = this,
				props = this.props,
				attrs = props.attributes;

			var inspectorControls = el( InspectorControls, {},
				el( PanelBody, {
					title: __( 'Heading' ),
					initialOpen: false,
				},
					el( SelectControl, {
						label: __( 'Heading Tag' ),
						value: attrs.tag,
						options: [
							{ label: __( 'H1' ), value: 'h1' },
							{ label: __( 'H2' ), value: 'h2' },
							{ label: __( 'H3' ), value: 'h3' },
							{ label: __( 'H4' ), value: 'h4' },
							{ label: __( 'H5' ), value: 'h5' },
							{ label: __( 'H6' ), value: 'h6' },
							{ label: __( 'P' ), value: 'p' },
						],
						onChange: ( value ) => { props.setAttributes( { tag: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Font Family ' ),
						value: attrs.family,
						onChange: ( value ) => { props.setAttributes( { family: value } ); },
					} ),
					el(
						'p',
						{ className: 'description' },
						__( 'Comma Seperated Font Families' ),
					),
					el( TextControl, {
						label: __( 'Font Size' ),
						value: attrs.size,
						onChange: ( value ) => { props.setAttributes( { size: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Font Weight (px) ' ),
						type: 'number',
						min: 300,
						value: attrs.weight,
						onChange: ( value ) => { props.setAttributes( { weight: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Letter Spacing ' ),
						value: attrs.ls,
						onChange: ( value ) => { props.setAttributes( { ls: value } ); },
					} ),
					el(
						'p',
						{ className: 'description' },
						__( 'Please Input value + unit. Empty unit will be set to "px".' ),
					),
					el( TextControl, {
						label: __( 'Line Height' ),
						value: attrs.lh,
						onChange: ( value ) => { props.setAttributes( { lh: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Text Align' ),
						value: attrs.content_align,
						options: [{ label: __( 'Left' ), value: 'left' }, { label: __( 'Center' ), value: 'center' }, { label: __( 'Right' ), value: 'right' }],
						onChange: ( value ) => { props.setAttributes( { content_align: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Text Transform' ),
						value: attrs.transform,
						options: [
							{ label: __( 'Default' ), value: 'none' },
							{ label: __( 'UPPERCASE' ), value: 'uppercase' },
							{ label: __( 'lowercase' ), value: 'lowercase' },
							{ label: __( 'Capitalize' ), value: 'capitalize' },
						],
						onChange: ( value ) => { props.setAttributes( { transform: value } ); },
					} ),
					el( 'div',
						{ className: 'dimension' },
						el(
							'h4',
							{},
							__( 'Margin' ),
						),
						el( 'div',
							{ className: 'options' },
							el( TextControl, {
								label: __( 'Top' ),
								value: attrs.mt,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { mt: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Right' ),
								value: attrs.mr,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { mr: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Bottom' ),
								value: attrs.mb,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { mb: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Left' ),
								value: attrs.ml,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { ml: value } ); },
							} ),
						),
					),
					el( PanelColorSettings, {
						title: __( 'Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Color' ),
							value: attrs.col,
							onChange: ( value ) => { props.setAttributes( { col: value } ); },
						}]
					} ),
				),
				el( PanelBody, {
					title: __( 'Heading Style' ),
					initialOpen: false,
				},
					el( SelectControl, {
						label: __( 'Type' ),
						value: attrs.decoration,
						options: [
							{ label: __( 'Simple' ), value: '' },
							// { label: __('Cross'), value: 'title-cross' },
							{ label: __( 'Underline' ), value: 'title-underline' },
						],
						onChange: ( value ) => { props.setAttributes( { decoration: value } ); },
					} ),
					// 'title-cross' === attrs.decoration && el(RangeControl, {
					// 	label: __('Decoration Spacing (px)'),
					// 	min: 0,
					// 	max: 200,
					// 	step: 1,
					// 	value: attrs.decor_space,
					// 	onChange: (value) => { props.setAttributes({ decor_space: value }); },
					// }),
					'title-underline' === attrs.decoration && el( TextControl, {
						label: __( 'Divider Height (px)' ),
						value: attrs.div_active_ht,
						type: 'number',
						onChange: ( value ) => { props.setAttributes( { div_active_ht: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Divider Height (px)' ),
						value: attrs.div_ht,
						type: 'number',
						onChange: ( value ) => { props.setAttributes( { div_ht: value } ); },
					} ),
					el( PanelColorSettings, {
						title: __( 'Divider Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Color' ),
							value: attrs.div_col,
							onChange: ( value ) => { props.setAttributes( { div_col: value } ); },
						}]
					} ),
					el( PanelColorSettings, {
						title: __( 'Divider Active Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Active Color' ),
							value: attrs.div_active_col,
							onChange: ( value ) => { props.setAttributes( { div_active_col: value } ); },
						}]
					} ),
				),
			);

			return [
				inspectorControls,
				this.createHeadingElement(),
			];
		}

		createHeadingElement () {
			var attrs = this.props.attributes,
				h_style = {},
				custom_style = [],
				aclass = [];
			aclass.push( attrs.decoration );
			aclass.push( attrs.content_align );

			h_style['margin'] = attrs.mt + 'px ' + attrs.mr + 'px ' + attrs.mb + 'px ' + attrs.ml + 'px';
			if ( attrs.family ) {
				h_style['fontFamily'] = attrs.family + ',' + jQuery( '.block-editor-block-list__layout' ).css( 'font-family' );
			}
			h_style['fontSize'] = String( attrs.size );
			if ( '' === h_style['fontSize'] ) {
				h_style['fontSize'] = '20';
			}
			if ( !h_style['fontSize'].replace( /[0-9.]/g, '' ) ) {
				h_style['fontSize'] += 'px';
			}
			h_style['fontWeight'] = attrs.weight;
			h_style['lineHeight'] = attrs.lh;
			h_style['color'] = attrs.col;
			h_style['letterSpacing'] = attrs.ls;
			if ( !h_style['letterSpacing'].replace( /[0-9.]/g, '' ) ) {
				h_style['letterSpacing'] += 'px';
			}
			h_style['textTransform'] = attrs.transform;

			if ( 'left' === attrs.content_align ) {
				h_style['justifyContent'] = 'flex-start';
			} else if ( 'right' === attrs.content_align ) {
				h_style['justifyContent'] = 'flex-end';
			} else {
				h_style['justifyContent'] = 'center';
			}

			// if ('title-cross' === attrs.decoration) {
			// 	custom_style.push('#block-' + this.props.clientId + ' .title::before { margin-right:' + attrs.decor_space + 'px; height: ' + attrs.div_ht + 'px; background: ' + (attrs.div_col ? attrs.div_col : '#f4f4f4') + '; }');
			// 	custom_style.push('#block-' + this.props.clientId + ' .title::after { margin-left:' + attrs.decor_space + 'px; height: ' + attrs.div_ht + 'px; background: ' + (attrs.div_col ? attrs.div_col : '#f4f4f4') + '; }');
			// } else
			if ( 'title-underline' === attrs.decoration ) {
				custom_style.push( '#block-' + this.props.clientId + ' .title-underline::after { height: ' + attrs.div_ht + 'px; background: ' + ( attrs.div_col ? attrs.div_col : '#f4f4f4' ) + '; }' );
				if ( attrs.hide_active_underline ) {
					custom_style.push( '#block-' + this.props.clientId + ' .title::after { content: none; }' );
				} else {
					custom_style.push( '#block-' + this.props.clientId + ' .title::after { height: ' + attrs.div_active_ht + 'px; background: ' + ( attrs.div_active_col ? attrs.div_active_col : '#2b579a' ) + '; }' );
				}
			}

			return [el(
				'style',
				{ type: 'text/css' },
				custom_style.join( ' ' ),
			),
			el( 'div',
				{
					className: 'title-wrapper ' + aclass.join( ' ' ),
				},
				el( RichText, {
					className: 'title',
					tagName: attrs.tag,
					style: h_style,
					value: attrs.text,
					onChange: ( value ) => { this.props.setAttributes( { text: value } ); },
				} )
			)];
		}
	};

	wolmartComponents.WolmartButton = class WolmartButton extends Component {
		constructor () {
			super( ...arguments );
		}

		componentDidMount () {
			this.props.attributes.tab = 1;
		}

		componentDidUpdate () { }

		render () {
			var _this = this,
				props = this.props,
				attrs = props.attributes;

			var inspectorControls = el( InspectorControls, {},
				el( PanelBody, {
					title: __( 'Button Content' ),
					initialOpen: false,
				},
					el( TextControl, {
						label: __( 'Text' ),
						value: attrs.text,
						onChange: ( value ) => { props.setAttributes( { text: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Link' ),
						value: attrs.link,
						onChange: ( value ) => { props.setAttributes( { link: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Skin' ),
						value: attrs.preset,
						options: [{ label: __( 'Primary' ), value: 'btn-primary' }, { label: __( 'Secondary' ), value: 'btn-secondary' }, { label: __( 'Warning' ), value: 'btn-warning' }, { label: __( 'Danger' ), value: 'btn-danger' }, { label: __( 'Success' ), value: 'btn-success' }, { label: __( 'Dark' ), value: 'btn-dark' }, { label: __( 'White' ), value: 'btn-white' }],
						onChange: ( value ) => { props.setAttributes( { preset: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Shape' ),
						value: attrs.shape,
						options: [{ label: __( 'Rectangle' ), value: '' }, { label: __( 'Rounded' ), value: 'btn-rounded' }, { label: __( 'Ellipse' ), value: 'btn-ellipse' }],
						onChange: ( value ) => { props.setAttributes( { shape: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Type' ),
						value: attrs.type,
						options: [{ label: __( 'Default' ), value: '' }, { label: __( 'Outline' ), value: 'btn-outline' }, { label: __( 'Solid' ), value: 'btn-solid' }, { label: __( 'Link' ), value: 'btn-link' }],
						onChange: ( value ) => { props.setAttributes( { type: value } ); },
					} ),
					'btn-link' === attrs.type && el( SelectControl, {
						label: __( 'Hover Underline' ),
						value: attrs.link_hover_type,
						options: [{ label: __( 'None' ), value: '' }, { label: __( 'Underline1' ), value: 'btn-underline sm' }, { label: __( 'Underline2' ), value: 'btn-underline' }, { label: __( 'Underline3' ), value: 'btn-underline lg' }],
						onChange: ( value ) => { props.setAttributes( { link_hover_type: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Size' ),
						value: attrs.btn_size,
						options: [{ label: __( 'Small' ), value: 'btn-sm' }, { label: __( 'Medium' ), value: 'btn-md' }, { label: __( 'Normal' ), value: '' }, { label: __( 'Large' ), value: 'btn-lg' }],
						onChange: ( value ) => { props.setAttributes( { btn_size: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Icon Class' ),
						value: attrs.icon_class,
						onChange: ( value ) => { props.setAttributes( { icon_class: value } ); },
					} ),
					el(
						ButtonGroup,
						{ className: "button_tabs" },
						el( 'button', {
							className: 'left' === attrs.icon_pos ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { icon_pos: 'left' } );
							},
						}, __( 'Before' ) ),
						el( 'button', {
							className: 'right' === attrs.icon_pos ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { icon_pos: 'right' } );
							},
						}, __( 'After' ) ),
					),
					el( TextControl, {
						label: __( 'Font Size' ),
						value: attrs.size,
						onChange: ( value ) => { props.setAttributes( { size: value } ); },
					} ),
					el( TextControl, {
						label: __( 'Icon Font Size' ),
						value: attrs.icon_size,
						onChange: ( value ) => { props.setAttributes( { icon_size: value } ); },
					} ),
					el( RangeControl, {
						label: __( 'Icon Margin (px)' ),
						min: 0,
						max: 30,
						step: 1,
						value: attrs.icon_margin,
						onChange: ( value ) => { props.setAttributes( { icon_margin: value } ); },
					} ),
					el( SelectControl, {
						label: __( 'Icon Hover Effect' ),
						value: attrs.icon_hover_effect,
						options: [{ label: __( 'None' ), value: '' }, { label: __( 'Slide left' ), value: 'btn-slide-left' }, { label: __( 'Slide right' ), value: 'btn-slide-right' }, { label: __( 'Slide up' ), value: 'btn-slide-up' }, { label: __( 'Slide down' ), value: 'btn-slide-down' }, { label: __( 'Reveal left' ), value: 'btn-reveal-left' }, { label: __( 'Reveal right' ), value: 'btn-reveal-right' }],
						onChange: ( value ) => { props.setAttributes( { icon_hover_effect: value } ); },
					} ),
					-1 !== String( attrs.icon_hover_effect ).indexOf( 'btn-slide' ) && el( ToggleControl, {
						label: __( 'Animation Infinite' ),
						checked: attrs.icon_infinite,
						onChange: ( checked ) => { props.setAttributes( { icon_infinite: checked } ); },
					} ),
					el( SelectControl, {
						label: __( 'Alignment' ),
						value: attrs.align,
						options: [{ label: __( 'Left' ), value: 'left' }, { label: __( 'Center' ), value: 'center' }, { label: __( 'Right' ), value: 'right' }, { label: __( 'Justify' ), value: 'justify' }],
						onChange: ( value ) => { props.setAttributes( { align: value } ); },
					} ),
				),
				el( PanelBody, {
					title: __( 'Button Style' ),
					initialOpen: false,
				},
					el( 'div',
						{ className: 'dimension' },
						el(
							'h4',
							{},
							__( 'Padding' ),
						),
						el( 'div',
							{ className: 'options' },
							el( TextControl, {
								label: __( 'Top' ),
								value: attrs.pt,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pt: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Right' ),
								value: attrs.pr,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pr: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Bottom' ),
								value: attrs.pb,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pb: value } ); },
							} ),
							el( TextControl, {
								label: __( 'Left' ),
								value: attrs.pl,
								type: 'number',
								min: 0,
								onChange: ( value ) => { props.setAttributes( { pl: value } ); },
							} ),
						),
					),
					el( RangeControl, {
						label: __( 'Border Radius' ),
						min: 0,
						max: 30,
						step: 1,
						value: attrs.border_radius,
						onChange: ( value ) => { props.setAttributes( { border_radius: value } ); },
					} ),
					el(
						ButtonGroup,
						{ className: "button_tabs" },
						el( 'button', {
							className: 1 === attrs.tab ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { tab: 1 } );
							},
						}, __( 'Normal' ) ),
						el( 'button', {
							className: 2 === attrs.tab ? 'active' : '',
							onClick: function onClick () {
								props.setAttributes( { tab: 2 } );
							},
						}, __( 'Hover' ) ),
					),
					1 === attrs.tab && el( PanelColorSettings, {
						title: __( 'Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Color' ),
							value: attrs.col,
							onChange: ( value ) => { props.setAttributes( { col: value } ); },
						}]
					} ),
					1 === attrs.tab && el( PanelColorSettings, {
						title: __( 'Background Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Background Color' ),
							value: attrs.bg_col,
							onChange: ( value ) => { props.setAttributes( { bg_col: value } ); },
						}]
					} ),
					1 === attrs.tab && el( PanelColorSettings, {
						title: __( 'Border Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Border Color' ),
							value: attrs.bd_col,
							onChange: ( value ) => { props.setAttributes( { bd_col: value } ); },
						}]
					} ),
					2 === attrs.tab && el( PanelColorSettings, {
						title: __( 'Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Color' ),
							value: attrs.hover_col,
							onChange: ( value ) => { props.setAttributes( { hover_col: value } ); },
						}]
					} ),
					2 === attrs.tab && el( PanelColorSettings, {
						title: __( 'Background Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Background Color' ),
							value: attrs.hover_bg_col,
							onChange: ( value ) => { props.setAttributes( { hover_bg_col: value } ); },
						}]
					} ),
					2 === attrs.tab && el( PanelColorSettings, {
						title: __( 'Border Color' ),
						initialOpen: false,
						colorSettings: [{
							label: __( 'Border Color' ),
							value: attrs.hover_bd_col,
							onChange: ( value ) => { props.setAttributes( { hover_bd_col: value } ); },
						}]
					} ),
				),
			);

			return [
				inspectorControls,
				this.createButtonElement(),
			];
		}

		createButtonElement () {
			var attrs = this.props.attributes,
				block_style = '',
				b_class = ['btn'],
				b_style = '',
				i_style = '',
				hover_style = '';

			b_class.push( attrs.preset );
			b_class.push( attrs.shape );
			b_class.push( attrs.type );
			if ( 'btn-link' === attrs.type ) {
				b_class.push( attrs.link_hover_type );
			}
			b_class.push( attrs.btn_size );

			if ( attrs.icon_class ) {
				b_class.push( 'btn-icon' + attrs.icon_pos );
				b_class.push( attrs.icon_hover_effect );
				if ( attrs.icon_infinite )
					b_class.push( 'btn-infinite' );
			}

			b_style += 'font-size: ' + ( '' === attrs.size ? '14' : attrs.size );
			if ( !String( attrs.size ).replace( /[0-9.]/g, '' ) ) {
				b_style += 'px';
			}
			b_style += ';';
			if ( '' !== attrs.icon_size ) {
				i_style += 'font-size: ' + attrs.icon_size;
				if ( !String( attrs.icon_size ).replace( /[0-9.]/g, '' ) ) {
					i_style += 'px';
				}
				i_style += ';';
			}
			i_style += 'margin-' + ( 'left' === attrs.icon_pos ? 'right' : 'left' ) + ': ' + attrs.icon_margin + 'px;';
			b_style += 'padding: ' + attrs.pt + 'px ' + attrs.pr + 'px ' + attrs.pb + 'px ' + attrs.pl + 'px' + ';';

			if ( attrs.col || attrs.bg_col || attrs.bd_col || attrs.hover_col || attrs.hover_bg_col || attrs.hover_bd_col ) {
				b_style += 'color: ' + attrs.col + ';' +
					'background-color: ' + attrs.bg_col + ';' +
					'border-color: ' + attrs.bd_col + ';';
				hover_style += 'color: ' + attrs.hover_col + ';' +
					'background-color: ' + attrs.hover_bg_col + ';' +
					'border-color: ' + attrs.hover_bd_col + ';';
			}

			if ( '' !== attrs.border_radius ) {
				b_style += 'border-radius: ' + Number( attrs.border_radius ) + 'px;';
			}

			block_style += 'text-align: ' + attrs.align;
			if ( 'justify' === attrs.align ) {
				b_style += 'width: 100%;';
			}

			return [el(
				'style',
				{ type: 'text/css' },
				'#block-' + this.props.clientId + '{' + block_style + '}',
				'#block-' + this.props.clientId + ' .btn{' + b_style + '}',
				'#block-' + this.props.clientId + ' .btn:hover{' + hover_style + '}',
				'#block-' + this.props.clientId + ' .btn i{' + i_style + '}',
			),
			el(
				'a',
				{ className: b_class.join( ' ' ), href: attrs.link },
				attrs.icon_class && 'left' === attrs.icon_pos && el(
					'i',
					{ className: attrs.icon_class },
				),
				attrs.text,
				attrs.icon_class && 'right' === attrs.icon_pos && el(
					'i',
					{ className: attrs.icon_class },
				),
			)];
		}
	};
}

/* General Functions */

/**
 * Get Responsive Columns
 * @param {object} cols
 * @param {string} type
 * @return {obj} result
 * @since 1.0
 */
function getResponsiveCols ( cols, type = 'product' ) {
	var result = {},
		base = cols['lg'] ? cols['lg'] : 4;

	if ( 6 < base ) { // 7, 8
		if ( !cols['xl'] ) {
			result = {
				'xl': base,
				'lg': 6,
				'md': 4,
				'sm': 3,
				'min': 2,
			}
		} else {
			result = {
				'lg': base,
				'md': 6,
				'sm': 4,
				'min': 3,
			}
		}
	} else if ( 4 < base ) { // 5, 6
		result = {
			'lg': base,
			'md': 4,
			'sm': 3,
			'min': 2,
		}

		if ( !cols['xl'] ) {
			result['xl'] = base;
			result['lg'] = 4;
		}
	} else if ( 2 < base ) { // 3, 4
		result = {
			'lg': base,
			'md': 3,
			'sm': 2,
			'min': 2,
		}

		if ( 'post' == type ) {
			result['min'] = 1;
		}
	} else { // 1, 2
		result = {
			'lg': base,
			'md': base,
			'sm': 1,
			'min': 1,
		}
	}

	for ( var w in cols ) {
		if ( 'lg' != w && cols[w] > 0 ) {
			result[w] = cols[w];
		}
	}

	return result;
}

/**
 * Check Slider Option
 * @param {object} attrs
 * @param {object} prevAttrs
 * @return {boolean}
 * @since 1.0
 */
function isSliderChanged ( attrs, prevAttrs ) {
	if ( attrs.show_nav !== prevAttrs.show_nav
		|| attrs.col_cnt_xl !== prevAttrs.col_cnt_xl
		|| attrs.col_cnt !== prevAttrs.col_cnt
		|| attrs.col_cnt_tablet !== prevAttrs.col_cnt_tablet
		|| attrs.col_cnt_mobile !== prevAttrs.col_cnt_mobile
		|| attrs.col_cnt_min !== prevAttrs.col_cnt_min
		|| attrs.col_sp !== prevAttrs.col_sp
		|| attrs.nav_hide !== prevAttrs.nav_hide
		|| attrs.nav_type !== prevAttrs.nav_type
		|| attrs.nav_pos !== prevAttrs.nav_pos
		|| attrs.show_dots !== prevAttrs.show_dots
		|| attrs.dots_type !== prevAttrs.dots_type
		|| attrs.dots_pos !== prevAttrs.dots_pos
		|| attrs.autoplay !== prevAttrs.autoplay
		|| attrs.autoplay_timeout !== prevAttrs.autoplay_timeout
		|| attrs.loop !== prevAttrs.loop
		|| attrs.pause_onhover !== prevAttrs.pause_onhover
		|| attrs.autoheight !== prevAttrs.autoheight ) {
		return true;
	}
	return false;
}

/**
 * Get Overlay Class
 * @param {string} overlay
 * @return {string}
 * @since 1.0
 */
function getOverlayClass ( overlay ) {
	if ( 'light' === overlay ) {
		return 'overlay-light';
	}
	if ( 'dark' === overlay ) {
		return 'overlay-dark';
	}
	if ( 'zoom' === overlay ) {
		return 'overlay-zoom';
	}
	if ( 'zoom_light' === overlay ) {
		return 'overlay-zoom overlay-light';
	}
	if ( 'zoom_dark' === overlay ) {
		return 'overlay-zoom overlay-dark';
	}
}

/**
 * Get Col Classes
 * @param {obj} col_cnt
 * @return {string}
 * @since 1.0
 */
function getColClass ( col_cnt ) {

	var cls = ' row';

	for ( var w in col_cnt ) {
		if ( col_cnt[w] > 0 ) {
			cls += ' cols-' + ( 'min' != w ? w + '-' : '' ) + col_cnt[w];
		}
	}

	return cls;
}

/**
 * Get Slider Classes
 * @param {obj} attrs
 * @return {string}
 * @since 1.0
 */
function getSliderClass ( attrs ) {
	var extra_class = ' slider-wrapper';
	if ( 'full' === attrs.nav_type ) {
		extra_class += ' slider-nav-full';
	} else {
		if ( 'circle' === attrs.nav_type ) {
			extra_class += ' slider-nav-circle';
		}
		if ( 'top' === attrs.nav_pos ) {
			extra_class += ' slider-nav-top';
		} else if ( 'inner' !== attrs.nav_pos ) {
			extra_class += ' slider-nav-outer';
		}
	}
	if ( attrs.nav_hide ) {
		extra_class += ' slider-nav-fade';
	}

	if ( attrs.dots_type ) {
		extra_class += ' slider-dots-' + attrs.dots_type;
	}

	if ( 'inner' === attrs.dots_pos ) {
		extra_class += ' slider-dots-inner';
	}
	if ( 'outer' === attrs.dots_pos ) {
		extra_class += ' slider-dots-outer';
	}

	if ( 'yes' === attrs.fullheight ) {
		extra_class += ' slider-full-height';
	}

	if ( 'top' === attrs.slider_vertical_align ||
		'middle' === attrs.slider_vertical_align ||
		'bottom' === attrs.slider_vertical_align ||
		'same-height' === attrs.slider_vertical_align ) {
		extra_class += ' ' + attrs.slider_vertical_align;
	}
	return extra_class;
}

/**
 * Get Slider Options
 * @param {obj} attrs
 * @return {string}
 * @since 1.0
 */
function getSliderOptions ( attrs ) {
	var extra_options = {},
		breakpoints = wolmart_gutenberg_vars.breakpoints;
	extra_options["nav"] = attrs.show_nav;
	extra_options["dots"] = attrs.show_dots;
	extra_options["autoplay"] = attrs.autoplay;
	extra_options["autoplayTimeout"] = attrs.autoplay_timeout;
	extra_options["autoplayHoverPause"] = attrs.autoplayHoverPause;
	extra_options["loop"] = attrs.loop;
	extra_options["autoHeight"] = attrs.autoHeight;
	extra_options["items"] = Math.max( Number( attrs.col_cnt ), 1 );

	if ( 'sm' === attrs.col_sp ) {
		extra_options['margin'] = 10;
	}
	else if ( 'lg' === attrs.col_sp ) {
		extra_options['margin'] = 30;
	}
	else if ( 'xs' === attrs.col_sp ) {
		extra_options['margin'] = 2;
	}
	else if ( 'no' === attrs.col_sp ) {
		extra_options['margin'] = 0;
	}
	else {
		extra_options['margin'] = 20;
	}

	var col_cnt = getResponsiveCols( {
		xl: attrs.col_cnt_xl,
		lg: attrs.col_cnt,
		md: attrs.col_cnt_tablet,
		sm: attrs.col_cnt_mobile,
		min: attrs.col_cnt_min,
	} );

	var responsive = {};
	for ( var w in col_cnt ) {
		responsive[breakpoints[w]] = {
			items: col_cnt[w]
		};
	}

	extra_options["responsive"] = responsive;
	return extra_options;
}

/**
 * Init Slider
 * @param {string, object} $selector
 * @param {object} $option
 * @since 1.0
 */
function initSlider ( $selector, $option = {} ) {
	if ( typeof Swiper != 'function' ) {
		return;
	}

	var sliderDefaultOptions = {
		waitForTransition: false,
		rewind: true,
		direction: Wolmart.$body.hasClass( 'rtl' ) ? 'rtl' : 'ltr',
		updateOnMove: true
	}

	if ( $selector.length ) {
		var pluginOptions = $selector.attr( 'data-plugin-options' );

		if ( typeof pluginOptions === 'string' ) {
			pluginOptions = JSON.parse( pluginOptions.replace( /'/g, '"' ).replace( ';', '' ) );
		}

		var settings = jQuery.extend( true, {}, sliderDefaultOptions, pluginOptions );
		settings = jQuery.extend( true, {}, settings, $option )

		$selector.imagesLoaded( function () {
			Wolmart.slider( $selector, settings );
		} );
	}
}

/**
 * Init Isotope Grid
 * @param {string, object} $selector
 * @since 1.0
 */
function initIsotopes ( $selector ) {
	if ( !jQuery.fn.isotope ) {
		return;
	}

	var isotopeDefaultOptions = {
		itemsSelector: '.grid-item',
		layoutMode: 'masonry',
		percentPosition: true,
		masonry: {
			columnWidth: '.grid-space',
		}
	};

	if ( $selector ) {
		var pluginOptions = $selector.data( 'grid-options' );

		if ( typeof pluginOptions === 'string' ) {
			pluginOptions = JSON.parse( pluginOptions.replace( /'/g, '"' ).replace( ';', '' ) );
		}

		var newSettings = jQuery.extend( true, {}, isotopeDefaultOptions, pluginOptions );

		$selector.imagesLoaded( function () {
			$selector.isotope( newSettings );
		} );
	}

	$selector.find( '.slider-wrapper' ).on( 'resize', function ( e ) {
		$selector.isotope( 'layout' );
	} );

	$selector.siblings( '.tabs' ).on( 'click', '.tab-link', function ( e ) {
		e.preventDefault();
		var filterValue = jQuery( this ).data( 'cat_id' );

		$selector.css( 'min-height', $selector.find( '.grid-item' ).outerHeight() );
		$selector.isotope( { filter: filterValue } );

		jQuery( this ).parents( 'li' ).siblings().removeClass( 'active' );
		jQuery( this ).parents( 'li' ).addClass( 'active' );
	} )
}

/**
 * Make Product Effect
 * @param {string, object} $selector
 * @since 1.0
 */
function productManage ( $selector ) {
	if ( $selector.find( '.product-popup' ) ) {
		jQuery( '.product-popup .product-details' ).each( function ( e ) {
			var $this = jQuery( this ),
				hidden_height = $this.find( '.product-hide-details' ).outerHeight( true );

			$this.height( $this.height() - hidden_height );
		} );

		$selector.find( '.product' )
			.on( 'mouseenter touchstart', function ( e ) {
				var $this = jQuery( this ),
					hidden_height = $this.find( '.product-hide-details' ).outerHeight( true );

				if ( $this.hasClass( 'product-popup' ) ) {
					// if boxed product
					$this.find( '.product-details' ).css( 'transform', 'translateY(' + ( $this.hasClass( 'product-boxed' ) ? 11 - hidden_height : -hidden_height ) + 'px)' );
					$this.find( '.product-hide-details' ).css( 'transform', 'translateY(' + ( -hidden_height ) + 'px)' );
				}
			} )
			.on( 'mouseleave touchleave', function ( e ) {
				var $this = jQuery( this );

				if ( $this.hasClass( 'product-popup' ) ) {
					$this.find( '.product-details' ).css( 'transform', 'translateY(0)' );
					$this.find( '.product-hide-details' ).css( 'transform', 'translateY(0)' );
				}
			} );
	} else {
		$this.find( '.product-details' ).css( 'height', '' );
		$this.find( '.product-details' ).css( 'transform', '' );
	}
}

/**
 * Get preset Wolmart layout.
 * @param {integer} $index
 * @returns {object}
 * @since 1.0
 */
function wolmart_creative_layout ( $index ) {
	$layout = [];
	if ( 1 === $index ) {
		$layout = [
			{ 'col': '6', 'h': '1', },
			{ 'col': '3', 'h': '1-2', },
			{ 'col': '3', 'h': '1-2', },
			{ 'col': '6', 'h': '1-2', },
		];
	} else if ( 2 === $index ) {
		$layout = [
			{ 'col': '6', 'h': '1', },
			{ 'col': '3', 'h': '1-2', },
			{ 'col': '3', 'h': '1', },
			{ 'col': '3', 'h': '1-2', },
		];
	} else if ( 3 === $index ) {
		$layout = [
			{ 'col': '6', 'h': '2-3', },
			{ 'col': '3', 'h': '1-3', },
			{ 'col': '3', 'h': '1-3', },
			{ 'col': '3', 'h': '1-3', },
			{ 'col': '3', 'h': '1-3', },
			{ 'col': '6', 'h': '1-3', },
			{ 'col': '3', 'h': '1-3', },
			{ 'col': '3', 'h': '1-3', },
		];
	} else if ( 4 === $index ) {
		$layout = [
			{ 'col': '3', 'h': '1-2', },
			{ 'col': '5', 'h': '1-2', },
			{ 'col': '4', 'h': '1', },
			{ 'col': '5', 'h': '1-2', },
			{ 'col': '3', 'h': '1-2', },
		];
	} else if ( 5 === $index ) {
		$layout = [
			{ 'col': '8', 'h': '1', },
			{ 'col': '4', 'h': '1-3', },
			{ 'col': '4', 'h': '1-3', },
			{ 'col': '4', 'h': '1-3', },
		];
	} else if ( 6 === $index ) {
		$layout = [
			{ 'col': '8', 'h': '1', },
			{ 'col': '4', 'h': '1-2', },
			{ 'col': '4', 'h': '1-2', },
		];
	} else if ( 7 === $index ) {
		$layout = [
			{ 'col': '3', 'h': '1', },
			{ 'col': '6', 'h': '1-2', },
			{ 'col': '6', 'h': '1-2', },
			{ 'col': '3', 'h': '1', },
		];
	} else if ( 8 === $index ) {
		$layout = [
			{ 'col': '6', 'h': '2-3', },
			{ 'col': '6', 'h': '1-3', },
			{ 'col': '6', 'h': '2-3', },
			{ 'col': '6', 'h': '1-3', },
		];
	} else if ( 9 === $index ) {
		$layout = [
			{ 'col': '8', 'h': '2-3', },
			{ 'col': '4', 'h': '2-3', },
			{ 'col': '6', 'h': '1-3', },
			{ 'col': '6', 'h': '1-3', },
		];
	} else if ( 10 === $index ) {
		$layout = [
			{ 'col': '6', 'h': '2-3', },
			{ 'col': '3', 'h': '1-3', },
			{ 'col': '3', 'h': '1-3', },
			{ 'col': '3', 'h': '1-3', },
			{ 'col': '3', 'h': '1-3', },
			{ 'col': '6', 'h': '1-3', },
			{ 'col': '3', 'h': '1-3', },
			{ 'col': '3', 'h': '1-3', },
		];
	} else if ( 11 === $index ) {
		$layout = [
			{ 'col': '3', 'h': '1-2', },
			{ 'col': '5', 'h': '1-2', },
			{ 'col': '4', 'h': '1', },
			{ 'col': '5', 'h': '1-2', },
			{ 'col': '3', 'h': '1-2', },
		];
	}
	return $layout;
}