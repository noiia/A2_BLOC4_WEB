<?php
function check_role(){
    $role =3;
    switch ($role) {
        case 3 : 
            echo '<div class="left_container" id="left_array">
            <p>Admin</p>
            <ul>
                <li><a href="../Profile/Profile.html.twig">Mon profil</a></li>
                <li><a href="../Students/Students.html">Etudiants</a></li>
                <li><a id="actual_page">Pilotes</a></li>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/Company/Company.html">Entreprises</a></li>
                <li><a href="../Internship/Internship.html">Stages</a></li>
                <li><a href="../WishList/WishList.html">WishList</a></li>
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