/**
 * Wolmart Typography
 *
 * @since 1.0.0
 */
jQuery('.wolmart-wpb-typography-container .wolmart-wpb-typography-toggle').on('click', function (e) {
    var $this = jQuery(this);
    $this.parent().toggleClass('show');
    $this.next().slideToggle(300);
});
jQuery(document.body).on('change', '.wolmart-wpb-typography-container .wolmart-vc-font-family', function (e) {
    var $this = jQuery(this),
        $control = $this.closest('.wolmart-wpb-typography-container'),
        $form = $control.next(),
        $variants = $control.find('.wolmart-vc-font-variants'),
        $status = $control.find('.wolmart-wpb-typography-toggle p'),
        font = $this.val(),
        variants = $this.find('option[value="' + font + '"]').data('variants'),
        html = '';

    variants.forEach(item => {
        html += '<option value="' + item + '">' + item + '</option>';
    });
    $variants.html(html);

    var data = {
        family: $this.val(),
        variant: $variants.val(),
        size: $control.find('.wolmart-vc-font-size').val(),
        line_height: $control.find('.wolmart-vc-line-height').val(),
        letter_spacing: $control.find('.wolmart-vc-letter-spacing').val(),
        text_transform: $control.find('.wolmart-vc-text-transform').val()
    };

    $form.val(JSON.stringify(data));

    $status.text(data.family + ' | ' + data.variant + ' | ' + data.size);
}).on('change', '.wolmart-wpb-typography-container .wolmart-vc-font-variants, .wolmart-wpb-typography-container .wolmart-vc-font-size, .wolmart-wpb-typography-container .wolmart-vc-letter-spacing, .wolmart-wpb-typography-container .wolmart-vc-line-height, .wolmart-wpb-typography-container .wolmart-vc-text-transform', function (e) {
    var $this = jQuery(this),
        $control = $this.closest('.wolmart-wpb-typography-container'),
        $status = $control.find('.wolmart-wpb-typography-toggle p'),
        $form = $control.next();

    var data = {
        family: $control.find('.wolmart-vc-font-family').val(),
        variant: $control.find('.wolmart-vc-font-variants').val(),
        size: $control.find('.wolmart-vc-font-size').val(),
        line_height: $control.find('.wolmart-vc-line-height').val(),
        letter_spacing: $control.find('.wolmart-vc-letter-spacing').val(),
        text_transform: $control.find('.wolmart-vc-text-transform').val()
    };

    $form.val(JSON.stringify(data));
    $status.text(data.family + ' | ' + data.variant + ' | ' + data.size);
});