<?php
function check_role()
{
    $role = 3;
    switch ($role) {
        case 1:
            echo '<div class="left_container" id="left_array">
            <p>Etudiants</p>
            <ul>
                <li><a id="actual_page">Mon profil</a></li>
                <li><a href="../WishList/WishList.html">WishList</a></li>
                <li><a href="../Postulation/Postulation.html">Mes postulations</a></li>
            </ul>
        </div>';
            break;
        case 2 :
            echo ' <div class="left_container" id="left_array">
            <p>Pilote</p>
            <ul>
                <li><a id="actual_page">Mon profil</a></li>
                <li><a href="../Students/Students.html.twig">Mes étudiants</a></li>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/CompanyManagement/CompanyManagement.html">Mes entreprises</a></li>
                <li><a href="../Internship/Internship.html">Mes stages</a></li>
            </ul>
        </div>';
            break;
        case 3 :
            echo '<div class="left_container" id="left_array">
            <p>Admin</p>
            <ul>
                <li><a id="actual_page">Mon profil</a></li>
                <li><a href="../Students/Students.html.twig">Etudiants</a></li>
                <li><a href="../Pilote/Pilote.html">Pilotes</a></li>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/CompanyManagement/CompanyManagement.html">Company</a></li>
                <li><a href="../Internship/Internship.html">Stages</a></li>
                <li><a href="../WishList/WishList.html">WishList</a></li>
            </ul>
        </div>';
            break;
        default :
            echo '';
    }
}

if ($_POST['action'] == 'role') {
    check_role();
}


?>