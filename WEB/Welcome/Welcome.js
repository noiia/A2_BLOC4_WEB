$(document).ready(function(){
    $("#postulation-button_postulation").click(function(){
        console.log("postulation");
        var postulationValue = "postulation";
        var welcomePHP = "Welcome.php";
        data = {
            action : postulationValue
        };
        $.post(welcomePHP, data, function(response){})
    });
    var Value = "profile";
    var PHPfiles = "Welcome.php";
    data = {
        action : Value
    };
    $.post(PHPfiles, data, function(response){
        $("#navbar-profile").append(response);
    });
})


function input_filter() {
    document.getElementById("rangeValue").textContent = "Bac+" + document.getElementById("rangeInput").value;
}

//-- ----------------------DEBUT JS SCRIPT STEPHAN BUBULLE-------------------------- 

function toggle_wishlist(){
    document.querySelector(".unselected-wishlist-logo-picture").classList.toggle('remove-wishlist-picture');
    document.querySelector(".selected-wishlist-logo-picture").classList.toggle('is-selected');
}
function toggle_bubulle(){
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
function do_add_file(){
    document.getElementById('file-input').click();
}

function del_file(id){
    document.getElementById(id).classList.add('file-hidden');
    document.getElementById(id).id += "-hidden"
    //suprimer dans le serveur
}

function open_file(name){
    window.open(name);
}

function add_file(){
    var file = document.getElementById('file-input').files[0];
    if (file.type === "application/pdf"){
        const name = file.name.replace(/ /g, '_'); //regex le g signifie : cherche plusieurs fois
        if (document.getElementById(name) == null){
            var txt = "\n";
            txt += '<div class="postulation-docs" id="'+name+'">';
            txt += '<p onclick="open_file(\'../../Assets/image/cesi-logo.png\')">'+name+'</p>';
            txt += '<img src="../../Assets/Icones/poubelle-de-recyclage.png" onclick="del_file(\''+name+'\');"/>';
            txt += '</div>';
            document.querySelector(".postulation-list_docs").innerHTML += txt;
            console.log('fichier sélectionné:', file);
            console.log(txt);
            //send_file(file);
        } else {
            console.log("Fichier deja existant");
            alert("Vous avez dejà un fichier avec ce nom.\nChanger votre fichier de nom ou supprimer l'ancien.");
        }
    }
    else if (file) {
        console.log('type de fichier non accepte:', file.type);
        alert("Seul le type de fichier .pdf est accepté");
    }
    else {
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


// test pour le filtre

function add_filter_block(event=Event, idInput){//ids est un tableau
    var input = document.getElementById(idInput);
    var ids = JSON.parse(event.currentTarget.dataset.array);

    if (input.value !== "" && (event.key === 'Enter' || event.type == PointerEvent)){
        for (var id in ids){
            var li = document.getElementById(ids[id]);
            if (li.hidden){
                var txt = document.querySelector('#'+ids[id]+' > p');
                txt.textContent = input.value;
                input.value = '';
                li.removeAttribute("hidden");
                console.log("recherche du filtre: '"+txt.textContent+"' dans "+idInput);
                break;
            }
        }
    }
}
function del_filter_block(event=Event){
    event.currentTarget.hidden = true;
}


//diff entre currentTarget et target : currentTarget est la div ayant l'event alors que le target est la div qui est actuellement clique/survole/...
