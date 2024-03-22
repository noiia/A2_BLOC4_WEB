$(document).ready(function(){
    var Value = "role";
    var PHPfiles = "FicheEtudiant.php";
    data = {
        action : Value
    };
    $.post(PHPfiles, data, function(response){
        $(".main_left").append(response);
    })
})