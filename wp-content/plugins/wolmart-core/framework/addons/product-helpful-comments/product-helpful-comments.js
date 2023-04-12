/**
 * Wolmart Dependent Plugin - Product Helpful Comments
 * 
 * @since 1.1
 */

'use script';

window.Wolmart || (window.Wolmart = {});

(function ($) {
    var ProductHelpfulComments = {
        action: 'wolmart_get_comments',

        post_id: null, // Product Id
        mode: 'all',   // Filter mode
        page: 1,    // Current page

        $tabs: null, // Tabs
        $pagination: null, // Pagination
        $panel: null, // Target panel
        $activePanel: null, // Active panel

        // Store previously feteched data
        cache: {},

        /**
         * Initialize
         *
         * @since 1.1
         */
        init: function () {
            this.$tabs = $('.woocommerce-Reviews .nav-tabs');
            this.$pagination = $('.woocommerce-Reviews .pagination');

            this.post_id = this.$tabs.data('post_id');

            // Register events.
            $('body')
                .on('click', '.woocommerce-Reviews .nav-link', this.filterComments)
                .on('click', '.woocommerce-Reviews .woocommerce-pagination .page-numbers', this.changePage)
                .on('click', '.review-vote .comment_help, .review-vote .comment_unhelp', this.onVoteComment);
        },

        /**
         * Filter Comments
         *  
         * @since 1.1
         */
        filterComments: function (e) {
            var $link = $(this);

            // if tab is loading, return
            if (ProductHelpfulComments.$tabs.hasClass('loading')) {
                return;
            }

            // get href
            var href = 'SPAN' == this.tagName ? $link.data('href') : $link.attr('href');

            // get panel
            if ('#' == href) {
                ProductHelpfulComments.$panel = $link.closest('.nav').siblings('.tab-content').children('.tab-pane').eq($link.parent().index());
            } else {
                ProductHelpfulComments.$panel = $(('#' == href.substring(0, 1) ? '' : '#') + href);
            }
            if (!ProductHelpfulComments.$panel.length) {
                return;
            }

            e.preventDefault();

            ProductHelpfulComments.$activePanel = ProductHelpfulComments.$panel.parent().children('.active');

            if ($link.hasClass("active") || !href) {
                return;
            }
            // change active link
            ProductHelpfulComments.$tabs.find('.active').removeClass('active');
            $link.addClass('active');

            // load tab pane ajax

            ProductHelpfulComments.mode = $link.data('mode');
            ProductHelpfulComments.page = 1;

            ProductHelpfulComments.getComments();
        },

        /**
         * Change page of comments
         * @since 1.1
         */
        changePage: function (e) {
            var $number = $(this);
            var url = $number.attr('href');

            e.preventDefault();

            if ($number.hasClass('prev')) {
                ProductHelpfulComments.page = parseInt($number.siblings('.current').text()) - 1;
            } else if ($number.hasClass('next')) {
                ProductHelpfulComments.page = parseInt($number.siblings('.current').text()) + 1;
            } else {
                ProductHelpfulComments.page = parseInt($number.text());
            }

            ProductHelpfulComments.$panel = ProductHelpfulComments.$activePanel = ProductHelpfulComments.$tabs.siblings('.tab-content').children('.active');

            ProductHelpfulComments.getComments(url);
        },

        /**
         * Get comments 
         *
         * @since 1.1
         */
        getComments: function (targetURL = '') {
            if (!ProductHelpfulComments.cache[ProductHelpfulComments.mode]) {
                ProductHelpfulComments.cache[ProductHelpfulComments.mode] = {};
            }

            var cacheData = ProductHelpfulComments.cache[ProductHelpfulComments.mode];
            var page = ProductHelpfulComments.page;

            if (cacheData && cacheData[page]) {
                var pageData = cacheData[page];
                if (!pageData['html'].trim() && ProductHelpfulComments.$panel.data('empty')) {
                    ProductHelpfulComments.$panel.html(ProductHelpfulComments.$panel.data('empty'))
                } else {
                    ProductHelpfulComments.$panel.html(pageData['html']);
                }
                ProductHelpfulComments.$pagination.html(pageData['pagination']);
                ProductHelpfulComments.changeTab();
            } else {
                ProductHelpfulComments.$tabs.addClass('loading');
                ProductHelpfulComments.$activePanel.addClass('loading');
                ProductHelpfulComments.$pagination && Wolmart.doLoading(ProductHelpfulComments.$pagination, 'small');

                $.post(
                    wolmart_vars.ajax_url,
                    {
                        action: this.action,
                        nonce: wolmart_vars.nonce,
                        post_id: this.post_id,
                        mode: this.mode,
                        page: this.page
                    },
                    function ({ html: sorted_comments, pagination }) {
                        cacheData || (cacheData = {});
                        cacheData[page] || (cacheData[page] = {});
                        cacheData[page] = {
                            html: sorted_comments,
                            pagination
                        };

                        ProductHelpfulComments.$pagination && Wolmart.endLoading(ProductHelpfulComments.$pagination);
                        ProductHelpfulComments.$activePanel.removeClass('loading')
                        ProductHelpfulComments.$tabs.removeClass('loading');

                        if (!sorted_comments.trim() && ProductHelpfulComments.$panel.data('empty')) {
                            ProductHelpfulComments.$panel.html(ProductHelpfulComments.$panel.data('empty'))
                        } else {
                            ProductHelpfulComments.$panel.html(sorted_comments);
                        }
                        ProductHelpfulComments.$pagination.html(pagination);

                        ProductHelpfulComments.changeTab();

                        if (targetURL) {
                            history.pushState({}, '', targetURL);
                        }
                    }
                );
            }
        },

        /**
         * Change Tab Content 
         *
         * @since 1.1
         */
        changeTab: function () {
            Wolmart.loadTemplate(this.$panel);
            Wolmart.slider(this.$panel.find('.slider-wrapper'));
            this.$activePanel.removeClass('in active');
            this.$panel.addClass('active in');
            Wolmart.refreshLayouts();
        },

        /**
         * Event handler to evaluate helpful or unhelpful comments.
         * 
         * @since 1.0
         * @param {Event} e 
         */
        onVoteComment: function (e) {
            var $this = $(this);
            var commentId = $this.data('comment_id');
            var iconClass = $this.hasClass('comment_help') ? 'fa-thumbs-up' : 'fa-thumbs-down';

            if ($this.hasClass('already_comment')) {
                $this.parent().children('.already_vote').fadeIn().fadeOut(1000);
            } else {
                $this.addClass('already_comment').parent().find('.comment_unhelp').addClass('already_comment');
                $('#wolmart_review_vote-' + commentId + ' .' + iconClass).removeClass(iconClass).addClass('fa-spinner fas');

                $.post(wolmart_vars.ajax_url, {
                    action: 'comment_vote',
                    nonce: wolmart_vars.nonce,
                    comment_id: commentId,
                    commentvote: $this.hasClass('comment_help') ? 'plus' : 'minus'
                }, function (response) {
                    ProductHelpfulComments.$activePanel = ProductHelpfulComments.$tabs.siblings('.tab-content').children('.active');

                    if (response === 'updated') {
                        ProductHelpfulComments.$activePanel.find('#wolmart_review_vote-' + commentId + ' .fa-spinner').removeClass('fa-spinner fas').addClass(iconClass);
                        ProductHelpfulComments.$activePanel.find('#comment' + ($this.hasClass('comment_help') ? '' : 'un') + 'help-count-' + commentId).text($this.data('count') + 1);
                    } else if (response === 'voted') {
                        ProductHelpfulComments.$activePanel.find('#wolmart_review_vote-' + commentId + ' .fa-spinner').removeClass('fa-spinner fas').addClass(iconClass);
                        $this.parent().children('.already_vote').fadeIn().fadeOut(1000);
                    }
                })

            }
        }
    }

    Wolmart.ProductHelpfulComments = ProductHelpfulComments;

    Wolmart.$window.on('wolmart_complete', function () {
        Wolmart.ProductHelpfulComments.init();
    });
})(jQuery);