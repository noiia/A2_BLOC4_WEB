<?php

declare(strict_types=1);

use App\Controller\CompanyController;
use App\Controller\CompanyStatsController;
use App\Controller\InternshipController;
use App\Controller\InternshipManagementController;
use App\Controller\InternshipStatsController;
use App\Controller\LocationController;
use App\Controller\LoginController;
use App\Controller\ProfileController;
use App\Controller\StudentsController;
use App\Controller\WishlistController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use RKA\Session;
use Slim\App;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/../src/Controller/InternshipController.php";

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Twig($loader);
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
        $group->get('Stage/Filtre/{arg}', [InternshipController::class, 'InternshipFilterApi']);

        $group->get('Entreprise', [CompanyController::class, 'Company']);
        $group->get('Entreprise/api/{id}', [CompanyController::class, 'CompanyApi']);
        $group->get('Entreprise/Filtre/{arg}', [CompanyController::class, 'CompanyFilterApi']);
        $group->post('Entreprise/addComment', [CompanyController::class, 'addComment']);

        $group->get('StatistiquesEntreprises', [CompanyStatsController::class, 'CompanyStats']);
        $group->get('StatistiquesEntreprises/Filtre/{arg}', [CompanyStatsController::class, 'CompanyStatsFilterApi']);
        $group->get('StatistiquesEntreprises/api/{arg}', [CompanyStatsController::class, 'CompanyStatsApi']);

        $group->get('StatistiquesStages', [InternshipStatsController::class, 'InternshipStats']);
        $group->get('StatistiquesStages/Filtre/{arg}', [InternshipStatsController::class, 'InternshipStatsFilterApi']);
        $group->get('StatistiquesStages/api/{arg}', [InternshipStatsController::class, 'InternshipStatsApi']);

        $group->get('Edition/MonProfil', [ProfileController::class, 'Profil']);

        $group->get('Edition/Etudiants', [StudentsController::class, 'Students']);
        $group->get('Edition/Etudiants/api/{id}', [StudentsController::class, 'StudentsApi']);
        $group->post('Edition/Etudiants/add', [StudentsController::class, 'addStudents']);
        $group->post('Edition/Etudiants/addPicture', [StudentsController::class, 'uploadPicture']);
        $group->patch('Edition/Etudiants/edit', [StudentsController::class, 'updateStudents']);
        $group->patch('Edition/Etudiants/delete/{id}', [StudentsController::class, 'delStudents']);
        $group->get('Edition/Etudiants/location/{id}', [StudentsController::class, 'locatePromotion']);

        $group->get('Edition/Entreprises', [CompanyController::class, 'CompanyManagement']);
        $group->get('Edition/Entreprises/mini-api', [CompanyController::class, 'miniCompanyManagementApi']);
        $group->get('Edition/Entreprises/api/{id}', [CompanyController::class, 'CompanyManagementApi']);
        $group->post('Edition/Entreprises/add', [CompanyController::class, 'addCompany']);
        $group->patch('Edition/Entreprises/delete/{id}', [CompanyController::class, 'delCompany']);

        $group->post('Edition/Location/add', [LocationController::class, 'addLocation']);
        $group->get('Edition/Location/api/{id}', [LocationController::class, 'apiLocation']);


        $group->get('Edition/Stages', [InternshipManagementController::class, 'InternshipManagement']);

        $group->get('Edition/Pilotes', [WishlistController::class, 'Wishlist']);

        $group->get('Wishlist', [WishlistController::class, 'Wishlist']);
        $group->post('Wishlist/add/{id}', [WishlistController::class, 'addInternshipToWishlist']);
        $group->patch('Wishlist/delete/{id}', [WishlistController::class, 'deleteInternshipFromWishlist']);

    })->add($authMiddleware);
};
