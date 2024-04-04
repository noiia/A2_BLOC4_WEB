var container_focus = null;

// focus des container

function focus_container(id) {
    if (container_focus === null) {
        document.getElementById(id).classList.add("container_focus");
        container_focus = id;
    } else if (container_focus !== id) {
        document.getElementById(container_focus).classList.remove("container_focus");
        document.getElementById(id).classList.add("container_focus");
        container_focus = id;
    }
}

// ------------------ parti Welcome/Entreprise ----------------

window.onscroll = function () {
    afficherOuMasquerBouton();
};

function afficherOuMasquerBouton() {
    var boutonRetourHaut = document.getElementById("button-retour-haut");
    var runwayContainerInternDetails = document.getElementById("runway-container-intern-details");

    if (document.documentElement.scrollTop < 115) {

        while (boutonRetourHaut.classList.length > 0) {
            boutonRetourHaut.classList.remove(boutonRetourHaut.classList.item(0));
        }
        while (runwayContainerInternDetails.classList.length > 0) {
            runwayContainerInternDetails.classList.remove(runwayContainerInternDetails.classList.item(0));
        }

        boutonRetourHaut.classList.add('display-none');
        runwayContainerInternDetails.classList.add('runway-container-intern-details');
    } else if (115 < document.documentElement.scrollTop && document.documentElement.scrollTop < 2500) {

        while (boutonRetourHaut.classList.length > 0) {
            boutonRetourHaut.classList.remove(boutonRetourHaut.classList.item(0));
        }
        while (runwayContainerInternDetails.classList.length > 0) {
            runwayContainerInternDetails.classList.remove(runwayContainerInternDetails.classList.item(0));
        }
        boutonRetourHaut.classList.add('retourHaut');
        runwayContainerInternDetails.classList.add('runway-container-intern-details-fixed');
    } else if (document.documentElement.scrollTop > 2500) {
        while (boutonRetourHaut.classList.length > 0) {
            boutonRetourHaut.classList.remove(boutonRetourHaut.classList.item(0));
        }
        while (runwayContainerInternDetails.classList.length > 0) {
            runwayContainerInternDetails.classList.remove(runwayContainerInternDetails.classList.item(0));
        }

        boutonRetourHaut.classList.add('retourHaut-bot');
        runwayContainerInternDetails.classList.add('runway-container-intern-details-bot');
    }
}

function retournerEnHaut() {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth"
    })
}

function toggle_navbarMenu() {
    document.querySelector(".navbar-links").classList.toggle('mobile-menu');
}

function toggle_filterMenu() {
    document.querySelector(".parent-filter").classList.toggle('filter-mobile_on-filter');
    document.querySelector(".runway-container").classList.toggle('filter-mobile_on-container');
}

// -------- ajouter/enlever fltre

function add_filter_block(idInput, data) {
    let input = document.getElementById(idInput);
    let children = input.dataset.children;
    let i = 0;
    while (document.getElementById(children + i) !== null) {
        let li = document.getElementById(children + i);
        if (li.hidden) {
            let txt = document.querySelector('#' + children + i + ' > p');
            txt.textContent = data.name;
            input.value = '';
            //input.dataset.values = '';
            if (input.dataset.values === '' || typeof input.dataset.values == 'undefined') {
                input.dataset.values = data.id;
            } else {
                input.dataset.values = input.dataset.values + ';' + data.id;
            }
            txt.dataset.value = data.id;
            li.removeAttribute("hidden");
            console.log("recherche du filtre: '" + txt.textContent + "' dans " + idInput);
            break;
        }
        i++;
    }
}

function del_filter_block(event = Event, idInput) {
    event.currentTarget.hidden = true;
    let input = document.getElementById(idInput);
    let values = input.dataset.values.split(';');
    values.splice(values.indexOf(event.currentTarget.dataset.value), 1); //suprime la valeur souhaite
    values.join(';');
    input.dataset.values = values;
}

// ------------------ parti gestion ---------------------
function toggle_menu() {
    document.querySelector(".main_left").classList.toggle('mobile-menu');
    document.querySelector("#close_menu").classList.toggle('display-cross');
}

function toggle_delete() {
    if (container_focus !== null) {
        document.querySelector(".del_bg").classList.toggle('active-del_block');
    }
}

function del_current_container() {
    document.getElementById(container_focus).classList.add('del_current_container');
    toggle_delete();
    container_focus = null;
}

function validerFormulaire(isCompany) {
    if (isCompany) {
        var numeroSiret = document.getElementById('N-Siret').value;
        if (!/^\d{14}$/.test(numeroSiret)) {
            alert("Le numéro de siret doit contenir une série de 14 chiffres uniquement.");
            return false;
        }
    }

    var champsObligatoires = document.querySelectorAll('[required]');
    for (var i = 0; i < champsObligatoires.length; i++) {
        if (!champsObligatoires[i].value.trim()) {
            alert("Veuillez remplir tous les champs.");
            return false;
        }
    }

    alert("Formulaire soumis avec succès!");
    toggle_hide_popup();
    var formreturn = document.getElementById('Students-Form');
    console.log(formreturn);
    return true;  // Permettre la soumission du formulaire
}

function toggle_hide_popup() {
    document.querySelector('.container-add-student').classList.toggle('hide_container');
}

// ------------ vérifier promotion
function valid_promotion(isCompany = false) {
    var inputValue1 = document.getElementById('select-promotions').value;
    var options1 = document.getElementById('promotions').getElementsByTagName('option');

    var isValid1 = false;
    for (var i = 0; i < options1.length; i++) {
        if (options1[i].value === inputValue1) {
            isValid1 = true;
            break;
        }
    }

    var inputValue2 = document.getElementById('select-campus').value;
    var options2 = document.getElementById('campus').getElementsByTagName('option');

    var isValid2 = false;
    for (var j = 0; j < options2.length; j++) {
        if (options2[j].value === inputValue2) {
            isValid2 = true;
            break;
        }
    }

    if (isValid1 && isValid2) {
        validerFormulaire(isCompany);
    } else if (isValid1 === true && isValid2 === false) {
        alert('Veuillez sélectionner un campus de la liste.');
    } else {
        alert('Veuillez sélectionner une promotion de la liste.');
    }
}


// -------------------- fin partie gestion ------------------- //

function formatDatabaseDate(databaseDate) {
    var data = databaseDate;
    const year = Number(data[0] + data[1] + data[2] + data[3]);
    const month = Number(data[5] + data[6]);
    const day = Number(data[8] + data[9]);
    return `${day}-${month}-${year}`;
}