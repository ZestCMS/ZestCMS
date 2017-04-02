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