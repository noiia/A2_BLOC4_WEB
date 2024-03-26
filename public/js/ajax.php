<?php
// Autoriser les requêtes depuis n'importe quelle origine
header("Access-Control-Allow-Origin: *");
// Autoriser les méthodes HTTP spécifiques
header("Access-Control-Allow-Methods: POST");
// Autoriser certains en-têtes HTTP
header("Access-Control-Allow-Headers: Content-Type");
// Définir le type de contenu de la réponse
header("Content-Type: application/json");

const HTTP_OK = 200;
const HTTP_BAD_REQUEST = 400;
const HTTP_METHOD_NOT_ALLOWED = 405;
var_dump($_SERVER['REQUEST_METHOD']);
// Vérifier la méthode de requête
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement de la requête POST
    // Exemple : récupération des données POST
    $json_data = json_decode(file_get_contents('php://input'), true);

    // Exemple : renvoyer une réponse JSON
    echo json_encode(['success' => true]);
} else {
    // Si la méthode de requête n'est pas POST, renvoyer une erreur
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}


if (isset($_SERVER['HTTP_X-REQUESTED-WITH']) && strtoupper($_SERVER['HTTP_X-REQUESTED-WITH']) == 'XMLHTTREQUEST')
{
    $response_code = HTTP_BAD_REQUEST;
    $message = "il manque le param ACTION";
    if($_POST['postCommentCompany']){
        echo "ok super";
        $response_code = HTTP_OK;
        $message = "tout fonctionne";
    }
    response($response_code, $message);
} else {
    $response_code = HTTP_METHOD_NOT_ALLOWED;
    $message = "il manque le param ACTION";
    response($response_code, $message);
}
function response($response_code, $message){
    header('Content-Type: application/json');
    http_response_code($response_code);

    $message = [
        "response_code" => $response_code,
        "message" => $message
    ];
    echo json_encode($message);
}