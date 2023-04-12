/**
 * Wolmart Dropdown
 * 
 * @since 1.0.0
 */
jQuery('.wolmart-wpb-dropdown-container .wolmart-responsive-toggle').on('click', function (e) {
    var $this = jQuery(this);
    $this.parent().toggleClass('show');
});
if (undefined == wolmart_core_vars.wpb_editor || undefined == wolmart_core_vars.wpb_editor.wolmart_dropdown_included || true != wolmart_core_vars.wpb_editor.wolmart_dropdown_included) {
    jQuery(document.body).on('click', '.wolmart-wpb-dropdown-container .wolmart-responsive-span li', function (e) {
        var $this = jQuery(this),
            $dropdown = $this.closest('.wolmart-responsive-dropdown'),
            $toggle = $dropdown.find('.wolmart-responsive-toggle'),
            $control = $dropdown.parent(),
            $input = $control.find('.wolmart-wpb-dropdown');
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
        $input.val($input.data(width) ? $input.data(width) : '');
    }).off('responsive_changed', '.wolmart-wpb-dropdown-container .wolmart-responsive-span li').on('responsive_changed', '.wolmart-wpb-dropdown-container .wolmart-responsive-span li', function (e) {
        var $this = jQuery(this),
            $dropdown = $this.closest('.wolmart-responsive-dropdown'),
            $toggle = $dropdown.find('.wolmart-responsive-toggle'),
            $control = $dropdown.parent(),
            $input = $control.find('.wolmart-wpb-dropdown');
        // Actions
        $this.addClass('active').siblings().removeClass('active');
        $dropdown.removeClass('show');
        $toggle.html($this.html());

        // Responsive Data
        var width = $this.data('width');
        $control.data('width', width);
        $input.val($input.data(width) ? $input.data(width) : '');
    }).on('change', '.wolmart-wpb-dropdown', function (e) {
        var $this = jQuery(this),
            $control = $this.parent(),
            $form = $control.next();
        if (undefined == $control.data('width')) {
            $this.data('xl', $this.val());
        } else {
            $this.data($control.data('width'), $this.val());
        }

        // Set Data
        if ($this.hasClass('simple-value')) {
            $form.val($this.val());
        } else {
            $form.val(JSON.stringify($this.data()));
        }
    })
    if (undefined == wolmart_core_vars.wpb_editor) {
        wolmart_core_vars.wpb_editor = {
            wolmart_dropdown_included: true,
        }
    } else {
        wolmart_core_vars.wpb_editor.wolmart_dropdown_included = true;
    }
}