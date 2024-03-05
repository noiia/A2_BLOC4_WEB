<?php
function check_role(){
    $role =3;
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
                <li><a href="../Students/Students.html">Mes étudiants</a></li>
                <li><a href="../Company/Company.html">Mes entreprises</a></li>
                <li><a href="../Internship/Internship.html">Mes stages</a></li>
            </ul>
        </div>';
        break;
        case 3 : 
            echo '<div class="left_container" id="left_array">
            <p>Admin</p>
            <ul>
                <li><a id="actual_page">Mon profil</a></li>
                <li><a href="../Students/Students.html">Etudiants</a></li>
                <li><a href="../Pilote/Pilote.html">Pilotes</a></li>
                <li><a href="../Company/Company.html">Entreprises</a></li>
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



?>