$(document).ready(function () {
    $("#postulation-button_postulation").click(function () {
        console.log("postulation");
        var postulationValue = "postulation";
        var welcomePHP = "Welcome.php";
        data = {
            action: postulationValue
        };
        $.post(welcomePHP, data, function (response) {
        })
    });
    var Value = "profile";
    var PHPfiles = "Welcome.php";
    data = {
        action: Value
    };
    $.post(PHPfiles, data, function (response) {
        $("#navbar-profile").append(response);
    });
})


$(document).ready(function () {
    var Value = "profile";
    var PHPfiles = "Welcome.php";
    data = {
        action: Value
    };
    $.post(PHPfiles, data, function (response) {
        $("#navbar-profile").append(response);
    });
});

function input_filter() {
    document.getElementById("rangeValue").textContent = "Bac+" + document.getElementById("rangeInput").value;
}

//-- ----------------------DEBUT JS SCRIPT STEPHAN BUBULLE-------------------------- 

function add_or_del_in_wish(isAWish) {
    var internshipID = Number(document.getElementById("Big-bubble-ID").textContent);
    console.log(internshipID);
    if (isAWish === true) {
        document.querySelector(".selected-wishlist-logo-picture").classList.toggle('is-selected');
        document.querySelector(".unselected-wishlist-logo-picture").classList.toggle('remove-wishlist-picture');
        console.log(isAWish);
        fetch("https://inter-net.loc/Wishlist/add/" + internshipID, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then(response => {
                if (response.ok) {
                    document.location.href = "../Stage?id=" + internshipID;
                } else {
                    alert("L'ajout a échoué.");
                }
            })
            .catch(error => {
                alert("Une erreur s'est produite lors de la création :", error);
            });
    } else {
        document.querySelector(".selected-wishlist-logo-picture").classList.toggle('is-selected');
        document.querySelector(".unselected-wishlist-logo-picture").classList.toggle('remove-wishlist-picture');
        fetch("https://inter-net.loc/Wishlist/delete/" + internshipID, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then(response => {
                if (response.ok) {
                    document.location.href = "../Stage?id=" + internshipID;
                } else {
                    alert("La suppression a échoué.");
                }
            })
            .catch(error => {
                alert("Une erreur s'est produite lors de la suppression :", error);
            });
    }
}

function toggle_bubulle() {
    document.querySelector(".container-intern-details").classList.toggle('close-tab-clicked');
    document.querySelector("body").classList.toggle('mobile-scroll');
}

// ----------------------FIN JS SCRIPT STEPHAN BUBULLE--------------------------


//- ---------------   JS POSTULATION ------------------------ -->

function block_postulation(active = false) {
    document.querySelector("header").classList.toggle("when_postulation");
    document.querySelector(".full-runway").classList.toggle("when_postulation");
    document.querySelector("footer").classList.toggle("when_postulation");
    document.querySelector("body").classList.toggle("disable_scroll");
    document.querySelector(".postulation-bg").classList.toggle("postulation-off");
    document.querySelector(".postulation-bg").classList.toggle("postulation-on");

    id = document.getElementById("Big-bubble-ID").textContent;

    fetch("https://inter-net.loc/Stage/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const postulationTemplate = document.getElementById("postulation-block");
            const container = document.getElementById("postulation-place");

            const postulationClone = postulationTemplate.content.cloneNode(true);

            postulationClone.getElementById("postulation-job").textContent = data.job;
            postulationClone.getElementById("postulation-company").textContent = data.company;
            postulationClone.getElementById("postulation-location").textContent = data.location;

            container.append(postulationClone);
        });
}

//--------------FIN JS POSTULATION ------------------------ -->

// input file
function do_add_file() {
    document.getElementById('file-input').click();
}

function del_file(id) {
    document.getElementById(id).classList.add('file-hidden');
    document.getElementById(id).id += "-hidden"
    //suprimer dans le serveur
}

function open_file(name) {
    window.open(name);
}

function add_file() {
    var file = document.getElementById('file-input').files[0];
    if (file.type === "application/pdf") {
        const name = file.name.replace(/ /g, '_'); //regex le g signifie : cherche plusieurs fois
        if (document.getElementById(name) == null) {
            var txt = "\n";
            txt += '<div class="postulation-docs" id="' + name + '">';
            txt += '<p onclick="open_file(\'../../Assets/image/cesi-logo.png\')">' + name + '</p>';
            txt += '<img src="images/Icones/poubelle-de-recyclage.png" onclick="del_file(\'' + name + '\');"/>';
            txt += '</div>';
            document.querySelector(".postulation-list_docs").innerHTML += txt;
            console.log('fichier sélectionné:', file);
            console.log(txt);
            //send_file(file);
        } else {
            console.log("Fichier deja existant");
            alert("Vous avez dejà un fichier avec ce nom.\nChanger votre fichier de nom ou supprimer l'ancien.");
        }
    } else if (file) {
        console.log('type de fichier non accepte:', file.type);
        alert("Seul le type de fichier .pdf est accepté");
    } else {
        console.log('aucun fichier sélectionner');
    }
}

function send_file(file) {
    //const uri = "C:/Program Files/XAMPP/htdocs/imgs"; // Remplacez "http://example.com/upload" par l'URL de votre point d'extrémité de téléversement sur le serveur Apache
    const uri = "./files";
    const xhr = new XMLHttpRequest(); // Création d'une nouvelle requête XMLHttpRequest
    const fd = new FormData(); // Création d'un objet FormData pour contenir les données à envoyer

    xhr.open("POST", uri, true); // Ouverture d'une connexion avec la méthode POST à l'URL spécifiée en mode asynchrone
    xhr.onreadystatechange = () => { // Fonction de rappel exécutée lorsque l'état de la requête change
        if (xhr.readyState === 4 && xhr.status === 200) { // Vérification que la requête est terminée et que la réponse du serveur est OK
            alert(xhr.responseText); // Affichage de la réponse du serveur dans la console
        }
    };
    fd.append('file', file); // Ajout du fichier à envoyer à l'objet FormData sous la clé 'file'
    // Envoi de l'objet FormData contenant le fichier
    xhr.send(fd);
}

function createPostulationPDF(username) {
    var doc = new jsPDF();
    motivationLetter = document.getElementById("postulation-motivation_letter").textContent;
    doc.text(motivationLetter, 10, 10);
    fileName = 'Lettre-de-motivation-' + username + '.pdf';
    return doc.save(fileName);
}

function postulation() {
    customPostulation = document.getElementById("postulation-motivation_letter").textContent;
    if (customPostulation !== null) {
        username = document.getElementById("user-name-session").textContent;
        createPostulationPDF(username);
    }

}

window.addEventListener("resize", () => {
    const widthScreen = window.innerWidth;
    if (widthScreen > 850) {
        document.querySelector(".parent-filter").classList.remove('filter-mobile_on-filter');
        document.querySelector(".runway-container").classList.remove('filter-mobile_on-container');
    }
});


function loadBubbleData(id = 1) {
    fetch("https://inter-net.loc/Stage/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const mainTemplate = document.getElementById("main-internship");
            const littleTemplate = document.getElementById("skills-template");

            const container = document.getElementById("bubble-place");

            const bubbleTemplate = mainTemplate.content.cloneNode(true);

            bubbleTemplate.getElementById("Big-bubble-name").textContent = data.job;
            bubbleTemplate.getElementById("Big-bubble-company-link").href = "https://inter-net.loc/Entreprise/" + data.company;
            bubbleTemplate.getElementById("Big-bubble-company-link").textContent = data.company;
            bubbleTemplate.getElementById("Big-bubble-location").textContent = data.location;
            bubbleTemplate.getElementById("Big-bubble-school-grade").textContent = data.school_grade;
            bubbleTemplate.getElementById("Big-bubble-month-payment").textContent = data.week_payment + " € par semaines soit " + data.hour_payment + " €/h";
            bubbleTemplate.getElementById("Big-bubble-begin-date").textContent = data.begin_date;
            bubbleTemplate.getElementById("Big-bubble-duration").textContent = data.duration;
            bubbleTemplate.getElementById("Big-bubble-place").textContent = data.taken_places + "/" + data.max_places;
            bubbleTemplate.getElementById("Big-bubble-advantages").textContent = data.advantages;
            bubbleTemplate.getElementById("Big-bubble-description").textContent = data.description;
            bubbleTemplate.getElementById("Big-bubble-ID").textContent = data.id;
            bubbleTemplate.getElementById("Big-bubble-logo").src = data.logo_path;

            container.append(bubbleTemplate);

            if (data.isAWish) {
                document.querySelector(".selected-wishlist-logo-picture").classList.toggle('is-selected');
                document.querySelector(".unselected-wishlist-logo-picture").classList.toggle('remove-wishlist-picture');
            }
            const skillsContainer = document.getElementById("container-skills");
            for (let skills of data.skills) {
                const skillsTemplate = littleTemplate.content.cloneNode(true);
                skillsTemplate.getElementById("skills").textContent = skills;
                skillsContainer.append(skillsTemplate);
            }
        });
}


var url = window.location.href;
var oldElement;
if (url !== "https://inter-net.loc/Stage") {
    if (url.split('?')[1] !== null) {
        var queryString = url.split('?')[1];
        var params = queryString.split('&');
        var queryParams = {};
        params.forEach(function (param) {
            var keyValue = param.split('=');
            var key = keyValue[0];
            var value = keyValue[1];
            key = decodeURIComponent(key);
            value = decodeURIComponent(value);
            queryParams[key] = value;
        });

        const runway = document.getElementById("runway-element")
        if (Number(queryParams["id"]) !== null) {
            oldElement = Number(queryParams["id"]);
            console.log(Number(queryParams["id"]));
        }
    }
} else {
    oldElement = 1;
}

loadBubbleData(oldElement);
addEventListener("click", (event) => {
    var focusedBubble = Number(document.activeElement.id);
    if (oldElement !== focusedBubble && focusedBubble > 0) {
        document.getElementById("runway-container-intern-details").remove();
        loadBubbleData(focusedBubble);
        oldElement = focusedBubble;
    }
});

