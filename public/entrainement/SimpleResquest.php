<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// récupère l'URL globale
$request = Request::createFromGlobals();
// récupère la valeur de la clef name dans l'url
$name = $request->get('name');
$response = new Response();

$response->setContent('<html><body>Hello '.$name.'</body></html>');
// renvoie un code 200
$response->setStatusCode(Response::HTTP_OK);
// renvoie une valeur en header de type html
$response->headers->set('Content-type', 'text/html');

// renvoie une réponse valide
$response->send();