/**
 * Wolmart Dimension
 * 
 * @since 1.0.0
 */
jQuery('.wolmart-wpb-dimension-container .wolmart-responsive-toggle').on('click', function (e) {
    var $this = jQuery(this);
    $this.parent().toggleClass('show');
});

if (undefined == wolmart_core_vars.wpb_editor || undefined == wolmart_core_vars.wpb_editor.wolmart_dimension_included || true != wolmart_core_vars.wpb_editor.wolmart_dimension_included) {
    jQuery(document.body).on('click', '.wolmart-wpb-dimension-container .wolmart-responsive-span li', function (e) {
        var $this = jQuery(this),
            $dropdown = $this.closest('.wolmart-responsive-dropdown'),
            $toggle = $dropdown.find('.wolmart-responsive-toggle'),
            $control = $dropdown.parent(),
            $inputs = $control.find('.wolmart-wpb-dimension');
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
        var width = $this.data('width');
        $control.data('width', width);
        $inputs.each(function () {
            var $input = jQuery(this);
            $input.val($input.data(width) ? $input.data(width) : '');
        });
    }).off('responsive_changed', '.wolmart-wpb-dimension-container .wolmart-responsive-span li').on('responsive_changed', '.wolmart-wpb-dimension-container .wolmart-responsive-span li', function (e) {
        var $this = jQuery(this),
            $dropdown = $this.closest('.wolmart-responsive-dropdown'),
            $toggle = $dropdown.find('.wolmart-responsive-toggle'),
            $control = $dropdown.parent(),
            $inputs = $control.find('.wolmart-wpb-dimension');

        // Actions
        $this.addClass('active').siblings().removeClass('active');
        $dropdown.removeClass('show');
        $toggle.html($this.html());

        // Responsive Data
        var width = $this.data('width');
        $control.data('width', width);
        $inputs.each(function () {
            var $input = jQuery(this);
            $input.val($input.data(width) ? $input.data(width) : '');
        });
    }).on('change', '.wolmart-wpb-dimension', function (e) {
        var $this = jQuery(this),
            $control = $this.closest('.wolmart-wpb-dimension-container'),
            $form = $control.next();
        if (undefined == $control.data('width')) {
            $this.data('xl', $this.val());
        } else {
            $this.data($control.data('width'), $this.val());
        }
        var data = {
            top: $control.find('.top input').data(),
            right: $control.find('.right input').data(),
            bottom: $control.find('.bottom input').data(),
            left: $control.find('.left input').data()
        };
        // Set Data
        $form.val(JSON.stringify(data));
    });
    if (undefined == wolmart_core_vars.wpb_editor) {
        wolmart_core_vars.wpb_editor = {
            wolmart_dimension_included: true,
        }
    } else {
        wolmart_core_vars.wpb_editor.wolmart_dimension_included = true;
    }
}