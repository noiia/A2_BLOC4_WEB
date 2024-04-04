function toggle_search() {
    document.querySelector(".search_list-students").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_student").classList.toggle('mobile-search_menu-profile');
}

function toggle_hide_popup() {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
}

function addProfile() {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
    document.getElementById("title-pop-up").textContent = "Ajouter un étudiant";
    document.getElementById("editID").value = "";
    document.getElementById("editName").value = "";
    document.getElementById("editSurname").value = "";
    document.getElementById("editDate").value = "";
    document.getElementById("select-promotions").value = "";
    document.getElementById("editEmail").value = "";
    document.getElementById("select-campus").value = "";
    document.getElementById("editDescription").value = "";
}


var selectedId = null;
document.addEventListener('DOMContentLoaded', function () {
    var button = document.getElementById("select-promotions");
    addEventListener('click', function () {
        if (document.getElementById('select-promotions').value !== "") {
            console.log(document.getElementById('select-promotions').value);
            var input = document.getElementById('select-promotions');
            var selectedValue = input.value;
            var options = document.getElementById('promotions').querySelectorAll('option');

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

function uploadPicture(file) {
    return new Promise((resolve, reject) => {
        console.log("iuifesfsefesf")
        const formData = new FormData();
        formData.append('file', file);
        const url = '../Edition/Etudiants/addPicture';
        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Erreur lors de l\'envoi du fichier.');
            })
            .then(data => {
                console.log(data); // Affichez la réponse du serveur
            })
            .catch(error => {
                console.error('Erreur:', error);
            });

    });
}


function newProfileToBdd() {
    var Name = document.getElementById("editName").value;
    var Surname = document.getElementById("editSurname").value;
    var date = document.getElementById("editDate").value;
    var idPromotion = Number(selectedId);
    var email = document.getElementById("editEmail").value;
    var Description = document.getElementById("editDescription").value;
    const fileInput = document.getElementById('file-input');
    const file = fileInput.files[0];
    console.log(file);
    if (file) {
        var picturePath = file.name;
        console.log(picturePath);
        uploadPicture(file).then(() => {
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
        const options = {
            method: 'POST',
            body: JSON.stringify(newProfile),
            headers: {
                'Content-Type': 'application/json'
            }
        }
        fetch('../Edition/Etudiants/add', options)
            .then(response => response.text())
            .then(data => {
                window.location = "../Edition/Etudiants"
                alert(data);
            })
            .catch(error => console.error('Erreur:', error));
    }
}

function editProfile() {
    document.getElementById("title-pop-up").textContent = "Editer un étudiant";
    document.querySelector('.container-add-student').classList.toggle('hide_container');
    id = Number(document.getElementById("students-profile-id_user").textContent);
    fetch("https://inter-net.loc/Edition/Etudiants/api/" + id, {
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
            document.getElementById("student_photo").src = data.ProfilePicture;

        });
}

function delProfile() {
    var id = document.getElementById("students-profile-id_user").textContent;
    console.log("id : " + id);
    fetch("https://inter-net.loc/Edition/Etudiants/delete/" + id, {
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
            if (data.ProfilePicture !== "") {
                bubbleTemplate.getElementById("student_photo").src = data.ProfilePicture;
            } else {
                bubbleTemplate.getElementById("student_photo").src = "../images/Icones/profile.png"
            }
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