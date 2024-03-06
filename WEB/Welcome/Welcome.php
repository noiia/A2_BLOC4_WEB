<?php
function send_mail(){
    $to = "mathice.leonie@viacesi.fr";
    $to_student = "mathice.leonie91@gmail.com";
    $subject = "Postulation à l'offre de stage *Commercial H/F* de **Orange**";
    if ($_POST["motivation_letter"]!="") {$message = $_POST["motivation_letter"];}
    else {$message = "Un étudiant a postulé à votre offre de stage!!!";}
    $message = wordwrap($message,70,"\n");
    $headers = "FROM: ".$to_student."\r\n".'X-Mailer: PHP/' . phpversion();
    
    $send = mail($to, $subject, $message, $headers);

    if ($send==true) {$message_student = "Votre candidature a bien été envoyé";}
    else {$message_student = "Votre candidature n'a pas été envoyé voici son mail: ".$to;}

    mail($to_student, $subject, $message_student);
}

function links_profile(){
    $username = "Moi";//$_POST['username'];
    $ProfilValue = "";
    $ProfilLink = "";

    if ($username != "") {
        $ProfilValue = $username;
    } else {
        $ProfilLink = 'href="../Login/login.php"';
        $ProfilValue = "Profil";
    }

    echo "<a ".$ProfilLink.">
            <span aria-hidden='true'>
                ".$ProfilValue."
            </span>
        </a>";
}

if ($_POST['action'] == 'postulation') {
    send_mail();
}
elseif ($_POST['action'] == 'profile'){
    links_profile();
}
?>