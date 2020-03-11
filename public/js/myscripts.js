var ahref = document.querySelector('a.nav-main-link.active');
var allhref = document.querySelectorAll('a.nav-main-link');

$(function() {
    $( 'li.nav-main-item a' ).on( 'click', function() {
          $( this ).parent().find( 'a.active' ).removeClass( 'active' );
          $( this ).addClass( 'active' );
    });
});
