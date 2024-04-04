function toggle_search() {
    document.querySelector(".search_list-companies").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_company").classList.toggle('mobile-search_menu-profile');
}

var current_student = null;

function toggle_valid(id) {
    current_student = id;
    document.querySelector(".valid_bg").classList.toggle('active-del_block');
}

function valid_current_student() {
    document.getElementById(current_student).classList.remove('black_check');
    console.log(current_student + " à été recruté");
    //ajouter dans la bdd
    //envoie du mail
    toggle_valid(current_student);
    document.getElementById(current_student).onclick = function () {
        toggle_end(current_student)
    };
}

function toggle_end(id) {
    current_student = id;
    document.querySelector(".end_bg").classList.toggle('active-del_block');
}

function end_current_student() {
    var radio = document.querySelector('input[name=end_radio]:checked');
    if (radio !== null) {
        document.getElementById(current_student).classList.add('black_check');
        console.log(current_student + " à été enlevé d'un stage pour raison: " + radio.value);
        //ajouter dans la bdd
        //envoie du mail
        toggle_end(current_student);
        document.getElementById(current_student).onclick = function () {
            toggle_valid(current_student)
        };
    } else {
        alert("Veuillez sélectionné une valeur avant de valider");
    }
}

function loadBubbleInternshipManagement(id = 1) {
    fetch("https://inter-net.loc/Stage/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const mainTemplate = document.getElementById("id-template-internship-m");
            const bubbleContainer = document.getElementById("bubble-place");
            const bubbleTemplate = mainTemplate.content.cloneNode(true);
            bubbleTemplate.getElementById("Bubble-job").textContent = data.job;
            bubbleTemplate.getElementById("Bubble-school-grade").textContent = data.school_grade;
            bubbleTemplate.getElementById("Bubble-company").textContent = data.company;
            bubbleTemplate.getElementById("Bubble-location").textContent = data.location;
            bubbleTemplate.getElementById("Bubble-begin-date").textContent = data.begin_date;
            bubbleTemplate.getElementById("Bubble-hour-payment").textContent = data.hour_payment;
            bubbleTemplate.getElementById("Bubble-week-payment").textContent = data.week_payment;
            bubbleTemplate.getElementById("Bubble-duration").textContent = data.duration;
            bubbleTemplate.getElementById("Bubble-taken-places").textContent = data.taken_places;
            bubbleTemplate.getElementById("Bubble-max-places").textContent = data.max_places;
            bubbleTemplate.getElementById("Bubble-description").textContent = data.description;
            bubbleContainer.appendChild(bubbleTemplate);
        });
}

const runway = document.getElementById("search_list-students");
var oldElement = 1;
loadBubbleInternshipManagement(oldElement);
addEventListener("click", (event) => {
    var focusedBubble = Number(document.activeElement.id);
    if (oldElement !== focusedBubble && focusedBubble > 0) {
        document.getElementById("template-space").remove();
        loadBubbleInternshipManagement(focusedBubble);
        oldElement = focusedBubble;
    }
});
