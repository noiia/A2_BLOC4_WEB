function toggle_search(){
    document.querySelector(".search_list-internships").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_internship").classList.toggle('mobile-search_menu-profile');
}

var current_student = null;
function toggle_valid(id){
    current_student = id;
    document.querySelector(".valid_bg").classList.toggle('active-del_block');
}

function toggle_hide_popup() {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
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

function newStageToBdd() {
    var nameInternship = document.getElementById("editNameInternship").value;
    var nameCompany = document.getElementById("editNameCompany").value;
    var promotion = document.getElementById("editPromotion").value;
    var salary = document.getElementById("editSalary").value;
    var hourPerWeek = document.getElementById("editHourPerWeek").value;
    var location = document.getElementById("editLocation").value;
    var startingDate = document.getElementById("editStartingDate").value;
    var duration = document.getElementById("editDuration").value;
    var description = document.getElementById("editDescription").value;


    var newStage = {
        'NameInternship': nameInternship,
        'NameCompany': nameCompany,
        'Promotion': promotion,
        'Salary': salary,
        'HourPerWeek': hourPerWeek,
        'Location': location,
        'StartingDate': startingDate,
        'Duration': duration,
        'Description': description,
    }

    const options = {
        method: 'POST',
        body: JSON.stringify(newStage),
        headers: {
            'Content-Type': 'application/json'
        }
    }

    fetch('../InternshipManagement/add', options)
        .then(response => response.text())
        .then(data => {
            alert(data);
            window.location = "../InternshipManagement";
        })
        .catch(error => console.error('Erreur:', error));
}


function addStage(studentsLength) {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
    // Insérer la valeur dans l'élément input
    document.getElementById("editID").value = studentsLength + 1;
    document.getElementById("title-pop-up").textContent = "Ajouter un stage";
    document.getElementById("editNameInternship").value = "";
    document.getElementById("editNameCompany").value = "";
    document.getElementById("editPromotion").value = "";
    document.getElementById("editSalary").value = "";
    document.getElementById("editHourPerWeek").value = "";
    document.getElementById("editLocation").value = "";
    document.getElementById("editStartingDate").value = "";
    document.getElementById("editDuration").value = "";
    document.getElementById("editDescription").value = "";
}


function editStage() {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
    id = Number(document.getElementById("students-profile-id_user").textContent);
    fetch("https://inter-net.loc/InternshipManagement/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json())
        .then((data) => {
            console.log(data);
             document.getElementById("editID").value = data.id;
             document.getElementById("editNameInternship").value = data.job;
             document.getElementById("editNameCompany").value = data.company;
             document.getElementById("editPromotion").value = data.school_grade;
             document.getElementById("editSalary").value = data.salary;
             document.getElementById("editHourPerWeek").value = data.week_hours;
             document.getElementById("editLocation").value = data.location;
             document.getElementById("editStartingDate").value = data.begin_date;
            document.getElementById("editDuration").value = data.duration;
            document.getElementById("editDescription").value = data.description;
        });
}

function delProfile() {
    var id = document.getElementById("students-profile-id_user").textContent;
    console.log("id : " + id);
    fetch("https://inter-net.loc/InternshipManagement/delete/" + id, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
        },
    }).then(response => response.text())
        .then(data => {
            alert(data);
        })
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
            bubbleTemplate.getElementById("Bubble-left-name").textContent = data.job;
            bubbleTemplate.getElementById("Bubble-left-siret").textContent = "N°SIRET: " + data.siret;
            bubbleTemplate.getElementById("Bubble-left-location").textContent = data.location;
            bubbleTemplate.getElementById("Bubble-left-school-grade").textContent = data.school_grade;
            bubbleTemplate.getElementById("Bubble-left-begin-date").textContent = data.begin_date;
            bubbleTemplate.getElementById("Bubble-left-duration").textContent = data.duration;
            bubbleTemplate.getElementById("Bubble-left-company").textContent = data.company;
            bubbleTemplate.getElementById("Bubble-right-advantages-1").textContent = data.advantages;
            bubbleTemplate.getElementById("Bubble-description").textContent = data.description;
            bubbleTemplate.getElementById("Bubble-left-ID").textContent = data.id;

            const bubblePlace = document.getElementById("bubble-place");
            bubblePlace.innerHTML = ""; // Effacer le contenu précédent
            bubblePlace.appendChild(bubbleTemplate);
        });
}

const runway = document.getElementById("search_list-internships");
var oldElement = 1;
loadBubbleStudent(oldElement);
addEventListener("click", (event) => {
    var focusedBubble = Number(document.activeElement.id);
    if (oldElement !== focusedBubble && focusedBubble > 0) {
        document.getElementById("profile_internship").remove();
        loadBubbleStudent(focusedBubble);
        oldElement = focusedBubble;
    }
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
