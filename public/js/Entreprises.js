
function input_filter(){
    document.getElementById("rangeValue").textContent = document.getElementById("rangeInput").value + "/10";
}

function toggle_bubulle(){
    document.querySelector(".container-intern-details").classList.toggle('close-tab-clicked');
    document.querySelector("body").classList.toggle('mobile-scroll');
}

window.addEventListener("resize", () => {
    const widthScreen = window.innerWidth;
    if (widthScreen > 850) {
        document.querySelector(".parent-filter").classList.remove('filter-mobile_on-filter');
        document.querySelector(".runway-container").classList.remove('filter-mobile_on-container');
    }
});

// ----------------------FIN JS SCRIPT STEPHAN BUBULLE-------------------------- -->
