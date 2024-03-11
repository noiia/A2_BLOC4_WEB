


// ------------------ parti Welcome/Entreprise ----------------
window.addEventListener("resize", () => {
    const widthScreen = window.innerWidth;
    if (widthScreen > 850) {
        filterMenu.classList.remove('filter-mobile_on-filter')
        container.classList.remove('filter-mobile_on-container')
    }
});

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

function toggle_navbarMenu(){
    document.querySelector(".navbar-links").classList.toggle('mobile-menu')
}
function toggle_filterMenu(){
    document.querySelector(".parent-filter").classList.toggle('filter-mobile_on-filter');
    document.querySelector(".runway-container").classList.toggle('filter-mobile_on-container');
}



// ------------------ parti gestion ---------------------
function toggle_menu(){
    document.querySelector(".main_left").classList.toggle('mobile-menu');
    document.querySelector("#close_menu").classList.toggle('display-cross');
}
// -------------------- fin parti gestion -------------------


