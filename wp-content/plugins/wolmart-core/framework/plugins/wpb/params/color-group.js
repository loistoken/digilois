/**
 * Wolmart Color Group
 * 
 * @since 1.0.0
 */

var wolmartWpbColorGroupPicker = function (e) {
    var $this = jQuery(this),
        $group = $this.closest('.vc_wrapper-param-type-wolmart_color_group'),
        $value = $group.find('[name="' + $group.attr('data-vc-shortcode-param-name') + '"]'),
        value = $value.val(),
        selector = $this.closest('.tab-pane').attr('id'),
        choice = $this.closest('.color-group-wrapper').attr('data-choice-id');

    if (value) {
        value = JSON.parse(value);

        if ('object' == typeof value[selector] && 0 == value[selector].length) {
            value[selector] = {};
        }
    } else {
        value = {};
    }

    if ('undefined' == typeof value[selector]) {
        value[selector] = {};
    }

    setTimeout(function () {
        if ($this.val() == $this.closest('.wp-picker-input-wrap').find('.wp-picker-clear').val()) {
            delete value[selector][choice];
        } else {
            value[selector][choice] = $this.val();
        }
        $value.val(JSON.stringify(value));
    }, 100);
};

jQuery('body').on('input', '.wolmart-wpb-color-group .wp-picker-input-wrap .wolmart_color_group_field', wolmartWpbColorGroupPicker);

jQuery('.wolmart-wpb-color-group .vc_color-control').wpColorPicker({
    change: wolmartWpbColorGroupPicker,
    clear: wolmartWpbColorGroupPicker
});

jQuery('.wolmart-wpb-color-group .nav-tabs a').on('click', function (e) {
    e.preventDefault();

    if (jQuery(this).hasClass('active')) {
        return;
    }

    jQuery(this).closest('.nav-tabs').find('.active').removeClass('active');
    jQuery(this).addClass('active');
    jQuery(this).closest('.wolmart-wpb-color-group').find('.tab-pane').removeClass('active');
    jQuery(this).closest('.wolmart-wpb-color-group').find('.tab-pane[id="' + jQuery(this).attr('data-pane-id') + '"]').addClass('active');
});