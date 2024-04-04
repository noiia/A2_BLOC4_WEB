function toggle_search() {
    document.querySelector(".search_list-companies").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_company").classList.toggle('mobile-search_menu-profile');
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

function getCity(street, zipCode) {
    return new Promise((resolve, reject) => {
        const options = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        };

        fetch('https://api-adresse.data.gouv.fr/search/?q=' + street + '&postcode=' + zipCode, options)
            .then(response => response.json())
            .then(data => {
                const feature = data.features[0];
                const properties = feature.properties;
                resolve(properties.city);
            })
            .catch(error => {
                console.error('Erreur:', error);
                reject(error);
            });
    });
}

function showLocation(id = 0) {
    fetch("https://inter-net.loc/Edition/Location/api/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json())
        .then((data) => {
            const mainTemplate = document.getElementById("template-location");
            const bubbleContainer = document.getElementById("container-location");
            const bubbleTemplate = mainTemplate.content.cloneNode(true);
            bubbleTemplate.getElementById("title-address").textContent = data.street + " - " + data.zipcode;
            bubbleTemplate.getElementById("title-address").id = data.id;
            bubbleContainer.append(bubbleTemplate);
        });
}

idNewLocation = 0;

function newAddressToBdd() {
    var street = document.getElementById("input-adresse").value;
    var zipCode = document.getElementById("input-code-postal").value;
    getCity(street, zipCode).then(city => {
        var newLocation = {
            'street': street,
            'zipCode': zipCode,
            'city': city,
        }
        console.log(newLocation);
        const options = {
            method: 'POST',
            body: JSON.stringify(newLocation),
            headers: {
                'Content-Type': 'application/json'
            }
        }
        console.log(options);
        fetch('../Edition/Location/add', options)
            .then(response => response.text())
            .then(data => {
                console.log(data);
                var clearedData = JSON.parse(data);
                idNewLocation = clearedData.id;
                console.log(idNewLocation);
                showLocation(JSON.parse(data).id)
            })
            .catch(error => console.error('Erreur:', error));
    });
}


function newCompanyToBdd() {
    var name = document.getElementById("add-Name").value;
    var SIRET = document.getElementById("N-Siret").value;
    var sector = document.getElementById("select-sector").value;
    var email = document.getElementById("add-email").value;
    var date = document.getElementById("id-input-creation-date").value;
    var staff = document.getElementById("add-staff").value;
    var type = document.getElementById("select-type").value;
    var website = document.getElementById("add-website").value;
    var Description = document.getElementById("add-description").value;
    var ID_location = idNewLocation;
    console.log(ID_location);
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
    var dateString = new Date(Date.parse(date));

    var idEditedCompany = 0;
    if (document.getElementById("add-id-company").value !== ("" || null)) {
        idEditedCompany = document.getElementById("add-id-company").value;
    }

    var newCompany = {
        'name': name,
        'SIRET': SIRET,
        'Date': dateString,
        'staff': staff,
        'Sector': sector,
        'type': type,
        'Email': email,
        'Website': website,
        'Description': Description,
        'id_location': ID_location,
        'editedCompany': idEditedCompany
    }
    console.log(newCompany);
    const options = {
        method: 'POST',
        body: JSON.stringify(newCompany),
        headers: {
            'Content-Type': 'application/json'
        }
    }
    fetch('../Edition/Entreprises/add', options)
        .then(response => response.text())
        .then(data => {
            alert(data);
        })
        .catch(error => console.error('Erreur:', error));
    //}
}

function editCompany() {
    toggle_hide_popup();
    document.getElementById("title-pop-up").textContent = "Editer une entreprise";
    document.querySelector('.container-add-student').classList.toggle('hide_container');
    id = Number(document.getElementById("company-ID").textContent);
    fetch("https://inter-net.loc/Edition/Entreprises/api/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    }).then((response) => response.json())
        .then((data) => {
            console.log(data);
            document.getElementById("add-Name").value = data.company;
            document.getElementById("N-Siret").value = data.SIRET;
            document.getElementById("add-email").value = data.sector;
            document.getElementById("id-input-creation-date").value = data.birthdate;
            document.getElementById("add-staff").value = data.staff;
            document.getElementById("select-type").value = data.type;
            document.getElementById("add-website").value = data.website;
            document.getElementById("add-description").value = data.description;

        });
}

function delCompany() {
    var id = document.getElementById("company-ID").textContent;
    console.log(id);
    fetch("https://inter-net.loc/Edition/Entreprises/delete/" + id, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
        },
    }).then(response => response.text())
        .then(data => {
            alert(data);
        })
}

function loadBubbleCompanyManagement(id = 1) {
    fetch("https://inter-net.loc/Edition/Entreprises/api/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            const mainTemplate = document.getElementById("main-bubble");
            const bubbleContainer = document.getElementById("main-block");
            const bubbleTemplate = mainTemplate.content.cloneNode(true);
            bubbleTemplate.getElementById("company-name").textContent = data.company;
            bubbleTemplate.getElementById("company-SIRET").textContent = data.SIRET;
            bubbleTemplate.getElementById("company-type").textContent = data.type;
            bubbleTemplate.getElementById("company-ID").textContent = data.id;
            bubbleTemplate.getElementById("company_description").textContent = data.description;
            bubbleTemplate.getElementById("company-people").textContent = data.staff;
            bubbleTemplate.getElementById("company-birthdate").textContent = formatDatabaseDate(data.birthdate.date);
            bubbleTemplate.getElementById("website-link").href = data.website;
            bubbleTemplate.getElementById("website-link").textContent = data.website;
            bubbleTemplate.getElementById("company_logo").src = "../" + data.logo_path;
            bubbleContainer.append(bubbleTemplate);

            const skillTemplate = document.getElementById("skill-template");
            const skillContainer = document.getElementById("skills-container");
            for (let skill of data.sector) {
                const cloneSkillTemplate = skillTemplate.content.cloneNode(true);
                cloneSkillTemplate.getElementById("skill-bubble").textContent = skill;
                skillContainer.append(cloneSkillTemplate);
            }


        });
}

function loadRunway() {
    fetch("https://inter-net.loc/Edition/Entreprises/mini-api", {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            const mainTemplate = document.getElementById("mini-company-template");
            const bubblePlace = document.getElementById("company-runway");

            for (let companies of data) {
                const bubbleTemplate = mainTemplate.content.cloneNode(true);

                bubbleTemplate.getElementById("mini-company").textContent = companies.name;
                bubbleTemplate.getElementById("mini-company").id = companies.id;

                bubblePlace.append(bubbleTemplate);
            }
        });
}

const runway = document.getElementById("search_list-students");
var oldElement = 1;
loadBubbleCompanyManagement(oldElement);
loadRunway();
addEventListener("click", (event) => {
    var focusedBubble = Number(document.activeElement.id);
    if (oldElement !== focusedBubble && focusedBubble > 0) {
        document.getElementById("template-space").remove();
        loadBubbleCompanyManagement(focusedBubble);
        oldElement = focusedBubble;
    }
});

