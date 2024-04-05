<?php

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use RKA\Session;

$wishlist = function (Request $request, $handler): ResponseInterface {
    $session = $request->getAttribute("user");
    if ($session->getRole() !== 2) {
        return $handler->handle($request);
    } else {
        $response = new Response();
        return $response->withHeader('Location', '/')->withStatus(403);
    }
};
return $wishlist;