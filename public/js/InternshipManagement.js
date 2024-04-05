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

function showSkill(id = 0) {
    fetch("https://inter-net.loc/Edition/Competence/api/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json())
        .then((data) => {
            const mainTemplate = document.getElementById("template-skills");
            const bubbleContainer = document.getElementById("skills-container");
            const bubbleTemplate = mainTemplate.content.cloneNode(true);
            bubbleTemplate.getElementById("add-skills").textContent = data.name;
            bubbleTemplate.getElementById("add-skills").id = data.id;
            console.log(data.id);
            bubbleContainer.append(bubbleTemplate);
        });
}

var skills = [];

function newSkillToBdd() {
    var skill = document.getElementById("input-skills").value;
    var newSkills = {
        'skill': skill,
    }
    console.log(newSkills);
    const options = {
        method: 'POST',
        body: JSON.stringify(newSkills),
        headers: {
            'Content-Type': 'application/json'
        }
    }
    console.log(options);
    fetch('../Edition/Competence/add', options)
        .then(response => response.text())
        .then(data => {
            console.log("data" + data);
            var clearedData = JSON.parse(data);
            idNewSkill = clearedData.id;
            console.log(idNewSkill);
            skills.push(idNewSkill);
            showSkill(idNewSkill)
        })
        .catch(error => console.error('Erreur:', error));
}

function delSkills(id) {

}

var validatedLocation;
/*
function controllLocation() {
    var location = document.getElementById("add-location").value;
    console.log(location);
    fetch("https://inter-net.loc/Edition/Location/reverseApi/" + location, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json())
        .then((data) => {
            validatedLocation = data;
        });
}
*/
var validatedCompany;

function controllCompany() {
    var location = document.getElementById("add-company").value;
    console.log(location);
    fetch("https://inter-net.loc/Edition/Entreprises/reverseApi/" + location, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json())
        .then((data) => {
            validatedCompany = data.id_company;
            validatedLocation = data.id_location;
            document.getElementById("add-location").value = data.location_name;
        });
}

function newInternshipToBdd() {
    var title = document.getElementById("add-title").value;
    var school_grade = document.getElementById("select-student-year").value;
    var hourly_rate = document.getElementById("add-hourly-rate").value;
    var hour_per_week = document.getElementById("add-hour-per-week").value;
    var begin_date = document.getElementById("id-input-starting-date").value;
    var internship_duration = document.getElementById("add-internship-duration").value;
    var Description = document.getElementById("add-description").value;
    var advantages = document.getElementById("add-advantages").value;

    /*
    const fileInput = document.getElementById('file-input');
    const file = fileInput.files[0];
    console.log(file);
    if (file) {
        var picturePath = file.name;
        console.log(picturePath);
        uploadPicture(file).then(() => {
            console.log("on est juste après l'upload");
            var dateString = new Date(Date.parse(date));
            var idEditedUser = 0;
            if (document.getElementById("editID").value != null) {
                idEditedUser = document.getElementById("editID").value;
            }
            var newProfile = {
                'Name': Name,
                'Surname': Surname,
                'Date': dateString,
                'idPromotion': idPromotion,
                'Email': email,
                'Description': Description,
                'picturePath': picturePath,
                'editedUser': idEditedUser
            }
            console.log(newProfile);
            console.log("on est avant options");
            const options = {
                method: 'POST',
                body: JSON.stringify(newProfile),
                headers: {
                    'Content-Type': 'application/json'
                }
            }
            console.log("on est avant fetchs");
            fetch('../Edition/Etudiants/add', options)
                .then(response => response.text())
                .then(data => {
                    alert(data);
                })
                .catch(error => console.error('Erreur:', error));
        });
    } else {
*/
    var dateString = new Date(Date.parse(begin_date));

    //var idEditedCompany = 0;
    //if (document.getElementById("add-id-company").value !== ("" || null)) {
    //    idEditedCompany = document.getElementById("add-id-company").value;
    //}

    var newInternship = {
        'title': title,
        'company': validatedCompany,
        'date': dateString,
        'school_grade': school_grade,
        'hourly_rate': hourly_rate,
        'hour_per_week': hour_per_week,
        'location': validatedLocation,
        'internship_duration': internship_duration,
        'Description': Description,
        'advantages': advantages,
        'skills': skills
    }
    console.log(newInternship);
    const options = {
        method: 'POST',
        body: JSON.stringify(newInternship),
        headers: {
            'Content-Type': 'application/json'
        }
    }
    fetch('../Edition/Stages/add', options)
        .then(response => response.text())
        .then(data => {
            alert(data);
        })
        .catch(error => console.error('Erreur:', error));
    //}
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
