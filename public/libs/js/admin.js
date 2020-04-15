$('ul.menu').each(function () {
    $(this).tendina();

    // find menu items with children.
    $(this).find('li').has('ul').addClass('has-menu');
});
$("#sidebar-toggle, #close-sidebar").click(function () {
    $("#sidebar-wrapper").toggle("slow");
});

if (screen.width >= 1280) {
    $("#sidebar-wrapper").show();
}

$(".msg a.msg-button-close").click(function () {
    $(this).parent().fadeOut("slow");
});

$.fancyConfirm = function (opts) {
    opts = $.extend(true, {
        title: '',
        message: '',
        okButton: '',
        noButton: '',
        callback: $.noop
    }, opts || {});

    $.fancybox.open({
        type: 'html',
        src:
                '<div class="fc-content">' +
                '<h3>' + opts.title + '</h3>' +
                '<p>' + opts.message + '</p>' +
                '<div class="buttons">' +
                '<button data-value="1" data-fancybox-close class="danger">' + opts.okButton + '</button>' +
                '<button data-value="0" data-fancybox-close class="success">' + opts.noButton + '</button>' +
                '</div>' +
                '</div>',
        opts: {
            animationDuration: 350,
            animationEffect: 'material',
            modal: true,
            baseTpl:
                    '<div class="fancybox-container fc-container" role="dialog" tabindex="-1">' +
                    '<div class="fancybox-bg"></div>' +
                    '<div class="fancybox-inner">' +
                    '<div class="fancybox-stage"></div>' +
                    '</div>' +
                    '</div>',
            afterClose: function (instance, current, e) {
                var button = e ? e.target || e.currentTarget : null;
                var value = button ? $(button).data('value') : 0;

                opts.callback(value);
            }
        }
    });
}