$(document).ready(function(){
    var Value = "role";
    var PHPfiles = "Students.php";
    data = {
        action : Value
    };
    $.post(PHPfiles, data, function(response){
        $(".main_left").append(response);
    })
})

function toggle_search(){
    document.querySelector(".search_list-students").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_student").classList.toggle('mobile-search_menu-profile');
}