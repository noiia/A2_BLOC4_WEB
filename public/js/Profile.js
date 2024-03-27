$(document).ready(function(){
    var roleValue = "role";
    var profilePHP = "Profile.php";
    data = {
        action : roleValue
    };
    $.post(profilePHP, data, function(response){
        $(".main_left").append(response);
    })
})