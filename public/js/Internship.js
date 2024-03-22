function toggle_search(){
    document.querySelector(".search_list-internships").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_internship").classList.toggle('mobile-search_menu-profile');
}

var current_student = null;
function toggle_valid(id){
    current_student = id;
    document.querySelector(".valid_bg").classList.toggle('active-del_block');
}
function valid_current_student(){
    document.getElementById(current_student).classList.remove('black_check');
    console.log(current_student+" à été recruté");
    //ajouter dans la bdd
    //envoie du mail
    toggle_valid(current_student);
    document.getElementById(current_student).onclick = function(){toggle_end(current_student)};
}

function toggle_end(id){
    current_student = id;
    document.querySelector(".end_bg").classList.toggle('active-del_block');
}
function end_current_student(){
    var radio = document.querySelector('input[name=end_radio]:checked');
    if (radio !== null){
        document.getElementById(current_student).classList.add('black_check');
        console.log(current_student+" à été enlevé d'un stage pour raison: "+radio.value);
        //ajouter dans la bdd
        //envoie du mail
        $('input[name=end_radio]:checked').prop('checked', false);
        toggle_end(current_student);
        document.getElementById(current_student).onclick = function(){toggle_valid(current_student)};
    } else {
        alert("Veuillez sélectionné une valeur avant de valider");
    }
}

function valid_comboBox_internship(isCompany = false) {
    // Récupérer la valeur de l'input
    var inputValue1 = document.getElementById('select-option1').value;
    // Récupérer les options disponibles
    var options1 = document.getElementById('option1').options;
    // Vérifier si la valeur saisie est une des options

    isValid = false;

    for (var i = 0; i < options1.length; i++) {
        if (options1[i].value === inputValue1) {
            validerFormulaire(isCompany);
            isValid = true;
            break;
        }
    }

    if (!isValid) {
        alert('Veuillez sélectionner une option de la liste.');
    }
}