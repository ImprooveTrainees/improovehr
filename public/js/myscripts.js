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

// Employees Other Role - Hide/Show
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

// Employees Other Role2 - Hide/Show
$("#exampleRole2").change(function(){
    if($(this).val()=="other")
    {
        $("div#rolenew2").css('display', 'grid');
        // $("div#rolenew").show(); - Apenas para Display Block
    }
     else
     {
         $("div#rolenew2").hide();
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


//Settings Page
function addDate() {
    var ul = document.getElementById("dateList");
    var li = document.createElement("li");
    li.appendChild(document.createTextNode(document.getElementById('dateSelected').value + " | " +  document.getElementById('descriptionExtraDay').value));
    li.setAttribute("value", document.getElementById('dateSelected').value);
    ul.appendChild(li);

    var form = document.getElementById('form');
    var hiddenInput = document.createElement("input");
    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("value",  document.getElementById('dateSelected').value);
    hiddenInput.setAttribute("name",  "dateList[]");
    form.appendChild(hiddenInput); //cria hidden inputs como array, com os valores das datas, para
    //ser mais fácil transmitir para o php

    var hiddenInputDescription =  document.createElement("input");
    hiddenInputDescription.setAttribute("type", "hidden");
    hiddenInputDescription.setAttribute("value",  document.getElementById('descriptionExtraDay').value);
    hiddenInputDescription.setAttribute("name",  "descriptionExtraDay[]");
    form.appendChild(hiddenInputDescription);

  }

  function execForm() {
    document.getElementById('form').submit();
  }


//Employees MODAL
function modalOpen(idUser) {
    var modal = document.getElementById("editProfessionaInfoModal");
    // Get the button that opens the modal
    var btn = document.getElementById("editUserModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal

    modal.style.display = "block";

    var form = document.getElementById('professionalEditForm');
    var hiddenInput = document.createElement("input");
    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("value",  idUser);
    hiddenInput.setAttribute("id",  "idUser");
    hiddenInput.setAttribute("name",  "idUser");
    form.appendChild(hiddenInput); //cria hidden input com o id do user, que vem do argumento da funcao

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    document.getElementById("idUser").remove(); //remove o hidden value do user quando fecha
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.getElementById("idUser").remove(); //remove o hidden value do user quando fecha
        }
    }
}


