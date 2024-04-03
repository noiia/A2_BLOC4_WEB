function toggle_search() {
    document.querySelector(".search_list-students").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_student").classList.toggle('mobile-search_menu-profile');
}

function toggle_hide_popup() {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
}

function addProfile() {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
    // Insérer la valeur dans l'élément input
    document.getElementById("editID").value = studentsLength + 1;
    document.getElementById("editName").value = "";
    document.getElementById("editSurname").value = "";
    document.getElementById("editDate").value = "";
    document.getElementById("select-promotions").value = "";
    document.getElementById("editEmail").value = "";
    document.getElementById("select-campus").value = "";
    document.getElementById("editDescription").value = "";
}

document.addEventListener('DOMContentLoaded', function () {
    var button = document.getElementById("select-promotions");
    addEventListener('click', function () {
        if (document.getElementById('select-promotions').value !== "") {
            console.log(document.getElementById('select-promotions').value);
            var input = document.getElementById('select-promotions');
            var selectedValue = input.value;
            var options = document.getElementById('promotions').querySelectorAll('option');
            var selectedId = null;
            options.forEach(function (option) {
                if (option.value === selectedValue) {
                    selectedId = option.getAttribute('data-id');
                }
            });
            console.log(selectedId);

            fetch("https://inter-net.loc/Edition/Etudiants/location/" + selectedId, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                },
            }).then((response) => response.json())
                .then((campus) => {
                    console.log(campus);
                    document.getElementById("select-campus").value = ""
                    document.getElementById("select-campus").value = campus;
                });
        }

    });
});

function newProfileToBdd() {
    var id = document.getElementById("editID").value = studentsLength + 1;
    var Name = document.getElementById("editName").value = "";
    var Surname = document.getElementById("editSurname").value = "";
    var Date = document.getElementById("editDate").value = "";
    var Promotion = document.getElementById("select-promotions").value = "";
    var email = document.getElementById("editEmail").value = "";
    var CampusLocation = document.getElementById("select-campus").value = "";
    var Description = document.getElementById("editDescription").value = "";

    var newProfile = {
        'id': id,
        'Name': Name,
        'Surname': Surname,
        'Date': Date,
        'Promotion': Promotion,
        'Email': email,
        'CampusLocation': CampusLocation,
        'Description': Description
    }

    var jsonTable = JSON.stringify(newProfile);
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "../Students/add", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
        }
    };
    xhr.send(jsonTable);
}

function editProfile() {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
    id = Number(document.getElementById("students-profile-id_user").textContent);
    fetch("https://inter-net.loc/Edition/Etudiants/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json())
        .then((data) => {
            console.log(data);
            document.getElementById("editName").value = data.Name;
            document.getElementById("editSurname").value = data.Surname;
            document.getElementById("editDate").value = data.Birth_date;
            document.getElementById("select-promotions").value = data.Promotion;
            document.getElementById("select-campus").value = data.Campus;
            document.getElementById("editEmail").value = data.Email;
            document.getElementById("editID").value = data.ID_users;
            document.getElementById("editDescription").value = data.Profile_Description;
        });
}

function loadBubbleStudent(id = 1) {
    fetch("https://inter-net.loc/Edition/Etudiants/api/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const mainTemplate = document.getElementById("id-template-students");

            const bubbleTemplate = mainTemplate.content.cloneNode(true);

            bubbleTemplate.getElementById("students-profile-surname").textContent = data.Surname;
            bubbleTemplate.getElementById("students-profile-name").textContent = data.Name;
            bubbleTemplate.getElementById("students-profile-id_user").textContent = data.ID_users;
            bubbleTemplate.getElementById("students-profile-birth_date").textContent = data.Birth_date;
            bubbleTemplate.getElementById("students-profile-mail").textContent = data.Email;
            bubbleTemplate.getElementById("students-profile-description").textContent = data.Profile_Description;
            bubbleTemplate.getElementById("students-profile-promotion").textContent = data.Promotion;
            bubbleTemplate.getElementById("students-profile-campus").textContent = data.location;
            const bubblePlace = document.getElementById("bubble-place");
            bubblePlace.innerHTML = ""; // Effacer le contenu précédent
            bubblePlace.appendChild(bubbleTemplate);
        });
}

const runway = document.getElementById("search_list-students");
var oldElement = 1;
loadBubbleStudent(oldElement);
addEventListener("click", (event) => {
    var focusedBubble = Number(document.activeElement.id);
    if (oldElement !== focusedBubble && focusedBubble > 0) {
        document.getElementById("profile_student").remove();
        loadBubbleStudent(focusedBubble);
        oldElement = focusedBubble;
    }
});

