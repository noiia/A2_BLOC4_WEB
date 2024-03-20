var container_focus = null;
// focus des container

function focus_container(id){
    if (container_focus === null){
        document.getElementById(id).classList.add("container_focus");
        container_focus = id;
    }
    else if (container_focus !== id) {
        document.getElementById(container_focus).classList.remove("container_focus");
        document.getElementById(id).classList.add("container_focus");
        container_focus = id;
    }
}


// ------------------ parti Welcome/Entreprise ----------------
window.addEventListener("resize", () => {
    const widthScreen = window.innerWidth;
    if (widthScreen > 850) {
        document.querySelector(".parent-filter").classList.remove('filter-mobile_on-filter');
        document.querySelector(".runway-container").classList.remove('filter-mobile_on-container');
    }
});

window.onscroll = function() {
    afficherOuMasquerBouton();
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
    window.scrollTo({
        top:0,
        left:0,
        behavior:"smooth"
    })
}

function toggle_navbarMenu(){
    document.querySelector(".navbar-links").classList.toggle('mobile-menu');
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
function toggle_delete(){
    if (container_focus !== null){
        document.querySelector(".del_bg").classList.toggle('active-del_block');
    }
}

function del_current_container(){
    document.getElementById(container_focus).classList.add('del_current_container');
    console.log(container_focus+" à été supprimer");
    //suprimer dans la bdd
    toggle_delete();
    container_focus = null;
}

function toggle_hide_popup(){
    document.querySelector('.container-add-student').classList.toggle('hide_container');
}

// -------------------- fin parti gestion -------------------


