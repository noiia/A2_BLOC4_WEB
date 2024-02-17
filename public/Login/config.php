<?php
session_start();

$id_session = session_id();

$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
if (!empty($username) && !empty($password)) {
    echo "success ; username:" . $username . " password:" . $password . "<br>";
    $server_name = "127.0.0.1";
    $user = "root";
    $BDD_password = "CESI_A2_B4";
    $BDD_name = "Inter_net_BDD";
    $server_port = "3310";
    echo "server_name:" . $server_name . "<br>";
    $con = mysqli_connect($server_name, $user, $BDD_password, $BDD_name, $server_port);

    if (!$con) {
        echo "err con";
        die("Connection failed: " . mysqli_connect_error());
    }
    $req = mysqli_query($con, "SELECT * FROM Users WHERE Login = '$username' AND Password = '$password'");
    if (!$req) {
        echo "err req";
        die("Query failed: " . mysqli_error($con));
    }
    $num_ligne = mysqli_num_rows($req);
    if ($num_ligne > 0) {
        header("Location: ../../Welcome/Welcome.php");
    } else {
        echo "Adresse mail ou mot de passe incorrect";
    }
} else {
    echo "error";
}
?>