$(document).ready(function(){
    var Value = 3;
    var PHPfiles = "WishList.php";
    data = {
        action : Value
    };
    $.post(PHPfiles, data, function(response){
        $(".main_left").append(response);
    })
})