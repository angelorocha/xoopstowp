jQuery(function ($) {
    $('.xtw-nav a').each(function () {
        $(this).on('click', function () {
            var tab = $('#' + $(this).attr('class'));
            $('.xtw-tab').removeClass('xtw-active-tab');
            $(tab).addClass('xtw-active-tab');
            $('.xtw-nav li a').removeClass('xwt-active');
            $(this).addClass('xwt-active');
        })
    })
});