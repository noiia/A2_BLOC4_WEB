console.log("oui");

var rangeInput = document.getElementById("rangeInput");
var rangeValue = document.getElementById("rangeValue");
rangeInput.addEventListener("input", function () {
    rangeValue.textContent = "Bac+" + this.value;
});

const filterShutter = document.querySelector(".filter-button")
const filterMenu = document.querySelector(".parent-filter")
const container = document.querySelector(".runway-container")

filterShutter.addEventListener('click', () => {
    filterMenu.classList.toggle('filter-mobile_on-filter')
})
filterShutter.addEventListener('click', () => {
    container.classList.toggle('filter-mobile_on-container')
})

window.addEventListener("resize", () => {
    const widthScreen = window.innerWidth;
    if (widthScreen > 850) {
        filterMenu.classList.remove('filter-mobile_on-filter')
        container.classList.remove('filter-mobile_on-container')

    }
});

const menuHamburger = document.querySelector(".navbar-hamburger")
const navbarLinks = document.querySelector(".navbar-links")

menuHamburger.addEventListener('click', () => {
    navbarLinks.classList.toggle('mobile-menu')
})


/// *********  bubulle ********** ///

const unselectedWishlist = document.querySelector(".unselected-wishlist-logo-picture");
const selectedWishlist = document.querySelector(".selected-wishlist-logo-picture");

unselectedWishlist.addEventListener('click', () => {
    unselectedWishlist.classList.add('remove-wishlist-picture');
    selectedWishlist.classList.add('is-selected');
});

selectedWishlist.addEventListener('click', () => {
    selectedWishlist.classList.remove('is-selected');
    unselectedWishlist.classList.remove('remove-wishlist-picture');
});

const buttonCloseTab = document.querySelector(".close-tab-logo-picture");
const containerInternDetails = document.querySelector(".container-intern-details");
const containerIntern = document.querySelector(".container-intern");
const body = document.querySelector("body");

buttonCloseTab.addEventListener('click', () => {
    containerInternDetails.classList.add('close-tab-clicked');
    body.classList.add('mobile-scroll');
});

containerIntern.addEventListener('click', () => {
    containerInternDetails.classList.remove('close-tab-clicked');
    body.classList.remove('mobile-scroll');
});

window.onscroll = function () {
    afficherOuMasquerBouton();
    calculRunwayDist();
};

function afficherOuMasquerBouton() {
    var boutonRetourHaut = document.getElementById("button-retour-haut");

    if (document.documentElement.scrollTop > 115) {
        boutonRetourHaut.classList.add('retourHaut');
        boutonRetourHaut.classList.remove('display-none');
    } else {
        boutonRetourHaut.classList.add('display-none');
        boutonRetourHaut.classList.remove('retourHaut');
    }
}

function retournerEnHaut() {
    document.documentElement.scrollTop = 0;
}

function calculRunwayDist() {
    var runwayContainer = document.getElementById('runway-container');
    var heightRunwayContainer = runwayContainer.clientHeight;
    var element = document.getElementById('runway-container-intern-details');
    if (heightRunwayContainer < 750) {
        runwayContainer.style.height = 750 + 'px';
    } else {
        element.style.height = heightRunwayContainer + 'px';
    }
}

/// ********* fin bubulle ********** ///