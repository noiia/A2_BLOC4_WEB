<?php

declare(strict_types=1);

use App\Controller\CompanyController;
use App\Controller\CompanyStatsController;
use App\Controller\InternshipController;
use App\Controller\InternshipStatsController;
use App\Controller\LoginController;
use App\Controller\WishlistController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use RKA\Session;
use Slim\App;
use Slim\Routing\RouteContext;

$authMiddleware = require_once __DIR__ . '/../src/Application/Middleware/AuthMiddleware.php';

return function (App $app) {
    global $authMiddleware;

    $app->addBodyParsingMiddleware();
    $app->add(function (Request $request, RequestHandlerInterface $handler): Response {
        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

        $response = $handler->handle($request);

        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
        $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
        $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);
        $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

        return $response;
    });
    $app->addRoutingMiddleware();

    $app->get('/Login', [LoginController::class, 'Login']);
    $app->post('/Login/Auth', [LoginController::class, 'testLogins']);

    $app->group('/', function ($group) {
        $group->get('disconnect', function ($request, $response) {
            Session::destroy();
            return $response->withHeader('Location', '/Login')->withStatus(302);
        });
        $group->get('Stage', [InternshipController::class, 'Welcome']);
        $group->get('Stage/{id}', [InternshipController::class, 'InternshipApi']);

        $group->get('Entreprise', [CompanyController::class, 'Company']);
        $group->get('Entreprise/api/{id}', [CompanyController::class, 'CompanyApi']);
        $group->post('Entreprise/addComment', [CompanyController::class, 'addComment']);

        $group->get('StatistiquesEntreprises', [CompanyStatsController::class, 'CompanyStats']);
        $group->get('StatistiquesStages', [InternshipStatsController::class, 'InternshipStats']);

        $group->get('Edition', [CompanyStatsController::class, 'CompanyStats']);
        $group->get('Wishlist', [WishlistController::class, 'Wishlist']);
        $group->post('Wishlist/add/{id}', [WishlistController::class, 'addInternshipToWishlist']);
        $group->patch('Wishlist/delete/{id}', [WishlistController::class, 'deleteInternshipFromWishlist']);

    })->add($authMiddleware);
};
