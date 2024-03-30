<?php

namespace App\Application\Middleware;

global $app;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

$loggedInMiddleware = function (Request $request, $handler): ResponseInterface {
    $session = new \RKA\Session();
    if (!isset($session->user)) {
        $response = new Response();
        return $response->withHeader('Location', '/Login')->withStatus(302);
    }
    $request = $request->withAttribute("user", $session->user);

    /*
    global $response;
    $routeContext = RouteContext::fromRequest($request);
    $route = $routeContext->getRoute();

    if (empty($route)) {
        throw new HttpNotFoundException($request, $response);
    }

    $routeName = $route->getName();

    $publicRoutesArray = array('Login');

    if (empty($_SESSION['user']) && (!in_array($routeName, $publicRoutesArray))) {
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('root');
        $response = new Response();

        return $response->withHeader('Location', $url)->withStatus(302);
    } else {
        $response = $handler->handle($request);
        return $response;
    }
    */
    return $handler->handle($request);
};
return $loggedInMiddleware;

