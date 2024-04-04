<?php
function check_role(){
    $role =2;
    switch ($role) {
        case 2 :
            echo ' <div class="left_container" id="left_array">
            <p>Pilote</p>
            <ul>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/Profile/Profile.html">Mon profil</a></li>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/Students/Students.html">Mes étudiants</a></li>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/CompanyManagement/CompanyManagement.html">Mes entreprises</a></li>
                <li><a id="actual_page">Mes stages</a></li>
            </ul>
        </div>';
        break;
        case 3 : 
            echo '<div class="left_container" id="left_array">
            <p>Admin</p>
            <ul>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/Profile/Profile.html">Mon profil</a></li>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/Students/Students.html">Etudiants</a></li>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/Pilote/Pilote.html">Pilotes</a></li>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/CompanyManagement/CompanyManagement.html">Company</a></li>
                <li><a id="actual_page">Stages</a></li>
                <li><a href="../../../inter-net-slim/inter-net-slim-2/templates/WishList/WishList.html">WishList</a></li>
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