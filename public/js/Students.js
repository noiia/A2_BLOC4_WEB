/*$(document).ready(function () {
    var Value = "role";
    var PHPfiles = "Students.php";
    data = {
        action: Value
    };
    $.post(PHPfiles, data, function (response) {
        $(".main_left").append(response);
    })
})*/

/*$(document).ready(function () {
    var Value = "role";
    var PHPfiles = "Students.php";
    data = {
        action: Value
    };
    $.post(PHPfiles, data, function (response) {
        $(".main_left").append(response);
    })
})*/

function toggle_search() {
    document.querySelector(".search_list-students").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_student").classList.toggle('mobile-search_menu-profile');
}

function toggle_hide_popup() {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
}

function addProfile(studentsLength) {
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


function editProfile() {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
    id = Number(document.getElementById("students-profile-id_user").textContent);
    fetch("https://inter-net.loc/Etudiants/" + id, {
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
    fetch("https://inter-net.loc/Etudiants/" + id, {
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
            bubbleTemplate.getElementById("students-profile-campus").textContent = data.Campus;
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

