<?php
function send_mail(){
    $to = "mathice.leonie@viacesi.fr";
    $to_student = "mathice.leonie91@gmail.com";
    $subject = "Postulation à l'offre de stage ...";
    if ($_POST["motivation_letter"]!="") {$message = $_POST["motivation_letter"];}
    else {$message = "Un étudiant a postulé à votre offre de stage!!!";}
    $message = wordwrap($message,70,"\n");
    $headers = "FROM: "+$to_student."\r\n".'X-Mailer: PHP/' . phpversion();
    
    $send = mail($to, $subject, $message, $headers);

    if ($send==true) {$message_student = "Votre candidature a bien été envoyé";}
    else {$message_student = "Votre candidature n'a pas été envoyé voici son mail: "+$to;}

    mail($to_student, $subject, $message_student);
}

if ($_POST['action'] == 'postulation') {
    send_mail();
}
?>