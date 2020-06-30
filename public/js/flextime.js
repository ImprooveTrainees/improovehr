// Toogle and Hide Tables
// function toggle_visibility(id) {
//     var e = document.getElementById(id);
//     if (e.style.display == 'block') {
//            e.style.display = 'none';
//     }
//     else{
//         e.style.display = 'block';
//     }
// }
var month = document.getElementById("lastMonth");
var twoWeeks = document.getElementById("last2weeks");
var week = document.getElementById("currentWeek");

function showMonth() {
    twoWeeks.style.display="none";
    week.style.display="none";
    month.style.display="block";
}

function show2weeks() {
    twoWeeks.style.display="block";
    week.style.display="none";
    month.style.display="none";
}

function showWeek() {
    twoWeeks.style.display="none";
    week.style.display="block";
    month.style.display="none";
}



// Add Class when resize for mobile
jQuery(document).ready(function ($) {
    var alterClass = function () {
        var ww = document.body.clientWidth;
        if (ww < 740) {
            $('.js-dataTable').removeClass('table');
        } else if (ww >= 760) {
            $('.js-dataTable').addClass('table');
        };
    };
    $(window).resize(function () {
        alterClass();
    });
    //Fire it when the page first loads:
    alterClass();
});


