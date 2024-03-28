<?php

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use RKA\Session;

$loggedInMiddleware = function (Request $request, $handler): ResponseInterface {
    $session = new Session();
    if (!isset($session->user)) {
        $response = new Response();
        return $response->withHeader('Location', '/Login')->withStatus(302);
    }
    $request = $request->withAttribute("user", $session->user);
    return $handler->handle($request);
};
return $loggedInMiddleware;
