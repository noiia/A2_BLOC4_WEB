$(document).ready(function(){
    var Value = "role";
    var PHPfiles = "Postulation.php";
    data = {
        action : Value
    };
    $.post(PHPfiles, data, function(response){
        $(".main_left").append(response);
    })
})