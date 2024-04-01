<?php
function check_role(){
    $role = 3;
    switch ($role) {
        case 1:
            echo '<div class="left_container" id="left_array">
            <p>Etudiants</p>
            <ul>
                <li><a href="../Profile/Profile.html.twig">Mon profil</a></li>
                <li><a id="actual_page" >WishList</a></li>
                <li><a href="../Postulation/Postulation.html.twig">Mes postulations</a></li>
            </ul>
        </div>';
        break;
        case 3 : 
            echo '<div class="left_container" id="left_array">
            <p>Admin</p>
            <ul>
                <li><a href="../Profile/Profile.html.twig">Mon profil</a></li>
                <li><a href="../Students/Students.html.twig">Etudiants</a></li>
                <li><a href="../Pilote/Pilote.html.twig">Pilotes</a></li>
                <li><a href="../Company/Company.html.twig">Entreprises</a></li>
                <li><a href="../Internship/Internship.html.twig">Stages</a></li>
                <li><a id="actual_page">WishList</a></li>
            </ul>
        </div>';
        break;
        default :
        echo '';
    }
}

if ($_POST['action'] == 'role')
{
    check_role();
}



?>