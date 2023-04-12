/**
 * Wolmart Dependent Plugin - ProductVideoPopup
 *
 * @package Wolmart WordPress Theme
 * @version 1.0
 */

'use strict';

window.Wolmart || ( window.Wolmart = {} );

( function ( $ ) {
	function openVideoPopup ( e ) {
		e.preventDefault();

		Wolmart.popup( {
			type: 'inline',
			mainClass: "product-popupbox product-video-popup wm-fade",
			preloader: false,
			items: {
				src: wolmart_vars.wvideo_data
			},
			callbacks: {
				open: function () {
					Wolmart.AjaxLoadPost.fitVideos( this.container );
				}
			}
		} );
	}

	Wolmart.$window.on( 'wolmart_complete', function () {
		if ( $.fn.fitVids && typeof wolmart_vars.wvideo_data && wolmart_vars.wvideo_data ) {
			Wolmart.$body.on( 'click', '.open-product-video-viewer', openVideoPopup );
		}
	} );
} )( jQuery );
