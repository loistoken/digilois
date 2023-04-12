/**
 * Wolmart Plugin - LiveSearch
 * 
 * @requires jquery.autocomplete
 */
'use strict';
window.Wolmart || (window.Wolmart = {});

(function ($) {
	function LiveSearch(e, $selector) {
		if (!$.fn.devbridgeAutocomplete) {
			return;
		}

		if ('undefined' == typeof $selector) {
			$selector = $('.search-wrapper');
		} else {
			$selector = $selector;
		}

		$selector.each(function () {
			var $this = $(this),
				appendTo = $this.find('.live-search-list'),
				searchCat = $this.find('.cat'),
				postType = $this.find('input[name="post_type"]').val(),
				serviceUrl = wolmart_vars.ajax_url + '?action=wolmart_ajax_search&nonce=' +
					wolmart_vars.nonce + (postType ? '&post_type=' + postType : '');

			$this.find('input[type="search"]').devbridgeAutocomplete({
				minChars: 3,
				appendTo: appendTo,
				triggerSelectOnValidInput: false,
				serviceUrl: serviceUrl,
				onSearchStart: function () {
					$this.addClass('skeleton-body');
					appendTo.children().eq(0)
						.html(wolmart_vars.skeleton_screen ? '<div class="skel-pro-search"></div><div class="skel-pro-search"></div><div class="skel-pro-search"></div>' : '<div class="w-loading"><i></i></div>')
						.css({ position: 'relative', display: 'block' });
				},
				onSelect: function (item) {
					if (item.id != -1) {
						window.location.href = item.url;
					}
				},
				onSearchComplete: function (q, suggestions) {
					if (!suggestions.length) {
						appendTo.children().eq(0).hide();
					}
				},
				beforeRender: function (container) {
					$(container).removeAttr('style');
				},
				formatResult: function (item, currentValue) {
					var pattern = '(' + $.Autocomplete.utils.escapeRegExChars(currentValue) + ')',
						html = '';
					if (item.img) {
						html += '<img class="search-image" src="' + item.img + '">';
					}
					html += '<div class="search-info">';
					html += '<div class="search-name">' + item.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') + '</div>';
					if (item.price) {
						html += '<span class="search-price">' + item.price + '</span>';
					}
					html += '</div>';

					return html;
				}
			});

			if (searchCat.length) {
				var searchForm = $this.find('input[type="search"]').devbridgeAutocomplete();
				searchCat.on('change', function (e) {
					if (searchCat.val() && searchCat.val() != '0') {
						searchForm.setOptions({
							serviceUrl: serviceUrl + '&cat=' + searchCat.val()
						});
					} else {
						searchForm.setOptions({
							serviceUrl: serviceUrl
						});
					}

					searchForm.hide();
					searchForm.onValueChange();
				});
			}
		});
	}

	Wolmart.liveSearch = LiveSearch;
	$(window).on('wolmart_complete', Wolmart.liveSearch);
})(jQuery);