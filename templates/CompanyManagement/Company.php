<?php
function check_role(){
    $role =2;
    switch ($role) {
        case 2 :
            echo ' <div class="left_container" id="left_array">
            <p>Pilote</p>
            <ul>
                <li><a href="../Profile/Profile.html.twig">Mon profil</a></li>
                <li><a href="../Students/Students.html.twig">Mes étudiants</a></li>
                <li><a id="actual_page">Mes entreprises</a></li>
                <li><a href="../Internship/Internship.html.twig">Mes stages</a></li>
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
                <li><a id="actual_page">Company</a></li>
                <li><a href="../Internship/Internship.html.twig">Mes stages</a></li>
                <li><a href="../Wishlist/Wishlist.html.twig">WishList</a></li>
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