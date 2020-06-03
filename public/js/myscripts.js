// Change the checked Box of Notifications when press "All Notifications"
document.addEventListener('DOMContentLoaded', function () {
    var checkbox = document.querySelector("#allnotifications input[type=checkbox]");
    var checkbox2 = document.querySelector("#holidaysnoti input[type=checkbox]");
    var checkbox3 = document.querySelector("#birthdaynoti input[type=checkbox]");
    var checkbox4 = document.querySelector("#evaluationsnoti input[type=checkbox]");
    var checkbox5 = document.querySelector("#flextimenoti input[type=checkbox]");
    var checkbox6 = document.querySelector("#notworkingnoti input[type=checkbox]");

    checkbox.addEventListener('change', function () {
      if (checkbox.checked) {
          checkbox2.checked = true;
          checkbox3.checked = true;
          checkbox4.checked = true;
          checkbox5.checked = true;
          checkbox6.checked = true;
      } else {
          checkbox2.checked = false;
          checkbox3.checked = false;
          checkbox4.checked = false;
          checkbox5.checked = false;
          checkbox6.checked = false;
      }
    });
  });

// Employees Role
$("#exampleRole").change(function(){
    if($(this).val()=="other")
    {
        $("div#rolenew").css('display', 'grid');
        // $("div#rolenew").show(); - Apenas para Display Block
    }
     else
     {
         $("div#rolenew").hide();
     }
 });


// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

// Change the Profile Photo
var icon = document.getElementById("imagefile");

icon.addEventListener('click', () => {
    $("input[type='file']").trigger('click');
})

$('input[type="file"]').on('change', function () {
    var val = $(this).val();
    $(this).siblings('span').text(val);
})
