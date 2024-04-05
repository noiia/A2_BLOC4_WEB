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
use App\Controller\SkillsController;
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
$piloteMiddleware = require_once __DIR__ . '/../src/Application/Middleware/PiloteMiddleware.php';
$adminMiddleware = require_once __DIR__ . '/../src/Application/Middleware/AdminMiddleware.php';
$wishlistMiddleware = require_once __DIR__ . '/../src/Application/Middleware/WishlistMiddleware.php';

return function (App $app) {
    global $authMiddleware;
    global $piloteMiddleware;
    global $adminMiddleware;
    global $wishlistMiddleware;

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

    $app->group('/', function ($group) use ($piloteMiddleware, $wishlistMiddleware) {
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

        $group->group('', function ($wishlist) {
            $wishlist->get('Wishlist', [WishlistController::class, 'Wishlist']);
            $wishlist->post('Wishlist/add/{id}', [WishlistController::class, 'addInternshipToWishlist']);
            $wishlist->patch('Wishlist/delete/{id}', [WishlistController::class, 'deleteInternshipFromWishlist']);
        })->add($wishlistMiddleware);

        $group->group('', function ($pilote) {
            $pilote->get('Edition/Etudiants', [StudentsController::class, 'Students']);
            $pilote->get('Edition/Etudiants/api/{id}', [StudentsController::class, 'StudentsApi']);
            $pilote->post('Edition/Etudiants/add', [StudentsController::class, 'addStudents']);
            $pilote->post('Edition/Etudiants/addPicture', [StudentsController::class, 'uploadPicture']);
            $pilote->patch('Edition/Etudiants/edit', [StudentsController::class, 'updateStudents']);
            $pilote->patch('Edition/Etudiants/delete/{id}', [StudentsController::class, 'delStudents']);
            $pilote->get('Edition/Etudiants/location/{id}', [StudentsController::class, 'locatePromotion']);
            $pilote->get('Edition/Entreprises', [CompanyController::class, 'CompanyManagement']);
            $pilote->get('Edition/Entreprises/mini-api', [CompanyController::class, 'miniCompanyManagementApi']);
            $pilote->get('Edition/Entreprises/api/{id}', [CompanyController::class, 'CompanyManagementApi']);
            $pilote->get('Edition/Entreprises/reverseApi/{args}', [CompanyController::class, 'reverseApiCompany']);
            $pilote->post('Edition/Entreprises/add', [CompanyController::class, 'addCompany']);
            $pilote->patch('Edition/Entreprises/delete/{id}', [CompanyController::class, 'delCompany']);
            $pilote->post('Edition/Location/add', [LocationController::class, 'addLocation']);
            $pilote->get('Edition/Location/api/{id}', [LocationController::class, 'apiLocation']);
            $pilote->get('Edition/Location/reverseApi/{args}', [LocationController::class, 'reverseApiLocation']);
            $pilote->post('Edition/Competence/add', [SkillsController::class, 'addSkill']);
            $pilote->get('Edition/Competence/api/{id}', [SkillsController::class, 'apiSkill']);
            $pilote->patch('Edition/Competence/del', [SkillsController::class, 'delSkill']);
            $pilote->get('Edition/Stages', [InternshipManagementController::class, 'InternshipManagement']);
            $pilote->post('Edition/Stages/add', [InternshipController::class, 'addInternship']);
            $pilote->get('Edition/Pilotes', [WishlistController::class, 'Wishlist']);
        })->add($piloteMiddleware);
    })->add($authMiddleware);
};
