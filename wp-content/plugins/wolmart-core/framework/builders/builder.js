/**
 * Wolmart Core Admin Library
 * 
 * @package Wolmart Core WordPress plugin
 * @since 1.0
 */
'use strict';
window.WolmartCoreAdmin || (window.WolmartCoreAdmin = {});

/**
 * Metabox Management
 * - show/hide metaboxes when post format is changed
 */
(function ($) {
    // Public Properties
    WolmartCoreAdmin.Metabox = function () {
        var initColorPicker = function () {
            if ($.fn.wpColorPicker) {
                $('input.wolmart-color-picker').wpColorPicker();
            }
        };

        var changePostFormat = function () {
            //media embed code area
            var post_type = $('.editor-post-format select');

            if (post_type == 'video') {
                $('#featured_video').closest('.rwmb-field').removeClass('hidden');
                $('[name="supported_images"]').closest('.rwmb-field').addClass('hidden');
            } else {
                $('#featured_video').closest('.rwmb-field').addClass('hidden');
                $('[name="supported_images"]').closest('.rwmb-field').removeClass('hidden');
            }
        };

        $(window).on('load', changePostFormat);
        $(window).on('load', initColorPicker);
        $('body').on('change', '.editor-post-format select', changePostFormat);
    }

    /**
     * Sidebar Builder
     * - register new sidebar
     * - remove registered sidebar
     */
    WolmartCoreAdmin.Sidebar = function () {
        var addSidebar = function () {
            var name = prompt("Widget Area Name"),
                slug = '',
                maxnum = -1,
                $this = $(this);

            if (!name) {
                return;
            }

            $this.attr('disabled', 'disabled');

            slug = name.toLowerCase().replace(/(\W|_)+/g, '-');
            if ('-' == slug[0] && '-' == slug[slug.length - 1]) {
                slug = slug.slice(1, -1);
            } else if ('-' == slug[0]) {
                slug = slug.slice(1);
            } else if ('-' == slug[slug.length - 1]) {
                slug = slug.slice(0, -1);
            }
            if (wolmart_core_vars.sidebars) {
                var slugs = Object.keys(wolmart_core_vars.sidebars);
                slugs.forEach(function (item) {
                    if (0 === item.indexOf(slug)) {
                        var num = item.replace(slug, '');

                        if ('' == num) {
                            maxnum = Math.max(maxnum, 0);
                        } else if (Number(num.slice(1))) {
                            maxnum = Math.max(maxnum, Number(num.slice(1)));
                        }
                    }
                })
            }

            if (maxnum >= 0) {
                slug = slug + '-' + (maxnum + 1);
            }

            $.ajax({
                url: wolmart_core_vars.ajax_url,
                data: {
                    action: 'wolmart_add_widget_area',
                    nonce: wolmart_core_vars.nonce,
                    name: name,
                    slug: slug
                },
                type: 'post',
                success: function (response) {
                    wolmart_core_vars.sidebars[slug] = name;

                    $('<tr id="' + slug + '" class="sidebar"><td class="title column-title">' + name + '</td><td class="slug column-slug">' + slug + '</td><td class="remove column-remove"><a href="#">Remove</a></td></tr>')
                        .appendTo($('#sidebar_table tbody#the-list'))
                        .hide().fadeIn();

                    $this.removeAttr('disabled');
                }
            }).fail(function (response) {
                console.log(response);
            });
        };

        var removeSidebar = function () {
            if (!confirm("Do you want to remove this sidebar?")) {
                return;
            }

            var $this = $(this),
                slug = $this.closest('tr').find('.column-slug').text();

            $.ajax({
                url: wolmart_core_vars.ajax_url,
                data: {
                    action: 'wolmart_remove_widget_area',
                    nonce: wolmart_core_vars.nonce,
                    slug: slug
                },
                type: 'post',
                success: function (response) {
                    delete wolmart_core_vars.sidebars[slug];

                    $this.closest('tr').fadeOut(function () {
                        $(this).remove();
                    });

                    $this.removeAttr('disabled');
                }
            }).fail(function (response) {
                console.log(response);
            });
        };

        $('body').on('click', '.wolmart-wrap #add_widget_area', addSidebar);
        $('body').on('click', '#sidebar_table .column-remove > a', removeSidebar);
    }

    /**
     * Template Wizard
     * - show template wizard popup before you create a new template
     * - start from prebuilt template or blank
     */
    WolmartCoreAdmin.TemplateWizard = (function () {

        function moveInsideAdminPanel() {
            $('#wpbody-content .wrap:not(.wolmart-admin-notices)').prependTo($('#wpbody-content .templates-builder'));
            $('div.updated, div.error, div.notice').not('.inline, .below-h2').appendTo($('.wolmart-admin-notices'));
        }
        function closeModalByClickOverlay() {
            closeModal($(this).next('.wolmart-modal'));
        }

        function closeModalByClickCloseButton() {
            closeModal($(this).parent('.wolmart-modal'));
        }

        function openModal(selector) {
            var $modal = $(selector);
            $modal = $modal.add($modal.prev('.wolmart-modal-overlay'));

            $modal.addClass('wolmart-modal-open');
            setTimeout(function () {
                $modal.addClass('wolmart-modal-fade');
            });
        }

        function closeModal($modal) {
            $modal = $modal.add($modal.prev('.wolmart-modal-overlay'));

            $modal.removeClass('wolmart-modal-fade');
            setTimeout(function () {
                $modal.removeClass('wolmart-modal-open');
            }, 50);
            // $modal
            //     .removeClass('wolmart-modal-open').removeClass('wolmart-modal-fade')
            //     .prev('.wolmart-modal-overlay')
            //     .removeClass('wolmart-modal-open').removeClass('wolmart-modal-fade');
        }

        function showTemplateWizard(e) {

            e.preventDefault();

            openModal('#wolmart_new_template');

            $('#wolmart-new-template-id').add('#wolmart-new-template-type').add('#wolmart-new-template-name').val('');

            // $.magnificPopup.open({
            //     type: 'inline',
            //     mainClass: "wolmart-modal mfp-fade",
            //     preloader: false,
            //     removalDelay: 350,
            //     autoFocusLast: false,
            //     showCloseBtn: true,
            //     items: {
            //         src: '#wolmart_new_template'
            //     },
            //     callbacks: {
            //         open: function () {
            //             $('html').css('overflow', 'hidden');
            //             $('body').css('overflow-x', 'visible');
            //             $('.mfp-wrap').css('overflow', 'hidden auto');
            //             $('.wolmart-modal .template-name').val('').trigger('focus');
            //             $('#wolmart-new-template-id').add('#wolmart-new-template-type').add('#wolmart-new-template-name').val('');
            //         },
            //         close: function () {
            //             $('html').css('overflow-y', '');
            //             $('body').css('overflow-x', 'hidden');
            //             $('.mfp-wrap').css('overflow', '');
            //         }
            //     }
            // });
        };

        function createNewTemplate(e) {
            var name = $('.wolmart-modal .template-name').val();
            if (!name) {
                $('.wolmart-modal .template-name').focus();
                return;
            }

            $.ajax({
                url: wolmart_core_vars.ajax_url,
                data: {
                    action: 'wolmart_save_template',
                    nonce: wolmart_core_vars.nonce,
                    type: $('.wolmart-modal .template-type').val(),
                    name: name,
                    template_id: $('#wolmart-new-template-id').val(),
                    template_type: $('#wolmart-new-template-type').val(),
                    template_category: $('.wolmart-new-template-form .template-type').val()
                },
                type: 'post',
                success: function (response) {
                    var post_id = parseInt(response.data);
                    window.location.href = $('.wolmart-add-new-template')
                        .attr('href')
                        .replace(
                            'edit.php?post_type=wolmart_template',
                            $('#wolmart-new-template-id').val() ? (
                                $('#wolmart-elementor-studio').is(':checked') ?
                                    'post.php?post=' + post_id + '&action=elementor' :
                                    'post.php?post=' + post_id + '&action=edit&vcv-action=frontend&vcv-source-id=' + post_id
                            ) : 'post.php?post=' + post_id + '&action=edit&post_type=wolmart_template'
                        );
                }
            }).fail(function (response) {
                console.log(response);
            });
        };

        function triggerCreateAction(e) {
            if (13 == e.keyCode && $('.wolmart-modal #wolmart-create-template-type').length) {
                createNewTemplate();
                return;
            }
        };

        return {
            init: function () {
                setTimeout(moveInsideAdminPanel, 300);

                $(document.body)
                    .on('click', '.wolmart-add-new-template', showTemplateWizard)
                    .on('click', '.wolmart-modal-close', closeModalByClickCloseButton)
                    .on('click', '.wolmart-modal-overlay', closeModalByClickOverlay)
                    .on('click', '.wolmart-modal #wolmart-create-template-type', createNewTemplate)
                    .on('keydown', triggerCreateAction)
            }
        }
    })();

    /**
     * Page Builder Addons
     * - studio
     * - template condition
     */
    WolmartCoreAdmin.BuilderAddons = function () {
        var insertElementorAddons = function () {
            if ($(document.body).hasClass('elementor-editor-active') && typeof elementor != 'undefined') {
                elementor.on('panel:init', function () {
                    var content = '<div id="wolmart-elementor-addons" class="elementor-panel-footer-tool tooltip-target">\
                        <span class="wolmart-elementor-addons-toggle" data-tooltip="' + wolmart_core_vars.texts.elementor_addon_settings + '">\
                        <i class="wolmart-mini-logo"></i></span><div class="dropdown-box"><ul class="options">';

                    if (wolmart_core_vars.builder_addons.length) {
                        wolmart_core_vars.builder_addons.forEach(function (value) {
                            if (value['elementor']) {
                                content += value['elementor'];
                            }
                        });
                    }

                    content += '</ul></div></div>';
                    $(content).insertAfter('#elementor-panel-footer-saver-preview')
                        .find('.wolmart-elementor-addons-toggle').tipsy({
                            gravity: 's',
                            title: function title() {
                                return this.getAttribute('data-tooltip');
                            }
                        });
                });


                elementor.on('document:loaded', function () {
                    $('body')
                        // Show Wolmart Elementor Addon
                        .on('click', '.wolmart-elementor-addons-toggle', function (e) {
                            $(this).siblings('.dropdown-box').toggleClass('show');
                        })
                        .on('click', function (e) {
                            $('#wolmart-elementor-addons .dropdown-box').removeClass('show');
                        })
                        .on('click', '#wolmart-elementor-addons', function (e) {
                            e.stopPropagation();
                        })
                        .on('click', '#wolmart-custom-css', function (e) { // open custom css code panel
                            $('#elementor-panel-footer-settings').trigger('click');
                            $('.elementor-tab-control-advanced a').trigger('click');
                            // setTimeout(function () {
                            //     $('.elementor-control-wolmart_custom_css_settings .elementor-panel-heading').trigger('click');
                            // }, 100);
                        })
                        .on('click', '#wolmart-custom-js', function (e) { // open custom js code panel
                            $('#elementor-panel-footer-settings').trigger('click');
                            $('.elementor-tab-control-advanced a').trigger('click');
                            setTimeout(function () {
                                $('.elementor-control-wolmart_custom_js_settings .elementor-panel-heading').trigger('click');
                            }, 100);
                        })
                        .on('click', '#wolmart-edit-area', function (e) { // open edit area resize panel
                            $('#elementor-panel-footer-settings').trigger('click');
                            $('.elementor-control-wolmart_edit_area .elementor-section-toggle').trigger('click');
                        })
                })
            }
        };

        var insertWPBAddons = function () {
            if ($(document.body).hasClass('vc_editor vc_inline-shortcode-edit-form') || $('#post-body #wpb_visual_composer').length) {
                // Wolmart WPBakery Addons

                var initPopupOptionsPanel = function () {
                    var changePopupOptions = function () {
                        if (!vc.$frame_body) {
                            vc.wolmart_popup_options_view.hide();
                            return;
                        }

                        var $wrapper = $(this).closest('.vc_ui-wolmart-panel'),
                            width = $wrapper.find('#vc_popup-width-field').val(),
                            hPos = $wrapper.find('#vc_popup-h_pos-field').val(),
                            vPos = $wrapper.find('#vc_popup-v_pos-field').val(),
                            border = $wrapper.find('#vc_popup-border-field').val(),
                            top = $wrapper.find('#vc_popup-margin-top-field').val(),
                            right = $wrapper.find('#vc_popup-margin-right-field').val(),
                            bottom = $wrapper.find('#vc_popup-margin-bottom-field').val(),
                            left = $wrapper.find('#vc_popup-margin-left-field').val();

                        vc.$frame_body.find('.mfp-wolmart .mfp-content').css({ justifyContent: hPos, alignItems: vPos });
                        vc.$frame_body.find('.mfp-wolmart .popup').css({ width: (width ? Number(width) + 'px' : '600px'), marginTop: (top ? top + 'px' : ''), marginRight: (right ? right + 'px' : ''), marginBottom: (bottom ? bottom + 'px' : ''), marginLeft: (left ? left + 'px' : '') });
                        vc.$frame_body.find('.mfp-wolmart .wolmart-popup-content').css({ borderRadius: (border ? Number(border) + 'px' : '') });
                    };

                    vc.WolmartPopupOptionsUIPanelEditor = vc.PostSettingsPanelView.vcExtendUI(vc.HelperPanelViewHeaderFooter).vcExtendUI(vc.HelperPanelViewResizable).vcExtendUI(vc.HelperPanelViewDraggable).vcExtendUI({
                        panelName: "wolmart_popup_options",
                        uiEvents: {
                            setSize: "setEditorSize",
                            show: "setEditorSize"
                        },
                        setSize: function () {
                            this.trigger("setSize")
                        },
                        setDefaultHeightSettings: function () {
                            this.$el.css("height", "70vh")
                        },
                        setEditorSize: function () {
                            this.editor.setSizeResizable()
                        }
                    });

                    vc.wolmart_popup_options_view = new vc.WolmartPopupOptionsUIPanelEditor({
                        el: "#vc_ui-panel-wolmart-popup-options"
                    });

                    if (window.vc.ShortcodesBuilder) {
                        window.vc.ShortcodesBuilder.prototype.save = function (status) { // update WPB save function
                            var string = this.getContent(),
                                data = {
                                    action: "vc_save"
                                };
                            data.vc_post_custom_css = window.vc.$custom_css.val();
                            data.content = this.wpautop(string);
                            status && (data.post_status = status,
                                $(".vc_button_save_draft").hide(100),
                                $("#vc_button-update").text(window.i18nLocale.update_all)),
                                window.vc.update_title && (data.post_title = this.getTitle()
                                );

                            var $wrapper = $('#vc_ui-panel-wolmart-popup-options'),
                                width = $wrapper.find('#vc_popup-width-field').val(),
                                hPos = $wrapper.find('#vc_popup-h_pos-field').val(),
                                vPos = $wrapper.find('#vc_popup-v_pos-field').val(),
                                border = $wrapper.find('#vc_popup-border-field').val(),
                                top = $wrapper.find('#vc_popup-margin-top-field').val(),
                                right = $wrapper.find('#vc_popup-margin-right-field').val(),
                                bottom = $wrapper.find('#vc_popup-margin-bottom-field').val(),
                                left = $wrapper.find('#vc_popup-margin-left-field').val(),
                                animation = $wrapper.find('#vc_popup-animation-field').val(),
                                duration = $wrapper.find('#vc_popup-anim-duration-field').val();

                            data.wolmart_popup_options = {
                                width: (width ? width : 600),
                                h_pos: (hPos ? hPos : 'center'),
                                v_pos: (vPos ? vPos : 'center'),
                                border: (border ? border : '0'),
                                top: (top ? top : ''),
                                right: (right ? right : ''),
                                bottom: (bottom ? bottom : ''),
                                left: (left ? left : ''),
                                popup_animation: animation,
                                popup_anim_duration: (duration ? duration : 400)
                            };

                            this.ajax(data).done(function () {
                                window.vc.unsetDataChanged(),
                                    window.vc.showMessage(window.i18nLocale.vc_successfully_updated || "Successfully updated!")
                            });
                        };
                    }

                    $('body')
                        .on('click', '.wolmart-wpb-addons #wolmart-popup-options', function (e) {
                            e && e.preventDefault && e.preventDefault();
                            vc.wolmart_popup_options_view.render().show();
                        })
                        .on('click', '#vc_ui-panel-wolmart-popup-options .vc_ui-button[data-vc-ui-element="button-save"]', changePopupOptions);
                };

                // Init Wolmart Panels
                if (wolmart_core_vars.wpb_preview_panels) {
                    Object.keys(wolmart_core_vars.wpb_preview_panels).forEach(function (key) {
                        $('#vc_ui-panel-row-layout').before($(wolmart_core_vars.wpb_preview_panels[key]));
                    })
                }

                if ($('.wolmart-wpb-addons #wolmart-popup-options').length) {
                    initPopupOptionsPanel();
                }
            }
        };

        insertElementorAddons();
        insertWPBAddons();
    }

    /* Wolmart Core Admin Initialize */
    $(document).on('ready', function () {

        WolmartCoreAdmin.Metabox();
        ('undefined' !== typeof wolmart_core_vars.sidebars) && WolmartCoreAdmin.Sidebar();
        WolmartCoreAdmin.TemplateWizard.init();
        ('undefined' !== typeof wolmart_core_vars.condition_network) && WolmartCoreAdmin.TemplateCondition();
        // ('undefined' !== typeof wolmart_core_vars.builder_addons) && WolmartCoreAdmin.BuilderAddons();
        WolmartCoreAdmin.BuilderAddons();
    });
})(jQuery);
