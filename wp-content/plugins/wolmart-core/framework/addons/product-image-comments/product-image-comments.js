/**
 * Wolmart Dependent Plugin - CommentWithImage
 */

'use script';

window.Wolmart || (window.Wolmart = {});

(function ($) {
    var CommentWithImage = {
        /**
         * Initialize
         * @since 1.0
         */
        init: function () {
            // Add enctype to comment form to upload file
            $('form.comment-form').attr('enctype', 'multipart/form-data');

            // Register events.
            $('body')
                .on('change', '.comment-form #wolmart-add-image', CommentWithImage.showImageCount)
                .on('submit', '.comment-form', CommentWithImage.checkValidate)
                .on('click', '.review-images img', CommentWithImage.openLightBox);
        },
        /**
         * Show image count
         * @param {Event} e 
         */
        showImageCount: function (e) {
            $('.wolmart-comment-images span').text(e.target.files.length);
        },

        checkValidate: function (e) {
            var $input = $('#wolmart-add-image');

            if (!$input.length) {
                return;
            }

            var is_large = false, is_not_allowed_mime = false;

            if ($input[0].files.length > wolmart_product_image_comments.max_count) {
                alert(wolmart_product_image_comments.error_msg['count_error']);
                e.preventDefault();
                return;
            }

            console.log($input[0].files);

            $input[0].files.forEach(function (file) {
                var size = file.size;
                var type = String(file.type);

                if (size > wolmart_product_image_comments.max_size) {
                    is_large = true;
                }

                if ($.inArray(type, wolmart_product_image_comments.mime_types) < 0) {
                    is_not_allowed_mime = true;
                }
            });

            if (is_not_allowed_mime) {
                alert(wolmart_product_image_comments.error_msg['mime_type_error']);
                e.preventDefault();
                return;
            }

            if (is_large) {
                alert(wolmart_product_image_comments.error_msg['size_error']);
                e.preventDefault();
                return;
            }
        },

        openLightBox: function (e) {
            e.preventDefault();
            var $img = $(e.currentTarget);
            var images = $img.parent().children().map(function () {
                return {
                    src: this.getAttribute('data-img-src'),
                    w: this.getAttribute('data-img-width'),
                    h: this.getAttribute('data-img-height'),
                    title: this.getAttribute('alt') || ''
                };
            }).get();

            if (typeof PhotoSwipe !== 'undefined') {
                var pswpElement = $('.pswp')[0];
                var photoSwipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, images, {
                    index: $img.index(),
                    closeOnScroll: false
                });
                // show image at first.
                photoSwipe.listen('afterInit', function () {
                    photoSwipe.shout('initialZoomInEnd');
                });
                photoSwipe.init();
            }
        }
    }

    Wolmart.CommentWithImage = CommentWithImage;

    Wolmart.$window.on('wolmart_complete', function () {
        Wolmart.CommentWithImage.init();
    });
})(jQuery);