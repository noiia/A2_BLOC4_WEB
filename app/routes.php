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
        $group->patch('Wishlist/delete/{id}', [WishlistController::class, 'deleteInternshipFromWishlist']);

        $group->get('Activities', [\App\Controller\ActivitiesController::class, 'Activities']);

        $group->get('Postulation', [\App\Controller\PostulationController::class, 'Postulation']);

        $group->get('InternshipManagement', [\App\Controller\InternshipManagementController::class, 'InternshipManagement']);
        $group->get('InternshipManagement/api/{id}', [\App\Controller\InternshipManagementController::class, 'InternshipManagementApi']);
        $group->post('InternshipManagement/add', [\App\Controller\InternshipManagementController::class, 'addInternshipManagement']);
        $group->patch('InternshipManagement/delete/{id}', [\App\Controller\InternshipManagementController::class, 'delInternshipManagement']);
        $group->patch('InternshipManagement/edit', [\App\Controller\InternshipManagementController::class, 'updateInternshipManagement']);

        $group->get('Edition/Etudiants', [\App\Controller\StudentsController::class, 'Students']);
        $group->get('Edition/Etudiants/api/{id}', [\App\Controller\StudentsController::class, 'StudentsApi']);
        $group->post('Edition/Etudiants/add', [\App\Controller\StudentsController::class, 'addStudents']);
        $group->post('Edition/Etudiants/addPicture', [\App\Controller\StudentsController::class, 'uploadPicture']);
        $group->patch('Edition/Etudiants/edit', [\App\Controller\StudentsController::class, 'updateStudents']);
        $group->patch('Edition/Etudiants/delete/{id}', [\App\Controller\StudentsController::class, 'delStudents']);
        $group->get('Edition/Etudiants/location/{id}', [\App\Controller\StudentsController::class, 'locatePromotion']);

    })->add($authMiddleware);
};