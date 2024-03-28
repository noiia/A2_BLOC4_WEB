const menuHamburger = document.querySelector(".hamburger");
const containerLinks = document.querySelector(".main_left");
menuHamburger.addEventListener('click', () => { containerLinks.classList.toggle('mobile-menu'); });

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