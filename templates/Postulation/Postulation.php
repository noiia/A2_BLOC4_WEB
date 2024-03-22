<?php
function check_role(){
    $role =1;
    switch ($role) {
        case 1:
            echo '<div class="left_container" id="left_array">
            <p>Etudiants</p>
            <ul>
                <li><a href="../Profile/Profile.html">Mon profil</a></li>
                <li><a href="../WishList/WishList.html">WishList</a></li>
                <li><a id="actual_page">Mes postulations</a></li>
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