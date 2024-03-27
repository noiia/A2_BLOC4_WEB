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

//-- filtre

function submitFilter(event = Event) {
    let url = [];
    const filters_html = ["input_localite", "input_skills", "input_company"];
    const filters_url = ["locations", "skills", "companies"];
    const filters2_url = new Map([['Duration', '-duration_internship'], ['Max_places', '-max_places'], ['Hourly_rate', '-hourly_rate'], ['Starting_date', '_start_internship']]);
    if (document.getElementById("general-search_bar").value !== '') {
        url.push('Title=' + document.getElementById("general-search_bar").value);
    }
    for (let f in filters_html) {
        let args = [];
        let values = document.getElementById(filters_html[f]).dataset.values;
        if (typeof values !== 'undefined' && values !== '') {
            args = document.getElementById(filters_html[f]).dataset.values.split(';');
            url.push(filters_url[f] + '=' + args.join(';'));
        }
    }
    for (let [k, v] of filters2_url) {
        let min = document.getElementById('minimum' + v).value;
        let max = document.getElementById('maximum' + v).value;
        if (max !== '' || min !== '') {
            url.push(k + '=' + min + ';' + max);
        }
    }
    console.log(url);
    document.location.href = '?' + url.join('&');
}

function load_filter(event = Event, idFilter = '') {
    if (event.key === 'Enter' || event instanceof PointerEvent) {
        const idToName = new Map([["input_localite", 'locations'], ['input_company', 'companies'], ['input_skills', 'Skills']]);
        let input = document.getElementById(idFilter);
        console.log(idToName.get(idFilter));
        fetch("https://inter-net.loc/Stage/Filtre/" + idToName.get(idFilter) + '=' + input.value, {
            method: "GET",
            headers: {"Content-Type": "application/json",},
        })
            .then((response) => response.json())
            .then((data) => {
                for (let [id, name] of idToName) {
                    if (idFilter === id) {
                        add_filter_block(idFilter, data);
                        break;
                    }
                }
            });
    }
}

function input_filter() {
    document.getElementById("rangeValue").textContent = "Bac+" + document.getElementById("rangeInput").value;
}

//-- ----------------------DEBUT JS SCRIPT STEPHAN BUBULLE-------------------------- 

function toggle_wishlist() {
    document.querySelector(".unselected-wishlist-logo-picture").classList.toggle('remove-wishlist-picture');
    document.querySelector(".selected-wishlist-logo-picture").classList.toggle('is-selected');
}

function toggle_bubulle() {
    document.querySelector(".container-intern-details").classList.toggle('close-tab-clicked');
    document.querySelector("body").classList.toggle('mobile-scroll');
}

// ----------------------FIN JS SCRIPT STEPHAN BUBULLE--------------------------


//- ---------------   JS POSTULATION ------------------------ -->

function block_postulation() {
    document.querySelector("header").classList.toggle("when_postulation");
    document.querySelector(".full-runway").classList.toggle("when_postulation");
    document.querySelector("footer").classList.toggle("when_postulation");
    document.querySelector("body").classList.toggle("disable_scroll");
    document.querySelector(".postulation-bg").classList.toggle("postulation-off");
    document.querySelector(".postulation-bg").classList.toggle("postulation-on");
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
            txt += '<img src="../../Assets/Icones/poubelle-de-recyclage.png" onclick="del_file(\'' + name + '\');"/>';
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
    const uri = "../../Assets/files/";
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

            function checkFileExists(file, callback) {
                $.ajax({
                    type: 'HEAD',
                    url: file,
                    success: function () {
                        callback(true);
                    },
                    error: function () {
                        callback(false);
                    }
                });
            }

            var imagePath = 'images/CompanyLogos/logo_' + data.id;
            checkFileExists(imagePath + '.jpg', function (success) {
                if (success) {
                    finalImagePath = imagePath + '.jpg'
                    bubbleTemplate.getElementById("Big-bubble-logo").src = finalImagePath;
                    container.append(bubbleTemplate);
                } else {
                    checkFileExists(imagePath + '.jpeg', function (success) {
                        if (success) {
                            finalImagePath = imagePath + '.jpeg'
                            bubbleTemplate.getElementById("Big-bubble-logo").src = finalImagePath;
                            container.append(bubbleTemplate);
                        } else {
                            checkFileExists(imagePath + '.png', function (success) {
                                if (success) {
                                    finalImagePath = imagePath + '.png'
                                    bubbleTemplate.getElementById("Big-bubble-logo").src = finalImagePath;
                                    container.append(bubbleTemplate);
                                } else {
                                    console.log('aucune image en mémoire')
                                }
                            });
                        }
                    });
                }
            });

            const skillsContainer = document.getElementById("container-skills");
            for (let skills of data.skills) {
                const skillsTemplate = littleTemplate.content.cloneNode(true);
                skillsTemplate.getElementById("skills").textContent = skills;
                skillsContainer.append(skillsTemplate);
            }
        });
}


const runway = document.getElementById("runway-element")
var oldElement = 1;
loadBubbleData(oldElement);
addEventListener("click", (event) => {
    var focusedBubble = Number(document.activeElement.id);
    if (oldElement !== focusedBubble && focusedBubble > 0) {
        document.getElementById("runway-container-intern-details").remove();
        loadBubbleData(focusedBubble);
        oldElement = focusedBubble;
    }
});
