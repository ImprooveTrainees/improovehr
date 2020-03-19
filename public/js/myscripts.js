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

var icon = document.getElementById("imagefile");

icon.addEventListener('click', () => {
    $("input[type='file']").trigger('click');
})

$('input[type="file"]').on('change', function () {
    var val = $(this).val();
    $(this).siblings('span').text(val);
})
