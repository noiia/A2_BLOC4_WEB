$(document).ready(function(){
    $("#postulation-button_postulation").click(function(){
        console.log("postulation");
        var postulationValue = "postulation";
        var welcomePHP = "Welcome.php";
        data = {
            action : postulationValue
        };
        $.post(welcomePHP, data, function(response){})
    })
})


function input_filter() {
    document.getElementById("rangeValue").textContent = "Bac+" + document.getElementById("rangeInput").value;
}

//-- ----------------------DEBUT JS SCRIPT STEPHAN BUBULLE-------------------------- 

function toggle_wishlist(){
    document.querySelector(".unselected-wishlist-logo-picture").classList.toggle('remove-wishlist-picture');
    document.querySelector(".selected-wishlist-logo-picture").classList.toggle('is-selected');
}
function toggle_bubulle(){
    document.querySelector(".container-intern-details").classList.toggle('close-tab-clicked');
    document.querySelector("body").classList.toggle('mobile-scroll');
}

// ----------------------FIN JS SCRIPT STEPHAN BUBULLE--------------------------


//- ---------------   JS POSTULATION ------------------------ -->

function block_postulation() {
    document.querySelector("header").classList.toggle("when_postulation");
    document.querySelector(".full-runway").classList.toggle("when_postulation");
    document.querySelector("footer").classList.toggle("when_postulation");
    document.querySelector("body").classList.toggle("disable_scroll");
    document.querySelector(".postulation-bg").classList.toggle("postulation-off");
    document.querySelector(".postulation-bg").classList.toggle("postulation-on");
}
//--------------FIN JS POSTULATION ------------------------ -->
