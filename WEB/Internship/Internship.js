function toggle_search(){
    document.querySelector(".search_list-companies").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_company").classList.toggle('mobile-search_menu-profile');
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