$(document).ready(function () {
    var Value = "role";
    var PHPfiles = "Activities.php";
    data = {
        action: Value
    };
    $.post(PHPfiles, data, function (response) {
        $(".main_left").append(response);
    })
})


const elements = document.querySelectorAll('.container-skills li');

// Parcourez chaque élément
elements.forEach(element => {
    // Vérifiez si le texte dépasse du conteneur
    if (element.offsetWidth < element.scrollWidth) {
        // Ajoutez une classe pour identifier ces éléments
        element.classList.add('has-overflow');

        // Ajoutez un gestionnaire d'événements pour ajouter et supprimer la classe de survol
        element.addEventListener('mouseenter', () => {
            element.classList.add('hover-effect');
        });

        element.addEventListener('mouseleave', () => {
            element.classList.remove('hover-effect');
        });
    }
});