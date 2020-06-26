//HOME Page Hide Calendar
// Add Class when resize for mobile
jQuery(document).ready(function ($) {
    var hideShowCalendar = function () {
        var wy = document.body.clientWidth;
        if (wy < 768) {
            $('#calendarDiv').css("display", "none");
        } else if (wy >= 768) {
            $('#calendarDiv').css("display", "block");
        };
    };
    $(window).resize(function () {
        hideShowCalendar();
    });
    //Fire it when the page first loads:
    hideShowCalendar();
});


//Change Div sizeMobile to not have Col-md-4
jQuery(document).ready(function ($) {
    var changeCol = function () {
        var wy = document.body.clientWidth;
        if (wy < 768) {
            $('.sizeMobile').removeClass('col-md-4');
        } else if (wy >= 768) {
            $('.sizeMobile').addClass('col-md-4');
        };
    };
    $(window).resize(function () {
        changeCol();
    });
    //Fire it when the page first loads:
    changeCol();
});
