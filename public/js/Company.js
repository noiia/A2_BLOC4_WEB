function loadCompanyBubbleData(id = 1) {
    console.log("https://inter-net.loc/Entreprise/api/" + id);
    fetch("https://inter-net.loc/Entreprise/api/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const mainTemplate = document.getElementById("main-company");
            const bubbleContainer = document.getElementById("bubble-place");
            const bubbleTemplate = mainTemplate.content.cloneNode(true);
            bubbleTemplate.getElementById("id-company").textContent = data.id;
            bubbleTemplate.getElementById("Big-bubble-name").textContent = data.company;
            bubbleTemplate.getElementById("Big-bubble-location").textContent = data.zip_code + ' - ' + data.location;
            bubbleTemplate.getElementById("Big-bubble-number-student").textContent = data.number_former_intern + ' étudiants';
            bubbleTemplate.getElementById("rangeValue2").textContent = data.medium_rate;
            bubbleTemplate.getElementById("rangeInput2").value = data.medium_rate;
            bubbleTemplate.getElementById("Big-bubble-description").textContent = data.description;
            bubbleTemplate.getElementById("internship-number").textContent = data.number_of_internship + " stages disponibles:";
            bubbleTemplate.getElementById("Big-bubble-logo").src = data.logo_path;
            bubbleContainer.append(bubbleTemplate);

            const miniInternshipTemplate = document.getElementById("mini-internship");
            const sectorTemplate = document.getElementById("sector-template");
            const commentTemplate = document.getElementById("comment-template");
            const sectorContainer = document.getElementById("container-company-details-sector-name-list");
            const internshipContainer = document.getElementById("mini-internship-container");
            const commentContainer = document.getElementById("comment-container");

            for (let sector of data.sector) {
                const cloneSectorTemplate = sectorTemplate.content.cloneNode(true);
                cloneSectorTemplate.getElementById("sector-ref").textContent = sector;
                sectorContainer.append(cloneSectorTemplate);
            }

            for (let internship of data.internship) {
                const cloneInternshipTemplate = miniInternshipTemplate.content.cloneNode(true);
                cloneInternshipTemplate.getElementById("internship-title").textContent = internship.title;
                cloneInternshipTemplate.getElementById("internship-location").textContent = "Site de : " + internship.location;
                cloneInternshipTemplate.getElementById("internship-starting-date").textContent = "A partir du " + internship.starting_date;
                cloneInternshipTemplate.getElementById("internship-duration").textContent = internship.duration + " semaines";
                internshipContainer.append(cloneInternshipTemplate);

                const skillTemplate = document.getElementById("skills-template");
                const skillContainer = document.getElementById("skills-container");

                // Initialiser un compteur pour limiter le nombre de compétences affichées à trois
                let skillCount = 0;

                // Parcourir les compétences du stage actuel
                for (let skill of internship.skill) {
                    // Vérifier si le nombre de compétences affichées est inférieur à trois
                    if (skillCount < 3) {
                        // Cloner le template de compétence et l'ajouter au conteneur de compétences
                        const cloneSkillTemplate = skillTemplate.content.cloneNode(true);
                        cloneSkillTemplate.getElementById("skills").textContent = skill;
                        skillContainer.append(cloneSkillTemplate);

                        // Incrémenter le compteur de compétences
                        skillCount++;
                    } else {
                        // Sortir de la boucle si trois compétences ont été affichées
                        break;
                    }
                }
            }

            for (let comment of data.comment) {
                const cloneCommentTemplate = commentTemplate.content.cloneNode(true);
                cloneCommentTemplate.getElementById("comment-user").textContent = comment.user + " - " + comment.note + "/10";
                cloneCommentTemplate.getElementById("comment-description").textContent = comment.description;
                commentContainer.append(cloneCommentTemplate);
            }
        });
}

const runway = document.getElementById("runway-element")
var oldElement = 1;
loadCompanyBubbleData(oldElement);
addEventListener("click", (event) => {
    var focusedBubble = Number(document.activeElement.id);
    if (oldElement !== focusedBubble && focusedBubble > 0) {
        document.getElementById("runway-container-intern-details").remove();
        loadCompanyBubbleData(focusedBubble);
        oldElement = focusedBubble;
    }
});

//filtre

function load_filter(event = Event, idFilter = '') {
    if (event.key === 'Enter' || event instanceof PointerEvent) {
        const idToName = new Map([["input_localite", 'locations'], ['input_activity', 'sector']]);
        let input = document.getElementById(idFilter);
        console.log(idToName.get(idFilter));
        fetch("https://inter-net.loc/Entreprise/Filtre/" + idToName.get(idFilter) + '=' + input.value, {
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
    document.getElementById("rangeValue").textContent = document.getElementById("rangeInput").value + "/10";
}

function submitFilter(event = Event) {
    let url = [];
    const filters_html = ["input_localite", "input_activity"];
    const filters_url = ["locations", "sector"];
    if (document.getElementById("general-search_bar").value !== '') {
        url.push('Name=' + document.getElementById("general-search_bar").value);
    }
    for (let f in filters_html) {
        let args = [];
        let values = document.getElementById(filters_html[f]).dataset.values;
        if (typeof values !== 'undefined' && values !== '') {
            args = document.getElementById(filters_html[f]).dataset.values.split(';');
            url.push(filters_url[f] + '=' + args.join(';'));
        }
    }
    let range = document.getElementById('rangeInput').value;
    if (range !== '1') {
        url.push('rates=' + range);
    }

    let min = document.getElementById('minimum-duration_internship').value;
    let max = document.getElementById('maximum-duration_internship').value;
    if (max !== '' || min !== '') {
        url.push('users=' + min + ';' + max);
    }
    console.log(url);
    document.location.href = '?' + url.join('&');
}

//fin filtre
function toggle_bubulle() {
    document.querySelector(".container-intern-details").classList.toggle('close-tab-clicked');
    document.querySelector("body").classList.toggle('mobile-scroll');
}

window.addEventListener("resize", () => {
    const widthScreen = window.innerWidth;
    if (widthScreen > 850) {
        document.querySelector(".parent-filter").classList.remove('filter-mobile_on-filter');
        document.querySelector(".runway-container").classList.remove('filter-mobile_on-container');
    }
});

function post_comment() {
    var companyId = Number(document.getElementById("id-company").textContent);
    var rate = Number(document.getElementById("rangeValue3").textContent);
    var comment = document.getElementById("comment-area").value;

    var json_data = {
        companyId: companyId,
        rate: rate,
        comment: comment
    };
    console.log(json_data);
    $.post("../Entreprise/addComment", {json: JSON.stringify(json_data)}, function (response) {
            console.log(response);
            document.location.href = "../Entreprise";
        },
        'json')
        .fail(function (xhr, status, error) {
            console.error(status);
            console.error(xhr.responseText);
            console.error(error);
        });
}

/* ------------------- PAGINATION ------------------*/
function updatePage(currentPage, totalPages, companiesPerPage) {
    var start = (currentPage - 1) * companiesPerPage;
    var end = start + companiesPerPage;
    var buttonsContainer = document.getElementById("pagination-buttons");
    buttonsContainer.innerHTML = currentPage + " / " + totalPages;

    var backButton = document.getElementById("id-button-back");
    if (currentPage === 1) {
        backButton.disabled = true;
    } else {
        backButton.disabled = false;
        backButton.addEventListener("click", function () {
            currentPage -= 1;
            updatePage(currentPage, totalPages, companiesPerPage);
        });
    }

    var nextButton = document.getElementById("id-button-next");
    if (currentPage === totalPages) {
        nextButton.disabled = true;
    } else {
        nextButton.disabled = false;
        nextButton.addEventListener("click", function () {
            currentPage += 1;
            updatePage(currentPage, totalPages, companiesPerPage);
        });
    }

    var boutons = document.querySelectorAll('.container');
    boutons.forEach(function (bouton, index) {
        if (index >= start && index < end) {
            bouton.style.display = 'block';
        } else {
            bouton.style.display = 'none';
        }
    });
}


document.addEventListener("DOMContentLoaded", function () {
    var currentPage = 1;
    var buttonsContainer = document.getElementById("pagination-buttons");
    var totalPages = parseInt(buttonsContainer.getAttribute("data-total-pages"));
    var companiesPerPage = parseInt(buttonsContainer.getAttribute("data-companies-per-page"));

    updatePage(currentPage, totalPages, companiesPerPage); // Appeler la fonction pour afficher la première page initialement

    document.getElementById("id-button-back").addEventListener("click", function () {
        currentPage -= 1;
        updatePage(currentPage, totalPages, companiesPerPage);
    });
    document.getElementById("id-button-next").addEventListener("click", function () {
        currentPage += 1;
        updatePage(currentPage, totalPages, companiesPerPage);
    });
});
