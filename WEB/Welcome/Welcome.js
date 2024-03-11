
function input_filter() {
    document.getElementById("rangeValue").textContent = "Bac+" + document.getElementById("rangeInput").value;
}
function toggle_filterMenu(){
    document.querySelector(".parent-filter").classList.toggle('filter-mobile_on-filter');
    document.querySelector(".runway-container").classList.toggle('filter-mobile_on-container');
}

window.addEventListener("resize", () => {
    const widthScreen = window.innerWidth;
    if (widthScreen > 850) {
        filterMenu.classList.remove('filter-mobile_on-filter')
        container.classList.remove('filter-mobile_on-container')

    }
});
function toggle_navbarMenu(){
    document.querySelector(".navbar-links").classList.toggle('mobile-menu')
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
window.onscroll = function() {
    afficherOuMasquerBouton();
    calculRunwayDist();
};

function afficherOuMasquerBouton() {
    var boutonRetourHaut = document.getElementById("button-retour-haut");

    if (document.documentElement.scrollTop > 115) {
        boutonRetourHaut.classList.add('retourHaut');
        boutonRetourHaut.classList.remove('display-none');
    }else {
        boutonRetourHaut.classList.add('display-none');
        boutonRetourHaut.classList.remove('retourHaut');
    }
}

function retournerEnHaut() {
    document.documentElement.scrollTop = 0;
}

function calculRunwayDist(){
    var runwayContainer = document.getElementById('runway-container');
    var heightRunwayContainer = runwayContainer.clientHeight;
    var element = document.getElementById('runway-container-intern-details');
    if (heightRunwayContainer < 750){
        runwayContainer.style.height = 750 + 'px'; 
    }else {
        element.style.height = heightRunwayContainer + 'px';
    }
}

// ----------------------FIN JS SCRIPT STEPHAN BUBULLE--------------------------

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
