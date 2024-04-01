function toggle_search(){
    document.querySelector(".search_list-companies").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_company").classList.toggle('mobile-search_menu-profile');
}

var current_student = null;
function toggle_valid(id){
    current_student = id;
    document.querySelector(".valid_bg").classList.toggle('active-del_block');
}
function valid_current_student(){
    document.getElementById(current_student).classList.remove('black_check');
    console.log(current_student+" à été recruté");
    //ajouter dans la bdd
    //envoie du mail
    toggle_valid(current_student);
    document.getElementById(current_student).onclick = function(){toggle_end(current_student)};
}

function toggle_end(id){
    current_student = id;
    document.querySelector(".end_bg").classList.toggle('active-del_block');
}
function end_current_student(){
    var radio = document.querySelector('input[name=end_radio]:checked');
    if (radio !== null){
        document.getElementById(current_student).classList.add('black_check');
        console.log(current_student+" à été enlevé d'un stage pour raison: "+radio.value);
        //ajouter dans la bdd
        //envoie du mail
        toggle_end(current_student);
        document.getElementById(current_student).onclick = function(){toggle_valid(current_student)};
    } else {
        alert("Veuillez sélectionné une valeur avant de valider");
    }
}

function loadBubbleStudent(id = 1) {
    fetch("https://inter-net.loc/InternshipManagement/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const mainTemplate = document.getElementById("id-template-internship-m");

            const bubbleTemplate = mainTemplate.content.cloneNode(true);

            // Mise à jour des données dans le modèle Twig
            bubbleTemplate.querySelector("#Bubble-left-name").textContent = data.job;
            bubbleTemplate.querySelector("#Bubble-left-siret").textContent = "N°SIRET: " + data.siret;
            bubbleTemplate.querySelector("#Bubble-left-location").textContent = data.location;
            bubbleTemplate.querySelector("#Bubble-left-school-grade").textContent = data.school_grade;
            bubbleTemplate.querySelector("#Bubble-left-begin-date").textContent = data.begin_date;
            bubbleTemplate.querySelector("#Bubble-left-duration").textContent = data.duration;
            bubbleTemplate.querySelector("#Bubble-left-company").textContent = data.company;
            bubbleTemplate.querySelector("#Bubble-right-advantages-1").textContent = data.advantages;
            bubbleTemplate.querySelector("#Bubble-description").textContent = data.description;
            bubbleTemplate.querySelector("#Bubble-left-ID").textContent = data.id;

            const bubblePlace = document.getElementById("bubble-place");
            bubblePlace.innerHTML = ""; // Effacer le contenu précédent
            bubblePlace.appendChild(bubbleTemplate);
        });
}

// Ajout de l'écouteur d'événements après le chargement des boutons
document.addEventListener("DOMContentLoaded", function() {
    const internships = document.querySelectorAll(".internship");
    internships.forEach(function(button) {
        button.addEventListener("click", function() {
            var id = this.id.split("-")[1]; // Récupérer l'ID du bouton
            loadBubbleStudent(id);
        });
    });
});


$(document).ready(function(){
    var Value = "role";
    var PHPfiles = "InternshipManagement.php";
    data = {
        action : Value
    };
    $.post(PHPfiles, data, function(response){
        $(".main_left").append(response);
    })
})
