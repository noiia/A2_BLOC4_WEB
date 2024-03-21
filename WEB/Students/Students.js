$(document).ready(function(){
    var Value = "role";
    var PHPfiles = "Students.php";
    data = {
        action : Value
    };
    $.post(PHPfiles, data, function(response){
        $(".main_left").append(response);
    })
})

function toggle_search(){
    document.querySelector(".search_list-students").classList.toggle('mobile-search_menu-menu');
    document.querySelector(".profile_student").classList.toggle('mobile-search_menu-profile');
}

var input = document.getElementById('select-promotions');

// ------------ vérifier promotion
function valid_promotion () {
    input.addEventListener('input', function() {
        // Vérifier si la valeur saisie est une des options
        var options = document.getElementById('promotions').options;
        var isValid = false;
        for (var i = 0; i < options.length; i++) {
            if (options[i].value.startsWith(input.value)) {
                isValid = true;
                break;
            }
        }
        // Appliquer la validité au champ
        if (isValid === false) {
            alert('Veuillez sélectionner une option de la liste.');
        }
    });
}