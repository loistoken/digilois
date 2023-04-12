/**
 * Wolmart Dependent Plugin - ProductThreeSixtyViewer
 *
 * @package Wolmart WordPress Theme
 * @requires threesixty-slider
 * @version 1.0
 */

'use strict';

window.Wolmart || (window.Wolmart = {});

(function ($) {

	function open360DegreeView(e) {
		e.preventDefault();
		Wolmart.popup({
			type: 'inline',
			mainClass: "product-popupbox wm-fade product-360-popup",
			preloader: false,
			items: {
				src: '<div class="product-gallery-degree">\
						<div class="w-loading"><i></i></div>\
						<ul class="product-degree-images"></ul>\
					</div>'
			},
			callbacks: {
				open: function () {
					var images = wolmart_vars.threesixty_data.split(',');
					this.container.find('.product-gallery-degree').ThreeSixty({
						totalFrames: images.length,
						endFrame: images.length,
						currentFrame: images.length - 1,
						imgList: this.container.find('.product-degree-images'),
						progress: '.w-loading',
						imgArray: images,
						// speedMultiplier: 1,
						// monitorInt: 1,
						speed: 10,
						height: 500,
						width: 830,
						navigation: true
					});
				},
				beforeClose: function () {
					this.container.empty();
				}
			}
		});
	}

	Wolmart.$window.on('wolmart_complete', function () {
		if ($.fn.ThreeSixty && wolmart_vars.threesixty_data && wolmart_vars.threesixty_data.length) {
			$(document.body).on('click', '.open-product-degree-viewer', open360DegreeView);
		}
	});
})(jQuery);
