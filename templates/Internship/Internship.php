<?php
function check_role(){
    $role =2;
    switch ($role) {
        case 2 :
            echo ' <div class="left_container" id="left_array">
            <p>Pilote</p>
            <ul>
                <li><a href="templates/Profile/Profile.html.twig">Mon profil</a></li>
                <li><a href="templates/Students/Students.html.twig">Mes étudiants</a></li>
                <li><a href="templates/CompanyManagement/CompanyManagement.html.twig">Mes entreprises</a></li>
                <li><a id="actual_page">Mes stages</a></li>
            </ul>
        </div>';
        break;
        case 3 : 
            echo '<div class="left_container" id="left_array">
            <p>Admin</p>
            <ul>
                <li><a href="templates/Profile/Profile.html.twig">Mon profil</a></li>
                <li><a href="templates/Students/Students.html.twig">Etudiants</a></li>
                <li><a href="templates/Pilote/Pilote.html.twig">Pilotes</a></li>
                <li><a href="templates/CompanyManagement/CompanyManagement.html.twig">Company</a></li>
                <li><a id="actual_page">Stages</a></li>
                <li><a href="templates/Wishlist/Wishlist.html.twig">WishList</a></li>
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