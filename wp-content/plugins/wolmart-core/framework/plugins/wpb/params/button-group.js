/**
 * Wolmart Button Group
 * 
 * @since 1.0.0
 */
jQuery('.wolmart-wpb-button-group .wolmart-responsive-toggle').on('click', function (e) {
    var $this = jQuery(this);
    $this.parent().toggleClass('show');
});

if (undefined == wolmart_core_vars.wpb_editor || undefined == wolmart_core_vars.wpb_editor.wolmart_button_group_included || true != wolmart_core_vars.wpb_editor.wolmart_button_group_included) {
    jQuery(document.body).on('click', '.wolmart-wpb-button-group .wolmart-responsive-span li', function (e) {
        var $this = jQuery(this),
            $dropdown = $this.closest('.wolmart-responsive-dropdown'),
            $toggle = $dropdown.find('.wolmart-responsive-toggle'),
            $control = $dropdown.parent(),
            $form = $control.next();
        // Actions
        $this.addClass('active').siblings().removeClass('active');
        $dropdown.removeClass('show');
        $toggle.html($this.html());

        // Trigger
        var $sizeControl = jQuery('#vc_screen-size-control'),
            $uiPanel = $this.closest('.vc_ui-panel-window');
        if ($sizeControl.length > 0) {
            $sizeControl.find('[data-size="' + $this.data('size') + '"]').click();
        }
        if ($uiPanel.length > 0) {
            $uiPanel.find('.wolmart-responsive-span [data-width="' + $this.data('width') + '"]').trigger('responsive_changed');
        }

        // Responsive Data
        var width = $this.data('width'),
            values = $form.val();
        $control.data('width', width);

        if (values) {
            values = JSON.parse(values);
        } else {
            values = {};
        }

        $control.find('.options-wrapper li').removeClass('active');
        if (undefined != values[width]) {
            $control.find('.options-wrapper [attr-value="' + values[width] + '"]').addClass('active');
        }
    }).off('responsive_changed', '.wolmart-wpb-button-group .wolmart-responsive-span li').on('responsive_changed', '.wolmart-wpb-button-group .wolmart-responsive-span li', function (e) {
        var $this = jQuery(this),
            $dropdown = $this.closest('.wolmart-responsive-dropdown'),
            $toggle = $dropdown.find('.wolmart-responsive-toggle'),
            $control = $dropdown.parent(),
            $form = $control.next();
        // Actions
        $this.addClass('active').siblings().removeClass('active');
        $dropdown.removeClass('show');
        $toggle.html($this.html());

        // Responsive Data
        var width = $this.data('width'),
            values = $form.val();
        $control.data('width', width);

        if (values) {
            values = JSON.parse(values);
        } else {
            values = {};
        }

        $control.find('.options-wrapper li').removeClass('active');
        if (undefined != values[width]) {
            $control.find('.options-wrapper [attr-value="' + values[width] + '"]').addClass('active');
        }
    }).on('click', '.wolmart-wpb-button-group .options-wrapper li', function (e) {
        var $this = jQuery(this),
            value = $this.attr('attr-value'),
            $control = $this.closest('.wolmart-wpb-button-group'),
            $form = $control.next();

        if (undefined == $control.data('width')) {
            $form.val(value);
            $form.trigger('change');
        } else {
            values = $form.val();
            if (values) {
                values = JSON.parse(values);
            } else {
                values = {};
            }

            values[$control.data('width')] = value;
            $form.val(JSON.stringify(values));
            $form.trigger('change');
        }

        $this.addClass('active').siblings().removeClass('active');
    });
    if (undefined == wolmart_core_vars.wpb_editor) {
        wolmart_core_vars.wpb_editor = {
            wolmart_button_group_included: true,
        }
    } else {
        wolmart_core_vars.wpb_editor.wolmart_button_group_included = true;
    }
}